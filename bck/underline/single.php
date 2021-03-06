<?php get_header(); ?>		

	<main id="main" class="site-body" role="main" itemscope="itemscope" itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">    
		<div class="wrap">   
			<section id="content">
				<?php if ( have_posts() ) : ?>
					<?php if ( function_exists( 'underline_breadcrumbs' ) ) underline_breadcrumbs(); ?>
					<?php if ( function_exists( 'underline_archive_meta' ) ) underline_archive_meta(); ?>
					
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				<?php endif; ?>
				
				<?php if ( is_single() ): ?>
					<?php // Post's author information ?>
					<?php underline_author_box();?>
					
					<?php // Widget area beneath every post ?>
					<?php if ( is_active_sidebar( 'post-sidebar' ) ) : ?>
						<aside id="post-sidebar" class="post-sidebar widget_area clearfix" role="complementary">
            <?php dynamic_sidebar( 'post-sidebar' ); ?>
            </aside>
					<?php endif; ?> 
			  <?php endif; ?>

        <?php // Next/prev posts ?>
				<?php underline_post_nav(); ?>

        <?php // Display comment section ?>
				<?php comments_template(); ?>

			</section><!-- #content -->
			
			<?php get_sidebar(); ?>
			<a href="#top" class="a-jump-to-top" title="<?php _e( 'Jump to top', 'underline' ); ?>"></a>
		</div>
		
	</main><!-- #main -->

<?php get_footer(); ?>