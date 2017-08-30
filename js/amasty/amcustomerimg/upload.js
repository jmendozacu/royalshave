/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/


function amcustomerimg_upload(generalId)
{
    formElementId   = generalId + '-form';
    targetIframeId  = generalId + '-target';
    errorDivId      = generalId + '-error';
    successDivId    = generalId + '-success';
    formContainerId = generalId + '-form-container';
    
    Effect.BlindUp(errorDivId, { duration: 0.1 });
    Effect.BlindUp(successDivId, { duration: 0.1 });
    
    $(formElementId).target = targetIframeId;
    $(targetIframeId).observe('load', function(){
        var response = $(targetIframeId).contentWindow.document.body.innerHTML;
        if (response)
        {
            response = response.evalJSON();
        }
        if (response.error)
        {
            $(errorDivId).innerHTML = response.message;
            $(errorDivId).appear({ duration: 1.0 });
        }
        if (response.success && !response.error)
        {
            Effect.BlindUp(formContainerId, { duration: 0.3 });
            $(successDivId).innerHTML = response.message;
            $(successDivId).appear({ duration: 1.0 });
        }
    });
    
    if($('check2')){
        $('check2').value =h.get('value');
    }
    var form = $('box-amcustomerimg-form-form');
    var validator = new Validation(form);
    if (validator.validate()) {
        $(formElementId).submit();
    }
    
}