<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://mohiuddinabdulkader.website
 * @since      1.0.0
 *
 * @package    The_Shop_Rental
 * @subpackage The_Shop_Rental/includes
 * @author     Mohiuddin Abdul Kader <muhin.cse.diu@gmail.com>
 */
class The_Shop_Rental {

	protected $loader;
	protected $plugin_name;
	protected $version;
	private $post_type = 'the-shop-rental';
	private $crew_post_type = 'the-crew';
	private $qoute_post_type = 'the-rental-qoute';
	
	
	/**
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'THSR_VERSION' ) ) {
			$this->version = THSR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'the-shop-rental';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_action( 'init', array( $this, 'crew_post_type' ) );
		add_action( 'init', array( $this, 'crew_taxonomy' ) );
		add_action( 'init', array( $this, 'quotes_post_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'qoutes_register_meta_boxes' ) );
		add_action( 'admin_menu', array( $this, 'disable_new_posts') );	
		add_action( 'init', array( $this, 'register_the_shop_rental_shortcode' ) );
		add_action( 'init', array( $this, 'register_the_rental_checkout_shortcode' ) );
		add_action( 'init', array( $this, 'register_the_rental_thanku_shortcode' ) );
				
	}

	/**
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-the-shop-rental-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-the-shop-rental-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-the-shop-rental-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-the-shop-rental-public.php';

		$this->loader = new The_Shop_Rental_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the The_Shop_Rental_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new The_Shop_Rental_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new The_Shop_Rental_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new The_Shop_Rental_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    The_Shop_Rental_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
     * Register the post type
     *
     * @return void
     */
    function register_post_type() {

		$labels = array(
			'name'                  => _x( 'Rental Items', 'Post Type General Name', 'the-shop-rental' ),
			'singular_name'         => _x( 'Rental Item', 'Post Type Singular Name', 'the-shop-rental' ),
			'menu_name'             => __( 'Rental Items', 'the-shop-rental' ),
			'name_admin_bar'        => __( 'Rental Item', 'the-shop-rental' ),
			'archives'              => __( 'Item Archives', 'the-shop-rental' ),
			'attributes'            => __( 'Item Attributes', 'the-shop-rental' ),
			'parent_item_colon'     => __( 'Parent Item:', 'the-shop-rental' ),
			'all_items'             => __( 'All Items', 'the-shop-rental' ),
			'add_new_item'          => __( 'Add New Item', 'the-shop-rental' ),
			'add_new'               => __( 'Add New Item', 'the-shop-rental' ),
			'new_item'              => __( 'New Item', 'the-shop-rental' ),
			'edit_item'             => __( 'Edit Item', 'the-shop-rental' ),
			'update_item'           => __( 'Update Item', 'the-shop-rental' ),
			'view_item'             => __( 'View Item', 'the-shop-rental' ),
			'view_items'            => __( 'View Items', 'the-shop-rental' ),
			'search_items'          => __( 'Search Item', 'the-shop-rental' ),
			'not_found'             => __( 'Not found', 'the-shop-rental' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'the-shop-rental' ),
			'featured_image'        => __( 'Rental Item Image', 'the-shop-rental' ),
			'set_featured_image'    => __( 'Set rental item image', 'the-shop-rental' ),
			'remove_featured_image' => __( 'Remove rental item image', 'the-shop-rental' ),
			'use_featured_image'    => __( 'Use as rental item image', 'the-shop-rental' ),
			'insert_into_item'      => __( 'Insert into item', 'the-shop-rental' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'the-shop-rental' ),
			'items_list'            => __( 'Items list', 'the-shop-rental' ),
			'items_list_navigation' => __( 'Items list navigation', 'the-shop-rental' ),
			'filter_items_list'     => __( 'Filter items list', 'the-shop-rental' ),
		);
		$args = array(
			'label'                 => __( 'Rental Items', 'the-shop-rental' ),
			'description'           => __( 'Rental Item Description', 'the-shop-rental' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'           	=> 'dashicons-store',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'taxonomies'          	=> array( 'rental_category' )
		);

        register_post_type( $this->post_type, $args );
	}
	
 	/**
     * Register doc tags taxonomy
     *
     * @return void
     */
    function register_taxonomy() {

        $labels = array(
            'name'                       => _x( 'Rental Categories', 'Taxonomy General Name', 'the-shop-rental' ),
            'singular_name'              => _x( 'Rental Category', 'Taxonomy Singular Name', 'the-shop-rental' ),
            'menu_name'                  => __( 'Rental Categories', 'the-shop-rental' ),
            'all_items'                  => __( 'All Categories', 'the-shop-rental' ),
            'parent_item'                => __( 'Parent Category', 'the-shop-rental' ),
            'parent_item_colon'          => __( 'Parent Category:', 'the-shop-rental' ),
            'new_item_name'              => __( 'New Category', 'the-shop-rental' ),
            'add_new_item'               => __( 'Add New Item', 'the-shop-rental' ),
            'edit_item'                  => __( 'Edit Category', 'the-shop-rental' ),
            'update_item'                => __( 'Update Category', 'the-shop-rental' ),
            'view_item'                  => __( 'View Category', 'the-shop-rental' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'the-shop-rental' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'the-shop-rental' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'the-shop-rental' ),
            'popular_items'              => __( 'Popular Categories', 'the-shop-rental' ),
            'search_items'               => __( 'Search Categories', 'the-shop-rental' ),
            'not_found'                  => __( 'Not Found', 'the-shop-rental' ),
            'no_terms'                   => __( 'No items', 'the-shop-rental' ),
            'items_list'                 => __( 'Categories', 'the-shop-rental' ),
            'items_list_navigation'      => __( 'Categories navigation', 'the-shop-rental' ),
        );

        $rewrite = array(
            'slug'                       => 'rental-category',
            'with_front'                 => true,
            'hierarchical'               => true,
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
            'show_in_rest'               => true,
            'rewrite'                    => $rewrite
        );

        register_taxonomy( 'rental_category', array( 'the-shop-rental' ), $args );

	}
	
	/**
     * Register the post type
     *
     * @return void
     */
    function crew_post_type() {

		$labels = array(
			'name'                  => _x( 'Crews', 'Post Type General Name', 'the-shop-rental' ),
			'singular_name'         => _x( 'Crew', 'Post Type Singular Name', 'the-shop-rental' ),
			'menu_name'             => __( 'Crews', 'the-shop-rental' ),
			'name_admin_bar'        => __( 'Crew', 'the-shop-rental' ),
			'archives'              => __( 'Crew Archives', 'the-shop-rental' ),
			'attributes'            => __( 'Crew Attributes', 'the-shop-rental' ),
			'parent_item_colon'     => __( 'Parent Crew:', 'the-shop-rental' ),
			'all_items'             => __( 'All Crews', 'the-shop-rental' ),
			'add_new_item'          => __( 'Add New Crew', 'the-shop-rental' ),
			'add_new'               => __( 'Add New Crew', 'the-shop-rental' ),
			'new_item'              => __( 'New Crew', 'the-shop-rental' ),
			'edit_item'             => __( 'Edit Crew', 'the-shop-rental' ),
			'update_item'           => __( 'Update Crew', 'the-shop-rental' ),
			'view_item'             => __( 'View Crew', 'the-shop-rental' ),
			'view_items'            => __( 'View Crews', 'the-shop-rental' ),
			'search_items'          => __( 'Search Crew', 'the-shop-rental' ),
			'not_found'             => __( 'Not found', 'the-shop-rental' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'the-shop-rental' ),
			'featured_image'        => __( 'Crew Image', 'the-shop-rental' ),
			'set_featured_image'    => __( 'Set crew image', 'the-shop-rental' ),
			'remove_featured_image' => __( 'Remove crew image', 'the-shop-rental' ),
			'use_featured_image'    => __( 'Use as crew image', 'the-shop-rental' ),
			'insert_into_item'      => __( 'Insert into Crew', 'the-shop-rental' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Crew', 'the-shop-rental' ),
			'items_list'            => __( 'Items list', 'the-shop-rental' ),
			'items_list_navigation' => __( 'Items list navigation', 'the-shop-rental' ),
			'filter_items_list'     => __( 'Filter items list', 'the-shop-rental' ),
		);
		$args = array(
			'label'                 => __( 'Crew', 'the-shop-rental' ),
			'description'           => __( 'Crew Description', 'the-shop-rental' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'           	=> 'dashicons-admin-users',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'taxonomies'          	=> array( 'crew_category' )
		);

        register_post_type( $this->crew_post_type, $args );
	}
	
 	/**
     * Register doc tags taxonomy
     *
     * @return void
     */
    function crew_taxonomy() {

        $labels = array(
            'name'                       => _x( 'Crew Categories', 'Taxonomy General Name', 'the-shop-rental' ),
            'singular_name'              => _x( 'Crew Category', 'Taxonomy Singular Name', 'the-shop-rental' ),
            'menu_name'                  => __( 'Crew Categories', 'the-shop-rental' ),
            'all_items'                  => __( 'All Categories', 'the-shop-rental' ),
            'parent_item'                => __( 'Parent Category', 'the-shop-rental' ),
            'parent_item_colon'          => __( 'Parent Category:', 'the-shop-rental' ),
            'new_item_name'              => __( 'New Category', 'the-shop-rental' ),
            'add_new_item'               => __( 'Add New Item', 'the-shop-rental' ),
            'edit_item'                  => __( 'Edit Category', 'the-shop-rental' ),
            'update_item'                => __( 'Update Category', 'the-shop-rental' ),
            'view_item'                  => __( 'View Category', 'the-shop-rental' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'the-shop-rental' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'the-shop-rental' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'the-shop-rental' ),
            'popular_items'              => __( 'Popular Tags', 'the-shop-rental' ),
            'search_items'               => __( 'Search Tags', 'the-shop-rental' ),
            'not_found'                  => __( 'Not Found', 'the-shop-rental' ),
            'no_terms'                   => __( 'No items', 'the-shop-rental' ),
            'items_list'                 => __( 'Tags list', 'the-shop-rental' ),
            'items_list_navigation'      => __( 'Tags list navigation', 'the-shop-rental' ),
        );

        $rewrite = array(
            'slug'                       => 'crew-category',
            'with_front'                 => true,
            'hierarchical'               => false,
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'show_in_rest'               => true,
            'rewrite'                    => $rewrite
        );

        register_taxonomy( 'crew_category', array( 'the-crew' ), $args );

	}


	
	/**
     * Register the post type
     *
     * @return void
     */
    function quotes_post_type() {

		$labels = array(
			'name'                  => _x( 'Quotes', 'Post Type General Name', 'the-shop-rental' ),
			'singular_name'         => _x( 'Quote', 'Post Type Singular Name', 'the-shop-rental' ),
			'menu_name'             => __( 'Quotes', 'the-shop-rental' ),
			'name_admin_bar'        => __( 'Quote', 'the-shop-rental' ),
			'archives'              => __( 'Quote Archives', 'the-shop-rental' ),
			'attributes'            => __( 'Quote Attributes', 'the-shop-rental' ),
			'parent_item_colon'     => __( 'Parent Quote:', 'the-shop-rental' ),
			'all_items'             => __( 'All Quotes', 'the-shop-rental' ),
			'add_new_item'          => __( 'Name', 'the-shop-rental' ),
			'add_new'               => __( 'Add New Quote', 'the-shop-rental' ),
			'new_item'              => __( 'New Quote', 'the-shop-rental' ),
			'edit_item'             => __( 'Edit Quote', 'the-shop-rental' ),
			'update_item'           => __( 'Update Quote', 'the-shop-rental' ),
			'view_item'             => __( 'View Quote', 'the-shop-rental' ),
			'view_items'            => __( 'View Quotes', 'the-shop-rental' ),
			'search_items'          => __( 'Search Quotes', 'the-shop-rental' ),
			'not_found'             => __( 'Not found', 'the-shop-rental' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'the-shop-rental' ),
			'featured_image'        => __( 'Quote Image', 'the-shop-rental' ),
			'set_featured_image'    => __( 'Set quote image', 'the-shop-rental' ),
			'remove_featured_image' => __( 'Remove quote image', 'the-shop-rental' ),
			'use_featured_image'    => __( 'Use as quote image', 'the-shop-rental' ),
			'insert_into_item'      => __( 'Insert into Quote', 'the-shop-rental' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Quote', 'the-shop-rental' ),
			'items_list'            => __( 'Items list', 'the-shop-rental' ),
			'items_list_navigation' => __( 'Items list navigation', 'the-shop-rental' ),
			'filter_items_list'     => __( 'Filter items list', 'the-shop-rental' ),
		);
		$args = array(
			'label'                 => __( 'Quotes', 'the-shop-rental' ),
			'description'           => __( 'Quote Description', 'the-shop-rental' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'           	=> 'dashicons-media-interactive',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			// 'capabilities'          => array('read_post'),
		);

        register_post_type( $this->qoute_post_type, $args );
	}

	public function disable_new_posts() {
		// Hide sidebar link
		global $submenu;
		unset($submenu['edit.php?post_type=the-rental-qoute'][10]);
	
		// Hide link on listing page
		if (isset($_GET['post_type']) && $_GET['post_type'] == 'the-rental-qoute') {
			echo '<style type="text/css">
			#favorite-actions, .add-new-h2, .tablenav { display:none; }
			</style>';
		}
	}	

	public function qoutes_register_meta_boxes() {

		add_meta_box( 
			'qoutes_metabox',                                   		
			__( 'Qoutes Information', 'the-shop-rental' ),      
			array( $this, 'qoutes_display_meta_field' ),                            		
			   'the-rental-qoute',                                         					
			'normal'                                                		
		);
	
	}

	public function qoutes_display_meta_field( $post ) {
		return include THSR_ADMIN_DIR_PATH . 'partials/qoutes-meta-fields.php';
	}

	public function display_rental_items( $atts ) {
		
		ob_start();
		include THSR_PUBLIC_PATH .'partials/the-shop-rental-items.php';
		$shorcode_php_function = ob_get_clean();
	
		return $shorcode_php_function;		
		//return include THSR_PUBLIC_PATH .'partials/the-shop-rental-items.php';
	}	
	
	public function register_the_shop_rental_shortcode( $atts = [], $content = null ) {
		$wporg_atts = shortcode_atts( [], $atts  );	
		add_shortcode( 'the-shop-rental', array($this, 'display_rental_items') );
	}

	public function display_rental_checkout_form( $atts ) {
		return include THSR_PUBLIC_PATH .'partials/the-rental-checkout-form.php';
	}	

	public function register_the_rental_checkout_shortcode( $atts = [], $content = null ) {
		$wporg_atts = shortcode_atts( [], $atts  );	
		add_shortcode( 'the-rental-checkout', array( $this, 'display_rental_checkout_form' ) );
	}
	
	public function display_rental_thanku( $atts ) {
		return include THSR_PUBLIC_PATH .'partials/the-rental-thanku.php';
	}	

	public function register_the_rental_thanku_shortcode( $atts = [], $content = null ) {
		$wporg_atts = shortcode_atts( [], $atts  );	
		add_shortcode( 'the-rental-thankyou', array( $this, 'display_rental_thanku' ) );
	}	
	

}
