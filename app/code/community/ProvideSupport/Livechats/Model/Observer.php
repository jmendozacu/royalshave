<?php
require_once 'ErrorHandler.php';
require_once 'Main.php';
require_once 'Action.php';


class ProvideSupport_livechats_Model_Observer
{
    
    public $countPastCode;
    public $countFixedCode;
    
    public function startCmsHadler()
    {
        
        $cms_info_array = array(
            'Magento' => array(
                'Mage' => 'getVersion'
            ),
            'Wordpress' => array(
                'wp' => 'wp'
            )
        );
        
        
        foreach ($cms_info_array as $cms_name => $cms_data) {
            switch ($cms_name) {
                case 'Magento':
                    $cms    = array();
                    $module = array();
                    
                    $modules = array_keys((array) Mage::getConfig()->getNode('modules')->children());
                    
                    foreach ($modules as $mod) {
                        $module[$mod] = array(
                            'Version' => (string) Mage::getConfig()->getNode()->modules->{$mod}->version,
                            'Active' => Mage::getConfig()->getModuleConfig($mod)->is('active', 'true')
                        );
                    }
                    
                    foreach ($cms_data as $class => $method) {
                        if (method_exists($class, $method)) {
                            $cms[$cms_name] = Mage::getVersion();
                        }
                    }
                    
                    $update = Mage::app()->getLayout()->getUpdate();
                    $update->load(array(
                        'default',
                        'catalog_product_view'
                    ));
                    $xml = $update->asSimplexml();
                    $js  = $xml->xpath('//action[@method="addJs"]');
                    
                    foreach ($js as $key) {
                        $jsFile[] = (string) $key->script;
                    }
                    
                    $total_info = array(
                        'current_CMS' => $cms,
                        'install_Modules' => $module,
                        'current_Js_file' => $jsFile
                    );
                    break;
                
                default:
                    break;
                    
            }
        }
        
        $level           = 3;
        $ErrorController = new OrtusErrorHandler(false, $total_info, $level);
        
    }
    
    public function __construct()
    {
        //Get if Error
        $this->startCmsHadler();
        
        $this->provide  = Mage::getModel('livechats/livechats')->load(1)->getData('content');
        $this->view     = Zend_Json::decode($this->provide, Zend_Json::TYPE_OBJECT);
        $this->settings = Zend_Json::decode($this->view->settings, Zend_Json::TYPE_OBJECT);
        $this->pos      = !empty($this->settings->buttonLocation) && isset($this->settings->buttonLocation) ?  $this->settings->buttonLocation : '';
        $this->list    = !empty($this->settings->buttonAvailableMenusList[0]) && isset($this->settings->buttonLocation) ? $this->settings->buttonAvailableMenusList[0] : '' ;
        $this->helper   = Mage::helper('livechats/data');
        $this->helper->initCodePS($this->view);
        
        
      
        
        //Fatal error testing 
        //require('null');
        
    }
    public function insertBlock($observer)
    {
		
		if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
			/* Если пришел Ajax то пропускаем, вновь не отработал код */
		}else{ 
        
        if (Mage::app()->getLayout()->getArea() == 'frontend') {
            $_name = $observer->getBlock()->getNameInLayout();
            $_type = $observer->getBlock()->getType();
        
            if (isset($this->settings->pluginEnabled) && $this->settings->pluginEnabled) {
                if ($this->pos == 'fixed') {
                    if ($_name == 'root') {
                        $this->handler();
                    }
                } elseif ($this->pos == 'define') {
                    if ($_name == $this->list) {
                        $this->countPastCode = true; //1
                        $this->handler();
                    } else {
                        if ($_name == 'before_body_end' && !$this->countPastCode && $this->settings->buttonAvailableWhole) {
                            $this->helper->showModuleHiddenCode();
                            $this->countPastCode = true;
                        }
                    }
                }
            }
        }
	}
    }
    protected function handler()
    {
        $this->helper->initJs();
        if ($this->settings->buttonAvailableAll == false && $this->settings->buttonAvailablePost == false && $this->settings->buttonAvailableWhole == false) {
            //Nothing to display in fixed position
        } elseif ($this->settings->buttonAvailableAll == false && $this->settings->buttonAvailablePost == false && $this->settings->buttonAvailableWhole) {
            //Only display the hidden code
            if ($this->pos === 'fixed') {
				$this->helper->showModuleJsHiddenCode();
                
            } else {
                $this->helper->showModuleHiddenCode();
                $this->countPastCode = true;
            }
        } else {
            if ($this->settings->buttonAvailableAll) {
                $this->helper->showInAllCode($this->pos);
            } else {
                $this->helper->showInAllHiddenCode($this->pos);
            }
            if ($this->settings->buttonAvailablePost) {
                if ($this->settings->buttonAvailablePostWhich == 'all') {
                    $this->helper->showAllPageCode($this->pos);
                } elseif ($this->settings->buttonAvailablePostWhich == 'selected') {
                    $this->helper->showSelectedPageCode($this->pos);
                }
            } else {
                $this->helper->showAllPageHiddenCode($this->pos);
            }
        }
    }
}
