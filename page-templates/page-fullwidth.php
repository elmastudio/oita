<?php
/**
 * Template Name: Fullwidth Page Template
 * Description: A Fullwidth page template
 *
 * @package Oita 
 * @since Oita 1.0
 */

get_header(); ?>

	<div id="site-content">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
			<?php comments_template( '', true ); ?>
		<?php endwhile; // end of the loop. ?>

	</div><!-- end #site-content -->

<?php get_footer(); ?>
