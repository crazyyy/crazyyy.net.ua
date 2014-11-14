<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">
  <header class="entry-header">
    <?php if ( is_singular() ) : ?>
    <h1 class="entry-title" title="<?php the_title(); ?>" itemprop="name"><?php the_title(); ?></h1>
    <?php else : ?>
    <h1 class="entry-title">
      <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark" itemprop="name"><?php the_title(); ?></a>
    </h1>
    <?php endif; ?>

    <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
    <div class="entry-thumbnail">
      <?php the_post_thumbnail(); ?>
    </div>
    <?php endif; ?>
  </header><!-- .entry-header -->
  
  <div class="entry-content clearfix" itemprop="articleBody">
    <?php the_content(__( 'Read more', 'underline')); ?>
    <?php wp_link_pages(); ?>
  </div><!-- .entry-content -->
  
  <footer class="entry-footer">
    <?php the_tags( '<p>' . __( 'Tags', 'underline' ) . ': ', ', ', '</p>' ); ?>
  </footer><!-- .entry-footer -->
</article><!-- .post -->