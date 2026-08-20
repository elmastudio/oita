<?php
/**
 * The default template for displaying content
 *
 * @package Oita 
 * @since Oita 1.0
 */
?>

<?php $options = get_option('oita_theme_options'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<aside class="entry-details">
			<ul>
				<?php if ( get_post_format() ) : // Show author link only for standard posts ?>	
				<?php else: ?>
				<li class="post-author">
				<?php
					printf( __( '<a href="%1$s" title="%2$s">%3$s</a>, ', 'oita' ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					sprintf( esc_attr__( 'All posts by %s', 'oita' ), get_the_author() ),
					get_the_author() );
				?>
				</li>
				<?php endif; ?>
				<li><a href="<?php the_permalink(); ?>" class="entry-date"><?php echo get_the_date(); ?></a></li>
				<li class="entry-permalink"><a href="<?php the_permalink(); ?>" title="Permalink"><?php _e('Permalink', 'oita') ?></a></li>
			</ul>
		</aside><!--end .entry-details -->
	</header><!--end .entry-header -->

		<div class="entry-content">
		<?php if( is_search () ) : // Show excerpts on search results. ?>
			<?php the_excerpt(); ?>
		<?php else : ?>
			<?php if ( has_post_thumbnail() ): ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			<?php endif; ?>
			<?php the_content( __( 'Read more', 'oita' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'oita' ), 'after' => '</div>' ) ); ?>
		<?php endif; ?>
		</div><!-- end .entry-content -->

		<?php if ( get_post_format() ) : // Show author bio only for standard post format posts ?>	
		<?php else: ?>
		<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their author bio, show it on standard posts. ?>
		<div class="author-info">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'oita_author_bio_avatar_size', 40 ) ); ?>
				<div class="author-details">
					<h3><?php the_author(); ?></h3>
					<?php if( $options['custom_authorlinks'] ) : // if author social links are filled out in the theme optons. ?>
						<p class="author-links"><span><?php _e('Find me on: ', 'oita') ?></span>
							<?php echo stripslashes($options['custom_authorlinks']); ?>
						</p>
					<?php endif; ?>
				</div><!-- end .author-details -->
				<p class="author-description"><?php the_author_meta( 'description' ); ?></p>	
		</div><!-- end .author-info -->
		<?php endif; ?>
		<?php endif; ?>

	<footer class="entry-meta">
		<ul>
			<?php if ( has_category() ) : ?>
			<li class="entry-cats"><span><?php _e('Filed under: ', 'oita') ?></span><?php the_category(', '); ?></li>
			<?php endif; // has_category() ?>
			<?php $tags_list = get_the_tag_list( '', ', ' ); 
			if ( $tags_list ): ?>
			<li class="entry-tags"><span><?php _e('Tagged:', 'oita') ?></span> <?php the_tags( '', ', ', '' ); ?></li>
			<?php endif; // get_the_tag_list() ?>
			<li class="entry-edit"><?php edit_post_link(__( 'Edit &rarr;', 'oita' ), '' ); ?></li>
		</ul>
		<?php // // Include Share Buttons on single posts
			$options = get_option('oita_theme_options');
			if($options['share-singleposts'] or $options['share-posts']) : ?>
			<?php get_template_part( 'share'); ?>
		<?php endif; ?>
	</footer><!-- end .entry-meta -->

</article><!-- end post -<?php the_ID(); ?> -->