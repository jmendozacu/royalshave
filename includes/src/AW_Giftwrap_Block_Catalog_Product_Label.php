<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This software is designed to work with Magento community edition and
 * its use on an edition other than specified is prohibited. aheadWorks does not
 * provide extension support in case of incorrect edition use.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Giftwrap
 * @version    1.1.1
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


class AW_Giftwrap_Block_Catalog_Product_Label extends Mage_Core_Block_Template
{
    public  function isCanShow()
    {
        $configHelper = Mage::helper('aw_giftwrap/config');
        if (!$configHelper->isEnabled()) {
            return false;
        }
        $product = $this->getProduct();
        if (is_null($product)) {
            return false;
        }
        if (!Mage::helper('aw_giftwrap')->isValidProduct($product)) {
            return false;
        }
        return true;
    }

    /**
     * @return null|Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        $product = Mage::registry('current_product');
        if (!is_object($product)) {
            return null;
        }
        if (is_null($product->getId())) {
            return null;
        }
        return $product;
    }

}