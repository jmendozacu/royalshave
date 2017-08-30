<?php
class Devinc_Dailydeal_Block_Recent extends Devinc_Dailydeal_Block_List
{
	//add breadcrumbs
    protected function _prepareLayout()
    {
    	parent::_prepareLayout();
    	
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb('home', array(
                'label'=>Mage::helper('catalog')->__('Home'),
                'title'=>Mage::helper('catalog')->__('Go to Home Page'),
                'link'=>Mage::getBaseUrl()
            ));
            
			$breadcrumbsBlock->addCrumb('deals', array(
				'label'=>Mage::helper('dailydeal')->__('Past Deals'),
				'title'=>Mage::helper('dailydeal')->__('Past Deals'),)
			);
            
            if ($headBlock = $this->getLayout()->getBlock('head')) {
                $headBlock->setTitle(Mage::helper('dailydeal')->__('Past Deals'));
            }
        }
                
        return $this;
    }
    
    public function getLoadedProductCollection($loadRecent = true)
    { 
    	return parent::getLoadedProductCollection($loadRecent);
    }
    
}