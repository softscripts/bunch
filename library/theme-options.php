<?php
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'bunch_options', 'bunch_theme_options', 'theme_options_validate' );

add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'theme-options-scripts', get_stylesheet_directory_uri() . '/library/js/admin-scripts.js', array( 'wp-color-picker' ), false, true );
    wp_enqueue_style( 'theme-options-styles', get_stylesheet_directory_uri() . '/library/css/admin.css', array(), '', 'all' );
		wp_enqueue_media();
}

}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'bunchtheme' ), __( 'Theme Options', 'bunchtheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}


/**
 * Create the options page
 */

function theme_options_tabs( $current = 'general' ) {
    $tabs = array( 'general' => 'General','home' => 'Home Page', 'footer' => 'Footer' ); // <=== Assign Tabs Here
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper theme-option-tabs">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='#$tab'>$name</a>";
    }
    echo '</h2>';
}


function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php echo "<h2>" . get_current_theme() . __( ' Theme Options', 'bunchtheme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade theme-options-updated"><p><strong><?php _e( 'Options saved', 'bunchtheme' ); ?></strong></p></div>
		<?php endif; ?>
		<?php theme_options_tabs('general'); ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'bunch_options' ); ?>
			<?php $options = get_option( 'bunch_theme_options' ); ?>

			<table id="general-tab" class="form-table current theme-options-tabs">

				<tr valign="top"><th scope="row"><?php _e( 'Logo', 'bunchtheme' ); ?></th>
					<td>
						<input id="bunch_theme_options_logo" class="regular-text" type="text" name="bunch_theme_options[logo]" value="<?php esc_attr_e( $options['logo'] ); ?>" /><input id="button_bunch_theme_options_logo" class="meta_upload" name="button_bunch_theme_options[logo]" type="button" value="Upload" style="width: auto;" />
					<label class="description" for="bunch_theme_options_logo"><?php _e( 'Insert website logo', 'bunchtheme' ); ?></label>
					<?php if($options['logo'] ) { ?><br /> <img src="<?php echo $options['logo']; ?>" style="max-width: 200px" /><?php } ?>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Facebook', 'bunchtheme' ); ?></th>
					<td>
						<input id="bunch_theme_options_facebook" class="regular-text" type="text" name="bunch_theme_options[facebook]" value="<?php esc_attr_e( $options['facebook'] ); ?>" />
					<label class="description" for="bunch_theme_options_facebook"><?php _e( 'Insert Facebook Link', 'bunchtheme' ); ?></label>
					</td>
				</tr>
		</table>

			<table id="home-tab" class="form-table theme-options-tabs">
				<tr valign="top"><th scope="row"><?php _e( 'Tagline', 'bunchtheme' ); ?></th>
					<td>
						<input id="bunch_theme_options_tagline" class="regular-text" type="text" name="bunch_theme_options[tagline]" value="<?php esc_attr_e( $options['tagline'] ); ?>" />
					<label class="description" for="bunch_theme_options_tagline"><?php _e( 'Insert Website Tagline', 'bunchtheme' ); ?></label>
					</td>
				</tr>			
	
			</table>

		<table id="footer-tab" class="form-table theme-options-tabs">
				
				<tr valign="top"><th scope="row"><?php _e( 'Copyright', 'bunchtheme' ); ?></th>
					<td>
						<input id="bunch_theme_options_copyright" class="regular-text" type="text" name="bunch_theme_options[copyright]" value="<?php esc_attr_e( $options['copyright'] ); ?>" />
					<label class="description" for="bunch_theme_options_copyright"><?php _e( 'Copyright text', 'bunchtheme' ); ?></label>
					</td>
				</tr>
				

	</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'bunchtheme' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )

	// Say our text option must be safe text with no HTML tags
	$input['logo'] = wp_filter_nohtml_kses( $input['logo'] );
	$input['tagline'] = wp_filter_nohtml_kses( $input['tagline'] );
	$input['facebook'] = wp_filter_nohtml_kses( $input['facebook'] );
	$input['copyright'] = $input['copyright'];

	// Say our textarea option must be safe text with the allowed tags for posts
	//$input['textarea'] = wp_filter_post_kses( $input['textarea'] );





	return $input;
}
