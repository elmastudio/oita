<?php
/**
 * The template for displaying Comments.
 *
 * @package Oita 
 * @since Oita 1.0
 */
?>

<div class="comments-wrap">
	<div id="comments" class="comments-area">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'oita' ); ?></p>
	</div><!-- #comments .comments-area -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), 'oita' ),
					number_format_i18n( get_comments_number() ) );
			?>
			<?php if ( comments_open() ) : ?>
			<span><a href="#reply-title"><?php _e( 'Write a comment', 'oita' ); ?></a></span>
			<?php endif; // comments_open() ?>
		</h3>

		<ol class="commentlist">
		<?php
			wp_list_comments( array(
				'avatar_size' => 40,
				'style'       => 'li',
				'short_ping'  => true,
				'format'      => 'html5',
				'callback'    => 'oita_comments_callback',
			) );
		?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav">
			<div class="nav-previous"><?php previous_comments_link( __( ' &larr;  Older Comments', 'oita' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments  &rarr; ', 'oita' ) ); ?></div>
		</nav><!-- end #comment-nav -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are no comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'oita' ); ?></p>
	<?php endif; ?>

	<?php comment_form (
		array(
			'title_reply' =>__( '<h3 id="reply-title">Leave a Comment</h3>', 'oita'),
			'comment_notes_before' =>__( '<p class="comment-note">Required fields are marked <span class="required">*</span>.</p>', 'oita'),
			'comment_notes_after' =>(''),
			'comment_field'  => '<p class="comment-form-comment"><label for="comment">' . _x( 'Message <span class="required">*</span>', 'noun', 'oita' ) . 			'</label><br/><textarea id="comment" name="comment" rows="8"></textarea></p>',
			'label_submit'	=> __( 'Send Comment', 'oita' ))
		); 
	?>

	</div><!-- #comments .comments-area -->
</div><!-- .comments-wrap -->
