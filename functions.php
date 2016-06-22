<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');

// Customize the Admin Pages
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');
function my_admin_theme_style() {
  wp_enqueue_style('my-admin-theme', get_template_directory_uri() . '/css/wp-admin.css');
}

//Add TinyMCI Editor Options
add_theme_support( 'editor_style' );
add_action( 'init', 'my_admin_editor_options' );
function my_admin_editor_options() {
    add_editor_style('css/editor-style.css');
}

// enables wigitized sidebars
if ( function_exists('register_sidebar') )
// Sidebar Widget
register_sidebar(array('name'=>'Sidebar',
	'before_widget' => '<div class="widget-area widget-sidebar"><ul>',
	'after_widget' => '</ul></div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));

// post thumbnail support
add_theme_support( 'post-thumbnails' );

// custom menu support
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'header-menu' => 'Header Menu',
      'side-menu' => 'Side Menu'
		)
	);
}

// removes detailed login error information for security
add_filter('login_errors',create_function('$a', "return null;"));

add_filter('the_excerpt', 'excerpt_read_more_link');
function excerpt_read_more_link($output) {
 global $post;
 return $output . '<a href="'.get_permalink($post->ID).'" class="read-more">'.'Keep reading &rarr;'.'</a>';
}

// custom excerpt ellipses for 2.9+
add_filter('excerpt_more', 'custom_excerpt_more');
function custom_excerpt_more($more) {
  return '&hellip;';
}


// Use Bootstrap pager formatting for nav links
function bootstrap_get_posts_nav_link( $args = array() ) {
	global $wp_query;
	$return = '';

	if ( !is_singular() ) {
		$defaults = array(
			'prelabel' => __('&larr; Previous Page'),
			'nxtlabel' => __('Next Page &rarr;'),
		);
		$args = wp_parse_args( $args, $defaults );
		$max_num_pages = $wp_query->max_num_pages;
		$paged = get_query_var('paged');

		if ( $max_num_pages > 1 ) {
			$return = '<ul class="pager"><li class="previous">';
			$return .= get_previous_posts_link($args['prelabel']);
			$return .= '</li><li class="next">';
			$return .= get_next_posts_link($args['nxtlabel']);
			$return .= '</li></ul>';
		}
	}
	return $return;
}
function bootstrap_posts_nav_link( $prelabel = '', $nxtlabel = '' ) {
	$args = array_filter( compact('prelabel', 'nxtlabel') );
	echo bootstrap_get_posts_nav_link($args);
}

// get the slug
function the_slug($echo=true){
	global $post;
	$slug = $post->post_name;
  if( $echo ) echo $slug;
  return $slug;
}

// Remove <br> from wpautop
//Author: Simon Battersby http://www.simonbattersby.com/blog/plugin-to-stop-wordpress-adding-br-tags/
function better_wpautop($pee){
	return wpautop($pee,false);
}
remove_filter( 'the_content', 'wpautop');
add_filter( 'the_content', 'better_wpautop');
add_filter( 'the_content', 'shortcode_unautop');

add_action('pre_get_posts', 'remove_p_from_pages');
function remove_p_from_pages() {
  if (is_page()) { 
    remove_filter ('the_content',  'better_wpautop');
  }
}

// Spit out icons for all the social icons that have links
function landia_social_icons_row($page) {
  $socialMedias = array ('facebook', 'instagram', 'twitter', 'flickr', 'linkedin', 'vimeo', 'googlePlus', 'pinterest', 'youtube');
  $return = '';
  foreach ($socialMedias as $socialMedia) {
    $socialMediaLink = esc_html( get_post_meta( $page, $socialMedia, true ) );
    $letter = landia_social_icons_letter($socialMedia);
    if ($socialMediaLink) {
      $return .= '<a href="'.esc_attr($socialMediaLink).'" class="socicon" title="'.ucfirst(esc_attr($socialMedia)).'">'.$letter.'</a> ';
    };
  }
  return $return;
}

// Set social media icon letter with social media
function landia_social_icons_letter($icon) {
  $socialMedias = array ( 'facebook' => 'b',
                          'instagram' => 'x',
                          'twitter' => 'a',
                          'flickr' => 'v',
                          'linkedin' => 'j',
                          'vimeo' => 's',
                          'googlePlus' => 'c',
                          'pinterest' => 'd',
                          'youtube' => 'r'
                        );
  return array_key_exists($icon, $socialMedias)? $socialMedias[$icon] : false; 
}

// Add items to the Side Navigation
add_filter('wp_nav_menu_items','landia_add_nav_item', 10, 2);
function landia_add_nav_item($items, $args) {
  if( $args->theme_location == 'side-menu' ) {
    // Get dynamic email address
    $contactID = get_page_by_title('Contact')->ID;
    $contactEmail = esc_html( get_post_meta( $contactID, 'contact_email', true ) );
    $emailArray = explode('@',$contactEmail);
    $emailDomain = $emailArray[1];
    $emailPrefix = $emailArray[0];
    //save menu items and add them after the redefined items
    $menuItems = $items;
    $items = '<a href="http://www.rifflandia.com"><div class="side-menu-box rifflandia"></div></a>
              <a href="http://www.thinklandia.ca"><div class="side-menu-box thinklandia"></div></a>
              <a href="http://www.artlandia.ca"><div class="side-menu-box artlandia"></div></a>
              <a href="http://www.makelandia.ca"><div class="side-menu-box makelandia"></div></a>
              <div class="clearfix"></div>';
    $items .= $menuItems;
    $items .= '<li class="social-icons">';
    $items .= landia_social_icons_row($contactID);
    $items .= '<a class="glyphicon glyphicon-envelope mailto" title="Email" data-domain="'.$emailDomain.'" data-prefix="'.$emailPrefix.'" data-text=" "></a></li>';
  }
  return $items;
}

//Send Yoast to the bottom
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');
function yoasttobottom() {
  return 'low';
}

// Setup Post 2 Post
add_action( 'p2p_init', 'my_connection_types' );
function my_connection_types() {
  p2p_register_connection_type( array( 
    'name' => 'Speakers and Events',
    'from' => 'speakers',
    'to' => 'events',
    'reciprocal' => true,
    'title' => 'Speakers + Events'
  ) );
}

// Shortcodes - Bootstrap /////////////////////////////////////
// Bootstrap row
add_shortcode( 'row', 'bootstrap_row' );
function bootstrap_row( $atts, $content = null ) {
  return '<div class="row">'. do_shortcode($content) . '</div>';
}

// full_col column
add_shortcode( 'full_col', 'bootstrap_full_col' );
function bootstrap_full_col( $atts, $content = null ) {
  return '<div class="col-sm-12">'. do_shortcode($content) . '</div>';
}

// half_col column
add_shortcode( 'half_col', 'bootstrap_half_col' );
function bootstrap_half_col( $atts, $content = null ) {
  return '<div class="col-sm-6">'. do_shortcode($content) . '</div>';
}

// two_third_col column
add_shortcode( 'two_third_col', 'bootstrap_two_third_col' );
function bootstrap_two_third_col( $atts, $content = null ) {
  return '<div class="col-sm-8">'. do_shortcode($content) . '</div>';
}

// one_third column
add_shortcode( 'one_third_col', 'bootstrap_one_third_col' );
function bootstrap_one_third_col( $atts, $content = null ) {
  $a = shortcode_atts( array(
    'offset' => false
    ), $atts );
  $offset = $a['offset'] ? 'col-sm-offset-2' : '';
  return '<div class="col-sm-4 '.$offset.'">'. do_shortcode($content) . '</div>';
}

// quarter_width column
add_shortcode( 'quarter_col', 'bootstrap_quarter_col' );
function bootstrap_quarter_col( $atts, $content = null ) {
  return '<div class="col-sm-3">'. do_shortcode($content) . '</div>';
}

// Bootstrap lead paragraph
add_shortcode( 'lead', 'bootstrap_lead_paragraph' );
function bootstrap_lead_paragraph( $atts, $content = null ) {
  return '<p class="lead">'. do_shortcode($content) . '</p>';
}

// Shortcodes ////////////////////////////////////////
// Colour Text span
// [text_color color="charcoal"][/text_color]
add_shortcode( 'text_color', 'landia_text_color_span' );
function landia_text_color_span( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'color' => 'grey',
	), $atts );
  return '<span class="' . esc_attr($a['color']) . '">'. do_shortcode($content) . '</span>';
}

// Contact Form
add_shortcode('contact_form', 'landia_contact_form');
function landia_contact_form(){
  ob_start();  
  include('snippets/contact-form.php'); 
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;
}

// Scroll Button
// [scroll_button label="Submit" color="sea-foam"]
add_shortcode('scroll_button', 'landia_scroll_button');
function landia_scroll_button( $atts ) {
  $a = shortcode_atts( array(
    'label' => 'Submit',
    'scroll' => 'home'
    ), $atts );
  return '<button class="scroll-button btn btn-primary" data-scroll="'. esc_attr($a['scroll']) .'">'. esc_attr($a['label']) .'</button>';
}

// Scroll Button
// [button label="Submit"]
add_shortcode('button', 'landia_button');
function landia_button( $atts ) {
  $a = shortcode_atts( array(
    'label' => 'Submit'
    ), $atts );
  return '<button class="btn btn-primary">'. esc_attr($a['label']) .'</button>';
}

// Shortcodes - Images //////////////////////////////
// Thinklandia Logo
add_shortcode('thinklandia_logo', 'landia_thinklandia_logo');
function landia_thinklandia_logo() {
  return '<img src="'. get_template_directory_uri() . '/images/logos/thinklandia-logo.svg" class="thinklandia-logo">';
}

// Artlandia Logo
add_shortcode('artlandia_logo', 'landia_artlandia_logo');
function landia_artlandia_logo() {
  return '<img src="'. get_template_directory_uri() . '/images/logos/artlandia-logo.svg" class="artlandia-logo">';
}

// Makelandia Logo
add_shortcode('makelandia_logo', 'landia_makelandia_logo');
function landia_makelandia_logo() {
  return '<img src="'. get_template_directory_uri() . '/images/logos/makelandia-logo.svg" class="makelandia-logo">';
}

//Info Icon
add_shortcode('info_icon', 'landia_info_icon');
function landia_info_icon() {
  return '<img src="'. get_template_directory_uri() . '/images/icons/eye.svg" width="40">';
}

//ticket Icon
add_shortcode('ticket_icon', 'landia_ticket_icon');
function landia_ticket_icon() {
  return '<img src="'. get_template_directory_uri() . '/images/icons/ticket.svg" width="40">';
}

//Arrow Icon
add_shortcode('arrow_icon', 'landia_arrow_icon');
function landia_arrow_icon() {
  return '<div class="arrow-icon hidden-xs"><img class="scroll-arrow" src="'. get_template_directory_uri() . '/images/icons/arrow.svg"></div>';
}

//Ideas Icon
add_shortcode('ideas_image', 'landia_ideas_image');
function landia_ideas_image() {
  return '<img src="'. get_template_directory_uri() . '/images/icons/ideas.svg" class="img-responsive hidden-xs">';
}

// Think Art Make Image
add_shortcode('think_art_make_image', 'landia_think_art_make_image');
function landia_think_art_make_image() {
  return '<img src="'. get_template_directory_uri() . '/images/think-art-make-tools.svg" class="think-art-make-tools-image">';
}

// Team Member Row
add_shortcode( 'team_member_row', 'landia_team_member_row' );
function landia_team_member_row( $atts, $content = null ) {
  return '</div><div class="team-member-row">'. do_shortcode($content) . '</div>';
}

// Made by People Images
add_shortcode('team_member_image', 'landia_team_member_image');
function landia_team_member_image($atts) {
  $a = shortcode_atts( array(
    'link' => '',
    'name' => 'M. Mysterious',
    'title' => '',
    'description' => ''
    ), $atts);
  return '<img src="'. esc_attr($a['link']) .'" data-toggle="tooltip" title="<p><strong>'. esc_attr($a['name']) .'</strong><br>'. esc_attr($a['title']) .'</p><p>'. esc_attr($a['description']) .'</p>" class="team-member-tooltip team-member-image">';
}

// Get the Speakers
add_shortcode('get_the_speakers', 'landia_get_the_speakers');
function landia_get_the_speakers() {
  ob_start();  
  include('snippets/get-the-speakers.php'); 
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;
}

// Get the Events
add_shortcode('get_the_events', 'landia_get_the_events');
function landia_get_the_events() {
  ob_start();  
  include('snippets/get-the-events.php'); 
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;
}

// Get the Featured Events
add_shortcode('get_featured_events', 'landia_get_featured_events');
function landia_get_featured_events() {
  ob_start();  
  include('snippets/get-featured-events.php'); 
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;
}

// Background Options Meta Box /////////////////////
add_action('add_meta_boxes', 'landia_bg_meta_box');
function landia_bg_meta_box() {
  add_meta_box_array('bg_meta_box', 'Background Options', 'landia_bg_meta_box_formatting', array('page', 'speakers', 'events'), 'side', 'low');
}

// Format the Options Meta Box
function landia_bg_meta_box_formatting($post){
  // Add an nonce field so we can check for it later.
  wp_nonce_field('bg_meta_box', 'bg_meta_box_nonce');

  // All the background colours
  $bgColors = array('','sea-foam-bg','sage-bg','green-bg','pale-green-bg','light-blue-bg','blue-bg','teal-bg','pale-yellow-bg','yellow-bg','orange-bg','dark-red-bg','red-bg','pink-bg','dark-pink-bg','pale-brown-bg','brown-bg','brown-red-bg','pale-cream-bg','cream-bg','light-grey-bg','pale-grey-bg','grey-bg','dark-grey-bg','light-slate-bg','slate-bg');

  // All the half background images
  $bgImages = array('', 'tool-bg');

  // Check for existing value
	$bg_color = esc_html( get_post_meta($post->ID, 'bg_color', true) );
	$half_bg = esc_html( get_post_meta($post->ID, 'half_bg', true) ); ?>

  <p class="meta-box-title strong">Background Color:</p>
  <div id="bg_color_box" class="<?php echo $bg_color ?>"> </div>
  <div id="bg_color_select_wrapper">
	  <select id="bg_color" name="bg_color" class="full-width margin-bottom">
	  <?php foreach ($bgColors as $color) : ?>
	  	<option value="<?php echo $color ?>" <?php echo ($color == $bg_color)? 'selected' : ''; ?>><?php echo ucfirst(substr($color, 0, -3)) ?></option>
	  <?php endforeach; ?>
	  </select>
  </div>

  <p class="meta-box-title strong">Half-width Background Image:</p>
  <select id="half_bg" name="half_bg" class="full-width margin-bottom">
  <?php foreach ($bgImages as $image) : ?>
  	<option value="<?php echo $image ?>" <?php echo ($image == $half_bg)? 'selected' : ''; ?>><?php echo ucfirst(substr($image, 0, -3)) ?></option>
  <?php endforeach; ?>
  </select>
  <?php //open PHP again
}

// Live adjustment of the meta box color
add_action('admin_head', 'landia_change_bg_color_box');
function landia_change_bg_color_box() {
  global $current_screen;
  //if('page' != $current_screen->id) return;

  echo <<<HTML
    <script type="text/javascript">
    jQuery(document).ready( function($) {
      $('#bg_color').live('change', function(){
        newColor = $(this).val();
        $('#bg_color_box').attr("class", newColor);
      });                
    });    
    </script>
HTML;
}

// Save Background Options Meta Box
add_action('save_post', 'landia_bg_meta_box_save_data');
function landia_bg_meta_box_save_data($post_id) {
  global $post;
  // Check if our nonce is set.
  if ( !isset( $_POST['bg_meta_box_nonce'] ) ) { return; }
  // Verify that the nonce is valid.
  if ( !wp_verify_nonce( $_POST['bg_meta_box_nonce'], 'bg_meta_box' ) ) { return; }
  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

  if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

  // Check for Meta Value
  if (isset($_POST['bg_color'])) {
    $custom_type_meta_values['bg_color'] = $_POST['bg_color'];
  }
  if (isset($_POST['half_bg'])) {
    $custom_type_meta_values['half_bg'] = $_POST['half_bg'];
  }

  // Finally ready to save the data
  if (isset($custom_type_meta_values)) {
    foreach ($custom_type_meta_values as $key => $value) {
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
        update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
        add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }

}

// Contact Information Meta Box /////////////////////
add_action('add_meta_boxes', 'landia_contact_info_meta_box');
function landia_contact_info_meta_box() {
  global $post;
  if ( $post->ID == get_page_by_title('Contact')->ID) {
    add_meta_box('contact_information_meta_box', 'Contact Information', 'landia_contact_meta_box_formatting', 'page', 'normal');
  }
}

// Format the Contact Information Meta Box
function landia_contact_meta_box_formatting($post){
  // Add an nonce field so we can check for it later.
  wp_nonce_field('contact_information_meta_box', 'contact_information_meta_box_nonce'); ?>

  <div class="meta-inline">
    <p class="meta-box-title">Email:</p>
    <input type="text" class="meta-box-input" name="contact_email" value="<?php echo esc_html( get_post_meta( $post->ID, 'contact_email', true )) ?>" />
  </div>
  <div class="meta-inline">
    <p class="meta-box-title">Address:</p>
    <input type="text" class="meta-box-input" name="contact_address" value="<?php echo esc_html( get_post_meta( $post->ID, 'contact_address', true )) ?>" />
  </div>
  <div style="clear:both"></div>

  <div class="meta-inline">
    <p class="meta-box-title">Sponsor Link:</p>
    <input type="text" class="meta-box-input" name="sponsor_link" value="<?php echo esc_html( get_post_meta( $post->ID, 'sponsor_link', true )) ?>" />
  </div>
  <div class="meta-inline">
    <p class="meta-box-title">Volunteer Link:</p>
    <input type="text" class="meta-box-input" name="volunteer_link" value="<?php echo esc_html( get_post_meta( $post->ID, 'volunteer_link', true )) ?>" />
  </div>
  <div style="clear:both"></div>

  <?  // Open up PHP again 
}

// Save Contact Information Meta Box
add_action('save_post', 'landia_contact_info_meta_box_save_data');
function landia_contact_info_meta_box_save_data($post_id) {
  global $post;
  // Check if our nonce is set.
  if ( !isset( $_POST['contact_information_meta_box_nonce'] ) ) { return; }
  // Verify that the nonce is valid.
  if ( !wp_verify_nonce( $_POST['contact_information_meta_box_nonce'], 'contact_information_meta_box' ) ) { return; }
  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

  if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

  // Check for Meta Value
  $metaValues = array ('contact_email', 'contact_address', 'sponsor_link', 'volunteer_link');
  foreach ($metaValues as $metaValue) {
    if (isset($_POST[$metaValue])) {
      $custom_type_meta_values[$metaValue] = $_POST[$metaValue];
    }
  }

  // Finally ready to save the data
  if (isset($custom_type_meta_values)) {
    foreach ($custom_type_meta_values as $key => $value) {
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
        update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
        add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }

}

// Custom Post Types ///////////////////////////////
// Event Custom Posts
add_action( 'init', 'landia_events_custom_type' );
function landia_events_custom_type() {
  $labels = array(
    'name'               => 'Events',
    'singular_name'      => 'Event',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Event',
    'edit_item'          => 'Edit Event',
    'new_item'           => 'New Event',
    'all_items'          => 'All Events',
    'view_item'          => 'View Event',
    'search_items'       => 'Search Events',
    'not_found'          => 'No Events found',
    'not_found_in_trash' => 'No Events found in the Trash',
    'menu_name'          => 'Events'
  );
  $args = array(
    'labels'        => $labels,
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'thumbnail', 'editor' ),
    'taxonomies' => array('category'),
    'menu_icon' => 'dashicons-calendar',
    'exclude_from_search' => true,
    'query_var' => true,
    'register_meta_box_cb' => 'events_meta_boxes',
    'has_archive'   => true
  );
  register_post_type( 'events', $args ); 
}
function events_meta_boxes() {
  custom_post_add_metabox('event','Event');
}

// Speaker Custom Posts
add_action( 'init', 'speakers_custom_type' );
function speakers_custom_type() {
  $labels = array(
    'name'               => 'Speakers',
    'singular_name'      => 'Speaker',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Speaker',
    'edit_item'          => 'Edit Speaker',
    'new_item'           => 'New Speaker',
    'all_items'          => 'All Speakers',
    'view_item'          => 'View Speaker',
    'search_items'       => 'Search Speakers',
    'not_found'          => 'No Speakers found',
    'not_found_in_trash' => 'No Speakers found in the Trash',
    'menu_name'          => 'Speakers'
  );
  $args = array(
    'labels'        => $labels,
    'public'        => true,
    'menu_position' => 7,
    'supports'      => array( 'title', 'thumbnail', 'editor' ),
    'menu_icon' => 'dashicons-businessman',
    'exclude_from_search' => true,
    'query_var' => true,
    'register_meta_box_cb' => 'speakers_meta_boxes',
    'has_archive'   => true
  );
  register_post_type( 'speakers', $args ); 
}
function speakers_meta_boxes() {
  custom_post_add_metabox('speaker','Speaker');
}

// Custom Post Saving functions /////////////////////////////////////
// Add Meta boxes to the custom post edit page
// Arguments take singular name: First with underscore, Second without
// Use: custom_post_add_metabox('team_member','Team Member'); 
function custom_post_add_metabox($metaSlug, $customTypeName){
  add_meta_box($metaSlug.'_meta_box', $customTypeName, 'custom_post_meta_box_view', $metaSlug.'s', 'normal', 'default', array('metaSlug'=>$metaSlug));
}

// Format the Meta Boxes
function custom_post_meta_box_view($post, $metaSlug) {
  global $post;
  $metaSlug = $metaSlug['args']['metaSlug'];
  // Noncename needed to verify where the data originated
  echo '<div class="'.$metaSlug.'_meta_box"><input type="hidden" name="'.$metaSlug.'_meta_noncename" id="'.$metaSlug.'_meta_noncename" value="' .wp_create_nonce( plugin_basename(__FILE__) ) . '" />';  
  include('snippets/metaboxes/'.$metaSlug.'.php');
  echo '</div>';
}

// Save the Metabox Data
add_action('save_post', 'landia_save_meta_boxes', 1, 2); // save the custom fields
function landia_save_meta_boxes($post_id, $post) {
  // verify this came from the our screen and with proper authorization because save_post can be triggered at other times
  //if ( !wp_verify_nonce( $_POST['team_members_meta_noncename'], plugin_basename(__FILE__) )) { return $post->ID; }
  if (isset($_POST['hidden_flag'])) {
    if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

    // Check for Meta Value
    $metaValues = array('position', 'email', 'website', 'date', 'start_time', 'end_time', 'venue', 'address', 'venue_site', 'tickets', 'price', 'moderator', 'featured', 'summary', 'show_title', 'header_icon');
    foreach ($metaValues as $metaValue) {
      if (isset($_POST[$metaValue])) {
        $custom_type_meta_values[$metaValue] = $_POST[$metaValue];
      } else {
        update_post_meta( $post_id, $metaValue, 0 ); // save unchecked check-boxes
      }
    }

    // Finally ready to save the data
    if (isset($custom_type_meta_values)) {
      foreach ($custom_type_meta_values as $key => $value) {
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
          update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
          add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
      }
    }
  }
}

// Social Media Meta Box /////////////////////////////
add_action('add_meta_boxes', 'landia_social_media_meta_box');
function landia_social_media_meta_box() {
  global $post;
  if ( $post->ID == get_page_by_title('Contact')->ID) {
    //add social media to Contact Page
    add_meta_box('social_media_meta_box', 'Social Media Links', 'landia_social_media_meta_box_formatting', 'page', 'normal', 'low');
  }
  add_meta_box('social_media_meta_box', 'Social Media Links', 'landia_social_media_meta_box_formatting', 'speakers', 'normal', 'low');
}

// accept arrays for the post type
// Use like regular add_meta_box
function add_meta_box_array($id, $title, $callback, $post_types, $context, $priority) {
    foreach( $post_types as $post_type ) {
        add_meta_box($id, $title, $callback, $post_type, $context, $priority);
    }
}

// Format the Contact Information Meta Box
function landia_social_media_meta_box_formatting($post){
  // Add an nonce field so we can check for it later.
  wp_nonce_field('social_media_meta_box', 'social_media_meta_box_nonce');
  include('snippets/metaboxes/social_media.php');
}

// Save Contact Information Meta Box
add_action('save_post', 'landia_social_media_meta_box_save_data');
function landia_social_media_meta_box_save_data($post_id) {
  if (isset($_POST['hidden_flag'])) {
    global $post;
    // Check if our nonce is set.
    if ( !isset( $_POST['social_media_meta_box_nonce'] ) ) { return; }
    // Verify that the nonce is valid.
    if ( !wp_verify_nonce( $_POST['social_media_meta_box_nonce'], 'social_media_meta_box' ) ) { return; }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

    if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

    // Check for Meta Value
    $metaValues = array ('facebook', 'instagram', 'twitter', 'flickr', 'linkedin', 'vimeo', 'googlePlus', 'pinterest', 'youtube');
    foreach ($metaValues as $metaValue) {
      if (isset($_POST[$metaValue])) {
        $custom_type_meta_values[$metaValue] = $_POST[$metaValue];
      }
    }

    // Finally ready to save the data
    if (isset($custom_type_meta_values)) {
      foreach ($custom_type_meta_values as $key => $value) {
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
          update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
          add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
      }
    }
  }
}

// Load scripts ////////////////////////////////////
add_action('wp_enqueue_scripts','landia_scripts_init');
function landia_scripts_init() {
	wp_enqueue_script( 'jquery' );

  wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js');
  wp_enqueue_script('bootstrap');

  wp_register_script( 'modernizr', get_template_directory_uri() . '/js/webshim/modernizr-custom.js', array( 'jquery') );
  wp_enqueue_script( 'modernizr' );

  wp_register_script( 'webshim', get_template_directory_uri() . '/js/webshim/polyfiller.js', array( 'jquery', 'modernizr' ) );
  wp_enqueue_script( 'webshim' );

  wp_register_script( 'webshim_init', get_template_directory_uri() . '/js/webshim_init.js');
  wp_enqueue_script('webshim_init');

  wp_register_script( 'landia_scripts', get_template_directory_uri() . '/js/scripts.js');
  wp_enqueue_script('landia_scripts');

  wp_localize_script('landia_scripts', 'landia_scripts_vars', array(
      'template_path' => get_bloginfo('template_directory')
    )
  );
}

add_action('admin_enqueue_scripts', 'landia_admin_scripts');
function landia_admin_scripts() {
  wp_register_script( 'modernizr', get_template_directory_uri() . '/js/webshim/modernizr-custom.js', array( 'jquery') );
  wp_enqueue_script( 'modernizr' );

  wp_register_script( 'webshim', get_template_directory_uri() . '/js/webshim/polyfiller.js', array( 'jquery', 'modernizr' ) );
  wp_enqueue_script( 'webshim' );

  wp_register_script( 'webshim_init', get_template_directory_uri() . '/js/webshim_init.js');
  wp_enqueue_script('webshim_init');
}
