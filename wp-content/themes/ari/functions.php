<?php
/**
 * Hawea functions and definitions
 *
 * @package Ari
 */

/* Make theme available for translation */
/* Translations can be filed in the /languages/ directory */
load_theme_textdomain( 'ari', get_template_directory() . '/languages' );

/* Set the content width based on the theme's design and stylesheet. */
if ( ! isset( $content_width ) )
	$content_width = 450;

/* Tell WordPress to run ari_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'ari_setup' );

if ( ! function_exists( 'ari_setup' ) ):

function ari_setup() {

	/* This theme styles the visual editor with editor-style.css to match the theme style. */
	add_editor_style();
	
	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );
	
	/* This theme uses post thumbnails */
	add_theme_support( 'post-thumbnails' );

	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

	/* This theme uses wp_nav_menu() in one location. */
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'ari'),
	) );
	
	// Implement the Custom Header feature
	require get_template_directory() . '/inc/custom-header.php';

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'ari_custom_background_args', array(
		'default-color'	=> 'ffffff',
		'default-image'	=> '',
	) ) );

}
endif;

/* Enqueue scripts and styles */
function ari_scripts() {
	global $wp_styles;


	// Loads JavaScript to pages with the comment form to support sites with threaded comments (when in use)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );

	// Loads main stylesheet.
	wp_enqueue_style( 'ari-style', get_stylesheet_uri(), array(), '20160207' );
	
	// Loads dark stylesheet
	if ( get_theme_mod ( 'dark_theme' ) )
	wp_enqueue_style( 'ari-dark-style', get_template_directory_uri() . '/css/dark.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'ari_scripts' );


/* Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link. */
function ari_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'ari_page_menu_args' );


/* Sets the post excerpt length to 40 characters. */
function ari_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'ari_excerpt_length' );


/* Returns a "Continue Reading" link for excerpts */
function ari_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'ari' ) . '</a>';
}

/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and ari_continue_reading_link(). */
function ari_auto_excerpt_more( $more ) {
	return ' &hellip;' . ari_continue_reading_link();
}
add_filter( 'excerpt_more', 'ari_auto_excerpt_more' );

/* Adds a pretty "Continue Reading" link to custom post excerpts. */
function ari_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= ari_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'ari_custom_excerpt_more' );


if ( ! function_exists( 'ari_comment' ) ) :

/*  Search form custom styling */
function ari_search_form( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="'.home_url().'" >
    <input type="text" class="search-input" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search', 'ari') .'" />
    </form>';

    return $form;
}
add_filter( 'get_search_form', 'ari_search_form' );

/* Template for comments and pingbacks. */
function ari_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-gravatar"><?php echo get_avatar( $comment, 50 ); ?></div>
		
		<div class="comment-body">
		<div class="comment-meta commentmetadata"><?php printf( __( '%s <span class="says">says</span>', 'ari' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?> <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'ari' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( 'Edit &rarr;', 'ari' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<?php comment_text(); ?>
		
		<?php if ( $comment->comment_approved == '0' ) : ?>
		<p class="moderation"><?php _e( 'Your comment is awaiting moderation.', 'ari' ); ?></p>
		<?php endif; ?>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
		
		</div>
		<!--comment Body-->
		
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'ari' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'ari'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;


/* Register widgetized areas, including two sidebars and four widget-ready columns in the footer. */
function ari_widgets_init() {
	// Primary Widget area (left, fixed sidebar)
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'ari' ),
		'id' => 'primary-widget-area',
		'description' => __( 'Here you can put one or two of your main widgets (like an intro text, your page navigation or some social site links) in your left sidebar. The sidebar is fixed, so the widgets content will always be visible, even when scrolling down the page.', 'ari' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Secondary Widget area (right, additional sidebar)
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'ari' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'Here you can put all the additional widgets for your right sidebar.', 'ari' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
/* Register sidebars by running ari_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'ari_widgets_init' );


if ( ! function_exists( 'ari_posted_on' ) ) :
/* Prints HTML with meta information for the current post—date/time and author. */
function ari_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'ari' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'ari' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

/* Custom Ari Social Links Widget */
class Ari_SocialLinks_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct( 'social_links', __( 'Ari Social Links', 'ari' ), array(
			'classname'   => 'widget_social_links',
			'description' => __( 'A list with your social profile links', 'ari' ),
		) );
	}
	
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		
		$rss_title = empty($instance['rss_title']) ? ' ' : apply_filters('widget_rss_title', $instance['rss_title']);	
		$rss_url = empty($instance['rss_url']) ? ' ' : apply_filters('widget_rss_url', $instance['rss_url']);
		$twitter_title = empty($instance['twitter_title']) ? ' ' : apply_filters('widget_twitter_title', $instance['twitter_title']);	
		$twitter_url = empty($instance['twitter_url']) ? ' ' : apply_filters('widget_twitter_url', $instance['twitter_url']);	
		$fb_title = empty($instance['fb_title']) ? ' ' : apply_filters('widget_fb_title', $instance['fb_title']);
		$fb_url = empty($instance['fb_url']) ? ' ' : apply_filters('widget_fb_url', $instance['fb_url']);
		$googleplus_title = empty($instance['googleplus_title']) ? ' ' : apply_filters('widget_googleplus_title', $instance['googleplus_title']);
		$googleplus_url = empty($instance['googleplus_url']) ? ' ' : apply_filters('widget_googleplus_url', $instance['googleplus_url']);
		$flickr_title = empty($instance['flickr_title']) ? ' ' : apply_filters('widget_flickr_title', $instance['flickr_title']);
		$flickr_url = empty($instance['flickr_url']) ? ' ' : apply_filters('widget_flickr_url', $instance['flickr_url']);
		$vimeo_title = empty($instance['vimeo_title']) ? ' ' : apply_filters('widget_vimeo_title', $instance['vimeo_title']);
		$vimeo_url = empty($instance['vimeo_url']) ? ' ' : apply_filters('widget_vimeo_url', $instance['vimeo_url']);
		$xing_title = empty($instance['xing_title']) ? ' ' : apply_filters('widget_xing_title', $instance['xing_title']);
		$xing_url = empty($instance['xing_url']) ? ' ' : apply_filters('widget_xing_url', $instance['xing_url']);
		$linkedin_title = empty($instance['linkedin_title']) ? ' ' : apply_filters('widget_linkedin_title', $instance['linkedin_title']);
		$linkedin_url = empty($instance['linkedin_url']) ? ' ' : apply_filters('widget_linkedin_url', $instance['linkedin_url']);
		$delicious_title = empty($instance['delicious_title']) ? ' ' : apply_filters('widget_delicious_title', $instance['delicious_title']);
		$delicious_url = empty($instance['delicious_url']) ? ' ' : apply_filters('widget_delicious_url', $instance['delicious_url']);
		
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo '<ul>';
	if($rss_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href=" '. $rss_url .'" class="rss" target="_blank">'. $rss_title .'</a></li>'; }
		if($twitter_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href=" '. $twitter_url .'" class="twitter" target="_blank">'. $twitter_title .'</a></li>'; }
		if($fb_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href=" '. $fb_url .'" class="facebook" target="_blank">'. $fb_title .'</a></li>'; }
		if($googleplus_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href=" '. $googleplus_url .'" class="googleplus" target="_blank">'. $googleplus_title .'</a></li>'; }
		if($flickr_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href=" '. $flickr_url .'" class="flickr" target="_blank">'. $flickr_title .'</a></li>'; }
		if($vimeo_title == ' ') { echo ''; } else {  echo  '  <li class="widget_sociallinks"><a href=" '. $vimeo_url .'" class="vimeo" target="_blank">'. $vimeo_title .'</a></li>'; }
		if($xing_title == ' ') { echo ''; } else {  echo  '  <li class="widget_sociallinks"><a href=" '. $xing_url .'" class="xing" target="_blank">'. $xing_title .'</a></li>'; }
		if($linkedin_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href=" '. $linkedin_url .'" class="linkedin" target="_blank">'. $linkedin_title .'</a></li>'; }
		if($delicious_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href=" '. $delicious_url .'" class="delicious" target="_blank">'. $delicious_title .'</a></li>'; }
		echo '</ul>';
		echo $after_widget;
		
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		$instance['rss_title'] = strip_tags($new_instance['rss_title']);
		$instance['rss_url'] = strip_tags($new_instance['rss_url']);
		$instance['twitter_title'] = strip_tags($new_instance['twitter_title']);
		$instance['twitter_url'] = strip_tags($new_instance['twitter_url']);
		$instance['fb_title'] = strip_tags($new_instance['fb_title']);
		$instance['fb_url'] = strip_tags($new_instance['fb_url']);
		$instance['googleplus_title'] = strip_tags($new_instance['googleplus_title']);
		$instance['googleplus_url'] = strip_tags($new_instance['googleplus_url']);
		$instance['flickr_title'] = strip_tags($new_instance['flickr_title']);
		$instance['flickr_url'] = strip_tags($new_instance['flickr_url']);
		$instance['vimeo_title'] = strip_tags($new_instance['vimeo_title']);
		$instance['vimeo_url'] = strip_tags($new_instance['vimeo_url']);		
		$instance['xing_title'] = strip_tags($new_instance['xing_title']);
		$instance['xing_url'] = strip_tags($new_instance['xing_url']);
		$instance['linkedin_title'] = strip_tags($new_instance['linkedin_title']);
		$instance['linkedin_url'] = strip_tags($new_instance['linkedin_url']);
		$instance['delicious_title'] = strip_tags($new_instance['delicious_title']);
		$instance['delicious_url'] = strip_tags($new_instance['delicious_url']);
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args(
		(array) $instance, array( 
			'title' => '',
			'rss_title' => '',
			'rss_url' => '',
			'twitter_title' => '',
			'twitter_url' => '',
			'fb_title' => '',
			'fb_url' => '',
			'googleplus_title' => '',
			'googleplus_url' => '',
			'flickr_title' => '',
			'flickr_url' => '',
			'vimeo_title' => '',
			'vimeo_url' => '',
			'xing_title' => '',
			'xing_url' => '',
			'linkedin_title' => '',
			'linkedin_url' => '',
			'delicious_title' => '',
			'delicious_url' => ''
		) );
		$title = strip_tags($instance['title']);	
		$rss_title = strip_tags($instance['rss_title']);
		$rss_url = strip_tags($instance['rss_url']);
		$twitter_title = strip_tags($instance['twitter_title']);
		$twitter_url = strip_tags($instance['twitter_url']);
		$fb_title = strip_tags($instance['fb_title']);
		$fb_url = strip_tags($instance['fb_url']);
		$googleplus_title = strip_tags($instance['googleplus_title']);
		$googleplus_url = strip_tags($instance['googleplus_url']);
		$flickr_title = strip_tags($instance['flickr_title']);
		$flickr_url = strip_tags($instance['flickr_url']);
		$vimeo_title = strip_tags($instance['vimeo_title']);
		$vimeo_url = strip_tags($instance['vimeo_url']);
		$xing_title = strip_tags($instance['xing_title']);
		$xing_url = strip_tags($instance['xing_url']);
		$linkedin_title = strip_tags($instance['linkedin_title']);
		$linkedin_url = strip_tags($instance['linkedin_url']);
		$delicious_title = strip_tags($instance['delicious_title']);
		$delicious_url = strip_tags($instance['delicious_url']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('rss_title'); ?>"><?php _e( 'RSS Text:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('rss_title'); ?>" name="<?php echo $this->get_field_name('rss_title'); ?>" type="text" value="<?php echo esc_attr($rss_title); ?>" /></label></p>	
			<p><label for="<?php echo $this->get_field_id('rss_url'); ?>"><?php _e( 'RSS  URL:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('rss_url'); ?>" name="<?php echo $this->get_field_name('rss_url'); ?>" type="text" value="<?php echo esc_attr($rss_url); ?>" /></label></p>	
			<p><label for="<?php echo $this->get_field_id('twitter_title'); ?>"><?php _e( 'Twitter Text:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('twitter_title'); ?>" name="<?php echo $this->get_field_name('twitter_title'); ?>" type="text" value="<?php echo esc_attr($twitter_title); ?>" /></label></p>	
			<p><label for="<?php echo $this->get_field_id('twitter_url'); ?>"><?php _e( 'Twitter  URL:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('twitter_url'); ?>" name="<?php echo $this->get_field_name('twitter_url'); ?>" type="text" value="<?php echo esc_attr($twitter_url); ?>" /></label></p>	
			<p><label for="<?php echo $this->get_field_id('fb_title'); ?>"><?php _e( 'Facebook Text:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('fb_title'); ?>" name="<?php echo $this->get_field_name('fb_title'); ?>" type="text" value="<?php echo esc_attr($fb_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('fb_url'); ?>"><?php _e( 'Facebook URL:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('fb_url'); ?>" name="<?php echo $this->get_field_name('fb_url'); ?>" type="text" value="<?php echo esc_attr($fb_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('googleplus_title'); ?>"><?php _e( 'Google+ Text:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('googleplus_title'); ?>" name="<?php echo $this->get_field_name('googleplus_title'); ?>" type="text" value="<?php echo esc_attr($googleplus_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('googleplus_url'); ?>"><?php _e( 'Google+ URL:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('googleplus_url'); ?>" name="<?php echo $this->get_field_name('googleplus_url'); ?>" type="text" value="<?php echo esc_attr($googleplus_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('flickr_title'); ?>"><?php _e( 'Flickr Text:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('flickr_title'); ?>" name="<?php echo $this->get_field_name('flickr_title'); ?>" type="text" value="<?php echo esc_attr($flickr_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('flickr_url'); ?>"><?php _e( 'Flickr URL:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('flickr_url'); ?>" name="<?php echo $this->get_field_name('flickr_url'); ?>" type="text" value="<?php echo esc_attr($flickr_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('vimeo_title'); ?>"><?php _e( 'Vimeo Text:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('vimeo_title'); ?>" name="<?php echo $this->get_field_name('vimeo_title'); ?>" type="text" value="<?php echo esc_attr($vimeo_title); ?>" /></label></p>	
			<p><label for="<?php echo $this->get_field_id('vimeo_url'); ?>"><?php _e( 'Vimeo URL:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('vimeo_url'); ?>" name="<?php echo $this->get_field_name('vimeo_url'); ?>" type="text" value="<?php echo esc_attr($vimeo_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('xing_title'); ?>"><?php _e( 'Xing Text:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('xing_title'); ?>" name="<?php echo $this->get_field_name('xing_title'); ?>" type="text" value="<?php echo esc_attr($xing_title); ?>" /></label></p>	
			<p><label for="<?php echo $this->get_field_id('xing_url'); ?>"><?php _e( 'Xing URL:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('xing_url'); ?>" name="<?php echo $this->get_field_name('xing_url'); ?>" type="text" value="<?php echo esc_attr($xing_url); ?>" /></label></p>		
			<p><label for="<?php echo $this->get_field_id('linkedin_title'); ?>"><?php _e( 'LinkedIn Text:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('linkedin_title'); ?>" name="<?php echo $this->get_field_name('linkedin_title'); ?>" type="text" value="<?php echo esc_attr($linkedin_title); ?>" /></label></p>		
			<p><label for="<?php echo $this->get_field_id('linkedin_url'); ?>"><?php _e( 'LinkedIn URL:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('linkedin_url'); ?>" name="<?php echo $this->get_field_name('linkedin_url'); ?>" type="text" value="<?php echo esc_attr($linkedin_url); ?>" /></label></p>	
			<p><label for="<?php echo $this->get_field_id('delicious_title'); ?>"><?php _e( 'Delicious Text:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('delicious_title'); ?>" name="<?php echo $this->get_field_name('delicious_title'); ?>" type="text" value="<?php echo esc_attr($delicious_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('delicious_url'); ?>"><?php _e( 'Delicious URL:', 'ari' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('delicious_url'); ?>" name="<?php echo $this->get_field_name('delicious_url'); ?>" type="text" value="<?php echo esc_attr($delicious_url); ?>" /></label></p>

<?php
	}
}

// register Ari SocialLinks Widget
add_action('widgets_init', create_function('', 'return register_widget("Ari_SocialLinks_Widget");'));


// Custom CSS Styles
function ari_customize_css() {
    ?>
	<style type="text/css">
	<?php if ('#ffffff' != get_theme_mod( 'background_color' ) ) { ?>
		#site-navigation {background:#<?php echo get_theme_mod('background_color', '#ffffff'); ?>;}
	<?php } ?>
	<?php if ('#88C34B' != get_theme_mod( 'link_color' ) ) { ?>
	a,
	ul.sidebar li.widget_text a,
	#content h2 a:hover,
	ul.sidebar a:hover,
	.comment-meta a:hover,
	p.logged-in-as a:hover,
	p.meta a:hover,
	a.post-edit-link:hover,
	#footer a:hover
	{ color: <?php echo get_theme_mod('link_color', '#000000'); ?>;}
	<?php } ?>
	<?php if ('#4C4C4C' != get_theme_mod( 'text_color' ) ) { ?>
	body, #content h2 a { color: <?php echo get_theme_mod('text_color', '#000000'); ?>; }
	<?php } ?>
	</style>
    <?php
}
add_action( 'wp_head', 'ari_customize_css');


/* Remove the default CSS style from the WP image gallery */
add_filter('gallery_style', create_function('$a', 'return "
<div class=\'gallery\'>";'));


/* Customizer additions */
require get_template_directory() . '/inc/customizer.php';
