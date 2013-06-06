<?php 
//populate the chamfer settings array
$chamfer = array();
$chamfer['borders'] = theme_get_setting('chamfer_borders');
$chamfer['top_logo'] = theme_get_setting('chamfer_top_logo');
$chamfer['top_link'] = theme_get_setting('chamfer_top_link');
$chamfer['bottom_logo'] = theme_get_setting('chamfer_bottom_logo');
$chamfer['bottom_link'] = theme_get_setting('chamfer_bottom_link');
$chamfer['chamfer_color_template'] = theme_get_setting('chamfer_color_template');
$chamfer['color_primary'] = theme_get_setting('chamfer_color_primary');
$chamfer['color_secondary'] = theme_get_setting('chamfer_color_secondary');
$chamfer['color_header1'] = theme_get_setting('chamfer_color_header1');
$chamfer['color_header2'] = theme_get_setting('chamfer_color_header2');
// accessibility issue potentially, commented out
// $chamfer['color_text'] = theme_get_setting('chamfer_color_text');
$chamfer['color_link'] = theme_get_setting('chamfer_color_link');
$chamfer['color_blocks'] = theme_get_setting('chamfer_color_blocks');
$chamfer['color_blockstyle_link'] = theme_get_setting('chamfer_color_blockstyle_link');
$chamfer['color_blockstyle_linkhover'] = theme_get_setting('chamfer_color_blockstyle_linkhover');
$chamfer['color_blockstyle_bgcolor'] = theme_get_setting('chamfer_color_blockstyle_bgcolor');
$chamfer['color_footer_text'] = theme_get_setting('chamfer_color_footer_text');
$chamfer['color_footer_link'] = theme_get_setting('chamfer_color_footer_link');

//setup border
if ($chamfer['borders'] == 0) {
  $border_class = 'main-border-0 ';
}
else {
  $border_class = 'main-border-10 ';
}
//setup top logo
if ($chamfer['top_logo'] == '0') {
  $top_logo = '<img alt="top logo" title="top logo" id="top_logo" src="'. base_path() . path_to_theme() .'/images/top_logo_01.png" style="display:none;"/>';
}
elseif ($chamfer['top_logo'] == '1') {
  if ($chamfer['top_link'] == '') {
    $top_logo = '<img alt="top logo" title="top logo" id="top_logo" src="'. base_path() . path_to_theme() .'/images/top_logo_01.png" />';
  }
  else {
    $top_logo = l('<img alt="top logo" title="top logo" id="top_logo" src="'. base_path() . path_to_theme() .'/images/top_logo_01.png" />',$chamfer['top_link'],array('html' => TRUE,'absolute' => TRUE));
  }
}
else {
  if ($chamfer['top_link'] == '') {
    $top_logo = '<img alt="top logo" title="top logo" id="top_logo" src="'. base_path() . path_to_theme() .'/images/top_logo_02.png" />';
  }
  else {
    $top_logo = l('<img alt="top logo" title="top logo" id="top_logo" src="'. base_path() . path_to_theme() .'/images/top_logo_02.png" />',$chamfer['top_link'],array('html' => TRUE,'absolute' => TRUE));
  }
}
//setup bottom logo
if ($chamfer['bottom_logo'] == '0') {
  $bottom_logo = '<img alt="bottom logo" title="bottom logo" id="bottom_logo" src="'. base_path() . path_to_theme() .'/images/bottom_logo_01.png" style="display:none;"/>';
}
elseif ($chamfer['bottom_logo'] == '1') {
  if ($chamfer['bottom_link'] == '') {
    $bottom_logo = '<img alt="bottom logo" title="bottom logo" id="bottom_logo" src="'. base_path() . path_to_theme() .'/images/bottom_logo_01.png" />';
  }
  else {
    $bottom_logo = l('<img alt="bottom logo" title="bottom logo" id="bottom_logo" src="'. base_path() . path_to_theme() .'/images/bottom_logo_01.png" />',$chamfer['bottom_link'],array('html' => TRUE,'absolute' => TRUE));
  }
}
else {
  if ($chamfer['bottom_link'] == '') {
    $bottom_logo = '<img alt="bottom logo" title="bottom logo" id="bottom_logo" src="'. base_path() . path_to_theme() .'/images/bottom_logo_02.png" />';
  }
  else {
    $bottom_logo = l('<img alt="bottom logo" title="bottom logo" id="bottom_logo" src="'. base_path() . path_to_theme() .'/images/bottom_logo_02.png"/>',$chamfer['bottom_link'],array('html' => TRUE,'absolute' => TRUE));
  }
}
//color selection time, do nothing for default cause it's already correct
if ($chamfer['chamfer_color_template'] != 'default') {
  $settings_style = '<style type="text/css">
  .primary-color {
    background-color:#'. $chamfer['color_primary'] .' !important;
  }
  .secondary-color {
  background-color:#'. $chamfer['color_secondary'] .' !important;
}
.left-col-2 div.block, .left-col-3 div.block, .right-col-3 div.block, .right-col-2 div.block {
  background-color:#'. $chamfer['color_blocks'] .' !important;
}
a {
  color:#'. $chamfer['color_link'] .' !important;
}
h2.title a{
    color:#'. $chamfer['color_header1'] .' !important;
}
h2.sub-title a {
    color:#'. $chamfer['color_header2'] .' !important;
}
.block-minimal-menu a {
   color:#'. $chamfer['color_blockstyle_link'] .' !important;
}
.block-minimal-menu a:hover {
   color:#'. $chamfer['color_blockstyle_linkhover'] .' !important;
}

.block-minimal-menu li .link-wrapper-1:hover{
   background-color:#'. $chamfer['color_blockstyle_bgcolor'] .' !important;
}
.block-minimal-menu li.active-trail .link-wrapper-1{
   background-color:#'. $chamfer['color_blockstyle_bgcolor'] .' !important;
}

.main-border-color {
  border-top-color:#'. $chamfer['color_secondary'] .' !important;
  border-bottom-color:#'. $chamfer['color_secondary'] .' !important;
  border-left-color:#'. $chamfer['color_secondary'] .' !important;
  border-right-color:#'. $chamfer['color_secondary'] .' !important;
}
.footer{
  color:#'. $chamfer['color_footer_text'] .' !important;  
}
.footer a{
  color:#'. $chamfer['color_footer_link'] .' !important;
}
  </style>';
}
else {
  $settings_style = '';
}
//calculate what the spacing / cols should be
if ($left && $right) {
  $cols = 3;
} elseif ($left) {
  $cols = 2;
} elseif ($right) {
  $cols = 2;
} else {
  $cols = 1;
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <title><?php print $head_title ?></title>
    <?php print $head ?>
    <?php print $styles ?>
    <?php print $settings_style?>
    <?php print $scripts ?>
  </head>
  <body<?php print chamfer_body_attributes($is_front, $layout); ?>>
  <div id="border_wrapper" class="wrapper static-color <?php print $border_class?>main-border-color">
    <div class="header secondary-color" >
      <div class="top-header secondary-color">
        <div class="top-header-logo"><?php print $top_logo?></div>
        <div class="titles">
          <h1 class="title"><?php print l($site_name, variable_get('site_frontpage',''));?></h1>
          <h2 class="sub-title"><?php print l($site_slogan, variable_get('site_frontpage',''));?></h2>
        </div>
      </div>
      <div class="btm-header static-color">
        <div class="style-helper">
          <div class="chamfer-1 secondary-color"></div>
          <div class="chamfer-2 secondary-color"></div>
        </div>
        <div class="banner-image-holder">
          <div class="banner-image" <?php if ($logo && !theme_get_setting('default_logo')) { print 'style="background-image:url(' . $logo .')"';} ?>>
            <div class="banner-crop">
            <?php if ($primary_menu || $superfish): ?>
              <!-- Primary || Superfish -->
              <div class="main-menu <?php print $primary_menu ? 'primary' : 'superfish' ; ?>" id="<?php print $primary_menu ? 'primary' : 'superfish' ; ?>">
              <?php if ($primary_menu): print $primary_menu; elseif ($superfish): print $superfish; endif; ?>
              </div>
              <!-- /primary || superfish -->
            <?php endif; ?>
            </div>
          </div>
        </div>
      </div><!-- end btm-header -->
      <?php if ($left) { ?><div class="left-col-<?php print $cols; ?> height"><?php print $left; ?></div><?php } ?>
      <div class="center-col-<?php print $cols; ?> height">
        <?php if ($messages): print $messages; endif; ?>
        <?php if ($help): print $help; endif; ?>
        <?php if ($tabs): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
        <?php print $content_top; ?>
        <?php if ($title): ?><h1 class="title"><?php print $title; ?></h1><?php endif; ?>          
        <?php print $content; ?>
        <?php print $content_bottom; ?>
      </div>
      <?php if ($right) { ?><div class="right-col-<?php print $cols; ?> height"><?php print $right; ?></div><?php } ?>
    </div>
  <div class="push"></div>
  </div>
  <div class="footer secondary-color <?php print $border_class?>main-border-color">
    <div class="footer-padding">
      <?php print $footer_message; ?>
      <div class="btm-logo"><?php print $bottom_logo; ?></div>
    </div>
  </div>
  <?php print $closure ?>
  </body>
</html>
