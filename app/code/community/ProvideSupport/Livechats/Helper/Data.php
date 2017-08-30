<?php
class ProvideSupport_livechats_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function initJs()
    {
        $this->page      = Mage::getSingleton('cms/page');
        $this->list_page = Zend_Json::decode($this->settings, Zend_Json::TYPE_OBJECT);
    }
    public function initCodePS($view)
    {
        $this->settings   = $view->settings;
        $this->code       = $view->code;
        $this->hiddencode = $view->hiddencode;
        $this->setJsCode();
    }
    public function showModuleCode()
    {
        echo '<div class="f7x">' . $this->code . '</div><script type="text/javascript">console.log("ProvideSupport : chat button code loaded");</script>';
    }
    public function showModuleHiddenCode()
    {
        echo '<div class="f7x">' . $this->hiddencode . '</div><script type="text/javascript">console.log("ProvideSupport : hidden monitoring code loaded");</script>';
    }
    public function showModuleJsCode()
    {
        echo $this->setJavaScript($this->jsCode . ' showChat(f7php.code); console.log(BUTTONTEXT); ');
    }
    public function showModuleJsHiddenCode()
    {
        echo $this->setJavaScript($this->jsCode . ' showChat(f7php.hiddencode); console.log(HIDDENTEXT); ');
    }
    public function showInAllCode($pos = '')
    {
        if (!$this->page->getId()) {
            switch ($pos) {
                case 'fixed':
                    $this->showModuleJsCode();
                    break;
                case 'define':
                    $this->showModuleCode();
                    break;
                default:
                    break;
            }
        }
    }
    public function showInAllHiddenCode($pos = '')
    {
        if (!$this->page->getId()) {
            if ($this->list_page->buttonAvailableWhole) {
                switch ($pos) {
                    case 'fixed':
                        $this->showModuleJsHiddenCode();
                        break;
                    case 'define':
                        $this->showModuleHiddenCode();
                        break;
                    default:
                        break;
                }
            }
        }
    }
    public function showAllPageCode($pos = '')
    {
        if ($this->page->getId()) {
            switch ($pos) {
                case 'fixed':
                    $this->showModuleJsCode();
                    break;
                case 'define':
                    $this->showModuleCode();
                    break;
                default:
                    break;
            }
        }
    }
    public function showAllPageHiddenCode($pos = '')
    {
        if ($this->page->getId()) {
            if ($this->list_page->buttonAvailableWhole) {
                switch ($pos) {
                    case 'fixed':
                        $this->showModuleJsHiddenCode();
                        break;
                    case 'define':
                        $this->showModuleHiddenCode();
                        break;
                    default:
                        break;
                }
            }
        }
    }
    public function showSelectedPageCode($pos = '')
    {
        if (is_array($this->list_page->buttonAvailablePostList) && count($this->list_page->buttonAvailablePostList) > 0 && in_array($this->page->getId(), $this->list_page->buttonAvailablePostList)) {
            switch ($pos) {
                case 'fixed':
                    $this->showModuleJsCode();
                    break;
                case 'define':
                    $this->showModuleCode();
                    break;
                default:
                    break;
            }
        } else {
            if ($this->list_page->buttonAvailableWhole && $this->page->getId()) {
                switch ($pos) {
                    case 'fixed':
                        $this->showModuleJsHiddenCode();
                        break;
                    case 'define':
                        $this->showModuleHiddenCode();
                        break;
                    default:
                        break;
                }
            }
        }
    }
    public function setJavaScript($message)
    {
		$jsUrl = Mage::getBaseUrl('js');
        $javascript = '
				<script type="text/javascript">
					(function ()
					{
						// Localize jQuery variable
						var jQuery;
						/******** Load jQuery if not present *********/
						if(window.jQuery === undefined || window.jQuery.fn.jquery !== "1.4.2")
						{
							var script_tag = document.createElement("script");
							script_tag.setAttribute("type", "text/javascript");
							script_tag.setAttribute("src",
								"'.$jsUrl.'provide/jquery.min.js");
							if(script_tag.readyState)
							{
								script_tag.onreadystatechange = function ()
								{ // For old versions of IE
									if(this.readyState == "complete" || this.readyState == "loaded")
									{
										scriptLoadHandler();
									}
								};
							}
							else
							{ // Other browsers
								script_tag.onload = scriptLoadHandler;
							}
							// Try to find the head, otherwise default to the documentElement
							(document.getElementsByTagName("head")[0] || document.documentElement)
								.appendChild(script_tag);
						}
						else
						{
							// The jQuery version on the window is the one we want to use
							jQuery = window.jQuery;
							main();
						}
						/******** Called once jQuery has loaded ******/
						function scriptLoadHandler()
						{
							// Restore $ and window.jQuery to their previous values and store the
							// new jQuery in our local jQuery variable
							jQuery = window.jQuery.noConflict(true);
							// Call our main function
							main();
						}
						/******** Our main function ********/
						function main()
						{
							jQuery(document)
								.ready(function ($)
								{
									' . $message . '
								});
						}
					})(); // We call our anonymous function immediately
				</script>';
        return $javascript;
    }
    public function setJsCode()
    {
        $this->jsCode = "
      
        var BUTTONTEXT = 'ProvideSupport : chat button code loaded';
		var HIDDENTEXT = 'ProvideSupport : hidden monitoring code loaded';
		var f7php = new Object();
		var f7s = new Object();
		f7s = JSON.parse(" . Zend_Json::encode($this->settings) . "); //f7php.settings
		
		
		
		f7php.code = " . Zend_Json::encode($this->code) . ";
		f7php.hiddencode = " . Zend_Json::encode($this->hiddencode) . ";
		showChat = function (code)
		{
			var codeBlock = document.createElement('div');
			
			
			
			codeBlock.className = 'f7x';
			document.body.appendChild(codeBlock);
			
			jQuery('.f7x').html(code);
			
			/*
			conf = {'position': 'fixed','width': 'auto','height': 'auto','z-index': 10000}
			jQuery('.f7x').css(conf);
			*/
			
			jQuery('.f7x').css(f7s.buttonLocationHorizontalFrom, f7s.buttonLocationHorizontalValue + f7s.buttonLocationHorizontalBy);
			jQuery('.f7x').css(f7s.buttonLocationVerticalFrom, f7s.buttonLocationVerticalValue + f7s.buttonLocationVerticalBy);
			
		}; ";
    }
}
