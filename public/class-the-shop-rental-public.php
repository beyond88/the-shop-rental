<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://mohiuddinabdulkader.website
 * @since      1.0.0
 *
 * @package    The_Shop_Rental
 * @subpackage The_Shop_Rental/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    The_Shop_Rental
 * @subpackage The_Shop_Rental/public
 * @author     Mohiuddin Abdul Kader <muhin.cse.diu@gmail.com>
 */
class The_Shop_Rental_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;


        add_action( 'wp_ajax_addItemToQuote', array($this, 'run_addItemToQuote') );		
		add_action( 'wp_ajax_nopriv_addItemToQuote', array($this, 'run_addItemToQuote') );	
		
        add_action( 'wp_ajax_removeItemFromQuote', array($this, 'run_removeItemFromQuote') );		
		add_action( 'wp_ajax_nopriv_removeItemFromQuote', array($this, 'run_removeItemFromQuote') );

		add_action( 'wp_ajax_submitQuote', array($this, 'run_submitQuote') );		
		add_action( 'wp_ajax_nopriv_submitQuote', array($this, 'run_submitQuote') );						

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name . 'featherlight', plugin_dir_url( __FILE__ ) . 'css/featherlight.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all' );		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/the-shop-rental-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name. '-parsley', plugin_dir_url( __FILE__ ) . 'js/jquery-parsley.min.js', array( 'jquery' ), $this->version, false );
		

		wp_enqueue_script( $this->plugin_name. 'jquery.min', plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name. '-featherlight', plugin_dir_url( __FILE__ ) . 'js/featherlight.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name. '-script', plugin_dir_url( __FILE__ ) . 'js/the-shop-rental-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name. '-script', 'ajax', 
								array('ajax_url' => admin_url('admin-ajax.php'),
								'nonce' => wp_create_nonce('ajaxnonce'), 					
								)
							);
	}

	/**
	 * add Rental Item
	 *
	 * @since    1.0.0
	 */
	public function run_addItemToQuote() {

		//check_ajax_referer( 'add_rental_item' );
		//wp_send_json_error()
		$item_count = $item_id = 0;
		if( isset( $_POST["itemId"] ) ) {

			if( isset( $_COOKIE["shopping_cart"] ) ) {
				$cookie_data 	= stripslashes($_COOKIE['shopping_cart']);
				$cart_data 		= json_decode($cookie_data, true);
			}
			else
			{
				$cart_data = array();
			}

			$item_id_list = array_column($cart_data, 'item_id');

			if(in_array($_POST["itemId"], $item_id_list))
			{
				foreach($cart_data as $keys => $values)
				{
					if($cart_data[$keys]["item_id"] == $_POST["itemId"])
					{
						$cart_data[$keys]["item_name"] = $_POST["itemName"];
					}
				}
			}
			else
			{
				$item_array = array(
					'item_id'			=>	$_POST["itemId"],
					'item_name'			=>	$_POST["itemName"]
				);
				$cart_data[] = $item_array;
			}
		
			$item_count 	= count($cart_data);
			$item_id 		= $_POST["itemId"];			
			$item_data 		= json_encode($cart_data);
			setcookie( 'shopping_cart', $item_data, time() + 3600, '/', $_SERVER['HTTP_HOST'] );
			wp_send_json_success(array('rowId'=> $item_id, 'count' => $item_count));			
		} else {
			wp_send_json_error("Something went wrong!");		
		}
	
	}

	/**
	 * remove Rental Item
	 *
	 * @since    1.0.0
	 */	
	public function run_removeItemFromQuote() {

		if( isset( $_POST["itemId"] ) ) {

			$cookie_data 	= stripslashes($_COOKIE['shopping_cart']);
			$cart_data 		= json_decode($cookie_data, true);
			foreach($cart_data as $keys => $values)
			{
				if($cart_data[$keys]['item_id'] == $_POST["itemId"])
				{
					unset($cart_data[$keys]);
					$item_data 		= json_encode($cart_data);
					$item_count 	= count($cart_data);
					setcookie("shopping_cart", $item_data, time() + (86400 * 30), '/', $_SERVER['HTTP_HOST']);
					wp_send_json_success($item_count);
				}
			}
		}		
		wp_send_json_error("Something went wrong");
		//wp_die();
	}	

	/**
	 * Submit qoute
	 *
	 * @since    1.0.0
	 */	
	public function run_submitQuote() {

		$city 				= sanitize_text_field($_POST['city']);
		$companyname 		= sanitize_text_field($_POST['companyname']);
		$email 				= sanitize_text_field($_POST['email']);
		$name 				= sanitize_text_field($_POST['name']);
		$noofdays 			= sanitize_text_field($_POST['noofdays']);
		$notes 				= sanitize_text_field($_POST['notes']);
		$phone 				= sanitize_text_field($_POST['phone']);
		$quoteproducts 		= trim($_POST['quoteproducts']);
		$rentaldate 		= sanitize_text_field($_POST['rentaldate']);

		$post_id = wp_insert_post(array (
			'post_content' 		=> $notes,
			'post_title' 		=> $name,
			'post_type' 		=> 'the-rental-qoute',
			'post_status' 		=> 'publish',
		
			// some simple key / value array
			'meta_input' => array(
				'qoutes_email' => $email,
				'qoutes_mobile' => $phone,
				'qoutes_company_name' => $companyname,
				'qoutes_city' => $city,
				'qoutes_date' => $rentaldate,
				'qoutes_day' => $noofdays
			)
		));

		if( $post_id ){

            $email_info             = get_option( 'email_settings' );
            $subject                = sanitize_text_field($email_info['email_subject']);
			$message                = esc_textarea($email_info['email_message']);
			$contact_to             = 'info@eqew.sa';
			wp_mail($contact_to, $subject, $message);			

			add_post_meta( $post_id, 'qoutes_data', $quoteproducts );
			$cookie_name = 'shopping_cart';
			unset($_COOKIE[$cookie_name]);
			// empty value and expiration one hour before
			$res = setcookie($cookie_name, '', time() - 3600*24);

			$thanku = get_option( 'the_rent_thankyou' );
			if( $thanku ) { 
				$url = get_permalink( $thanku );
				wp_send_json_success(array( 'url'=> $url ));
			} else {
				$url = get_permalink();
				wp_send_json_success(array( 'url'=> $url ));
			}

		} else {
			wp_send_json_error("Something went wrong");
		}
		
	}		


	
}
