<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script type="text/javascript">  
    Cufon.replace('#sidebar-first .testimonials .block');
</script>
<!--[if IE 6]>
        <script type="text/javascript" src="<?php print $base_path . $directory; ?>/js/jquery.pngFix.js"></script>
<![endif]-->
<!--[if IE 6]>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(document).pngFix();
    });
</script>
<![endif]-->
<style>#primary-menu {
    float: right;
    margin-right: 10px;
    margin-top: 7px;
    min-width: 663px;
    text-align: right;
}
#primary-menu-inner{
 float: right;
 margin: 0;
}
#primary-menu-inner ul{
 float: right;
    margin: 0;
	list-style:none;
	padding: 0 0 0 2em;
	margin: 28px 0 0;
	}
	</style>
	<script type="text/javascript">
$(document).ready(function() {
  $('#slid_show .slideshow').cycle({
    fx:     'fade', 
   speed:  200, 
   timeout: 5000
  });
    
});
</script>
</head>
<body class="<?php print $classes; ?>">
  <div id="page-wrapper"><div id="page">
    <div id="header"><div class="section clearfix"><div id="header-inner">

      <?php if ($logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
      <?php endif; ?>

      <?php if ($site_name || $site_slogan): ?>
        <div id="name-and-slogan">
          <?php if ($site_name): ?>
            <?php if ($title): ?>
              <div id="site-name"><strong>
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
              </strong></div>
            <?php else:?>
              <h1 id="site-name">
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
              </h1>
            <?php endif; ?>
          <?php endif; ?>
         
		  <?php if ($site_slogan): ?>
            <div id="site-slogan"><?php print $site_slogan; ?></div> 
			<?php endif; ?>
	 </div><!-- /#name-and-slogan -->
      <?php endif; ?>

      <?php if ($search_box): ?>
        <div id="search-box"><?php print $search_box; ?></div>
      <?php endif; ?>
 <?php 
print icebusiness_header_menu($primary_links_tree, 'primary-menu'); 
?> 

<?php print $header; ?>
<?php if ($primary_links): ?>

 <?php endif; ?>

 <?php if ($header_menu): ?>
 <div id="header_top_menu"><?php print $header_menu; ?></div>
 <?php endif; ?>

    </div></div></div><!-- /.section, /#header -->
 <!-- error -->
  <?php if ($navigation): ?>
        <div id="navigation"><div class="section clearfix">
		         <?php print $navigation; ?>
        </div></div><!-- /.section, /#navigation -->
      <?php endif; ?>
      <!-- *********** #slider ************ -->
	   
	   <div id="slider"><?php if ($slider): ?><?php print $slider; ?> <?php endif; ?> 

	 <div id="slid_show">
	    <div class="content">
        <div class="slideshow">

    <img alt="slide1" title="slide1" width="914" src="/sites/all/themes/icebusiness/images/slider_img/cms-customization.jpg?" />
    <img alt="slide2" title="slide2"  width="914"src="/sites/all/themes/icebusiness/images/slider_img/search-engine-optimization.jpg?" />
<img alt="slide3" title="slide3" width="914" src="/sites/all/themes/icebusiness/images/slider_img/web-application-development.jpg?" />
           </div>    
            </div> 
	   </div></div>
	  
	   <!-- *********** End #slider ************ -->

 <?php if ($tab_boxes): ?>
 <div id="tabs-wrp"> <div class="tabs-bg"><?php print $tab_boxes; ?></div></div>
 <?php endif; ?>

   <div id="main-wrapper"><div id="main" class="clearfix<?php if ($primary_links || $navigation) { print ' with-navigation'; } ?>">

      <div id="content" class="column"><div class="section">

        <?php if ($mission): ?>
          <div id="mission"><?php print $mission; ?></div>
        <?php endif; ?>
        <?php if ($highlight): ?>
         <div id="highlight-wrp"><?php print $highlight; ?></div>        
        <?php endif; ?>
        <?php print $breadcrumb; ?>
        <?php if ($title): ?>
          <h1 class="title"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php print $messages; ?>
        <?php if ($tabs): ?>
          <div class="tabs"><?php print $tabs; ?></div>
        <?php endif; ?>
        <?php print $help; ?>

        <?php print $content_top; ?>

        <div id="content-area">
          <?php print $content; ?>
        </div>
<!--  error -->
        <?php print $content_bottom; ?>

        <?php if ($feed_icons): ?>
          <div class="feed-icons"><?php print $feed_icons; ?></div>
        <?php endif; ?>

      </div></div><!-- /.section, /#content -->
<div style="display:none;">Designed and developed By <a href="http://www.drupalnetworks.com/">DrupalNetworks.com</a>. Drupal Networks is a division of <a href="http://www.yasglobal.com/">YAS Global</a>.</div>
    
       <?php if ($sidebar_first || $testimonials || $right_sidee_block ): ?>
	   <div id="sidebar-first">
      <?php print $sidebar_first; ?>
	    <?php if ($testimonials): ?>
          <div class="testimonials"><?php print $testimonials; ?></div>
        <?php endif; ?>
         <?php if ($right_sidee_block): ?>
          <div class="right_sidee_block"><?php print $right_sidee_block; ?></div>
        <?php endif; ?>
       </div>
		  <?php endif; ?>
      <?php print $sidebar_second; ?>

    </div></div><!-- /#main, /#main-wrapper -->



  </div></div><!-- /#page, /#page-wrapper -->
  <!-- ****************************************** -->

<div id="footer">
<div class="section">
	<div id="footer-message"><?php print $footer_message; ?></div>
	<?php if($user_1): ?>
		<div class="user_1"><?php print $user_1; ?></div>
	<?php endif; ?>
	<?php if($user_2): ?>
		<div class="user_2"><?php print $user_2; ?>	</div>		
	<?php endif; ?>
	
		<div class="user_3"><?php if ($user_3): ?><?php print $user_3; ?>	<?php endif; ?>		
		 <h2>Recent Work</h2>
		<div><img src="sites/all/themes/icebusiness/images/recent-work.jpg" alt="Our Recent Work" /></div> 
		</div>
	


	
		<div class="user_4"><?php if ($user_4): ?><?php print $user_4; ?>	<?php endif; ?>
	<div class="region-user-4" style=" max-width: 150px;">
	<h2>Social Network</h2><a href="#" style="float: left; margin-top:16px;"><img src="sites/all/themes/icebusiness/images/social-networking/facebook.png" title="Facebook"></a>
<a href="#"><img src="sites/all/themes/icebusiness/images/social-networking/twitter.png" title="Twitter"></a>
<a href="#"><img src="sites/all/themes/icebusiness/images/social-networking/LinkedIn.png" title="LinkedIn"></a>
<a href="#"><img src="sites/all/themes/icebusiness/images/social-networking/blogger.png" title="Blog"></a></div>	
		 </div>

	<?php if ($footer): ?>
	<div class="copy_right"><?php print $footer; ?></div>
<?php endif; ?>
</div></div><!-- /.section, /#footer -->

<!-- *************************** -->
  <?php print $page_closure; ?>
  <?php print $closure; ?>
</body>
</html>
