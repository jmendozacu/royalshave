<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Model_Mysql4_Image extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('amcustomerimg/image', 'entity_id');
    }
}