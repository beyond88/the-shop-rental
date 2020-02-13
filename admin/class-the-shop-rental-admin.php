<?php

/**
 *
 * @link       http://mohiuddinabdulkader.website
 * @since      1.0.0
 *
 * @package    The_Shop_Rental
 * @subpackage The_Shop_Rental/admin
 * @author     Mohiuddin Abdul Kader <muhin.cse.diu@gmail.com>
 */
class The_Shop_Rental_Admin {


	private $plugin_name;
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'admin_menu', array($this, 'shop_rental_admin_menu') ); 

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {


		wp_enqueue_style( $this->plugin_name, THSR_ADMIN_URL . 'css/the-shop-rental-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, THSR_ADMIN_URL . 'js/the-shop-rental-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function shop_rental_admin_menu(){
		add_submenu_page('edit.php?post_type=the-rental-qoute', __('Settings', 'the-shop-rental'), __('Settings', 'the-shop-rental'), 'manage_options', 'the-shop-rental', array( $this, 'email_settings'));	
	}
	
	public function email_settings() {

		include plugin_dir_path( __FILE__ ) . 'partials/email-settings.php';	
	}

}
