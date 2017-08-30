<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Adminhtml_Image_Renderer_Thumb extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $html = '<img src="' . Mage::helper('amcustomerimg/image')->getThumbUrl($row->getFile()) . '" style="padding: 4px 0px 0px 4px;" alt="" />';
        return $html;
    }
}