<?php
/**
* BSS Commerce Co.
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://bsscommerce.com/Bss-Commerce-License.txt
*
* =================================================================
*                 MAGENTO EDITION USAGE NOTICE
* =================================================================
* This package designed for Magento COMMUNITY edition
* BSS Commerce does not guarantee correct work of this extension
* on any other Magento edition except Magento COMMUNITY edition.
* BSS Commerce does not provide extension support in case of
* incorrect edition usage.
* =================================================================
*
* @category   BSS
* @package    Bss_DeferJS
* @author     Extension Team
* @copyright  Copyright (c) 2014-2105 BSS Commerce Co. ( http://bsscommerce.com )
* @license    http://bsscommerce.com/Bss-Commerce-License.txt
*/
class Bss_DeferJS_Model_Observer 
{
   public function deferScript($observer) {
      if(!Mage::helper('bss_deferjs')->isEnabled()) {
         return $this;
      }

      $response = $observer->getEvent()->getControllerAction()->getResponse();
      $html = $response->getBody();

      //get and remove script in <if> tag
      //$conditionalJsPattern = '#<\!--\[if[^\>]*>\s*.*</script>\s*<\!\[endif\]-->#isU';
      $conditionalJsPattern = '#<\!--\[if[^\>]*>\s*<script.*</script>\s*<\!\[endif\]-->#isU';
      preg_match_all($conditionalJsPattern, $html, $_matches);
      $_js_if = implode('', $_matches[0]);

      $html = preg_replace($conditionalJsPattern, '' , $html);


      //get and remove script
      $conditionalJsPattern = '@(?:<script type="text/javascript"|<script)(.*)</script>@msU';
      preg_match_all($conditionalJsPattern,$html,$_matches);
      $_js = implode('',$_matches[0]);

      $html = preg_replace($conditionalJsPattern,'',$html);

      //remove </body></html>
      $check = 0;
      if (strpos($html, '</html>') && strpos($html, '</body>')) {
         $check = 1;
         $html = substr_replace($html, '', strripos($html,"</html>"), 7);
         $html = substr_replace($html, '', strripos($html,"</body>"), 7);
      }

      
      if(Mage::getStoreConfig('deferjs/general/show_path')) {
         $module = Mage::app()->getFrontController()->getRequest()->getModuleName();
         $controller = Mage::app()->getFrontController()->getRequest()->getControllerName();
         $action = Mage::app()->getFrontController()->getRequest()->getActionName();

         $h = '<table cellspacing="0" cellpadding="2" border="1" style="width:auto;background-color:white">
         <tbody>
            <tr>
               <th>Module</th>
               <th>Controller</th>
               <th>Action</th>
               <th>Path</th>
            </tr>
            <tr>
               <td align="left">'.$module.'.</td>
               <td>'.$controller.'</td>
               <td align="right">'.$action.'</td>
               <td align="right">'.Mage::app()->getRequest()->getRequestUri().'</td>
            </tr>
         </tbody>
      </table>';
      $html .= $h;
   }

   //merger script to end of body
   $html .= $_js . $_js_if;

   if ($check == 1) {
      $response->setBody($html.'</body></html>');
   }else {
      $response->setBody($html);
   }
}
}