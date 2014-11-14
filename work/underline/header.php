<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<meta name="viewport" content="width=device-width">		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
		<div id="page">
			<header id="header" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
				<div class="wrap">
					<div class="title-area">
						<h5 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
						</h5>
            <h4 class="site-description"><?php bloginfo( 'description' ); ?></h4>
            <p><a class="a-show-menu nav-icon" title="Toggle menu" href="#"></a></p>
					</div> 

          <?php if ( has_nav_menu( 'primary' ) ) : ?>

					<?php 
            // Main navigation
						wp_nav_menu( array( 
              'theme_location' => 'primary', 
              'container' => '',
              'menu_class' => 'nav-menu clearfix',
              'items_wrap' => '<nav id="main-navigation" class="main-navigation" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
              'walker' => new Underline_Walker_Sub_Menu 
            ) ); 

            // Mobile menu
            wp_nav_menu( array( 
              'theme_location' => 'primary', 
              'container' => '',
              'menu_class' => 'nav-menu clearfix',
              'items_wrap' => '<nav id="mobile-navigation" class="mobile-navigation" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"><ul id="%1$s" class="%2$s">%3$s</ul></nav>'
            ) ); 
          ?>          
          <?php endif; ?>

				</div>
			</header><!-- #header -->
