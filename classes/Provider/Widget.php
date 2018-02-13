<?php
/**
 * Locationews Widget provider.
 *
 * @package   Locationews
 * @copyright Copyright (c) 2018, Locationews, LLC
 * @license   GPL-2.0+
 * @since     2.1.0
 */

/**
 * Widget provider class.
 *
 * @package Locationews
 * @since   2.1.0
 */
class Locationews_Provider_Widget extends Locationews_AbstractProvider {

	/**
	 * Options
	 *
	 * @var
	 */
	private $options;

	/**
	 * Register hooks
	 *
	 * Loads the text domain during the `plugins_loaded` action.
	 *
	 * @since 2.1.0
	 */
	public function ln_register_hooks() {
		add_action( 'widgets_init', array( $this, 'ln_register_widgets' ) );
	}

	/**
	 * Register widgets
	 *
	 * @since 2.1.0
	 */
	public function ln_register_widgets() {
		register_widget( 'Locationews_Publication_Widget' );
	}

}
