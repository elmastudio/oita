<?php
/**
 * Oita functions and definitions
 *
 * @package Oita
 * @since Oita 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Theme update feature setup
/*-----------------------------------------------------------------------------------*/

if ( ! class_exists( 'WC_AM_Client_25' ) ) {
	require_once( get_template_directory() . '/inc/wc-am-client.php' );
}

if ( class_exists( 'WC_AM_Client_25' ) ) {

	$wcam_lib = new WC_AM_Client_25( __FILE__, '', wp_get_theme( wp_get_theme()->Template )->Version, 'theme', 'https://www.elmastudio.de/', wp_get_theme( wp_get_theme()->Template )->Name, wp_get_theme( wp_get_theme()->Template )->get( 'TextDomain' ), '36217' );

}

 /*-----------------------------------------------------------------------------------*/
/* Set the content width based on the theme's design and stylesheet.
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) )
	$content_width = 720; /* pixels */

/*-----------------------------------------------------------------------------------*/
/* Sets up theme defaults and registers support for various WordPress features.
/*-----------------------------------------------------------------------------------*/
/**
 * Tell WordPress to run oita_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'oita_setup' );

if ( ! function_exists( 'oita_setup' ) ):
/**
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override oita_setup() in a child theme, add your own oita_setup to your child theme's
 * functions.php file.
 */
function oita_setup() {

	// Make Oita available for translation. Translations can be filed in the /languages/ directory.
	load_theme_textdomain( 'oita', get_template_directory() . '/languages' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for editor font sizes.
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name' => __( 'small', 'oita' ),
			'shortName' => __( 'S', 'oita' ),
			'size' => 16,
			'slug' => 'small'
		),
		array(
			'name' => __( 'regular', 'oita' ),
			'shortName' => __( 'M', 'oita' ),
			'size' => 19,
			'slug' => 'regular'
		),
		array(
			'name' => __( 'large', 'oita' ),
			'shortName' => __( 'L', 'oita' ),
			'size' => 22,
			'slug' => 'large'
		),
		array(
			'name' => __( 'larger', 'oita' ),
			'shortName' => __( 'XL', 'oita' ),
			'size' => 29,
			'slug' => 'larger'
		)
	) );

	// Add editor color palette.
	add_theme_support( 'editor-color-palette', array(
		array(
			'name' => __( 'black', 'oita' ),
			'slug' => 'black',
			'color' => '#000000',
		),
		array(
			'name' => __( 'white', 'oita' ),
			'slug' => 'white',
			'color' => '#ffffff',
		),
		array(
			'name' => __( 'grey', 'oita' ),
			'slug' => 'grey',
			'color' => '#aaaaaa',
		),
		array(
			'name' => __( 'yellow', 'oita' ),
			'slug' => 'yellow',
			'color' => '#f9ca79',
		),
	) );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style( array( 'editor-style.css' ) );

	// Load up the Oita theme options page and related code.
	require( get_template_directory() . '/inc/theme-options.php' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu().
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'oita' ),
		'optional' => __( 'Footer Navigation (no sub menus supported)', 'oita' )
	) );

	// Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'quote', 'image', 'gallery', 'video', 'status' ) );

	// This theme support for Jetpack Infinite Scroll
	add_theme_support( 'infinite-scroll', array(
		'container'  => 'site-content',

	) );

}
endif; // oita_setup


/*-----------------------------------------------------------------------------------*/
/* Register Google fonts for Oita.
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'oita_fonts_url' ) ) :

function oita_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Crimson Text, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Crimson Text font: on or off', 'oita' ) ) {
		$fonts[] = 'Crimson Text:400,700,400italic,700italic';
	}

	/* translators: If there are characters in your language that are not supported by Raleway, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Raleway font: on or off', 'oita' ) ) {
		$fonts[] = 'Raleway:400,700';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;


/*-----------------------------------------------------------------------------------*/
/*  Enqueue scripts and styles
/*-----------------------------------------------------------------------------------*/

function oita_scripts() {
	global $wp_styles;

	// Adds JavaScript to pages with the comment form to support sites with threaded comments (when in use)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds JavaScript for responsive videos
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );

	// Adds Custom Oita JavaScript for Off Canvas layout
	wp_enqueue_script( 'oita-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '20130306', true );

	// Add fonts, used in the main stylesheet.
	wp_enqueue_style( 'oita-fonts', oita_fonts_url(), array(), null );

	// Loads main stylesheet.
	wp_enqueue_style( 'oita-style', get_stylesheet_uri(), array(), '20160511' );

	// Loads the Internet Explorer specific stylesheet for IE versions below 9
	wp_enqueue_style( 'oita-ie', get_template_directory_uri() . '/css/ie.css', array( 'oita-style' ), '20130306' );
	$wp_styles->add_data( 'oita-ie', 'conditional', 'lt IE 9' );

}
add_action( 'wp_enqueue_scripts', 'oita_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Load block editor styles.
/*-----------------------------------------------------------------------------------*/
function oita_block_editor_styles() {
 wp_enqueue_style( 'oita-block-editor-styles', get_template_directory_uri() . '/block-editor.css');
 wp_enqueue_style( 'oita-fonts', oita_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'oita_block_editor_styles' );

/*-----------------------------------------------------------------------------------*/
/* Include theme options in the theme customizer
/*-----------------------------------------------------------------------------------*/
function oita_customize_register( $wp_customize ) {
//All our sections, settings, and controls will be added here

}
add_action( 'customize_register', 'oita_customize_register' );

/*-----------------------------------------------------------------------------------*/
/* Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
/*-----------------------------------------------------------------------------------*/
function oita_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'oita_page_menu_args' );

/*-----------------------------------------------------------------------------------*/
/* Number of tags in the tagcoud widget
/*-----------------------------------------------------------------------------------*/
add_filter( 'widget_tag_cloud_args', 'oita_widget_tag_cloud_args' );
function oita_widget_tag_cloud_args( $args ) {
	$args['number'] = 30;
	return $args;
}

/*-----------------------------------------------------------------------------------*/
/* Sets the post excerpt length to 40 characters.
/*-----------------------------------------------------------------------------------*/
function oita_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'oita_excerpt_length' );

/*-----------------------------------------------------------------------------------*/
/* Returns a "Continue Reading" link for excerpts
/*-----------------------------------------------------------------------------------*/
function oita_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Read more', 'oita' ) . '</a>';
}

/*-----------------------------------------------------------------------------------*/
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and oita_continue_reading_link().
/*
/* To override this in a child theme, remove the filter and add your own
/* function tied to the excerpt_more filter hook.
/*-----------------------------------------------------------------------------------*/
function oita_auto_excerpt_more( $more ) {
	return ' (&hellip;)' . oita_continue_reading_link();
}
add_filter( 'excerpt_more', 'oita_auto_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Adds a pretty "Continue Reading" link to custom post excerpts.
/*-----------------------------------------------------------------------------------*/
function oita_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= oita_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'oita_custom_excerpt_more' );

/**
 * Callback to change just html output on a comment.
 */
function oita_comments_callback($comment, $args, $depth){
	//checks if were using a div or ol|ul for our output
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="comment">

			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 40 ); ?>
			</div>

			<div class="comment-content">
				<ul class="comment-meta">
					<li class="comment-author"><?php printf( __( ' %s ', 'oita' ), sprintf( ' %s ', get_comment_author_link() ) ); ?></li>
					<li class="comment-time"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s @ %2$s', 'oita' ),
						get_comment_date('d.m.y'),
						get_comment_time() );
					?></a></li>
					<li class="comment-edit"><?php edit_comment_link( __( 'Edit &rarr;', 'oita' ), ' &#183; ' );?></li>
				</ul>
				<div class="comment-text">
					<?php comment_text(); ?>
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'oita' ); ?></p>
					<?php endif; ?>
					<p class="comment-reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'oita' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></p>
				</div><!-- end .comment-text -->
			</div><!-- end .comment-content -->
		</article><!-- end .comment -->
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Register widgetized areas
/*-----------------------------------------------------------------------------------*/
function oita_widgets_init() {

	register_sidebar( array (
		'name' => __( 'Sidebar Right, Single Column', 'oita' ),
		'id' => 'sidebar-2',
		'description' => __( 'Widgets will appear in the right sidebar.', 'oita' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Sidebar Right, Two-Columns Left', 'oita' ),
		'id' => 'sidebar-3',
		'description' => __( 'Widgets will appear in the right sidebar in the left column of the two-column widget area.', 'oita' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Sidebar Right, Two-Columns Right', 'oita' ),
		'id' => 'sidebar-4',
		'description' => __( 'Widgets will appear in the right sidebar in the right column of the two-column widget area.', 'oita' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Sidebar Left', 'oita' ),
		'id' => 'sidebar-1',
		'description' => __( 'Widgets will appear in the left sidebar below the main navigation.', 'oita' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'init', 'oita_widgets_init' );


if ( ! function_exists( 'oita_content_nav' ) ) :

/*-----------------------------------------------------------------------------------*/
/* Display navigation to next/previous pages when applicable
/*-----------------------------------------------------------------------------------*/
function oita_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="clearfix">
				<div class="nav-previous"><?php next_posts_link( __( 'Older entries', 'oita'  ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer entries', 'oita' ) ); ?></div>
			</nav><!-- end #nav-below -->
	<?php endif;
}

endif; // oita_content_nav

/*-----------------------------------------------------------------------------------*/
/* Extends the default WordPress body classes
/*-----------------------------------------------------------------------------------*/
function oita_body_class( $classes ) {

	if ( is_page_template( 'page-templates/page-archive.php' ) )
		$classes[] = 'template-archive';

	if ( is_page_template( 'page-templates/page-fullwidth.php' ) )
		$classes[] = 'template-fullwidth';

	return $classes;
}
add_filter( 'body_class', 'oita_body_class' );

/*-----------------------------------------------------------------------------------*/
/* Add One Click Demo Import code.
/*-----------------------------------------------------------------------------------*/
require get_template_directory() . '/inc/demo-installer.php';

/*-----------------------------------------------------------------------------------*/
/* Oita Shortcodes
/*-----------------------------------------------------------------------------------*/
// Enable shortcodes in widget areas
add_filter( 'widget_text', 'do_shortcode' );

// Replace WP autop formatting
if (!function_exists( "oita_remove_wpautop")) {
	function oita_remove_wpautop($content) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Multi Columns Shortcodes
/* Don't forget to add "_last" behind the shortcode if it is the last column.
/*-----------------------------------------------------------------------------------*/

// Two Columns
function oita_shortcode_two_columns_one( $atts, $content = null ) {
	 return '<div class="two-columns-one">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one', 'oita_shortcode_two_columns_one' );

function oita_shortcode_two_columns_one_last( $atts, $content = null ) {
	 return '<div class="two-columns-one last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one_last', 'oita_shortcode_two_columns_one_last' );

// Three Columns
function oita_shortcode_three_columns_one($atts, $content = null) {
	 return '<div class="three-columns-one">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one', 'oita_shortcode_three_columns_one' );

function oita_shortcode_three_columns_one_last($atts, $content = null) {
	 return '<div class="three-columns-one last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one_last', 'oita_shortcode_three_columns_one_last' );

function oita_shortcode_three_columns_two($atts, $content = null) {
	 return '<div class="three-columns-two">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two', 'oita_shortcode_three_columns_two' );

function oita_shortcode_three_columns_two_last($atts, $content = null) {
	 return '<div class="three-columns-two last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two_last', 'oita_shortcode_three_columns_two_last' );

// Four Columns
function oita_shortcode_four_columns_one($atts, $content = null) {
	 return '<div class="four-columns-one">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one', 'oita_shortcode_four_columns_one' );

function oita_shortcode_four_columns_one_last($atts, $content = null) {
	 return '<div class="four-columns-one last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one_last', 'oita_shortcode_four_columns_one_last' );

function oita_shortcode_four_columns_two($atts, $content = null) {
	 return '<div class="four-columns-two">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two', 'oita_shortcode_four_columns_two' );

function oita_shortcode_four_columns_two_last($atts, $content = null) {
	 return '<div class="four-columns-two last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two_last', 'oita_shortcode_four_columns_two_last' );

function oita_shortcode_four_columns_three($atts, $content = null) {
	 return '<div class="four-columns-three">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three', 'oita_shortcode_four_columns_three' );

function oita_shortcode_four_columns_three_last($atts, $content = null) {
	 return '<div class="four-columns-three last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three_last', 'oita_shortcode_four_columns_three_last' );

// Five Columns
function oita_shortcode_five_columns_one($atts, $content = null) {
	 return '<div class="five-columns-one">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_one', 'oita_shortcode_five_columns_one' );

function oita_shortcode_five_columns_one_last($atts, $content = null) {
	 return '<div class="five-columns-one last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_one_last', 'oita_shortcode_five_columns_one_last' );

function oita_shortcode_five_columns_two($atts, $content = null) {
	 return '<div class="five-columns-two">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_two', 'oita_shortcode_five_columns_two' );

function oita_shortcode_five_columns_two_last($atts, $content = null) {
	 return '<div class="five-columns-two last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_two_last', 'oita_shortcode_five_columns_two_last' );

function oita_shortcode_five_columns_three($atts, $content = null) {
	 return '<div class="five-columns-three">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_three', 'oita_shortcode_five_columns_three' );

function oita_shortcode_five_columns_three_last($atts, $content = null) {
	 return '<div class="five-columns-three last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_three_last', 'oita_shortcode_five_columns_three_last' );

function oita_shortcode_five_columns_four($atts, $content = null) {
	 return '<div class="five-columns-four">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_four', 'oita_shortcode_five_columns_four' );

function oita_shortcode_five_columns_four_last($atts, $content = null) {
	 return '<div class="five-columns-four last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_four_last', 'oita_shortcode_five_columns_four_last' );

// Six Columns
function oita_shortcode_six_columns_one($atts, $content = null) {
	 return '<div class="six-columns-one">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_one', 'oita_shortcode_six_columns_one' );

function oita_shortcode_six_columns_one_last($atts, $content = null) {
	 return '<div class="six-columns-one last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_one_last', 'oita_shortcode_six_columns_one_last' );

function oita_shortcode_six_columns_two($atts, $content = null) {
	 return '<div class="six-columns-two">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_two', 'oita_shortcode_six_columns_two' );

function oita_shortcode_six_columns_two_last($atts, $content = null) {
	 return '<div class="six-columns-two last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_two_last', 'oita_shortcode_six_columns_two_last' );

function oita_shortcode_six_columns_three($atts, $content = null) {
	 return '<div class="six-columns-three">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_three', 'oita_shortcode_six_columns_three' );

function oita_shortcode_six_columns_three_last($atts, $content = null) {
	 return '<div class="six-columns-three last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_three_last', 'oita_shortcode_six_columns_three_last' );

function oita_shortcode_six_columns_four($atts, $content = null) {
	 return '<div class="six-columns-four">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_four', 'oita_shortcode_six_columns_four' );

function oita_shortcode_six_columns_four_last($atts, $content = null) {
	 return '<div class="six-columns-four last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_four_last', 'oita_shortcode_six_columns_four_last' );

function oita_shortcode_six_columns_five($atts, $content = null) {
	 return '<div class="six-columns-five">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_five', 'oita_shortcode_six_columns_five' );

function oita_shortcode_six_columns_five_last($atts, $content = null) {
	 return '<div class="six-columns-five last">' . oita_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_five_last', 'oita_shortcode_six_columns_five_last' );


// Divide Text Shortcode
function oita_shortcode_divider($atts, $content = null) {
	 return '<div class="divider"></div>';
}
add_shortcode( 'divider', 'oita_shortcode_divider' );

/*-----------------------------------------------------------------------------------*/
/* Text Highlight and Info Boxes Shortcodes
/*-----------------------------------------------------------------------------------*/

function oita_shortcode_white_box($atts, $content = null) {
	 return '<div class="white-box">' . do_shortcode( oita_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'white_box', 'oita_shortcode_white_box' );

function oita_shortcode_yellow_box($atts, $content = null) {
	 return '<div class="yellow-box">' . do_shortcode( oita_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'yellow_box', 'oita_shortcode_yellow_box' );

function oita_shortcode_red_box($atts, $content = null) {
	 return '<div class="red-box">' . do_shortcode( oita_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'red_box', 'oita_shortcode_red_box' );

function oita_shortcode_blue_box($atts, $content = null) {
	 return '<div class="blue-box">' . do_shortcode( oita_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'blue_box', 'oita_shortcode_blue_box' );

function oita_shortcode_green_box($atts, $content = null) {
	 return '<div class="green-box">' . do_shortcode( oita_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'green_box', 'oita_shortcode_green_box' );

function oita_shortcode_lightgrey_box($atts, $content = null) {
	 return '<div class="lightgrey-box">' . do_shortcode( oita_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'lightgrey_box', 'oita_shortcode_lightgrey_box' );

function oita_shortcode_grey_box($atts, $content = null) {
	 return '<div class="grey-box">' . do_shortcode( oita_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'grey_box', 'oita_shortcode_grey_box' );

function oita_shortcode_dark_box($atts, $content = null) {
	 return '<div class="dark-box">' . do_shortcode( oita_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'dark_box', 'oita_shortcode_dark_box' );

/*-----------------------------------------------------------------------------------*/
/* Buttons Shortcodes
/*-----------------------------------------------------------------------------------*/
function oita_button( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'link'	=> '#',
		'target' => '',
		'color'	=> '',
		'size'	=> '',
	 'form'	=> '',
	 'font'	=> '',
		), $atts));

	$color = ($color) ? ' '.$color. '-btn' : '';
	$size = ($size) ? ' '.$size. '-btn' : '';
	$form = ($form) ? ' '.$form. '-btn' : '';
	$font = ($font) ? ' '.$font. '-btn' : '';
	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<a' .$target. ' class="standard-btn' .$color.$size.$form.$font. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

		return $out;
}
add_shortcode('button', 'oita_button');

/*-----------------------------------------------------------------------------------*/
/* Include Oita Flickr Widget
/*-----------------------------------------------------------------------------------*/
class oita_flickr extends WP_Widget {

	public function __construct() {
		parent::__construct( 'oita_flickr', __( 'Oita Flickr', 'oita' ), array(
			'classname'   => 'widget_oita_flickr',
			'description' => __( 'Show your Flickr preview images', 'oita' ),
		) );
	}

	function widget($args, $instance) {
		/* __php8_keys */ $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'id' => '', 'number' => '', 'type' => '', 'sorting' => '' ) );
		extract( $args );
		$title = $instance['title'];
		$id = $instance['id'];
		$number = $instance['number'];
		$type = $instance['type'];
		$sorting = $instance['sorting'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

				<div class="flickr_badge_wrapper"><script type="text/javascript" src="https://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=<?php echo $sorting; ?>&amp;&amp;source=<?php echo $type; ?>&amp;<?php echo $type; ?>=<?php echo $id; ?>&amp;size=s"></script>
			<div class="clear"></div>
		</div><!-- end .flickr_badge_wrapper -->

		 <?php
		 echo $after_widget;
	 }

	 function update($new_instance, $old_instance) {
			 return $new_instance;
	 }

	 function form($instance) {
		/* __php8_keys */ $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'id' => '', 'number' => '', 'type' => '', 'sorting' => '' ) );
		$title = esc_attr($instance['title']);
		$id = esc_attr($instance['id']);
		$number = esc_attr($instance['number']);
		$type = esc_attr($instance['type']);
		$sorting = esc_attr($instance['sorting']);
		?>

		 <p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
				</p>

				<p>
						<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr ID:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" />
				</p>

				 <p>
						<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos:','oita'); ?></label>
						<select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
								<?php for ( $i = 1; $i <= 10; $i += 1) { ?>
								<option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
								<?php } ?>
						</select>
				</p>

				<p>
						<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Choose user or group:','oita'); ?></label>
						<select name="<?php echo $this->get_field_name('type'); ?>" class="widefat" id="<?php echo $this->get_field_id('type'); ?>">
								<option value="user" <?php if($type == "user"){ echo "selected='selected'";} ?>><?php _e('User', 'oita'); ?></option>
								<option value="group" <?php if($type == "group"){ echo "selected='selected'";} ?>><?php _e('Group', 'oita'); ?></option>
						</select>
				</p>
				<p>
						<label for="<?php echo $this->get_field_id('sorting'); ?>"><?php _e('Show latest or random pictures:','oita'); ?></label>
						<select name="<?php echo $this->get_field_name('sorting'); ?>" class="widefat" id="<?php echo $this->get_field_id('sorting'); ?>">
								<option value="latest" <?php if($sorting == "latest"){ echo "selected='selected'";} ?>><?php _e('Latest', 'oita'); ?></option>
								<option value="random" <?php if($sorting == "random"){ echo "selected='selected'";} ?>><?php _e('Random', 'oita'); ?></option>
						</select>
				</p>
		<?php
	}
}

register_widget('oita_flickr');


/*-----------------------------------------------------------------------------------*/
/* Include Oita About Widget
/*-----------------------------------------------------------------------------------*/

class oita_about extends WP_Widget {

	public function __construct() {
		parent::__construct( 'oita_about', __( 'Oita About', 'oita' ), array(
			'classname'   => 'widget_oita_about',
			'description' => __( 'About widget with picture and intro text', 'oita' ),
		) );
	}

	function widget($args, $instance) {
		/* __php8_keys */ $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'imageurl' => '', 'imagewidth' => '', 'imageheight' => '', 'aboutintro' => '', 'abouttext' => '' ) );
		extract( $args );
		$title = $instance['title'];
		$imageurl = $instance['imageurl'];
		$imagewidth = $instance['imagewidth'];
		$imageheight = $instance['imageheight'];
		$aboutintro = $instance['aboutintro'];
		$abouttext = $instance['abouttext'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

				<img src="<?php echo $imageurl; ?>" width="<?php echo $imagewidth; ?>" height="<?php echo $imageheight; ?>" class="about-image">
			<div class="about-text-wrap">
				<p class="about-intro"><?php echo $aboutintro; ?></p>
				<p class="about-text"><?php echo $abouttext; ?></p>
			</div><!-- end .about-text-wrap -->
		 <?php
		 echo $after_widget;
	 }

	 function update($new_instance, $old_instance) {
			 return $new_instance;
	 }

	 function form($instance) {
		/* __php8_keys */ $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'imageurl' => '', 'imagewidth' => '', 'imageheight' => '', 'aboutintro' => '', 'abouttext' => '' ) );
		$title = esc_attr($instance['title']);
		$imageurl = esc_attr($instance['imageurl']);
		$imagewidth = esc_attr($instance['imagewidth']);
		$imageheight = esc_attr($instance['imageheight']);
		$aboutintro = esc_attr($instance['aboutintro']);
		$abouttext = esc_attr($instance['abouttext']);
		?>

		 <p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
				</p>

			<p>
						<label for="<?php echo $this->get_field_id('imageurl'); ?>"><?php _e('Image URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('imageurl'); ?>" value="<?php echo $imageurl; ?>" class="widefat" id="<?php echo $this->get_field_id('imageurl'); ?>" />
				</p>

			<p>
						<label for="<?php echo $this->get_field_id('imagewidth'); ?>"><?php _e('Image Width (only value, no px):','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('imagewidth'); ?>" value="<?php echo $imagewidth; ?>" class="widefat" id="<?php echo $this->get_field_id('imagewidth'); ?>" />
				</p>

			 <p>
						<label for="<?php echo $this->get_field_id('imageheight'); ?>"><?php _e('Image Height (only value, no px):','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('imageheight'); ?>" value="<?php echo $imageheight; ?>" class="widefat" id="<?php echo $this->get_field_id('imageheight'); ?>" />
				</p>

				<p>
						<label for="<?php echo $this->get_field_id('aboutintro'); ?>"><?php _e('About Intro Text:','oita'); ?></label>
					 <textarea name="<?php echo $this->get_field_name('aboutintro'); ?>" class="widefat" rows="7" cols="20" id="<?php echo $this->get_field_id('aboutintro'); ?>"><?php echo( $aboutintro ); ?></textarea>
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('abouttext'); ?>"><?php _e('About Text:','oita'); ?></label>
					 <textarea name="<?php echo $this->get_field_name('abouttext'); ?>" class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('abouttext'); ?>"><?php echo( $abouttext ); ?></textarea>
				</p>

		<?php
	}
}

register_widget('oita_about');

/*-----------------------------------------------------------------------------------*/
/* Include Oita Video Widget
/*-----------------------------------------------------------------------------------*/

class oita_video extends WP_Widget {

	public function __construct() {
		parent::__construct( 'oita_video', __( 'Oita Featured Video', 'oita' ), array(
			'classname'   => 'widget_oita_video',
			'description' => __( 'Show a featured video', 'oita' ),
		) );
	}

	function widget($args, $instance) {
		/* __php8_keys */ $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'embedcode' => '' ) );
		extract( $args );
		$title = $instance['title'];
		$embedcode = $instance['embedcode'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

				<div class="video_widget">
			<div class="featured-video"><?php echo $embedcode; ?></div>
			</div><!-- end .video_widget -->

		 <?php
		 echo $after_widget;
	 }

	 function update($new_instance, $old_instance) {
			 return $new_instance;
	 }

	 function form($instance) {
		/* __php8_keys */ $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'embedcode' => '' ) );
		$title = esc_attr($instance['title']);
		$embedcode = esc_attr($instance['embedcode']);
		?>

		 <p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
				</p>

				<p>
						<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Video embed code:','oita'); ?></label>
				<textarea name="<?php echo $this->get_field_name('embedcode'); ?>" class="widefat" rows="6" id="<?php echo $this->get_field_id('embedcode'); ?>"><?php echo( $embedcode ); ?></textarea>
				</p>

		<?php
	}
}

register_widget('oita_video');


/*-----------------------------------------------------------------------------------*/
/* Including Oita Social Links Widget
/*-----------------------------------------------------------------------------------*/

 class oita_sociallinks extends WP_Widget {

	public function __construct() {
		parent::__construct( 'oita_sociallinks', __( 'Oita Social Links', 'oita' ), array(
			'classname'   => 'widget_oita_sociallinks',
			'description' => __( 'Link to your social profile sites', 'oita' ),
		) );
	}

	function widget($args, $instance) {
		/* __php8_keys */ $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'twitter' => '', 'facebook' => '', 'googleplus' => '', 'appnet' => '', 'flickr' => '', 'instagram' => '', 'picasa' => '', 'fivehundredpx' => '', 'youtube' => '', 'vimeo' => '', 'dribbble' => '', 'ffffound' => '', 'pinterest' => '', 'behance' => '', 'deviantart' => '', 'squidoo' => '', 'slideshare' => '', 'lastfm' => '', 'grooveshark' => '', 'soundcloud' => '', 'foursquare' => '', 'github' => '', 'linkedin' => '', 'xing' => '', 'wordpress' => '', 'tumblr' => '', 'rss' => '', 'rsscomments' => '', 'target' => '' ) );
		extract( $args );
		$title = $instance['title'];
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$googleplus = $instance['googleplus'];
		$appnet = $instance['appnet'];
		$flickr = $instance['flickr'];
		$instagram = $instance['instagram'];
		$picasa = $instance['picasa'];
		$fivehundredpx = $instance['fivehundredpx'];
		$youtube = $instance['youtube'];
		$vimeo = $instance['vimeo'];
		$dribbble = $instance['dribbble'];
		$ffffound = $instance['ffffound'];
		$pinterest = $instance['pinterest'];
		$behance = $instance['behance'];
		$deviantart = $instance['deviantart'];
		$squidoo = $instance['squidoo'];
		$slideshare = $instance['slideshare'];
		$lastfm = $instance['lastfm'];
		$grooveshark = $instance['grooveshark'];
		$soundcloud = $instance['soundcloud'];
		$foursquare = $instance['foursquare'];
		$github = $instance['github'];
		$linkedin = $instance['linkedin'];
		$xing = $instance['xing'];
		$wordpress = $instance['wordpress'];
		$tumblr = $instance['tumblr'];
		$rss = $instance['rss'];
		$rsscomments = $instance['rsscomments'];
		$target = $instance['target'];


		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

				<ul class="sociallinks">
			<?php
			if($twitter != '' && $target != ''){
				echo '<li><a href="'.$twitter.'" class="twitter" title="Twitter" target="_blank">Twitter</a></li>';
			} elseif($twitter != '') {
				echo '<li><a href="'.$twitter.'" class="twitter" title="Twitter">Twitter</a></li>';
			}
			?>

			<?php
			if($facebook != '' && $target != ''){
				echo '<li><a href="'.$facebook.'" class="facebook" title="Facebook" target="_blank">Facebook</a></li>';
			} elseif($facebook != '') {
				echo '<li><a href="'.$facebook.'" class="facebook" title="Facebook">Facebook</a></li>';
			}
			?>

			<?php
			if($googleplus != '' && $target != ''){
				echo '<li><a href="'.$googleplus.'" class="googleplus" title="Google+" target="_blank">Google+</a></li>';
			} elseif($googleplus != '') {
				echo '<li><a href="'.$googleplus.'" class="googleplus" title="Google+">Google+</a></li>';
			}
			?>

			<?php
			if($appnet != '' && $target != ''){
				echo '<li><a href="'.$appnet.'" class="appnet" title="App.net" target="_blank">App.net</a></li>';
			} elseif($appnet != '') {
				echo '<li><a href="'.$appnet.'" class="appnet" title="App.net">App.net</a></li>';
			}
			?>

			<?php if($flickr != '' && $target != ''){
				echo '<li><a href="'.$flickr.'" class="flickr" title="Flickr" target="_blank">Flickr</a></li>';
			} elseif($flickr != '') {
				echo '<li><a href="'.$flickr.'" class="flickr" title="Flickr">Flickr</a></li>';
			}
			?>

			<?php if($instagram != '' && $target != ''){
				echo '<li><a href="'.$instagram.'" class="instagram" title="Instagram" target="_blank">Instagram</a></li>';
			} elseif($instagram != '') {
				echo '<li><a href="'.$instagram.'" class="instagram" title="Instagram">Instagram</a></li>';
			}
			?>

			<?php if($picasa != '' && $target != ''){
				echo '<li><a href="'.$picasa.'" class="picasa" title="Picasa" target="_blank">Picasa</a></li>';
			} elseif($picasa != '') {
				echo '<li><a href="'.$picasa.'" class="picasa" title="Picasa">Picasa</a></li>';
			}
			?>

			<?php if($fivehundredpx != '' && $target != ''){
				echo '<li><a href="'.$fivehundredpx.'" class="fivehundredpx" title="500px" target="_blank">500px</a></li>';
			} elseif($fivehundredpx != '') {
				echo '<li><a href="'.$fivehundredpx.'" class="fivehundredpx" title="500px">500px</a></li>';
			}
			?>

			<?php if($youtube != '' && $target != ''){
			echo '<li><a href="'.$youtube.'" class="youtube" title="YouTube" target="_blank">YouTube</a></li>';
			} elseif($youtube != '') {
				echo '<li><a href="'.$youtube.'" class="youtube" title="YouTube">YouTube</a></li>';
			}
			?>

			<?php if($vimeo != '' && $target != ''){
			echo '<li><a href="'.$vimeo.'" class="vimeo" title="Vimeo" target="_blank">Vimeo</a></li>';
			} elseif($vimeo != '') {
				echo '<li><a href="'.$vimeo.'" class="vimeo" title="Vimeo">Vimeo</a></li>';
			}
			?>

			<?php if($dribbble != '' && $target != ''){
			echo '<li><a href="'.$dribbble.'" class="dribbble" title="Dribbble" target="_blank">Dribbble</a></li>';
			} elseif($dribbble != '') {
				echo '<li><a href="'.$dribbble.'" class="dribbble" title="Dribbble">Dribbble</a></li>';
			}
			?>

			<?php if($ffffound != '' && $target != ''){
			echo '<li><a href="'.$ffffound.'" class="ffffound" title="Ffffound" target="_blank">Ffffound</a></li>';
			} elseif($ffffound != '') {
				echo '<li><a href="'.$ffffound.'" class="ffffound" title="Ffffound">Ffffound</a></li>';
			}
			?>

			<?php if($pinterest != '' && $target != ''){
			echo '<li><a href="'.$pinterest.'" class="pinterest" title="Pinterest" target="_blank">Pinterest</a></li>';
			} elseif($pinterest != '') {
				echo '<li><a href="'.$pinterest.'" class="pinterest" title="Pinterest">Pinterest</a></li>';
			}
			?>

			<?php if($behance != '' && $target != ''){
				echo '<li><a href="'.$behance.'" class="behance" title="Behance Network" target="_blank">Behance Network</a></li>';
			} elseif($behance != '') {
				echo '<li><a href="'.$behance.'" class="behance" title="Behance Network">Behance Network</a></li>';
			}
			?>

			<?php if($deviantart != '' && $target != ''){
				echo '<li><a href="'.$deviantart.'" class="deviantart" title="deviantART" target="_blank">deviantART</a></li>';
			} elseif($deviantart != '') {
				echo '<li><a href="'.$deviantart.'" class="deviantart" title="deviantART">deviantART</a></li>';
			}
			?>

			<?php if($squidoo != '' && $target != ''){
				echo '<li><a href="'.$squidoo.'" class="squidoo" title="Squidoo" target="_blank">Squidoo</a></li>';
			} elseif($squidoo != '') {
				echo '<li><a href="'.$squidoo.'" class="squidoo" title="Squidoo">Squidoo</a></li>';
			}
			?>

			<?php if($slideshare != '' && $target != ''){
				echo '<li><a href="'.$slideshare.'" class="slideshare" title="Slideshare" target="_blank">Slideshare</a></li>';
			} elseif($slideshare != '') {
				echo '<li><a href="'.$slideshare.'" class="slideshare" title="Slideshare">Slideshare</a></li>';
			}
			?>

			<?php if($lastfm != '' && $target != ''){
				echo '<li><a href="'.$lastfm.'" class="lastfm" title="Lastfm" target="_blank">Lastfm</a></li>';
			} elseif($lastfm != '') {
				echo '<li><a href="'.$lastfm.'" class="lastfm" title="Lastfm">Lastfm</a></li>';
			}
			?>

			<?php if($grooveshark != '' && $target != ''){
				echo '<li><a href="'.$grooveshark.'" class="grooveshark" title="Grooveshark" target="_blank">Grooveshark</a></li>';
			} elseif($grooveshark != '') {
				echo '<li><a href="'.$grooveshark.'" class="grooveshark" title="Grooveshark">Grooveshark</a></li>';
			}
			?>

			<?php if($soundcloud != '' && $target != ''){
				echo '<li><a href="'.$soundcloud.'" class="soundcloud" title="Soundcloud" target="_blank">Soundcloud</a></li>';
			} elseif($soundcloud != '') {
				echo '<li><a href="'.$soundcloud.'" class="soundcloud" title="Soundcloud">Soundcloud</a></li>';
			}
			?>

			<?php if($foursquare != '' && $target != ''){
				echo '<li><a href="'.$foursquare.'" class="foursquare" title="Foursquare" target="_blank">Foursquare</a></li>';
			} elseif($foursquare != '') {
				echo '<li><a href="'.$foursquare.'" class="foursquare" title="Foursquare">Foursquare</a></li>';
			}
			?>

			<?php if($github != '' && $target != ''){
				echo '<li><a href="'.$github.'" class="github" title="GitHub" target="_blank">GitHub</a></li>';
			} elseif($github != '') {
				echo '<li><a href="'.$github.'" class="github" title="GitHub">GitHub</a></li>';
			}
			?>

			<?php if($linkedin != '' && $target != ''){
				echo '<li><a href="'.$linkedin.'" class="linkedin" title="LinkedIn" target="_blank">LinkedIn</a></li>';
			} elseif($linkedin != '') {
				echo '<li><a href="'.$linkedin.'" class="linkedin" title="LinkedIn">LinkedIn</a></li>';
			}
			?>

			<?php if($xing != '' && $target != ''){
				echo '<li><a href="'.$xing.'" class="xing" title="Xing" target="_blank">Xing</a></li>';
			} elseif($xing != '') {
				echo '<li><a href="'.$xing.'" class="xing" title="Xing">Xing</a></li>';
			}
			?>

			<?php if($wordpress != '' && $target != ''){
				echo '<li><a href="'.$wordpress.'" class="wordpress" title="WordPress" target="_blank">WordPress</a></li>';
			} elseif($wordpress != '') {
				echo '<li><a href="'.$wordpress.'" class="wordpress" title="WordPress">WordPress</a></li>';
			}
			?>

			<?php if($tumblr != '' && $target != ''){
				echo '<li><a href="'.$tumblr.'" class="tumblr" title="Tumblr" target="_blank">Tumblr</a></li>';
			} elseif($tumblr != '') {
				echo '<li><a href="'.$tumblr.'" class="tumblr" title="Tumblr">Tumblr</a></li>';
			}
			?>

			<?php if($rss != '' && $target != ''){
				echo '<li><a href="'.$rss.'" class="rss" title="RSS Feed" target="_blank">RSS Feed</a></li>';
			} elseif($rss != '') {
				echo '<li><a href="'.$rss.'" class="rss" title="RSS Feed">RSS Feed</a></li>';
			}
			?>

			<?php if($rsscomments != '' && $target != ''){
				echo '<li><a href="'.$rsscomments.'" class="rsscomments" title="RSS Comments" target="_blank">RSS Comments</a></li>';
			} elseif($rsscomments != '') {
				echo '<li><a href="'.$rsscomments.'" class="rsscomments" title="RSS Comments">RSS Comments</a></li>';
			}
			?>

		</ul><!-- end .sociallinks -->

		 <?php
		 echo $after_widget;
	 }

	 function update($new_instance, $old_instance) {
			 return $new_instance;
	 }

	 function form($instance) {
		/* __php8_keys */ $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'twitter' => '', 'facebook' => '', 'googleplus' => '', 'appnet' => '', 'flickr' => '', 'instagram' => '', 'picasa' => '', 'fivehundredpx' => '', 'youtube' => '', 'vimeo' => '', 'dribbble' => '', 'ffffound' => '', 'pinterest' => '', 'behance' => '', 'deviantart' => '', 'squidoo' => '', 'slideshare' => '', 'lastfm' => '', 'grooveshark' => '', 'soundcloud' => '', 'foursquare' => '', 'github' => '', 'linkedin' => '', 'xing' => '', 'wordpress' => '', 'tumblr' => '', 'rss' => '', 'rsscomments' => '', 'target' => '' ) );
		$title = esc_attr($instance['title']);
		$twitter = esc_attr($instance['twitter']);
		$facebook = esc_attr($instance['facebook']);
		$googleplus = esc_attr($instance['googleplus']);
		$appnet = esc_attr($instance['appnet']);
		$flickr = esc_attr($instance['flickr']);
		$instagram = esc_attr($instance['instagram']);
		$picasa = esc_attr($instance['picasa']);
		$fivehundredpx = esc_attr($instance['fivehundredpx']);
		$youtube = esc_attr($instance['youtube']);
		$vimeo = esc_attr($instance['vimeo']);
		$dribbble = esc_attr($instance['dribbble']);
		$ffffound = esc_attr($instance['ffffound']);
		$pinterest = esc_attr($instance['pinterest']);
		$behance = esc_attr($instance['behance']);
		$deviantart = esc_attr($instance['deviantart']);
		$squidoo = esc_attr($instance['squidoo']);
		$slideshare = esc_attr($instance['slideshare']);
		$lastfm = esc_attr($instance['lastfm']);
		$grooveshark = esc_attr($instance['grooveshark']);
		$soundcloud = esc_attr($instance['soundcloud']);
		$foursquare = esc_attr($instance['foursquare']);
		$github = esc_attr($instance['github']);
		$linkedin = esc_attr($instance['linkedin']);
		$xing = esc_attr($instance['xing']);
		$wordpress = esc_attr($instance['wordpress']);
		$tumblr = esc_attr($instance['tumblr']);
		$rss = esc_attr($instance['rss']);
		$rsscomments = esc_attr($instance['rsscomments']);
		$target = esc_attr($instance['target']);

		?>

		 <p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google+ URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('googleplus'); ?>" value="<?php echo $googleplus; ?>" class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" />
				</p>

			<p>
						<label for="<?php echo $this->get_field_id('appnet'); ?>"><?php _e('App.net URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('appnet'); ?>" value="<?php echo $appnet; ?>" class="widefat" id="<?php echo $this->get_field_id('appnet'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo $flickr; ?>" class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" />
				</p>

		 <p>
						<label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo $instagram; ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('picasa'); ?>"><?php _e('Picasa URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('picasa'); ?>" value="<?php echo $picasa; ?>" class="widefat" id="<?php echo $this->get_field_id('picasa'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('fivehundredpx'); ?>"><?php _e('500px URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('fivehundredpx'); ?>" value="<?php echo $fivehundredpx; ?>" class="widefat" id="<?php echo $this->get_field_id('fivehundredpx'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $youtube; ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php _e('Vimeo URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo $vimeo; ?>" class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e('Dribbble URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('dribbble'); ?>" value="<?php echo $dribbble; ?>" class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('ffffound'); ?>"><?php _e('Ffffound URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('ffffound'); ?>" value="<?php echo $ffffound; ?>" class="widefat" id="<?php echo $this->get_field_id('ffffound'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo $pinterest; ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('behance'); ?>"><?php _e('Behance Network URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('behance'); ?>" value="<?php echo $behance; ?>" class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" />
				</p>

		 <p>
						<label for="<?php echo $this->get_field_id('deviantart'); ?>"><?php _e('deviantART URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('deviantart'); ?>" value="<?php echo $deviantart; ?>" class="widefat" id="<?php echo $this->get_field_id('deviantart'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('squidoo'); ?>"><?php _e('Squidoo URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('squidoo'); ?>" value="<?php echo $squidoo; ?>" class="widefat" id="<?php echo $this->get_field_id('squidoo'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('slideshare'); ?>"><?php _e('Slideshare URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('slideshare'); ?>" value="<?php echo $slideshare; ?>" class="widefat" id="<?php echo $this->get_field_id('slideshare'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('lastfm'); ?>"><?php _e('Last.fm URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('lastfm'); ?>" value="<?php echo $lastfm; ?>" class="widefat" id="<?php echo $this->get_field_id('lastfm'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('grooveshark'); ?>"><?php _e('Grooveshark URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('grooveshark'); ?>" value="<?php echo $grooveshark; ?>" class="widefat" id="<?php echo $this->get_field_id('grooveshark'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php _e('Soundcloud URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('soundcloud'); ?>" value="<?php echo $soundcloud; ?>" class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php _e('Foursquare URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('foursquare'); ?>" value="<?php echo $foursquare; ?>" class="widefat" id="<?php echo $this->get_field_id('foursquare'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('github'); ?>"><?php _e('GitHub URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('github'); ?>" value="<?php echo $github; ?>" class="widefat" id="<?php echo $this->get_field_id('github'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo $linkedin; ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('xing'); ?>"><?php _e('Xing URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('xing'); ?>" value="<?php echo $xing; ?>" class="widefat" id="<?php echo $this->get_field_id('xing'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('wordpress'); ?>"><?php _e('WordPress URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('wordpress'); ?>" value="<?php echo $wordpress; ?>" class="widefat" id="<?php echo $this->get_field_id('wordpress'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e('Tumblr URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('tumblr'); ?>" value="<?php echo $tumblr; ?>" class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS-Feed URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo $rss; ?>" class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('rsscomments'); ?>"><?php _e('RSS for Comments URL:','oita'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('rsscomments'); ?>" value="<?php echo $rsscomments; ?>" class="widefat" id="<?php echo $this->get_field_id('rsscomments'); ?>" />
				</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['target'], true ); ?> id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" <?php checked( $target, 'on' ); ?>> <?php _e('Open all links in a new browser tab', 'oita'); ?></input>
		</p>

		<?php
	}
}

register_widget('oita_sociallinks');

/* __php8_option_defaults: never let the theme options be false or miss a key (PHP 8). */
function oita_php8_option_defaults( $options = array() ) {
	$fallback = array_fill_keys( array( 'share-pages', 'custom_favicon', 'custom_apple_icon', 'custom_logo', 'link_color', 'extrafont_color', 'sidebarbg_color', 'bg_color', 'show-excerpt', 'custom_footertext', 'custom_authorlinks', 'share-posts', 'share-singleposts', 'custom-css' ), '' );
	if ( function_exists( 'oita_get_default_theme_options' ) ) {
		$fallback = array_merge( $fallback, (array) oita_get_default_theme_options() );
	}
	return wp_parse_args( is_array( $options ) ? $options : array(), $fallback );
}
add_filter( 'default_option_oita_theme_options', 'oita_php8_option_defaults' );
add_filter( 'option_oita_theme_options', 'oita_php8_option_defaults' );
