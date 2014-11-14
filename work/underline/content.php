<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
		<h1 class="entry-title" title="<?php the_title(); ?>" itemprop="name"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark" itemprop="name"><?php the_title(); ?></a>
		</h1>
		<?php endif; ?>
		
		<?php if ( ! is_page() ) : ?>
		<p class="entry-meta"><?php _e( 'Posted on', 'underline' ); ?> <a href="#" title="<?php echo get_the_date('H:i a'); ?>"><time class="entry-date updated" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date( 'M j, Y' ); ?></time></a> <?php _e( 'by', 'underline' ); ?> <span itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php printf( __( "View all posts by %s", 'underline' ), get_the_author_meta( 'display_name' ) ); ?>" rel="author" itemprop="name"><?php the_author_meta( 'display_name' ); ?></a></span>
		</p>
	  <?php endif; ?>

	

		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>
	</header><!-- .entry-header -->
	
	<div class="entry-content clearfix" itemprop="articleBody">
		<?php if ( is_singular() ) : ?>
      <?php the_content(); ?>
	  <?php else : ?>
      <?php the_excerpt(); ?>
      <p><a href="<?php the_permalink(); ?>" class="button"><?php _e( 'Read more', 'underline' ); ?></a></p>
    <?php endif; ?>
		

		
		<?php underline_wp_link_pages(); ?>
	</div><!-- .entry-content -->
	
	<footer class="entry-footer">
		<?php if ( is_single() ) the_tags( '<p>' . __( 'Tags', 'underline' ) . ': ', ', ', '</p>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- .post -->