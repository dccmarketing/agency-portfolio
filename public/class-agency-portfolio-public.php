<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://slushman.com/plugins/agency-portfolio
 * @since      1.0.0
 *
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/public
 * @author     Slushman <chris@slushman.com>
 */
class Agency_Portfolio_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plug_name    The ID of this plugin.
	 */
	private $plug_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plug_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plug_name, $version ) {

		$this->plugin_name 	= $plug_name;
		$this->version 		= $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/agency-portfolio-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . '-isotope', plugin_dir_url( __FILE__ ) . 'js/isotope.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/agency-portfolio-public.min.js', array( 'jquery', $this->plugin_name . '-isotope' ), $this->version, false );

	}

	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {

		add_shortcode( 'agencyportfolio', array( $this, 'shortcode' ) );

	} // register_shortcodes()

	/**
	 * Processes shortcode
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 * @uses	get_option
	 * @uses	get_layout
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function shortcode( $atts ) {

		ob_start();

		$defaults['types'] 		= '';
		$defaults['industries'] = '';
		$defaults['order'] 		= '';
		$defaults['quantity'] 	= '';
		$args					= shortcode_atts( $defaults, $atts, 'portfolio' );
		$items 					= $this->get_portfolio_items( $args );

		include( plugin_dir_path( __FILE__ ) . 'partials/agency-portfolio-public-display.php' );

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // shortcode()

/**
 * [get_all_terms description]
 * @return [type] [description]
 */
	private function get_all_terms( $tax ) {

		$args['orderby'] 	= 'name';
		$args['order'] 		= 'ASC';
		$args['hide_empty'] = TRUE;
		$terms 				= get_terms( $tax, $args );

		if ( empty( $terms ) ) {

			$return = '';

		} else {

			$return = $terms;

		}

		return $return;

	} // get_all_terms()

/**
 * [get_cats_as_classes description]
 * @param  [type] $postID [description]
 * @return [type]         [description]
 */
	private function get_cats_as_classes( $postID ) {

		if ( empty( $postID ) ) { return ''; }

		$types 		= get_the_terms( $postID, 'portfolio_item_type' );
		$industries = get_the_terms( $postID, 'portfolio_industry' );

		if ( empty( $types ) && empty( $industries ) ) {

			return '';

		} elseif ( empty( $types ) ) {

			$terms = $industries;

		} elseif ( empty( $industries ) ) {

			$terms = $types;

		} else {

			$terms = array_merge( $types, $industries );

		}

		if ( empty( $terms ) ) { return ''; }

		$return = '';

		foreach ( $terms as $term ) {

			$return .= esc_attr( $term->slug ) . ' ';

		} // foreach

		return $return;

	} // get_cats_as_classes()

/**
 * [get_portfolio_filters description]
 * @return [type] [description]
 */
	private function get_portfolio_filters() {

		$taxes 	= get_object_taxonomies( 'portfolio', 'objects' );
		$return = '';

		foreach ( $taxes as $tax ) {

			include( plugin_dir_path( __FILE__ ) . 'partials/agency-portfolio-public-filters-select.php' );

		} // foreach

		return $return;

	} // get_portfolio_filters()

/**
 * Returns a post object of portfolio posts
 *
 * @param 	array 		$params 			An array of optional parameters
 *                           types 			An array of portfolio item type slugs
 *                           industries		An array of portfolio industry slugs
 *                           quantity		Number of posts to return
 *
 * @return 	object 		A post object
 */
	private function get_portfolio_items( $params ) {

		$return = '';

		$args['post_type'] 				= 'portfolio';
		$args['post_status'] 			= 'publish';
		$args['order_by'] 				= 'date';
		$args['posts_per_page'] 		= 20;
		$args['no_found_rows']			= true;
		$args['update_post_meta_cache'] = false;
		$args['update_post_term_cache'] = false;

		if ( ! empty( $params['quantity'] ) ) {

			$args['posts_per_page'] = $params['quantity'];

		}

		if ( ! empty( $params['types'] ) ) {

			$args['tax_query'][]['taxonomy'] 	= 'portfolio_item_type';
			$args['tax_query'][]['field'] 		= 'slug';
			$args['tax_query'][]['terms'] 		= $params['types'];

		}

		if ( ! empty( $params['industries'] ) ) {

			$args['tax_query'][]['taxonomy'] 	= 'portfolio_industry';
			$args['tax_query'][]['field'] 		= 'slug';
			$args['tax_query'][]['terms'] 		= $params['industries'];

		}

		if ( ! empty( $params['types'] ) && ! empty( $params['industries'] ) ) {

			$args['tax_query']['relation'] = 'AND';

		}

		$query = new WP_Query( $args );

		if ( 0 > $query->found_posts ) {

			$return = '<p>No portfolio items to display.</p>';

		} else {

			$return = $query;

		}

		return $return;

	} // get_portfolio_items()

/**
 * Returns the URL of the featured image
 *
 * @param 	int 		$postID 		The post ID
 * @param 	string 		$size 			The image size to return
 *
 * @return 	string | bool 				The URL of the featured image, otherwise FALSE
 */
	private function get_thumbnail_url( $postID, $size = 'thumbnail' ) {

		if ( empty( $postID ) ) { return FALSE; }

		$thumb_id = get_post_thumbnail_id( $postID );

		if ( empty( $thumb_id ) ) { return FALSE; }

		$thumb_array = wp_get_attachment_image_src( $thumb_id, $size, true );

		if ( empty( $thumb_array ) ) { return FALSE; }

		return $thumb_array[0];

	} // get_thumbnail_url()

} // class
