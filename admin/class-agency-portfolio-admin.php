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
	 * The admin generator object
	 *
	 * @since 	1.0.0
	 * @access 	private
	 * @var 	object 		$admingen		The admin generator class instance
	 */
	private $admingen;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $i18n    The ID of this plugin.
	 */
	private $i18n;

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
	 * @var      string    $i18n       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $i18n, $version ) {

		$this->i18n 	= $i18n;
		$this->version 	= $version;
		$this->options 	= 'testoptions';

		//$this->load_dependencies();
		//$this->set_locale();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Agency_Portfolio_Loader. Orchestrates the hooks of the plugin.
	 * - Agency_Portfolio_i18n. Defines internationalization functionality.
	 * - Agency_Portfolio_Admin. Defines all hooks for the dashboard.
	 * - Agency_Portfolio_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-agency-portfolio-admin-generator.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-agency-portfolio-field-generator.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-agency-portfolio-sanitizer.php';

		//$this->admingen = new Agency_Portfolio_Admin_Generator();

	} // load_dependencies()

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
				$this->i18n,
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

		wp_enqueue_style( $this->i18n, plugin_dir_url( __FILE__ ) . 'css/agency-portfolio-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->i18n, plugin_dir_url( __FILE__ ) . 'js/agency-portfolio-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Creates a new custom post type
	 *
	 * @uses   register_post_type()
	 */
	public function new_cpt_portfolio() {

		$cap_type 	= 'post';
		$plural 	= 'Portfolio Items';
		$single 	= 'Portfolio Item';
		$cpt_name 	= 'Portfolio';

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

		$opts['labels']['add_new']						= __( "Add New {$single}", $this->i18n );
		$opts['labels']['add_new_item']					= __( "Add New {$single}", $this->i18n );
		$opts['labels']['all_items']					= __( $plural, $this->i18n );
		$opts['labels']['edit_item']					= __( "Edit {$single}" , $this->i18n);
		$opts['labels']['menu_name']					= __( $cpt_name, $this->i18n );
		$opts['labels']['name']							= __( $plural, $this->i18n );
		$opts['labels']['name_admin_bar']				= __( $single, $this->i18n );
		$opts['labels']['new_item']						= __( "New {$single}", $this->i18n );
		$opts['labels']['not_found']					= __( "No {$plural} Found", $this->i18n );
		$opts['labels']['not_found_in_trash']			= __( "No {$plural} Found in Trash", $this->i18n );
		$opts['labels']['parent_item_colon']			= __( "Parent {$plural} :", $this->i18n );
		$opts['labels']['search_items']					= __( "Search {$plural}", $this->i18n );
		$opts['labels']['singular_name']				= __( $single, $this->i18n );
		$opts['labels']['view_item']					= __( "View {$single}", $this->i18n );

		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= __( strtolower( $plural ), $this->i18n );
		$opts['rewrite']['with_front']					= FALSE;

		register_post_type( strtolower( $cpt_name ), $opts );

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

		$opts['labels']['add_new_item'] 				= __( "Add New {$single}", $this->i18n );
		$opts['labels']['add_or_remove_items'] 			= __( "Add or remove {$plural}", $this->i18n );
		$opts['labels']['all_items'] 					= __( $plural, $this->i18n );
		$opts['labels']['choose_from_most_used'] 		= __( "Choose from most used {$plural}", $this->i18n );
		$opts['labels']['edit_item'] 					= __( "Edit {$single}" , $this->i18n);
		$opts['labels']['menu_name'] 					= __( $plural, $this->i18n );
		$opts['labels']['name'] 						= __( $plural, $this->i18n );
		$opts['labels']['new_item_name'] 				= __( "New {$single} Name", $this->i18n );
		$opts['labels']['not_found'] 					= __( "No {$plural} Found", $this->i18n );
		$opts['labels']['parent_item'] 					= __( "Parent {$single}", $this->i18n );
		$opts['labels']['parent_item_colon'] 			= __( "Parent {$single}:", $this->i18n );
		$opts['labels']['popular_items'] 				= __( "Popular {$plural}", $this->i18n );
		$opts['labels']['search_items'] 				= __( "Search {$plural}", $this->i18n );
		$opts['labels']['separate_items_with_commas'] 	= __( "Separate {$plural} with commas", $this->i18n );
		$opts['labels']['singular_name'] 				= __( $single, $this->i18n );
		$opts['labels']['update_item'] 					= __( "Update {$single}", $this->i18n );
		$opts['labels']['view_item'] 					= __( "View {$single}", $this->i18n );

		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= __( strtolower( $tax_name ), $this->i18n );
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

		$opts['labels']['add_new_item'] 				= __( "Add New {$single}", $this->i18n );
		$opts['labels']['add_or_remove_items'] 			= __( "Add or remove {$plural}", $this->i18n );
		$opts['labels']['all_items'] 					= __( $plural, $this->i18n );
		$opts['labels']['choose_from_most_used'] 		= __( "Choose from most used {$plural}", $this->i18n );
		$opts['labels']['edit_item'] 					= __( "Edit {$single}" , $this->i18n);
		$opts['labels']['menu_name'] 					= __( $plural, $this->i18n );
		$opts['labels']['name'] 						= __( $plural, $this->i18n );
		$opts['labels']['new_item_name'] 				= __( "New {$single} Name", $this->i18n );
		$opts['labels']['not_found'] 					= __( "No {$plural} Found", $this->i18n );
		$opts['labels']['parent_item'] 					= __( "Parent {$single}", $this->i18n );
		$opts['labels']['parent_item_colon'] 			= __( "Parent {$single}:", $this->i18n );
		$opts['labels']['popular_items'] 				= __( "Popular {$plural}", $this->i18n );
		$opts['labels']['search_items'] 				= __( "Search {$plural}", $this->i18n );
		$opts['labels']['separate_items_with_commas'] 	= __( "Separate {$plural} with commas", $this->i18n );
		$opts['labels']['singular_name'] 				= __( $single, $this->i18n );
		$opts['labels']['update_item'] 					= __( "Update {$single}", $this->i18n );
		$opts['labels']['view_item'] 					= __( "View {$single}", $this->i18n );

		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= __( strtolower( $tax_name ), $this->i18n );
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
