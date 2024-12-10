<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
	
</head>

<body <?php body_class(); ?>>
	<div class="header-top">
			<div class="wrap">
				<h1><a href="<?php bloginfo('url'); ?>" title="Nghe Nhạc Trực Tuyến" class="logo">Nghe Nhạc Trực Tuyến</a></h1>
				<form action="<?php bloginfo('url'); ?>" method="get" id="search-form">
					<input type="text" name="s" id="s" placeholder="Nhập từ khóa cần tìm ....">
					<input type="submit" id="search-sb" value="">
				</form><!--search form-->
				<div class="login-box">
					<a href="/login">Đăng nhập</a> |
					<a href="/wp-signup.php">Đăng ký</a>
				</div>
			</div>
		</div><!--end hedaer-top-->
		<div class="header-menu">
			<div class="wrap">
				<div id='h-menu'>
					<?php 
						wp_nav_menu(array("menu" => "header menu", "container" => ""));
					?>
				</div>
			</div>
		</div><!--end header menu-->
		<div class="content-wrap">
			<div class="wrap">

