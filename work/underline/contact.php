<?php
/**
 * Template Name: Contact Page Template
 *
 * Description: A page template that provides a contact form in which visitors can send out an email to you
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
            <?php get_template_part( 'content', 'contact' ); ?>
            <?php underline_send_message(); ?>
            <form id="contact-form" class="contact-form" action="" method="POST">
              <p>
                <label for="mail-email" class="form-label"><?php _e( 'Email', 'underline' ); ?><span class="required">*</span></label>
                <input id="mail-email" name="mail[email]" type="text" value="" size="30" aria-required="true">
              </p>

              <p>
                <label for="mail-subject" class="form-label"><?php _e( 'Subject', 'underline' ); ?> <span class="required">*</span></label>
                <input id="mail-subject" name="mail[subject]" type="text" value="" size="30" aria-required="true">
              </p>

              <p>
                <label for="mail-message" class="form-label"><?php _e( 'Message', 'underline' ); ?> <span class="required">*</span></label> 
                <textarea id="mail-message" name="mail[message]" cols="45" rows="8" aria-required="true"></textarea>
              </p>

              <p>
                <input id="mail-checker" name="mail[checker]" type="checkbox" >
                <label for="mail-checker"><?php _e( "I'm a human.", 'underline' ); ?></label>
              </p>

              <p>
                <input type="hidden" name="underline_contact_nonce" value="<?php echo wp_create_nonce( 'underline-send-message' ); ?>">
                <input name="submit" type="submit" id="contact-submit" class="button" value="<?php _e( 'Send message', 'underline' ); ?>">
              </p>
            </form>
          <?php endwhile; ?>
        <?php endif; ?>

        <?php comments_template(); ?>

      </section><!-- #content -->
      
      <?php get_sidebar(); ?>
      <a href="#top" class="a-jump-to-top" title="<?php _e( 'Jump to top', 'underline' ); ?>"></a>
    </div>
    
  </main><!-- #main -->

<?php get_footer(); ?>