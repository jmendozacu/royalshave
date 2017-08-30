<?php
class Devinc_Dailydeal_Block_Dailydeal extends Mage_Core_Block_Template
{	        
	//returns the current product if it's a deal
    public function getDealProduct()
	{
		//Mage::getModel('dailydeal/dailydeal')->refreshDeals();
		$product = Mage::registry('product');		
		$deal = Mage::helper('dailydeal')->getDealByProduct($product);	
		if ($deal) {
			//increase deal number of views
			$nrViews = $deal->getNrViews();
			$nrViews++;
			$deal->setNrViews($nrViews)->save();
			
			$product->setDealQty($deal->getDealQty());			
			return $product;		
		} else {
			return false;
		}
	}
	
	//returns the product of the main deal
    public function getMainDealProduct() {  
		//Mage::getModel('dailydeal/dailydeal')->refreshDeals(); 
		$mainDeal = Mage::helper('dailydeal')->getDeal();
		
		if ($mainDeal) {
		    $product = Mage::getModel('catalog/product')->load($mainDeal->getProductId());				
    	    $product->setDoNotUseCategoryId(true);
		    return $product;
		} else {
			return false;
		}	
    }
	
	//to bypass Full Page Cache of Magento Enterprise
    public function getCacheKeyInfo()
	{
	    $info = parent::getCacheKeyInfo();
	    if (Mage::registry('product'))
	    {
	        $info['product_id'] = Mage::registry('product')->getId();
	    }
	    return $info;
	}
	
	//DEPRECATED
	//generates the countdowns that are displayed on product lists
	public function generateCountdownsHtml() {  
		$productIds = unserialize(Mage::getSingleton('customer/session')->getProductIds());
		$productStock = unserialize(Mage::getSingleton('customer/session')->getProductStock());
		$dealCollection = Mage::helper('dailydeal')->getDealsByProductIds($productIds);
		$html = '';

		foreach ($dealCollection as $deal) {				
			$toDate = $deal->getDatetimeTo();
			$finished = false;
			$currentDateTime = Mage::helper('dailydeal')->getCurrentDateTime(0);
			//set it to finished if the deal's time is up or product is out of stock
			if ($currentDateTime>=$deal->getDatetimeFrom() && $currentDateTime<=$deal->getDatetimeTo()) {
				$finished = ($productStock[$deal->getProductId()]) ? false : true;
			} else {
				Mage::getModel('dailydeal/dailydeal')->refreshDeal($deal);
				$finished = true;
			}
			$html .= '<div class="item-countdown-container" style="display:none;" id="countdown'.$deal->getProductId().'">';
			// $html .= '<b>'.$this->__('Time left to buy:').'</b>';
			$html .= Mage::helper('dailydeal')->getCountdown($toDate, $deal->getId(), $finished, array('width'=>'100%','height'=>'50px'));
			$html .= '</div>';
		}

		return $html;
	}
}