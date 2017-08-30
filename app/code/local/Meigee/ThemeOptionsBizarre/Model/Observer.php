<?php
/**
 * Call actions after configuration is saved
 */
class Meigee_ThemeOptionsBizarre_Model_Observer
{
	/**
     * After any system config is saved
     */
	public function cssgenerate()
	{
		$section = Mage::app()->getRequest()->getParam('section');

		if ($section == 'meigee_bizarre_design' || $section == 'meigee_bizarre_design_skin1' || $section == 'meigee_bizarre_design_skin2' || $section == 'meigee_bizarre_design_skin3' || $section == 'meigee_bizarre_design_skin4' || $section == 'meigee_bizarre_design_skin5' || $section == 'meigee_bizarre_design_skin6')
		{
			Mage::getSingleton('ThemeOptionsBizarre/Cssgenerate')->saveCss();
			$response = Mage::app()->getFrontController()->getResponse();
			$response->sendResponse();
		}

	}
}
