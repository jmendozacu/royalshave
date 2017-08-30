<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright  Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Onepage controller for checkout
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */

require_once 'Mage/Checkout/controllers/OnepageController.php';
class Gsx_Globalshopex_OnepageController extends Mage_Checkout_OnepageController
{


    /**
     * Save checkout billing address
     */
    public function saveBillingAction()
    {   

        $mystring1 = Mage::helper('core/url')->getCurrentUrl();
        $findme1   = 'checkout/onepage';
        $pos1 = strpos($mystring1, $findme1);
        
         // var_dump($pos1);die;                       
        if($pos1 !== false) {
            //use module ms_address
            $address = Mage::helper('ms_addressverification')->getPostAddressAsObject('billing');
            $result = Mage::helper('ms_addressverification')->verifyAddress($address);

            if (empty($result['error'])) {
                if (isset($result['address'])) {
                    Mage::helper('ms_addressverification')->updatePostAddress($result['address'], 'billing');
                }

                parent::saveBillingAction();
            } else {
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result['error']));
            }
        }else {

            //use international shipping
            if ($this->_expireAjax()) {
                return;
            }
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost('billing', array());
                $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

                if (isset($data['email'])) {
                    $data['email'] = trim($data['email']);
                }
                $result = $this->getOnepage()->saveBilling($data, $customerAddressId);

                if (!isset($result['error'])) {
                    if ($this->getOnepage()->getQuote()->isVirtual()) {
                        $result['goto_section'] = 'payment';
                        $result['update_section'] = array(
                            'name' => 'payment-method',
                            'html' => $this->_getPaymentMethodsHtml()
                        );
                    } elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
                        $result['goto_section'] = 'shipping_method';
                        $result['update_section'] = array(
                            'name' => 'shipping-method',
                            'html' => $this->_getShippingMethodsHtml()
                        );

                        $result['allow_sections'] = array('shipping');
                        $result['duplicateBillingInfo'] = 'true';

                        // FAV
                        $checkParamExist = strrpos(strtolower($_SERVER['HTTP_REFERER']),'gsx') ;
                        if ($checkParamExist===false) {
                            $checkParamExist=false;
                        }else{
                            $checkParamExist=true;
                        }
                        $enabled = Mage::getStoreConfig("checkout/globalshopex/gsx_is_live");
                        $address = Mage::getSingleton('checkout/session')->getQuote()->getBillingAddress();
                        $countryId = $address->getCountryId();
                        if (($checkParamExist || ($enabled==0)) && $countryId != 'US'){
                            $result = $this->getResponseInternational();
                        }
                        // END FAV


                    } else {
                        $result['goto_section'] = 'shipping';
                    }
                }

                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));

            }
        }
    }

    /**
     * Shipping address save action
     */
    public function saveShippingAction()
    {
        $mystring1 = Mage::helper('core/url')->getCurrentUrl();
        $findme1   = 'checkout/onepage';
        $pos1 = strpos($mystring1, $findme1);
                                
        if($pos1 !== false) {
            //use module ms_address
            $address = Mage::helper('ms_addressverification')->getPostAddressAsObject('shipping');
            $result = Mage::helper('ms_addressverification')->verifyAddress($address);

            if (empty($result['error'])) {
                if (isset($result['address'])) {
                    Mage::helper('ms_addressverification')->updatePostAddress($result['address'], 'shipping');
                }

                parent::saveShippingAction();
            } else {
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result['error']));
            }
        }else {
            //use international shipping
            if ($this->_expireAjax()) {
                return;
            }
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost('shipping', array());
                $customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);
                $result = $this->getOnepage()->saveShipping($data, $customerAddressId);

                if (!isset($result['error'])) {
                    $result['goto_section'] = 'shipping_method';
                    $result['update_section'] = array(
                        'name' => 'shipping-method',
                        'html' => $this->_getShippingMethodsHtml()
                    );
                }

                // FAV
                $checkParamExist = strrpos(strtolower($_SERVER['HTTP_REFERER']),'gsx') ;
                if ($checkParamExist===false) {
                    $checkParamExist=false;
                }else{
                    $checkParamExist=true;
                }
                $enabled = Mage::getStoreConfig("checkout/globalshopex/gsx_is_live");
                $address = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress();
                $countryId = $address->getCountryId();
                if (($checkParamExist || ($enabled==0)) && $countryId != 'US'){
                    $result = $this->getResponseInternational();
                }
                // END FAV

                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
            }
        }
    }

    public function getResponseInternational()
    {
        $result = array();
        $url = "/index.php/GSXInternationalCheckout/GSX";
        $html = '';
        $html .= '<dl class="sp-methods"><a href="'.$url.'">Please wait while we redirect you to our International Checkout page...</a></dl>';
        $html .= '<script type="text/javascript">'."\n";
        $html .= '//<![CDATA[ '."\n";
        $html .= 'window.location="'.$url.'"; '."\n";
        $html .= '//]]>'."\n";
        $html .= '</script>';
        $result['goto_section'] = 'shipping_method';
        $result['update_section'] = array(
            'name' => 'shipping-method',
            'html' => $html
        );
        return $result;
    }

}
