/**
 * scripts.js
 *
 * Computer Science 50
 * Final Project:
 * Light Source
 *
 * Global JavaScript functions.
 */
 
const SUFFIXES = [
		"Million", 
		"Billion",
		"Trillion",
		"Quadrillion",
		"Quintillion",
		"Sextillion",
		"Septillion",
		"Octillion",
		"Nonillion",
		"Decillion",
		"Undecillion",
		"Duodecillion",
		"Tredecillion",
		"Quattuordecillion",
		"Quindecillion",
		"Sexdecillion",
		"Septendecillion",
		"Octodecillion",
		"Novemdecillion",
		"Vigintillion"];

const LIMITS = [100, 500, 2000, 10000];
const COLORS = [ "rgba(240, 103, 34, 1)", "rgba(173, 171, 170, 1)", "rgba(215, 215, 0, 1)", "rgba(229, 228, 226, 1)"];
const MEDALS = ["bronze", "silver", "gold", "platinum"];

/*
* Performs a query on the database using query.php
* Takes one array containing all arguments (including SQL query) to be passed to query function
* Arguments:
*** params: The parameters to be passed to the query function; use "-1" to be replaced with $_SESSION["id"]
*** callback: The function to be executed upon successful return of the query data, which will be automatically passed as the first arguments
*** callbackparams: An array of any further arguments that should be passed to the callback function
*/
function query(params, callback, callbackparams) {
    
    if (typeof(callbackparams) === "undefined")
    {
    	callbackparams = [];
    }
    // parameters
    var parameters = {code: "55ZYAv9lV2TdA", params: params};
    
    // contact query.php
    $.ajax({
    	type: "POST",
    	url: "query.php",
    	data: parameters,
    	dataType: "json",
    })
        
    // if received response successfully
    .done(function(data, textStatus, jqXHR) {
        
        // if response is unsuccessful query
        if (data.success == true)
        {
			callbackparams.unshift(data);
			callback.apply(this, callbackparams);
        }
        else
        {
        	console.log("Error in query.")
        }
     })
         
     // if failed, log the error
     .fail(function(jqXHR, textStatus, errorThrown) {

         // log error to browser's console
         console.log(errorThrown);
     });
} 
 
 
 
/*
* enlarge, shrinks by percent% using "enlarge" and "shrink" modes respectively
* returns to normal size using "normal" mode
*/
function change(mode, image, pixels) {
			
	// shrink 
	if (mode == "shrink")
	{
		// prepare new dimensions
		var shrinkedh = String(image.height - pixels + "px"),
			shrinkedw = String(image.width - pixels + "px");
			
		// apply new dimensions
		game.animate({
			width: shrinkedw,
			height: shrinkedh
		}, 50);
		return;
	}
	
	// enlarge image
	else if (mode == "enlarge")
	{
		// prepare new dimensions
		var enlargedh = String(image.height + pixels) + "px",
			enlargedw = String(image.width + pixels) + "px";
			
		// apply new dimesnsions	
		game.animate({
			width: enlargedw,
			height: enlargedh
		}, 50);
		return;
	}
		
		
	// return to normal size
	else if (mode == "normal")
	{
		// prepare new dimensions
		var normalh   = String(image.height) + "px",
			normalw   = String(image.width) + "px";
			
		// apply new dimensions
		game.animate({
			width: normalw,
			height: normalh
		}, 50);
		return;
	}
	return;
}

/*
* Shows a notification at the top of the window with message
* If message not provided, loading gif is used instead
*/
function showNotification(message) {

   noty({
		layout: 'bottomCenter',
		type: 'alert',
		text: message,
		dismissQueue: true,
		animation: {
		    open: 'animated fadeInUp', // or Animate.css class names like: 'animated bounceInLeft'
		    close: 'animated fadeOutDown', // or Animate.css class names like: 'animated bounceOutLeft'
		},
		timeout: 10000, // delay for closing event. Set false for sticky notifications
		maxVisible: 3, // you can set max visible notification for dismissQueue true option,
		closeWith: ['button'], // ['click', 'button', 'hover', 'backdrop'] // backdrop click will close all notifications
	});
	
}

/*
* saves the score score to the database using AJAX
* and save.php
* has three modes:
* score    : updates the score only (only first argument (an integer) is provided)
* sprite   : updates the score and the currently active sprite (only the first two arguments are provided)
* purchase : updates the score, the active sprite, and the new purchased source (all three arguments)
*/
function save(score, sprite, owned) {
    
    // initial parameters
    var parameters = {score: score, code: "55ZYAv9lV2TdA"};
    
    // determine which mode is being used and add extra parameters
    var mode;
    if (typeof(owned) === "undefined")
    {
    	if (typeof(sprite) === "undefined")
    	{
    		parameters.mode = "score";
    	}
    	else
    	{
    		parameters.mode   = "sprite";
    		parameters.sprite = sprite;
    	}
    }
    else
    {
    	parameters.mode   = "purchase";
    	parameters.sprite = sprite;
    	parameters.owned  = owned;
    }
    
    // save new score using save.php
    $.ajax({
    	type: "POST",
    	url: "save.php",
    	data: parameters,
    	dataType: "json"
    })
        
    // if received response successfully
    .done(function(data, textStatus, jqXHR) {
    
        // if response is successful saving
        if (data.success == true)
        {
        	// show notification of save successful
        	notify("alert", "save successful");
        }
        else
        {
        	// show notification save failed
        	notify("error", "save failed");
        }
     })
         
     // if failed, log the error
     .fail(function(jqXHR, textStatus, errorThrown) {

         // log error to browser's console
         console.log(errorThrown.toString());
     });
}

// animate the given label from and to the given numbers
function countUp(label, from, to, duration) {
	
	$({someValue: from}).animate({someValue: to}, {
		duration: duration,
		easing:'easeOutCubic',
		step: function() { // called on every step
	    	// Update the element's text with rounded-up value:
		    label.text(formatNumber(Math.round(this.someValue), 3));
		},
		complete:function(){
		    label.text(formatNumber(Math.round(this.someValue), 3));
		    if (interset == false)
		    {
				inter = setInterval(function()
				{
					oldscore = getNum('#counter');
					countUp2(counter, oldscore, score, 100, 3);
				}, 100);
				interset = true;
			}
		}
    });
}

// animate the given label from and to the given numbers
function countUp2(label, from, to, duration, percision) {
	
	$({someValue: from}).animate({someValue: to}, {
		duration: duration,
		easing:'linear',
		step: function() { // called on every step
	    	// Update the element's text with rounded-up value:
		    label.text(formatNumber(this.someValue, percision));
		},
		complete:function(){
		    label.text(formatNumber(this.someValue, percision));
		}
    });
}

// animate the given label from and to the given numbers
function countUp3(label, from, to, duration, percision) {
	
	$({someValue: from}).animate({someValue: to}, {
		duration: duration,
		easing:'easeOutExpo',
		step: function() { // called on every step
	    	// Update the element's text with rounded-up value:
		    label.text(formatNumber(this.someValue, percision));
		},
		complete:function(){
		    label.text(formatNumber(this.someValue,  percision));
		}
    });
}

/*
*	Produces a notification at the bottom of the screen with the text message
*/
function notify(mode, message)
{
	noty({
		layout: 'bottomCenter',
		type: mode,
		text: message,
		dismissQueue: true,
		animation: {
		    open: 'animated fadeInUp', // or other Animate.css class names like: 'animated bounceInLeft'
		    close: 'animated fadeOutDown', // or other Animate.css class names like: 'animated bounceOutLeft'
		},
		timeout: 10000, // delay for closing event. Set false for sticky notifications
		maxVisible: 3, // you can set max visible notification for dismissQueue true option,
		closeWith: ['button'], // ['click', 'button', 'hover', 'backdrop'] // backdrop click will close all notifications
	});
}


/*
*	Updates the unlocked and locked buy buttons for the given selector (either .buy or .buyauto)
*   Modes:
*	*** 0: The score is decreasing; update unlocked buttons
*	*** 1: The score is increasing; update locked buttons
* noti is a boolean attribute specifying whether or not a notification should be displayed
*/
function updateBuyButtons(selector, mode, noti)
{
	// update locked buttons if score is increasing
	if (mode == 1)
	{
	 	$(selector + '.btn-danger').each(function(index) {
				if (score >= parseFloat($(this).get(0).value))
				{
					// change colour and make it enabled
					$(this).removeClass('disabled').removeClass('btn-danger').prop('disabled', false);
				
					if (noti == 1)
					{
						// Notify user of unlock
						notify("success", "You have just unlocked a new Light Source!");
						$(this).addClass('btn-warning');
					}
					else
					{
				 		$(this).addClass('btn-success');
					}
				}
			
		});
	}
		
		// update unlocked buttons if the score is decreasing
		else if (mode == 0 && selector == '.buy')
		{
			$(selector + '.btn-warning').each(function(index) {
				if (parseInt($(this).get(0).value) > score)
				{
						$(this).addClass('disabled').addClass('btn-danger').removeClass('btn-warning').attr("disabled", "true");
				}
			});
		}
		else if (mode == 0 && selector == '.buyauto')
		{
			$(selector + '.btn-success').each(function(index) {
				if (parseInt($(this).get(0).value) > score)
				{
						$(this).addClass('disabled').addClass('btn-danger').removeClass('btn-success').attr("disabled", "true");
				}
			});
		}
	}


/*
*	Decreases the score by the price and updates the buy and buyauto buttons
*/
function buy(price)
{
			oldscore = score;
			score -= price;
			countUp(counter, oldscore, score, 3000);
			updateBuyButtons('.buy', 0, 0);
			updateBuyButtons('.buyauto', 0, 0);
}


/*
*	Removes the current sprite and replaces it with the sprite img of production increment
*/
function switchSprite(img, increment)
{
		game.addClass("animated zoomOutRight");
			// when animation is done
			game.on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(evnt) {
				// remove inline styles (width and height)
				game.removeAttr("style");
			
				// add new sprite
				game.attr("src", "/img/" + img + ".png").load(function() {
					// widths and heights for animations
					image = {
						width: game.width(),
						height: game.height(),
						increment: increment
					};
				});
				// animate in new sprite
				game.removeClass("animated zoomOutRight").addClass("animated zoomInLeft");
				game.on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(evnt) {
					// remove animation class after it is done
					game.removeClass("animated zoomInLeft");
				});
			});
}

/*
*	Gets an integer from the given selector's preformatted text
*/
function getNum(selector)
{
	return parseInt(getFloat(selector));
}

/*
*	Gets a float from the given selector's preformatted text
*/
function getFloat(selector)
{
	var ans;
	var raw = $(selector).text();
	if ((raw.match(/,/g) || []).length == 0)
	{
		var f = parseFloat(raw);
		var suffix = raw.split(" ")[1];
		if (SUFFIXES.indexOf(suffix) == -1)
		{
			ans = f;
		}
		else
		{
			ans = f * Math.pow(10, (SUFFIXES.indexOf(suffix)+2) * 3);
		}
	}
	else
	{
		ans = ($(selector).text().replace(/,/g, ''));
	}
	return parseFloat(ans);
}

function getFloat2(obj)
{
	var ans;
	var raw = obj.text();
	if ((raw.match(/,/g) || []).length == 0)
	{
		var f = parseFloat(raw);
		var suffix = raw.split(" ")[1];
		if (SUFFIXES.indexOf(suffix) == -1)
		{
			ans = f;
		}
		else
		{
			ans = f * Math.pow(10, (SUFFIXES.indexOf(suffix)+2) * 3);
		}
	}
	else
	{
		ans = ($(selector).text().replace(/,/g, ''));
	}
	return parseFloat(ans);
}

function formatNumber(num, percision)
{
	if (typeof(percision) == "undefined" || num < 1000000)
	{
		percision = 0;
	}
	
	var ans = "";
	var number = num;
	var count = 0;
	
	if (number < 1000000)
	{
		ans = s.numberFormat(number, percision);
	}
	else
	{
	
		while (number >= 1000)
		{
			number /= 1000;
			count++;
		}
		if (count <= 21)
		{
			ans = s.numberFormat(number, percision) + " " + SUFFIXES[count-2];
		}
		else
		{
			number /= 1000;
			count++;
			ans = s.numberFormat(number, 2) + 'e' + ((count) * 3);
		}
		
	}
    return ans;
}
/*
* 0 = from bronze to silver
* 1 = from silver to gold
* 2 = from gold to platinum
*/
function switchColors(num, spriteid)
{
	var prg = $('#' + spriteid + '-progress-bar');
	
	// change attributes
	prg.attr("aria-valuemin", LIMITS[num]);
	prg.attr("aria-valuemax", LIMITS[num+1]);
	prg.attr("aria-valuenow", LIMITS[num]);
	
	// change limit
	$('#' + spriteid + '-progress-limit').html(LIMITS[num+1]);
	
	// animate new color and width	
	prg.animate({
		backgroundColor: COLORS[num+1],
		width: (LIMITS[num]/LIMITS[num+1] * 100) + "%"
	}, 3000, "easeOutCubic", function(){
		prg.removeClass("progress-bar-" + num).addClass("progress-bar-" + (num+1));
	});
}

function medals(num, spriteid)
{
	// get medal
	var medal = $('#' + spriteid + "-medal");
	
	// fade out old medal
	medal.addClass("animated fadeOut");
	// when animation is done
	medal.on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(evnt) {
		
		// remove inline styles (width and height)
		medal.removeAttr("style");
			
		// substitute and fade in new medal
		medal.attr("src", "/img/" + "medal_" + num + ".png");
		medal.removeClass("animated fadeOut").addClass("animated fadeIn");
		
		// remove animation class after it is done
		medal.on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(evnt) {					
					medal.removeClass("animated zoomInLeft");
		});
	});
	
	
	// save new medal to database
	query(['INSERT INTO `medals` (userid, sourceid, type) VALUES(?, ?, ?)', -1, spriteid, num], function(){
	
		notify("success", "<b>Congratulations!</b> You just received a " + MEDALS[num] + " medal!");
		
	});
	
}

function isScrolledIntoView(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
