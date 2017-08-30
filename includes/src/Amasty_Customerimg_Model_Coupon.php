<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Model_Coupon
{
    public function checkShouldReward($approvedImage)
    {
        if (!Mage::getStoreConfig('amcustomerimg/coupon/send'))
        {
            return ;
        }
        
        $approvedCollection = $approvedImage->getCollection();
        if (0 == $approvedImage->getCustomerId()) {
            $approvedCollection->addFieldToFilter('guest_email', $approvedImage->getGuestEmail());
            if ("" == $approvedImage->getGuestEmail()){
                 return ;
            }
        }
        else {
            $approvedCollection->addFieldToFilter('customer_id', $approvedImage->getCustomerId()); 
        }
        $approvedCollection->addFieldToFilter('status', 'approved');
        $approvedCollection->addFieldToFilter('is_rewarded', 0);
        $approvedCollection->getSelect()->limit(Mage::getStoreConfig('amcustomerimg/coupon/approved_cnt'));
        
        if ($approvedCollection->getSize() >= Mage::getStoreConfig('amcustomerimg/coupon/approved_cnt'))
        {
            if (0 == $approvedImage->getCustomerId()){
                  Mage::register('amcustomerimg_coupon_store_id',$approvedImage->getStoreId());  
                  $this->sendRewardCoupon($approvedImage->getGuestEmail());
            }
            else {
                  $this->sendRewardCoupon($approvedImage->getCustomerId());
            }
            foreach ($approvedCollection as $image)
            {
                $image->setIsRewarded(1);
            }
            $approvedCollection->save();
        }
    }
    
    public function removeOldCoupons()
    {
        $days = intVal(Mage::getStoreConfig('amcustomerimg/coupon/remove_days'));
        if ($days <= 0)
            return;
            
        $rules = Mage::getResourceModel('salesrule/rule_collection')
            ->addFieldToFilter('name', array('like' => Mage::helper('amcustomerimg')->__('Customer Product Images Coupon For ') . '%'))
            ->addFieldToFilter('from_date', array('lt' => date('Y-m-d', strtotime("-$days days"))))
            ;
         
        $errors = '';       
        foreach ($rules as $rule){
            try {
                $rule->delete();
            } 
            catch (Exception $e) {
                $errors .= "\r\nError when deleting rule #" . $rule->getId() . ' : ' . $e->getMessage();    
            }
        }
        
        if ($errors)
        {
            throw new Exception($errors);
        }
    }
    
    public function sendRewardCoupon($customerId)
    {
        if (is_numeric($customerId)){
            $customer = Mage::getModel('customer/customer')->load($customerId);
            if (!$customer->getId())
            {
                return ;
            }
        }
        else{
            $customer = new Varien_Object();
            $customer->setFirstname( Mage::helper('amcustomerimg')->__('Customer'));
            $customer->setLastname('');
            $customer->setEmail($customerId);
            $customer->setName(Mage::helper('amcustomerimg')->__('Customer'));
            $customer->setStoreId(Mage::registry('amcustomerimg_coupon_store_id'));
        }
        $couponData = array();
        $couponData['name']      = Mage::helper('amcustomerimg')->__('Customer Product Images Coupon For ') . $customer->getFirstname() . ' ' . $customer->getLastname() . ' (' . date('Y-m-d') . ')';
        $couponData['is_active'] = 1;
        // all websites here:
        $couponData['website_ids'] =  array_keys(Mage::app()->getWebsites(true));
        
        $couponData['coupon_type'] = 2;  // for magento 1.4.1.1
        $couponData['coupon_code'] = strtoupper(uniqid()); 
        $maxUses = intval(Mage::getStoreConfig('amcustomerimg/coupon/coupon_uses'));
        $couponData['uses_per_coupon']   = $maxUses;
        $couponData['uses_per_customer'] = $maxUses;
        
        $couponData['from_date'] = ''; //current date

        $days = intval(Mage::getStoreConfig('amcustomerimg/coupon/coupon_days'));
        $date = date('Y-m-d', time() + $days * 24 * 3600);
        $couponData['to_date'] = $date;
        
        $couponData['simple_action']   = Mage::getStoreConfig('amcustomerimg/coupon/coupon_type');
        $couponData['discount_amount'] = Mage::getStoreConfig('amcustomerimg/coupon/coupon_amount');
        $couponData['conditions'] = array(
            1 => array(
                'type'       => 'salesrule/rule_condition_combine',
                'aggregator' => 'all',
                'value'      => 1,
                'new_child'  =>'', 
            )
        );
        
        $couponData['actions'] = array(
            1 => array(
                'type'       => 'salesrule/rule_condition_product_combine',
                'aggregator' => 'all',
                'value'      => 1,
                'new_child'  =>'', 
            )
        );

        //compatibility with aitoc's individual promo extension
        $couponData['customer_individ_ids'] = array();
        
        //create for all customer groups
        $couponData['customer_group_ids'] = array();
        $customerGroups = Mage::getResourceModel('customer/group_collection')
            ->load();

        $found = false;
        foreach ($customerGroups as $group) {
            if (0 == $group->getId()) {
                $found = true;
            }
            $couponData['customer_group_ids'][] = $group->getId();
        }
        if (!$found) {
            $couponData['customer_group_ids'][] = 0;
        }
        
        try { 
            Mage::getModel('salesrule/rule')
                ->loadPost($couponData)
                ->save();      
        } 
        catch (Exception $e){
            $couponData['coupon_code'] = '';   
        }
        
        if (!$couponData['coupon_code'])
        {
            return ;
        }
        
        $this->_sendCoupon($customer, $couponData);
    }
    
    protected function _sendCoupon($customer, $couponData)
    {
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        
        $store = Mage::app()->getStore($customer->getStoreId());
        $tpl = Mage::getModel('core/email_template');
        $tpl->setDesignConfig(array('area'=>'frontend', 'store'=>$store->getId()))
            ->sendTransactional(
                Mage::getStoreConfig('amcustomerimg/coupon/template', $store),
                Mage::getStoreConfig('amcustomerimg/coupon/identity', $store),
                $customer->getEmail(),
                $customer->getName(),
                array(
                    'website_name'  => $store->getWebsite()->getName(),
                    'group_name'    => $store->getGroup()->getName(),
                    'store_name'    => $store->getName(), 
                    'coupon'        => $couponData['coupon_code'], 
                    'coupon_days'   => Mage::getStoreConfig('amcustomerimg/coupon/coupon_days'), 
                    'customer_name' => $customer->getName(),
                )
        );
        
        $translate->setTranslateInline(true);
    }
}