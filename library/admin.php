<?php
/*
This file handles the admin area and functions.
You can use this file to make changes to the
dashboard. Updates to this page are coming soon.
It's turned off by default, but you can call it
via the functions file.

Special Thanks for code & inspiration to:
Eddie Machado - http://themble.com/bones/
@jackmcconnell - http://www.voltronik.co.uk/
Digging into WP - http://digwp.com/2010/10/customize-wordpress-dashboard/

*/

/************* DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );    // Right Now Widget
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' ); // Comments Widget
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );  // Incoming Links Widget
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core' );   // Quick Press Widget
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );   // Recent Drafts Widget
	remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );         //
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );       //

	// removing plugin dashboard boxes
	remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );         // Yoast's SEO Plugin Widget

	/*
	have more plugin widgets you'd like to remove?
	share them with us so we can get a list of
	the most commonly used. :D
	https://github.com/eddiemachado/bones/issues
	*/
}


// removing the dashboard widgets
add_action( 'admin_menu', 'disable_default_dashboard_widgets' );


/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it

//Updated to proper 'enqueue' method
//http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
function bunch_login_css() {
	wp_enqueue_style( 'bunch_login_css', get_template_directory_uri() . '/library/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function bunch_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function bunch_login_title() { return get_option( 'blogname' ); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'bunch_login_css', 10 );
add_filter( 'login_headerurl', 'bunch_login_url' );
add_filter( 'login_headertitle', 'bunch_login_title' );


/************* CUSTOMIZE ADMIN *******************/

/*
I don't really recommend editing the admin too much
as things may get funky if WordPress updates. Here
are a few funtions which you can choose to use if
you like.
*/

// Custom Backend Footer
function bunch_custom_admin_footer() {
	_e( '<span id="footer-thankyou">Developed by <a href="http://yoursite.com" target="_blank">Your Site Name</a></span>. Built using <a href="https://github.com/softscripts/bunch/" target="_blank">Bench</a>.', 'bunchtheme' );
}

// adding it to the admin area
//add_filter( 'admin_footer_text', 'bunch_custom_admin_footer' );

?>
