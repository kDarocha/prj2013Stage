<?php // $Id: template.php
if (is_null(theme_get_setting('chamfer_borders'))) { // if this is null it means nothing has been set so we should have defaults created to render correctly
  global $theme_key;
  /*
   * The default values for the theme variables. Make sure $defaults exactly
   * matches the $defaults in the theme-settings.php file.
   */ 
  $defaults = array(
    'chamfer_borders' => 1,
	'chamfer_bgimage' => 0,
    'chamfer_top_logo' => 1, //0,1 or 2 for off, clear or solid
	'chamfer_top_link' => '',
	'chamfer_bottom_logo' => 1, //0,1 or 2 for off, clear or solid
	'chamfer_bottom_link' => '',
	'chamfer_color_template' => 'default',
    'chamfer_color_primary' => '000000',
	'chamfer_color_secondary' => '000000',
	'chamfer_color_header1' => '0099FF',
	'chamfer_color_header2' => '00CCFF',
	'chamfer_color_text' => '666666',
	'chamfer_color_link' => '0099FF',
	'chamfer_color_blocks' => 'E7E7E7',
	'chamfer_color_blockstyle_link' => '6D6D6D',
	'chamfer_color_blockstyle_bgcolor' => 'df5c5c',
	'chamfer_color_blockstyle_linkhover' => 'FFFFFF',
	'chamfer_color_footer_text' => 'FFFFFF',
	'chamfer_color_footer_link' => '00CCFF',
  );

  // Get default theme settings.
  $settings = theme_get_settings($theme_key);
  // Save default theme settings.
  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge($defaults, $settings)
  );
  // Force refresh of Drupal internals.
  theme_get_setting('', TRUE);
}

/**
 * Add custom PHPTemplate variable into the page template
 */
function chamfer_preprocess_page(&$vars) {
if ($vars['template_files'][4] == 'page-admin-build-themes-settings-chamfer') {
	$vars['content'] = str_replace('<fieldset class="theme-settings-bottom">','<fieldset class="collapsed collapsible theme-settings-bottom">',str_replace('<fieldset>','<fieldset class="collapsed collapsible">',$vars['content']));
}

}

function chamfer_preprocess(&$variables,$hook) {
 drupal_add_js('misc/collapse.js', 'theme');
 $js_variables = array();
  if ($hook == 'book_navigation') {
    $js_variables = array(
	'prev_title' => $variables['prev_title'],
	'prev_url' => $variables['prev_url'],
	'next_title' => $variables['next_title'],
	'next_url' => $variables['next_url'],
    );
  }
  if ($hook == 'page') {
    if (module_exists('jquery_colorpicker')) {
      $js_variables['colorpicker'] = 1;
    }
    else {
      $js_variables['colorpicker'] = 0;
    }
  }
  drupal_add_js(array('chamfer' => $js_variables), "setting");
}

function chamfer_menu_item_link($link) {
  if (empty($link['options'])) {
    $link['options'] = array();
  }
//$test = '<pre>'. var_export($link,TRUE) .'</pre>';
  // If an item is a LOCAL TASK, render it as a tab
    $link['title'] = '<div class="link-wrapper-1"><div class="link-wrapper-2">' . check_plain($link['title']) . '</div></div>';
    $link['options']['html'] = TRUE;

  if (empty($link['type'])) {
    $true = TRUE;
  }

  return l($link['title'], $link['href'], $link['options']);
}

/**
* Sets the body tag class and id attributes.
*
* From the Theme Developer's Guide, http://drupal.org/node/32077
*
* @param $is_front
*   boolean Whether or not the current page is the front page.
* @param $layout
*   string Which sidebars are being displayed.
* @return
*   string The rendered id and class attributes.
*/
function chamfer_body_attributes($is_front = false, $layout = 'none') {
  if ($is_front) {
    $body_id = $body_class = 'homepage';
  }
  else {
    // Remove base path and any query string.
    global $base_path;
    list(,$path) = explode($base_path, request_uri(), 2);
    list($path,) = explode('?', $path, 2);
    $path = rtrim($path, '/');
    // Construct the id name from the path, replacing slashes with dashes.
    $body_id = str_replace('/', '-', $path);
    // Construct the class name from the first part of the path only.
    list($body_class,) = explode('/', $path, 2);
  }
  $body_id = 'page-'. $body_id;
  $body_class = 'section-'. $body_class;

  // Use the same sidebar classes as Garland.
  $sidebar_class = ($layout == 'both') ? 'sidebars' : "sidebar-$layout";

//setup bg image
	if (theme_get_setting('chamfer_bgimage') == 0) {
    $bgimage = '';
	}
  else {
    $bgimage = 'bg-image';
  }

  return " id=\"$body_id\" class=\"primary-color $body_class $sidebar_class $bgimage\"";
}