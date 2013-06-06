
//Very minor change from the jquery_colorpicker module in order to make it work with this
// $Id: jquery_colorpicker.js,v 1.1 2010/05/27 18:57:11 btopro Exp $
// JavaScript Document

// The following code is called on page load by Drupal
Drupal.behaviors.jqueryColorpicker = function()
{
	var targets = "";
	var first = true;
	// First we initialize some CSS settings - adding the background that the user has chosen etc. 
	for(var i = 0; i < Drupal.settings.jqueryColorpicker.ids.length; i++)
	{
		if(!first)
		{
			targets += ", ";
		}
		else
		{
			first = false;
		}
		// This following gives us the ID of the element we will use as a point of reference for the settings
		var id = "#" + Drupal.settings.jqueryColorpicker.ids[i] + "-wrapper";
		// Next we use that point of reference to set a bunch of CSS settings
		$(id).children(".inner_wrapper").css({"background-image" : "url(" + Drupal.settings.jqueryColorpicker.backgrounds[i] + ")", "height" : "36px", "width" : "36px", "position" : "relative"})
		.children(".color_picker").css({"background-image" : "url(" + Drupal.settings.jqueryColorpicker.backgrounds[i] + ")", "background-repeat" : "no-repeat", "background-position" : "center center", "height" : "30px", "width" : "30px", "position" : "absolute", "top" : "3px", "left" : "3px"})
		.children().css({"display" : "none"});
		// we build a list of IDS that will then be acted upon in the next section of code
		targets += id;
	}
	
	// next we use the list of IDs we just built and act upon each of them
	$(targets).each(function()
	{
		// First we get a point of reference from which to work
		var target = $(this).children(".inner_wrapper").attr("id");
		// we set the display of the label to inline. The reason for this is that clicking on a label element
		// automatically sets the focus on the input. With the jquery colorpicker, this means the colorpicker
		// pops up. When the display isn't set to inline, it extends to 100% width, meaning the clickable
		// area is much bigger than it should be, making the 'invisible' clickable space very large.
		// When it's set to inline, the width of the lable is only as wide as the text
		// as big as 
		$("#" + target).siblings("label:first").css("display",  "inline");
		// next we get the background color of the element
		var defaultColor = $("#" + target + " .color_picker").css("background-color");
		// if the background color is an rgb value, which it is when using firefox, we convert it to a
		// hexidecimal number
		if(defaultColor.match(/rgb/))
		{
			defaultColor = jqueryColorpicker.rgb2hex(defaultColor);
		}
		// finally we initialize the colorpicker element. This calls functions provided by the 3rd party code.
		var trigger = $(this).children(".inner_wrapper").children(".color_picker");
		trigger.ColorPicker(
		{
			color: defaultColor,
			onShow: function (colpkr)
			{
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr)
			{
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb)
			{
				$("#" + target + " .color_picker").css("backgroundColor", "#" + hex).children("input").val(hex).keyup();
			}
		});
	});
}