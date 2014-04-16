<?php
/**
 * Enqueue link to add CSS through PHP
 *
 * This is a typical WP Enqueue statement,
 * except that the URL of the stylesheet is simply a query var.
 * This query var is passed to the URL, and when it is detected by sccss_add_trigger(),
 * It fires sccss_trigger_check, which writes its PHP/CSS to the browser.
 *
 * Credit for this technique: @Otto http://ottopress.com/2010/dont-include-wp-load-please/
 *
 * @since 1.1
 */
function sccss_register_style() {
	wp_register_style( 'sccss_style', home_url( '/?sccss=1' ) );
	wp_enqueue_style( 'sccss_style' );
}
add_action( 'wp_enqueue_scripts', 'sccss_register_style', 99 );


/**
 * Enqueues Scripts/Styles for Syntax Highlighter
 *
 * @since  3.0
 * @param  string  Hook of admin screen
 * @return void
 */
function sccss_register_codemirror( ) {
		wp_enqueue_style( 'codemirror-css', get_template_directory_uri().'/library/custom-css/codemirror/codemirror.css' );
		wp_enqueue_script( 'codemirror-js', get_template_directory_uri().'/library/custom-css/codemirror/codemirror.js', array('jquery'), '20140329', true );
		wp_enqueue_script( 'codemirror-css-js', get_template_directory_uri().'/library/custom-css/codemirror/css.js', array('jquery'), '20140329', true );
}
add_action( 'admin_enqueue_scripts', 'sccss_register_codemirror' );


/**
 * Add Query Var Stylesheet trigger
 *
 * Adds a query var to our stylesheet, so it can trigger our psuedo-stylesheet
 *
 * @since 1.1
 * @param string $vars
 * @return array $vars
 */
function sccss_add_trigger( $vars ) {
	$vars[] = 'sccss';
	return $vars;
}
add_filter( 'query_vars', 'sccss_add_trigger' );


/**
 * If trigger (query var) is tripped, load our pseudo-stylesheet
 *
 * I'd prefer to esc $content at the very last moment, but we need to allow the > character.
 *
 * @since 1.1
 */
function sccss_trigger_check() {
	if ( intval( get_query_var( 'sccss' ) ) == 1 ) {
		ob_start();
		header( 'Content-type: text/css' );
		$options     = get_option( 'sccss_settings' );
		$raw_content = isset( $options['sccss-content'] ) ? $options['sccss-content'] : '';
		$content     = wp_kses( $raw_content, array( '\'', '\"' ) );
		$content     = str_replace( '&gt;', '>', $content );
		echo $content; //xss okay
		exit;
		ob_clean();
	}
}
add_action( 'template_redirect', 'sccss_trigger_check' );


/**
 * Register "Custom CSS" submenu in "Appearance" Admin Menu
 *
 * @since 1.0
 */
function sccss_register_submenu_page() {
	add_theme_page( __( 'Custom CSS', 'sccss' ), __( 'Custom CSS', 'sccss' ), 'edit_theme_options', 'custom-css', 'sccss_render_submenu_page' );
}
add_action( 'admin_menu', 'sccss_register_submenu_page' );


/**
 * Register settings
 *
 * @since 1.0
 */
function sccss_register_settings() {
	register_setting( 'sccss_settings_group', 'sccss_settings' );
}
add_action( 'admin_init', 'sccss_register_settings' );


/**
 * Render Admin Menu page
 *
 * @since 1.0
 */
function sccss_render_submenu_page() {

	$options = get_option( 'sccss_settings' );
	$content = isset( $options['sccss-content'] ) && ! empty( $options['sccss-content'] ) ? $options['sccss-content'] : '/* Enter Your Custom CSS Here */';

	if ( isset( $_GET['settings-updated'] ) ) : ?>
		<div id="message" class="updated"><p><?php _e( 'Custom CSS updated successfully.', 'sccss' ); ?></p></div>
	<?php endif; ?>
	<div class="wrap">
		<h2 style="margin-bottom: 1em;"><?php _e( 'Custom CSS', 'sccss' ); ?></h2>
		<form name="sccss-form" action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_fields( 'sccss_settings_group' ); ?>
			<div id="templateside">
				<?php do_action( 'sccss-sidebar-top' ); ?>
				<p style="margin-top: 0"><?php _e( 'Simple Custom CSS allows you to add your own styles or override the default CSS of a plugin or theme.', 'sccss' ) ?></p>
				<p><?php _e( 'To use, enter your custom CSS, then click "Update Custom CSS".  It\'s that simple!', 'sccss' ) ?></p>
				<?php do_action( 'sccss-sidebar-bottom' ); ?>
			</div>
			<div id="template">
				<?php do_action( 'sccss-form-top' ); ?>
				<div>
					<textarea cols="70" rows="30" name="sccss_settings[sccss-content]" id="sccss_settings[sccss-content]" ><?php echo esc_html( $content ); ?></textarea>
				</div>
				<?php do_action( 'sccss-textarea-bottom' ); ?>
				<div>
					<?php submit_button( __( 'Update Custom CSS', 'sccss' ), 'primary', 'submit', true ); ?>
				</div>
				<?php do_action( 'sccss-form-bottom' ); ?>
			</div>
		</form>
		<script language="javascript">
			jQuery( document ).ready( function() {
				var editor = CodeMirror.fromTextArea( document.getElementById( "sccss_settings[sccss-content]" ), {lineNumbers: true, lineWrapping: true} );
			});
		</script>
	</div>
	<?php
}
