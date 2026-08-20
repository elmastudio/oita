<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Oita 
 * @since Oita 1.0
 */

get_header(); ?>

	<div id="site-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'single' ); ?>
			<?php comments_template( '', true ); ?>
		<?php endwhile; // end of the loop. ?>

		<nav id="nav-single" class="clearfix">
			<div class="nav-previous"><?php next_post_link( '%link', __( 'Next Post', 'oita' ) ); ?></div>
			<div class="nav-next"><?php previous_post_link( '%link', __( 'Previous Post', 'oita' ) ); ?></div>
		</nav><!-- #nav-below -->
	
	</div><!-- end #site-content -->

<?php get_footer(); ?>
