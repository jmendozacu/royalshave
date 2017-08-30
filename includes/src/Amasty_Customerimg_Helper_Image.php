<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Helper_Image extends Mage_Core_Helper_Abstract
{
    const THUMB_X = 100;
    const THUMB_Y = 75;
    
    protected $_imagePath      = '/catalog/product/customerimg';
    protected $_imageThumbPath = '/catalog/product/customerimg/thumb';
    
    public function cleanupImage($image)
    {
        $files = array();

        $files[]= $this->getImagePath() . $image;
        $files[]= $this->getImageThumbPath() . $image;
        
        $width     = ($x ? $x : Mage::getStoreConfig('amcustomerimg/image/lightbox_x'));
        $height    = ($y ? $y : Mage::getStoreConfig('amcustomerimg/image/lightbox_y'));
        $sizeFolder  = '/' . $width . 'x' . $height;

        $files[]= $this->getImagePath() . $sizeFolder . $image;

        $width     = Mage::getStoreConfig('amcustomerimg/image/size_x');
        $height    = Mage::getStoreConfig('amcustomerimg/image/size_y');
        $sizeFolder  = '/' . $width . 'x' . $height;

        $files[]= $this->getImagePath() . $sizeFolder . $image;

        foreach ($files as $file)
        {
            if (file_exists($file))
                unlink ($file);
        }
    }
	
    public function getImagePath()
    {
        return Mage::getBaseDir('media') . $this->_imagePath;
    }
    
    public function getImageThumbPath()
    {
        return Mage::getBaseDir('media') . $this->_imageThumbPath;
    }
    
    public function copyTempProductImage($image)
    {
        $source = $image['path'] . $image['file'];
        $dest   = $this->getImagePath() . $image['file'];
        
        $destDir = dirname($dest); 
        if (!is_dir($destDir))
        {
            @mkdir($destDir, 0777, true);
        }
        
        @copy($source, $dest);
    }
    
    public function makeThumbnail($image)
    {
        $file      = $image['path'] . $image['file'];
        $processor = new Varien_Image($file);
        $processor->keepAspectRatio(true);
        $processor->keepTransparency(true);
        $processor->resize(self::THUMB_X, self::THUMB_Y);
        $destination = $this->getImageThumbPath() . $image['file'];
        $processor->save($destination);
    }
    
    public function getThumbUrl($file)
    {
        $url = Mage::getBaseUrl('media') . $this->_imageThumbPath . $file;
        return $url;
    }
    
    public function makeSeparateBlockImage($image, $storeId, $x = 0, $y = 0)
    {
        $file      = $this->getImagePath() . $image['file'];
        $width     = ($x ? $x : Mage::getStoreConfig('amcustomerimg/image/size_x', $storeId));
        $height    = ($y ? $y : Mage::getStoreConfig('amcustomerimg/image/size_y', $storeId));
        $processor = new Varien_Image($file);
        $processor->keepAspectRatio(true);
        $processor->keepTransparency(true);
        $processor->resize($width, $height);
        $sizeFolder  = '/' . $width . 'x' . $height;
        $destination = $this->getImagePath() . $sizeFolder . $image['file'];
        $processor->save($destination);
    }
    
    public function getSeparateThumbUrl($image)
    {
        $width     = Mage::getStoreConfig('amcustomerimg/image/size_x');
        $height    = Mage::getStoreConfig('amcustomerimg/image/size_y');
        $sizeFolder  = '/' . $width . 'x' . $height;
        if (!file_exists($this->getImagePath() . $sizeFolder . $image['file']))
        {
            $this->makeSeparateBlockImage($image, Mage::app()->getStore()->getId());
        }
        return Mage::getBaseUrl('media') . $this->_imagePath . $sizeFolder . $image['file'];
    }
    
    public function getSeparateUrl($image)
    {
        $width     = Mage::getStoreConfig('amcustomerimg/image/lightbox_x');
        $height    = Mage::getStoreConfig('amcustomerimg/image/lightbox_y');
        $sizeFolder  = '/' . $width . 'x' . $height;
        if (!file_exists($this->getImagePath() . $sizeFolder . $image['file']))
        {
            $this->makeSeparateBlockImage($image, Mage::app()->getStore()->getId(), $width, $height);
        }
        return Mage::getBaseUrl('media') . $this->_imagePath . $sizeFolder . $image['file'];
    }
    
    
    
}