/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/

function amcustomerimg_position(blockId, containerClass)
{
    $$(containerClass).each(function(container){
        container.appendChild($(blockId));
        $(blockId).style.display = '';
    });
}