<?php
/**
 * Locationews Shortcode provider.
 *
 * @package   Locationews
 * @copyright Copyright (c) 2018, Locationews, LLC
 * @license   GPL-2.0+
 * @since     2.1.0
 */

/**
 * Shortcode provider class.
 *
 * @package Locationews
 * @since   2.1.0
 */
class Locationews_Provider_Shortcode extends Locationews_AbstractProvider {

	/**
	 * Register hooks
	 *
	 * Loads the text domain during the `plugins_loaded` action.
	 *
	 * @since 2.1.0
	 */
	public function ln_register_hooks() {
		add_action( 'init', [ $this, 'ln_register_shortcodes' ] );
		add_action( 'init', [ $this, 'ln_add_filters'] );
	}

	/**
	 * Register shortcodes
	 *
	 * @since 2.1.0
	 */
	public function ln_register_shortcodes() {
		add_shortcode( 'locationews', [ $this,'ln_shortcode'] );
	}

	/**
	 * Add filters
	 *
	 * @since 2.1.0
	 */
	public function ln_add_filters() {
		add_filter( 'the_content', [ $this, 'ln_the_content' ] );
	}

	public function ln_shortcode( $atts ) {

		global $post;

		$locationews_meta = get_post_meta( $post->ID, $this->plugin->ln_get_meta_name(), true );

		if ( ! isset( $locationews_meta['on'] ) || $locationews_meta['on'] != 1 ) {
			return '';
		}

		$defaults = $this->plugin->ln_get_front_options();

		// Get coordinates
		$coordinates = explode(',', $locationews_meta['latlng'] );
		$default_coordinates = explode(',', $defaults['location'] );

		if ( isset( $coordinates[0] ) && $coordinates[0] != 0 ) {
			$latitude = $coordinates[0];
		} else {
			$latitude = $default_coordinates[0];
		}

		if ( isset( $coordinates[1] ) && $coordinates[1] != 0 ) {
			$longitude = $coordinates[1];
		} else {
			$longitude = $default_coordinates[1];
		}

		$a = shortcode_atts( array(
			'width' => '100%',
			'height' => '150px',
			'zoom' => $defaults['gZoom'],
			'icon' => $defaults['gIcon']
		), $atts );

		$article = [
			'ID'        => $post->ID,
			'title'     => apply_filters( 'the_title', $post->post_title ),
			'url'       => get_permalink( $post->ID ),
			'latitude'  => $latitude,
			'longitude' => $longitude
		];

		wp_localize_script( 'locationews', 'locationews_map_init',
			array(
				'article'    => $article,
				'articles'   => [], //$articles,
				'zoom'       => $a['zoom'],
				'icon'       => $a['icon']
			)
		);

		return '<div id="locationews-google-map" class="locationews-google-map" style="width:' . $a['width']. ';height:' . $a['height'] . '"></div>
			<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>';
	}


	public function ln_the_content( $content ){

		global $post;

		if( is_single() ){
			$content .= do_shortcode( '[locationews]' );

		}

		return $content;
	}

}
