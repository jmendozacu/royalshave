<?php
class Devinc_Dailydeal_Block_List extends Mage_Catalog_Block_Product_List
{
	const STATUS_RUNNING = Devinc_Dailydeal_Model_Source_Status::STATUS_RUNNING;
	const STATUS_DISABLED = Devinc_Dailydeal_Model_Source_Status::STATUS_DISABLED;
	const STATUS_ENDED = Devinc_Dailydeal_Model_Source_Status::STATUS_ENDED;
	const STATUS_QUEUED = Devinc_Dailydeal_Model_Source_Status::STATUS_QUEUED;
    protected $_dealsCollection;
	
    protected function _prepareLayout()
    {        
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb('home', array(
                'label'=>Mage::helper('catalog')->__('Home'),
                'title'=>Mage::helper('catalog')->__('Go to Home Page'),
                'link'=>Mage::getBaseUrl()
            ));
            
			$breadcrumbsBlock->addCrumb('deals',
			array('label'=>Mage::helper('dailydeal')->__('Active Deals'),
				'title'=>Mage::helper('dailydeal')->__('Active Deals'),)
			);
            
            if ($headBlock = $this->getLayout()->getBlock('head')) {
                $headBlock->setTitle(Mage::helper('dailydeal')->__('Active Deals'));
            }
        }
        
        return parent::_prepareLayout();
    }
    
    public function getLoadedProductCollection($loadRecent = false)
    { 
        if (!$this->_dealsCollection) {
        	$dealStatus = ($loadRecent) ? self::STATUS_ENDED : self::STATUS_RUNNING;    	
        	
        	//load active deal ids
    		$dealCollection = Mage::getModel('dailydeal/dailydeal')->getCollection()->addFieldToFilter('status', array('eq'=>$dealStatus))->setOrder('position', 'ASC')->setOrder('dailydeal_id', 'DESC');
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
            } else {
            	$dealIdsString = 0;
            }
            
            //load product collection + deals info
            $resource = Mage::getSingleton('core/resource');
            $collection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
         	    ->addAttributeToFilter('entity_id', array('in', $productIds))
                ->addAttributeToFilter('status', array('in'=>array(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)))
                ->addStoreFilter()
                ->joinTable($resource->getTableName('dailydeal'),'product_id=entity_id', array('dailydeal_id' => 'dailydeal_id', 'position' => 'position', 'deal_qty' => 'deal_qty', 'datetime_to' => 'datetime_to'), '{{table}}.dailydeal_id IN ('.$dealIdsString.')','left')
                ->setOrder('position', 'ASC')
                ->setOrder('dailydeal_id', 'DESC');

            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
		      
            $this->_dealsCollection = $collection;
        }
        return $this->_dealsCollection;
    }

    protected function _getProductCollection() {
        return $this->getLoadedProductCollection();
    }

    protected function _beforeToHtml()
    {
        $toolbar = $this->getToolbarBlock();
        $orders = $toolbar->getAvailableOrders();

        unset($orders['position']);
        $toolbar->setAvailableOrders($orders);

        return parent::_beforeToHtml();
    }
    
}