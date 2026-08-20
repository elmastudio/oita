<?php
/**
 * Oita Theme Options
 *
 * @subpackage Oita
 * @since Oita 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Properly enqueue styles and scripts for our theme options page.
/*
/* This function is attached to the admin_enqueue_scripts action hook.
/*
/* @param string $hook_suffix The action passes the current page to the function.
/* We don't do anything if we're not on our theme options page.
/*-----------------------------------------------------------------------------------*/

function oita_admin_enqueue_scripts( $hook_suffix ) {
	if ( $hook_suffix != 'appearance_page_theme_options' )
		return;

	wp_enqueue_style( 'oita-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2013-03-05' );
	wp_enqueue_script( 'oita-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2013-03-05' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_enqueue_scripts', 'oita_admin_enqueue_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Register the form setting for our oita_options array.
/*
/* This function is attached to the admin_init action hook.
/*
/* This call to register_setting() registers a validation callback, oita_theme_options_validate(),
/* which is used when the option is saved, to ensure that our option values are complete, properly
/* formatted, and safe.
/*
/* We also use this function to add our theme option if it doesn't already exist.
/*-----------------------------------------------------------------------------------*/

function oita_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === oita_get_theme_options() )
		add_option( 'oita_theme_options', oita_get_default_theme_options() );

	register_setting(
		'oita_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'oita_theme_options', // Database option, see oita_get_theme_options()
		'oita_theme_options_validate' // The sanitization callback, see oita_theme_options_validate()
	);
}
add_action( 'admin_init', 'oita_theme_options_init' );

/*-----------------------------------------------------------------------------------*/
/* Add our theme options page to the admin menu.
/* 
/* This function is attached to the admin_menu action hook.
/*-----------------------------------------------------------------------------------*/

function oita_theme_options_add_page() {
	add_theme_page(
		__( 'Theme Options', 'oita' ), // Name of page
		__( 'Theme Options', 'oita' ), // Label in menu
		'edit_theme_options',                  // Capability required
		'theme_options',                       // Menu slug, used to uniquely identify the page
		'theme_options_render_page'            // Function that renders the options page
	);
}
add_action( 'admin_menu', 'oita_theme_options_add_page' );

/*-----------------------------------------------------------------------------------*/
/* Returns the default options for Oita
/*-----------------------------------------------------------------------------------*/

function oita_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   => '#f9ca79',
		'extrafont_color'   => '#f9ca79',
		'sidebarbg_color'   => '#f2f2f2',
		'bg_color'   => '#ffffff',
		'custom_logo' => '',
		'custom_footertext' => '',
		'custom_authorlinks' => '',
		'custom_favicon' => '',
		'custom_apple_icon' => '',
		'show-excerpt' => '',
		'share-posts' => '',
		'share-singleposts' => '',
		'share-pages' => '',
		'custom-css' => '',
	);

	return apply_filters( 'oita_default_theme_options', $default_theme_options );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Oita
/*-----------------------------------------------------------------------------------*/

function oita_get_theme_options() {
	return get_option( 'oita_theme_options' );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Oita
/*-----------------------------------------------------------------------------------*/

function theme_options_render_page() {
	?>
	<div class="wrap">
		<h2><?php printf( __( '%s Theme Options', 'oita' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'oita_options' );
				$options = oita_get_theme_options();
				$default_options = oita_get_default_theme_options();
			?>

			<table class="form-table">
			<h3 style="margin-top:30px;"><?php _e( 'Custom Colors', 'oita' ); ?></h3>
				<tr valign="top"><th scope="row"><?php _e( 'Link Color', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'oita' ); ?></span></legend>
							 <input type="text" name="oita_theme_options[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>" id="link-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker1"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your custom link color, the default color is: %s. Do not forget to include the # before the color value.', 'oita' ), $default_options['link_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Additional Font Color', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Additional Font Color', 'oita' ); ?></span></legend>
							 <input type="text" name="oita_theme_options[extrafont_color]" value="<?php echo esc_attr( $options['extrafont_color'] ); ?>" id="extrafont-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker3"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your custom additional font color, the default color is: %s.', 'oita' ), $default_options['extrafont_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Sidebar Background Color', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Sidebar Background Color', 'oita' ); ?></span></legend>
							 <input type="text" name="oita_theme_options[sidebarbg_color]" value="<?php echo esc_attr( $options['sidebarbg_color'] ); ?>" id="sidebarbg-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker2"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your custom sidebar background color, the default color is: %s.', 'oita' ), $default_options['sidebarbg_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Main Background Color', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Main Background Color', 'oita' ); ?></span></legend>
							 <input type="text" name="oita_theme_options[bg_color]" value="<?php echo esc_attr( $options['bg_color'] ); ?>" id="bg-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker4"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your custom main background color, the default color is: %s.', 'oita' ), $default_options['bg_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>
				</table>

				<table class="form-table">
				<h3 style="margin-top:30px;"><?php _e( 'Logo, Post Excerpts & Custom Texts', 'oita' ); ?></h3>
				<tr valign="top"><th scope="row"><?php _e( 'Custom Logo', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Logo image', 'oita' ); ?></span></legend>
							<input class="regular-text" type="text" name="oita_theme_options[custom_logo]" value="<?php echo esc_attr( $options['custom_logo'] ); ?>" />
						<br/><label class="description" for="oita_theme_options[custom_logo]"><?php _e('Upload your own logo image using the ', 'oita'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'oita'); ?></a><?php _e('. Then copy your logo image file URL and insert the URL here.', 'oita'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Post Excerpts', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Post Excerpts', 'oita' ); ?></span></legend>
							<input id="oita_theme_options[show-excerpt]" name="oita_theme_options[show-excerpt]" type="checkbox" value="1" <?php checked( '1', $options['show-excerpt'] ); ?> />
							<label class="description" for="oita_theme_options[show-excerpt]"><?php _e( 'Check this box to show automatic post excerpts. With this option you will not need to add the more tag in posts.', 'oita' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Footer Text', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Footer text', 'oita' ); ?></span></legend>
							<textarea id="oita_theme_options[custom_footertext]" class="small-text" cols="120" rows="3" name="oita_theme_options[custom_footertext]"><?php echo esc_textarea( $options['custom_footertext'] ); ?></textarea>
						<br/><label class="description" for="oita_theme_options[custom_footertext]"><?php _e( 'Customize the footer credit text (Standard HTML is allowed).', 'oita' ); ?></label>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Custom Author Links', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Author Links', 'oita' ); ?></span></legend>
							<textarea id="oita_theme_options[custom_authorlinks]" class="small-text" cols="120" rows="3" name="oita_theme_options[custom_authorlinks]"><?php echo esc_textarea( $options['custom_authorlinks'] ); ?></textarea>
						<br/><label class="description" for="oita_theme_options[custom_authorlinks]"><?php _e( 'Add custom "Find me on" links to your author bio on single posts (Standard HTML is allowed).', 'oita' ); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>
				
				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Favicon and Apple Touch Icon', 'oita' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Favicon', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Favicon', 'oita' ); ?></span></legend>
							<input class="regular-text" type="text" name="oita_theme_options[custom_favicon]" value="<?php echo esc_attr( $options['custom_favicon'] ); ?>" />
						<br/><label class="description" for="oita_theme_options[custom_favicon]"><?php _e( 'Create a <strong>16x16px</strong> image and generate a .ico favicon using a favicon online generator. Now upload your favicon to your themes folder (via FTP) and enter your Favicon URL here (the URL path should be similar to: yourdomain.com/wp-content/themes/oita/favicon.ico).', 'oita' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Apple Touch Icon', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Apple Touch Icon', 'oita' ); ?></span></legend>
							<input class="regular-text" type="text" name="oita_theme_options[custom_apple_icon]" value="<?php echo esc_attr( $options['custom_apple_icon'] ); ?>" />
						<br/><label class="description" for="oita_theme_options[custom_apple_icon]"><?php _e('Create a <strong>128x128px png</strong> image for your webclip icon. Upload your image using the ', 'oita'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'oita'); ?></a><?php _e('. Now copy the image file URL and insert the URL here.', 'oita'); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>

				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Share Buttons', 'oita' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Share buttons on posts', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share buttons on posts', 'oita' ); ?></span></legend>
							<input id="oita_theme_options[share-posts]" name="oita_theme_options[share-posts]" type="checkbox" value="1" <?php checked( '1', $options['share-posts'] ); ?> />
							<label class="description" for="oita_theme_options[share-posts]"><?php _e( 'Check this box to show share buttons (Twitter, Facebook, Google+, Pinterest) on your blogs front page and on single posts.', 'oita' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share buttons on single posts only', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share buttons on single posts only', 'oita' ); ?></span></legend>
							<input id="oita_theme_options[share-singleposts]" name="oita_theme_options[share-singleposts]" type="checkbox" value="1" <?php checked( '1', $options['share-singleposts'] ); ?> />
							<label class="description" for="oita_theme_options[share-singleposts]"><?php _e( 'Check this box to show share buttons <strong>only</strong> on single posts (below the post content).', 'oita' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share buttons on pages', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share buttons on pages', 'oita' ); ?></span></legend>
							<input id="oita_theme_options[share-pages]" name="oita_theme_options[share-pages]" type="checkbox" value="1" <?php checked( '1', $options['share-pages'] ); ?> />
							<label class="description" for="oita_theme_options[share-pages]"><?php _e( 'Check this box to show share buttons on pages.', 'oita' ); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>
				
				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Custom CSS', 'oita' ); ?></h3>
				
				<tr valign="top"><th scope="row"><?php _e( 'Include Custom CSS', 'oita' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Include Custom CSS', 'oita' ); ?></span></legend>
							<textarea id="oita_theme_options[custom-css]" class="small-text" style="font-family: monospace;" cols="120" rows="10" name="oita_theme_options[custom-css]"><?php echo esc_textarea( $options['custom-css'] ); ?></textarea>
						<br/><label class="description" for="oita_theme_options[custom-css]"><?php _e( 'Include custom CSS styles, use !important to overwrite existing styles.', 'oita' ); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Sanitize and validate form input. Accepts an array, return a sanitized array.
/*-----------------------------------------------------------------------------------*/

function oita_theme_options_validate( $input ) {
	global $layout_options, $font_options;

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
			$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Link hover color must be 3 or 6 hexadecimal characters
	if ( isset( $input['extrafont_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['extrafont_color'] ) )
			$output['extrafont_color'] = '#' . strtolower( ltrim( $input['extrafont_color'], '#' ) );

	// Footer background color must be 3 or 6 hexadecimal characters
	if ( isset( $input['sidebarbg_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['sidebarbg_color'] ) )
			$output['sidebarbg_color'] = '#' . strtolower( ltrim( $input['sidebarbg_color'], '#' ) );
			
	// Background color must be 3 or 6 hexadecimal characters
	if ( isset( $input['bg_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['bg_color'] ) )
			$output['bg_color'] = '#' . strtolower( ltrim( $input['bg_color'], '#' ) );

	// Text options must be safe text with no HTML tags
	$input['custom_logo'] = wp_filter_nohtml_kses( $input['custom_logo'] );
	$input['custom_favicon'] = wp_filter_nohtml_kses( $input['custom_favicon'] );
	$input['custom_apple_icon'] = wp_filter_nohtml_kses( $input['custom_apple_icon'] );

	// checkbox values are either 0 or 1
	if ( ! isset( $input['share-posts'] ) )
		$input['share-posts'] = null;
	$input['share-posts'] = ( $input['share-posts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-singleposts'] ) )
		$input['share-singleposts'] = null;
	$input['share-singleposts'] = ( $input['share-singleposts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-pages'] ) )
		$input['share-pages'] = null;
	$input['share-pages'] = ( $input['share-pages'] == 1 ? 1 : 0 );

	if ( ! isset( $input['show-excerpt'] ) )
		$input['show-excerpt'] = null;
	$input['show-excerpt'] = ( $input['show-excerpt'] == 1 ? 1 : 0 );

	return $input;
}

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current link color.
/* 
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function oita_print_link_color_style() {
	$options = oita_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = oita_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
<style type="text/css">
/* Custom Link Color */
a:hover,
.site-title h1.title a,
.main-nav .menu-item a:hover,
.main-nav ul li a:hover,
#site-content .entry-header h2.entry-title a:hover,
.entry-content a.more-link:hover,
#comments .comment-text a:hover,
#comments .comment-content ul li.comment-author a:hover,
#comments .comment-content ul li.comment-time a:hover,
#comments .comment-content ul li.comment-edit a:hover,
#comments .comment-content p.comment-reply a:hover,
#comments ol li.pingback a:hover,
.template-archive ul li a:hover,
.widget a:hover,
.widget-area .textwidget a:hover,
.widget_twitter ul.tweets li a:hover,
.colophon .footer-nav li a:hover,
#nav-single a:hover, 
#nav-below a:hover {color: <?php echo $link_color; ?>;}
input[type="submit"], .entry-content .archive-tags a:hover, .flickr_badge_wrapper .flickr-bottom a,
.jetpack_subscription_widget form#subscribe-blog input[type="submit"] {background:<?php echo $link_color; ?>;}
#nav-single a:hover, #nav-below a:hover, .previous-image a:hover, .next-image a:hover, #comment-nav a:hover {border-bottom:1px solid <?php echo $link_color; ?>;}
@media screen and (min-width: 1160px) {
.featured-post, .postformat-label {color: <?php echo $link_color; ?>;}
}
</style>
<?php
}
add_action( 'wp_head', 'oita_print_link_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the currentlink hover color.
/* 
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function oita_print_extrafont_color_style() {
	$options = oita_get_theme_options();
	$extrafont_color = $options['extrafont_color'];

	$default_options = oita_get_default_theme_options();

	// Don't do anything if the current  optional font color is the default.
	if ( $default_options['extrafont_color'] == $extrafont_color )
		return;
?>
<style type="text/css">
h5, h6, .entry-content p span.highlight, .entry-content p span.dropcaps, .entry-content p.sidenote-left span, .entry-content p.sidenote-right span, .entry-content p.colored {color: <?php echo $extrafont_color; ?>;}
.featured-post, .postformat-label {background: <?php echo $extrafont_color; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'oita_print_extrafont_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current footer background color.
/* 
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function oita_print_sidebarbg_color_style() {
	$options = oita_get_theme_options();
	$sidebarbg_color = $options['sidebarbg_color'];

	$default_options = oita_get_default_theme_options();

	// Don't do anything if the current  footer widget background color is the default.
	if ( $default_options['sidebarbg_color'] == $sidebarbg_color )
		return;
?>
<style type="text/css">
/* Custom Sidebar Bg Color */
.container [role="navigation"], [role="complementary"], .js body.active-nav, .main-nav, .format-quote .entry-content {background: <?php echo $sidebarbg_color; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'oita_print_sidebarbg_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current background color.
/* 
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function oita_print_bg_color_style() {
	$options = oita_get_theme_options();
	$bg_color = $options['bg_color'];

	$default_options = oita_get_default_theme_options();

	// Don't do anything if the current background color is the default.
	if ( $default_options['bg_color'] == $bg_color )
		return;
?>
<style type="text/css">
/* Custom Bg Color */
@media screen and (min-width: 1160px) {
body, [role="banner"], .js .active-nav .content-wrap, .js .active-sidebar .content-wrap, .off-canvas-nav {background: <?php echo $bg_color; ?>;}
.site-title h2.site-description, #nav-single a, #nav-below a {color:#222;}
#nav-single a, #nav-below a {border-bottom:1px solid #222;}
}
</style>
<?php
}
add_action( 'wp_head', 'oita_print_bg_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for custom css styles.
/* 
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function oita_print_customcss_style() {
	$options = oita_get_theme_options();
	$customcss = $options['custom-css'];

	$default_options = oita_get_default_theme_options();

	// Don't do anything if the current  footer widget background color is the default.
	if ( $default_options['custom-css'] == $customcss )
		return;
?>
<style type="text/css">
/* Custom CSS */
<?php echo $customcss; ?>
</style>
<?php
}
add_action( 'wp_head', 'oita_print_customcss_style' );
