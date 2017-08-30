<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Helper_Retina extends Mage_Core_Helper_Abstract
{
 
	public function getRetinaData ($data, $_item=0, $_itemparameter=0) {

 		$helpImg = MAGE::helper('ThemeOptionsBizarre/images');

 		if (Mage::getStoreConfig('meigee_bizarre_general/retina/status')) {
			$general = MAGE::helper('ThemeOptionsBizarre')->getThemeOptionsBizarre('meigee_bizarre_general');
			$customlogo = $general['customlogo'];
			
			$html ='';
			switch ($data) {
				case 'logo':
					$html = 'data-srcX2="' . Mage::getDesign()->getSkinUrl('images/@x2/logo@x2.png') . '"';
				break;
				case 'logo_custom':
    				$mediaurl = MAGE::helper('ThemeOptionsBizarre')->getThemeOptionsBizarre('mediaurl');
					$html = 'data-srcX2="' . $mediaurl.$customlogo['logo'] . '"';
				break;
				case 'small_logo':
					$html = 'data-srcX2="' . Mage::getDesign()->getSkinUrl('images/@x2/small_logo@x2.png') . '"';
				break;
				case 'small_logo_custom':
    				$mediaurl = MAGE::helper('ThemeOptionsBizarre')->getThemeOptionsBizarre('mediaurl');
					$html = 'data-srcX2="' . $mediaurl.$customlogo['small_logo_retina'] . '"';
				break;
				default:
					# code...
					break;
			}
			return $html;
		}
		else return false;
	}

}