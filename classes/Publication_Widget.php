<?php
class Locationews_Publication_Widget extends WP_Widget {

	var $options;

    public function __construct( ) {

        $widget_options = [
            'classname'   => 'locationews_magazine_widget',
            'description' => __('Display all your articles in Locationews map.', 'locationews'),
        ];

        parent::__construct( 'locationews_publication_widget', 'Locationews Publication Widget', $widget_options );
    }

    public function form( $instance ) {
	    $instance = wp_parse_args( (array) $instance, array(
		    'link_text' => '',
		    'post_id'   => '',
		    'text'      => '',
		    'title'     => '',
	    ) );

    	$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        echo "
        <p>
            <label for=\"" . $this->get_field_id( 'title' ) . "\">" . __('Title', 'locationews' ) . ":</label>
            <input type=\"text\" id=\"" . $this->get_field_id( 'title' ) . "\" name=\"" . $this->get_field_name( 'title' ) . "\" value=\"" . esc_attr( $title ) . "\" />
        </p>";
    }

    public function update( $new_instance, $old_instance ) {
	    $instance = wp_parse_args( $new_instance, $old_instance );
	    $instance['title'] = wp_strip_all_tags( $new_instance['title'] );
	    $instance['text'] = wp_kses_data( $new_instance['text'] );
	    $instance['link_text'] = wp_kses_data( $new_instance['link_text'] );
	    return $instance;
    }

    public function widget( $args, $instance ) {

	    if ( empty( $instance['post_id'] ) ) {
		    //return;
	    }
		global $post;

    	// Current article
	    $article = [];

    	// Locationews articles
	    $articles = [];

    	// Current post meta
    	//$locationews_meta = get_post_meta( $post->ID, 'locationews', true );

	    // Publication's default coordinates
    	list( $default_lat, $default_lng ) = explode(',', $this->options['location'] );

	    // Get all published Locationews articles
	    $ln_posts = get_posts(
	        array(
			    'posts_per_page' => -1,
			    'post_status'    => 'publish',
			    'meta_query'     => array(
				    array(
					    'key'    => 'locationews',
					    'compare' => 'EXISTS'
				    )
			    )
		    )
	    );

	    if ( is_array( $ln_posts ) ) {
	    	foreach ( $ln_posts as $ln ) {

	    		// Get post meta
	    		$ln_meta = get_post_meta( $ln->ID, 'locationews', true );

	    		// Show marker only if Locationews status is on
	    		if ( $ln_meta['on'] == 1 ) {

	    			// Get coordinates
	    			$coordinates = explode(',', $ln->latlng );

	    			if ( isset( $coordinates[0] ) && $coordinates[0] != 0 ) {
						$latitude = $coordinates[0];
					} else {
						$latitude = $default_lat;
					}

				    if ( isset( $coordinates[1] ) && $coordinates[1] != 0 ) {
					    $longitude = $coordinates[1];
				    } else {
					    $longitude = $default_lng;
				    }

				    if ( $ln->ID == $post->ID ) {
					    $article = array(
						    'ID'        => $ln->ID,
						    'title'     => apply_filters( 'the_title', $ln->post_title ),
						    'url'       => get_permalink( $ln->ID ),
						    'latitude'  => $latitude,
						    'longitude' => $longitude
					    );
				    } else {
					    $articles[] = array(
						    'ID'        => $ln->ID,
						    'title'     => apply_filters( 'the_title', $ln->post_title ),
						    'url'       => get_permalink( $ln->ID ),
						    'latitude'  => $latitude,
						    'longitude' => $longitude
					    );
				    }
			    }
		    }
	    }

	    //if ( ! empty( $article ) ) {
	/*	    wp_localize_script( 'locationews', 'locationews_map_init',
			    array(
				    'article'    => $article,
				    'articles'   => [], //$articles,
				    'zoom'       => $args['zoom']
			    )
		    );

		    echo $instance['before_widget'];
		    echo '<div id="locationews-google-map" class="locationews-google-map" style="width:' . $args['width'] . ';height:' . $args['height'] . '"></div>
			<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>';
		    echo $instance['after_widget'];
*/
	   // }
    }

	/**
	 * Locationews shortcode
	 *
	 * Shortcode for displaying map
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	/*function locationews_shortcode( $atts ) {

		extract( shortcode_atts(
			[
				'width' => '100%',
				'height' => '250px',
				'zoom' => '11'
			],
			$atts
		) );

		$args = [
			'before_widget' => '<div id="locationews-widget" class="locationews-widget">',
			'after_widget'  => '</div>',
		];

		ob_start();
		the_widget('Locationews_Publication_Widget', $atts, $args );
		$output = ob_get_clean();

		return $output;
	}
	*/

	//[foobar]
	function foobar_func( $atts ){
		global $post;

		$a = shortcode_atts( array(
			'width' => '100%',
			'height' => '150px',
		), $atts );

		$ln = get_post($post->ID);

		$default_lat = 0;
		$default_lng = 0;

		$locationews_meta = get_post_meta( $post->ID, 'locationews_dev', true );

		// Get coordinates
		$coordinates = explode(',', $locationews_meta['latlng'] );

		if ( isset( $coordinates[0] ) && $coordinates[0] != 0 ) {
			$latitude = $coordinates[0];
		} else {
			$latitude = $default_lat;
		}

		if ( isset( $coordinates[1] ) && $coordinates[1] != 0 ) {
			$longitude = $coordinates[1];
		} else {
			$longitude = $default_lng;
		}

		$article = array(
			'ID'        => $ln->ID,
			'title'     => apply_filters( 'the_title', $ln->post_title ),
			'url'       => get_permalink( $ln->ID ),
			'latitude'  => $latitude,
			'longitude' => $longitude
		);

//		return "foo and bar";
		wp_localize_script( 'locationews', 'locationews_map_init',
			array(
				'article'    => $article,
				'articles'   => [], //$articles,
				'zoom'       => 11//$args['zoom']
			)
		);
		/*
		echo '<div id="locationews-google-map" class="locationews-google-map" style="width:' . $a['width']. ';height:' . $a['height'] . '">asdf</div>
			<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>';
	*/
	}
}


//add_shortcode( 'locationews', ['Locationews_Publication_Widget','locationews_shortcode' ] );

add_shortcode( 'foobar', ['Locationews_Publication_Widget','foobar_func'] );
