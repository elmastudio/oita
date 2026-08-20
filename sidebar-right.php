<?php
/**
 * The Sidebar Right containing the widget areas.
 *
 * @package Oita
 * @since Oita 1.0
 */
?>

	<?php
	/* Check if any of the footer widget areas have widgets.
	 *
	 * If none of the footer widget areas have widgets, let's bail early.
	 */
		if (   ! is_active_sidebar( 'sidebar-2' )
			&& ! is_active_sidebar( 'sidebar-3' )
			&& ! is_active_sidebar( 'sidebar-4' )
		)
		return;
	// If we get this far, we have widgets. Let do this.
	?>

	<section class="sidebar-right" role="complementary">
		<div class="widget-area-wrap">
		
		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div id="sidebar-right-onecol" class="widget-area">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div><!-- .widget-area -->
		<?php endif; ?>
		
		<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
		<div id="sidebar-right-twocolleft" class="widget-area">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</div><!-- .widget-area -->
		<?php endif; ?>
		
		<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
		<div id="sidebar-right-twocolright" class="widget-area">
			<?php dynamic_sidebar( 'sidebar-4' ); ?>
		</div><!-- .widget-area -->
		<?php endif; ?>

		</div><!-- end .widget-area-wrap -->
	</section><!-- end .sidebar-right -->