/**
 * @file
 * The Superfish Drupal Behavior to apply the Superfish jQuery plugin to lists.
 */

(function ($) {
  Drupal.behaviors.superfish = function (context) {
    // Take a look at each list to apply Superfish to.
    $.each(Drupal.settings.superfish || {}, function(index, options) {
      // Process all Superfish lists.
      var  list = $('#superfish-' + options.id, context);

      // Check if we are to apply the Supersubs plug-in to it.
      if (options.plugins || false) {
        if (options.plugins.supersubs || false) {
          list.supersubs(options.plugins.supersubs);
        }
      }

      // Apply Superfish to the list.
      list.superfish(options.sf);

      // Check if we are to apply any other plug-in to it.
      if (options.plugins || false) {
        if (options.plugins.touchscreen || false) {
          list.sftouchscreen(options.plugins.touchscreen);
        }
        if (options.plugins.smallscreen || false) {
          list.sfsmallscreen(options.plugins.smallscreen);
        }
        if (options.plugins.supposition || false) {
          list.supposition();
        }
        if (options.plugins.bgiframe || false) {
          list.find('ul').bgIframe({opacity:false});
        }
      }
    });
  };
}(jQuery));