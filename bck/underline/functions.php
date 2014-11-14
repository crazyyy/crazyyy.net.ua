<?php
if ( ! isset( $content_width ) ) $content_width = 900;

// Disable XMLRPC
add_filter('xmlrpc_enabled', '__return_false');

require_once( get_template_directory() . '/inc/widgets.php' );

function underline_setup() {

	load_theme_textdomain( 'underline', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'underline' ) );

	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'F8F8F8',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 300, true ); // Unlimited height, hard crop
}
add_action( 'after_setup_theme', 'underline_setup' );

function underline_frontend_scripts_styles() {
	global $wp_styles;

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	
		wp_enqueue_style( 'underline-style', get_stylesheet_directory_uri() . '/css/main.min.css' );
    wp_enqueue_script( 'underline-js', get_stylesheet_directory_uri() . '/js/main.min.js', array(), '12112013', true);		
}
add_action( 'wp_enqueue_scripts', 'underline_frontend_scripts_styles' );

// Widget 
if ( ! function_exists( 'underline_widgets_init' ) ) : 
add_action( 'widgets_init', 'underline_widgets_init' );
function underline_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'underline' ),
		'id'            => 'main-sidebar',
		'description'   => __( 'Appears in the left/right section of the site.', 'underline' ),
		'before_widget' => '<section id="%1$s" class="widget clearfix %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
    
  register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'underline' ),
		'id'            => 'footer-sidebar',
		'description'   => __( 'Appears in the bottom section of the site.', 'underline' ),
		'before_widget' => '<section id="%1$s" class="widget one_third %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Post Widget Area', 'underline' ),
		'id'            => 'post-sidebar',
		'description'   => __( "Appears beneath every single post, righ after the post's author information box", 'underline' ),
		'before_widget' => '<section id="%1$s" class="widget one_half %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_widget( 'Underline_Random_Posts' );
	register_widget( 'Underline_Related_Posts' );
}
endif; 

if ( ! function_exists( 'underline_number_paging_nav' ) ) :
function underline_number_paging_nav(
	$head = '<nav class="navigation paging-navigation clearfix" role="navigation">', 
	$before_child = '', 
	$after_child = '', 
	$tail = '</nav><!-- .navigation -->'
) {

	global $wp_query, $paged;

	$max_pages = intval($wp_query->max_num_pages);

	// Don't print empty markup if there's only one page.
	if ( $max_pages < 2 )
		return;

	if ( ! $paged )
		$paged = (int) 1;
	
	// Main paging numbers to show in total
	$total_pages = apply_filters( 'underline_paging_nav_numbers', 5 );
	// Adjacent paging of current page
	$adjacent_pages = intval( ($total_pages - 1)/2 );
	
	// Get paging range to show
	if ( $adjacent_pages >= $paged ) {
		$from = 1;
		$to = min( $total_pages, $max_pages );
	} elseif ( $adjacent_pages > ( $max_pages - $paged ) ) {
		$from = max( $max_pages - $total_pages, 1 ); 
		$to = $max_pages;
	} else {
		$from = $paged - $adjacent_pages;
		$to = $paged + $adjacent_pages;
	}
	
	$far_next = ceil($to / 10)*10;
	
	$far_prev = ceil($from / 10)*10;
	?>

	<?php echo $head; ?>
		<?php // Display First button ?>
		<?php if ( $from > 1 ) : ?>
			<?php echo $before_child; ?>
			<a class="button" href="<?php echo get_pagenum_link(1); ?>">&#171; <?php _e( 'First', 'underline' ); ?></a>
			<?php echo $after_child; ?>
		<?php endif; ?>
		
		<?php // Display Previous button ?>
		<?php if ( $paged > 1 ) : ?>
			<?php echo $before_child; ?>
			<a class="button prev" href="<?php previous_posts($max_pages, 1); ?>" rel="prev">&#171;</a>
			<?php echo $after_child; ?>
		<?php endif; ?>
		
		<?php // Display Page button range ?>
		<?php for ( $i = $from; $i <= $to; $i++ ) : ?>
			<?php echo $before_child; ?>
			<?php $rel = ( $paged === $i - 1 ) ? 'rel="next"' : ( ( $paged === $i + 1 ) ? 'rel="prev"' : "") ; ?>
	    <a class="button <?php echo ( $paged === $i ) ? 'active':''; ?>" href="<?php echo get_pagenum_link($i); ?>" <?php echo $rel; ?>><?php echo $i; ?></a>
	    <?php echo $after_child; ?>
		<?php endfor; ?>

		<?php // Display Next button ?>
	    <?php if ( $paged < $max_pages ) : ?>
	    <?php echo $before_child; ?>
	    	<a class="button next" href="<?php next_posts($max_pages, 1); ?>" rel="next">&#187;</a>
	    <?php echo $after_child; ?>
		<?php endif; ?>
		
		<?php // Display Last button ?>
		<?php if ( $to < $max_pages ) : ?>
			<?php echo $before_child; ?>
			<a class="button" href="<?php echo get_pagenum_link($max_pages); ?>"><?php _e( 'Last', 'underline' ); ?> &#187;</a>
			<?php echo $after_child; ?>
		<?php endif; ?>
		
		<?php echo $tail; ?>
	<?php
}
endif;

if ( ! function_exists( 'underline_next_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @see twentythirteen_paging_nav()
 * @since Underline 1.0
 *
 * @return void
 */
function underline_next_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation clearfix" role="navigation">
		<div class="nav-links">
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'underline' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'underline' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'underline_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @see underline_paging_nav()
 * @since Underline 1.0
 *
 * @return void
 */
function underline_paging_nav() {
	if ( function_exists( 'wp_pagenavi' ) ) {
    wp_pagenavi();
    return;
	}

	$style = apply_filters( 'underline_paging_nav', 'number' );

	if ( in_array( $style, array( 'number', 'next' ) ) ) {
		call_user_func( "underline_{$style}_paging_nav" );
	}
}
endif;


if ( ! function_exists( 'underline_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since Underline 1.0
*
* @return void
*/
function underline_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation paging-navigation clearfix" role="navigation">
		<?php previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'underline' ) ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'underline' ) ); ?>
  </nav><!-- .paging-navigation -->
	<?php
}
endif;	

if ( ! function_exists( 'underline_wp_link_pages' ) ) :

function underline_wp_link_pages() {
  if ( function_exists( 'wp_pagenavi' ) ) {
  	wp_pagenavi( array( 'type' => 'multipart' ) );
  	return;
  }

  wp_link_pages('next_or_number=number');
}

endif;

// Tweak read more button
function underline_more_link( $link ) {
	$link = str_replace( 'more-link', 'button', $link );
	return '</p><p>' . $link;
}
add_filter( 'the_content_more_link', 'underline_more_link' );


/**
 * Breacrumbs
 *
 * Compatible with Breadcrumbs NavXT, Wordpress SEO Yoast
 *
 * @since Underline 1.0
 *
 * @return void
 */

if ( ! function_exists( 'underline_breadcrumbs' ) ) :

function underline_breadcrumbs() {

  // Use Breadcrumbs NavXT if it has been using
  if ( function_exists( 'bcn_display' ) ) {
    echo '<nav class="breadcrumbs" role="navigation">';
    bcn_display();
    echo '</nav>';
    return;
  }

  // If not, use Wordpress SEO Yoast's breadcrumbs
  if ( function_exists('yoast_breadcrumb') ) {
    $breadcrumb = yoast_breadcrumb( '', '', false );
    
    if ( count(explode( 'v:Breadcrumb', $breadcrumb )) < 3 && ! is_paged() && ! apply_filters( 'underline-display-home-link', false ) )
    	return;
    
    $breadcrumb = '<nav class="breadcrumbs" role="navigation">' . $breadcrumb . '</nav>';

    echo $breadcrumb;
    return;
  }
	
	// Otherwise, use the default

	// Only display breadcrumbs for post and category page
	if ( ! is_single() && ! is_category() )
		return; 

	global $post;
	$categories = wp_get_post_categories( $post->ID );
	
	// Return if the post doesn't belong to any category
	if ( ! $categories || ! is_array( $categories ) )
		return;

	// Store chained of categories
	$cats = array();
  
	if ( is_single() ) {
		// Currently only get the first category
		$cat_ID = $categories[0];
		$cat = get_category($cat_ID);
		$cats[] = $cat;
		$current_text = get_the_title();
	}	else {
		// Get current category ID
		$cat_ID = get_category( get_query_var( 'cat' ) );
		$cat = get_category($cat_ID);
		$current_text = $cat->name;
	}

	while ( $cat->parent ) {
		$cat = get_category($cat->parent);
		$cats[] = $cat;
	}
?>
	<nav class="breadcrumbs" role="navigation">
		<ol class="list">
			<li class="breadcrumb" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">
				<a href="<?php echo home_url(); ?>" rel="home" title="<?php echo get_bloginfo( 'title' ); ?>" itemprop="url"><span itemprop="title"><?php _e( 'Home', 'underline' ); ?></span></a> 
			</li>
			
			<?php while ( count( $cats ) ) : $cat = array_pop( $cats ) ; ?>
			<span class="sep">&raquo;</span> 
			<li class="breadcrumb" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">
				<a href="<?php echo get_category_link( $cat->term_id ); ?>" rel="tag" title="<?php printf( "%s category", $cat->name ); ?>" itemprop="url"><span itemprop="title"><?php echo $cat->name; ?></span></a>
			</li>
			<?php endwhile; ?>
			
			<span class="sep">&raquo;</span>
			<li class="breadcrumb"><strong><?php echo $current_text; ?></strong></li>
		</ol>
	</nav><!-- .breadcrumbs -->
<?php
}

endif;


/**
 * Display author's information box
 *
 * Usually used in the end of each post or in the Author page
 *
 * @since Underline 1.0
 *
 * @return void
 */

if ( ! function_exists( 'underline_author_box' ) ) :

function underline_author_box($class = '') {
  global $authordata;
		$title = __( 'Author', 'underline' ) . ': ' . get_the_author();
		
		$author_id = isset( $authordata->ID ) ? $authordata->ID : 0;
		$author = get_userdata( $author_id );

		$desc = ( $author->description ) ? $author->description : '';
		$author_email = ( $author->user_email ) ? $author->user_email : '';
?>
	<div class="<?php echo esc_attr($class); ?> author-info clearfix">
		<div class="author-avatar">
			<?php echo get_avatar( $author_email, 44 ); ?>
		</div>
		<div class="author-description">
			<h2 class="author-title"><?php echo $title; ?></h2>
			<p class="author-bio"><?php echo $desc; ?></p>
			<ul class="author-links">
			  <?php if ( $author->user_url && $author->user_url !== '' ) : 
          $home_url = parse_url ( home_url() );
          $home_host = $home_url['host'];
          $author_url = parse_url( $author->user_url );
          $author_host = $author_url['host'];
			    $rel = ( $home_host == $author_host ) ? '' : 'rel="me"'; ?>
        <li class="author-url"><a href="<?php echo $author->user_url; ?>" <?php echo $rel; ?>><?php _e( 'Website', 'underline' ); ?></a></li> 
			  <?php endif; ?>

			  <?php if ( $author->twitter && $author->twitter !== '' ) : ?>
        <li class="author-twitter"><a href="<?php echo $author->twitter; ?>">Twitter</a></li>
			  <?php endif; ?>

				<?php if ( $author->googleplus && $author->googleplus !== '' ) : ?>
        <li class="author-googleplus"><a href="<?php echo $author->googleplus . '?rel=author'; ?>">Google+</a></li>
				<?php endif; ?>

				<?php if ( $author->facebook && $author->facebook !== '' ) : ?>
				<li class="author-facebook"><a href="<?php echo $author->facebook; ?>">Facebook</a></li>
				<?php endif; ?>

				<?php do_action( 'underline_author_links', $author ); ?>
			</ul>
		</div>
	</div><!-- archive-meta -->
<?php }

endif;

/**
 * Display meta description of archive type page
 * includes Category, Tag, Search, Archive
 *
 * @since Underline 1.0
 *
 * @return void
 */

function underline_archive_meta() {

	if ( is_home() || is_singular() )
		return;

	global $post;

  $title = '';
  $desc = '';

	if ( is_category() ) : 	
		
		$categories = wp_get_post_categories( $post->ID );

		if ( ! $categories || ! is_array( $categories ) )
			return;

		$cat = get_category( $categories[0] );

		$title = __( 'Category', 'underline' ) . ': ' . $cat->name;
		$desc = $cat->description;
?>
	<div class="archive-meta">
		<h1 class="archive-title"><?php echo $title; ?></h1>
		<p class="archive-description"><?php echo $desc; ?></p>
	</div><!-- archive-meta -->

<?php elseif ( is_tag() ) :

		$title = __( 'Tag Archives', 'underline' ) . ': ' . single_tag_title( '', false );
		$desc = tag_description();
?>
	<div class="archive-meta">
		<h1 class="archive-title"><?php echo $title; ?></h1>
		<p class="archive-description"><?php echo $desc; ?></p>
	</div><!-- archive-meta -->
<?php elseif ( is_author() ) : 
  underline_author_box( 'archive-meta' ) ; ?>
<?php elseif ( is_search() ) : 

		$title = __( 'Search Results for', 'underline' ) . ': ' . get_search_query();
?>
	<div class="archive-meta">
		<h1 class="archive-title"><?php echo $title; ?></h1>
		<p class="archive-description"><?php echo $desc; ?></p>
	</div><!-- archive-meta -->
<?php else :
		if ( is_day() ) {
			$title = __( 'Daily Archives', 'underline' ) . ': ' . get_the_date();
		} elseif ( is_month() ) {
			$title = __( 'Monthly Archives', 'underline' ) . ': ' . get_the_date( 'F Y' );
		} elseif ( is_year() ) {
			$title = __( 'Yearly Archives', 'underline' ) . ': ' . get_the_date( 'Y' );
		} else {
			$title = __( 'Archives', 'underline' );
		}
?>
	<div class="archive-meta">
		<h1 class="archive-title"><?php echo $title; ?></h1>
		<p class="archive-description"><?php echo $desc; ?></p>
	</div><!-- archive-meta -->
<?php endif;  
}

if ( ! function_exists( 'underline_comment_callback' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * Extended from TwentyTwelve 
 * 
 * @since Underline 1.0
 *
 * @return void
 */
function underline_comment_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'underline' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'underline' ), '<span class="edit-link">', '</span>' ); ?></p>
	</li>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment clearfix" itemtype="http://schema.org/Comment" itemscope="itemscope" itemprop="comment">
			<header class="comment-meta comment-author">
				<div class="comment-author">
					<?php echo get_avatar( $comment, 44 ); ?>
					<?php $url = ( $comment->user_id === $post->post_author ) ? home_url() : get_comment_author_url(); ?>
					
					<?php if ( $url == '' || 'http://' == $url || 'https://' == $url ) : ?>
					<span class="comment-author-name" itemprop="author"><?php echo get_comment_author(); ?></span>
					<?php else : ?>
					<?php printf( '<a href="%s" class="comment-author-name" rel="external nofollow" itemprop="author">%s</a>', $url, get_comment_author() ); ?>
					<?php endif; ?> 
					
      		<?php if ( $comment->user_id === $post->post_author ) : ?>
					<span class="post-author">Post author</span>
      		<?php endif; ?>
      	</div><!-- .comment-author -->

      	<div class="comment-metadata">
    			<?php 
    				printf( '<a href="%s"><time datetime="%s" itemprop="dateCreated">%s</time></a>', 
    					esc_url( get_comment_link( $comment->comment_ID ) ),
    					get_comment_time( 'c' ),
    					sprintf( __( '%1$s at %2$s', 'underline' ), get_comment_date(), get_comment_time() )
    				); 
    			?>
    			<?php edit_comment_link( __( 'Edit', 'underline' ), '<span class="edit-link">(', ')</span>' ); ?>
        	
      	</div><!-- .comment-metadata -->
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'underline' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment" itemprop="text">
				<?php comment_text(); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'underline' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

// Theme use Schema markup (excerpt for breadcrumbs) not hAtom
if ( ! function_exists( 'underline_remove_hAtom_class' ) ) :

function underline_remove_hAtom_class($classes) {
	return array_diff( $classes, array( 'hentry' ) );
}
add_filter( 'post_class', 'underline_remove_hAtom_class' );

endif;

/**
 * Create HTML list of nav menu items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker
 */
class Underline_Walker_Sub_Menu extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$extend = '<a class="extend" href="#">&rsaquo;</a>';
		$output .= "\n{$indent}{$extend}<ul class=\"sub-menu\">\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

// Used by contact form to send out messages
if ( ! function_exists( 'underline_send_message' ) ) :
function underline_send_message() {	
  if ( ! isset( $_POST['submit']) )
  	return;

  $nonce = $_POST['underline_contact_nonce'];

  if ( ! wp_verify_nonce( $nonce, 'underline-send-message' ) )
  	die( __( "Please don't!", 'underline' ) );
 
	if ( ! isset( $_POST['mail'] ) )
		die( __( 'Something goes wrong!', 'underline' ) );
  
  echo '<ul class="messages">';

  $mail = array_merge( array(
    'email' => '',
    'subject' => '',
    'message' => ''
    ),
    $_POST['mail']
  );

  $errors = array();

  if ( ! isset( $mail['checker']) )
  	$errors[] = __( "You're not human?", "underline" ); 

	$email = trim( $mail['email'] );
	$subject = trim( $mail['subject'] );
	$message = trim( $mail['message'] );

  
	if ( $email == '' || $subject == '' || $message == '' )
		$errors[] = __( 'Please fill out all required fields', 'underline' );

	if ( strlen( $message ) < 10 )
		$errors[] = __( 'The message must be longer than 10 letters', 'underline' );

	if ( ! is_email($email) )
		$errors[] = __( 'The email is invalid', 'underline' );

	if ( count($errors) ) {
	?>
    <?php foreach ( $errors as $error ) : ?>
  	<li class="error"><?php echo $error; ?></li>
  	<?php endforeach; ?>
  </ul> 
	<?php
	} else {

    $headers = sprintf( "From : %s\n\n", $email );
    $message = $headers . $message;

		// Actually send it 
		$to = apply_filters( 'underline_mail_to', get_option( 'admin_email' ) );
		
		if ( ! is_email( $to ) )
			die( __( 'Sorry, we can\'t receive mail now. Please try again later.', 'underline' ) ); 
		
		$sent = wp_mail( $to, $subject, $message );

		if ( $sent )
			echo '<li class="success">' . __( 'The message is sent successfully.', 'underline' ) . '</li>';
		else 
			echo '<li class="error">' . __( 'Something goes wrong! Please try again later.', 'underline' ) . '</li>';
	}

	echo '</ul>';
}

endif;