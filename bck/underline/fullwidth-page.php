<?php
/**
 * Template Name: Fullwidth Page Template
 *
 * Description: A fullwidth page type
 *
 * @package WordPress
 * @subpackage Underline
 * @since Underline 1.0.0
 */
?>

<?php get_header(); ?>    

      <main id="main" class="site-body" role="main" itemscope="itemscope" itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">    
        <div class="wrap">   
          <section id="content">
            <?php if ( have_posts() ) : ?>
              <?php if ( function_exists( 'underline_breadcrumbs' ) ) underline_breadcrumbs(); ?>
              <?php if ( function_exists( 'underline_archive_meta' ) ) underline_archive_meta(); ?>
              
              <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'content', 'fullwidth' ); ?>
              <?php endwhile; ?>
            <?php endif; ?>

            <?php comments_template(); ?>

          </section><!-- #content -->
          
          <a href="#top" class="a-jump-to-top" title="<?php _e( 'Jump to top', 'underline' ); ?>"></a>
        </div>
        
      </main><!-- #main -->

<?php get_footer(); ?>
