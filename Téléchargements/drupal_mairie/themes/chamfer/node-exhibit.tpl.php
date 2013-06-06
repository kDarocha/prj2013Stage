<?php // $Id: node.tpl.php,v 1.1 2010/03/10 16:06:51 btopro Exp $
/**
 * @file
 *  node.tpl.php
 *
 * Theme implementation to display a node.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
?>
<div id="node-<?php print $node->nid; ?>" class="exhibit-heading node <?php print $node_classes; ?>">
  <div class="node-inner-0">
  <div class="node-inner-1">
  <div class="node-inner-2">
  <div class="node-inner-3">

<div class="content clearfix">
<div class="media-stream-row media-top" id="media-element-<?php print $node->nid; ?>">
<div class="media-stream-row-inner">
<div class="media-stream-container">
<?php
	if ($terms): ?>
        <h2 class="taxonomy exhibit-title"><?php print strip_tags($terms); ?></h2>
      <?php endif; ?>
  <div class="media-stream-media">
      <div class="add-comment-box-arrow">
      </div>
 	  <div class="node-add-comment-box">
  	  <div class="Acomment">ADD AN EXHIBIT COMMENT</div>
      <div class="comment-add-image">
      </div>
  </div>
  <?php 
  if ($node->comment_count != 0) { ?>
  <div class="node-show-comment-box"><div class="Scomment">SHOW EXHIBIT COMMENTS (<?php print $node->comment_count; ?>)</div><div class="Hcomment">HIDE EXHIBIT COMMENTS (<?php print $node->comment_count; ?>)</div><div class="comment-show-image"></div></div>
  <?php } ?>
  </div><!-- end media-stream-container -->
  
  <div class="media-stream-content">
    <div class="media-stream-content-title"><?php print $title; ?></div>
    <div class="media-stream-content-body">
	   
      <?php if ($unpublished): ?>
        <div class="unpublished"><?php print t('Unpublished'); ?></div>
      <?php endif; ?>

      <?php if (!empty($submitted)): ?>
        <div class="submitted"><?php print $submitted; ?></div>
      <?php endif; ?>
	  <?php print $content; ?>
      <?php
		global $user;
		  if ($node->uid == $user->uid) {
		    print l('Add image to this exhibit','node/add/exhibit-image',array('query' => 'destination=node/'. $node->nid .'&edit[field_exhibit_reference][nid][nid]='. $node->nid,'attributes' => array('class' => 'add-image-link')));
		  }
		?>
      </div>
  </div>
  </div><!-- end media-stream-row-inner -->
</div><!-- end media-stream-row -->
        
      </div>

    </div></div>
  </div></div>
</div> <!-- /node -->
</div>