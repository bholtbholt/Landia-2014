<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- 
        ,@@@@@...
     ,@@@@@@@@@@@@@@..
   ,@@@@~'        `~@@@.
  @@@@                `~
 @@@@@        (_O
@@@@@@@.       /\
@@@@@@@@@..   |\_,-'   
@@@@@@@@@@@@@='~
@@@@@@@@@@@@@@@@@@@@@@@==......__
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@=...__
@@@@@@@@ SITE BY BRIANHOLT.CA @@@@@@@@@=...__
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@=...__
-->
	<title><?php echo get_bloginfo('name'); wp_title(' | '); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
	<?php wp_head();
		$linkColor = substr(esc_html( get_post_meta( get_page_by_title('Contact')->ID, 'bg_color', true ) ), 0, -3);
		if (is_archive()) {
			$top_bg_color = 'white-bg';
		} else {
			$top_bg_color = esc_html( get_post_meta(get_the_ID(), 'bg_color', true) );
		} ?>
</head>
<body class="<?php echo $linkColor ?>-link">

<nav id="main-nav" class="<?php echo $top_bg_color; ?>">
	<div class="container">
		<button type="button" class="btn btn-primary visible-xs" data-toggle="collapse" data-target="#header-menu-div">MENU</button>
	  <div id="header-menu-div" class="collapse">
	    <?php wp_nav_menu( array( 'theme_location' => 'header-menu',
	                              'container' => '',
	                              'menu_id' => 'header-menu'
	    ) ); ?>
	  </div>
	</div>
</nav>

<nav id="side-nav" class="hidden-xs">
	<div id="toggle-side-nav"><span class="glyphicon glyphicon-cog"></span></div>
	<?php wp_nav_menu( array( 'theme_location' => 'side-menu',
                            'container' => '',
                            'menu_id' => 'side-menu'
		    ) ); ?>
</nav>