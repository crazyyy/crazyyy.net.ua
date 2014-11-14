<?php if ( is_home() ) : ?>
  <div class="notice">
    <p><?php _e( 'No posts found.', 'underline' ); ?></p>
  </div>
<?php elseif ( is_search() ) : ?>
  <div class="notice">
    <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'underline' ); ?></p>
  </div>
  <p><?php get_search_form(); ?></p>
<?php else : ?>
  <div class="notice">
    <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'underline' ); ?></p>
    <p><?php get_search_form(); ?></p>
  </div>
<?php endif; ?>
