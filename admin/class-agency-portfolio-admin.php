<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://slushman.com/plugins/agency-portfolio
 * @since      1.0.0
 *
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/admin
 * @author     Slushman <chris@slushman.com>
 */
class Agency_Portfolio_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plug_name    The ID of this plugin.
	 */
	private $plug_name;

	/**
	 * The name of the plugin options
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $options    The array of plugin options
	 */
	private $options;

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
	 * @var      string    $plug_name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plug_name, $version ) {

		$this->plugin_name 	= $plug_name;
		$this->version 		= $version;
		$this->options 		= 'testoptions';

	}

	/**
	 * Adds the plugin settings page to the appropriate admin menu
	 *
	 * @since	0.1
	 *
	 * @uses	add_options_page
	 */
		function add_menu() {

			add_options_page(
				'Agency Portfolio Options',
				'Agency Portfolio',
				'manage_options',
				'agency-portfolio',
				array( $this, 'settings_page' )
			);

		} // add_menu()

	/**
	 * [create_options description]
	 * @return [type] [description]
	 */
	public function create_options() {

		$opts['listorselect'] = 'select';

		update_option( $this->options, $opts );

	} // create_options()

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		//wp_enqueue_style( 'agency-portfolio', plugin_dir_url( __FILE__ ) . 'css/agency-portfolio-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		//wp_enqueue_script( 'agency-portfolio', plugin_dir_url( __FILE__ ) . 'js/agency-portfolio-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Creates a new custom post type
	 *
	 * @uses   register_post_type()
	 */
	public static function new_cpt_portfolio() {

		$cap_type 	= 'post';
		$plural 	= 'Portfolio Items';
		$single 	= 'Portfolio Item';
		$cpt_name 	= 'portfolio';

		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= '';
		$opts['exclude_from_search']					= FALSE;
		$opts['has_archive']							= FALSE;
		$opts['hierarchical']							= FALSE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= 'dashicons-portfolio';
		$opts['menu_position']							= 25;
		$opts['public']									= TRUE;
		$opts['publicly_querable']						= TRUE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title', 'editor', 'thumbnail' );
		$opts['taxonomies']								= array();

		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";

		$opts['labels']['add_new']						= esc_html__( "Add New {$single}", 'agency-portfolio' );
		$opts['labels']['add_new_item']					= esc_html__( "Add New {$single}", 'agency-portfolio' );
		$opts['labels']['all_items']					= esc_html__( $plural, 'agency-portfolio' );
		$opts['labels']['edit_item']					= esc_html__( "Edit {$single}" , 'agency-portfolio');
		$opts['labels']['menu_name']					= esc_html__( $cpt_name, 'agency-portfolio' );
		$opts['labels']['name']							= esc_html__( $plural, 'agency-portfolio' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'agency-portfolio' );
		$opts['labels']['new_item']						= esc_html__( "New {$single}", 'agency-portfolio' );
		$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'agency-portfolio' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'agency-portfolio' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'agency-portfolio' );
		$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'agency-portfolio' );
		$opts['labels']['singular_name']				= esc_html__( $single, 'agency-portfolio' );
		$opts['labels']['view_item']					= esc_html__( "View {$single}", 'agency-portfolio' );

		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= $cpt_name;
		$opts['rewrite']['with_front']					= FALSE;

		register_post_type( $cpt_name, $opts );

	} // new_cpt_portfolio()

/**
 * Creates a new taxonomy for a custom post type
 *
 * @uses   register_taxonomy()
 */
	public function new_tax_portfolio_item_type() {

		$plural 	= 'Types';
		$single 	= 'Type';
		$tax_name 	= 'portfolio_item_type';

		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';

		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';

		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'agency-portfolio' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'agency-portfolio' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'agency-portfolio' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'agency-portfolio' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'agency-portfolio');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'agency-portfolio' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'agency-portfolio' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'agency-portfolio' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'agency-portfolio' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'agency-portfolio' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'agency-portfolio' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'agency-portfolio' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'agency-portfolio' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'agency-portfolio' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'agency-portfolio' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'agency-portfolio' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'agency-portfolio' );

		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'agency-portfolio' );
		$opts['rewrite']['with_front']					= FALSE;

		register_taxonomy( $tax_name, 'portfolio', $opts );

	} // new_tax_portfolio_item_type()

/**
 * Creates a new taxonomy for a custom post type
 *
 * @uses   register_taxonomy()
 */
	public function new_tax_industry() {

		$plural 	= 'Industries';
		$single 	= 'Industry';
		$tax_name 	= 'portfolio_industry';

		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';

		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';

		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'agency-portfolio' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'agency-portfolio' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'agency-portfolio' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'agency-portfolio' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'agency-portfolio');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'agency-portfolio' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'agency-portfolio' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'agency-portfolio' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'agency-portfolio' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'agency-portfolio' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'agency-portfolio' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'agency-portfolio' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'agency-portfolio' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'agency-portfolio' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'agency-portfolio' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'agency-portfolio' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'agency-portfolio' );

		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'agency-portfolio' );
		$opts['rewrite']['with_front']					= FALSE;

		register_taxonomy( $tax_name, 'portfolio', $opts );

	} // new_tax_industry()

	/**
	 * Creates the settings page
	 *
	 * @since	0.1
	 *
	 * @uses	plugins_url
	 * @uses	settings_fields
	 * @uses	do_settings_sections
	 * @uses	submit_button
	 */
		function settings_page() {

			?><form method="post" action="options.php"><?php

				settings_fields( $tab );
				do_settings_sections( $tab );
				submit_button(); ?>

			</form><?php

		} // settings_page()

} // class
