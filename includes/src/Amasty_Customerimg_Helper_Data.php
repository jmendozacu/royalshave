<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function showForm()
    {
        if (!Mage::getStoreConfig('amcustomerimg/general/guest_enabled')) {
	        if (!Mage::getSingleton('customer/session')->isLoggedIn() || !Mage::getStoreConfig('amcustomerimg/general/enabled') ) {
		        return '';
		    }
        }
        $block = Mage::app()->getLayout()->createBlock('amcustomerimg/form', 'amcustomerimg.form');
        if ($block)
        {
            return $block->toHtml();
        }
        return '';
    }
    
    public function showSlider()
    {
        $block = Mage::app()->getLayout()->createBlock('amcustomerimg/slider', 'amcustomerimg.slider');
        if ($block)
        {
            return $block->toHtml();
        }
        return '';
    }
    
    public function notifyAdmin($productId)
    {
        if (Mage::getStoreConfig('amcustomerimg/notification/send') && Mage::getStoreConfig('amcustomerimg/notification/to'))
        {
            $translate = Mage::getSingleton('core/translate');
            $translate->setTranslateInline(false);
            
            $store = Mage::app()->getStore();
            $tpl = Mage::getModel('core/email_template');
            $tpl->setDesignConfig(array('area'=>'frontend', 'store'=>$store->getId()))
                ->sendTransactional(
                    Mage::getStoreConfig('amcustomerimg/notification/template'),
                    Mage::getStoreConfig('amcustomerimg/notification/from'),
                    Mage::getStoreConfig('amcustomerimg/notification/to'),
                    $this->__('Administrator'),
                    array(
                        'website_name'  => $store->getWebsite()->getName(),
                        'group_name'    => $store->getGroup()->getName(),
                        'store_name'    => $store->getName(), 
                        'product_name'	=> Mage::getModel('catalog/product')->load($productId)->getName(),
                    )
            );
            
            $translate->setTranslateInline(true);
        }
    }
}