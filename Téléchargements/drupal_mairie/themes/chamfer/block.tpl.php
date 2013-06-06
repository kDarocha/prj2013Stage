<?php // $Id: block.tpl.php,v 1.2 2010/05/27 18:57:51 btopro Exp $
/**
 * @file
 *  block.tpl.php
 *
 * Theme implementation to display a block.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 */
 $specialblocks = theme_get_setting('chamfer_color_specialblock');
 if ($specialblocks == '') {
	$specialblocks = array(); 
 }
 if (in_array($block->bid,$specialblocks)) {
	$block_style_class = ' block-minimal-menu'; 
 }
 else {
	$block_style_class = ''; 
 }
?>
<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block <?php print $block_classes . $block_style_class; ?>">
  <div class="block-inner">
  <?php if ($block->subject): ?>
    <h2 class="block-title"><?php print $block->subject; ?></h2>
  <?php endif; ?>
    <div class="block-content">
      <div class="block-content-inner">
        <?php print $block->content; ?>
      </div>
    </div>
  </div>
</div> <!-- /block -->