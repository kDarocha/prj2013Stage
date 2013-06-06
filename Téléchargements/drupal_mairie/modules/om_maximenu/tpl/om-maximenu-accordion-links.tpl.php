<?php
/**
 * @file om_maximenu_accordion_links.tpl.php
 * Default theme implementation of om maximenu links with accordion blocks
 *
 * Available variables:
 * - $om_accordion_dt: rendered dt with attributes
 * - $content: array, used for link classes and content
 *
 * Helper variables:
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $key: numeric link order id
 * - $id: automatic id given based on order of appearance.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $user: (object) user properties
 * - $permission: TRUE/FALSE
 *
 * @see template_preprocess_om_maximenu_accordion()
 * @see template_preprocess_om_maximenu_accordion_links()
 * @see template_preprocess_om_maximenu_accordion_content() 
 *
 */
?>  

<?php if (!empty($permission)): ?>   
  <?php print $om_accordion_dt; ?>
  <dd><?php print theme('om_maximenu_accordion_content', $content['content'], $maximenu_name, $key); ?></dd> 
<?php endif; ?>  
