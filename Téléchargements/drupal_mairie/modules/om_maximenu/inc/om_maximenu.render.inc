<?php
// $Id$

/**
 * @file
 * OM Maximenu Render
 *
 * @author: Daniel Honrade http://drupal.org/user/351112
 *
 */
  
/**
 * Implementation of hook_init().
 *
 */
function om_maximenu_init() {
  global $_om_maximenu_variable;
  global $_om_maximenu_block_classes;  
  global $_om_maximenu_visible_blocks;
  
  $_om_maximenu_visible_blocks = om_maximenu_blocks_visibility();
  
  drupal_add_css(OM_MAXIMENU_PATH . '/css/om_maximenu.css');
  drupal_add_js(OM_MAXIMENU_PATH . '/js/om_maximenu.js'); 
  
  // add om tools custom block classes    
  if (module_exists('om_tools')) {

    $om_tools_values = variable_get('om_tools', '');
    $om_blocks = isset($om_tools_values['block']) ? $om_tools_values['block']: array();
    
    if (!empty($om_blocks) && ($om_blocks['block_classes_switch'] == 1)) {
      $_om_maximenu_block_classes = array();
      foreach ($om_blocks as $block_key => $block_class) {
        $block  = explode('___', $block_key);
        if (isset($block[1])) { // filters switch/reset        
          $module = $block[1];
          $delta  = $block[2];
          $_om_maximenu_block_classes[$module][$delta] = $block_class;
        }
      }
    }
  }

  // all menus settings
  $_om_maximenu_variable  = variable_get('om_maximenu', array());

  $maximenu = $_om_maximenu_variable;
  
  if (!empty($maximenu)) {
    foreach ($maximenu as $menu_key => $menu_content) {
      $visibility_values = isset($menu_content['menu_visibility']) ? $menu_content['menu_visibility']: array('visibility' => 0, 'pages' => '');
      $visibility = om_maximenu_menu_visibility($visibility_values);
      if (($menu_content['output'] == 'block') && !isset($menu_content['modal_content'])) {
        // effects won't load if disabled blocks          
        $status = !empty($menu_content['block_options']['region']) ? 1: 0;
      }
      elseif (isset($menu_content['modal_content']) && ( $menu_content['modal_content'] == 1)) {
        $status = 1; // forced include for modal     
      }
      else {
        $status = 1; // all non-blocks
      }
      if ($visibility && $status) {      
      
        // update change from tabbed to style
        $menu_content['style'] = isset($menu_content['tabbed']) ? $menu_content['tabbed']: $menu_content['style'];
      
        $action        = isset($menu_content['action']) ? $menu_content['action']: 'hover';  
        $active        = isset($menu_content['active']) ? $menu_content['active']: 0;  
        $longmenu      = isset($menu_content['longmenu']) ? $menu_content['longmenu']: FALSE;  
        $displace      = isset($menu_content['displace']) ? $menu_content['displace']: 0;  
        $delay         = isset($menu_content['delay']) ? $menu_content['delay']: 1000;  
        $fadeout       = isset($menu_content['fadeout']) ? $menu_content['fadeout']: 1;          
        $skin          = isset($menu_content['skin']) ? $menu_content['skin']: 'bubble';
        $animated_bg   = isset($menu_content['animated_bg']) ? 1: 0; 
        $animated_link = isset($menu_content['animated_link']) ? 1: 0; 
        $jiggle        = isset($menu_content['jiggle']) ? 1: 0;   
        $scroll        = isset($menu_content['scroll']) ? 1: 0; 
        $style         = isset($menu_content['style']) ? $menu_content['style']: '';                                                     
        $dock          = isset($menu_content['float_options']['dock']) ? 1: 0;
        $maximenu_name = om_string_name($menu_content['title']); 

        // add action per OM Maximenu
        om_maximenu_action($action, $maximenu_name, $displace, $style, $delay, $fadeout); 

        // add css per OM Maximenu       
        drupal_add_css(OM_MAXIMENU_PATH . '/skin/' . $skin . '/' . $skin . '.css');

        // add 'active-trail' to menu li when submenus are active
        if ($active) om_maximenu_active_js($maximenu_name, $animated_bg, $style); 

        // scroll long menu if it won't fit the container
        if ($longmenu) om_maximenu_longmenu_js($maximenu_name, $longmenu); 
        
        // animated bg effect
        if ($animated_bg) om_maximenu_bg_slider($maximenu_name);

        // animated link effect
        if ($animated_link) om_maximenu_link_slider($maximenu_name);
                 
        // animated link jiggle
        if ($jiggle) om_maximenu_jiggle($maximenu_name);
        
        // scrolling float
        if ($scroll) om_maximenu_scroll($maximenu_name);
        
        // jquery fisheye dock effect 
        if ($dock) om_maximenu_dock($maximenu_name);
      }
    }
  }
}

 
/**
 * Load all OM Maximenu blocks
 * 
 * This will process all created OM Maximenu blocks
 *
 */
function om_maximenu_block_load($maximenu_delta = '') {
  global $_om_maximenu_variable;
  
  $maximenu = $_om_maximenu_variable;
    
  $maximenu_delta = explode('-', $maximenu_delta);
  // ex. $maximenu_delta = 'om-maximenu-1';
  $delta = $maximenu_delta[2];
    
  $out = array();
  // om delta always starts with 1
  if (isset($maximenu[$delta]) && ($delta != 0)) {
    if (!empty($maximenu) && ($maximenu[$delta]['output'] == 'block')) {
      $visibility_values = isset($maximenu[$delta]['menu_visibility']) ? $maximenu[$delta]['menu_visibility']: array('visibility' => 0, 'pages' => '');
      $visibility = om_maximenu_menu_visibility($visibility_values);
      if ($visibility) {  
      
        // update change from tabbed to style
        $maximenu[$delta]['style'] = isset($maximenu[$delta]['tabbed']) ? $maximenu[$delta]['tabbed']: $maximenu[$delta]['style'];
      
        $out['title']   = check_plain($maximenu[$delta]['title']);
        $out['content'] = om_maximenu_links_render($maximenu[$delta], $delta);
      }
    }
  }
  return $out;  
}


/**
 * Load all OM Maximenu blocks
 * 
 * This will process the main menu and floating blocks
 *
 */
function om_maximenu_load() {
  global $_om_maximenu_variable;
  $maximenu = $_om_maximenu_variable;

  $out = array();
  if (!empty($maximenu)) {
    foreach ($maximenu as $menu_key => $menu_content) {

      // update change from tabbed to style
      $menu_content['style'] = isset($menu_content['tabbed']) ? $menu_content['tabbed']: $menu_content['style'];

      $visibility_values = isset($menu_content['menu_visibility']) ? $menu_content['menu_visibility']: array('visibility' => 0, 'pages' => '');
      $visibility = om_maximenu_menu_visibility($visibility_values);

      if ($visibility && ($menu_content['output'] != 'block')) {
        $out[$menu_key]['content'] = om_maximenu_links_render($maximenu[$menu_key], $menu_key); 
      }            
      
      if ($visibility) {  
      
        //$out[$menu_key]['title']   = $menu_content['title'];
        $out[$menu_key]['output']  = $menu_content['output'];
        
        // when to render modal content
        if ((isset($menu_content['style']) && ($menu_content['style'] == 'modal')) && (isset($menu_content['block_options']['region']) && !empty($menu_content['block_options']['region']))) {
          // if it's output is block and visible in region
          $render_modal_content = 1;
        }
        elseif ((isset($menu_content['style']) && ($menu_content['style'] == 'modal')) && (($menu_content['output'] == 'float') || ( $menu_content['output'] == 'main_menu'))) {
          // if the output is either float or main menu
          $render_modal_content = 1;
        }
        elseif ((($menu_content['output'] == 'block') && empty($menu_content['block_options']['region'])) && (isset($menu_content['modal_content']) && ( $menu_content['modal_content'] == 1))) {
          // force render modal content even if it's not visible in any region
          $render_modal_content = 1;
        }
        else {
          // or do not render modal content
          $render_modal_content = 0;
        }
        
        if ($render_modal_content) {
          $maximenu_name = om_string_name($menu_content['title']); 
          
          if (empty($out[$menu_key]['modal_windows'])) {
            $out[$menu_key]['modal_windows'] = theme('om_maximenu_modal_content', $menu_content, $maximenu_name);           
          }
          else {
            $out[$menu_key]['modal_windows'] .= theme('om_maximenu_modal_content', $menu_content, $maximenu_name); 
          }
        }

      }
    }
  }
  return $out;  
}


/**
 * OM Maximenu links rendering engine
 *
 */
function om_maximenu_links_render($links = array(), $menu_key = 1) {
  // immediately returns nothing if no links
  if (!isset($links['links'])) return NULL;
  
  // style content
  $style = (isset($links['style']) && ($links['style'] <> '')) ? 1: 0; 
  
  if ($style) {
    // style links        
    if ($links['style'] == 'accordion') {
      $out = theme('om_maximenu_accordion', $links, $menu_key);  
    }
    elseif ($links['style'] == 'roundabout') {
      $out = theme('om_maximenu_roundabout', $links, $menu_key);  
    }    
    elseif ($links['style'] == 'modal') {
      $out = theme('om_maximenu_modal', $links, $menu_key);  
    }
    else {
      $out = theme('om_maximenu_tabbed', $links, $menu_key);  
    }
  }
  else {
    $out = theme('om_maximenu_submenu', $links, $menu_key);  
  }
              
  // access on editing
  if (user_access('administer OM Maximenu')) $out .= '<div class="om-maximenu-edit">' . l(t('Maxedit'), 'admin/settings/om-maximenu/' . $menu_key . '/edit', array('query' => drupal_get_destination())) . '</div>';    
  
  return theme('om_maximenu_wrapper', $links, $out);
}


/**
 * OM Maximenu content rendering engine
 *
 */
function om_maximenu_content_render($content = array()) {
  global $_om_maximenu_block_classes;
  global $_om_maximenu_visible_blocks;
    
  $visible_blocks = $_om_maximenu_visible_blocks;
  //dsm($visible_blocks);  
  $block_classes = !empty($_om_maximenu_block_classes) ? $_om_maximenu_block_classes: array();  

  $count = 0;
  uasort($content, 'om_sort_by_weight'); 
  $total = count($content); 
  $out = '';
  foreach ($content as $key => $prop) {
    $count++;
        
    $module     = $prop['module'];
    $delta      = $prop['delta'];
    $visibility = (isset($prop['visibility']) && ($prop['visibility'] == 1)) ? in_array($module . '__' . $delta, $visible_blocks) ? 1: 0: 1;
    
    if ($visibility) {
      $title               = stripslashes(trim($prop['title'])); // allows markups
      $path                = ($prop['title_path'] == '<front>') ? '': $prop['title_path'];
      $options             = array();
      $options['query']    = isset($prop['title_path_query']) ? $prop['title_path_query']: '';
      $options['fragment'] = isset($prop['title_path_fragment']) ? $prop['title_path_fragment']: '';        
      $block_title         = (!empty($prop['title_path'])) ? '<a href="' . url($path, $options) .'" title="' . $title . '">' . $title . '</a>': $title;      
      $block               = module_invoke($module, 'block', 'view', $delta); 
      
      $om_classes = ($count == 1) ? ' first': '';
      if ($count == $total) $om_classes .= ' last'; 
      $om_classes .=  isset($block_classes[$module][$delta]) ? ' ' . $block_classes[$module][$delta]: ''; 
    
      $out .= theme('om_maximenu_content', $block, $module, $delta, $om_classes, $title, $block_title);   
    }                   
  }
  return $out;
}


/**
 * OM Maximenu content block visibility check
 *
 */
function om_maximenu_blocks_visibility() {
  global $user;
  
  // $theme_key is not processed on hook_init()
  $theme_key = variable_get('theme_default', 'garland');

  $visible_blocks = array();
    
  $blocks = array();

  if (!count($blocks)) {
    $rids = array_keys($user->roles);
    $result = db_query(db_rewrite_sql("SELECT DISTINCT b.* FROM {blocks} b LEFT JOIN {blocks_roles} r ON b.module = r.module AND b.delta = r.delta WHERE b.theme = '%s' AND (r.rid IN (". db_placeholders($rids) .") OR r.rid IS NULL) ORDER BY b.region, b.weight, b.module", 'b', 'bid'), array_merge(array($theme_key), $rids));
    while ($block = db_fetch_object($result)) {

      // Use the user's block visibility setting, if necessary
      if ($block->custom != 0) {
        if ($user->uid && isset($user->block[$block->module][$block->delta])) {
          $enabled = $user->block[$block->module][$block->delta];
        }
        else {
          $enabled = ($block->custom == 1);
        }
      }
      else {
        $enabled = TRUE;
      }

      // Match path if necessary
      if ($block->pages) {
        if ($block->visibility < 2) {
          $path = drupal_get_path_alias($_GET['q']);
          // Compare with the internal and path alias (if any).
          $page_match = drupal_match_path($path, $block->pages);
          if ($path != $_GET['q']) {
            $page_match = $page_match || drupal_match_path($_GET['q'], $block->pages);
          }
          // When $block->visibility has a value of 0, the block is displayed on
          // all pages except those listed in $block->pages. When set to 1, it
          // is displayed only on those pages listed in $block->pages.
          $page_match = !($block->visibility xor $page_match);
        }
        else {
          $page_match = drupal_eval($block->pages);
        }
      }
      else {
        $page_match = TRUE;
      }
      $block->enabled = $enabled;
      $block->page_match = $page_match;
      if ($page_match) $visible_blocks[] = $block->module . '__' . $block->delta;
    }
  }
  return $visible_blocks;
}
  

/**
 * Process variables for om_maximenu_submenu.tpl.php
 *
 */
function template_preprocess_om_maximenu_submenu(&$vars) {

  // sort by weight
  uasort($vars['links']['links'], 'om_sort_by_weight'); 
  
  $links = $vars['links'];
  $vars['skin'] = $links['skin'];    
  // menu name
  $vars['maximenu_name'] = om_string_name($links['title']); 

  // disable link when active
  $vars['disabled'] = (isset($links['disabled']) && ($links['disabled'] == 1)) ? 1: 0; 
  
  $vars['code'] = $links['code'];

  $vars['count'] = 0;
  $vars['total'] = count($links['links']);
        
  $vars['template_files'][] = 'om-maximenu-submenu__' . $vars['menu_key'];
  $vars['template_files'][] = 'om-maximenu-submenu__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-submenu__' . $links['output'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_submenu_links.tpl.php
 *
 */
function template_preprocess_om_maximenu_submenu_links(&$vars) {
  //dsm($vars);

  $disabled = $vars['disabled'];  
  $content  = $vars['content'];
  
    // user roles and permissions
  $vars['permission'] = om_maximenu_link_visible($vars['content']['roles']);

  // php on title
  if (isset(  $content['php_option']) && ($content['php_option'] == 1)) {
    ob_start();
      $content['link_title'] = eval($content['link_title']);
      //$output = ob_get_contents();
    ob_end_clean(); 
  }
        
  // span id
  $span_id = (!empty($content['id'])) ? ' id="' . om_string_name($content['id']) . '"': '';        

  // span title
  $span_title = (!empty($content['description']) && ($content['description_option'] == 'hover')) ? 'title="' . check_plain($content['description']) . '"': ''; 
    
  // link content      
  $link_option = om_maximenu_link_option($content);
      
  // a link attributes
  $attributes = om_maximenu_link_attrib($content);

  // link is disabled when it's on its page
  $uri = trim($_SERVER['REQUEST_URI']);
  $qpath =  $_GET['q'];
  $path_relative = base_path() . $content['path'];

  // Drupal doesn't accept # as valid path on field input
  $options = array();
  $options['query']    = isset($content['path_query']) ? $content['path_query']: '';
  $options['fragment'] = isset($content['path_fragment']) ? $content['path_fragment']: '';        
			
  // disables link when active
  $disable_active_link = ($disabled) ? (($path_relative != $uri) && ($content['path'] != $qpath)) ? 1: 0: 1;
			
  if (!empty($content['path']) && $disable_active_link) {
    $path = ($content['path'] == '<front>') ? '': $content['path'];
    // there are too many things inside this $link_options which a regular l() can't handle
    //$out .= l($content['link_title'], $content['path'], array('attributes' => $attributes));
    $vars['om_link'] = '<a ' . drupal_attributes($attributes) . ' href="' . url($path, $options) . '">' . $link_option . '</a>';
  }
  elseif (!empty($options['query']) || !empty($options['fragment'])) {
    // base path is not necessary when path is empty but anchor is not or query, 
    $vars['om_link'] = '<a ' . drupal_attributes($attributes) . ' href="' . url('', $options) . '">' . $link_option . '</a>';
  }      
  else {
    // title with javascript should have div tag
    $script_link = om_string_name($content['link_title'], FALSE);
      
    // title contains some block elements 
    $link_tag = ((isset($content['php_option']) && ($content['php_option'] == 1)) || ($script_link == 'Script Link')) ? 'div': 'span';

    // useful when you just want a button for getting the content to show and not actually linking to anything
    $vars['om_link'] = '<' . $link_tag . $span_id . ' class="' . $attributes['class'] . '" ' . $span_title . '>' . $link_option . '</' . $link_tag . '>';
  }
              
  $vars['template_files'][] = 'om-maximenu-submenu-links__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-submenu-links__' . $vars['maximenu_name'] . '-' . $vars['key'];
  $vars['template_files'][] = 'om-maximenu-submenu-links__' . om_string_name($content['link_title']);
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_submenu_content.tpl.php
 *
 */
function template_preprocess_om_maximenu_submenu_content(&$vars) {
  $vars['template_files'][] = 'om-maximenu-submenu-content__' . $vars['skin'];
  $vars['template_files'][] = 'om-maximenu-submenu-content__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-submenu-content__' . $vars['maximenu_name'] . '-' . $vars['key'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_tabbed.tpl.php
 *
 */
function template_preprocess_om_maximenu_tabbed(&$vars) {

  // sort by weight
  uasort($vars['links']['links'], 'om_sort_by_weight'); 
  
  $links = $vars['links'];
  
  // menu name
  $vars['maximenu_name'] = om_string_name($links['title']); 

  // disable link when active
  $vars['disabled'] = (isset($links['disabled']) && ($links['disabled'] == 1)) ? 1: 0; 
  
  $vars['code'] = $links['code'];

  $vars['count'] = 0;
  $vars['total'] = count($links['links']);
        
  $vars['template_files'][] = 'om-maximenu-tabbed__' . $vars['menu_key'];
  $vars['template_files'][] = 'om-maximenu-tabbed__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-tabbed__' . $links['output'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_tabbed_links.tpl.php
 *
 */
function template_preprocess_om_maximenu_tabbed_links(&$vars) {
    
  $content = $vars['content'];
  
    // user roles and permissions
  $vars['permission'] = om_maximenu_link_visible($vars['content']['roles']);

  // php on title
  if (isset(  $content['php_option']) && ($content['php_option'] == 1)) {
    ob_start();
      $content['link_title'] = eval($content['link_title']);
      //$output = ob_get_contents();
    ob_end_clean(); 
  }
        
  // span id
  $span_id = (!empty($content['id'])) ? ' id="' . om_string_name($content['id']) . '"': '';        

  // span title
  $span_title = (!empty($content['description']) && ($content['description_option'] == 'hover')) ? 'title="' . check_plain($content['description']) . '"': ''; 
    
  // link content      
  $link_option = om_maximenu_link_option($content);
      
  // a link attributes
  $attributes = om_maximenu_link_attrib($content);

  // link is disabled when it's on its page
  $uri = trim($_SERVER['REQUEST_URI']);
  $path_relative = base_path() . $content['path'];

  // Drupal doesn't accept # as valid path on field input
  $options = array();
  $options['query']    = isset($content['path_query']) ? $content['path_query']: '';
  $options['fragment'] = isset($content['path_fragment']) ? $content['path_fragment']: '';        
			
  // title with javascript should have div tag
  $script_link = om_string_name($content['link_title'], FALSE);
      
  // title contains some block elements 
  $link_tag = ((isset($content['php_option']) && ($content['php_option'] == 1)) || ($script_link == 'Script Link')) ? 'div': 'span';

  // useful when you just want a button for getting the content to show and not actually linking to anything
  $vars['om_link'] = '<' . $link_tag . $span_id . ' class="' . $attributes['class'] . '" ' . $span_title . '>' . $link_option . '</' . $link_tag . '>';
              
  $vars['template_files'][] = 'om-maximenu-tabbed-links__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-tabbed-links__' . $vars['maximenu_name'] . '-' . $vars['key'];
  $vars['template_files'][] = 'om-maximenu-tabbed-links__' . om_string_name($content['link_title']);
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_tabbed_content.tpl.php
 *
 */
function template_preprocess_om_maximenu_tabbed_content(&$vars) {
  $links = $vars['links'];
  $vars['template_files'][] = 'om-maximenu-tabbed-content__' . $links['style'];
  $vars['template_files'][] = 'om-maximenu-tabbed-content__' . $vars['maximenu_name'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_modal.tpl.php
 *
 */
function template_preprocess_om_maximenu_modal(&$vars) {

  // sort by weight
  uasort($vars['links']['links'], 'om_sort_by_weight'); 
  
  $links = $vars['links'];
  
  // menu name
  $vars['maximenu_name'] = om_string_name($links['title']); 

  // disable link when active
  $vars['disabled'] = (isset($links['disabled']) && ($links['disabled'] == 1)) ? 1: 0; 
  
  $vars['code'] = $links['code'];

  $vars['count'] = 0;
  $vars['total'] = count($links['links']);
        
  $vars['template_files'][] = 'om-maximenu-modal__' . $vars['menu_key'];
  $vars['template_files'][] = 'om-maximenu-modal__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-modal__' . $links['output'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_modal_links.tpl.php
 *
 */
function template_preprocess_om_maximenu_modal_links(&$vars) {
    
  $content = $vars['content'];
  
    // user roles and permissions
  $vars['permission'] = om_maximenu_link_visible($vars['content']['roles']);

  // php on title
  if (isset(  $content['php_option']) && ($content['php_option'] == 1)) {
    ob_start();
      $content['link_title'] = eval($content['link_title']);
      //$output = ob_get_contents();
    ob_end_clean(); 
  }
        
  // span id
  $span_id = (!empty($content['id'])) ? ' id="' . om_string_name($content['id']) . '"': '';        

  // span title
  $span_title = (!empty($content['description']) && ($content['description_option'] == 'hover')) ? 'title="' . check_plain($content['description']) . '"': ''; 
    
  // link content      
  $link_option = om_maximenu_link_option($content);
      
  // a link attributes
  $attributes = om_maximenu_link_attrib($content);

  // link is disabled when it's on its page
  $uri = trim($_SERVER['REQUEST_URI']);
  $path_relative = base_path() . $content['path'];

  // Drupal doesn't accept # as valid path on field input
  $options = array();
  $options['query']    = isset($content['path_query']) ? $content['path_query']: '';
  $options['fragment'] = isset($content['path_fragment']) ? $content['path_fragment']: '';        
			
  // title with javascript should have div tag
  $script_link = om_string_name($content['link_title'], FALSE);
      
  // title contains some block elements 
  if ((isset($content['php_option']) && ($content['php_option'] == 1)) || ($script_link == 'Script Link')) {
    // any link with scripts cannot be processed as modal
    $vars['om_link'] = '<div' . $span_id . ' class="' . $attributes['class'] . '" ' . $span_title . '>' . $link_option . '</div>';  
  }
  else {
    // useful when you just want a button for getting the content to show and not actually linking to anything
    $vars['om_link'] = '<a' . $span_id . ' href="#om-modal-content-' . $vars['code'] . '-' . $vars['key'] . '" rel="om-maximenu-modal" class="' . $attributes['class'] . '" ' . $span_title . '>' . $link_option . '</a>';
  }      
  $vars['template_files'][] = 'om-maximenu-modal-links__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-modal-links__' . $vars['maximenu_name'] . '-' . $vars['key'];
  $vars['template_files'][] = 'om-maximenu-modal-links__' . om_string_name($content['link_title']);
}


/**
 * Process variables for om_maximenu_modal_content.tpl.php
 *
 */
function template_preprocess_om_maximenu_modal_content(&$vars) {
  $links = $vars['links'];
  $vars['template_files'][] = 'om-maximenu-modal-content__' . $links['style'];
  $vars['template_files'][] = 'om-maximenu-modal-content__' . $links['skin'];
  $vars['template_files'][] = 'om-maximenu-modal-content__' . $vars['maximenu_name'];  
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_accordion.tpl.php
 *
 */
function template_preprocess_om_maximenu_accordion(&$vars) {

  // sort by weight
  uasort($vars['links']['links'], 'om_sort_by_weight'); 
  
  $links = $vars['links'];
  
  // menu name
  $vars['maximenu_name'] = om_string_name($links['title']); 

  // disable link when active
  $vars['disabled'] = (isset($links['disabled']) && ($links['disabled'] == 1)) ? 1: 0; 
  
  $vars['code'] = $links['code'];

  $vars['count'] = 0;
  $vars['total'] = count($links['links']);
        
  $vars['template_files'][] = 'om-maximenu-accordion__' . $vars['menu_key'];
  $vars['template_files'][] = 'om-maximenu-accordion__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-accordion__' . $links['output'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_accordion_links.tpl.php
 *
 */
function template_preprocess_om_maximenu_accordion_links(&$vars) {
  
  $content = $vars['content'];
  
    // user roles and permissions
  $vars['permission'] = om_maximenu_link_visible($vars['content']['roles']);

  // php on title
  if (isset(  $content['php_option']) && ($content['php_option'] == 1)) {
    ob_start();
      $content['link_title'] = eval($content['link_title']);
      //$output = ob_get_contents();
    ob_end_clean(); 
  }
        
  // span id
  $span_id = (!empty($content['id'])) ? ' id="' . om_string_name($content['id']) . '"': '';        

  // span title
  $span_title = (!empty($content['description']) && ($content['description_option'] == 'hover')) ? 'title="' . check_plain($content['description']) . '"': ''; 
    
  // link content      
  $link_option = om_maximenu_link_option($content);
      
  // a link attributes
  $attributes = om_maximenu_link_attrib($content);

  // dt style doesn't need any a tag
  $vars['om_accordion_dt'] = '<dt' . $span_id . ' class="' . $attributes['class'] . '" ' . $span_title . '>' . $link_option . '</dt>';
                          
  $vars['template_files'][] = 'om-maximenu-accordion-links__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-accordion-links__' . $vars['maximenu_name'] . '-' . $vars['key'];  
  $vars['template_files'][] = 'om-maximenu-accordion-links__' . om_string_name($content['link_title']);
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_accordion_content.tpl.php
 *
 */
function template_preprocess_om_maximenu_accordion_content(&$vars) {
  $vars['template_files'][] = 'om-maximenu-accordion-content__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-accordion-content__' . $vars['maximenu_name'] . '-' . $vars['key'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_roundabout.tpl.php
 *
 */
function template_preprocess_om_maximenu_roundabout(&$vars) {

  // sort by weight
  uasort($vars['links']['links'], 'om_sort_by_weight'); 
  
  $links = $vars['links'];
  
  // menu name
  $vars['maximenu_name'] = om_string_name($links['title']); 

  // disable link when active
  $vars['disabled'] = (isset($links['disabled']) && ($links['disabled'] == 1)) ? 1: 0; 
  
  $vars['code'] = $links['code'];

  $vars['count'] = 0;
  $vars['total'] = count($links['links']);
        
  $vars['template_files'][] = 'om-maximenu-roundabout__' . $vars['menu_key'];
  $vars['template_files'][] = 'om-maximenu-roundabout__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-roundabout__' . $links['output'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_roundabout_links.tpl.php
 *
 */
function template_preprocess_om_maximenu_roundabout_links(&$vars) {
    
  $content = $vars['content'];
  
    // user roles and permissions
  $vars['permission'] = om_maximenu_link_visible($vars['content']['roles']);

  // php on title
  if (isset(  $content['php_option']) && ($content['php_option'] == 1)) {
    ob_start();
      $content['link_title'] = eval($content['link_title']);
      //$output = ob_get_contents();
    ob_end_clean(); 
  }
        
  // span id
  $span_id = (!empty($content['id'])) ? ' id="' . om_string_name($content['id']) . '"': '';        

  // span title
  $span_title = (!empty($content['description']) && ($content['description_option'] == 'hover')) ? 'title="' . check_plain($content['description']) . '"': ''; 
    
  // link content      
  $link_option = om_maximenu_link_option($content);
      
  // a link attributes
  $attributes = om_maximenu_link_attrib($content);

  // title with javascript should have div tag
  $script_link = om_string_name($content['link_title'], FALSE);
      
  // title contains some block elements 
  $link_tag = ((isset($content['php_option']) && ($content['php_option'] == 1)) || ($script_link == 'Script Link')) ? 'div': 'span';

  // useful when you just want a button for getting the content to show and not actually linking to anything
  $vars['om_link'] = '<' . $link_tag . $span_id . ' class="' . $attributes['class'] . '" ' . $span_title . '>' . $link_option . '</' . $link_tag . '>';
              
  $vars['template_files'][] = 'om-maximenu-roundabout-links__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-roundabout-links__' . $vars['maximenu_name'] . '-' . $vars['key'];
  $vars['template_files'][] = 'om-maximenu-roundabout-links__' . om_string_name($content['link_title']);
}


/**
 * Process variables for om_maximenu_roundabout_content.tpl.php
 *
 */
function template_preprocess_om_maximenu_roundabout_content(&$vars) {
  $vars['template_files'][] = 'om-maximenu-accordion-content__' . $vars['maximenu_name'];
  $vars['template_files'][] = 'om-maximenu-accordion-content__' . $vars['maximenu_name'] . '-' . $vars['key'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_wrapper.tpl.php
 *
 */
function template_preprocess_om_maximenu_wrapper(&$vars) {
  $links = $vars['links'];
  $vars['maximenu_name'] = om_string_name($links['title']); 
  $vars['link_code']     = isset($links['code']) ? trim($links['code']): 'om-u'. $vars['user']->uid . '-' . mt_rand();  

  $vars['template_files'][] = 'om-maximenu-wrapper__' . $vars['link_code'];
  $vars['template_files'][] = 'om-maximenu-wrapper__' . $vars['maximenu_name'];
  //dsm($vars);
}


/**
 * Process variables for om_maximenu_content.tpl.php
 *
 */
function template_preprocess_om_maximenu_content(&$vars) {
  if (!isset($vars['block']['content'])) $vars['block']['content'] = ''; 
  $vars['template_files'][] = 'om-maximenu-content__' . $vars['module'];
  $vars['template_files'][] = 'om-maximenu-content__' . $vars['module'] . '-' . $vars['delta'];
  //dsm($vars);
}




