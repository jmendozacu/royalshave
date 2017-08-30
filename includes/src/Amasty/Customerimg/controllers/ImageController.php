<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2012 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_ImageController extends Mage_Core_Controller_Front_Action
{
    
    public function uploadAction()
    {
        $customerSession = Mage::getSingleton('customer/session');
        if (!Mage::getStoreConfig('amcustomerimg/general/guest_enabled')){
            if (!$customerSession->isLoggedIn()) {
                $result = array(
                    'error'	  => true,
                    'message' => $this->__('Please log-in to upload images.'),
                );
                $this->getResponse()->setBody(Zend_Json::encode($result));
                return ;
            }
        }
        
        if ($customerSession->isLoggedIn()) {
                $idCustomer = $customerSession->getCustomer()->getId();
        }
        else {
            if ( 6 != strlen(Mage::app()->getRequest()->getParam('check1'))){
                $result = array(
                    'error'      => true,
                    'message' => $this->__('Please try to re-submit the form once again.'),
                );
                $this->getResponse()->setBody(Zend_Json::encode($result));
                return ;
            }
                
            if ( 3 > Mage::app()->getRequest()->getParam('check2')){
                $result = array(
                    'error'      => true,
                    'message' => $this->__('Please try to re-submit the form once again.'),
                );
                $this->getResponse()->setBody(Zend_Json::encode($result));
                return ;
            }
            
            $idCustomer = 0; 
        }
        
        $productId = Mage::app()->getRequest()->getParam('product_id');
        if (!$productId || !Mage::getModel('catalog/product')->load($productId)->getId())
        {
            $result = array(
                'error'	  => true,
                'message' => $this->__('Sorry, can not find a product requested. Please try to refresh product page.'),
            );
            $this->getResponse()->setBody(Zend_Json::encode($result));
            return ;
        }
        
        if (!isset($_FILES['image']) || !isset($_FILES['image']['error']))
        {
            $result = array(
                'error'	  => true,
                'message' => $this->__('No files specified. Please make sure you have selected at least one.'),
            );
            $this->getResponse()->setBody(Zend_Json::encode($result));
            return ;
        }
        
        $wasUploaded = false;
        if (is_array($_FILES['image']['error']) && !empty($_FILES['image']['error']))
        {
            foreach ($_FILES['image']['error'] as $error)
            {
                if (UPLOAD_ERR_OK == $error)
                {
                    $wasUploaded = true;
                    break;
                }
            }
        }
        
        if (!$wasUploaded)
        {
            $result = array(
                'error'	  => true,
                'message' => $this->__('No files were uploaded.'),
            );
            $this->getResponse()->setBody(Zend_Json::encode($result));
            return ;
        }
        
        $result = array(
            'success'	=> true,
            'message'	=> $this->__('Thank you! Your uploaded images will appear on the product page once approved by website administrator.'),
        );
        
        $titles = Mage::app()->getRequest()->getParam('title');
        $guestEmail = Mage::app()->getRequest()->getParam('guest_email');
        
        for ($i = 0; $i < count($_FILES['image']['error']); $i++)
        {
            if (UPLOAD_ERR_OK == $_FILES['image']['error'][$i])
            {
                try
                {
                    $uploader = new Varien_File_Uploader('image[' . $i . ']');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                    $uploader->addValidateCallback('catalog_product_image', Mage::helper('catalog/image'), 'validateUploadFile');
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $fileResult = $uploader->save(
                        Mage::getSingleton('catalog/product_media_config')->getBaseTmpMediaPath()
                    );
                    $fileResult['url']     = Mage::getSingleton('catalog/product_media_config')->getTmpMediaUrl($fileResult['file']);
                    $fileResult['tmpfile'] = $fileResult['file'] . '.tmp';
                    
                    Mage::helper('amcustomerimg/image')->copyTempProductImage($fileResult);
                    Mage::helper('amcustomerimg/image')->makeThumbnail($fileResult);
                    
                    // now will save image into the database
                    $data = array(
                        'customer_id'	       => $idCustomer,
                        'product_id'	       => $productId,
                        'store_id'			   => Mage::app()->getStore()->getId(),
                        'file'	               => $fileResult['file'],
                    	'title'				   => $titles[$i],
                        'file_data_serialized' => serialize($fileResult),
                        'status'		       => 'pending',
                        'decline_reason'	   => '',
                        'created_at'		   => date('Y-m-d H:i:s'),
                        'updated_at'		   => date('Y-m-d H:i:s'),
                        'is_rewarded'           => 0,
                        'guest_email'		   => $guestEmail,
                    );
                    Mage::getModel('amcustomerimg/image')->setData($data)->save();
                    
                } catch (Exception $e) {
                    $result = array(
                        'error'   => true,
                        'message' => $e->getMessage()
                    );
                }
            }
        }
        
        if (isset($result['success']))
        {
            Mage::helper('amcustomerimg')->notifyAdmin($productId);
        }
        
        $this->getResponse()->setBody(Zend_Json::encode($result));
    }
}