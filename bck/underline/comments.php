<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * Extended from TwentyThirteen 
 *
 * @package WordPress
 * @subpackage Underline
 * @since Underline 1.0.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title"><?php _e( 'Comments', 'underline' ); ?></h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => apply_filters( 'underline_comment_avatar', 74 ),
					'callback'    => 'underline_comment_callback'
				) );
			?>
		</ol><!-- .comment-list -->

		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation clearfix" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'underline' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'underline' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'underline' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
	
	<?php
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		$comment_form_args = array(
			'id_submit' => 'comment-submit',
			'fields' => array(
				'author' => '<p class="comment-form-author"><label for="author" class="comment-form-label form-label">' . __( 'Name', 'underline' ) . ' <span class="required">*</span> </label> <input id="author" name="author" type="text" value="" size="30"' . $aria_req . '"></p>',
				'email' => '<p class="comment-form-email"><label for="email" class="comment-form-label form-label">' . __( 'Email', 'underline' ) . ( $req ? ' <span class="required">*</span>': '') . '</label> <input id="email" name="email" type="email" value="" size="30"'. $aria_req . '></p>',
				'url' => '<p class="comment-form-url"><label for="url" class="comment-form-label form-label">' . __( 'Website', 'underline' ) . '</label> <input id="url" name="url" type="url" value="" size="30"></p>'
			),
			'comment_field' => '<p class="comment-form-comment"><label for="comment" class="comment-form-label form-label">Comment <span class="required">*</span></label> <textarea id="comment" name="comment" cols="45" rows="8"' . $aria_req . '></textarea></p>'
		);
	?>

	<?php comment_form($comment_form_args); ?>

</div><!-- #comments -->