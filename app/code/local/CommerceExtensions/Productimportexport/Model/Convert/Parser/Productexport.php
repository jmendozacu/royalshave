<?php
/**
 * Productexport.php
 * CommerceThemes @ InterSEC Solutions LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.commercethemes.com/LICENSE-M1.txt
 *
 * @category   Product
 * @package    Productexport
 * @copyright  Copyright (c) 2003-2009 CommerceThemes @ InterSEC Solutions LLC. (http://www.commercethemes.com)
 * @license    http://www.commercethemes.com/LICENSE-M1.txt
 */


class CommerceExtensions_Productimportexport_Model_Convert_Parser_Productexport
    extends Mage_Eav_Model_Convert_Parser_Abstract
{
    const MULTI_DELIMITER = ' , ';
    protected $_resource;

    /**
     * Product collections per store
     *
     * @var array
     */
    protected $_collections;

    protected $_productTypes = array(
        'simple'=>'Simple',
        'bundle'=>'Bundle',
        'configurable'=>'Configurable',
        'grouped'=>'Grouped',
        'virtual'=>'Virtual',
    );

    protected $_inventoryFields = array();

    protected $_imageFields = array();

    protected $_systemFields = array();
    protected $_internalFields = array();
    protected $_externalFields = array();

    protected $_inventoryItems = array();

    protected $_productModel;

    protected $_setInstances = array();

    protected $_store;
    protected $_storeId;
    protected $_attributes = array();

    public function __construct()
    {
        foreach (Mage::getConfig()->getFieldset('catalog_product_dataflow', 'admin') as $code=>$node) {
            if ($node->is('inventory')) {
                $this->_inventoryFields[] = $code;
                if ($node->is('use_config')) {
                    $this->_inventoryFields[] = 'use_config_'.$code;
                }
            }
            if ($node->is('internal')) {
                $this->_internalFields[] = $code;
            }
            if ($node->is('system')) {
                $this->_systemFields[] = $code;
            }
            if ($node->is('external')) {
                $this->_externalFields[$code] = $code;
            }
            if ($node->is('img')) {
                $this->_imageFields[] = $code;
            }
        }
    }

    /**
     * @return Mage_Catalog_Model_Mysql4_Convert
     */
    public function getResource()
    {
        if (!$this->_resource) {
            $this->_resource = Mage::getResourceSingleton('catalog_entity/convert');
                #->loadStores()
                #->loadProducts()
                #->loadAttributeSets()
                #->loadAttributeOptions();
        }
        return $this->_resource;
    }

    public function getCollection($storeId)
    {
        if (!isset($this->_collections[$storeId])) {
            $this->_collections[$storeId] = Mage::getResourceModel('catalog/product_collection');
            $this->_collections[$storeId]->getEntity()->setStore($storeId);
        }
        return $this->_collections[$storeId];
    }

    /**
     * Retrieve product type options
     *
     * @return array
     */
    public function getProductTypes()
    {
        if (is_null($this->_productTypes)) {
            $this->_productTypes = Mage::getSingleton('catalog/product_type')
                ->getOptionArray();
        }
        return $this->_productTypes;
    }

    /**
     * Retrieve Product type name by code
     *
     * @param string $code
     * @return string
     */
    public function getProductTypeName($code)
    {
        $productTypes = $this->getProductTypes();
        if (isset($productTypes[$code])) {
            return $productTypes[$code];
        }
        return false;
    }

    /**
     * Retrieve product type code by name
     *
     * @param string $name
     * @return string
     */
    public function getProductTypeId($name)
    {
        $productTypes = $this->getProductTypes();
        if ($code = array_search($name, $productTypes)) {
            return $code;
        }
        return false;
    }

    /**
     * Retrieve product model cache
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProductModel()
    {
        if (is_null($this->_productModel)) {
            $productModel = Mage::getModel('catalog/product');
            $this->_productModel = Mage::objects()->save($productModel);
        }
        return Mage::objects()->load($this->_productModel);
    }

    /**
     * Retrieve current store model
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        if (is_null($this->_store)) {
            try {
                $store = Mage::app()->getStore($this->getVar('store'));
            }
            catch (Exception $e) {
                $this->addException(Mage::helper('catalog')->__('Invalid store specified'), Varien_Convert_Exception::FATAL);
                throw $e;
            }
            $this->_store = $store;
        }
        return $this->_store;
    }

    /**
     * Retrieve store ID
     *
     * @return int
     */
    public function getStoreId()
    {
        if (is_null($this->_storeId)) {
            $this->_storeId = $this->getStore()->getId();
        }
        return $this->_storeId;
    }

/**
     * ReDefine Product Type Instance to Product
     *
     * @param Mage_Catalog_Model_Product $product
     * @return Mage_Catalog_Model_Convert_Adapter_Product
     */
    public function setProductTypeInstance(Mage_Catalog_Model_Product $product)
    {
        $type = $product->getTypeId();
        if (!isset($this->_productTypeInstances[$type])) {
            $this->_productTypeInstances[$type] = Mage::getSingleton('catalog/product_type')
                ->factory($product, true);
        }
        $product->setTypeInstance($this->_productTypeInstances[$type], true);
        return $this;
    }

    public function getAttributeSetInstance()
    {
        $productType = $this->getProductModel()->getType();
        $attributeSetId = $this->getProductModel()->getAttributeSetId();

        if (!isset($this->_setInstances[$productType][$attributeSetId])) {
            $this->_setInstances[$productType][$attributeSetId] =
                Mage::getSingleton('catalog/product_type')->factory($this->getProductModel());
        }

        return $this->_setInstances[$productType][$attributeSetId];
    }

    /**
     * Retrieve eav entity attribute model
     *
     * @param string $code
     * @return Mage_Eav_Model_Entity_Attribute
     */
    public function getAttribute($code)
    {
        if (!isset($this->_attributes[$code])) {
            $this->_attributes[$code] = $this->getProductModel()->getResource()->getAttribute($code);
        }
        return $this->_attributes[$code];
    }

    /**
     * @deprecated not used anymore
     */
    public function parse()
    {
        $data = $this->getData();

        $entityTypeId = Mage::getSingleton('eav/config')->getEntityType('catalog_product')->getId();

        $result = array();
        $inventoryFields = array();
        foreach ($data as $i=>$row) {
            $this->setPosition('Line: '.($i+1));
            try {
                // validate SKU
                if (empty($row['sku'])) {
                    $this->addException(Mage::helper('catalog')->__('Missing SKU, skipping the record'), Mage_Dataflow_Model_Convert_Exception::ERROR);
                    continue;
                }
                $this->setPosition('Line: '.($i+1).', SKU: '.$row['sku']);

                // try to get entity_id by sku if not set
                if (empty($row['entity_id'])) {
                    $row['entity_id'] = $this->getResource()->getProductIdBySku($row['sku']);
                }

                // if attribute_set not set use default
                if (empty($row['attribute_set'])) {
                    $row['attribute_set'] = 'Default';
                }
                // get attribute_set_id, if not throw error
                $row['attribute_set_id'] = $this->getAttributeSetId($entityTypeId, $row['attribute_set']);
                if (!$row['attribute_set_id']) {
                    $this->addException(Mage::helper('catalog')->__("Invalid attribute set specified, skipping the record"), Mage_Dataflow_Model_Convert_Exception::ERROR);
                    continue;
                }

                if (empty($row['type'])) {
                    $row['type'] = 'Simple';
                }
                // get product type_id, if not throw error
                $row['type_id'] = $this->getProductTypeId($row['type']);
                if (!$row['type_id']) {
                    $this->addException(Mage::helper('catalog')->__("Invalid product type specified, skipping the record"), Mage_Dataflow_Model_Convert_Exception::ERROR);
                    continue;
                }

                // get store ids
                $storeIds = $this->getStoreIds(isset($row['store']) ? $row['store'] : $this->getVar('store'));
                if (!$storeIds) {
                    $this->addException(Mage::helper('catalog')->__("Invalid store specified, skipping the record"), Mage_Dataflow_Model_Convert_Exception::ERROR);
                    continue;
                }

                // import data
                $rowError = false;
                foreach ($storeIds as $storeId) {
                    $collection = $this->getCollection($storeId);
                    $entity = $collection->getEntity();

                    $model = Mage::getModel('catalog/product');
                    $model->setStoreId($storeId);
                    if (!empty($row['entity_id'])) {
                        $model->load($row['entity_id']);
                    }
                    foreach ($row as $field=>$value) {
                        $attribute = $entity->getAttribute($field);

                        if (!$attribute) {
                            //$inventoryFields[$row['sku']][$field] = $value;

                            if (in_array($field, $this->_inventoryFields)) {
                                $inventoryFields[$row['sku']][$field] = $value;
                            }
                            continue;
                            #$this->addException(Mage::helper('catalog')->__("Unknown attribute: %s", $field), Mage_Dataflow_Model_Convert_Exception::ERROR);
                        }
                        if ($attribute->usesSource()) {
                            $source = $attribute->getSource();
                            $optionId = $this->getSourceOptionId($source, $value);
                            if (is_null($optionId)) {
                                $rowError = true;
                                $this->addException(Mage::helper('catalog')->__("Invalid attribute option specified for attribute %s (%s), skipping the record", $field, $value), Mage_Dataflow_Model_Convert_Exception::ERROR);
                                continue;
                            }
                            $value = $optionId;
                        }
                        $model->setData($field, $value);

                    }//foreach ($row as $field=>$value)

                    //echo 'Before **********************<br/><pre>';
                    //print_r($model->getData());
                    if (!$rowError) {
                        $collection->addItem($model);
                    }
                    unset($model);
                } //foreach ($storeIds as $storeId)
            } catch (Exception $e) {
                if (!$e instanceof Mage_Dataflow_Model_Convert_Exception) {
                    $this->addException(Mage::helper('catalog')->__("Error during retrieval of option value: %s", $e->getMessage()), Mage_Dataflow_Model_Convert_Exception::FATAL);
                }
            }
        }

        // set importinted to adaptor
        if (sizeof($inventoryFields) > 0) {
            Mage::register('current_imported_inventory', $inventoryFields);
            //$this->setInventoryItems($inventoryFields);
        } // end setting imported to adaptor

        $this->setData($this->_collections);
        return $this;
    }

    public function setInventoryItems($items)
    {
        $this->_inventoryItems = $items;
    }

    public function getInventoryItems()
    {
        return $this->_inventoryItems;
    }

	public function exportProductData($product, $export_multi_store, $i, $read, $prefix, $websiteCode="")
    {
				
            $position = Mage::helper('catalog')->__('Line %d, SKU: %s', ($i+1), $product->getSku());
            $this->setPosition($position);
			
			if($export_multi_store == "true") {	
				$exported_store_code = $product->getStore()->getCode();
			} else {
				$exported_store_code = $this->getStore()->getCode();
			}
            $row = array(
                'store'         => $exported_store_code,
                'websites'      => '',
                'attribute_set' => $this->getAttributeSetName($product->getEntityTypeId(), $product->getAttributeSetId()),
                'prodtype'          => $product->getTypeId(),
                'category_ids'  => join(',', $product->getCategoryIds())
            );
			
			if($export_multi_store == "true") {	
				$row['websites'] = $websiteCode;
			} else {
			
				if ($this->getStore()->getCode() == Mage_Core_Model_Store::ADMIN_CODE) {
					$websiteCodes = array();
					foreach ($product->getWebsiteIds() as $websiteId) {
						$websiteCode = Mage::app()->getWebsite($websiteId)->getCode();
						$websiteCodes[$websiteCode] = $websiteCode;
					}
					$row['websites'] = join(',', $websiteCodes);
				}
				else {
					$row['websites'] = $this->getStore()->getWebsite()->getCode();
					if ($this->getVar('url_field')) {
						$row['url'] = $product->getProductUrl(false);
					}
				}
			}
            foreach ($product->getData() as $field => $value) {
                if (in_array($field, $this->_systemFields) || is_object($value)) {
                    continue;
                }

                $attribute = $this->getAttribute($field);
                if (!$attribute) {
                    continue;
                }
								#print_r($attribute);
                if ($attribute->usesSource()) {
										
										$finalproductattributes = "";
										$row['config_attributes'] = '';
										if($product->getTypeId() == "configurable") {
											  //$cProduct = Mage::getModel('catalog/product')->load($product->getId());
												//check if product is a configurable type or not
												if ($product->getData('type_id') == "configurable")
												{
														 //get the configurable data from the product
														 $config = $product->getTypeInstance(true);
														 //loop through the attributes                                  
														 foreach($config->getConfigurableAttributesAsArray($product) as $attributes)
														 { 
																 #$finalproductattributes .= $attributes["label"] . ",";
														 		 $finalproductattributes .= $attributes['attribute_code'] . ",";
																 
														 }
												} 

										}
										$row['config_attributes'] = substr_replace($finalproductattributes,"",-1);
					if (is_object($attribute->usesSource())) {							
						$option = $attribute->getSource()->getOptionText($value);
					} else if ($field != "meta_robots" && $field != "canonical_url"){ //3rd party patch here for these fields.. attribute non-object error
						  $attributes = Mage::getResourceModel('eav/entity_attribute_collection')
						  ->setEntityTypeFilter($product->getResource()->getTypeId())
						  ->addFieldToFilter('attribute_code', $field);
						  $attribute = $attributes->getFirstItem()->setEntity($product->getResource());
						  #echo "FIELD: " . $field . "<br/>";
						  #echo "VALUE: " . $attribute->getSource()->getOptionText($value). "<br/>";	
						  $option = $attribute->getSource()->getOptionText($value);
						  #exit;
					} else {
						$option ="";
					}
                    if ($value && $value !="" && empty($option) && $field != "meta_robots") {
                        $message = Mage::helper('catalog')->__("Invalid option id specified for %s (%s), skipping the record", $field, $value);
                        #$this->addException($message, Mage_Dataflow_Model_Convert_Exception::ERROR);
                        continue;
                    }
                    if (is_array($option)) {
                        $value = join(self::MULTI_DELIMITER, $option);
                    } else {
                        $value = $option;
                    }
                    unset($option);
                }
                elseif (is_array($value)) {
                    continue;
                }

				if($this->getVar('export_full_image_paths') == "true" && $field == "image" || $this->getVar('export_full_image_paths') == "true" && $field == "small_image" || $this->getVar('export_full_image_paths') == "true" && $field == "thumbnail") {
					if($value !="no_selection") { $row[$field] = Mage::getBaseUrl('web') . "media/catalog/product" . $value; }else{$row[$field] = $value;}
				} else {
					$row[$field] = $value;
				}
            }

						
            if ($stockItem = $product->getStockItem()) {
                foreach ($stockItem->getData() as $field => $value) {
                    if (in_array($field, $this->_systemFields) || is_object($value)) {
                        continue;
                    }
                    $row[$field] = $value;
                }
            }

            foreach ($this->_imageFields as $field) {
                if (isset($row[$field]) && $row[$field] == 'no_selection') {
                    $row[$field] = null;
                }
            }
						
				$row['product_id'] =  $product->getId();
				if($this->getVar('export_category_paths') == "true") {
					 
					  /* ADDITIONAL CATEGORY ID EXPORT FOR 1.4 ONLY [START] */
					 $finalcategoryIds = "";
					 $select_qryvalues2 = $read->query("SELECT category_id FROM `".$prefix."catalog_category_product` WHERE product_id = '".$product->getId()."'");
					 while ($datavalues2 = $select_qryvalues2->fetch()) {
						$finalcategoryIds .= $datavalues2['category_id'] . ",";
					 }
					 $row['categorys_ids'] = substr_replace($finalcategoryIds,"",-1);
					 /* ADDITIONAL CATEGORY ID EXPORT FOR 1.4 ONLY [END] */
					 
					 /* PRODUCT CATEGORIES EXPORT START */
						#print_r($row['categorys_ids']);
						if($row['categorys_ids'] != "") {
						    $finalimportofcategories = "";
							$okforallcategoriesnow = "";
							$finalvcategoriesproductoptions1 = "";
							$finalvcategoriesproductoptions2 = "";
							$finalvcategoriesproductoptions2before = "";
							foreach(explode(',',$row['categorys_ids']) as $productcategoryId)
							{
									$cat = Mage::getModel('catalog/category')->load($productcategoryId);
									$finalvcategoriesproductoptions1 = $cat->getName();
									$subcatsforreverse = $cat->getParentIds();
									$subcats = array_shift($subcatsforreverse);
									$subcats1 = array_shift($subcatsforreverse);
									#print_r($subcatsforreverse);
									$finalvcategoriesproductoptions2before = "";
									foreach($subcatsforreverse as $subcatsproductcategoryId)
									{
											$subcat = Mage::getModel('catalog/category')->load($subcatsproductcategoryId);
											#echo "CAT1: " . $subcat->getName() . "<br/>";
											$finalvcategoriesproductoptions2before .= $subcat->getName() . "/";
											$subsubcats = $subcat->getChildren();
									}
									$finalimportofcategories .= $finalvcategoriesproductoptions2before . 
									$finalvcategoriesproductoptions1 . " , ";
							}
							$okforallcategoriesnow = substr_replace($finalimportofcategories,"",-3);
							$row['categories'] = $okforallcategoriesnow;
							
						}
					/* PRODUCT CATEGORIES EXPORT END */
					 
				} else {
					 
					 /* ADDITIONAL CATEGORY ID EXPORT FOR 1.4 ONLY [START] */
					 $finalcategoryIds = "";
					 $select_qryvalues2 = $read->query("SELECT category_id FROM `".$prefix."catalog_category_product` WHERE product_id = '".$product->getId()."'");
					 while ($datavalues2 = $select_qryvalues2->fetch()) {
						$finalcategoryIds .= $datavalues2['category_id'] . ",";
					 }
					 $row['category_ids'] = substr_replace($finalcategoryIds,"",-1);
					 /* ADDITIONAL CATEGORY ID EXPORT FOR 1.4 ONLY [END] */
					 
				}
						/* ADDITIONAL IMAGE EXPORT FOR 1.4 ONLY [START] */
						$finalgalleryimages = "";
						//$galleryImagesModel = Mage::getModel('catalog/product')->load($product->getId())->getMediaGalleryImages();
						$galleryImagesModel = $product->getData('media_gallery');
						
						if (count($galleryImagesModel['images']) > 0) {
							foreach ($galleryImagesModel['images'] as $_image) {
								
								if($this->getVar('export_full_image_paths') == "true") {
									//$finalgalleryimages .= Mage::getBaseUrl('web') . "media/catalog/product" .  $_image->getFile() . ",";
									$finalgalleryimages .= Mage::getBaseUrl('web') . "media/catalog/product" .  $_image['file'] . ",";
								} else {
									//$finalgalleryimages .= $_image->getFile() . ",";
									$finalgalleryimages .= $_image['file'] . ",";
								}
							}
						}
						
						$row['gallery'] = substr_replace($finalgalleryimages,"",-1);
						/* ADDITIONAL IMAGE EXPORT FOR 1.4 ONLY [END] */
						
						/* ADDITIONAL IMAGE LABEL EXPORT FOR 1.4 ONLY [START] */
						$finalgallerylabelimages = "";
						
						if (count($galleryImagesModel['images']) > 0) {
							foreach ($galleryImagesModel['images'] as $_image) {
								//if($_image->getLabel() !="") { $finalgallerylabelimages .= $_image->getLabel() . ";"; }
								if($_image['label'] !="") { $finalgallerylabelimages .= $_image['label'] . ";"; }
							}
						}
						$row['gallery_label'] = substr_replace($finalgallerylabelimages,"",-1);
						
						/* ADDITIONAL IMAGE LABEL EXPORT FOR 1.4 ONLY [END] */
						
						$row['related'] = "";
						$incoming_RelatedProducts = $product->getRelatedProducts();
						foreach($incoming_RelatedProducts as $relatedproducts_str){
							#print_r($relatedproducts_str);
							#echo "SKU: " . $relatedproducts_str->getSku();
							if($this->getVar('export_related_position') == "true") {
								$row['related'] .= $relatedproducts_str['position'] .":". $relatedproducts_str->getSku() . ",";
							} else {
								$row['related'] .= $relatedproducts_str->getSku() . ",";
							}
						} 
						
						$row['upsell'] = "";
						$incoming_UpSellProducts = $product->getUpSellProducts();
						foreach($incoming_UpSellProducts as $UpSellproducts_str){
							#print_r($relatedproducts_str);
							#echo "SKU: " . $UpSellproducts_str->getSku();
							if($this->getVar('export_upsell_position') == "true") {
								$row['upsell'] .= $UpSellproducts_str['position'] .":". $UpSellproducts_str->getSku() . ",";
							} else {
								$row['upsell'] .= $UpSellproducts_str->getSku() . ",";
							}
						}
				
						$row['crosssell'] = "";
						$incoming_CrossSellProducts = $product->getCrossSellProducts ();
						foreach($incoming_CrossSellProducts as $CrossSellproducts_str){
							#print_r($relatedproducts_str);
							#echo "SKU: " . $CrossSellproducts_str->getSku();
							if($this->getVar('export_upsell_position') == "true") {
							    #echo "SKU crosssell: " . $CrossSellproducts_str['position'] . " -- "  . $CrossSellproducts_str->getSku();
								$row['crosssell'] .= $CrossSellproducts_str['position'] .":". $CrossSellproducts_str->getSku() . ",";
							} else {
								$row['crosssell'] .= $CrossSellproducts_str->getSku() . ",";
							}
						}
		
						/* EXPORTS TIER PRICING */
						#print_r($product->getTierPrice());
						$row['tier_prices'] = "";
						#$incoming_tierps = $product->getTierPrice();
						$incoming_tierps = $product->getData('tier_price');
						if(is_array($incoming_tierps)) {
							foreach($incoming_tierps as $tier_str){
								#print_r($tier_str);
								$row['tier_prices'] .= $tier_str['cust_group'] . "=" . round($tier_str['price_qty']) . "=" . $tier_str['price'] . "|";
							}
						}
						/* EXPORTS ASSOICATED CONFIGURABLE SKUS */
						$row['associated'] = '';
						if($product->getTypeId() == "configurable") {
							$associatedProducts = Mage::getSingleton('catalog/product_type')->factory($product)->getUsedProducts($product);
							#print_r($associatedProducts->getUsedProducts($product));
							#echo "ID: " . $product2->getId();
							foreach($associatedProducts as $associatedProduct) {
									$row['associated'] .= $associatedProduct->getSku() . ",";
							}
						}
										
							/* EXPORTS ASSOICATED BUNDLE SKUS */
							$row['bundle_options'] = '';
							if($product->getTypeId() == "bundle") {
								$finalbundleoptions = "";
								$finalbundleselectionoptions = "";
								$finalbundleselectionoptionssorting = "";
								$optionModel = Mage::getModel('bundle/option')->getResourceCollection()->setProductIdFilter($product->getId());
									
								foreach($optionModel as $eachOption) {
										
										$selectOptionID = "SELECT title FROM ".$prefix."catalog_product_bundle_option_value WHERE option_id = ".$eachOption->getData('option_id')."";
										$Optiondatarows = $read->query($selectOptionID);
										while ($Option_row = $Optiondatarows->fetch()) {
											$finaltitle = str_replace(' ','_',$Option_row['title']);
										}
										$finalbundleoptions .=  $finaltitle . "," . $eachOption->getData('type') . "," . $eachOption->getData('required') . "," . $eachOption->getData('position') . "|";
										
										
										$selectionModel = Mage::getModel('bundle/selection')->setOptionId($eachOption->getData('option_id'))->getResourceCollection();
										#print_r($selectionModel->getData());
										foreach($selectionModel as $eachselectionOption) {
											#echo "t: " . $eachselectionOption->getData('selection_price_type');
											if($eachselectionOption->getData('option_id') == $eachOption->getData('option_id')) {
											$finalbundleselectionoptionssorting .=  $eachselectionOption->getData('sku') . ":" . $eachselectionOption->getData('selection_price_type') . ":" . $eachselectionOption->getData('selection_price_value') . ":" . $eachselectionOption->getData('is_default') . ":" . $eachselectionOption->getData('selection_qty') . ":" . $eachselectionOption->getData('selection_can_change_qty'). ":" . $eachselectionOption->getData('position') . ",";
											}
										}
										$finalbundleselectionoptionssorting = substr_replace($finalbundleselectionoptionssorting,"",-1);
										$finalbundleselectionoptionssorting .=  "|";
										$finalbundleselectionoptions = substr_replace($finalbundleselectionoptionssorting,"",-1);
								}
								$row['bundle_options'] = substr_replace($finalbundleoptions,"",-1);
								$row['bundle_selections'] = substr_replace($finalbundleselectionoptions,"",-1);
							}
			
						
						/* EXPORTS ASSOICATED GROUPED SKUS */
						$row['grouped'] = '';
						if($product->getTypeId() == "grouped") {
							$associatedProducts = Mage::getSingleton('catalog/product_type')->factory($product)->getAssociatedProducts($product);
							foreach($associatedProducts as $associatedProduct) {
									if($this->getVar('export_grouped_position') == "true") {
										$row['grouped'] .= $associatedProduct->getPosition() . ":" . $associatedProduct->getSku() . ":" . $associatedProduct->getQty() . ",";
									} else {
										$row['grouped'] .= $associatedProduct->getSku() . ",";
									}
							}
						}
						
						/*EXPORTS GROUPED PRICES 1.7.x beta rc1 */
						$verChecksplit = explode(".",Mage::getVersion());
						// 1.7.x ONLY and Professional 1.11.x
						if ($verChecksplit[1] >= 7 && $verChecksplit[1] != 11) {
						
							$resource2 = Mage::getSingleton('core/resource');
							$finalgrouped_prices_info="";
							$select_qry_grouped_pricing = "SELECT * FROM ".$resource2->getTableName('catalog/product_attribute_group_price')." WHERE entity_id = '".$product->getId()."'";
							$rows = $read->query($select_qry_grouped_pricing);
							
					 		while ($groupRow = $rows->fetch()) {
							  if($groupRow['website_id'] !="" && $groupRow['website_id'] > 0) {
								$finalgrouped_prices_info .= $groupRow['customer_group_id']."=".$groupRow['value']."=".$groupRow['website_id']."|";
							  } else {
								$finalgrouped_prices_info .= $groupRow['customer_group_id'] . "=" . $groupRow['value'] . "|";
							  }
							}
							$row['group_price_price'] = substr_replace($finalgrouped_prices_info,"",-1);
							
						}
						/* EXPORTS DOWNLOADABLE OPTIONS */
						$row['downloadable_options'] = '';
						$row['downloadable_sample_options'] = '';
						$finaldownloabledproductoptions = "";
						$finaldownloabledsampleproductoptions = "";
						
						if($product->getTypeId() == "downloadable") {
						
            	$_linkCollection = Mage::getModel('downloadable/link')->getCollection()
                ->addProductToFilter($product->getId())
                ->addTitleToResult($product->getStoreId())
                ->addPriceToResult($product->getStore()->getWebsiteId());

						 foreach ($_linkCollection as $link) {
              /* @var Mage_Downloadable_Model_Link $link */
              #print_r($link);
							#Main file,0.00,3,file,/test.mp3,/sample.mp
							if($link->getLinkUrl() !="" && $link->getSampleUrl() !="") {
							$finaldownloabledproductoptions .= $link->getTitle() . "," . $link->getPrice() . "," . $link->getNumberOfDownloads() . "," . $link->getLinkType() . "," . $link->getLinkUrl() . "," . $link->getSampleUrl() . "|";
							} else if($link->getLinkUrl() !="") {
							$finaldownloabledproductoptions .= $link->getTitle() . "," . $link->getPrice() . "," . $link->getNumberOfDownloads() . "," . $link->getLinkType() . "," . $link->getLinkUrl() . "|";
							} else if($link->getLinkFile() !="" && $link->getSampleFile() !="") {
							$finaldownloabledproductoptions .= $link->getTitle() . "," . $link->getPrice() . "," . $link->getNumberOfDownloads() . "," . $link->getLinkType() . "," . $link->getLinkFile() . "," . $link->getSampleFile() . "|";
							} else {
							$finaldownloabledproductoptions .= $link->getTitle() . "," . $link->getPrice() . "," . $link->getNumberOfDownloads() . "," . $link->getLinkType() . "," . $link->getLinkFile() . "|";
							}
						 }
						 $row['downloadable_options'] = substr_replace($finaldownloabledproductoptions,"",-1);
							
						
						
						$_linkSampleCollection = Mage::getModel('downloadable/sample')->getCollection()
                								->addProductToFilter($product->getId())
                								->addTitleToResult($product->getStoreId());

						 foreach ($_linkSampleCollection as $sample_link) {
							/* @var Mage_Downloadable_Model_Sample $sample_link */
							#print_r($sample_link);
							#Main file,file,/test.mp3,/sample.mp3
							if($sample_link->getSampleUrl() !="") {
								$finaldownloabledsampleproductoptions .= $sample_link->getTitle() . "," . $sample_link->getLinkType() . "," . $sample_link->getSampleUrl() . "|";
							} else if($sample_link->getSampleFile() !="") {
								$finaldownloabledsampleproductoptions .= $sample_link->getTitle() . "," . $sample_link->getLinkType() . "," . $sample_link->getSampleFile() . "|";
							}
						 }
						 $row['downloadable_sample_options'] = substr_replace($finaldownloabledsampleproductoptions,"",-1);
						 
						 } // end for check of downloadable type
						 
						/* EXPORTS SUPER ATTRIBUTE PRICING [START] */
						 $row['super_attribute_pricing'] = "";
						 $finalsuper_attribute_pricing_product_options = "";
					 
						if($product->getTypeId() == "configurable") {
						
							//$cProduct = Mage::getModel('catalog/product')->load($product->getId());
							//check if product is a configurable type or not
							if ($product->getData('type_id') == "configurable")
							{
								 //get the configurable data from the product
								 $config = $product->getTypeInstance(true);
								 //loop through the attributes                                  
								 foreach($config->getConfigurableAttributesAsArray($product) as $attributes)
								 { 
									 foreach($attributes['values'] as $attributedata)
									 { 
										$select_qry_for_super_attribute_pricing = "SELECT * FROM `".$prefix."catalog_product_super_attribute_pricing` WHERE ".$prefix."catalog_product_super_attribute_pricing.product_super_attribute_id = '".$attributedata['product_super_attribute_id']."' AND ".$prefix."catalog_product_super_attribute_pricing.value_index = '".$attributedata['value_index']."'";
										
										$rows = $read->query($select_qry_for_super_attribute_pricing);
										
										if(!empty($rows)) {
											while ($data_sap = $rows->fetch()) { 
											//[value_id] => 4 [product_super_attribute_id] => 3 [value_index] => 39 [is_percent] => 0 [pricing_value] => 1.0000
												$finalsuper_attribute_pricing_product_options .= $attributedata['label'] . ":" . $data_sap['pricing_value'] . ":" . $data_sap['is_percent'] . "|";
											}
										} else {
										  $finalsuper_attribute_pricing_product_options .= $attributedata['label'] . ":" . $attributedata['pricing_value'] . ":" . $attributedata['is_percent'] . "|";
										}
									}
								 }
							} 

						}
						$row['super_attribute_pricing'] = substr_replace($finalsuper_attribute_pricing_product_options,"",-1);
						/* EXPORTS SUPER ATTRIBUTE PRICING [END] */
						
						/* EXPORTS PRODUCT TAGS START*/
						$row['product_tags'] = '';
						$producttagcustomerID="";
						
						$select = "SELECT customer_id FROM `".$prefix."tag_relation` WHERE product_id =".$product->getId()." LIMIT 1";
						$tagRows = $read->query($select);
						while ($TagRow = $tagRows->fetch()) {
							$producttagcustomerID = $TagRow['customer_id'];
						}
						if(!empty($rows)) {
							$all_tags="";
							$tagsCollection = Mage::getModel('tag/tag')->getResourceCollection();
							$tagsCollection->addPopularity()
										   ->addProductFilter($product->getId())
										   ->setActiveFilter();
										   
							foreach( $tagsCollection as $_tag ) {
								  $all_tags .= $producttagcustomerID . ":".str_replace(" ","_", serialize($_tag->getData('name'))) . ",";
							}
							$row['product_tags'] = substr_replace($all_tags,"",-2);
						}
						
						/* EXPORT PRODUCT TAGS END */ 
						
						/* EXPORTS CUSTOM OPTIONS */
						
						//MAGEWORX Custom Option Fix for older versions
						/* 
						$resource2 = Mage::getSingleton('core/resource');
						$storeId = $product->getStoreId();
						$productIds[0] = $product->getId();
						$options = Mage::getResourceModel('catalog/product_option_collection')
							->reset()
							->addTitleToResult($storeId)
							->addPriceToResult($storeId)
							->addProductToFilter($productIds)
							->addValuesToResult($storeId);
						*/
						
						#foreach ($options as $o) {
						foreach ($product->getOptions() as $o) {
							#print_r($o->getData());
							#echo "CUSTOM OPTIONS NAME: " . $o->getData('title') . ":" . $o->getData('type') . ":" . $o->getData('is_require') . ":". $o->getData('sort_order');
							$customoptionvalues = "";
							$customoptionstitle = $o->getData('title') . ":" . $o->getData('type') . ":" . $o->getData('is_require') . ":". $o->getData('sort_order');
							if($o->getData('type')=="checkbox" || $o->getData('type')=="drop_down" || $o->getData('type')=="radio" || $o->getData('type')=="multiple") {
								foreach ( $o->getValues() as $oValues ) {
								  if($oValues->getData('price_type')=="") { $price_type = "fixed"; } else { $price_type = $oValues->getData('price_type'); }
								  if($oValues->getData('price')=="") { $price = "0.0000"; } else { $price = $oValues->getData('price'); }
								  if($oValues->getData('sku')=="") { $sku = " "; } else { $sku = $oValues->getData('sku'); }
								  if($oValues->getData('sort_order')=="") { $sort_order = "0"; } else { $sort_order = $oValues->getData('sort_order'); }
								  if($oValues->getData('max_characters')=="") { $max_characters = "0"; } else { $max_characters = $oValues->getData('max_characters'); }
									
				$customoptionvalues .= $oValues->getData('title') . ":" . $price_type . ":" . $price . ":" . $sku . ":" . $sort_order . ":" . $max_characters . "|";
									
								}
							} else {
								#print_r($o->getData());
								if($o->getData('price_type')=="") { $price_type = "fixed"; } else { $price_type = $o->getData('price_type'); }
								if($o->getData('price')=="") { $price = "0.0000"; } else { $price = $o->getData('price'); }
								if($o->getData('sku')=="") { $sku = " "; } else { $sku = $o->getData('sku'); }
								if($o->getData('sort_order')=="") { $sort_order = "0"; } else { $sort_order = $o->getData('sort_order'); }
								if($o->getData('max_characters')=="") { $max_characters = "0"; } else { $max_characters = $o->getData('max_characters'); }
								
				$customoptionvalues .= $o->getData('title') . ":" . $price_type . ":" . $price . ":" . $sku . ":" . $sort_order . ":" . $max_characters . "|";
							}
							$row[$customoptionstitle] = substr_replace($customoptionvalues,"",-1);
						}
						
				if($this->getVar('export_category_paths') == "true") {
					unset($row["category_ids"]);
				}
            $batchExport = $this->getBatchExportModel()
                ->setId(null)
                ->setBatchId($this->getBatchModel()->getId())
                ->setBatchData($row)
                ->setStatus(1)
                ->save();
	}
    /**
     * Unparse (prepare data) loaded products
     *
     * @return Mage_Catalog_Model_Convert_Parser_Product
     */
    public function unparse()
    {
	 	$recordlimitstart = $this->getVar('recordlimitstart');
		$recordlimitend = $this->getVar('recordlimitend');
		$prefix = Mage::getConfig()->getNode('global/resources/db/table_prefix'); 
		$read = Mage::getSingleton('core/resource')->getConnection('core_read');
		$overallcount = 1;
	    #array_reverse($entityIds);
	    if($this->getVar('export_filter_by_manufacturer') != "") {	
		
			if($this->getVar('export_filter_by_code') != "") { $attribute_code = $this->getVar('export_filter_by_code'); } else { $filter_attribute_code = "manufacturer"; }
			
			$product_brand = $this->getVar('export_filter_by_manufacturer');
			  
			$entityIds = Mage::getModel('catalog/product')->getCollection();
			$entityIds->addAttributeToSelect($attribute_code);
			$entityIds->addFieldToFilter(array(array('attribute'=>$attribute_code,'eq'=> Mage::getResourceModel('catalog/product')
							->getAttribute($attribute_code)
							->getSource()
							->getOptionId(trim($product_brand)))));
		} else {
       		$entityIds = $this->getData();
		}
		
        foreach ($entityIds as $i => $dataentityId) {
		
			if(is_array($dataentityId) || is_object($dataentityId)) {
				$entityId = $dataentityId['entity_id'];
			} else {
				$entityId = $dataentityId;
			}
			
			if ($overallcount < $recordlimitend && $overallcount >= $recordlimitstart) {
			
				if($this->getVar('export_multi_store') == "true") {	
						
					if ($this->getStore()->getCode() == Mage_Core_Model_Store::ADMIN_CODE) {
							
						$allproduct = $this->getProductModel()->setData(array())->load($entityId);
						$final_webids = $allproduct->getWebsiteIds();
						$solid = array_unshift($final_webids, "0"); // ADD ADMIN VIEW END
						
						foreach ($final_webids as $websiteId) {
						
							$websiteCode = Mage::app()->getWebsite($websiteId)->getCode();
							if($websiteCode == "admin") { $websiteCode = "base"; }
							$allstoreids = Mage::app()->getWebsite($websiteId)->getStoreIds();
							
							foreach ($allstoreids as $storeId) {
							
								$productModel = $this->getProductModel()
												->reset()
												->setStoreId($storeId)
												->load($entityId);
												
								$this->setProductTypeInstance($productModel);
								$this->exportProductData($productModel, $this->getVar('export_multi_store'), $i, $read, $prefix, $websiteCode);
							}
							$overallcount+=1;
						}
							
					} else { $overallcount+=1; }
					
					
				} else {
				
					$product = $this->getProductModel()
						->reset()
						->setStoreId($this->getStoreId())
						->load($entityId);
					$this->setProductTypeInstance($product);
					/* @var $product Mage_Catalog_Model_Product */
					$this->exportProductData($product, $this->getVar('export_multi_store'), $i, $read, $prefix);	
				
				}
				
			}#ends check on count of orders being exported
			$overallcount+=1;
        }
		
		
        return $this;
    }

    /**
     * Retrieve accessible external product attributes
     *
     * @return array
     */
   public function getExternalAttributes()
    {
        $entityTypeId = Mage::getSingleton('eav/config')->getEntityType('catalog_product')->getId();
        $productAttributes = Mage::getResourceModel('catalog/product_attribute_collection')
            ->load();

        $attributes = $this->_externalFields;

        foreach ($productAttributes as $attr) {
            $code = $attr->getAttributeCode();
            if (in_array($code, $this->_internalFields) || $attr->getFrontendInput() == 'hidden') {
                continue;
            }
            $attributes[$code] = $code;
        }

        foreach ($this->_inventoryFields as $field) {
            $attributes[$field] = $field;
        }

        return $attributes;
    }
}