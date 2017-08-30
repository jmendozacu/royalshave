<?php
class Devinc_Dailydeal_Block_List_Sidedeals extends Mage_Catalog_Block_Product_Abstract
{	    
	const STATUS_RUNNING = Devinc_Dailydeal_Model_Source_Status::STATUS_RUNNING;
	const STATUS_DISABLED = Devinc_Dailydeal_Model_Source_Status::STATUS_DISABLED;
	const STATUS_ENDED = Devinc_Dailydeal_Model_Source_Status::STATUS_ENDED;
	const STATUS_QUEUED = Devinc_Dailydeal_Model_Source_Status::STATUS_QUEUED;
	
	//returns the product of the featured deal
    public function getFeaturedDeal() {   	
		if (Mage::getStoreConfig('dailydeal/featured_deal/enabled')) {
			$currentProduct = Mage::registry('product');		
			$currentProductId = (!isset($currentProduct)) ? 0: $currentProduct->getId();
			$excludeProductIds = array($currentProductId);
			
			$deal = Mage::helper('dailydeal')->getDeal($excludeProductIds);
			if ($deal) {
		    	$product = Mage::getModel('catalog/product')->load($deal->getProductId());				
    	    	$product->setDoNotUseCategoryId(true);			
    	    	$product->setDealQty($deal->getDealQty());
    	    
    	    	return $product;
    	    }
		}
		
		return false;		
    }
    
    public function getItems($loadRecent = false)
    {     	
    	$featuredDealProductId = ($product = $this->getFeaturedDeal()) ? $product->getId() : 0;
		$currentProduct = Mage::registry('product');		
		$currentProductId = (!isset($currentProduct)) ? 0: $currentProduct->getId();
		$excludeProductIds = array($currentProductId, $featuredDealProductId);
		
		//load active deal ids
		$dealCollection = Mage::getModel('dailydeal/dailydeal')->getCollection()->addFieldToFilter('status', array('eq'=>self::STATUS_RUNNING))->addFieldToFilter('product_id', array('nin'=>$excludeProductIds))->setOrder('position', 'ASC')->setOrder('dailydeal_id', 'DESC');	
		$dealIdsString = '';  
		$productIds = array(0);   
		
		if (count($dealCollection)) {    
			$dealIds = array();   
 			foreach ($dealCollection as $deal) {
 				if (Mage::helper('dailydeal')->runOnStore($deal) && !array_key_exists($deal->getProductId(), $dealIds)) {
 					$dealIds[$deal->getProductId()] = $deal->getId();
 					$productIds[] = $deal->getProductId();
 				}
        	}
        	
        	if (count($dealIds)) {
	        	$dealIdsString = implode(',', $dealIds);
	        } else {
		        $dealIdsString = 0;		        
	        }
        } 
        
        if ($dealIdsString!='') {
        	//load product collection
        	$resource = Mage::getSingleton('core/resource');
        	$collection = Mage::getResourceModel('catalog/product_collection')
     		    ->addAttributeToSelect('*')
     	    	->addAttributeToFilter('entity_id', array('in', $productIds))
        	    ->addStoreFilter()
            	->joinTable($resource->getTableName('dailydeal'),'product_id=entity_id', array('dailydeal_id' => 'dailydeal_id', 'position' => 'position', 'deal_qty' => 'deal_qty'), '{{table}}.dailydeal_id IN ('.$dealIdsString.')','left');
        	
        	//set collection order        
    		$collection->setOrder('position', 'ASC')->setOrder('dailydeal_id', 'DESC'); 	
			
        	Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        	Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
			
			foreach ($collection as $product) {
        	   	$product->setDoNotUseCategoryId(true);
        	}
        	 
        	return $collection;
        } else {
        	return array();
        }
    }

    //the "slim" parameter is used when calling the side deals block into a static block
	public function isSlimCountdown() {	
		if ($this->getSlim() && $this->getSlim()=='true') {	
			return ' dd-slim-countdown';
		} 

		return '';
	}

	public function getBlockId() {	
		$random = rand(10e16, 10e20);

		return 'dd-block-'.$random;
	}  
	
	//refresh the deal statuses
    public function updateDeals()
    {		
		//Mage::getModel('dailydeal/dailydeal')->refreshDeals();
	}
	
}