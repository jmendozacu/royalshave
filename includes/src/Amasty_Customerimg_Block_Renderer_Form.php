<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Renderer_Form extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('amasty/amcustomerimg/renderer/form.phtml');
    }
    
    protected function _toHtml()
    {
        return parent::_toHtml();
    }
}