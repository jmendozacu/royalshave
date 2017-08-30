<?php
class IWD_Productvideo_Block_Frontend_Media extends Mage_Catalog_Block_Product_View_Media
{
    public function getGalleryImages()
    {
        $collection = parent::getGalleryImages();

        if (empty($collection) || $collection->getSize() == 0) {
            $productMediaConfig = Mage::getModel('catalog/product_media_config');
            $image = $this->getProduct()->getImage();

            if ($image != 'no_selection') {
                $img['url'] = $productMediaConfig->getMediaUrl($image);
                $img['id'] = null;
                $img['path'] = $productMediaConfig->getMediaPath($image);
                $collection = new Varien_Data_Collection();
                $collection->addItem(new Varien_Object($img));
            }
        }

        return $collection;
    }
}
