<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Adminhtml_ImageController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog/amcustomerimg')
            ->_addBreadcrumb(Mage::helper('amcustomerimg')->__('Catalog'), Mage::helper('amcustomerimg')->__('Catalog'))
            ->_addBreadcrumb(Mage::helper('amcustomerimg')->__('Customer Images'), Mage::helper('amcustomerimg')->__('Customer Images'))
        ;
        return $this;
    }
    
    protected function _approveImage($imageId)
    {
        $imageModel     = Mage::getModel('amcustomerimg/image')->load($imageId);
        $sendToMain     = Mage::app()->getRequest()->getParam('main', 0);
        $sendToSeparate = Mage::app()->getRequest()->getParam('separate', 0);
        
        if (!$imageModel->getId())
        {
            $this->_getSession()->addError($this->__('Invalid image.'));
            $this->_redirect('*/*/');
            return ;
        }
        
        $product = Mage::getModel('catalog/product')->load($imageModel->getProductId());
        if (!$product->getId())
        {
            $this->_getSession()->addError($this->__('Product does not exist.'));
            $this->_redirect('*/*/');
            return ;
        }
        
        if ($sendToMain && !$imageModel->getShownInProduct())
        {
            $mediaGallery = $product->getMediaGallery();
            $result       = unserialize($imageModel->getFileDataSerialized());
            $mediaGallery['images'][] = array(
                'file'     => $result['file'],
                'url'      => $result['url'],
                'label'    => $imageModel->getTitle(),
                'disabled' => 0,
                'removed'  => 0,
                'position' => count($mediaGallery['images']) + 1,
            );
            $product->setMediaGallery($mediaGallery);
            $product->save();
            
            $imageModel->setShownInProduct(1);
        }
        
        if ($sendToSeparate && !$imageModel->getShownInSeparate())
        {
            $result = unserialize($imageModel->getFileDataSerialized());
            Mage::helper('amcustomerimg/image')->makeSeparateBlockImage($result, $imageModel->getStoreId());
            
            $imageModel->setShownInSeparate(1);
        }
        
        $imageModel->approve();
    }
    
    protected function _declineImage($imageId)
    {
        $imageModel = Mage::getModel('amcustomerimg/image')->load($imageId);
        if ($imageModel->getId())
        {
            $imageModel->decline();
        }
    }
    
    public function indexAction()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('amcustomerimg/adminhtml_image'))
            ->renderLayout();
    }
    
    public function editAction()
    {
        $this->_title($this->__('Customer Product Images'))->_title($this->__('Edit Image'));
        
        $id    = $this->getRequest()->getParam('id');
        $model = Mage::getModel('amcustomerimg/image');
        if ($id) 
        {
            $model->load($id);
            if (!$model->getId()) 
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('amcustomerimg')->__('This image no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        
        // Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) 
        {
            $model->setData($data);
        }
        
        Mage::register('amcustomerimg_image', $model);

        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('amcustomerimg/adminhtml_image_edit'))
            ->_addLeft($this->getLayout()->createBlock('amcustomerimg/adminhtml_image_edit_tabs'))
            ->renderLayout();
    }
    
    public function validateAction()
    {
        
    }
    
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) 
        {
            $id = $this->getRequest()->getParam('id');
            $model  = Mage::getModel('amcustomerimg/image');
            if ($id) 
            {
                $model->load($id);
            }
            $model->addData($data);
            try 
            {
                $model->save();
                $id = $model->getId();
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('amcustomerimg')->__('The image has been saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                
                $this->_redirect('*/*/');
                return;
                
            } catch (Exception $e) 
            {
                $this->_getSession()->addException($e, Mage::helper('amcustomerimg')->__('An error occurred while saving the image: ') . $e->getMessage());
            }
            
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $id));
            return;
        }
        $this->_redirect('*/*/');
    }
    
    public function approveAction()
    {
        $imageId        = Mage::app()->getRequest()->getParam('id');
        try {
            $this->_approveImage($imageId);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('amcustomerimg')->__('Image approved.'));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    }
    
    public function declineAction()
    {
        $imageId        = Mage::app()->getRequest()->getParam('id');
        try {
            $this->_declineImage($imageId);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('amcustomerimg')->__('Image declined.'));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    } 
    
    public function massApproveAction()
    {
        $imageIds = Mage::app()->getRequest()->getParam('image');
		foreach ($imageIds as $imageId)
		{
			try {
				$this->_approveImage($imageId);
			} catch (Mage_Core_Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			} catch (Exception $e) {
				Mage::logException($e);
				$this->_getSession()->addError($e->getMessage());
			}
		}
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('amcustomerimg')->__('Images approved.'));
        $this->_redirect('*/*/');
    }
    
    public function massDeclineAction()
    {
        $imageIds = Mage::app()->getRequest()->getParam('image');
		foreach ($imageIds as $imageId)
		{
			try {
		        $this->_declineImage($imageId);
			} catch (Mage_Core_Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			} catch (Exception $e) {
				Mage::logException($e);
				$this->_getSession()->addError($e->getMessage());
			}
		}
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('amcustomerimg')->__('Images declined.'));
        $this->_redirect('*/*/');
    }
    
    protected function _deleteImage($imageId)
    {
        $imageModel = Mage::getModel('amcustomerimg/image')->load($imageId);
        if ($imageModel->getId())
        {
            $imageModel->delete();
        }
    }

    public function deleteAction()
    {
        $imageId = Mage::app()->getRequest()->getParam('id');
        try {
            $this->_deleteImage($imageId);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('amcustomerimg')->__('Image deleted.'));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    } 
	
    public function massDeleteAction()
    {
        $imageIds = Mage::app()->getRequest()->getParam('image');
		foreach ($imageIds as $imageId)
		{
			try {
		        $this->_deleteImage($imageId);
			} catch (Mage_Core_Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			} catch (Exception $e) {
				Mage::logException($e);
				$this->_getSession()->addError($e->getMessage());
			}
		}
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('amcustomerimg')->__('Images deleted.'));
        $this->_redirect('*/*/');
    }

}