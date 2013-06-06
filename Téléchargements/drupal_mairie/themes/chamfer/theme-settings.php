<?php
/**
* Implementation of THEMEHOOK_settings() function.
*
* @param $saved_settings
*   array An array of saved settings for this theme.
* @return
*   array A form array.
*/
function phptemplate_settings($saved_settings) {
  drupal_add_js(drupal_get_path('theme', 'chamfer') .'/js/settings.js', 'theme');
  if (module_exists('jquery_colorpicker')) {
    drupal_add_js(drupal_get_path('theme','chamfer') .'/js/jquery_colorpicker.js','theme');
  }
  /*
   * The default values for the theme variables. Make sure $defaults exactly
   * matches the $defaults in the template.php file.
   */
  $color_array = array(
   'default' => 'Default',
   'mudbrown' => 'Mud Brown',
   'silver' => 'Silver',
   'formalgreen' => 'Formal Green',
   'black' => 'Space Opera Black',
   'space' => 'Space Custom',
   'custom' => 'Custom',
  );
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

  // Merge the saved variables and their default values
  $settings = array_merge($defaults, $saved_settings);

  // Create the form widgets using Forms API
  $form['chamfer_color_template'] = array(
    '#type' => 'select',
    '#title' => t('Template'),
	'#description' => t('Use this color template'),
	'#options' => $color_array,
    '#default_value' => $settings['chamfer_color_template'],
  );
  if (module_exists('jquery_colorpicker')) {
    $fieldtype = 'colorpicker';
  }
  else {
    $fieldtype = 'textfield';
  }
  //page colors
  $form['page'] = array(
    '#type' => 'fieldset',
	'#title' => t('Page Settings'),
	'#description' => t("Change page related colors"),
	'#collapsed' => TRUE,
	'#collapsible' => TRUE,
  );
  $form['page']['chamfer_bgimage'] = array(
    '#type' => 'checkbox',
    '#title' => t('Background Image'),
	'#description' => t('Whether or not to show the background image'),
    '#default_value' => $settings['chamfer_bgimage'],
  );
  $form['page']['chamfer_borders'] = array(
    '#type' => 'checkbox',
    '#title' => t('Include Borders'),
	'#description' => t('Whether or not there should be a 10px border'),
    '#default_value' => $settings['chamfer_borders'],
  );
  $form['page']['chamfer_color_primary'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,
    '#title' => t('Background'),
	'#description' => t('Color of the background'),
    '#default_value' => $settings['chamfer_color_primary'],
  );
  $form['page']['chamfer_color_secondary'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Secondary Background'),
	'#description' => t('Color of the Inner background, the border and header / footer'),
    '#default_value' => $settings['chamfer_color_secondary'],
  );
  //header
  $form['header'] = array(
    '#type' => 'fieldset',
	'#title' => t('Header Settings'),
	'#description' => t('Change items in the header'),
	'#collapsed' => TRUE,
	'#collapsible' => TRUE,
  );
  $form['header']['chamfer_top_logo'] = array(
    '#type' => 'select',
    '#title' => t('Show Top Logo'),
	'#description' => t('Display the logo at the top left of the interface'),
	'#options' => array(0 => 'No', 1 => 'Logo 1', 2 => 'Logo 2'),
    '#default_value' => $settings['chamfer_top_logo'],
  );
  $form['header']['chamfer_top_link'] = array(
    '#type' => 'textfield',
    '#title' => t('Top Logo Link'),
	'#description' => t('The link the logo should go to when clicked, leave blank for none'),
    '#default_value' => $settings['chamfer_top_link'],
  );
  $form['header']['chamfer_color_header1'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Site Title'),
	'#description' => t('Color of the site title'),
    '#default_value' => $settings['chamfer_color_header1'],
  );
  $form['header']['chamfer_color_header2'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Site Slogan'),
	'#description' => t('Color of the site slogan'),
    '#default_value' => $settings['chamfer_color_header2'],
  );
  //content
  $form['content'] = array(
    '#type' => 'fieldset',
	'#title' => t('Content Settings'),
	'#description' => t("Change content related colors"),
	'#collapsed' => TRUE,
	'#collapsible' => TRUE,
  );
  $form['content']['chamfer_color_text'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Text'),
	'#description' => t('Body of content text'),
    '#default_value' => $settings['chamfer_color_text'],
  );
  $form['content']['chamfer_color_link'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Links'),
	'#description' => t('Color of content links'),
    '#default_value' => $settings['chamfer_color_link'],
  );
  $form['content']['chamfer_color_blocks'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Block background'),
	'#description' => t('Background color of the block regions in the content'),
    '#default_value' => $settings['chamfer_color_blocks'],
  );
  $form['content']['chamfer_color_blockstyle_link'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Special Style Link'),
	'#description' => t('The special block style link color'),
    '#default_value' => $settings['chamfer_color_blockstyle_link'],
  );
  $form['content']['chamfer_color_blockstyle_linkhover'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Special Style Hovered link'),
	'#description' => t('The special block style hovered link color'),
    '#default_value' => $settings['chamfer_color_blockstyle_linkhover'],
  );
  $form['content']['chamfer_color_blockstyle_bgcolor'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Special Style Background'),
	'#description' => t('Hover color for special block style'),
    '#default_value' => $settings['chamfer_color_blockstyle_bgcolor'],
  );
	$block_options = array();
	$result = db_query("SELECT bid,module,delta FROM {blocks} WHERE theme='chamfer' AND status=1 AND (region='left' OR region='right') ORDER BY weight");
	while ($val = db_fetch_array($result)) {
		$blocks = call_user_func_array($val['module'] .'_block', array('list'));
		$block_options[$val['bid']] = $blocks[$val['delta']]['info'];
	}
	$form['content']['chamfer_color_specialblock'] = array(
    '#type' => 'select',  
	'#title' => t('Special Style Background'),
	'#multiple' => TRUE,
	'#description' => t('Which blocks should have the special styling?'),
  '#options' => $block_options,
    '#default_value' => $settings['chamfer_color_specialblock'],
  );
	$form['content']['chamfer_taxonomy'] = array(
    '#type' => 'select',  
	'#title' => t('Taxonomy'),
	'#description' => t('Display taxonomy with node?'),
  '#options' => array(0 => 'No', 1 => 'Yes'),
    '#default_value' => $settings['chamfer_taxonomy'],
  );
  //footer
  $form['footer'] = array(
    '#type' => 'fieldset',
	'#title' => t('Footer Settings'),
	'#description' => t('Change items in the footer'),
	'#collapsed' => TRUE,
	'#collapsible' => TRUE,
  );
  $form['footer']['chamfer_bottom_logo'] = array(
    '#type' => 'select',
    '#title' => t('Show Bottom Logo'),
	'#description' => t('Display the logo at the top left of the interface'),
	'#options' => array(0 => 'No', 1 => 'Logo 1', 2 => 'Logo 2'),
    '#default_value' => $settings['chamfer_bottom_logo'],
  );
  $form['footer']['chamfer_bottom_link'] = array(
    '#type' => 'textfield',
    '#title' => t('Bottom Logo Link'),
	'#description' => t('The link the logo should go to when clicked, leave blank for none'),
    '#default_value' => $settings['chamfer_bottom_link'],
  );
  $form['footer']['chamfer_color_footer_text'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Footer text'),
	'#description' => t('Color of the footer text'),
    '#default_value' => $settings['chamfer_color_footer_text'],
  );
  $form['footer']['chamfer_color_footer_links'] = array(
    '#type' => $fieldtype,
	'#size' => 6,
	'#maxlength' => 6,    
	'#title' => t('Footer links'),
	'#description' => t('Color of the footer links'),
    '#default_value' => $settings['chamfer_color_footer_links'],
  );
	$form['preset_generate'] = array(
	  '#type' => 'button',
		'#value' => 'Generate Preset',
	);
  // Return the additional form widgets
  return $form;
}
?>