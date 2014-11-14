<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">
  <header class="entry-header">
    <h1 class="entry-title" title="<?php the_title(); ?>" itemprop="name"><?php the_title(); ?></h1>

    <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
    <div class="entry-thumbnail">
      <?php the_post_thumbnail('large'); ?>
    </div>
    <?php endif; ?>
  </header><!-- .entry-header -->
  
  <div class="entry-content clearfix" itemprop="articleBody">
    <?php the_content(__( 'Read more', 'underline' )); ?>
    <?php underline_wp_link_pages(); ?>
  </div><!-- .entry-content -->
  
  <footer class="entry-footer">
  </footer><!-- .entry-footer -->
</article><!-- .post -->