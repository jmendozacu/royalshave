<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Adminhtml_Image extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'amcustomerimg';
        $this->_controller = 'adminhtml';
        $this->_headerText = Mage::helper('amcustomerimg')->__('Customer Images List');
        $this->_removeButton('add');
    }

}