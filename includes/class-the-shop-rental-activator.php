<?php

/**
 * Fired during plugin activation
 *
 * @link       http://mohiuddinabdulkader.website
 * @since      1.0.0
 *
 * @package    The_Shop_Rental
 * @subpackage The_Shop_Rental/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    The_Shop_Rental
 * @subpackage The_Shop_Rental/includes
 * @author     Mohiuddin Abdul Kader <muhin.cse.diu@gmail.com>
 */
class The_Shop_Rental_Activator {

	public static function activate() {

		// $page_id = wp_insert_post(array(
		// 	'post_type' 		=> 'page',
		// 	'post_title' 		=> 'The Shop Rental',
		// 	'post_content' 		=> '<!-- wp:shortcode -->[' . 'the-shop-rental' . ']<!-- /wp:shortcode -->',
		// 	'post_name' 		=> 'the-shop-rental',
		// 	'post_status'    	=> 'publish',
		// ));

		// update_option( 'the_shop_rental', $page_id );

		// $page_id =  wp_insert_post(array(
		// 	'post_type' 		=> 'page',
		// 	'post_title' 		=> 'The Rental Checkout',
		// 	'post_content' 		=> '<!-- wp:shortcode -->[' . 'the-rental-checkout' . ']<!-- /wp:shortcode -->',
		// 	'post_name' 		=> 'the-rental-checkout',
		// 	'post_status'    	=> 'publish',
		// ));

		// update_option( 'the_rent_checkout', $page_id );

		// $page_id =  wp_insert_post(array(
		// 	'post_type' 		=> 'page',
		// 	'post_title' 		=> 'The Rental Thank you',
		// 	'post_content' 		=> '<!-- wp:shortcode -->[' . 'the-rental-thankyou' . ']<!-- /wp:shortcode -->',
		// 	'post_name' 		=> 'the-rental-thankyou',
		// 	'post_status'    	=> 'publish',
		// ));

		// update_option( 'the_rent_thankyou', $page_id );		
	}
	
}