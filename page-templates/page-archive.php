<?php
/**
 * Template Name: Archive Page Template
 * Description: An archive page template
 *
 * @package Oita 
 * @since Oita 1.0
 */

get_header(); ?>

	<div id="site-content">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- end .entry-header -->

			<div class="entry-content clearfix">
				<h2 class="archive-title"><?php _e('Filter by Tags:', 'oita') ?></h2>
				<div class="archive-tags clearfix">
					<?php wp_tag_cloud('orderby=count&number=30'); ?> 
				</div><!-- end .archive-tags -->

				<h2 class="archive-title"><?php _e('The Latest 50 Posts:', 'oita') ?></h2>
				<ul class="latest-posts-list">
					<?php wp_get_archives('type=postbypost&limit=50'); ?>  
				</ul><!-- end .latest-posts-list -->

				<h2 class="archive-title"><?php _e('The Monthly Archive:', 'oita') ?></h2>
				<ul class="monthly-archive-list">
					<?php wp_get_archives('type=monthly'); ?>  
				</ul><!-- end .monthly-archive-list -->
			</div><!-- end .entry-content -->

			<?php // Include Share-Btns
				$options = get_option('oita_theme_options');
				if( $options['share-pages'] ) : ?>
				<footer class="entry-meta">
					<?php get_template_part( 'share'); ?>
				</footer><!-- end .entry-meta -->
			<?php endif; ?>

		</article><!-- end post-<?php the_ID(); ?> -->

	</div><!-- end #site-content -->

<?php get_footer(); ?>
