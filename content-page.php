<?php
/**
 * The template used for displaying page content.
 *
 * @package Oita 
 * @since Oita 1.0
 */
?>

<?php $options = get_option('oita_theme_options'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- end .entry-header -->

	<div class="entry-content clearfix">
		<?php the_content(); ?>
	</div><!-- end .entry-content -->

	<?php // Include Share-Btns
		$options = get_option('oita_theme_options');
		if( $options['share-pages'] ) : ?>
		<footer class="entry-meta">
			<?php get_template_part( 'share'); ?>
		</footer><!-- end .entry-meta -->
	<?php endif; ?>

</article><!-- end post-<?php the_ID(); ?> -->