$(function() {
	
	/*
	 * prevents aelements with class 'noSelect' from being highlighted on double clicks
	 */
	$.extend($.fn.disableTextSelect = function() {
    	return this.each(function(){
                $(this).mousedown(function(){return false;});
            });
    });
    //No text selection on elements with a class of 'noSelect'
    $('.noSelect').disableTextSelect();
});
