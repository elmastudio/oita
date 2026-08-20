<?php
/**
 * The main template file.
 *
 * @package Oita 
 * @since Oita 1.0
 */

get_header(); ?>

	<div id="site-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; // end of the loop. ?>

		<?php /* Display navigation to next/previous pages when applicable, also check if WP pagenavi plugin is activated */ ?>
		<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<?php oita_content_nav( 'nav-below' ); ?>
		<?php endif; ?>
	</div><!-- end #site-content -->

<?php get_footer(); ?>