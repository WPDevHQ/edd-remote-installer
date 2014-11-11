<?php

/**
* The EDD Remote Installer admin page
*/
class EDD_RI_Admin {

	function __construct() {

		// Add the admin menu
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		// Initialize the settings the settings
		add_action( 'admin_init', array( $this, 'settings_init' ) );

	}

	/**
	 * Create the admin menu
	 */
	function add_admin_menu() {
		add_options_page( 'EDD Remote Installer', 'EDD Remote Installer', 'manage_options', 'edd_ri', array( $this, 'options_page' ) );
	}

	/**
	 * Initialize settings
	 */
	function settings_init() {

		register_setting( 'edd_ri_settings', 'edd_ri_settings' );

		add_settings_section( 'edd_ri', __( 'EDD Remote Installer Settings', 'edd_ri' ), array( $this, 'callback' ), 'edd_ri_settings' );
		add_settings_field( 'edd_ri_enable', __( 'Enable/Disable the json feed', 'edd_ri' ), array( $this, 'enable_render' ), 'edd_ri_settings', 'edd_ri' );
		add_settings_field( 'edd_ri_plugins_select', __( 'Select plugins category', 'edd_ri' ), array( $this, 'plugins_select_render' ), 'edd_ri_settings', 'edd_ri' );
		add_settings_field( 'edd_ri_themes_select', __( 'Select themes category', 'edd_ri' ), array( $this, 'themes_select_render' ), 'edd_ri_settings', 'edd_ri' );

	}

	/**
	 * Render the enable/disable control
	 */
	function enable_render() {

		$options = get_option( 'edd_ri_settings' ); ?>
		<input type='checkbox' name='edd_ri_settings[edd_ri_enable]' <?php checked( $options['edd_ri_enable'], 1 ); ?> value='1'>
		<?php

	}

	/**
	 * Render the plugin category selection dropdown
	 */
	function plugins_select_render() {

		$options = get_option( 'edd_ri_settings' );
		$terms   = get_terms( 'download_category' );
		?>

		<select name="edd_ri_settings[edd_ri_plugins_select]">

			<?php foreach ( $terms as $term ) : ?>
				<option value="<?php echo $term->term_id; ?>" <?php selected( $options['edd_ri_plugins_select'], $term->term_id ); ?>><?php echo $term->name; ?></option>
			<?php endforeach; ?>

		</select>

		<?php

	}

	/**
	 * Render the plugin category selection dropdown
	 */
	function themes_select_render() {

		$options = get_option( 'edd_ri_settings' );
		$terms   = get_terms( 'download_category' );
		?>

		<select name="edd_ri_settings[edd_ri_themes_select]">

			<?php foreach ( $terms as $term ) : ?>
				<option value="<?php echo $term->term_id; ?>" <?php selected( $options['edd_ri_themes_select'], $term->term_id ); ?>><?php echo $term->name; ?></option>
			<?php endforeach; ?>

		</select>

		<?php

	}

	/**
	 * Add the description
	 */
	function callback() {
		_e( 'Below you can edit your settings for EDD Remote Installer. By selecting a category for plugins and themes you\'re limiting the products that will be displayed to clients. This is a necessary step if you\'re selling both plugins and themes so that themes can use the theme installer instead of the plugin installer.', 'edd_ri' );
	}

	/**
	 * Create the page content
	 */
	function options_page() {

		?>
		<form action='options.php' method='post'>

			<h2><?php _e( 'EDD Remote Installer', 'edd_ri' ); ?></h2>

			<?php
			settings_fields( 'edd_ri_settings' );
			do_settings_sections( 'edd_ri_settings' );
			submit_button();
			?>

		</form>
		<?php

	}

}