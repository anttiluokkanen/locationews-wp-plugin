<?php
/**
 * Locationews Options provider.
 *
 * @package   Locationews
 * @copyright Copyright (c) 2018, Locationews, LLC
 * @license   GPL-2.0+
 * @since     2.0.0
 */

/**
 * Options provider class.
 *
 * @package Locationews
 * @since   2.0.0
 */
class Locationews_Provider_Options extends Locationews_AbstractProvider {

	/**
	 * Register hooks
	 *
	 * Loads the text domain during the `plugins_loaded` action.
	 *
	 * @since 2.0.0
	 */
	public function ln_register_hooks() {
		add_action( 'admin_menu', [ $this, 'ln_add_plugin_page' ] );
		add_action( 'admin_init', [ $this, 'ln_settings_page_init' ] );
	}

	/**
	 * Add plugin page
	 *
	 * Add settings page for plugin.
	 *
	 * @since 2.0.0
	 */
	public function ln_add_plugin_page() {
		add_menu_page(
			'Locationews',
			'Locationews',
			'manage_options',
			'locationews-settings',
			[ $this, 'ln_create_admin_page' ],
			'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAAYCAMAAAArvOYAAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAACGVBMVEUAAADrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGSHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGiHrGSHrGSDrGB/rGiHrGB/rHyPtMTLuPzzrGiHrGSDvRkT3opn81c/95uLrGiHrGB/wVFL82dP////////82NPwVFLrGB/rGCDtNjX6zsjt8PDx8fH7zsjtNjXrFx70dnD8+PaKioylpKX39/f09PT09PX/////+/jzdXDrGiHrHiH3pZz8//94eHmZmZn39/iHh4lvb3Fzc3Ts7Oz3pZzrICL4q6H8//95eHqTkpTq6utiYWOTk5VYV1jQ0NH+///4q6HrGR71i4X8/fyCgoNPTk91dXdgYGK4ubpqaWuHiIrMzc33jYfrGB/vS0f85uHh4+TLy8zOz9DU1dbs7O3Y2drT1dbp08/wS0jrGiHrHSL0hX3+9vP/9/T1hn7rHSLrGSDsIyb0fXb82dP+9/T//Pn0fXbsIybrGSDrGSDrGyDuOjjyZV70dnHrGyDrGSDrGiHrGCDrFx7rFh7rGiGalQZVAAAAPXRSTlMAAAo5ZHEFQJ/f9vkMeegGfvZO7hC2ROt0+oiE/2f2MOAHmS/WTuABStwATOMBZfMIk/4m03f6LMoSewQexmgNFwAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxIAAAsSAdLdfvwAAAAHdElNRQfhAwYHDTd7W4pMAAAA40lEQVQY023OPSvFARTH8e/3uP7ykFIWbDeLiaKsdpm9FkIYvBezshsV5Wa4i3gBBqU8lOFn+N/rKs5wOn0659cRENUkISA47lDyFcRpXW2ll7xFZ3VtuHOXvOqc66Or27w476YqoPp5nU45qfoByZRWOuWE6secqlZc3PGnnrrvuXDJ3RH5dp5OOfNL2pz/5RJgu0226/7gwzE9yqOy7MlQ9vJAharTpmmapqmDKiK4omcA+0k/FKRfdQgcVvUDYwDPC3W1daz3AQogvSqqegGQtm+YGwLQASCWaWEgUGYw/ZVvt+hf4QWLPjYAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTctMDMtMDZUMDc6MTM6NTUtMDU6MDBD8t61AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE3LTAzLTA2VDA3OjEzOjU1LTA1OjAwMq9mCQAAAABJRU5ErkJggg==',
			76
		);
	}

	/**
	 * Create admin page
	 *
	 * Create settings page for plugin.
	 *
	 * @since 2.0.0
	 */
	public function ln_create_admin_page() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="locationews-wp-plugin">
			<div class="wrap">
				<div id="ln-block">
					<div id="ln-title">
						<h1>Locationews</h1>
						<p>
							<?php _e( 'Locationews plugin publish your news to Locationews service. With these settings, you can specify the basic functions on the map selector which appear in the article edit view.', $this->plugin->ln_get_slug() ); ?>
						</p>
						<?php if ( $this->plugin->ln_get_option( 'jwt' ) == 'plugintest' ): ?>
							<p>
								<?php _e( 'Register your free account at <a href="https://locationews.com/en/" target="_blank">Locationews.com</a> and start publishing.', $this->plugin->ln_get_slug() ); ?>
							</p>
						<?php endif; ?>
					</div>
					<div id="ln-logo">
						<a href="https://www.locationews.com/en/"
						   target="_blank"
						   title="Locationews.com">
							<img
								src="<?php echo $this->plugin->ln_get_url(); ?>assets/img/icon.png"
								alt="Locationews"
								id="locationewslogo" class="pull-x-right"/>
						</a>
					</div>
				</div>
			</div>
			<div class="wrap">
				<?php
				settings_errors();
				?>
				<form method="post" action="options.php">
					<?php
					settings_fields( 'locationews_user' );
					do_settings_sections( 'locationews' );
					?>
					<input type="submit" id="locationews-save-btn"
					       class="locationews btn btn-danger"
					       value="<?php _e( 'Save Settings', $this->plugin->ln_get_slug() ); ?>">
				</form>
			</div>
		</div>
		<?php

	}

	/**
	 * Settings page init
	 *
	 * Initialize plugin settings.
	 *
	 * @since 2.0.0
	 */
	public function ln_settings_page_init() {

		register_setting(
			'locationews_user',
			'locationews_user',
			[ $this, 'ln_settings_sanitize' ]
		);

		add_settings_section(
			'locationews-fields',
			__( 'Settings', $this->plugin->ln_get_slug() ),
			[ $this, 'ln_settings_section_info' ],
			'locationews'
		);

		add_settings_field(
			'locationewsCategory',
			__( 'Default Category', $this->plugin->ln_get_slug() ),
			[ $this->plugin, 'ln_field_select' ],
			'locationews',
			'locationews-fields',
			[
				'description' => __( 'Set the default category for Locationews articles. This function does not affect on the WordPress categories.', $this->plugin->ln_get_slug() ),
				'id'          => 'locationewsCategory',
				'value'       => '',
				'fields'      => $this->plugin->ln_get_categories(),
			]
		);

		add_settings_field(
			'defaultCategories',
			__( 'Categories', $this->plugin->ln_get_slug() ),
			[ $this->plugin, 'ln_field_multicheckbox' ],
			'locationews',
			'locationews-fields',
			[
				'description' => __( 'Select WordPress Categories whose news you want to post to Locationews.', $this->plugin->ln_get_slug() ),
				'id'          => 'defaultCategories',
				'value'       => 'all',
				'fields'      => $this->plugin->ln_get_wp_categories(),
			]
		);

		add_settings_field(
			'postTypes',
			__( 'Post types', $this->plugin->ln_get_slug() ),
			[ $this->plugin, 'ln_field_multicheckbox' ],
			'locationews',
			'locationews-fields',
			[
				'description' => __( 'Choose which post types you want to allow use Locationews. The default option is normal post type.', $this->plugin->ln_get_slug() ),
				'id'          => 'postTypes',
				'value'       => 'post',
				'fields'      => $this->plugin->ln_get_wp_post_types(),
			]
		);

		add_settings_field(
			'location',
			__( 'Default location', $this->plugin->ln_get_slug() ),
			[ $this->plugin, 'ln_field_google_map' ],
			'locationews',
			'locationews-fields',
			[
				'description' => __( "Select the default location (the default option is your publication's address, here you can choose another location).", $this->plugin->ln_get_slug() ),
				'id'          => 'location',
				'value'       => $this->plugin->ln_get_option( 'location', 'user' ),
			]
		);



	}

	/**
	 * Settings sanitize
	 *
	 * Sanitize plugin settings.
	 *
	 * @since 2.0.0
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function ln_settings_sanitize( $input ) {

		$sanitary_values = [];
		if ( isset( $input['locationewsCategory'] ) ) {
			$sanitary_values['locationewsCategory'] = $input['locationewsCategory'];
		}

		if ( isset( $input['defaultCategories'] ) ) {
			$sanitary_values['defaultCategories'] = $input['defaultCategories'];
		}

		if ( isset( $input['postTypes'] ) ) {
			$sanitary_values['postTypes'] = $input['postTypes'];
		}

		if ( isset( $input['location'] ) ) {
			$sanitary_values['location'] = sanitize_text_field( $input['location'] );
		}

		return $sanitary_values;
	}

	/**
	 * Settings section info
	 *
	 * Dummy callback function.
	 *
	 * @since 2.0.0
	 */
	public function ln_settings_section_info() {

	}


}
