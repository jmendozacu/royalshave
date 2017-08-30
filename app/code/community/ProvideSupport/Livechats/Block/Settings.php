<?php
class ProvideSupport_livechats_Block_Settings extends Mage_Core_Block_Template
{
    private function addProvideCss()
    {
		$css = '
<style type="text/css">
/*
 * Developed by Ortus IT.
 * Web: http://ortus-it.com
 * Code part:#02-01-rev.004, October 2013. 
 * -All Rights of this product are belong to Provide Support, LLC.-
 * 
 */
*{
  padding: 0;
  margin: 0;
}
.novalid {
  border-color: tomato !important;
  border-width: 1px;
}
.novalidButton{background-color:tomato !important;}
#f7main {
background: none repeat scroll 0 0 #FAFAFA;
    border: 1px solid #D6D6D6;
  
}
#f7main #f7title,
#f7main #f7message,
#f7main #f7settings,
#f7main #f7account,
#f7main #f7accountInfo {
  width: 60%;
  margin-top: 5px;
  /*margin-left: 20px;*/
  margin: 5px auto;
  text-align: center;
  padding-top: 5px;
  padding-bottom: 5px;
  border-radius:3px;
}
#f7main #f7title {
  border: 1px solid lightgrey;
}
#f7main #f7message {
  display: none;
  color: darkgreen;
  border: 1px solid darkgreen;
  background-color: #caffca;
}
#f7main .f7warning {
  color: darkred !important;
  border: 1px solid darkred !important;
  background-color: #fff1f1 !important;
}
#f7main #f7account {
	text-align:left;
	position:relative;
	}
#f7main #f7account #f7buttonE,
#f7main #f7account #f7buttonN{
	display:inline-block;
	width:110px;height:25px;
	line-height:25px;
	background-color:#6F8992;
	text-align:center;
	border-top:1px solid #6F8992;
	border-left:1px solid #6F8992;
	border-right:1px solid #6F8992;
	border-bottom:1px solid #6F8992;
	position:relative;
	top:1px;
	left:30px;
	z-index:100;
	cursor:pointer;
	color:white;
	}
.f7buttonNoBorder{color:black !important;border-bottom:1px solid white !important;background-color:white !important;}
#f7main #f7account #f7buttonN{border-left:none;}
#f7main #f7account #f7accountE{
	width:600px;
	border-top: 1px solid black;
	z-index:1;
	position:relative;
	}
#f7main #f7account #f7accountE .f7fields{
	margin-top:10px;
	position:relative;
	width:100%;
	height:20px;
	}
#f7main #f7account #f7accountE .f7fields .f7label,
#f7main #f7account #f7accountE .f7fields .f7field{
	position:absolute;
	}
#f7main #f7account #f7accountE .f7fields .f7label{
	top:4px;
	left:11%;
	}
#f7main #f7account #f7accountE .f7fields .f7field{
	left:51%;
	width:220px;
	}
#f7main #f7account #f7accountE .f7fields .f7field input{
	width:100%;
	}
#f7main #f7account #f7accountE .f7fields .f7field #f7accountSubmit,#f7anotherAccount{
	width:219px;
	height:25px;
	line-height:25px;
	text-align:center;
	font-weight:bold;
	border:1px solid #6F8992;
	border-radius:3px;
	background-color: #6F8992;
	cursor:pointer;
	opacity:.8;
	color:white;
	}
#f7main #f7account #f7accountE .f7fields .f7field #f7accountSubmit:hover{opacity:1;}
#f7anotherAccount:hover{opacity:1;}
#f7main #f7settings {
  position: relative;
  text-align: left;
}
#f7main #f7settings input {
  margin-right: 3px;
}
#f7main #f7settings .setting {
  padding-top: 5px;
  margin-left: 30px;
}
#f7main #f7settings .setting .settingInt {
  padding-top: 5px;
  margin-left: 25px;
}
#f7main #f7settings .setting .settingInt .f7part1,
#f7main #f7settings .setting .settingInt .f7part2,
#f7main #f7settings .setting .settingInt .f7part3,
#f7main #f7settings .setting .settingInt .f7part4 {
  display: inline-block;
  margin-left: 8px;
}
#f7main #f7settings .setting .settingInt .f7part1 {
  width: 65px;
}
#f7main #f7settings .setting .settingInt .f7part3,
#f7main #f7settings .setting .settingInt .f7part4 {
  position: relative;
  top: 8px;
}
#f7main #f7settings .setting .settingInt #selectPagesMenus #selectPostMenus {
  margin-left: 20px;
  position: relative;
  width: 250px;
  height: auto;
  padding: 0 0 0 20px;
}

#f7main #f7settings .setting .settingInt #f7pagesSubmit {
  width: 50%;
  margin: 2px auto;
  height: 18px;
  background-color: darkgreen;
  border-radius: 10px;
  text-align: center;
  color: white;
  font-weight: bold;
  cursor: pointer;
}
#f7main #f7settings .setting .settingInt .settingIntInt {
  padding-top: 5px;
  margin-left: 25px;
}
#f7main #f7settings #f7livePreview {
  position: absolute;
  padding-bottom:0px;
  width: auto;
  height: auto;
  top: 10px;
  right: 30px;
  border-radius:3px;
  color:darkgrey;
}
#f7main #f7settings .f7separator{
	position:relative;
	width:450px;
	border-bottom:1px solid darkgrey;
	margin-top:15px;
	margin-bottom:7px;
	}
#f7main #f7settings .f7separator .f7inner{
	position:absolute;
	top:-9px;right:25px;
	padding: 1px 4px;
	background-color:white;
	font-weight:bold;
	}
#f7main #f7submit{
	width:100px;
	background-color: #6F8992 ;
	margin: 15px auto;
	padding:3px;
	border-radius:10px;
	text-align:center;
	font-weight:bold;
	color:white;
	opacity:.9;	
	}
#f7main #f7submit:hover{opacity:1;}
.f7r{margin-right:2px !important;margin-left:1px !important;}

#selectPagesMenus label {
    font-size: 1em;
    margin-top: 5px;
    margin-bottom: 0px;
}
#selectPagesMenus input {
    margin: 2px 0 0 8px;
}
.menus-header{
	color: #999999;
    display: block;
    font-size: 11px;
    font-weight: bold;
    padding: 3px 6px;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
    text-transform: uppercase;
}
#selectedBlock{
	 margin: 10px 0;
	 border-color: #6F8992;
}
</style>';
	return $css;
    }
    protected function _toHtml()
    {
        $html = '<script>var urlAjax = "' . Mage::getUrl('') . 'livechats/admin/ajax/?isAjax=true";</script>';
        $html .= $this->addProvideCss() . ' <div id="f7main">';
        $html .= '<div id="f7title">';
        $html .= 'Welcome to Provide Support Live Chat module settings page.<br/>Visit our website <a href="http://www.providesupport.com" target="_blank">www.providesupport.com</a> to find more information about our Live Chat system.';
        $html .= '</div>';
        $html .= '<div id="f7message">';
        $html .= '';
        $html .= '</div>';
        $html .= '<div id="f7accountInfo"></div>';
        $html .= '<div id="f7account">';
        $html .= '<div id="f7buttonE" class="f7buttonNoBorder">Existing Account</div>';
        $html .= '<div id="f7buttonN">New account</div>';
        $html .= '<div id="f7accountE">';
        $html .= '<div class="f7fields">';
        $html .= '<div class="f7label">';
        $html .= 'Your Provide Support account name:';
        $html .= '</div>';
        $html .= '<div class="f7field">';
        $html .= '<input type="text">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="f7fields">';
        $html .= '<div class="f7label">';
        $html .= 'Your Provide Support account password:';
        $html .= '</div>';
        $html .= '<div class="f7field">';
        $html .= '<input type="password">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="f7fields" style="display:none">';
        $html .= '<div class="f7label">';
        $html .= 'Your email:';
        $html .= '</div>';
        $html .= '<div class="f7field">';
        $html .= '<input type="email">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="f7fields">';
        $html .= '<div class="f7field">';
        $html .= '<div id="f7accountSubmit">Connect to Account</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div id="f7settings" style="display:none">';
        $html .= '<div id="f7livePreview"></div>';
        $html .= '<div class="setting f7control">';
        $html .= '<input type="checkbox" id="f7pluginEnabled">Enable live chat module';
        $html .= '</div>';
        $html .= '<div class="f7separator"><div class="f7inner">Select chat button type</div></div>';
        $html .= '<div class="setting">';
        $html .= '<input type="radio" name="buttonAppearance" id="buttonImageType" class="f7button1">Graphics chat button';
        $html .= '<div class="settingInt">';
        $html .= '<input type="radio" name="customImages" id="buttonImageSource" class="f7button3">Use images selected in your account setings';
        $html .= '<div class="settingIntInt" style="width:240px;">';
        $html .= 'Images uploaded to Account Settings / Images page of your Provide Support account Control Panel will be used';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="settingInt">';
        $html .= '<input type="radio" name="customImages" class="f7button4">Use custom images';
        $html .= '<div class="settingIntInt">';
        $html .= 'Online image URL <input type="text" id="buttonImageUrlOnline">';
        $html .= '</div>';
        $html .= '<div class="settingIntInt">';
        $html .= 'Offline image URL <input type="text" id="buttonImageUrlOffline">';
        $html .= '</div>';
        $html .= '<div class="settingIntInt" style="width:236px;margin:5px 0 5px 27px;font-size:10px;line-height:10px;">';
        $html .= 'You can specify here actual links to images stored on your server. If you use your  Live Chat account on several websites, this feature lets you display your custom chat icons, different from the ones uploaded to your Provide Support account ';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="setting">';
        $html .= '<input type="radio" class="f7button2" name="buttonAppearance">Text chat link';
        $html .= '<div class="settingInt">';
        $html .= 'Online Chat Link text <input type="text" id="buttonImageTextOnline">';
        $html .= '</div>';
        $html .= '<div class="settingInt">';
        $html .= 'Offline Chat Link text <input type="text" id="buttonImageTextOffline">';
        $html .= '</div>';
        $html .= '<div class="settingInt" style="width:236px;margin-left:39px;font-size:11px;line-height:10px;">';
        $html .= 'HTML formatting is supported for Chat Link texts';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="f7separator"><div class="f7inner">Chat button position</div></div>';
        $html .= '<div class="setting">';
        $html .= '<input type="radio" location="define" name="buttonLocation">Show Chat Button in selected for a module position';
        $html .= '<div class="settingInt" style="width:300px;font-size:12px;line-height:13px;">';
        $html .= '<div style="text-align: justify;">Your Live Chat button will be displayed according to the module position selected from the below drop down list. <b style="color:red;">Please note!</b> The position should be available with your Magento theme, otherwise the chat button will not be displayed</div>';
        $html .= $this->getMenu();
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="setting">';
        $html .= '<input type="radio" location="fixed" name="buttonLocation">Show Сhat Button at a fixed position on the browser window';
        $html .= '<div class="settingInt" style=" padding-top: 0px; ">';
        $html .= '<div class="f7part1">';
        $html .= 'Vertical';
        $html .= '</div>';
        $html .= '<div class="f7part2">';
        $html .= '<input type="text" id="buttonLocationVerticalValue" value=50>';
        $html .= '</div>';
        $html .= '<div class="f7part3">';
        $html .= '<input type="radio" class="f7button5" name="specVerticalPx" id="buttonLocationVerticalBy">px';
        $html .= '<br />';
        $html .= '<input type="radio" class="f7button6" name="specVerticalPx" checked>%';
        $html .= '</div>';
        $html .= '<div class="f7part4">';
        $html .= '<input type="radio" class="f7button9" name="specVerticalFrom" id="buttonLocationVerticalFrom">from top';
        $html .= '<br />';
        $html .= '<input type="radio" class="f7button10" name="specVerticalFrom" checked>from bottom';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="settingInt" style=" padding-top: 0px; ">';
        $html .= '<div class="f7part1">';
        $html .= 'Horizontal';
        $html .= '</div>';
        $html .= '<div class="f7part2">';
        $html .= '<input type="text" id="buttonLocationHorizontalValue" value=0>';
        $html .= '</div>';
        $html .= '<div class="f7part3">';
        $html .= '<input type="radio" class="f7button7" name="specHorizontalPx" id="buttonLocationHorizontalBy">px';
        $html .= '<br />';
        $html .= '<input type="radio" class="f7button8" name="specHorizontalPx" checked>%';
        $html .= '</div>';
        $html .= '<div class="f7part4">';
        $html .= '<input type="radio" class="f7button11" name="specHorizontalFrom" id="buttonLocationHorizontalFrom">from left';
        $html .= '<br />';
        $html .= '<input type="radio" class="f7button12" name="specHorizontalFrom" checked>from right';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="settingInt" style="width:253px;margin-left:64px;">';
        $html .= 'Specify vertical and horizontal position in pixels or percent for your Chat Button';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="f7separator"><div class="f7inner shortcodeSeparator">Display chat button at</div></div>';
        $html .= '<div class="setting">';
		$html .= '<input type="checkbox" id="buttonAvailableAll">All predefined Magento store pages';
		$html .= '</div>';
        $html .= '<div class="setting selectPostToggle">';
        $html .= '<input type="checkbox" id="buttonAvailablePost">Single Posts created in CMS/Pages:';
        $html .= '<div class="settingInt">';
        $html .= '<input type="radio" class="f7button15" name="optionPost" id="buttonAvailablePostWhich">All';
        $html .= '</div>';
        $html .= '<div class="settingInt">';
        $html .= '<input type="radio" class="f7button16" name="optionPost">Selected';
        $html .= $this->getPage();
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="setting">';
        $html .= '<input type="checkbox" id="buttonAvailableWhole">Monitor the whole website';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div id="f7wait" style="margin:4px auto;width:33px;"></div>';
        $html .= '<div id="f7submit" style="cursor:pointer;display:none;">UPDATE</div>';
        $html .= '</div>';
        return $html;
    }
    private function getPage()
    {
        $store     = Mage::app()->getStore('default'); 
        $cms_pages = Mage::getModel('cms/page')->getCollection();
        $cms_pages->addStoreFilter($store);
        $cms_pages->load();
        $count = count($cms_pages);
        if ($count > 0) {
            $div_post = '<div id="selectPostMenus" style="padding: 0 0 0 15px;">';
            foreach ($cms_pages as $_page) {
                $data = $_page->getData();
                if ($data['is_active'] == 0) {
                    $published = '<span style="color:grey;">' . $data['title'] . ' (Disabled) </span>';
                    $disabled  = 'disabled';
                    $strike    = $published;
                } else {
                    $published = $data['title'];
                    $disabled  = '';
                    $strike    = $published;
                }
                $div_post .= '<input type="checkbox" ' . $disabled . ' postid="' . $data['page_id'] . '">' . $strike . '<br />';
            }
            $div_post .= '</div>';
            return $div_post;
        }
    }
    protected function getMenu()
    {
        $layout        = '';//'default,catalog_category_layered,catalog_product_view';
        //$layout = 'default,catalog_category_layered,catalog_product_view,PRODUCT_TYPE_simple,PRODUCT_TYPE_grouped,PRODUCT_TYPE_configurable,PRODUCT_TYPE_virtual,PRODUCT_TYPE_bundle,PRODUCT_TYPE_downloadable';
        $blocksChooser = $this->getLayout()->createBlock('widget/adminhtml_widget_instance_edit_chooser_block')->setLayoutHandle($layout);
        $option        = $blocksChooser->toHtml();
        $div_menu      = '<div id="selectPagesMenus">';
        $div_menu .= '<select id="selectedBlock">';
        $div_menu .= $this->getParseOptions($option);
        //$additional_blocks = $this->getLayout()->createBlock('widget/adminhtml_widget_instance_edit_chooser_layout');
        //$option            = $additional_blocks->toHtml();
        //$div_menu .= $this->getParseOptions($option);
        $div_menu .= '</select>';
        $div_menu .= '</div>';
        return $div_menu;
    }
    function getParseOptions($option)
    {
        preg_match_all('/<option value="([^"]*)" >([^>]*)<\/option>/', $option, $option_value);
        $count = count($option_value[1]);
        if ($count > 0) {
			$div_menu = '';
            for ($i = 1; $i < $count; $i++) {
                $div_menu .= '<option value="' . $option_value[1][$i] . '">' . $option_value[2][$i] . '</option>';
            }
        }
        return $div_menu;
    }
}
