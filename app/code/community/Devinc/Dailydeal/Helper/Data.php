<?php

class Devinc_Dailydeal_Helper_Data extends Mage_Core_Helper_Abstract
{
	const STATUS_RUNNING = Devinc_Dailydeal_Model_Source_Status::STATUS_RUNNING;
	const STATUS_DISABLED = Devinc_Dailydeal_Model_Source_Status::STATUS_DISABLED;
	const STATUS_ENDED = Devinc_Dailydeal_Model_Source_Status::STATUS_ENDED;
	const STATUS_QUEUED = Devinc_Dailydeal_Model_Source_Status::STATUS_QUEUED;
	
	//check if extension is enabled
	public static function isEnabled()
	{
		$storeId = Mage::app()->getStore()->getId();
		$isModuleEnabled = Mage::getStoreConfig('advanced/modules_disable_output/Devinc_Dailydeal', $storeId);
		$isEnabled = Mage::getStoreConfig('dailydeal/configuration/enabled', $storeId);
		return ($isModuleEnabled == 0 && $isEnabled == 1);
	}
	
	//$toDate format(year-month-day hour:minute:second) = 0000-00-00 00:00:00
    public function getCountdown($_product, $finished = false)
    {
    	$toDate = $_product->getDatetimeTo();
    	$countdownId = $_product->getId();
		$randomNr = rand(10e16, 10e20);

    	//from/to date variables
		$fromDate = $this->getCurrentDateTime();
		$jsFromDate = date('F d, Y H:i:s', strtotime($fromDate));
		$jsToDate = date('F d, Y H:i:s', strtotime($toDate));			
		if ($finished) {
			$toDate = $fromDate;
			$jsToDate = $jsFromDate;	
		}	
		
		$countdownType = Mage::getStoreConfig('dailydeal/configuration/countdown_type');

		//cirle countdown configuration		
		if ($countdownType==0) {
			$bgColor = (Mage::getStoreConfig('dailydeal/circle_countdown/bg_color')) ? $this->hex2rgb(Mage::getStoreConfig('dailydeal/circle_countdown/bg_color')) : '192, 202, 202';
			$loadingColor = (Mage::getStoreConfig('dailydeal/circle_countdown/loading_color')) ? $this->hex2rgb(Mage::getStoreConfig('dailydeal/circle_countdown/loading_color')) : '229, 233, 233';
			$daysText = Mage::getStoreConfig('dailydeal/circle_countdown/days_text');
			$hourText = Mage::getStoreConfig('dailydeal/circle_countdown/hour_text');
			$minText = Mage::getStoreConfig('dailydeal/circle_countdown/min_text');
			$secText = Mage::getStoreConfig('dailydeal/circle_countdown/sec_text');
		} elseif ($countdownType==1) {
			$daysText = Mage::getStoreConfig('dailydeal/flip_countdown/days_text');
			$hourText = Mage::getStoreConfig('dailydeal/flip_countdown/hour_text');
			$minText = Mage::getStoreConfig('dailydeal/flip_countdown/min_text');
			$secText = Mage::getStoreConfig('dailydeal/flip_countdown/sec_text');
		} elseif ($countdownType==2) {
			$daysText = Mage::getStoreConfig('dailydeal/simple_countdown/days_text');
			$hourText = Mage::getStoreConfig('dailydeal/simple_countdown/hour_text');
			$minText = Mage::getStoreConfig('dailydeal/simple_countdown/min_text');
			$secText = Mage::getStoreConfig('dailydeal/simple_countdown/sec_text');
		}
		
		$date1 = strtotime($fromDate);
	    $date2 = strtotime($toDate);	   
		$dateDiff = $date2 - $date1;
		$days = floor($dateDiff/(60*60*24));

		if ($countdownType==0) {
			if ($days>0) {
				$size = '50';
				$daysClass = ' countdown-days';
				$layout = '<ul>'.
				'{d<}<li class="days"><em>{dn}</em> '.$daysText.'</li>{d>}'.
				'{h<}<li class="hours"><em>{hn}</em> '.$hourText.'</li>{h>}'.
				'{m<}<li class="minutes"><em>{mn}</em> '.$minText.'</li>{m>}'.
				'{s<}<li class="seconds"><em>{sn}</em> '.$secText.'</li>{s>}'.
				'</ul>';
			} else {
				$size = '60';
				$daysClass = '';				
				$layout = '<ul>'.
				'{h<}<li class="hours"><em>{hn}</em> '.$hourText.'</li>{h>}'.
				'{m<}<li class="minutes"><em>{mn}</em> '.$minText.'</li>{m>}'.
				'{s<}<li class="seconds"><em>{sn}</em> '.$secText.'</li>{s>}'.
				'</ul>';
			}
			$html = '
				<div class="countdown'.$daysClass.'">
					<div id="countdown-'.$countdownId.'-'.$randomNr.'-timer" class="countdown_timer"></div>			                
				    <div id="countdown-'.$countdownId.'-'.$randomNr.'" class="countdown_clock">';
				    if ($days>0) {             
				        $html .= '<canvas class="circular_countdown_element" id="circular_countdown_days-'.$countdownId.'-'.$randomNr.'" width="'.$size.'" height="'.$size.'"></canvas>';
				    }

			  $html .= '<canvas class="circular_countdown_element" id="circular_countdown_hours-'.$countdownId.'-'.$randomNr.'" width="'.$size.'" height="'.$size.'"></canvas>
				        <canvas class="circular_countdown_element" id="circular_countdown_minutes-'.$countdownId.'-'.$randomNr.'" width="'.$size.'" height="'.$size.'"></canvas>
				        <canvas class="circular_countdown_element last" id="circular_countdown_seconds-'.$countdownId.'-'.$randomNr.'" width="'.$size.'" height="'.$size.'"></canvas>
				    </div>
				</div>';

			$html .= '<script type="text/javascript">
						jQueryDD(document).ready(function($){
						    jQueryDD(\'#countdown-'.$countdownId.'-'.$randomNr.'\').circularCountdown({
						        strokeDaysBackgroundColor:\'rgba('.$loadingColor.',1)\',
						        strokeDaysColor:\'rgba('.$bgColor.',1)\',
						        strokeHoursBackgroundColor:\'rgba('.$loadingColor.',1)\',
						        strokeHoursColor:\'rgba('.$bgColor.',1)\',
						        strokeMinutesBackgroundColor:\'rgba('.$loadingColor.',1)\',
						        strokeMinutesColor:\'rgba('.$bgColor.',1)\',
						        strokeSecondsBackgroundColor:\'rgba('.$loadingColor.',1)\',
						        strokeSecondsColor:\'rgba('.$bgColor.',1)\',
						        strokeWidth:6,
						        strokeBackgroundWidth:6,
						        countdownEasing:\'easeOutBounce\',
						        countdownTickSpeed:\'slow\',
						        currentDateTime: \''.$jsFromDate.'\',
						        until: new Date(\''.$jsToDate.'\'),
						        layout: \''.$layout.'\',
						        id: \''.$countdownId.'-'.$randomNr.'\'
						    });
						});
					</script>';
		} elseif ($countdownType==1) {
			$countdownToDateTime = explode(' ', $toDate);
			$countdownToDate = $countdownToDateTime[0];
			$countdownToTime = $countdownToDateTime[1];

			if ($days>0) {
				$html = '<div class="countdown countdown-days" id="countdown-'.$countdownId.'-'.$randomNr.'">
				<div class="unit-wrap">
					<div class="days"></div>
					<span class="ce-days-label"></span>
				</div>';
			} else {
				$html = '<div class="countdown" id="countdown-'.$countdownId.'-'.$randomNr.'">';
			}

			$html .= '<div class="unit-wrap">
					<div class="hours"></div>
					<span class="ce-hours-label"></span>
				</div>
				<div class="unit-wrap">
					<div class="minutes"></div>
					<span class="ce-minutes-label"></span>
				</div>
				<div class="unit-wrap">
					<div class="seconds"></div>
					<span class="ce-seconds-label"></span>
				</div>
			</div>';
			
			$html .= '<script type="text/javascript">
				 			runCountdown(\'countdown-'.$countdownId.'-'.$randomNr.'\',\''.$countdownToDate.'\',\''.$countdownToTime.'\',\''.$jsFromDate.'\',\''.$daysText.'\',\''.$hourText.'\',\''.$minText.'\',\''.$secText.'\');
				 		</script>';
		} else {
			if ($days>0) {
				$html = '<div class="countdown countdown-days" id="countdown-'.$countdownId.'-'.$randomNr.'">
								<div class="days">
				                    <span class="digits">42</span>
				                    <span class="label">'.$daysText.'</span>
				                </div>
				                <span class="sep days-sep">•</span>';
			} else {
				$html = '<div class="countdown" id="countdown-'.$countdownId.'-'.$randomNr.'">';
			}
			
			$html .= '<div class="hours">
		                    <span class="digits">11</span>
		                    <span class="label">'.$hourText.'</span>
		                </div>
		                <span class="sep">•</span>
		                <div class="minutes">
		                    <span class="digits">48</span>
		                    <span class="label">'.$minText.'</span>
		                </div>
		                <span class="sep">•</span>
		                <div class="seconds">
		                    <span class="digits">46</span>
		                    <span class="label">'.$secText.'</span>
		                </div>
			        </div>';

			$html .= '<script type="text/javascript">
				 			var jsCountdown = new JsCountdown("'.$jsFromDate.'", "'.$jsToDate.'", "countdown-'.$countdownId.'-'.$randomNr.'");
				 		</script>';
		}
	
        return $html;
    }
        
    //called on product list pages
    public function getProductCountdown(Varien_Object $_product, $_timeLeftText=false) {
		$deal = $this->getDealByProduct($_product);
		$html = '';		
		if (Mage::helper('dailydeal')->isEnabled() && $deal) {		
			$toDate = $deal->getDatetimeTo();
			$_product->setDatetimeTo($toDate);
			$currentDateTime = Mage::helper('dailydeal')->getCurrentDateTime(0);
			//set it to finished if the deal's time is up or product is out of stock
			if ($currentDateTime>=$deal->getDatetimeFrom() && $currentDateTime<=$deal->getDatetimeTo()) {
    			$finished = ($_product->isSaleable()) ? false : true;
    		} else {
				Mage::getModel('dailydeal/dailydeal')->refreshDeal($deal);
    			$finished = true;
    		}
    		$html .= ($_timeLeftText) ? '<span class="countdown-time-left">'.$this->__('Time left to buy').'</span>' : '';
			$html .= $this->getCountdown($_product, $finished);
		}
				
		return $html;
    }
	
	public function getCurrentDateTime($_storeId = null, $_format = 'Y-m-d H:i:s') {
		if (is_null($_storeId)) {
			$_storeId = Mage::app()->getStore()->getId();
		}
		$storeDatetime = new DateTime();
		$storeDatetime->setTimezone(new DateTimeZone(Mage::getStoreConfig('general/locale/timezone', $_storeId)));	
		
		return $storeDatetime->format($_format);
	}
	
	//returns the page number for the "Select a Product" tab on the deal edit page
    public function getProductPage($productId)
    {
    	$visibility = array(2, 4);
    	$collectionSize = Mage::getModel('catalog/product')->getCollection()->setOrder('entity_id', 'DESC')->addAttributeToFilter('visibility', $visibility)->addAttributeToFilter('entity_id', array('gteq' => $productId))->getSize();
    	
    	return ceil($collectionSize/20);
    }
    
    public function getMagentoVersion() {
		return (int)str_replace(".", "", Mage::getVersion());
    }
    
    //return true if deal should run on store
    public function runOnStore(Varien_Object $_deal, $_storeId = false) {
    	if ($_deal->getStores()!='') {
    		$dealStoreIds = array();
    		if (strpos($_deal->getStores(), ',')) {
				$dealStoreIds = explode(',', $_deal->getStores());
			} else {
				$dealStoreIds[] = $_deal->getStores();
			}
			if (!$_storeId) {
    			$_storeId = Mage::app()->getStore()->getId();
    		}
    		return (in_array($_storeId, $dealStoreIds)) ? true : false;
    	}
    	
    	return false;
    }
    
    //returns the main running deal of the current store
    public function getDeal($_excludeProductIds = array(0)) {  		    	
		$dealCollection = Mage::getModel('dailydeal/dailydeal')->getCollection()->addFieldToFilter('product_id', array('nin'=>$_excludeProductIds))->addFieldToFilter('status', array('eq'=>self::STATUS_RUNNING))->setOrder('position', 'ASC')->setOrder('dailydeal_id', 'DESC');	
			
		if (count($dealCollection)) {
	        foreach ($dealCollection as $deal) {
    	    	if ($this->runOnStore($deal)) {
		    		return $deal;
		    	}
		    }
		}	
		
		return false;	
    }
    
    //if the product is a deal and the deal is running under the current store, returns the deal data
    public function getDealByProduct(Varien_Object $_product) {  		    	
		$dealCollection = Mage::getModel('dailydeal/dailydeal')->getCollection()->addFieldToFilter('product_id', array('eq'=>$_product->getId()))->addFieldToFilter('status', array('eq'=>self::STATUS_RUNNING))->setOrder('position', 'ASC')->setOrder('dailydeal_id', 'DESC');
				
		if (count($dealCollection)) {
	        foreach ($dealCollection as $deal) {
    	    	if ($this->runOnStore($deal)) {
		    		return $deal;
		    	}
		    }
		}	
		
		return false;	
    }
    
    public function getDealsByProductIds($_productIds) {  		    	
		$dealCollection = Mage::getModel('dailydeal/dailydeal')->getCollection()->addFieldToFilter('product_id', array('in'=>$_productIds))->addFieldToFilter('status', array('eq'=>self::STATUS_RUNNING))->setOrder('position', 'ASC')->setOrder('dailydeal_id', 'DESC');
				
		if (count($dealCollection)) {
	        foreach ($dealCollection as $key=>$deal) {
    	    	if (!$this->runOnStore($deal)) {
		    		$dealCollection->removeItemByKey($key);
		    	}
		    }
		}	
		
		return $dealCollection;	
    }
    
    public function hex2rgb($hex) {
        return Mage::getModel('license/module')->hex2rgb($hex);
    }
    
    public function isMobile()
    {           
        if (Mage::getModel('license/module')->isMobile()) {
            return true;
        }
        
        return false;
    }    
    
    public function isTablet()
    {           
        if (Mage::getModel('license/module')->isTablet()) {
            return true;
        }
        
        return false;
    }  
    
}