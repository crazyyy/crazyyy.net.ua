<?php
if ( ! class_exists( 'Underline_Random_Posts' ) ) : 
/**
 * Underline Random Posts widget class
 *
 * @since 1.0.0
 */
class Underline_Random_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'widget_random_posts', 
			'description' => __( 'A list of random posts', 'underline' ) 
		);
		parent::__construct( 
			'underline-random-posts', 
			__( 'Underline Random Posts', 'underline' ), 
			$widget_ops
		);
	}

	function widget( $args, $instance ) {
		global $post;

		extract($args);
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$showposts = $instance['showposts'];

		echo $before_widget;
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;
    
		$posts = new WP_Query( array(
			'post_type' => 'post',
			'ignore_sticky_posts' => 1,
      'post__not_in' => array( $post->ID ),
      'posts_per_page' => $showposts,
      'orderby' => 'rand'
		) );
		?>

		<?php if ( $posts->have_posts() ) : ?>
		<ul>
			<?php while ( $posts->have_posts() ) : $posts->the_post() ; ?>
			<li><a href="<?php the_permalink(); ?>" title="<?php echo __( 'Permalink to ', 'underline' ) . get_the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
		</ul>
		<?php wp_reset_postdata(); endif; ?>
		<?php

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => __( 'Random Posts', 'underline' ),
			'showposts' => 5 
		) );

		$title = $instance['title'];
		$showposts = $instance['showposts'];
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Show posts <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('showposts'); ?>">Show posts <input class="widefat" id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="text" value="<?php echo esc_attr($showposts); ?>" /></label></p>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) )
			$instance['title'] = $new_instance['title'];
		if ( ! empty( $new_instance['showposts'] ) )
			$instance['showposts'] = $new_instance['showposts'];

		return $instance;
	}

}
endif;


if ( ! class_exists( 'Underline_Related_Posts' ) ) : 
/**
 * Underline Related Posts widget class
 *
 * @since 1.0.0
 */
class Underline_Related_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'widget_related_posts', 
			'description' => __( "A list of the current post's related posts", 'underline' ) 
		);
		parent::__construct( 
			'underline-related-posts', 
			__( 'Underline Related Posts', 'underline' ), 
			$widget_ops
		);
	}

	function widget( $args, $instance ) {
		global $post;

		if ( ! is_single() )
			return;

		extract($args);
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$showposts = $instance['showposts'];

		echo $before_widget;
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;
    
    $cat_objects = wp_get_object_terms( $post->ID, 'category' );
    $cat_length = count( $cat_objects );
    foreach ( $cat_objects as $cat ) {
    	$cat = (array) $cat;
    	$cat_lists[] = $cat['term_id'];
    }

    $tag_objects = wp_get_object_terms( $post->ID, 'post_tag' );
    $tag_length = count( $tag_objects );
    foreach ( $tag_objects as $tag ) {
    	$tag = (array) $tag;
    	$tag_lists[] = $tag['term_id'];
    }
    
    $args = array(
      'post_type' => 'post',
      'ignore_sticky_posts' => 1,
      'post__not_in' => array( $post->ID ),
      'posts_per_page' => $showposts,
      'orderby' => 'rand',
      'tax_query' => array(
        'relation' => 'OR',
        array(
          'taxonomy' => 'category',
          'terms' => $cat_lists
        ),
        array(
        	'taxonomy' => 'post_tag',
        	'terms' => $tag_lists
        )
      )
    );

		$posts = new WP_Query( $args );
		?>

		<?php if ( $posts->have_posts() ) : ?>
		<ul>
			<?php while ( $posts->have_posts() ) : $posts->the_post() ; ?>
			<li><a href="<?php the_permalink(); ?>" title="<?php echo __( 'Permalink to ', 'underline' ) . get_the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
		</ul>
		<?php wp_reset_postdata(); endif; ?>
		<?php

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => __( 'Related Posts', 'underline' ),
			'showposts' => 5 
		) );

		$title = $instance['title'];
		$showposts = $instance['showposts'];
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Show posts <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('showposts'); ?>">Show posts <input class="widefat" id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="text" value="<?php echo esc_attr($showposts); ?>" /></label></p>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) )
			$instance['title'] = $new_instance['title'];
		if ( ! empty( $new_instance['showposts'] ) )
			$instance['showposts'] = $new_instance['showposts'];

		return $instance;
	}

}
endif;
