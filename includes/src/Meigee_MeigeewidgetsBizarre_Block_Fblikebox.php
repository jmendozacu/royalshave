<?php

class Meigee_MeigeewidgetsBizarre_Block_Fblikebox
extends Mage_Core_Block_Html_Link
implements Mage_Widget_Block_Interface
{
    protected function _construct() {
        parent::_construct();
    }
	protected function _toHtml() {
        return parent::_toHtml();  
    }

    public function getContentLikebox()
    {
		$fbcontent = 
        'data-width="300"'
        . 'data-height="' . $this->getData('height') . '"'
        . 'data-href="' . $this->getData('href') . '"'
        . 'data-colorscheme="' . $this->getData('colorscheme') . '"'
        .($this->getData('faces') ? 'data-show-faces="true"' : 'data-show-faces="false"')
        .($this->getData('header') ? 'data-header="true"' : 'data-header="false"')
        . 'data-stream="' . $this->getData('stream') . '"'
		.($this->getData('border') ? 'data-show-border="true"' : 'data-show-border="false"');
        return $fbcontent;
    }
}