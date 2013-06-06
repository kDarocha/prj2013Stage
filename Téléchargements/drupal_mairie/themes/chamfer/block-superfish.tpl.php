<?php // $Id: block-superfish.tpl.php,v 1.1 2010/03/10 16:06:51 btopro Exp $
/**
 * @file
 *  block.tpl.php
 *
 * Theme implementation to display the Superfish menu block.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 */
?>
<?php print str_replace('class="menu"','class="sf-menu"',$block->content); ?>