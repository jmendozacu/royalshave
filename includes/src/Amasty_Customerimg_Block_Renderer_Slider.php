<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Renderer_Slider extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('amasty/amcustomerimg/renderer/slider.phtml');
    }
    
    protected function _toHtml()
    {
        return parent::_toHtml();
    }
}