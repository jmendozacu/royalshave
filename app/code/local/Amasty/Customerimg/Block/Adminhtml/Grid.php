<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Adminhtml_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('amcustomerimgGrid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
    }
    
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('amcustomerimg/image')->getCollection();
        
        $collection->addCustomerEmail();
        $collection->addProductName();
        $collection->addProductSku();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _prepareColumns()
    {
        parent::_prepareColumns();
        
        $this->addColumn('thumb',
            array(
                'header'    => Mage::helper('catalog')->__('Thumbnail'),
                'renderer'  => 'amcustomerimg/adminhtml_image_renderer_thumb',
                'sortable'  => false,
                'filter'    => false,
                'width'		=> Amasty_Customerimg_Helper_Image::THUMB_X + 20,
        ));
        
        $this->addColumn('title', array(
            'header'    => Mage::helper('amcustomerimg')->__('Image Title'),
            'index'     => 'title',
        ));
        
        $this->addColumn('product_name', array(
            'header'    => Mage::helper('amcustomerimg')->__('Product Name'),
            'index'     => 'value',
        ));
        
        $this->addColumn('product_sku', array(
            'header'    => Mage::helper('amcustomerimg')->__('Product SKU'),
            'index'     => 'sku',
        ));
       
        $this->addColumn('customer_email', array(
            'header'    => Mage::helper('amcustomerimg')->__('Customer E-mail'),
            'renderer'  => 'amcustomerimg/adminhtml_image_renderer_customerEmail',
            'index'     => 'customer_email',
            'filter'    => false,
        ));
        
        $this->addColumn('status', array(
            'header'    => Mage::helper('amcustomerimg')->__('Approval Status'),
            'sortable'  => true,
            'index'     => 'status',
            'type'      => 'options',
            'options' => array(
                'pending'  => Mage::helper('amcustomerimg')->__('Pending'),
                'approved' => Mage::helper('amcustomerimg')->__('Approved'),
                'declined' => Mage::helper('amcustomerimg')->__('Declined'),
            ),
            'align' => 'center',
        ));
        
        $this->addColumn('shown_in_product', array(
            'header'    => Mage::helper('amcustomerimg')->__('Added To Main Product Images'),
            'sortable'  => true,
            'index'     => 'shown_in_product',
            'type'      => 'options',
            'options' => array(
                '0' => Mage::helper('amcustomerimg')->__('No'),
                '1' => Mage::helper('amcustomerimg')->__('Yes'),
            ),
            'align' => 'center',
        ));
        
        $this->addColumn('shown_in_separate', array(
            'header'    => Mage::helper('amcustomerimg')->__('Shown In Customer Images'),
            'sortable'  => true,
            'index'     => 'shown_in_separate',
            'type'      => 'options',
            'options' => array(
                '0' => Mage::helper('amcustomerimg')->__('No'),
                '1' => Mage::helper('amcustomerimg')->__('Yes'),
            ),
            'align' => 'center',
        ));
        
        $this->addColumn('created_at', array(
            'header' => Mage::helper('amcustomerimg')->__('Uploaded On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '160px',
        ));
        
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('amcustomerimg')->__('Action'),
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('amcustomerimg')->__('Approve --> Product Images'),
                        'url'       => array('base'=> '*/*/approve', 'params' => array('main' => 1)),
                        'field'     => 'id'
                    ),
                    array(
                        'caption'   => Mage::helper('amcustomerimg')->__('Approve --> Customer Images'),
                        'url'       => array('base'=> '*/*/approve', 'params' => array('separate' => 1)),
                        'field'     => 'id'
                    ),
                    array(
                        'caption'   => Mage::helper('amcustomerimg')->__('Approve --> Both'),
                        'url'       => array('base'=> '*/*/approve', 'params' => array('main' => 1, 'separate' => 1)),
                        'field'     => 'id'
                    ),
                    array(
                        'caption'   => Mage::helper('amcustomerimg')->__('Decline'),
                        'url'       => array('base'=> '*/*/decline'),
                        'field'     => 'id'
                    ),
                    array(
                        'caption'   => Mage::helper('amcustomerimg')->__('Delete'),
                        'url'       => array('base'=> '*/*/delete'),
                        'field'     => 'id'
                    ),
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
                'width'	    => '200px',
        ));
        
        return $this;
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('image');

        $this->getMassactionBlock()->addItem('approve_product', array(
             'label'=> Mage::helper('catalog')->__('Approve --> Product Images'),
             'url'  => $this->getUrl('*/*/massApprove', array('main' => 1)),
        ));
        
        $this->getMassactionBlock()->addItem('approve_separate', array(
             'label'=> Mage::helper('catalog')->__('Approve --> Customer Images'),
             'url'  => $this->getUrl('*/*/massApprove', array('separate' => 1)),
        ));
        
        $this->getMassactionBlock()->addItem('approve_both', array(
             'label'=> Mage::helper('catalog')->__('Approve --> Both'),
             'url'  => $this->getUrl('*/*/massApprove', array('main' => 1, 'separate' => 1)),
        ));
        
        $this->getMassactionBlock()->addItem('decline', array(
             'label'=> Mage::helper('catalog')->__('Decline'),
             'url'  => $this->getUrl('*/*/massDecline'),
             'confirm' => Mage::helper('catalog')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('catalog')->__('Delete'),
             'url'  => $this->getUrl('*/*/massDelete'),
             'confirm' => Mage::helper('catalog')->__('Are you sure?')
        ));
		
        return $this;
    }
    
    public function getRowUrl($row)
    {
        return false;
    }
}