<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_MeigeewidgetsBizarre_Model_Templates
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'meigee/meigeewidgetsbizarre/grid.phtml', 'label'=>'Grid'),
			array('value'=>'meigee/meigeewidgetsbizarre/masonry_grid.phtml', 'label'=>'Masonry Grid'),
            array('value'=>'meigee/meigeewidgetsbizarre/list.phtml', 'label'=>'List'),
			array('value'=>'meigee/meigeewidgetsbizarre/footer_list.phtml', 'label'=>'Footer List'),
            array('value'=>'meigee/meigeewidgetsbizarre/slider.phtml', 'label'=>'Slider')
        );
    }

}