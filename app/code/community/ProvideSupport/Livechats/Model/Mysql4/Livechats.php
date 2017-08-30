<?php
class ProvideSupport_livechats_Model_Mysql4_livechats extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('livechats/livechats', 'id');
    }
}
