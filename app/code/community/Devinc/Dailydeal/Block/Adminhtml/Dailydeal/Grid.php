<?php

class Devinc_Dailydeal_Block_Adminhtml_Dailydeal_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	const STATUS_RUNNING = Devinc_Dailydeal_Model_Source_Status::STATUS_RUNNING;
	const STATUS_DISABLED = Devinc_Dailydeal_Model_Source_Status::STATUS_DISABLED;
	const STATUS_ENDED = Devinc_Dailydeal_Model_Source_Status::STATUS_ENDED;
	const STATUS_QUEUED = Devinc_Dailydeal_Model_Source_Status::STATUS_QUEUED;
  
    public function __construct()
    {
        parent::__construct();
        $this->setId('dailydealGrid');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }
    
    protected function _prepareCollection()
    {
		$nameAttributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product','name');
        $collection = Mage::getModel('dailydeal/dailydeal')->getCollection();
        
        $resource = Mage::getSingleton('core/resource');
        //add product names to collection
        $collection->getSelect()->join(array('product_name_table'=>$resource->getTableName('catalog_product_entity_varchar')), 'main_table.product_id = product_name_table.entity_id AND store_id = 0 AND attribute_id = '.$nameAttributeId, array('product_name' => 'product_name_table.value'));
        //add product skus to collection
		$collection->getSelect()->join(array('product_sku_table'=>$resource->getTableName('catalog_product_entity')), 'main_table.product_id = product_sku_table.entity_id', array('product_sku' => 'product_sku_table.sku'));
    	
    	$defaultSort = Mage::getSingleton('adminhtml/session')->getData('dailydealGridsort');
   	    $sort = $this->getRequest()->getParam('sort', '');
  	    if ($sort=='' && $defaultSort=='') {
  	    	  $collection->setOrder('status', 'ASC')->setOrder('position', 'ASC')->setOrder('dailydeal_id', 'DESC');
  	    } 
  	    
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _prepareColumns()
    {
        $this->addColumn('dailydeal_id', array(
            'header'    => Mage::helper('dailydeal')->__('ID'),
            'align'     =>'left',
            'width'     => '30px',
            'index'     => 'dailydeal_id',
        ));
            		
    	$this->addColumn('product_name', array( 
            'header'    => Mage::helper('dailydeal')->__('Product name'),
            'align'     => 'left',
            'index'     => 'product_name',
        	'filter_index' => 'product_name_table.value',
        ));   	
    		
    	$this->addColumn('product_sku', array( 
            'header'    => Mage::helper('dailydeal')->__('Product SKU'),
            'align'     => 'left',
            'width'     => '200px',
            'index'     => 'product_sku',
        	'filter_index' => 'product_sku_table.sku',
        ));  

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('stores', array(
                'header'    => Mage::helper('sales')->__('Available in Store(s)'),
                'index'     => 'stores',
                'type'      => 'options',
                'sortable'	=> false,
                'filter'	=> false,
            	'width'     => '150px',
           		'renderer'  => 'dailydeal/adminhtml_dailydeal_grid_renderer_stores',
            ));
        }
    	  
        $store = $this->_getStore();	  
    	$this->addColumn('deal_price', array( 
            'header'    => Mage::helper('dailydeal')->__('Deal Price'),
            'align'     => 'left',
            'index'     => 'deal_price',
            'width'     => '50px',
            'currency_code' => $store->getBaseCurrency()->getCode(),
            'type'      => 'price',
        ));     
            
        $this->addColumn('deal_qty', array(
            'header'    => Mage::helper('dailydeal')->__('Deal Qty'),
            'align'     =>'left',
            'width'     => '30px',
            'index'     => 'deal_qty',
        ));
    	  
    	$this->addColumn('datetime_from', array(
            'header'    => Mage::helper('dailydeal')->__('Date/Time From'),
            'align'     => 'left',
            'width'     => '135px',
            'type'      => 'date',
            'format'    => Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM),
            'gmtoffset' => false,
            'default'   => '',
            'index'     => 'datetime_from',
        ));	 
    	  
    	$this->addColumn('datetime_to', array(
            'header'    => Mage::helper('dailydeal')->__('Date/Time To'),
            'align'     => 'left',
            'width'     => '135px',
            'type'      => 'date',
            'format'    => Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM),
            'gmtoffset' => false,
            'default'   => '',
            'index'     => 'datetime_to',
        ));	 
            
        $this->addColumn('qty_sold', array(
            'header'    => Mage::helper('dailydeal')->__('Qty Sold'),
            'align'     =>'left',
            'width'     => '30px',
            'index'     => 'qty_sold',
        ));
    
        $this->addColumn('nr_views', array(
            'header'    => Mage::helper('dailydeal')->__('Nr. Views'),
            'align'     =>'left',
            'width'     => '30px',
            'index'     => 'nr_views',
        ));
    	  
        $this->addColumn('status', array(
            'header'    => Mage::helper('dailydeal')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                self::STATUS_QUEUED => 'Queued',
                self::STATUS_RUNNING => 'Running',
                self::STATUS_ENDED => 'Ended',
                self::STATUS_DISABLED => 'Disabled',
            ),
            'renderer'  => 'dailydeal/adminhtml_dailydeal_grid_renderer_status',
        ));
  	    
        $this->addColumn('position', array(
            'header'    => Mage::helper('catalog')->__('Position'),
            'type'      => 'number',
            'index'     => 'position',
            'editable'  => false
        ));
    	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('dailydeal')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(		
                    array(
                        'caption'   => Mage::helper('dailydeal')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    ),		
                    array(
                        'caption'   => Mage::helper('dailydeal')->__('Delete'),
                        'url'       => array('base'=> '*/*/delete'),
                        'field'     => 'id',
    			  	    'confirm'  => Mage::helper('dailydeal')->__('Are you sure you want to delete this deal?')
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
    		
    	$this->addExportType('*/*/exportCsv', Mage::helper('dailydeal')->__('CSV'));
    	$this->addExportType('*/*/exportXml', Mage::helper('dailydeal')->__('XML'));
    	  
        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction()
    {
          $this->setMassactionIdField('dailydeal_id');
          $this->getMassactionBlock()->setFormFieldName('dailydeal');
    
          $this->getMassactionBlock()->addItem('delete', array(
               'label'    => Mage::helper('dailydeal')->__('Delete'),
               'url'      => $this->getUrl('*/*/massDelete'),
               'confirm'  => Mage::helper('dailydeal')->__('Are you sure you want to delete these deals?')
          ));
    
          $statuses = Mage::getSingleton('dailydeal/source_status')->getOptionArray();
    
          array_unshift($statuses, array('label'=>'', 'value'=>''));
          $this->getMassactionBlock()->addItem('status', array(
               'label'=> Mage::helper('dailydeal')->__('Change status'),
               'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
               'additional' => array(
                      'visibility' => array(
                           'name' => 'status',
                           'type' => 'select',
                           'class' => 'required-entry',
                           'label' => Mage::helper('dailydeal')->__('Status'),
                           'values' => $statuses
                       )
               )
          ));
          return $this;
    }
    
    protected function _getStore()
    {
          $storeId = (int) $this->getRequest()->getParam('store', 0);
          return Mage::app()->getStore($storeId);
    }   
	
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
    
    public function getRowUrl($row)
    {
    	$page = Mage::helper('dailydeal')->getProductPage($row->getProductId());
    	  
        return $this->getUrl('*/*/edit', array('id' => $row->getId(), 'page' => $page));
    }

}