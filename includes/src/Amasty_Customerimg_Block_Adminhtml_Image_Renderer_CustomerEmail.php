<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2012 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Adminhtml_Image_Renderer_Customeremail extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
       if (0 == $row->getCustomerId()){
           if ('' == $row->getGuestEmail()){
               $html = 'guest';
           }
           else {
               $html =$row->getGuestEmail();
           }
        }
        else{
            $html = $row->getCustomerEmail();
        }
        
        return $html;
    }
}