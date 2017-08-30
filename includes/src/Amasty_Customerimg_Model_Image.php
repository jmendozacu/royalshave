<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Model_Image extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
        $this->_init('amcustomerimg/image');
    }
    
    public function approve()
    {
        $this->setStatus('approved');
        $this->save();
        Mage::getModel('amcustomerimg/coupon')->checkShouldReward($this);
    }
    
    public function decline()
    {
        $this->setStatus('declined');
        $this->setShownInSeparate(0);
        $this->save();
    }
	
    public function delete()
    {
        $imageHelper = Mage::helper('amcustomerimg/image');
        $imageHelper->cleanupImage($this->getFile());

        parent::delete();
    }
}