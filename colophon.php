<?php
/**
 * The template for displaying an optional footer nav and the site info.
 *
 * @package Oita
 * @since Oita 1.0.1
 */
?>

<div class="colophon" role="contentinfo">

	<?php if (has_nav_menu( 'optional' ) ) {
		wp_nav_menu( array('theme_location' => 'optional', 'container' => 'nav' , 'container_class' => 'footer-nav', 'depth' => 1 ));}
	?>

	<div class="site-info">
			<?php
				$options = get_option('oita_theme_options');
				if($options['custom_footertext'] != '' ){
					echo ('<ul class="credit"><li>');
					echo stripslashes($options['custom_footertext']);
					echo ('</li></ul>');
			} else { ?>
			<ul class="credit">
				<li>&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url( '/' ); ?>"><?php bloginfo(); ?></a>.</li>
				<?php
					/* Include Privacy Policy link. */
					if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '<li>', '.</li>', 'oita');
					}
				?>
				<li><?php _e('Powered by', 'oita') ?> <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'oita' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'oita' ); ?>"><?php _e('WordPress', 'oita') ?></a>.</li>
				<li><?php printf( __( 'Theme: %1$s by %2$s.', 'oita' ), 'Oita', '<a href="https://www.elmastudio.de/en/" title="Elmastudio WordPress Themes">Elmastudio</a>' ); ?></li>
			</ul><!-- end .credit -->
			<?php } ?>
	</div><!-- end .site-info -->

</div><!-- end .colophon -->
