<?php get_header(); ?>		

	<main id="main" class="site-body" role="main" itemscope="itemscope" itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">    
		<div class="wrap">   
			<section id="content">
				<?php if ( have_posts() ) : ?>
			<?php if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<p id="breadcrumbs">','</p>');
			} ?>
					<?php if ( function_exists( 'underline_archive_meta' ) ) underline_archive_meta(); ?>
					
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
						<!-- noindex -->
						<div class="dllinks">
							<ul class="clearfix">
								<li><a target="_blank" rel="nofollow" href="http://adf.ly/ZTBoL">Сервер Москва</a></li>
								<li><a target="_blank" rel="nofollow" href="http://adf.ly/ZTBvT">Сервер Киев</a></li>
								<li><a target="_blank" rel="nofollow" href="http://adf.ly/ZTC5K">Сервер Минск</a></li>
							</ul>
						</div>
						<!-- / noindex -->
					<?php endwhile; ?>
				<?php endif; ?>
				
				<?php if ( is_single() ): ?>
					
					<?php // Widget area beneath every post ?>
					<?php if ( is_active_sidebar( 'post-sidebar' ) ) : ?>
						<aside id="post-sidebar" class="post-sidebar widget_area clearfix" role="complementary">
			            <?php dynamic_sidebar( 'post-sidebar' ); ?>
			            </aside>
					<?php endif; ?> 
			  <?php endif; ?>
			        <?php // Display comment section ?>
				<?php comments_template(); ?>
				
			        <?php // Next/prev posts ?>
				<?php underline_post_nav(); ?>
			
			
			</section><!-- #content -->
			
			<?php get_sidebar(); ?>
			<a href="#top" class="a-jump-to-top" title="<?php _e( 'Jump to top', 'underline' ); ?>"></a>
		</div>
		
	</main><!-- #main -->

<?php get_footer(); ?>