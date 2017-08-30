<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Cssgenerate extends Mage_Core_Model_Abstract
{
    private $baseColors;
	private $catlabelsColors;
    private $appearance;
    private $mediaPath;
    private $dirPath;
    private $filePath;
	private $buttonsColors;
	private $productsColors;
	private $contentColors;
	private $socialLinksColors;
	private $headerColors;
	private $stickyHeaderColors;
	private $footerColors;
	private $menuColors;
	private $revSliderButtonsColors;
	private $parallaxBannersColors;
	private $pageNotFoundColors;

    private function setParams () {
        $this->baseColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/base');
		$this->catlabelsColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/catlabels');
        $this->appearance = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/appearance');
		$this->buttonsColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/buttons');
		$this->productsColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/products');
		$this->socialLinksColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/social_links');
		$this->footerColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/footer');
		$this->contentColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/content');
		$this->headerColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/header');
		$this->stickyHeaderColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/sticky_header');
		$this->menuColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/menu');
		$this->revSliderButtonsColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/rev_slider_but');
		$this->parallaxBannersColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/parallax_banners');
		$this->pageNotFoundColors = Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/page_not_found');
    }

    private function setLocation () {
        $this->mediaPath = Mage::getBaseDir('media') . 'images/';
        $this->dirPath = Mage::getBaseDir('skin') . '/frontend//' . Mage::getStoreConfig('meigee_bizarre_design'.Mage::getStoreConfig('meigee_bizarre_general/design/skin_design').'/options/theme') . '//css/';
        $this->filePath = $this->dirPath . 'skin.css';
    }

    public function saveCss()
    {

        $this->setParams();

$css = "/**
*
* This file is generated automaticaly. Please do no edit it directly cause all changes will be lost.
*
*/
";

if ($this->appearance['font_main'] == 1)
{
    $css .= '/*====== Font Replacement - Main Text =======*/ ';
    if ($this->appearance['main_default_sizes'] == 0)
        {
$css .= '
body{
    font-family: '. $this->appearance['gfontmain'] .', sans-serif; 
    font-size:'. $this->appearance['main_fontsize'] .'px !important;
    line-height:' . $this->appearance['main_lineheight'] .'px !important;
    font-weight:' .$this->appearance['main_fontweight'] .' !important;
}

';
	}else{
		$css .= '
		body{
			font-family: '. $this->appearance['gfontmain'] .', sans-serif;
		}
		
		';
	}
};


if ($this->appearance['font'] == 1)
{
    $css .= '/*====== Font Replacement - Titles =======*/ ';
    if ($this->appearance['default_sizes'] == 0)
        {
$css .= '
.widget-latest li h3 a,
.widget .widget-title h1,
.widget .widget-title h2,
.widget-title h2,
.page-title h1,
.page-title h2,
.page-title h3,
.page-title h4,
.page-title h5,
.page-title h6,
.nav-container a.level-top > span,
header.header .top-cart .block-title .title-cart,
.home-banners-2 .text-banner .banner-title strong,
.home-text-banners span strong,
.home-container.grid-2 .product-info-top .product-name a,
aside.sidebar .block.block-layered-nav dl dt.filter-label,
.newsletter-line .block-subscribe h3,
.footer-links span,
#footer .footer-second-line .footer-block-title h2,
aside.sidebar .block-title strong span,
.products-list .product-name a,
.sorter label,
.product-view .product-shop .product-name h1,
.related-wrapper-bottom .block-title strong span,
.rating-title h2,
.related-wrapper .block-related .block-title span,
.related-wrapper .block-related.large-image .product-name a,
.product-collateral h2,
.nav-wide ul.level0 li.level1 span.subtitle,
.nav-wide .top-content a,
.nav-wide .bottom-content span strong,
header.header .top-cart .block-content .subtotal .label,
header.header .top-cart .block-content .subtotal .price,
.data-table .product-name a,
.cart header h2,
#cart-accordion h3.accordion-title span,
.fieldset .legend,
.product-options dt label,
.dashboard .welcome-msg .hello,
.dashboard .box-title h2,
.dashboard .box-title h3,
.dashboard .box-head h3,
.dashboard .box-head h2,
.opc h3,
.opc-wrapper-opc .opc-block-title h3,
.meigee-tabs a,
.menu-button,
.sorter .view-mode .grid,
.sorter .view-mode .list,
.home-banners-2 .banner .banner-content h2,
a.aw-blog-read-more,
.block-subscribe strong span,
.block-title h2,
.text-banner .text-banner-content h2,
.banner .banner-title,
body .address-block .banner-title,
header#header .language-currency-dropdown label,
.banner .banner-content,
.bottom-scroll-button,
.page-no-route .text-block h2,
.page-no-route .text-block h3 {
    font-family: '. $this->appearance['gfont'] .', sans-serif; 
    font-size:'. $this->appearance['fontsize'] .'px !important;
    line-height:' . $this->appearance['lineheight'] .'px !important;
    font-weight:' .$this->appearance['fontweight'] .' !important;
	-webkit-text-stroke-width: 0.02em;
}

.opc .step-title h2,
aside.sidebar .actions a,
#login-holder .link-box a,
button.button span span,
.add-to-cart-success a,
.widget-wrapper .category-button a,
header.header .top-cart .block-content .actions a,
.related-products-button a,
.pages li.current,
.pages li a {
    font-family: '. $this->appearance['gfont'] .', sans-serif; 
    font-size:'. $this->appearance['fontsize'] .'px !important;
    font-weight:' .$this->appearance['fontweight'] .' !important;
	-webkit-text-stroke-width: 0.02em;
}

';
        } else {
        $css .= '
.widget-latest li h3 a,
.widget .widget-title h1,
.widget .widget-title h2,
.widget-title h2,
.page-title h1,
.page-title h2,
.page-title h3,
.page-title h4,
.page-title h5,
.page-title h6,
.nav-container a.level-top > span,
#login-holder .link-box a,
button.button span span,
header.header .top-cart .block-title .title-cart,
.home-banners-2 .text-banner .banner-title strong,
.home-text-banners span strong,
.home-container.grid-2 .product-info-top .product-name a,
aside.sidebar .block.block-layered-nav dl dt.filter-label,
.newsletter-line .block-subscribe h3,
.footer-links span,
#footer .footer-second-line .footer-block-title h2,
aside.sidebar .block-title strong span,
aside.sidebar .actions a,
.products-list .product-name a,
.sorter .view-mode .grid,
.sorter .view-mode .list,
.sorter label,
.pages li.current,
.pages li a,
.product-view .product-shop .product-name h1,
.meigee-tabs a,
.related-wrapper-bottom .block-title strong span,
.rating-title h2,
.related-wrapper .block-related .block-title span,
.related-products-button a,
.related-wrapper .block-related.large-image .product-name a,
.product-collateral h2,
.nav-wide ul.level0 li.level1 span.subtitle,
.nav-wide .top-content a,
.nav-wide .bottom-content span strong,
header.header .top-cart .block-content .subtotal .label,
header.header .top-cart .block-content .subtotal .price,
header.header .top-cart .block-content .actions a,
.data-table .product-name a,
.cart header h2,
#cart-accordion h3.accordion-title span,
.fieldset .legend,
.product-options dt label,
.dashboard .welcome-msg .hello,
.dashboard .box-title h2,
.dashboard .box-title h3,
.dashboard .box-head h3,
.dashboard .box-head h2,
.opc h3,
.opc-wrapper-opc .opc-block-title h3,
.opc .step-title h2,
.menu-button,
.widget-wrapper .category-button a,
.add-to-cart-success a,
.home-banners-2 .banner .banner-content h2,
a.aw-blog-read-more,
.block-subscribe strong span,
.block-title h2,
.text-banner .text-banner-content h2,
.banner .banner-title,
body .address-block .banner-title,
header#header .language-currency-dropdown label,
.banner .banner-content,
.bottom-scroll-button,
.page-no-route .text-block h2,
.page-no-route .text-block h3 {font-family: ' . $this->appearance['gfont'] .', sans-serif; -webkit-text-stroke-width: 0.02em;}';}
}

if ($this->appearance['custompatern']) {
$css .= '

/*====== Custom Patern =======*/
body { background: url("' . MAGE::helper('ThemeOptionsBizarre')->getThemeOptionsBizarre('mediaurl') . $this->appearance['custompatern'] . '") center top repeat !important;}';
}
$css .= '

/*====== Site Bg =======*/
body,
body.boxed-layout,
#footer .footer-topline,
#footer .footer-bottom,
body.boxed-layout #footer .footer-topline .container_12,
body.boxed-layout #footer .footer-bottom  .container_12,
#footer .footer-links ul.active {background-color:#' . $this->baseColors['sitebg'] . ';}

/*====== Skin Color #1 =======*/
.nav-container a.level-top:hover,
.nav-container .active a.level-top,
.nav-container .over a.level-top,
#footer .footer-second-line .block-tags li a:hover,
header.header .form-search button:hover,
header.header .search-button:hover,
.slider-container .prev:hover i,
.slider-container .next:hover i,
aside.sidebar .block-tags li a:hover,
.data-table .remove i:hover,
body .text-banner .text-banner-content.skin-2 h2:after,
.swatch-current .selected .swatch-link,
.configurable-swatch-list .selected .swatch-link {border-color: #' . $this->baseColors['maincolor'] . ';}

.rev_slider_wrapper .tp-leftarrow.default:hover,
.rev_slider_wrapper .tp-rightarrow.default:hover,
#login-holder form .actions button span span,
.products-grid li.item .button-holder .btn-cart:hover span span i,
.home-banners-2 .text-banner,
.ui-slider .ui-slider-range,
aside.sidebar .actions button span span,
.products-list li.item .button-holder button.button span span,
.sorter .view-mode .view-mode-separator:after,
.pages li:hover,
.label-sale,
.products-grid .availability-only,
.products-list .availability-only,
body button.button span span,
.catalog-product-view .box-reviews .data-table thead,
.catalog-product-view .box-reviews .full-review,
.home-container.grid-2 .item:hover .product-info-top,
.block-related.large-image .slideSelectors li.selected,
#footer .footer-second-line .block-tags li a:hover,
.widget-wrapper .category-button a:hover,
header.header .form-search button:hover > span,
.top-link-wishlist i:hover,
header.header .search-button:hover,
#toTopHover i:hover,
header#header .links li a i:hover,
.newsletter-line .block-subscribe button.button:hover span span,
.slider-container .prev:hover i,
.slider-container .next:hover i,
.related-wrapper-bottom .block-related .prev:hover i,
.related-wrapper-bottom .block-related .next:hover i,
aside.sidebar .block-poll .actions button:hover span span,
aside.sidebar .actions a:hover,
.related-wrapper .related-products-button a:hover,
.more-views .prev i:hover,
.more-views .next i:hover,
aside.sidebar .block-tags li a:hover,
.add-to-cart-success a,
.home-banners-2 .banner .banner-content .label,
a.aw-blog-read-more:hover,
body .address-block,
.product-view .product-img-box .fancybox-product,
.product-tabs li.current,
.product-tabs li:hover,
.banner .banner-content {background-color: #' . $this->baseColors['maincolor'] . ';}

a,
.nav-wide .menu-wrapper.default-menu ul.level0 li.level1 a:hover span,
#login-holder .close-button i:hover,
.widget-title .category-link,
.price-box .price,
#categories-accordion .btn-cat .fa-minus-square-o,
.block-vertical-nav li a:hover,
.products-grid li.item .product-buttons .btn-quick-view:hover span span,
.products-grid li.item .product-buttons .btn-quick-view:hover span span i,
.products-list li.item .btn-quick-view:hover span span i,
.sorter a.asc:hover,
.sorter a.desc:hover,
.catalog-product-view .box-reviews .form-add h3 span,
.catalog-product-view .box-reviews ul li small span,
.block-related.large-image .related-checkbox-label,
header.header .top-cart .product-name a:hover,
header.header .top-cart .block-content .mini-products-list .product-details .price,
.data-table .cart-price .price,
.data-table .product-name a:hover,
.item-options dd .price,
.block-account li strong,
.block-account li a:hover,
div.quantity-decrease i:hover,
div.quantity-increase i:hover,
nav.breadcrumbs li strong,
#footer .form-currency > a:hover,
#footer .form-language > a:hover,
#footer .footer-products-list .product-shop .product-name a:hover,
#footer .footer-second-line .footer-info a:hover,
.products-grid .product-name a:hover,
.products-grid li.item .product-buttons li i:hover,
.product-view .product-shop .add-to-links-box i:hover,
.product-options-bottom .add-to-links i:hover,
.product-options-bottom .email-friend i:hover,
.products-list li.item .add-to-links li i:hover,
aside.sidebar .block.block-layered-nav ol li a:hover,
.products-list .product-name a:hover,
header.header .top-cart .btn-edit i:hover,
header.header .top-cart .btn-remove i:hover,
#login-holder .page-title .forgot-pass:hover,
.nav-wide ul.level1 a:hover,
aside.sidebar .block.block-wishlist li.item .product-details .btn-remove i:hover,
aside.sidebar .block.block-wishlist li.item .product-details .product-name a:hover,
aside.sidebar .block.block-wishlist .link-cart:hover,
aside.sidebar .product-name a:hover,
.block-compare li.item .btn-remove i:hover,
.crosssell .product-details .add-to-links i:hover,
.crosssell .product-details .product-name a:hover,
.cart .totals .checkout-types li a:hover,
.crosssell .product-details button.button:hover span,
.data-table .c_actions a i:hover,
.data-table .remove i:hover,
.banner .banner-title:hover,
.home-sidebar .faq .question i,
.text-banner .banner-content h2 span,
.block-vertical-nav li.active > a,
.bottom-scroll-button .icon,
.text-banner .text-banner-content a.banner-link,
.configurable-swatch-list .swatch-link:hover,
.swatch-current .selected .swatch-link,
.configurable-swatch-list .selected .swatch-link {color: #' . $this->baseColors['maincolor'] . ';}

.label-type-5 .label-sale:before,
.products-grid.label-type-5 .availability-only:before,
.products-list.label-type-5 .availability-only:before{
	border-top-color: #' . $this->baseColors['maincolor'] . ';
}
.label-type-5 .label-sale:after,
.products-grid.label-type-5 .availability-only:after,
.products-list.label-type-5 .availability-only:after{
	border-bottom-color: #' . $this->baseColors['maincolor'] . ';
}

/*====== Skin Color #2 =======*/
.category-products .toolbar-bottom:before,
.ias_trigger.active button.button > span,
footer#footer,
.newsletter-line .block-subscribe  button.button span span,
.pages li.current,
.label-new,
body.boxed-layout footer#footer .container_12,
.widget-wrapper .category-button a,
#toTopHover i,
body button.button:hover span span,
aside.sidebar .actions button:hover span span,
.products-list li.item .button-holder button.button:hover span span,
header.header .top-cart .block-content .actions a:hover,
#login-holder form .actions button:hover span span,
#login-holder .link-box a:hover,
.add-to-cart-success a:hover,
.cart-table .buttons-row .buttons .btn-clear:hover span span, 
.cart-table .buttons-row .buttons .btn-update:hover span span,
.my-wishlist .buttons-set .btn-share:hover span span, 
.my-wishlist .buttons-set .btn-add:hover span span,
.products-list li.item .fancybox,
.products-grid li.item .fancybox {background-color: #' . $this->baseColors['secondcolor'] . ';}

a:hover,
.widget-latest li h3 a:hover,
.widget-latest li .comments a:hover,
.widget-title .category-link:hover,
.home-text-banners span a:hover,
.banner .banner-title,
.text-banner .text-banner-content a.banner-link:hover {color: #' . $this->baseColors['secondcolor'] . ';}

.label-type-5 .label-new:before{
    border-top-color: #' . $this->baseColors['secondcolor'] . ';
}
.label-type-5 .label-new:after{
    border-bottom-color: #' . $this->baseColors['secondcolor'] . ';
}
';
$searchBgTransparent = ($this->headerColors["header_search_transparent_bg_value"]/100);
$searchBorderTransparent = ($this->headerColors["header_search_transparent_border_value"]/100);
$searchActiveBgTransparent = ($this->headerColors["header_search_active_transparent_bg_value"]/100);
$searchActiveBorderTransparent = ($this->headerColors["header_search_active_transparent_border_value"]/100);
$cartBgTransparent = ($this->headerColors["cart_transparent_bg_value"]/100);
$cartHoverBgTransparent = ($this->headerColors["cart_transparent_bg_h_value"]/100);
$loginWishlistBgTransparent = ($this->headerColors["login_wishlist_transparent_bg_value"]/100);
$loginWishlistHoverBgTransparent = ($this->headerColors["login_wishlist_transparent_bg_h_value"]/100);
$menuBgTransparent = ($this->menuColors["menu_transparent_bg_value"]/100);
$menuBorderTransparent = ($this->menuColors["menu_transparent_border_value"]/100);
$menuLinkBgTransparent = ($this->menuColors["top_link_transparent_bg_value"]/100);
$menuLinkHoverBgTransparent = ($this->menuColors["top_link_transparent_bg_h_value"]/100);
$stickyCartBgValue = ($this->stickyHeaderColors["sticky_cart_transparent_bg_value"]/100);
$stickyCartHoverBgValue = ($this->stickyHeaderColors["sticky_cart_transparent_bg_h_value"]/100);
$stickyMenuLinkBgValue = ($this->stickyHeaderColors["sticky_menu_link_transparent_bg_value"]/100);
$stickyMenuHoverLinkBgValue = ($this->stickyHeaderColors["sticky_menu_link_transparent_bg_h_value"]/100);
$revSliderButtonsBg = ($this->revSliderButtonsColors["buttons_transparent_bg_value"]/100);
$revSliderButtonsBorder = ($this->revSliderButtonsColors["buttons_transparent_border_value"]/100);
$revSliderButtonsHoverBg = ($this->revSliderButtonsColors["buttons_transparent_bg_h_value"]/100);
$revSliderButtonsHoverBorder = ($this->revSliderButtonsColors["buttons_transparent_border_h_value"]/100);

$pageNotFoundBorder = ($this->pageNotFoundColors["transparent_border_color_value"]/100);
$pageNotFoundWidgetBorder = ($this->pageNotFoundColors["transparent_widget_title_divider_value"]/100);
$pageNotFoundFooterLinksBg = ($this->pageNotFoundColors["transparent_footer_links_bg_value"]/100);
$pageNotFoundFooterLinksBgH = ($this->pageNotFoundColors["transparent_footer_links_bg_h_value"]/100);
$pageNotFoundProductsDivider = ($this->pageNotFoundColors["transparent_products_divider_color_value"]/100);

$css .= '
/*====== Header ======*/
';
if($this->headerColors['gradient_header_bg'] == 0) {
$css .= '
header.header,
.topline,
body.boxed-layout .topline .container_12 {background: #' . $this->headerColors['header_bg'] . ';}
'; } else {
$css .= '
header.header,
body.boxed-layout .topline .container_12 {
	background: #' . $this->headerColors['gradient_header_bg_start'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_header_bg_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_header_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_header_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_header_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_header_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_header_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_header_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_bg_end'] . ' 100%);
}
';}
$css .= '
header.header .top-block,
body.boxed-layout header.header .top-block .container_12 {background-color: #' . $this->headerColors['header_top_bg'] . ';}
header.header,
header#header .welcome-msg,
#header a.phone,
#header a.phone:visited,
#header a.phone:focus {color: #' . $this->headerColors['header_color'] . ';}
header.header a {color: #' . $this->headerColors['header_link_color'] . ';}
header.header a:hover {color: #' . $this->headerColors['header_link_color_h'] . ';}
header.header,
body.boxed-layout header.header .menu-line .container_12 {
	border-bottom-color: #' . $this->headerColors['header_border_color'] . ';
	border-width: ' . $this->headerColors['header_border_width'] . 'px;
} 

/**** Header language and currency switchers ****/
header#header .language-currency-block {
	background-color: #' . $this->headerColors['header_lang_currency_bg'] . ';
	color: #' . $this->headerColors['header_lang_currency_text'] . ';
}
header#header .language-currency-block:hover,
header#header .language-currency-block.open {
	background-color: #' . $this->headerColors['header_lang_currency_bg_h'] . ';
	color: #' . $this->headerColors['header_lang_currency_text_h'] . ';
}
header#header .language-currency-dropdown {background-color: #' . $this->headerColors['header_lang_currency_dropdown_bg'] . ';}
header#header .language-currency-dropdown label {color: #' . $this->headerColors['header_lang_currency_label'] . ';}
header#header .language-currency-dropdown .sbSelector {
	color: #' . $this->headerColors['header_lang_currency_swither_color'] . ';
	background-color: #' . $this->headerColors['header_lang_currency_swither_bg'] . ';
	border-color: #' . $this->headerColors['header_lang_currency_swither_border'] . ';
}
header#header .language-currency-dropdown .sbOptions {background-color: #' . $this->headerColors['header_lang_currency_swither_dropdown'] . ';}
header#header .language-currency-dropdown .sbOptions li a,
header#header .language-currency-dropdown > div > a {color: #' . $this->headerColors['header_lang_currency_swither_dropdown_link'] . ';}
header#header .language-currency-dropdown .sbOptions li:hover {background-color: #' . $this->headerColors['header_lang_currency_swither_dropdown_link_bg_h'] . ';}
header#header .language-currency-dropdown .sbOptions li:hover a,
header#header .language-currency-dropdown > div > a:hover {color: #' . $this->headerColors['header_lang_currency_swither_dropdown_link_h'] . ';}

/**** Header Search ****/
header.header .form-search input {
	background-color: ' . ($this->headerColors['header_search_transparent_bg'] == 0 ? ' #' . $this->headerColors["header_search_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->headerColors['header_search_bg']).', '.$searchBgTransparent.')').';
	border-color: ' . ($this->headerColors['header_search_transparent_border'] == 0 ? ' #' . $this->headerColors["header_search_border"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->headerColors['header_search_border']).', '.$searchBorderTransparent.')').';
	color: #' . $this->headerColors['header_search_color'] . ';
	border-width: ' . $this->headerColors['header_search_border_width'] . 'px;
}
';
if($this->headerColors['gradient_header_search_button_bg'] == 0) {
$css .= '
header.header .form-search button > span {
	border-color: #' . $this->headerColors['header_search_border'] . ';
	background-color: #' . $this->headerColors['header_search_button_bg'] . ';
	color: #' . $this->headerColors['header_search_button_color'] . ';
	border-width: ' . $this->headerColors['header_search_border_width'] . 'px;
}
'; } else {
$css .= '
header.header .form-search button > span {
	border-color: #' . $this->headerColors['header_search_border'] . ';
	color: #' . $this->headerColors['header_search_button_color'] . ';
	border-width: ' . $this->headerColors['header_search_border_width'] . 'px;
	background: #' . $this->headerColors['gradient_header_search_button_bg_start'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_header_search_button_bg_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_header_search_button_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_header_search_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_end'] . ' 100%);
}
';}
if($this->headerColors['gradient_header_search_button_bg_h'] == 0) {
$css .= '
header.header .form-search button:hover > span {
	background-color: #' . $this->headerColors['header_search_button_bg_h'] . ';
	color: #' . $this->headerColors['header_search_button_color_h'] . ';
	background-image: none;
}
'; } else {
$css .= '
header.header .form-search button:hover > span {
	color: #' . $this->headerColors['header_search_button_color_h'] . ';
	background: #' . $this->headerColors['gradient_header_search_button_bg_h_start'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_header_search_button_bg_h_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_header_search_button_bg_h_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_h_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_h_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_h_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_h_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_header_search_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_button_bg_h_end'] . ' 100%);
}
';}
$css .= '
header.header .form-search .focus input {
	background-color: ' . ($this->headerColors['header_search_active_transparent_bg'] == 0 ? ' #' . $this->headerColors["header_search_active_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->headerColors['header_search_active_bg']).', '.$searchActiveBgTransparent.')').';
	border-color: ' . ($this->headerColors['header_search_active_transparent_border'] == 0 ? ' #' . $this->headerColors["header_search_active_border"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->headerColors['header_search_active_border']).', '.$searchActiveBorderTransparent.')').';
	color: #' . $this->headerColors['header_search_active_color'] . ';
}
';
if($this->headerColors['gradient_header_search_active_button_bg'] == 0) {
$css .= '
header.header .form-search .focus button > span {
	border-color: #' . $this->headerColors['header_search_active_border'] . ';
	background-color: #' . $this->headerColors['header_search_active_button_bg'] . ';
	color: #' . $this->headerColors['header_search_active_button_color'] . ';
}
'; } else {
$css .= '
header.header .form-search .focus button > span {
	border-color: #' . $this->headerColors['header_search_active_border'] . ';
	color: #' . $this->headerColors['header_search_active_button_color'] . ';
	background: #' . $this->headerColors['gradient_header_search_active_button_bg_start'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_header_search_active_button_bg_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_header_search_active_button_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_active_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_active_button_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_active_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_active_button_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_active_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_active_button_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_header_search_active_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_active_button_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_header_search_active_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_header_search_active_button_bg_end'] . ' 100%);
}
';}
if($this->headerColors['gradient_cart_bg'] == 0) {
$css .= '
/**** Header Cart ****/
header.header .top-cart .block-title .title-cart {
	background-color: ' . ($this->headerColors['cart_transparent_bg'] == 0 ? ' #' . $this->headerColors["cart_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->headerColors['cart_bg']).', '.$cartBgTransparent.')').';
	color: #' . $this->headerColors['cart_color'] . ';
}
'; } else {
$css .= '
/**** Header Cart ****/
header.header .top-cart .block-title .title-cart {
	color: #' . $this->headerColors['cart_color'] . ';
	background: #' . $this->headerColors['gradient_cart_bg_start'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_cart_bg_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_cart_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_cart_bg_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_cart_bg_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_cart_bg_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_cart_bg_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_cart_bg_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_end'] . ' 100%);
}
';}
$css .= '
header.header .top-cart .block-title .cart-qty {color: #' . $this->headerColors['cart_text_color'] . ';}
header.header .top-cart .block-title .price {color: #' . $this->headerColors['cart_price_color'] . ';}
';
if($this->headerColors['gradient_cart_bg_h'] == 0) {
$css .= '
header.header .top-cart .block-title .title-cart:hover,
header.header .top-cart .block-title.active .title-cart {
	background-color: ' . ($this->headerColors['cart_transparent_bg_h'] == 0 ? ' #' . $this->headerColors["cart_bg_h"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->headerColors['cart_bg_h']).', '.$cartHoverBgTransparent.')').';
	color: #' . $this->headerColors['cart_color_h'] . ';
	background-image: none;
}
'; } else {
$css .= '
header.header .top-cart .block-title .title-cart:hover,
header.header .top-cart .block-title.active .title-cart {
	color: #' . $this->headerColors['cart_color_h'] . ';
	background: #' . $this->headerColors['gradient_cart_bg_h_start'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_cart_bg_h_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_cart_bg_h_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_cart_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_h_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_cart_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_h_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_cart_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_h_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_cart_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_h_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_cart_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_cart_bg_h_end'] . ' 100%);
}
';}
$css .= '
header.header .top-cart .block-title .title-cart:hover .cart-qty,
header.header .top-cart .block-title.active .title-cart .cart-qty {color: #' . $this->headerColors['cart_text_color_h'] . ';}
header.header .top-cart .block-title .title-cart:hover .price,
header.header .top-cart .block-title.active .title-cart .price {color: #' . $this->headerColors['cart_price_color_h'] . ';}
header.header .top-cart .block-content {
	background-color: #' . $this->headerColors['cart_dropdown_bg'] . ';
	box-shadow: 0 0 5px rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->headerColors['cart_dropdown_shadow']).',.1); 
}
header.header .top-cart .product-name a {color: #' . $this->headerColors['cart_dropdown_product_title'] . ';}
header.header .top-cart .product-name a:hover {color: #' . $this->headerColors['cart_dropdown_product_title_h'] . ';}
header.header .top-cart .block-content .mini-products-list .product-details .price {color: #' . $this->headerColors['cart_dropdown_product_price'] . ';}
header.header .top-cart .cart-price-qt strong {
	background-color: #' . $this->headerColors['cart_dropdown_count_bg'] . ';
	color: #' . $this->headerColors['cart_dropdown_count_color'] . ';
}
header.header .top-cart .block-content .item-options dt {color: #' . $this->headerColors['cart_dropdown_label_color'] . ';}
header.header .top-cart .block-content .item-options dd {color: #' . $this->headerColors['cart_dropdown_options_color'] . ';}
header.header .top-cart .btn-edit i,
header.header .top-cart .btn-remove i {color: #' . $this->headerColors['cart_dropdown_icons_color'] . ';}
header.header .top-cart .btn-edit i:hover,
header.header .top-cart .btn-remove i:hover {color: #' . $this->headerColors['cart_dropdown_icons_color_h'] . ';}
header.header .top-cart .block-content .subtotal .label,
header.header .top-cart .block-content .subtotal .price {color: #' . $this->headerColors['cart_dropdown_total_color'] . ';}
header.header .top-cart .block-content .subtotal {
	border-color: #' . $this->headerColors['cart_dropdown_total_border'] . ';
	border-width: ' . $this->headerColors['cart_dropdown_total_border_width'] . 'px;
}

/**** Login and Wishlist ****/
';
if($this->headerColors['gradient_login_wishlist_bg'] == 0) {
$css .= '
.top-link-wishlist i,
header#header .links li a i,
header#header .customer-name,
header#header.skin5-header .search-button {
	background-color: ' . ($this->headerColors['login_wishlist_transparent_bg'] == 0 ? ' #' . $this->headerColors["login_wishlist_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->headerColors['login_wishlist_bg']).', '.$loginWishlistBgTransparent.')').';
	color: #' . $this->headerColors['login_wishlist_color'] . ';
}
'; } else {
$css .= '
.top-link-wishlist i,
header#header .links li a i,
header#header .customer-name,
header#header.skin5-header .search-button {
	color: #' . $this->headerColors['login_wishlist_color'] . ';
	background: #' . $this->headerColors['gradient_login_wishlist_bg_start'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_login_wishlist_bg_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_login_wishlist_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_login_wishlist_bg_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_login_wishlist_bg_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_login_wishlist_bg_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_login_wishlist_bg_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_login_wishlist_bg_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_end'] . ' 100%);
}
';}
if($this->headerColors['gradient_login_wishlist_bg_h'] == 0) {
$css .= '
.top-link-wishlist:hover i,
header#header .links li a:hover i,
header#header.skin5-header .search-button:hover,
header#header.skin5-header .search-button.open {
	background-color: ' . ($this->headerColors['login_wishlist_transparent_bg_h'] == 0 ? ' #' . $this->headerColors["login_wishlist_bg_h"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->headerColors['login_wishlist_bg_h']).', '.$loginWishlistHoverBgTransparent.')').';
	color: #' . $this->headerColors['login_wishlist_color_h'] . ';
	background-image: none;
} 
'; } else {
$css .= '
.top-link-wishlist:hover i,
header#header .links li a:hover i,
header#header.skin5-header .search-button:hover,
header#header.skin5-header .search-button.open {
	color: #' . $this->headerColors['login_wishlist_color_h'] . ';
	background: #' . $this->headerColors['gradient_login_wishlist_bg_h_start'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_login_wishlist_bg_h_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_login_wishlist_bg_h_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_login_wishlist_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_h_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_login_wishlist_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_h_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_login_wishlist_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_h_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_login_wishlist_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_h_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_login_wishlist_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_login_wishlist_bg_h_end'] . ' 100%);
}
';}
$css .= '
.top-link-wishlist .wishlist-items {color: #' . $this->headerColors['login_wishlist_text_color'] . ';}
.top-link-wishlist:hover .wishlist-items {color: #' . $this->headerColors['login_wishlist_text_color_h'] . ';}

/**** Account Block ****/
header#header .customer-name.open .arrow i,
header#header .customer-name:hover .arrow i {background-color: #' . $this->headerColors['login_active_button_bg'] . ';}
header#header .customer-name .user i {
	background-color: #' . $this->headerColors['login_user_icon_bg'] . ';
	color: #' . $this->headerColors['login_user_icon'] . ';
} 
header#header .customer-name .arrow i {color: #' . $this->headerColors['login_submenu_icon'] . ';}
header#header .customer-name + .links {background-color: #' . $this->headerColors['login_submenu_bg'] . ';}
header#header .customer-name + .links li {
	border-color: #' . $this->headerColors['login_submenu_link_divider'] . ';
	border-width: ' . $this->headerColors['login_submenu_link_divider_width'] . 'px;
}
header#header .customer-name + .links li a {
	color: #' . $this->headerColors['login_submenu_link_color'] . ';
	background-color: #' . $this->headerColors['login_submenu_link_bg'] . ';
} 
header#header .customer-name + .links li a:hover {
	color: #' . $this->headerColors['login_submenu_link_color_h'] . ';
	background-color: #' . $this->headerColors['login_submenu_link_bg_h'] . ';
} 

/**** Login and Register Popup ****/
#login-holder {background-color: #' . $this->headerColors['login_popup_form_bg'] . ';} 
#login-holder .page-title {
	border-color: #' . $this->headerColors['login_popup_title_border'] . '; 
	border-width: ' . $this->headerColors['login_popup_title_border_width'] . 'px; 
}
#login-holder .page-title h1 {color: #' . $this->headerColors['login_popup_title_color'] . ';} 
#login-holder form p.required,
#login-holder .form-list label.required em {color: #' . $this->headerColors['login_popup_system_text'] . ';} 
#login-holder form p {color: #' . $this->headerColors['login_popup_text_color'] . ';} 
#login-holder .page-title .forgot-pass {color: #' . $this->headerColors['login_popup_forgot_link'] . ';} 
#login-holder .page-title .forgot-pass:hover {color: #' . $this->headerColors['login_popup_forgot_link_h'] . ';} 
#login-holder .close-button i {color: #' . $this->headerColors['login_popup_icon_color'] . ';} 
#login-holder .close-button i:hover {color: #' . $this->headerColors['login_popup_icon_color_h'] . ';} 
#login-holder form .input-box input {
	border-color: #' . $this->headerColors['login_popup_input_border'] . '; 
	background-color: #' . $this->headerColors['login_popup_input_bg'] . '; 
	color: #' . $this->headerColors['login_popup_input_color'] . '; 
}
#login-holder form .fieldset .legend {color: #' . $this->headerColors['login_popup_subtitle_color'] . ';} 
#login-holder .account-create .form-list label {color: #' . $this->headerColors['login_popup_label_color'] . ';} 

/*====== Category Labels =======*/
.nav-wide li.level-top .category-label.label_one { 
    background-color: #' . $this->catlabelsColors['label_one'] . ';
    border-color: #' . $this->catlabelsColors['label_one'] . ';
    color: #' . $this->catlabelsColors['label_one_color'] . ';
}
.nav-wide li.level-top.over .category-label.label_one { 
    background-color: #' . $this->catlabelsColors['label_one_h'] . ';
    border-color: #' . $this->catlabelsColors['label_one_h'] . ';
    color: #' . $this->catlabelsColors['label_one_color_h'] . ';
}
.nav-wide li.level-top .category-label.label_two { 
    background-color: #' . $this->catlabelsColors['label_two'] . ';
    border-color: #' . $this->catlabelsColors['label_two'] . ';
    color: #' . $this->catlabelsColors['label_two_color'] . ';
}
.nav-wide li.level-top.over .category-label.label_two { 
    background-color: #' . $this->catlabelsColors['label_two_h'] . ';
    border-color: #' . $this->catlabelsColors['label_two_h'] . ';
    color: #' . $this->catlabelsColors['label_two_color_h'] . ';
}
.nav-wide li.level-top .category-label.label_three { 
    background-color: #' . $this->catlabelsColors['label_three'] . ';
    border-color: #' . $this->catlabelsColors['label_three'] . ';
    color: #' . $this->catlabelsColors['label_three_color'] . ';
}
.nav-wide li.level-top.over .category-label.label_three { 
    background-color: #' . $this->catlabelsColors['label_three_h'] . ';
    border-color: #' . $this->catlabelsColors['label_three_h'] . ';
    color: #' . $this->catlabelsColors['label_three_color_h'] . ';
}

/*====== Sticky Header ======*/
body .header-wrapper header#sticky-header,
header#sticky-header .menu-line,
body.boxed-layout .header-wrapper header#sticky-header .topline .container_12,
body.boxed-layout .header-wrapper header#sticky-header .menu-line .container_12,
header#sticky-header.floating .search_mini_form {background-color: #' . $this->stickyHeaderColors['sticky_header_bg'] . ';}

/**** Menu ****/
header#sticky-header .nav-container a.level-top {background-color: ' . ($this->stickyHeaderColors['sticky_menu_link_transparent_bg'] == 0 ? ' #' . $this->stickyHeaderColors["sticky_menu_link_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->stickyHeaderColors['sticky_menu_link_bg']).', '.$stickyMenuLinkBgValue.')').';}
header#sticky-header .nav-container a.level-top > span {color: #' . $this->stickyHeaderColors['sticky_menu_link_color'] . ';}
header#sticky-header .nav-container a.level-top:hover,
header#sticky-header .nav-container .active a.level-top,
header#sticky-header .nav-container .over a.level-top {
	background-color: ' . ($this->stickyHeaderColors['sticky_menu_link_transparent_bg_h'] == 0 ? ' #' . $this->stickyHeaderColors["sticky_menu_link_bg_h"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->stickyHeaderColors['sticky_menu_link_bg_h']).', '.$stickyMenuHoverLinkBgValue.')').';
	border-bottom-color: #' . $this->stickyHeaderColors['sticky_menu_link_divider'] . ';
    border-bottom-width: ' . $this->stickyHeaderColors['sticky_menu_link_divider_width'] . 'px;
    margin-top: -' . $this->stickyHeaderColors['sticky_menu_link_divider_width'] . 'px;
}
header#sticky-header .nav-container a.level-top:hover > span,
header#sticky-header .nav-container .active a.level-top > span,
header#sticky-header .nav-container .over a.level-top > span {color: #' . $this->stickyHeaderColors['sticky_menu_link_color_h'] . ';}

/**** Cart ****/
header#sticky-header  .top-cart .block-title .title-cart {
	background-color: ' . ($this->stickyHeaderColors['sticky_cart_transparent_bg'] == 0 ? ' #' . $this->stickyHeaderColors["sticky_cart_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->stickyHeaderColors['sticky_cart_bg']).', '.$stickyCartBgValue.')').';
	color: #' . $this->stickyHeaderColors['sticky_cart_color'] . ';
	background-image: none;
}
header#sticky-header  .top-cart .block-title .cart-qty {color: #' . $this->stickyHeaderColors['sticky_cart_text_color'] . ';}
header#sticky-header  .top-cart .block-title .price  {color: #' . $this->stickyHeaderColors['sticky_cart_price_color'] . ';}
header#sticky-header  .top-cart .block-title .title-cart:hover,
header#sticky-header  .top-cart .block-title.active .title-cart {
	background-color: ' . ($this->stickyHeaderColors['sticky_cart_transparent_bg_h'] == 0 ? ' #' . $this->stickyHeaderColors["sticky_cart_bg_h"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->stickyHeaderColors['sticky_cart_bg_h']).', '.$stickyCartHoverBgValue.')').';
	color: #' . $this->stickyHeaderColors['sticky_cart_color_h'] . ';
}
header#sticky-header  .top-cart .block-title .title-cart:hover .cart-qty,
header#sticky-header  .top-cart .block-title.active .title-cart .cart-qty {color: #' . $this->stickyHeaderColors['sticky_cart_text_color_h'] . ';}
header#sticky-header  .top-cart .block-title .title-cart:hover .price,
header#sticky-header  .top-cart .block-title.active .title-cart .price {color: #' . $this->stickyHeaderColors['sticky_cart_price_color_h'] . ';}

/**** Search Button ****/
header#sticky-header .search-button {
	background-color: #' . $this->stickyHeaderColors['sticky_search_bg'] . ';
	color: #' . $this->stickyHeaderColors['sticky_search_color'] . ';
	border-color: #' . $this->stickyHeaderColors['sticky_search_border'] . ';
	border-width: ' . $this->stickyHeaderColors['sticky_search_border_width'] . 'px;
}
header#sticky-header .search-button:hover,
header#sticky-header .search-button.open {
	background-color: #' . $this->stickyHeaderColors['sticky_search_bg_h'] . ';
	color: #' . $this->stickyHeaderColors['sticky_search_color_h'] . ';
	border-color: #' . $this->stickyHeaderColors['sticky_search_border_h'] . ';
}

/*====== Menu =======*/
';
if($this->menuColors['menu_bg_filling'] == 0) {
	$css .= '
header.header .menu-line,
body.boxed-layout header.header .menu-line .container_12 {background-color: ' . ($this->menuColors['menu_transparent_bg'] == 0 ? ' #' . $this->menuColors["menu_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->menuColors['menu_bg']).', '.$menuBgTransparent.')').';}
.topline {
	border-bottom-width: ' . $this->menuColors['menu_border_width'] . 'px;
	border-color: ' . ($this->menuColors['menu_transparent_border'] == 0 ? ' #' . $this->menuColors["menu_border"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->menuColors['menu_border']).', '.$menuBorderTransparent.')').';
}

'; } else {
	$css .= '
header.header .menu-line .grid_12,
body.boxed-layout header.header .menu-line .container_12 {background-color: ' . ($this->menuColors['menu_transparent_bg'] == 0 ? ' #' . $this->menuColors["menu_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->menuColors['menu_bg']).', '.$menuBgTransparent.')').';}
.topline .grid_12 {
	border-bottom-width: ' . $this->menuColors['menu_border_width'] . 'px;
	border-color: ' . ($this->menuColors['menu_transparent_border'] == 0 ? ' #' . $this->menuColors["menu_border"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->menuColors['menu_border']).', '.$menuBorderTransparent.')').';
}
';}
$css .= '

/**** Top Level ****/
.nav-container a.level-top {
	background-color: ' . ($this->menuColors['top_link_transparent_bg'] == 0 ? ' #' . $this->menuColors["top_link_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->menuColors['top_link_bg']).', '.$menuLinkBgTransparent.')').';
	
} 
.nav-container a.level-top > span {color: #' . $this->menuColors['top_link_color'] . ';}
.nav-container a.level-top:hover,
.nav-container .active a.level-top,
.nav-container .over a.level-top {
	background-color: ' . ($this->menuColors['top_link_transparent_bg_h'] == 0 ? ' #' . $this->menuColors["top_link_bg_h"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->menuColors['top_link_bg_h']).', '.$menuLinkHoverBgTransparent.')').';
	border-bottom-width: ' . $this->menuColors['top_link_divider_width'] . 'px;
	border-bottom-color: #' . $this->menuColors['top_link_divider'] . ';
} 
.nav-container a.level-top:hover > span,
.nav-container .active a.level-top > span,
.nav-container .over a.level-top > span {color: #' . $this->menuColors['top_link_color_h'] . ';}

/**** Submenu ****/
.nav-wide .menu-wrapper,
.nav ul {background-color: #' . $this->menuColors['submenu_bg'] . ';}
.nav-wide ul.level0 li.level1 span.subtitle {
	background-color: #' . $this->menuColors['submenu_top_link_bg'] . ';
	border-width: ' . $this->menuColors['submenu_top_link_border_width'] . 'px;
	border-color: #' . $this->menuColors['submenu_top_link_border'] . ';
	color: #' . $this->menuColors['submenu_top_link_color'] . ';
}
.nav-wide ul.level0 li.level1 span.subtitle:hover {
	background-color: #' . $this->menuColors['submenu_top_link_bg_h'] . ';
	border-color: #' . $this->menuColors['submenu_top_link_border_h'] . ';
	color: #' . $this->menuColors['submenu_top_link_color_h'] . ';
}
.nav-wide ul.level1 a,
.nav ul li a,
.nav-wide .menu-wrapper.default-menu ul.level0 li.level1 a {
	background-color: #' . $this->menuColors['submenu_link_bg'] . ';
	color: #' . $this->menuColors['submenu_link_color'] . ';
}
.nav-wide ul li,
.nav-wide ul.level1 ul,
.nav ul li,
.nav-wide .menu-wrapper.default-menu ul.level0 li {
	border-width: ' . $this->menuColors['submenu_link_border_width'] . 'px;
	border-color: #' . $this->menuColors['submenu_link_border'] . ';
}
.nav-wide .menu-wrapper.default-menu ul.level0 li.level1 a:hover span,
.nav-wide ul.level1 a:hover,
.nav ul li a:hover,
.nav-wide .menu-wrapper.default-menu ul.level0 li.level1 a:hover {
	background-color: #' . $this->menuColors['submenu_link_bg_h'] . ';
	color: #' . $this->menuColors['submenu_link_color_h'] . ';
}
.nav-wide ul li:hover,
.nav-wide ul.level1 ul:hover,
.nav ul li:hover,
.nav-wide .menu-wrapper.default-menu ul.level0 li:hover {border-color: #' . $this->menuColors['submenu_link_border_h'] . ';}
.nav-wide .bottom-content span,
.nav-wide .top-content,
.nav-wide .top-content .left-links li {
	border-width: ' . $this->menuColors['submenu_borders_width'] . 'px;
	border-color: #' . $this->menuColors['submenu_borders_color'] . ';
}
.nav-wide .bottom-content,
.nav-wide .top-content,
.nav-wide .bottom-content span,
.nav-wide {color: #' . $this->menuColors['submenu_text_color'] . ';}
.nav-wide .top-content .left-links li a,
.nav-wide .bottom-content span strong {color: #' . $this->menuColors['submenu_strong_text_color'] . ';}
.nav-wide .top-content .right-link a {color: #' . $this->menuColors['submenu_strong_link_color'] . ';}
.nav-wide .top-content .right-link a:hover {color: #' . $this->menuColors['submenu_strong_link_color_h'] . ';}

/*====== Revolution Slider Buttons =======*/
.rev_slider_wrapper .tp-leftarrow.default,
.rev_slider_wrapper .tp-rightarrow.default {
	background-color: ' . ($this->revSliderButtonsColors['buttons_transparent_bg'] == 0 ? ' #' . $this->revSliderButtonsColors["buttons_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->revSliderButtonsColors['buttons_bg']).', '.$revSliderButtonsBg.')').';
	border-color: ' . ($this->revSliderButtonsColors['buttons_transparent_border'] == 0 ? ' #' . $this->revSliderButtonsColors["buttons_border"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->revSliderButtonsColors['buttons_border']).', '.$revSliderButtonsBorder.')').';
	border-width: ' . $this->revSliderButtonsColors['buttons_border_width'] . 'px;
}
.rev_slider_wrapper .tp-leftarrow.default:after, 
.rev_slider_wrapper .tp-rightarrow.default:after {color: #' . $this->revSliderButtonsColors['buttons_color'] . ';}

.rev_slider_wrapper .tp-leftarrow.default:hover,
.rev_slider_wrapper .tp-rightarrow.default:hover {
	background-color: ' . ($this->revSliderButtonsColors['buttons_transparent_bg_h'] == 0 ? ' #' . $this->revSliderButtonsColors["buttons_bg_h"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->revSliderButtonsColors['buttons_bg_h']).', '.$revSliderButtonsHoverBg.')').';
	border-color: ' . ($this->revSliderButtonsColors['buttons_transparent_border_h'] == 0 ? ' #' . $this->revSliderButtonsColors["buttons_border_h"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->revSliderButtonsColors['buttons_border_h']).', '.$revSliderButtonsHoverBorder.')').';
}
.rev_slider_wrapper .tp-leftarrow.default:hover:after, 
.rev_slider_wrapper .tp-rightarrow.default:hover:after {color: #' . $this->revSliderButtonsColors['buttons_color_h'] . ';}

/*====== Parallax Banners ======*/
.parallax-banners-wrapper .text-banner .banner-content.colors-1 p {color: #' . $this->parallaxBannersColors['colors1_text'] . ';}
.parallax-banners-wrapper .text-banner .banner-content.colors-1 h2 {
	color: #' . $this->parallaxBannersColors['colors1_title'] . ';
	border-color: #' . $this->parallaxBannersColors['colors1_title_border'] . ';
	border-width: ' . $this->parallaxBannersColors['colors1_title_border_width'] . 'px;
}
.parallax-banners-wrapper .text-banner .banner-content.colors-1 h2 span {color: #' . $this->parallaxBannersColors['colors1_title_span_color'] . ';}
.parallax-banners-wrapper .text-banner .banner-content.colors-1 h3 {color: #' . $this->parallaxBannersColors['colors1_subtitle_color'] . ';}
.parallax-banners-wrapper .text-banner .banner-content.colors-1 button span span {
	background-color: #' . $this->parallaxBannersColors['colors1_button_bg'] . ';
	color: #' . $this->parallaxBannersColors['colors1_button_color'] . ';
}
.parallax-banners-wrapper .text-banner .banner-content.colors-1 button > span {
	border-width: ' . $this->parallaxBannersColors['colors1_button_border_width'] . 'px;
	border-color: #' . $this->parallaxBannersColors['colors1_button_border'] . ';
}
.parallax-banners-wrapper .text-banner .banner-content.colors-1 button:hover span span {
	background-color: #' . $this->parallaxBannersColors['colors1_button_bg_h'] . ';
	color: #' . $this->parallaxBannersColors['colors1_button_color_h'] . ';
}
.parallax-banners-wrapper .text-banner .banner-content.colors-1 button:hover > span {
	border-color: #' . $this->parallaxBannersColors['colors1_button_border_h'] . ';
}

.parallax-banners-wrapper .text-banner .banner-content.colors-2 p {color: #' . $this->parallaxBannersColors['colors2_text'] . ';}
.parallax-banners-wrapper .text-banner .banner-content.colors-2 h2 {
	color: #' . $this->parallaxBannersColors['colors2_title'] . ';
	border-color: #' . $this->parallaxBannersColors['colors2_title_border'] . ';
	border-width: ' . $this->parallaxBannersColors['colors2_title_border_width'] . 'px;
}
.parallax-banners-wrapper .text-banner .banner-content.colors-2 h2 span {color: #' . $this->parallaxBannersColors['colors2_title_span_color'] . ';}
.parallax-banners-wrapper .text-banner .banner-content.colors-2 h3 {color: #' . $this->parallaxBannersColors['colors2_subtitle_color'] . ';}
.parallax-banners-wrapper .text-banner .banner-content.colors-2 button span span {
	background-color: #' . $this->parallaxBannersColors['colors2_button_bg'] . ';
	color: #' . $this->parallaxBannersColors['colors2_button_color'] . ';
}
.parallax-banners-wrapper .text-banner .banner-content.colors-2 button > span {
	border-width: ' . $this->parallaxBannersColors['colors2_button_border_width'] . 'px;
	border-color: #' . $this->parallaxBannersColors['colors2_button_border'] . ';
}
.parallax-banners-wrapper .text-banner .banner-content.colors-2 button:hover span span {
	background-color: #' . $this->parallaxBannersColors['colors2_button_bg_h'] . ';
	color: #' . $this->parallaxBannersColors['colors2_button_color_h'] . ';
}
.parallax-banners-wrapper .text-banner .banner-content.colors-2 button:hover > span {
	border-color: #' . $this->parallaxBannersColors['colors2_button_border_h'] . ';
}

/*====== 404 page ======*/
.page-no-route header.header .form-search input {
	background-color: #' . $this->pageNotFoundColors['search_bg'] . ';
	border-color: #' . $this->pageNotFoundColors['search_border'] . ';
	border-width: ' . $this->pageNotFoundColors['search_border_width'] . 'px;
	color: #' . $this->pageNotFoundColors['search_color'] . ';
} 
.page-no-route header.header .form-search button > span {
	background-color: #' . $this->pageNotFoundColors['search_button_bg'] . ';
	color: #' . $this->pageNotFoundColors['search_button_color'] . ';
	border-color: #' . $this->pageNotFoundColors['search_button_border'] . ';
	border-width: ' . $this->pageNotFoundColors['search_button_border_width'] . 'px;
}
.page-no-route header.header .form-search button:hover > span {
	background-color: #' . $this->pageNotFoundColors['search_button_bg_h'] . ';
	color: #' . $this->pageNotFoundColors['search_button_color_h'] . ';
	border-color: #' . $this->pageNotFoundColors['search_button_border_h'] . ';
}
.page-no-route .text-block h2 {color: #' . $this->pageNotFoundColors['title_color'] . ';}
.page-no-route .text-block h3 {color: #' . $this->pageNotFoundColors['subtitle_color'] . ';}
.page-no-route .text-block p,
.page-no-route .no-route .block-or {color: #' . $this->pageNotFoundColors['text_color'] . ';}
.page-no-route .text-block .f-left {border-color: ' . ($this->pageNotFoundColors['transparent_border_color'] == 0 ? ' #' . $this->pageNotFoundColors["border_color"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->pageNotFoundColors['border_color']).', '.$pageNotFoundBorder.')').';}
.page-no-route .no-route .button > span {
	border-width: ' . $this->pageNotFoundColors['button_border_width'] . 'px;
	border-color: #' . $this->pageNotFoundColors['button_border'] . ';
}
.page-no-route .no-route .button:hover > span {border-color: #' . $this->pageNotFoundColors['button_border_h'] . ';}

';
if($this->headerColors['gradient_button_bg'] == 0) {
$css .= '
.page-no-route .no-route .button span span {
	background-color: #' . $this->pageNotFoundColors['buttonbg'] . ';
	color: #' . $this->pageNotFoundColors['button_link'] . ';
	background-image: none;
}
'; } else {
$css .= '
.page-no-route .no-route .button span span {
	background: #' . $this->headerColors['gradient_button_bg_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_button_bg_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_button_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_button_bg_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_end'] . ' 100%);
}
';}

if($this->headerColors['gradient_button_bg_h'] == 0) {
$css .= '
.page-no-route .no-route .button:hover span span {
	background-color: #' . $this->pageNotFoundColors['buttonbg_h'] . ';
	color: #' . $this->pageNotFoundColors['button_link_h'] . ';
	background-image: none;
}
'; } else {
$css .= '
.page-no-route .no-route .button span span {
	background: #' . $this->headerColors['gradient_button_bg_h_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->headerColors['gradient_button_bg_h_start'] . '),
		color-stop(1, #' . $this->headerColors['gradient_button_bg_h_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->headerColors['gradient_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_h_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->headerColors['gradient_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_h_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->headerColors['gradient_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_h_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->headerColors['gradient_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_h_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->headerColors['gradient_button_bg_h_start'] . ' 0%, #' . $this->headerColors['gradient_button_bg_h_end'] . ' 100%);
}
';}
$css .= '
.page-no-route .no-route .block-or:before,
.page-no-route .no-route .block-or:after {background-color: ' . ($this->pageNotFoundColors['transparent_border_color'] == 0 ? ' #' . $this->pageNotFoundColors["border_color"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->pageNotFoundColors['border_color']).', '.$pageNotFoundBorder.')').';}
body .page-no-route .widget .widget-title,
.page-no-route .widget-title {
	border-color: ' . ($this->pageNotFoundColors['transparent_widget_title_divider'] == 0 ? ' #' . $this->pageNotFoundColors["widget_title_divider"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->pageNotFoundColors['widget_title_divider']).', '.$pageNotFoundWidgetBorder.')').';
	border-width: ' . $this->pageNotFoundColors['widget_title_divider_width'] . 'px;
}
body .page-no-route .widget .widget-title h2,
.page-no-route .widget-title h2 {color: #' . $this->pageNotFoundColors['widget_title'] . ';}
.page-no-route .products-grid .product-name a,
.page-no-route .products-list .product-name a {color: #' . $this->pageNotFoundColors['products_title_color'] . ';}
.page-no-route .products-grid .product-name a:hover,
.page-no-route .products-list .product-name a:hover {color: #' . $this->pageNotFoundColors['products_title_color_h'] . ';}

.page-no-route .products-list .desc,
.page-no-route .products-grid .desc {color: #' . $this->pageNotFoundColors['products_text_color'] . ';}
.page-no-route .products-list .desc a,
.page-no-route .products-grid .desc a {color: #' . $this->pageNotFoundColors['products_links_color'] . ';}
.page-no-route .products-list .desc a:hover,
.page-no-route .products-grid .desc a:hover {color: #' . $this->pageNotFoundColors['products_links_color_h'] . ';}

.page-no-route .price-box .price {color: #' . $this->pageNotFoundColors['products_price_color'] . ';}
.page-no-route .old-price .price,
.page-no-route .price-box .old-price .price {color: #' . $this->pageNotFoundColors['products_old_price_color'] . ';}
.page-no-route .special-price .price {color: #' . $this->pageNotFoundColors['products_special_price_color'] . ';}

.page-no-route .products-list .desc,
.page-no-route .products-list .price-box,
.page-no-route .products-list .ratings,
.page-no-route .products-list .product-name,
.page-no-route .products-grid li.item .product-buttons,
.page-no-route .products-grid li.item .product-buttons .btn-quick-view {
	border-color: ' . ($this->pageNotFoundColors['transparent_products_divider_color'] == 0 ? ' #' . $this->pageNotFoundColors["products_divider_color"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->pageNotFoundColors['products_divider_color']).', '.$pageNotFoundProductsDivider.')').';
	border-width: ' . $this->pageNotFoundColors['products_divider_width'] . 'px;
}

.page-no-route .footer-links li a {
	background-color: ' . ($this->pageNotFoundColors['transparent_footer_links_bg'] == 0 ? ' #' . $this->pageNotFoundColors["footer_links_bg"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->pageNotFoundColors['footer_links_bg']).', '.$pageNotFoundFooterLinksBg.')').';
	color: #' . $this->pageNotFoundColors['footer_links'] . ';
}
.page-no-route .footer-links li a:hover {
	background-color: ' . ($this->pageNotFoundColors['transparent_footer_links_bg_h'] == 0 ? ' #' . $this->pageNotFoundColors["footer_links_bg_h"] . ' ' : 'rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->pageNotFoundColors['footer_links_bg_h']).', '.$pageNotFoundFooterLinksBgH.')').'; 
	color: #' . $this->pageNotFoundColors['footer_links_h'] . '; 
}
.page-no-route #footer address,
.page-no-route #footer address a {color: #' . $this->pageNotFoundColors['copyright_color'] . ';}

/*====== Content =======*/
body .widget .widget-title h1,
body .widget .widget-title h2,
.widget-title h2,
.page-title h1,
.page-title h2,
.page-title h3,
.page-title h4,
.page-title h5,
.page-title h6,
.opc-wrapper-opc h2.opc-title,
.op_block_title,
.related-wrapper-bottom .block-title strong span,
.rating-title h2 {color: #' . $this->contentColors['title_color'] . ';}
.page-title,
.widget .widget-title,
.widget-title,
.related-wrapper-bottom .block-title,
.rating-title {
	border-color: #' . $this->contentColors['title_border'] . ';
	border-width: ' . $this->contentColors['title_border_width'] . 'px;
}

/**** Toolbar ****/
.toolbar {background-color: #' . $this->contentColors['toolbar_bg'] . ';}
.sorter label {color: #' . $this->contentColors['toolbar_label'] . ';}
.toolbar .sbSelector,
.toolbar .sbOptions,
.toolbar .sbHolder .sbToggleOpen + .sbSelector {background-color: #' . $this->contentColors['toolbar_select_bg'] . ';}
.toolbar .sbSelector > span,
.toolbar .sbOptions a,
.toolbar .sbHolder .sbToggleOpen + .sbSelector,
.toolbar .sbHolder .sbToggleOpen + .sbSelector > span {
	color: #' . $this->contentColors['toolbar_select_text'] . ';
	border-top-color: #' . $this->contentColors['toolbar_select_text'] . ';
}
.toolbar .sbHolder .sbToggleOpen + .sbSelector {border-color: #' . $this->contentColors['toolbar_select_text'] . ';}

/**** Pager ****/
.pages li.current {
	background-color: #' . $this->contentColors['pager_active_button_bg'] . ';
	color: #' . $this->contentColors['pager_active_button'] . ';
}
.pages li {background-color: #' . $this->contentColors['pager_buttons_bg'] . ';}
.pages li a,
.pager .pages li a.i-previous i,
.pager .pages li a.i-next i  {color: #' . $this->contentColors['pager_buttons_color'] . ';}
.pages li:hover {background-color: #' . $this->contentColors['pager_buttons_bg_h'] . ';}
.pages li:hover a,
.pager .pages li:hover a.i-previous i,
.pager .pages li:hover a.i-next i {color: #' . $this->contentColors['pager_buttons_color_h'] . ';}


/*====== Buttons =======*/
';
if($this->buttonsColors['gradient_buttons_bg'] == 0) {
$css .= '
aside.sidebar .actions a,
header.header .top-cart .block-content .actions a,
#login-holder .link-box a,
a.aw-blog-read-more {
	background-color: #' . $this->buttonsColors['buttonsbg'] . ';
	color: #' . $this->buttonsColors['buttons_link'] . ';
	border-width: ' . $this->buttonsColors['buttons_border_width'] . 'px;
	border-color: #' . $this->buttonsColors['buttons_border'] . ';
	background-image: none;
}
.products-grid li.item .button-holder .btn-cart span span i,
aside.sidebar .block-poll .actions button span span,
.cart-table .buttons-row .buttons .btn-clear span span,
.cart-table .buttons-row .buttons .btn-update span span,
.my-wishlist .buttons-set .btn-share span span,
.my-wishlist .buttons-set .btn-add span span,
body .text-banner .banner-content button span span {
	background-color: #' . $this->buttonsColors['buttonsbg'] . ';
	color: #' . $this->buttonsColors['buttons_link'] . ';
	background-image: none;
}
'; } else {
$css .= '
aside.sidebar .actions a,
header.header .top-cart .block-content .actions a,
#login-holder .link-box a,
a.aw-blog-read-more {
	color: #' . $this->buttonsColors['buttons_link'] . ';
	border-width: ' . $this->buttonsColors['buttons_border_width'] . 'px;
	border-color: #' . $this->buttonsColors['buttons_border'] . ';
	background: #' . $this->buttonsColors['gradient_buttons_bg_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->buttonsColors['gradient_buttons_bg_start'] . '),
		color-stop(1, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);	
}
.products-grid li.item .button-holder .btn-cart span span i,
aside.sidebar .block-poll .actions button span span,
.cart-table .buttons-row .buttons .btn-clear span span,
.cart-table .buttons-row .buttons .btn-update span span,
.my-wishlist .buttons-set .btn-share span span,
.my-wishlist .buttons-set .btn-add span span,
body .text-banner .banner-content button span span {
	color: #' . $this->buttonsColors['buttons_link'] . ';
	background: #' . $this->buttonsColors['gradient_buttons_bg_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->buttonsColors['gradient_buttons_bg_start'] . '),
		color-stop(1, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->buttonsColors['gradient_buttons_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_end'] . ' 100%);	
}
';}
$css .= '
.products-grid li.item .button-holder .btn-cart > span,
aside.sidebar .block-poll .actions button > span,
.cart-table .buttons-row .buttons .btn-clear > span,
.cart-table .buttons-row .buttons .btn-update > span,
.my-wishlist .buttons-set .btn-share > span,
.my-wishlist .buttons-set .btn-add > span,
body .text-banner .banner-content button > span {
	border-width: ' . $this->buttonsColors['buttons_border_width'] . 'px;
	border-color: #' . $this->buttonsColors['buttons_border'] . ';
}
';
if($this->buttonsColors['gradient_buttons_bg_h'] == 0) {
$css .= '
aside.sidebar .actions a:hover,
header.header .top-cart .block-content .actions a:hover,
#login-holder .link-box a:hover,
a.aw-blog-read-more:hover {
	color: #' . $this->buttonsColors['buttons_link_h'] . ';
	border-color: #' . $this->buttonsColors['buttons_border_h'] . ';
	background-color: #' . $this->buttonsColors['buttonsbg_h'] . ';
	background-image: none;
}
.ias_trigger.active button.button span,
.products-grid li.item .button-holder .btn-cart:hover span span i,
aside.sidebar .block-poll .actions button:hover span span,
.cart-table .buttons-row .buttons .btn-clear:hover span span,
.cart-table .buttons-row .buttons .btn-update:hover span span,
.my-wishlist .buttons-set .btn-share:hover span span,
.my-wishlist .buttons-set .btn-add:hover span span,
body .text-banner .banner-content button:hover span span {
	background-color: #' . $this->buttonsColors['buttonsbg_h'] . ';
	color: #' . $this->buttonsColors['buttons_link_h'] . ';
	background-image: none;
}
'; } else {
$css .= '
aside.sidebar .actions a:hover,
header.header .top-cart .block-content .actions a:hover,
#login-holder .link-box a:hover,
a.aw-blog-read-more:hover {
	color: #' . $this->buttonsColors['buttons_link_h'] . ';
	border-color: #' . $this->buttonsColors['buttons_border_h'] . ';
	background: #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . '),
		color-stop(1, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
}
.ias_trigger.active button.button span,
.products-grid li.item .button-holder .btn-cart:hover span span i,
aside.sidebar .block-poll .actions button:hover span span,
.cart-table .buttons-row .buttons .btn-clear:hover span span,
.cart-table .buttons-row .buttons .btn-update:hover span span,
.my-wishlist .buttons-set .btn-share:hover span span,
.my-wishlist .buttons-set .btn-add:hover span span,
body .text-banner .banner-content button:hover span span {
	color: #' . $this->buttonsColors['buttons_link_h'] . ';
	background: #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . '),
		color-stop(1, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->buttonsColors['gradient_buttons_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_bg_h_end'] . ' 100%);
}
';}
$css .= '
.ias_trigger.active button.button > span,
.products-grid li.item .button-holder .btn-cart:hover > span,
aside.sidebar .block-poll .actions button:hover > span,
.cart-table .buttons-row .buttons .btn-clear:hover > span,
.cart-table .buttons-row .buttons .btn-update:hover > span,
.my-wishlist .buttons-set .btn-share:hover > span,
.my-wishlist .buttons-set .btn-add:hover > span,
body .text-banner .banner-content button:hover > span {
	border-color: #' . $this->buttonsColors['buttons_border_h'] . ';
}

/**** Buttons Type 2 ****/
';
if($this->buttonsColors['gradient_buttons_2_bg'] == 0) {
$css .= '
.widget-wrapper .category-button a:hover, 
.add-to-cart-success a {
	background-color: #' . $this->buttonsColors['buttons_2_bg'] . ';
	border-color: #' . $this->buttonsColors['buttons_2_border'] . ';
	color: #' . $this->buttonsColors['buttons_2_link'] . ';
	background-image: none;
}
body button.button span span,
body .text-banner .banner-content.skin-3 button span span,
#login-holder form .actions button span span,
aside.sidebar .actions button span span,
.products-list li.item .button-holder button.button span span,
.newsletter-line .block-subscribe button.button:hover span span {
	color: #' . $this->buttonsColors['buttons_2_link'] . ';
	background-color: #' . $this->buttonsColors['buttons_2_bg'] . ';
	background-image: none;
}
'; } else {
$css .= '
.widget-wrapper .category-button a:hover, 
.add-to-cart-success a {
	border-color: #' . $this->buttonsColors['buttons_2_border'] . ';
	color: #' . $this->buttonsColors['buttons_2_link'] . ';
	background: #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . '),
		color-stop(1, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
}
body button.button span span,
body .text-banner .banner-content.skin-3 button span span,
#login-holder form .actions button span span,
aside.sidebar .actions button span span,
.products-list li.item .button-holder button.button span span,
.newsletter-line .block-subscribe button.button:hover span span {
	color: #' . $this->buttonsColors['buttons_2_link'] . ';
	background: #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . '),
		color-stop(1, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_end'] . ' 100%);
}
';}
$css .= '
body button.button > span,
body .text-banner .banner-content.skin-3 button > span,
#login-holder form .actions button > span,
aside.sidebar .actions button > span,
.products-list li.item .button-holder button.button > span,
.newsletter-line .block-subscribe button.button:hover > span {
	border-color: #' . $this->buttonsColors['buttons_2_border'] . ';
}
';
if($this->buttonsColors['gradient_buttons_2_bg_h'] == 0) {
$css .= '
.widget-wrapper .category-button a, 
.add-to-cart-success a:hover {
	background-color: #' . $this->buttonsColors['buttons_2_bg_h'] . ';
	border-color: #' . $this->buttonsColors['buttons_2_border_h'] . ';
	color: #' . $this->buttonsColors['buttons_2_link_h'] . ';
	background-image: none;
}
body button.button:hover span span,
body .text-banner .banner-content.skin-3 button:hover span span,
#login-holder form .actions button:hover span span,
aside.sidebar .actions button:hover span span,
.products-list li.item .button-holder button.button:hover span span,
.newsletter-line .block-subscribe button.button span span {
	color: #' . $this->buttonsColors['buttons_2_link_h'] . ';
	background-color: #' . $this->buttonsColors['buttons_2_bg_h'] . ';
	background-image: none;
}
'; } else {
$css .= '
.widget-wrapper .category-button a, 
.add-to-cart-success a:hover {
	border-color: #' . $this->buttonsColors['buttons_2_border_h'] . ';
	color: #' . $this->buttonsColors['buttons_2_link_h'] . ';
	background: #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . '),
		color-stop(1, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
}
body button.button:hover span span,
body .text-banner .banner-content.skin-3 button:hover span span,
#login-holder form .actions button:hover span span,
aside.sidebar .actions button:hover span span,
.products-list li.item .button-holder button.button:hover span span,
.newsletter-line .block-subscribe button.button span span {
	color: #' . $this->buttonsColors['buttons_2_link_h'] . ';
	background: #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ';
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . '),
		color-stop(1, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ')
	);
	background-image: -o-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
	background-image: -moz-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
	background-image: -webkit-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
	background-image: -ms-linear-gradient(bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
	background-image: linear-gradient(to bottom, #' . $this->buttonsColors['gradient_buttons_2_bg_h_start'] . ' 0%, #' . $this->buttonsColors['gradient_buttons_2_bg_h_end'] . ' 100%);
}
';}
$css .= '
body button.button:hover > span,
body .text-banner .banner-content.skin-3 button:hover > span,
#login-holder form .actions button:hover > span,
aside.sidebar .actions button:hover > span,
.products-list li.item .button-holder button.button:hover > span,
.newsletter-line .block-subscribe button.button > span {
	border-color: #' . $this->buttonsColors['buttons_2_border_h'] . ';
}
.newsletter-line .block-subscribe button.button > span,
.widget-wrapper .category-button a,
button.button > span,
#login-holder form .actions button > span,
aside.sidebar .actions button > span,
.products-list li.item .button-holder button.button > span,
.add-to-cart-success a {border-width: ' . $this->buttonsColors['buttons_2_border_width'] . 'px;}

/*====== Products ======*/
.products-list li.item .product-img-box,
.products-grid li.item .product-img-box {
	background-color: #' . $this->productsColors['products_bg'] . ';
	border-width: ' . $this->productsColors['products_border_width'] . 'px;
	border-color: #' . $this->productsColors['products_border'] . ';
}
.products-grid .product-name a,
.products-list .product-name a {color: #' . $this->productsColors['products_title_color'] . ';}
.products-grid .product-name a:hover,
.products-list .product-name a:hover {color: #' . $this->productsColors['products_title_color_h'] . ';}
.products-list .desc,
.products-grid .desc {color: #' . $this->productsColors['produst_text_color'] . ';}
.products-list .desc a,
.products-grid .desc a {color: #' . $this->productsColors['products_links_color'] . ';}
.products-list .desc a:hover,
.products-grid .desc a:hover {color: #' . $this->productsColors['products_links_color_h'] . ';}
.price-box .price {color: #' . $this->productsColors['produst_price_color'] . ';}
.old-price .price,
.price-box .old-price .price {color: #' . $this->productsColors['produst_old_price_color'] . ';}
.special-price .price {color: #' . $this->productsColors['produst_special_price_color'] . ';}
.products-list .desc,
.products-list .price-box,
.products-list .ratings,
.products-list .product-name,
.products-grid li.item .product-buttons {
	border-color: #' . $this->productsColors['products_divider_color'] . ';
	border-width: ' . $this->productsColors['products_divider_width'] . 'px;
}

/**** Product Labels ****/
.products-grid .availability-only,
.products-list .availability-only,
.label-sale {
	background-color: #' . $this->productsColors['label_sale_bg'] . ';
	color: #' . $this->productsColors['label_sale_color'] . ';
}
.products-grid .availability-only,
.products-list .availability-only,
.label-sale strong {
	border-top-color: rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->productsColors['label_sale_border']).',.5);
	border-bottom-color: rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->productsColors['label_sale_border']).',.5);
	border-width: ' . $this->productsColors['label_sale_border_width'] . 'px;
}
.label-type-5 .label-sale:before,
.products-grid.label-type-5 .availability-only:before,
.products-list.label-type-5 .availability-only:before{
	border-top-color: #' . $this->productsColors['label_sale_bg'] . ';
}
.label-type-5 .label-sale:after,
.products-grid.label-type-5 .availability-only:after,
.products-list.label-type-5 .availability-only:after{
	border-bottom-color: #' . $this->productsColors['label_sale_bg'] . ';
}
.label-new {
	background-color: #' . $this->productsColors['label_new_bg'] . ';
	color: #' . $this->productsColors['label_new_color'] . ';
}
.label-new strong {
	border-top-color: rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->productsColors['label_new_border']).',.5);
	border-bottom-color: rgba('.MAGE::helper('ThemeOptionsBizarre')->HexToRGB($this->productsColors['label_new_border']).',.5);
	border-width: ' . $this->productsColors['label_new_border_width'] . 'px;
}
.label-type-5 .label-new:before{
    border-top-color: #' . $this->productsColors['label_new_bg'] . ';
}
.label-type-5 .label-new:after{
    border-bottom-color: #' . $this->productsColors['label_new_bg'] . ';
}

/*====== Social Links ======*/
ul.social-links li a {
	background-color: #' . $this->socialLinksColors['social_links_bg'] . ';
	border-color: #' . $this->socialLinksColors['social_links_border'] . ';
	border-width: ' . $this->socialLinksColors['social_links_border_width'] . 'px;
}
ul.social-links li a:hover {
	background-color: #' . $this->socialLinksColors['social_links_bg_h'] . ';
	border-color: #' . $this->socialLinksColors['social_links_border_h'] . ';
}
ul.social-links li a i {
	color: #' . $this->socialLinksColors['social_links_color'] . ';
	border-color: #' . $this->socialLinksColors['social_links_divider'] . ';
	border-width: ' . $this->socialLinksColors['social_links_divider_width'] . 'px;
}
ul.social-links li a:hover i {
	color: #' . $this->socialLinksColors['social_links_color_h'] . ';
	border-color: #' . $this->socialLinksColors['social_links_divider_h'] . ';
}

/*====== Footer ======*/

/**** Top Block ****/
#footer .footer-topline,
body.boxed-layout #footer .footer-topline .container_12,
#footer .footer-links ul.active {
	background-color: #' . $this->footerColors['top_block_bg'] . ';
	color: #' . $this->footerColors['top_block_text'] . ';
}
#footer .footer-topline,
body.boxed-layout #footer .footer-topline .container_12 {
	border-color: #' . $this->footerColors['top_block_border'] . ';
	border-width: ' . $this->footerColors['top_block_border_width'] . 'px;
}
#footer .footer-topline a {color: #' . $this->footerColors['top_block_link'] . ';}
#footer .footer-topline a:hover {color: #' . $this->footerColors['top_block_link_h'] . ';}
#footer .footer-topline .footer-links span {
	background-color: #' . $this->footerColors['top_block_button_bg'] . ';
	color: #' . $this->footerColors['top_block_button_color'] . ';
}
#footer .footer-topline .footer-links span i {color: #' . $this->footerColors['top_block_button_color'] . ';}
#footer .footer-topline .footer-links span:hover {
	background-color: #' . $this->footerColors['top_block_button_bg_h'] . ';
	color: #' . $this->footerColors['top_block_button_color_h'] . ';
}
#footer .footer-topline .footer-links span:hover i {color: #' . $this->footerColors['top_block_button_color_h'] . ';}
#footer .footer-topline .footer-links li a {
	background-color: #' . $this->footerColors['top_block_list_links_bg'] . ';
	color: #' . $this->footerColors['top_block_list_links_color'] . ';
}
#footer .footer-topline .footer-links ul i {color: #' . $this->footerColors['top_block_list_links_color'] . ';}
#footer .footer-topline .footer-links li a:hover {
	background-color: #' . $this->footerColors['top_block_list_links_bg_h'] . ';
	color: #' . $this->footerColors['top_block_list_links_color_h'] . ';
}
#footer .footer-topline .footer-links ul i:hover {color: #' . $this->footerColors['top_block_list_links_color_h'] . ';}

/**** Middle Block ****/
.footer-second-line,
body.boxed-layout #footer .footer-second-line .container_12 {
	background-color: #' . $this->footerColors['middle_block_bg'] . ';
	border-color: #' . $this->footerColors['middle_block_border'] . ';
	border-width: ' . $this->footerColors['middle_block_border_width'] . 'px;
}
#footer .footer-second-line .footer-block-title {
	border-color: #' . $this->footerColors['middle_block_title_divider'] . ';
	border-width: ' . $this->footerColors['middle_block_title_divider_width'] . 'px;
}
#footer .footer-second-line .footer-block-title h2 {color: #' . $this->footerColors['middle_block_title_color'] . ';}
.footer-second-line,
#footer .footer-second-line .footer-info {color: #' . $this->footerColors['middle_block_text'] . ';}
.footer-second-line a,
#footer .footer-second-line .footer-info a {color: #' . $this->footerColors['middle_block_link'] . ';}
.footer-second-line a:hover,
#footer .footer-second-line .footer-info a:hover {color: #' . $this->footerColors['middle_block_link_h'] . ';}
#footer .custom-footer-content ul.links li:before {background-color: #' . $this->footerColors['middle_block_list_link_bg'] . ';}
#footer .footer-second-line .links li {
	border-color: #' . $this->footerColors['middle_block_list_link_border'] . ';
	border-width: ' . $this->footerColors['middle_block_list_link_border_width'] . 'px;
}
#footer .footer-second-line .links li a {color: #' . $this->footerColors['middle_block_list_link_color'] . ';}
#footer .footer-second-line .links li:after {background-color: #' . $this->footerColors['middle_block_list_link_bg_h'] . ';}
#footer .footer-second-line .links li:hover {border-color: #' . $this->footerColors['middle_block_list_link_border_h'] . ';}
#footer .footer-second-line .links li:hover a {color: #' . $this->footerColors['middle_block_list_link_color_h'] . ';}
#footer .footer-products-list .product-shop .product-name a {color: #' . $this->footerColors['middle_block_products_title'] . ';}
#footer .footer-products-list .product-shop .product-name a:hover {color: #' . $this->footerColors['middle_block_products_title_h'] . ';}
#footer .footer-products-list .product-shop .price-box .price {color: #' . $this->footerColors['middle_block_products_price'] . ';}
#footer .footer-products-list .product-shop .price-box .old-price .price {color: #' . $this->footerColors['middle_block_products_old_price'] . ';}
#footer .footer-products-list .product-shop .price-box .special-price .price {color: #' . $this->footerColors['middle_block_products_special_price'] . ';}
#footer .footer-second-line .block-tags li a {
	background-color: #' . $this->footerColors['middle_block_tags_link_bg'] . ';
	border-color: #' . $this->footerColors['middle_block_tags_link_border'] . ';
	border-width: ' . $this->footerColors['middle_block_tags_link_border_width'] . 'px;
	color: #' . $this->footerColors['middle_block_tags_link_color'] . ';
}
#footer .footer-second-line .block-tags li a:hover {
	color: #' . $this->footerColors['middle_block_tags_link_color_h'] . ';
	border-color: #' . $this->footerColors['middle_block_tags_link_border_h'] . ';
	background-color: #' . $this->footerColors['middle_block_tags_link_bg_h'] . ';
}

/**** Links Block ****/
#footer .links-block,
body.boxed-layout #footer .links-block .container_12 {
	background-color: #' . $this->footerColors['links_block_bg'] . ';
	border-color: #' . $this->footerColors['links_block_border'] . ';
	border-width: ' . $this->footerColors['links_block_border_width'] . 'px;
}
#footer .links-block .links li a {color: #' . $this->footerColors['links_block_link'] . ';}
#footer .links-block .links li a:hover {color: #' . $this->footerColors['links_block_link_h'] . ';}

/**** Bottom Block ****/
#footer .footer-bottom,
body.boxed-layout #footer .footer-bottom .container_12 {
	background-color: #' . $this->footerColors['bottom_block_bg'] . ';
	color: #' . $this->footerColors['bottom_block_text'] . ';
}
#footer address,
#footer address a {color: #' . $this->footerColors['bottom_block_text'] . ';}
#footer .store-switcher label,
#footer .form-language label,
#footer .form-currency label {color: #' . $this->footerColors['bottom_block_labels'] . ';}
#footer .sbSelector {
	background-color: #' . $this->footerColors['bottom_block_select_bg'] . ';
	color: #' . $this->footerColors['bottom_block_select_color'] . ';
	border-color: #' . $this->footerColors['bottom_block_select_border'] . ';
	border-width: ' . $this->footerColors['bottom_block_select_border_width'] . 'px;
}

/**** Contact Form ****/

#footer #AjaxcontactForm li .input-box input,
#footer #AjaxcontactForm li textarea {
	background-color: #' . $this->footerColors['contact_bg'] . ';
	border-color: #' . $this->footerColors['contact_border'] . ';
	color: #' . $this->footerColors['contact_text'] . ';
}
#footer #AjaxcontactForm li label {color: #' . $this->footerColors['contact_text'] . ';}

/**** Facebook Widget ****/
.facebook-widget-wraper {background-color: #' . $this->footerColors['facebook_bg'] . ';} 

';


    	$this->saveData($css);
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ThemeOptionsBizarre')->__("CSS file with custom styles has been created"));
        
        return true;
    }

    private function saveData($data)
    {
        $this->setLocation ();

        try {
	        /*$fh = fopen($file, 'w');
	       	fwrite($fh, $data);
	        fclose($fh);*/

            $fh = new Varien_Io_File(); 
            $fh->setAllowCreateFolders(true); 
            $fh->open(array('path' => $this->dirPath));
            $fh->streamOpen($this->filePath, 'w+'); 
            $fh->streamLock(true); 
            $fh->streamWrite($data); 
            $fh->streamUnlock(); 
            $fh->streamClose(); 
    	}
    	catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ThemeOptionsBizarre')->__('Failed creation custom css rules. '.$e->getMessage()));
        }
    }

}