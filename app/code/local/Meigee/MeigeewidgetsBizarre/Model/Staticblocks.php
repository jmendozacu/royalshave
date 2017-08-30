<?php class Meigee_MeigeewidgetsBizarre_Model_Staticblocks
{
    public function toOptionArray()
    {
        return Mage::getModel('cms/block')->getCollection()->toOptionArray();
    }

}