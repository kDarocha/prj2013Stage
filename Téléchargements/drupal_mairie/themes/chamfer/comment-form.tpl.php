<?php
// $Id: comment-form.tpl.php
/**
 * @file comment-form.tpl.php
*/
?>
<div class="comment-form clearfix">
  <?php print str_replace('Comment:','Your Comment:',str_replace('<div class="form-item">','<div class="form-item" style="display:none">',drupal_render($form))); ?>
  <?php print $submit; ?>
</div>
