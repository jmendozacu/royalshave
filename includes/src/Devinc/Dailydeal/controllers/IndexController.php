<?php
class Devinc_Dailydeal_IndexController extends Mage_Core_Controller_Front_Action
{	 
    public function indexAction()
    {       
        $helper = Mage::helper('dailydeal');
		$storeId = Mage::app()->getStore()->getId();
		
		if ($helper->isEnabled()) {
			//Mage::getModel('dailydeal/dailydeal')->refreshDeals();
        	if ($mainDeal = $helper->getDeal()) {
        	    $product = Mage::getModel('catalog/product')->setStore($storeId)->load($mainDeal->getProductId());	
        	    $product->setDoNotUseCategoryId(true);
        	    
        	    $this->_redirectUrl($product->getProductUrl());
        	    return;		
        	} else {	
				if (Mage::getStoreConfig('dailydeal/configuration/notify')) {	
					$subject = Mage::helper('dailydeal')->__('There are no deals setup at the moment.');
					$content = Mage::helper('dailydeal')->__('A customer tried to view the deals page.');
					$replyTo = Mage::getStoreConfig('trans_email/ident_general/email', $storeId);
							
					$mail = new Zend_Mail();
					$mail->setBodyHtml($content);
					$mail->setFrom($replyTo);
					$mail->addTo(Mage::getStoreConfig('dailydeal/configuration/admin_email'));
					$mail->setSubject($subject);	
					$mail->send();
				}
				$this->_redirect('dailydeal/index/list');
			}
        } else {
			$this->_redirect('no-route');		
		}
    }
	
	public function listAction()
    {      
   		if (Mage::helper('dailydeal')->isEnabled()) {
			//Mage::getModel('dailydeal/dailydeal')->refreshDeals();
			$this->loadLayout();	
			if (Mage::helper('dailydeal')->getMagentoVersion()>1411 && Mage::helper('dailydeal')->getMagentoVersion()<1800) {	
				$this->initLayoutMessages(array('catalog/session', 'checkout/session'));
			}
			$this->renderLayout();      
		} else {
			$this->_redirect('no-route');		
		}
    }
	
	public function recentAction()
    {      
        if (Mage::helper('dailydeal')->isEnabled() && Mage::getStoreConfig('dailydeal/configuration/past_deals')) {
			//Mage::getModel('dailydeal/dailydeal')->refreshDeals();
			$this->loadLayout();	
			if (Mage::helper('dailydeal')->getMagentoVersion()>1411 && Mage::helper('dailydeal')->getMagentoVersion()<1800) {	
				$this->initLayoutMessages(array('catalog/session', 'checkout/session'));
			}
			$this->renderLayout(); 
		} else {
			$this->_redirect('no-route');		
		}
    }
}