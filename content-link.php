<?php
/**
 * The template for displaying posts in the Link Post Format
 *
 * @package Oita 
 * @since Oita 1.0
 */
?>

<?php $options = get_option('oita_theme_options'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post"><?php _e( 'Featured Link', 'oita' ); ?></div>
		<?php else : ?>
		<div class="postformat-label"><?php _e( 'Link', 'oita' ); ?></div>
		<?php endif; ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'oita' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<aside class="entry-details">
			<ul>
				<li class="entry-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
				<li class="entry-permalink"><a href="<?php the_permalink(); ?>" title="Permalink"><?php _e('Permalink', 'oita') ?></a></li>
			</ul>
		</aside><!--end .entry-details -->
	</header><!--end .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Read more', 'oita' ) ); ?>
	</div><!-- end entry-content -->
	
	<footer class="entry-meta">
		<ul>
			<li class="entry-comments">
			<?php comments_popup_link( __( 'Leave a Comment &rarr;', 'oita' ), __( '<span class="comment-count">1</span> Comment &rarr;', 'oita' ), __( '<span class="comment-count">%</span> Comments &rarr;', 'oita' ) ); ?>
			</li>
			<?php if ( has_category() ) : ?>
			<li class="entry-cats"><span><?php _e('Filed under: ', 'oita') ?></span><?php the_category(', '); ?></li>
			<?php endif; // has_category() ?>
			<li class="entry-edit"><?php edit_post_link(__( 'Edit &rarr;', 'oita' ), '' ); ?></li>
		</ul>
		<?php // Include Share-Btns
		if( $options['share-posts'] && ! is_search() ) : ?>
			<?php get_template_part( 'share'); ?>
		<?php endif; ?>
	</footer><!-- end .entry-meta -->

</article><!-- end post -<?php the_ID(); ?> -->