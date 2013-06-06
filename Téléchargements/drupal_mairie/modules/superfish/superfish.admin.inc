<?php

/**
 * @file
 * Functions that are only called on the admin pages.
 */

/**
 * Generate the default path for the Superfish library.
 */
function superfish_library_path() {
  // Ensure the Libraries API module is installed and working.
  if (module_exists('libraries') && function_exists('libraries_get_path')) {
    $directory = libraries_get_path('superfish');
  }
  // Otherwise use the default directory.
  else {
    $directory = 'sites/all/libraries/superfish';
  }
  if (file_exists($directory)) {
    $output = $directory . "/jquery.hoverIntent.minified.js\n" .
      $directory . "/jquery.bgiframe.min.js\n" .
      $directory . "/superfish.js\n" .
      $directory . "/supersubs.js\n" .
      $directory . "/supposition.js\n" .
      $directory . "/sftouchscreen.js\n" .
      $directory . "/sfsmallscreen.js";
  }
  else {
    $output = '';
  }
  return $output;
}

/**
 * Overriding system settings form.
 */
function superfish_system_settings_form($form) {
  $form['buttons']['submit'] = array('#type' => 'submit', '#value' => t('Save configuration') );
  if (!empty($_POST) && form_get_errors()) {
    drupal_set_message(t('The settings have not been saved because of the errors.'), 'error');
  }
  $form['#submit'][] = 'system_settings_form_submit';
  $form['#theme'] = 'system_settings_form';
  return $form;
}

/**
 * Module settings form.
 */
function superfish_menu_settings() {
  $form['superfish_number'] = array(
    '#type' => 'select',
    '#title' => t('Number of blocks'),
    '#multiple' => FALSE,
    '#options' => drupal_map_assoc(range(1, 50)),
    '#description' => t('The number of Superfish menu blocks.'),
    '#default_value' => variable_get('superfish_number', 4),
  );
  $form['superfish_slp'] = array(
    '#type' => 'textarea',
    '#title' => t('Path to Superfish library'),
    '#description' => t('Edit only if you are sure of what you are doing.'),
    '#default_value' => variable_get('superfish_slp', superfish_library_path()),
    '#rows' => 7,
  );
  return superfish_system_settings_form($form);
}

/**
 * Implements hook_validate().
 */
function superfish_menu_settings_validate($form, &$form_state) {
  $error = array();
  $sf_library = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", trim($form_state['values']['superfish_slp']));
  if (empty($sf_library)) {
    form_set_error('superfish_slp', t('<strong>Path to Superfish library</strong> field cannot be empty. Please try the below list:') . '<br /><pre>' . superfish_library_path() . '</pre>');
  }
  else {
    // Trimming blank lines and such
    $sf_library = explode("\n", $sf_library);
    // Crystal clear
    foreach ($sf_library as $s) {
      if (!file_exists($s)) {
        $error[] = $s;
      }
    }
    if (!empty($error)) {
      $error_message = '';
      if (count($error) > 1) {
        foreach ($error as $e) {
          $error_message .= '<li>' . $e . '</li>';
        }
        $error_message = t('Files not found') . ': <ul>' . $error_message . '</ul>';
      }
      else {
        $error_message = t('File not found') . ': ' . $error[0];
      }
      form_set_error('superfish_slp', $error_message);
    }
  }
}