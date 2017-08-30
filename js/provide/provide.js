/*
 * Developed by Ortus IT.
 * Web: http://ortus-it.com
 * Code part:#02-01-rev.004, October 2013. 
 * -All Rights of this product are belong to Provide Support, LLC.-
 * 
 */


function generateRandomString(length) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
};


jQuery(document).ready(function () {

    jQuery('#f7main input').prop('checked',false);
	
    var settingsLoaded = false;
    var emulateCount = 0;
    var depended = jQuery('#buttonAvailableAll,#buttonAvailablePost,#buttonAvailableWhole,.shortcodeSeparator').parent();

	var form_key = window.FORM_KEY;
    var f7php = new Object();
    var f7acc = new Object();
    var f7accc = new Object();
    var f7settings = new Object();
    var newExisting = false;
	var autoLogin = false;
	var setAccount = false;
    var validation = true;
    var validation2 = true;
    var f7message = jQuery('#f7message');
    var f7messageFlag = false;

   
    jQuery('#selectPostMenus').hide(); 
    jQuery('input[name=buttonAppearance]').parent().children('.settingInt').hide();
    jQuery('input[name=customImages]').parent().children('.settingIntInt').hide();
    jQuery('input[name=buttonLocation]').parent().children('.settingInt').hide();
   
    jQuery('#buttonAvailablePost').parent().children('.settingInt').hide();

    hideshow = function (obj, type) {
		
		
        jQuery(obj).parent().on('click', function () {
            jQuery(obj).parent().each(function () {
                currentSetting = jQuery(this);
                if (currentSetting.children('input').prop('checked')) {
                    currentSetting.children(type).slideDown('fast');
                } else {
                    currentSetting.children(type).slideUp('fast');
                }
            });
        });
    }
    
    hideshow('input[name=buttonAppearance]', '.settingInt');
    hideshow('input[name=customImages]', '.settingIntInt');
    hideshow('input[name=buttonLocation]', '.settingInt');
  
    hideshow('#buttonAvailablePost', '.settingInt');
    hideshow('input[name=optionPages]', '#selectPagesMenus');
    hideshow('input[name=optionPost]', '#selectPostMenus');


    jQuery('.f7control').on('click', function () {
		
		if (jQuery(this).children('input').attr('checked') == 'checked') {
            jQuery('#f7settings').children().not('.f7control').not('').slideDown('fast');
        } else {
            jQuery('#f7settings').children().not('.f7control').not('').slideUp('fast');
        }
    });


    jQuery('.f7control').on('click', function () {
        if (jQuery('input[location=shortcode]').attr('checked') == 'checked') {
            nnot = depended;
        } else {
            nnot = '';
        }
        if (jQuery(this).children('input').attr('checked') == 'checked') {
            jQuery('#f7settings').children().not('.f7control').not(nnot).slideDown('fast');
        } else {
            jQuery('#f7settings').children().not('.f7control').not(nnot).slideUp('fast');
        }
    });

    jQuery('input[location]').on('click', function () {
        shortcode = jQuery('input[location=shortcode]');
        dep = depended;
        if (shortcode.attr('checked') == 'checked') {
            dep.hide('fast');
        }
        if (shortcode.attr('checked') != 'checked') {
            dep.show('fast');
        }
    });
    
	idInterval = setInterval(function () {
        checkMessage()
    }, 1000);


    /*----------------------initializing--------------------------------
     * initializing - function that gets data from db
     * Get next param:
     * f7php.db.accountName = accountName
     * f7php.db.accountHash = accountHash
     * f7php.db.settings = settings
     * f7php.db.pluginsFolder = pluginsFolder
     * urlAjax = ajaxurl
     */
    initializing = function () {

     
        ajaxData = {
            action: 'getaccount',
            form_key: form_key
        }
        
        jQuery.ajax({
            url: urlAjax,
            type: 'POST',
            data: ajaxData
        }).done(function (data) {

            f7php.db = JSON.parse(data);
			
			
			// if no account set param
            if ((f7php.db.settings + '' || f7php.db.account + '') == 'undefined') {
		
                f7php.db.settings = 'null'; 
                f7php.db.account = {};
                f7php.db.account.accountName = '';
                f7php.db.account.accountHash = '';

            }
            
            checkAccount();

        })
    }();
    
    
    /*----------------------heckAccount---------------------------------
     * checkAccount - function check login and pass than chek submit
     * Set next param:
     * f7php.db.account.accountName
     * f7php.db.account.accountHash
     */
    checkAccount = function () {

            if (f7php.db.account.accountName != '' && f7php.db.account.accountHash != '') {
                jQuery('.f7fields:eq(0) > .f7field > input').val(f7php.db.account.accountName);
                jQuery('.f7fields:eq(1) > .f7field > input').val(f7php.db.account.accountHash);

				autoLogin = true;

                setTimeout(function () {
                    jQuery('#f7accountSubmit').trigger('click'); 
                }, 1500);
            }else{
					
				autoLogin = false;
			
				}
        
    };




    f7emulate = function (obj, prop) {
        emulateCount++;
        if (emulateCount > 0) {
            setTimeout(function () {
                if (prop) jQuery(obj).prop('checked', true);
                jQuery(obj).trigger('click');
            }, 100 * emulateCount);
        } else {
            if (prop) jQuery(obj).prop('checked', true);
            jQuery(obj).trigger('click');
        }
    }



    jQuery('#f7buttonE').on('click', function () {
        jQuery('.f7field input').removeClass('novalid').attr('placeholder', '');
        jQuery('#f7buttonN').removeClass('f7buttonNoBorder');
        jQuery(this).addClass('f7buttonNoBorder');
        jQuery('.f7fields').eq(2).slideUp();
        jQuery('#f7accountSubmit').html('Connect to Account');
    });
    jQuery('#f7buttonN').on('click', function () {
        jQuery('.f7field input').removeClass('novalid').attr('placeholder', '');
        jQuery('#f7buttonE').removeClass('f7buttonNoBorder');
        jQuery(this).addClass('f7buttonNoBorder');
        jQuery('.f7fields').eq(2).slideDown();
        jQuery('#f7accountSubmit').html('Create Account and connect');
    });



/*------------------------f7Login---------------------------------------
     * f7Login - function that set data in db
     * Set next param:
     * action = setaccount,
     * accountName = f7accc.login
     * accountHash = f7acc.pass
     */
f7Login = function () {
	
	    f7accc.login = f7acc.name;
	    
		
	    if(newExisting == true){ 
			var newPass = f7acc.pass;
			f7acc.pass = CryptoJS.MD5(f7acc.pass)+'';
			f7accc.md5 = CryptoJS.MD5(f7acc.pass) + '';
		}
		
		if(setAccount == true){
			f7acc.pass = CryptoJS.MD5(f7acc.pass)+'';
		}
		
       accountInfo = '';
		accountInfo += 'Connected to account : ';
		accountInfo += '<b>' + f7accc.login + '</b>';
		if(f7acc.type == 'existing'){	
			accountInfo += '<br /><br /><div id="f7oldaccountDetails">To go online and start answering chat requests, please install the <a target="_blank" href = "http://www.providesupport.com/downloads/index.html?utm_source=magento-plugin&utm_medium=settings&utm_campaign=Plugins" style="text-decoration: none">Operator Console</a> ';
			accountInfo += 'and login <br /> with the credentials available on your account <a target="_blank" href="https://admin.providesupport.com/view/my-account/operators-and-departments?utm_source=magento-plugin&utm_medium=settings&utm_campaign=Plugins" style="text-decoration: none">Operators and Departments</a> page.';
			accountInfo += '<br />To customize your live chat appearance, please use available settings <br /> in your account <a target="_blank" href = "https://admin.providesupport.com/view/my-account/dashboard?utm_source=magento-plugin&utm_medium=settings&utm_campaign=Plugins" style="text-decoration: none">Control Panel</a>.';
			accountInfo += '</div>';
		}
		if(f7acc.type == 'new'){		
			accountInfo += '<br /><br /><div id="f7newaccountDetails">To start using the live chat service and appear online please install the <a target="_blank" href = "http://www.providesupport.com/downloads/index.html?utm_source=magento-plugin&utm_medium=settings&utm_campaign=Plugins" style="text-decoration: none">Operator Console</a> ';
			accountInfo += '<br />and login with the following credentials:';
			accountInfo += '<br /><br />Account Name: <b>' + f7acc.name + '</b>';
			accountInfo += '<br />Operator Login: <b>operator1</b>';
			accountInfo += '<br />Operator Password: <b>password1</b>';
			accountInfo += '<br /><br />To customize your live chat appearance and configure other settings, <br />please use your account <a target="_blank" href = "https://admin.providesupport.com/action/main/company/company-login?login=' + f7acc.name + '&password=' + newPass + '" style="text-decoration: none">Control Panel</a>.';
			accountInfo += '</div>';
		}
		accountInfo += '<br /><div id="f7anotherAccount" style="margin:5px auto;width:285px;">Connect to another Provide Support account</div>';
        jQuery('#f7accountInfo').html(accountInfo);


		
	jQuery('#f7anotherAccount').on('click', function () {
		
	        ajaxData = {
                action: 'clearall',
                form_key: form_key
            }
            func = function(){
				location.reload();
			}
            ajaxSend(ajaxData, func);
          
});

          
		f7opensettings();

		
		
		ajaxData = {
            action: 'setaccount',
            form_key: form_key,
            accountName: f7accc.login,
            accountHash: f7acc.pass
        }
        
        func = function(){};
		ajaxSend(ajaxData, func);	
		
}

ajaxSend = function(ajaxData, func){
	
	//console.log(f7php);
	//console.log(ajaxData);
	 jQuery.ajax({
            url: urlAjax,
            type: 'POST',
            data: ajaxData
        }).done(function (msg) {
			func();
        });
	
	}

  

    //-------------------------- 7php settings -------------------------------
    f7opensettings = function () {
        
        
        f7php.db.settings = JSON.parse(f7php.db.settings);
        
	if (f7php.db.settings + '' == 'null'){
        
            f7php.db.settings = new Object();
            f7php.db.settings.pluginEnabled = true;
            f7php.db.settings.buttonImageType = 'graphic';
            f7php.db.settings.buttonImageSource = 'account';
            f7php.db.settings.buttonLocation = 'fixed';
            f7php.db.settings.buttonLocationVerticalBy = '%';
            f7php.db.settings.buttonLocationVerticalValue = '50';
            f7php.db.settings.buttonLocationVerticalFrom = 'bottom';
            f7php.db.settings.buttonLocationHorizontalBy = '%';
            f7php.db.settings.buttonLocationHorizontalValue = '0';
            f7php.db.settings.buttonLocationHorizontalFrom = 'right';
            f7php.db.settings.buttonAvailableMenus = true
            f7php.db.settings.buttonAvailableMenusWhich = 'all';
            f7php.db.settings.buttonAvailablePost = true
            f7php.db.settings.buttonAvailablePostWhich = 'all';
            f7php.db.settings.buttonAvailableWhole = true;
            f7php.db.settings.buttonAvailableAll = true;
        }
        
        if (f7php.db.settings.pluginEnabled + '' == 'true') {

            jQuery('#f7settings').slideDown();
        } else {
            jQuery('#f7wait').html('<img src="' + f7php.db.pluginsFolder + '/img/wait.gif" width="30px" height="30px">');
            
        }
        jQuery('#f7submit').slideDown();
        jQuery('#f7account').slideUp();
        jQuery('#f7accountInfo').slideDown(); 


        loadSettings(f7php.db.settings); 
    }


    loadSettings = function (sett) { 


        if (!settingsLoaded) {


            if (sett.pluginEnabled) {
                jQuery('#f7pluginEnabled').attr('checked', true);
                f7emulate('.f7control');
            }
            if (sett.buttonImageType == 'graphic') {
                f7emulate('.f7button1', true);
            }
            if (sett.buttonImageType == 'text') 
			{
                f7emulate('.f7button2', true);
               
                jQuery('#buttonImageTextOnline').val(sett.buttonImageTextOnline);
                jQuery('#buttonImageTextOffline').val(sett.buttonImageTextOffline);
            }
            if (sett.buttonImageSource == 'account') {
                f7emulate('.f7button3', true);
            }
            
            if (sett.buttonImageSource == 'custom') {
                f7emulate('.f7button4', true);
               
                jQuery('#buttonImageUrlOnline').val(sett.buttonImageUrlOnline);
                jQuery('#buttonImageUrlOffline').val(sett.buttonImageUrlOffline);
                
            }
            if (sett.buttonLocation) {
                string = 'input[location=' + sett.buttonLocation + ']';
                f7emulate(string, true);
                if (sett.buttonLocation == 'fixed') {
                    jQuery('#buttonLocationVerticalValue').val(sett.buttonLocationVerticalValue);
                    jQuery('#buttonLocationHorizontalValue').val(sett.buttonLocationHorizontalValue);
                    //---------------------------------
                    if (sett.buttonLocationVerticalBy == 'px') {
                        f7emulate('.f7button5');
                    } else {
                        f7emulate('.f7button6');
                    }
                    if (sett.buttonLocationHorizontalBy == 'px') {
                        f7emulate('.f7button7');
                    } else {
                        f7emulate('.f7button8');
                    }
                    //---------------------------------
                    if (sett.buttonLocationVerticalFrom == 'top') {
                        f7emulate('.f7button9');
                    } else {
                        f7emulate('.f7button10');
                    }
                    if (sett.buttonLocationHorizontalFrom == 'left') {
                        f7emulate('.f7button11');
                    } else {
                        f7emulate('.f7button12');
                    }
                }else{
					
					jQuery("#selectedBlock option").filter(function() {
						return jQuery(this).val() == sett.buttonAvailableMenusList; 
					}).attr('selected', true);
					
				}
                
            }

            
             if (sett.buttonAvailablePost) {
                f7emulate('#buttonAvailablePost');
                if (sett.buttonAvailablePostWhich == 'all') {
                    f7emulate('.f7button15', true);
                } else {
                    f7emulate('.f7button16', true);
                    for (var i=0; i<sett.buttonAvailablePostList.length ; i++){
						jQuery('input[postid=' + sett.buttonAvailablePostList[i] + ']').trigger('click');
						
					}
                }
            }
            if (sett.buttonAvailableWhole) {

                f7emulate('#buttonAvailableWhole');
            }
			
			if (sett.buttonAvailableAll) {

                f7emulate('#buttonAvailableAll');
            } 
			
			 
            settingsLoaded = true;

            if (!sett.pluginEnabled) {
                f7emulate('.f7control');
                f7emulate('.f7control');
            }

            setTimeout(function () {
                jQuery('#f7submit').trigger('click'); 
            }, 2000);
            setTimeout(function () {
                jQuery('#f7settings').fadeIn();
                jQuery('#f7wait').remove();
            }, 100 * emulateCount + 200);
        }

    }



    //---------------------------------------  accErase  ------------------------------------------//	
    accErase = function () {
        f7acc.type = '';
        f7acc.name = '';
        f7acc.pass = '';
        f7acc.mail = '';
    };

    //---------------------------------------  accGrub  ------------------------------------------//
    accGrub = function () {
        f7acc.type = (jQuery('#f7buttonE').hasClass('f7buttonNoBorder')) ? 'existing' : 'new';
        f7acc.name = jQuery('.f7fields').eq(0).children('.f7field').children('input').val() || '';
        f7acc.pass = jQuery('.f7fields').eq(1).children('.f7field').children('input').val() || '';
        f7acc.mail = jQuery('.f7fields').eq(2).children('.f7field').children('input').val() || '';
    }


    //---------------------------------------  validate  ------------------------------------------//
    validate = function () { //
        validation = true;
        if (f7settings.buttonImageType == 'graphic' && f7settings.buttonImageSource == 'custom') {
            valid('#buttonImageUrlOnline');
            valid('#buttonImageUrlOffline');
        }
        if (f7settings.buttonImageType == 'text') {
            valid('#buttonImageTextOnline');
            valid('#buttonImageTextOffline');
        }
        if (f7settings.buttonLocation == 'fixed') {
            valid('#buttonLocationVerticalValue');
            valid('#buttonLocationHorizontalValue');
        }
    }

    //---------------------------------------  validate2  ------------------------------------------//
    validate2 = function (number){
		validation2 = true;
		jQuery('.f7fields > .f7field > input').removeClass('novalid');
		valid('.f7fields:eq(0) > .f7field > input',true);
			name = jQuery('.f7fields:eq(0) > .f7field > input').val();
			pattern = new RegExp(/^[-a-z0-9_]{0,20}$/i);
			if(pattern.test(name)){		
			}else if(name != ''){
				textMessage('The account name should contain no more than 20 alphanumeric characters <br> (Latin letters or digits), \'-\' (dashes), or \'_\' (underscore) characters. Spaces are not allowed.','warning');
				jQuery('.f7fields:eq(0) > .f7field > input').addClass('novalid');
				validation2 = false;
				}
		valid('.f7fields:eq(1) > .f7field > input',true);
		pass = jQuery('.f7fields:eq(1) > .f7field > input').val();
		if(pass.length > number) {validation2 = false;jQuery('.f7fields:eq(1) > .f7field > input').addClass('novalid');textMessage('The account password should contain no more than 20 characters.','warning');} 
		if(f7acc.type == 'new') {
				valid('.f7fields:eq(2) > .f7field > input',true);
				pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
				if(pattern.test(jQuery('.f7fields:eq(2) > .f7field > input').val())){
				}else{
					validation2 = false;
					jQuery('.f7fields:eq(2) > .f7field > input').addClass('novalid');
					textMessage('Please enter a correct e-mail address','warning');
					}
			}
		checkFields();
		}


    checkFields = function () {
        jQuery('.f7field input').each(function () {
            if (jQuery(this).hasClass('novalid')) {
                jQuery(this).attr('placeholder', 'This field is required!');
            } else {

            }
        });
    }


    valid = function (obj, type) {
        type = type || false;
        if (jQuery(obj).val() == '') {
            jQuery(obj).addClass('novalid');
            if (!type) {
                validation = false;
            } else {
                validation2 = false;
            }
        } else {
            jQuery(obj).removeClass('novalid');
        }
    }

    textMessage = function (message, type) {
        jQuery('#f7message').html(message);
        type = type || 'info';
        if (type == 'warning') {
            f7message.addClass('f7warning');
        } else {
            f7message.removeClass('f7warning');
        }
    }

    checkMessage = function () {
        if (f7message.html() != '' && !f7messageFlag) {
            f7messageFlag = true;
            f7message.slideDown('fast');
            setTimeout(function () {
                f7message.slideUp('fast');
                f7message.empty();
                f7messageFlag = !f7messageFlag
            }, 8000);
        }
    }


    //---------------------------------------  submit to account  ------------------------------------------//	
    jQuery('#f7accountSubmit').on('click', function () {
        accErase(); 
        accGrub(); 
         
        if(autoLogin == true){
			validate2(32);
		}else{
			validate2(20);
		}
		
        if (validation2){
			
            jQuery('#f7accountSubmit').append('<img id="accountWait" style="position:absolute;top:-2px;right:-38px;"  src="data:image/gif;base64,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" width="30px" height="30px">');
            var accSet = {};
            if (f7acc.type == 'existing') {
				
				var siteUrl = 'https://www.providesupport.com/api/account/v1/companies/';
				var companyLogin = '?companyLogin=';
				var companyPasswords = '&companyPasswordMD5Hash=';
				
				if(autoLogin == true){
				url = siteUrl + f7acc.name + companyLogin + f7acc.name + companyPasswords + f7acc.pass;
				}else{
				url = siteUrl + f7acc.name + companyLogin + f7acc.name + companyPasswords + CryptoJS.MD5(f7acc.pass);
				}
			    
			    
			    
       
                jQuery.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'jsonp',
                    data: {},
                    async: false,
                    success: function (msg) {
                        
                        if (typeof msg.company != 'undefined') {
							
							f7message.slideUp('fast');
							clearInterval(idInterval);
							
							newExisting = false;
							
							if(autoLogin == false){
								setAccount = true;
							}else{
								setAccount = false;
								}
							f7Login();
							
                        } 
                        if (msg.error == 'incorrect-password-md5-hash') {
                            textMessage('Incorrect password', 'warning');
                        } else if (msg.error == 'no-such-company') {
                            textMessage(msg.errorDescription, 'warning');
                        } else {
                            if (msg.errorDescription != '') {
                                textMessage(msg.errorDescription, 'warning')
                            } else {
                                textMessage(msg.error, 'warning')
                            }
                        }
                        
                        jQuery('#accountWait').remove(); 
                    }
                }).done(function () {
                    jQuery('#accountWait').remove();
                }); //?

            }
            if (f7acc.type == 'new') {
                accSet = {}
                accSet.companyLogin = f7acc.name;
                //accSet.companyPassword = CryptoJS.MD5(f7acc.pass)+'';
                accSet.companyPassword = f7acc.pass; 
                accSet.email = f7acc.mail;
                accSet.caller = 'magento-plugin-2.0.3';
                accSet.accountSettings = {
											"chatIconOnline": "57/chat-icon-57-online-en.gif", 
											"chatIconOffline": "57/chat-icon-57-offline-en.gif"
										 }

                
               
                jQuery.ajax({
					url: 'https://www.providesupport.com/api/account/v1/companies/?method=post',
                    dataType: 'jsonp',
                    data: {
                        params: JSON.stringify(accSet)
                    },
                    success: function (msg) {
                        
                        if (msg.error == 'duplicate-company-login') {
                            textMessage('Account name "' + f7acc.name + '" is taken', 'warning')
                        } else if (msg.result == 'success') {
							
														
							f7message.slideUp('fast');
							clearInterval(idInterval);
							
							newExisting = true;
							f7Login();
                        } else {
                            if (msg.errorDescription != '') {
                                textMessage(msg.errorDescription, 'warning')
                            } else {
                                textMessage(msg.error, 'warning')
                            }
                        }
                        jQuery('#accountWait').remove(); 
                    }
                }).done(function () {
                    jQuery('#accountWait').remove();
                }); //?
            }
        }
    });


    jQuery('#f7submit').on('click', function () {
        eraseSettings();
        grabSettings();
        validate();
        if (f7settings.pluginEnabled + '' == 'false') validation = true;
        if (validation) {
            jQuery('#f7livePreview').html('<img src="' + f7php.db.pluginsFolder + '/img/wait.gif" width="30px" height="30px">');
            jQuery(this).removeClass('novalidButton');
            ajaxData = {
                action: 'setsettings',
                form_key: form_key,
                settings: JSON.stringify(f7settings)
            }
            jQuery.ajax({
                url: urlAjax,
                type: 'POST',
                data: ajaxData
            }).done(function (msg) {
            });

            var json = {};
            json.hash = generateRandomString(4);
            
            json.locale = location.language || 'en';
            json.fixed = false;
            json.codeType = 'script';
            json.appearance = 'graphics';
            json.companyLogin = f7accc.login;
            //json.companyPasswordMD5Hash = f7acc.pass;
            
            
            json.fixed = f7settings.buttonLocation == 'fixed' ? true : false;
            json.fixedPosition = {
				"horizontal": {
                        "value":f7settings.buttonLocationHorizontalValue,
                        "units":f7settings.buttonLocationHorizontalBy,
                        "startAt":f7settings.buttonLocationHorizontalFrom
                },
                "vertical": {
                        "value":f7settings.buttonLocationVerticalValue,
                        "units":f7settings.buttonLocationVerticalBy,
                        "startAt":f7settings.buttonLocationVerticalFrom
                }
			};
            
            //console.log('json.fixed = '+json.fixed);
            //console.log('json.fixedPosition : '+json.fixedPosition);
            
            
            
            
            if(autoLogin == true){
				json.companyPasswordMD5Hash = f7acc.pass;
            }else{
				if(setAccount == true){
					json.companyPasswordMD5Hash = f7acc.pass;		
			//json.companyPasswordMD5Hash = CryptoJS.MD5(f7acc.pass)+'';		
			}
			
            if(newExisting == true){
				json.companyPasswordMD5Hash = f7acc.pass;
			}
			}
			
			
            var f7url = new Object();
            f7url.hidden = 'http://www.providesupport.com/api/chat-button/v1/get-code';
            f7url.text = 'http://www.providesupport.com/api/chat-button/v1/get-code';
            f7url.graphic = 'http://www.providesupport.com/api/chat-button/v1/get-code';
            f7url.featured = 'http://www.providesupport.com/api/chat-button/v1/get-code';
            //console.log(':::START');
            if (f7settings.buttonImageType == 'graphic') {
                if (f7settings.buttonImageSource == 'account') {
                    requestCode(json, f7url.featured);
                    console.log('featured');
                }
                if (f7settings.buttonImageSource == 'custom') {
                    json.customImageUrls = {};
                    json.customImageUrls.online = f7settings.buttonImageUrlOnline;
                    json.customImageUrls.offline = f7settings.buttonImageUrlOffline;
                    requestCode(json, f7url.graphic);
                    console.log('custom');
                    
                }
            } else {
                json.appearance = 'text';
                json.chatLinkHtmls = {};
                json.chatLinkHtmls.online = f7settings.buttonImageTextOnline;
                json.chatLinkHtmls.offline = f7settings.buttonImageTextOffline;
                requestCode(json, f7url.text);
                console.log('text');
            }
            if (f7settings.buttonAvailableWhole) {
                json.appearance = 'hidden';
                requestCode(json, f7url.hidden, true);
            }
           
            
        } else {
            jQuery(this).addClass('novalidButton');
        }
    });




    eraseSettings = function () {
        f7settings.pluginEnabled = false; // false || true
        f7settings.buttonImageType = false; // graphic || text 
        f7settings.buttonImageSource = false; // account || custom
        f7settings.buttonImageUrlOnline = false; // url
        f7settings.buttonImageUrlOffline = false; // url
        f7settings.buttonImageTextOnline = false; // text
        f7settings.buttonImageTextOffline = false; // text
        f7settings.buttonLocation = false // widget || fixed || shortcode
        f7settings.buttonLocationVerticalBy = false // pixel || percent
        f7settings.buttonLocationVerticalValue = false; // value
        f7settings.buttonLocationVerticalFrom = false; // top || bottom
        f7settings.buttonLocationHorizontalBy = false // pixel || percent
        f7settings.buttonLocationHorizontalValue = false; // value
        f7settings.buttonLocationHorizontalFrom = false; // top || bottom
        f7settings.buttonAvailableMenus = false; // ||true
        f7settings.buttonAvailableMenusWhich = false // all || selected
        f7settings.buttonAvailableMenusList = new Array(); // array()
        f7settings.buttonAvailablePost = false; // ||true
        f7settings.buttonAvailablePostWhich = false // all || selected
        f7settings.buttonAvailablePostList = new Array(); // array(page id, page id)
        f7settings.buttonAvailableWhole = false // ||true
        f7settings.buttonAvailableAll = false;
    }
    grabSettings = function () {
        f7settings.pluginEnabled = (jQuery('#f7pluginEnabled').prop('checked')) ? true : false;
        f7settings.buttonImageType = (jQuery('#buttonImageType').prop('checked')) ? 'graphic' : 'text';
        f7settings.buttonImageSource = (jQuery('#buttonImageSource').prop('checked')) ? 'account' : 'custom';
        f7settings.buttonImageUrlOnline = jQuery('#buttonImageUrlOnline').val() || false;
        f7settings.buttonImageUrlOffline = jQuery('#buttonImageUrlOffline').val() || false;
        f7settings.buttonImageTextOnline = jQuery('#buttonImageTextOnline').val() || false;
        f7settings.buttonImageTextOffline = jQuery('#buttonImageTextOffline').val() || false;
        jQuery('input[name=buttonLocation]').each(function (index) {
            if (jQuery(this).prop('checked')) {
                f7settings.buttonLocation = jQuery(this).attr('location');
            }
        });
        f7settings.buttonLocationVerticalValue = jQuery('#buttonLocationVerticalValue').val() || false;
        f7settings.buttonLocationVerticalBy = (jQuery('#buttonLocationVerticalBy').prop('checked')) ? 'px' : '%';
        f7settings.buttonLocationVerticalFrom = (jQuery('#buttonLocationVerticalFrom').prop('checked')) ? 'top' : 'bottom';
        f7settings.buttonLocationHorizontalValue = jQuery('#buttonLocationHorizontalValue').val() || false;
        f7settings.buttonLocationHorizontalBy = (jQuery('#buttonLocationHorizontalBy').prop('checked')) ? 'px' : '%';
        f7settings.buttonLocationHorizontalFrom = (jQuery('#buttonLocationHorizontalFrom').prop('checked')) ? 'left' : 'right';
        
        
        
        
        //selected Block
        f7settings.buttonAvailableMenusList.push(jQuery("#selectedBlock").val());
        
         
        f7settings.buttonAvailablePost = (jQuery('#buttonAvailablePost').prop('checked')) ? true : false;
        f7settings.buttonAvailablePostWhich = (jQuery('#buttonAvailablePostWhich').prop('checked')) ? 'all' : 'selected';
        jQuery('#selectPostMenus > input').each(function () {
            currentInput = jQuery(this);
            //console.log(currentInput);
            if (currentInput.prop('checked')) {
                f7settings.buttonAvailablePostList.push(currentInput.attr('postid'));
            }
         });
         
         
         
        f7settings.buttonAvailableWhole = (jQuery('#buttonAvailableWhole').prop('checked')) ? true : false;
        f7settings.buttonAvailableAll = (jQuery('#buttonAvailableAll').prop('checked')) ? true : false;
    };




    requestCode = function (json, url, format) {
		

		//json.fixed = false;	
        format = format || false;
        url = location.protocol + '//www.providesupport.com/api/chat-button/v1/get-code';
        jQuery.ajax({
            type: 'GET',
            url: url,
            dataType: 'jsonp',
            contentType: "application/json",
            data: {
                jsonParam: JSON.stringify(json)
            },
            async: false,
            success: function (msg) {
				
				//console.log(msg);
                setCode(msg.code, format);
            }
        });
        
        json.fixed = false;
        
        jQuery.ajax({
            type: 'GET',
            url: url,
            dataType: 'jsonp',
            contentType: "application/json",
            data: {
                jsonParam: JSON.stringify(json)
            },
            async: false,
            success: function (msg) {
				
				//console.log(msg);
                
                if (!format) {
                    jQuery('#f7livePreview').html('Your live chat link example: <br />' + msg.code);
                }
               
            }
        });
        
        
        
    }

    setCode = function (value, type) {
        type = type || false;
        value = value || false;
        //	console.log(value);
        ajaxData = {
            action: 'setcode',
            type: type,
            form_key: form_key,
            value: value
        }
        jQuery.ajax({
            url: urlAjax,
            type: 'POST',
            data: ajaxData
        }).done(function (msg) {
            //	console.log('EX :: '+msg);
        });
    }




})
