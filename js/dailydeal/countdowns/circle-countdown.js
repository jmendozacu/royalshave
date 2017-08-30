/*
Item Name : Circular Countdown jQueryDD Plugin
Item URI : http://codecanyon.net/item/circular-countdown-jqueryDD-plugin/3761921
Author URI : http://codecanyon.net/user/Pixelworkshop/
Version : 1.21
*/



(function ($) {
    $.fn.circularCountdown = function (method) {
    	var settings;
	    this.methods = {
	        
	        init:function (options) {
	            
	            settings = $.extend(1, settings, options);

	            return this.each(function () {

					countdownTimer(settings);
		            countdownArcs(settings);

		            // resize
					var container = $('#countdown-'+settings.id).parent();
					if (container.hasClass('countdown-days')) {
						var width = container.width();
						if(width<=220 && width>=192) {
							container.addClass('countdown-large');
						} else if(width>=170 && width<192) {
							container.addClass('countdown-medium');
						} else if(width<170 && width>=156) {
							container.addClass('countdown-small');
						} else if(width<156) {
							container.addClass('countdown-xsmall');
						}
					} else {
						var width = container.width();
						if(width<204 && width>=170) {
							container.addClass('countdown-large');
						} else if(width<170 && width>=156) {
							container.addClass('countdown-medium');
						} else if(width<156) {
							container.addClass('countdown-small');
						}
					}

					$(window).resize(function() {
						if (container.hasClass('countdown-days')) {
							container.removeClass('countdown-large countdown-medium countdown-small countdown-xsmall');
							var width = container.width();
							if(width<=220 && width>=192) {
								container.addClass('countdown-large');
							} else if(width>=170 && width<192) {
								container.addClass('countdown-medium');
							} else if(width<170 && width>=156) {
								container.addClass('countdown-small');
							} else if(width<156) {
								container.addClass('countdown-xsmall');
							}
						} else {
							container.removeClass('countdown-large countdown-medium countdown-small countdown-xsmall');
							var width = container.width();
							if(width<204 && width>=170) {
								container.addClass('countdown-large');
							} else if(width<170 && width>=156) {
								container.addClass('countdown-medium');
							} else if(width<156) {
								container.addClass('countdown-small');
							}
						}
					});	

	            }); // End each

	        },

	        update:function (options) {
	            settings = $.extend(1, settings, options);
	        }
	    };

        if (this.methods[method]) {
            return this.methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return this.methods.init.apply(this, arguments);
        } else {
            $.error('No found method ' + method);
        }

    };


	function countdownArcs(settings) { 

			this.circularCountdown = $('#circular_countdown_days-'+settings.id),
			this.countdownElementRadius = ($('#countdown-'+settings.id+'-timer'+' li').width() - settings.strokeWidth) / 2,
			this.countdownElementWidth = this.countdownElementRadius * 2 + settings.strokeWidth,
			this.countdownXPosition = this.countdownElementWidth / 2,
			this.countdownYPosition = this.countdownElementWidth / 2;


			$("#circular_countdown_days-"+settings.id).detectPixelRatio()
				.drawArc({
					layer: true,
					name: "days_bg",
					strokeStyle: settings.strokeDaysBackgroundColor,
					strokeWidth: settings.strokeBackgroundWidth,
					radius: countdownElementRadius,
					shadowColor: settings.backgroundShadowColor,
					shadowBlur: settings.backgroundShadowBlur,
					x: this.countdownXPosition, 
					y: this.countdownYPosition
				})
				.drawArc({
					layer: true,
					name: "days",
					strokeStyle: settings.strokeDaysColor,
					strokeWidth: settings.strokeWidth,
					radius: countdownElementRadius,
					x: this.countdownXPosition, 
					y: this.countdownYPosition
				})
			$("#circular_countdown_hours-"+settings.id)
				.drawArc({
					layer: true,
					name: "hours_bg",
					strokeStyle: settings.strokeHoursBackgroundColor,
					strokeWidth: settings.strokeBackgroundWidth,
					radius: countdownElementRadius,
					shadowColor: settings.backgroundShadowColor,
					shadowBlur: settings.backgroundShadowBlur,
					x: this.countdownXPosition, 
					y: this.countdownYPosition
				})
				.drawArc({
					layer: true,
					name: "hours",
					strokeStyle: settings.strokeHoursColor,
					strokeWidth: settings.strokeWidth,
					radius: countdownElementRadius,
					x: this.countdownXPosition, 
					y: this.countdownYPosition
				})
			$("#circular_countdown_minutes-"+settings.id)
				.drawArc({
					layer: true,
					name: "minutes_bg",
					strokeStyle: settings.strokeMinutesBackgroundColor,
					strokeWidth: settings.strokeBackgroundWidth,
					radius: countdownElementRadius,
					shadowColor: settings.backgroundShadowColor,
					shadowBlur: settings.backgroundShadowBlur,
					x: this.countdownXPosition, 
					y: this.countdownYPosition
				})
				.drawArc({
					layer: true,
					name: "minutes",
					strokeStyle: settings.strokeMinutesColor,
					strokeWidth: settings.strokeWidth,
					radius: countdownElementRadius,
					x: this.countdownXPosition, 
					y: this.countdownYPosition
				})
			$("#circular_countdown_seconds-"+settings.id)
				.drawArc({
					layer: true,
					name: "seconds_bg",
					strokeStyle: settings.strokeSecondsBackgroundColor,
					strokeWidth: settings.strokeBackgroundWidth,
					radius: countdownElementRadius,
					shadowColor: settings.backgroundShadowColor,
					shadowBlur: settings.backgroundShadowBlur,
					x: this.countdownXPosition, 
					y: this.countdownYPosition
				})
				.drawArc({
					layer: true,
					name: "seconds",
					strokeStyle: settings.strokeSecondsColor,
					strokeWidth: settings.strokeWidth,
					radius: countdownElementRadius,
					x: this.countdownXPosition, 
					y: this.countdownYPosition
				})

				.drawLayers()

	}


	function countdownAnimation(settings) { 

		$("#circular_countdown_days-"+settings.id)
			.animateLayer("days", {
				end:$('#countdown-'+settings.id+'-timer'+' ul li.days em').text() * 0.9863
			}, settings.countdownTickSpeed, settings.countdownEasing)
		$("#circular_countdown_hours-"+settings.id)
			.animateLayer("hours", {
				end:$('#countdown-'+settings.id+'-timer'+' ul li.hours em').text() * 15
			}, settings.countdownTickSpeed, settings.countdownEasing)
		$("#circular_countdown_minutes-"+settings.id)
			.animateLayer("minutes", {
				end:$('#countdown-'+settings.id+'-timer'+' ul li.minutes em').text() * 6
			}, settings.countdownTickSpeed, settings.countdownEasing)
		$("#circular_countdown_seconds-"+settings.id)
			.animateLayer("seconds", {
				end:$('#countdown-'+settings.id+'-timer'+' ul li.seconds em').text() * 6
			}, settings.countdownTickSpeed, settings.countdownEasing)
					
	}

	function serverTime(settings) { 
		alert(settings.id);
    	var server = new Date(2014, 10, 20, 8); 
    	return server; 
	}

	function countdownTimer(settings) { 

		$('#countdown-'+settings.id+'-timer').countdown({

			// new Date(year, mth, day, hr, min, sec) - Date / Time to count down to 

			// How to format the date :
			// Year,
			// Month (january = 0, february = 1; etc.),
			// Day of the month (2 for the 2nd, 3 for the 3rd, etc.),
			// Hour of the day (using the 24-hour system) 
			// Optionnally you can add minutes and seconds separated by commas

			// Examples : 
			// new Date(2014, 2, 15, 18) will count until the 15th of March 2014 at 6 PM.
			// new Date(2013, 6, 3, 8) will count until the 3rd of July 2013 at 8 AM.

			// until: settings.until, 
			until: settings.until, 
			serverSync: function serverTime() { 
					    	var server = new Date(settings.currentDateTime); 
					    	return server; 
						}, 
			// timezone: 2,
			format: 'DHMS',
			layout: settings.layout,

			onTick: function() {
				countdownAnimation(settings);
			}
		});				
	}


})(jQueryDD);