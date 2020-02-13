<?php

/**
 *
 * @link              http://mohiuddinabdulkader.website
 * @since             1.0.0
 * @package           The_Shop_Rental
 *
 * @wordpress-plugin
 * Plugin Name:       The Shop Rental
 * Plugin URI:        http://mohiuddinabdulkader.website
 * Description:       The shop rental is a new way to rent out products on WordPress.
 * Version:           1.0.0
 * Author:            Mohiuddin Abdul Kader
 * Author URI:        http://mohiuddinabdulkader.website
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       the-shop-rental
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'THSR_VERSION', '1.0.0' );
define( 'THSR_URL', plugins_url( '/', __FILE__ ) );
define( 'THSR_ADMIN_URL', THSR_URL . 'admin/' );
define( 'THSR_PUBLIC_URL', THSR_URL . 'public/' );

define( 'THSR_FILE', __FILE__ );
define( 'THSR_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'THSR_ADMIN_DIR_PATH', THSR_ROOT_DIR_PATH . 'admin/' );
define( 'THSR_PUBLIC_PATH', THSR_ROOT_DIR_PATH . 'public/' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-the-shop-rental-activator.php
 */
function activate_the_shop_rental() {
	require_once THSR_ROOT_DIR_PATH . 'includes/class-the-shop-rental-activator.php';
	The_Shop_Rental_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-the-shop-rental-deactivator.php
 */
function deactivate_the_shop_rental() {
	require_once THSR_ROOT_DIR_PATH . 'includes/class-the-shop-rental-deactivator.php';
	The_Shop_Rental_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_the_shop_rental' );
register_deactivation_hook( __FILE__, 'deactivate_the_shop_rental' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require THSR_ROOT_DIR_PATH . 'includes/class-the-shop-rental.php';

# Quote Single Page.
function shop_rental_template($single_template) {
	global $post;
	if ($post->post_type == 'the-rental-qoute') {
		$single_template = dirname( __FILE__ ) . '/templates/quote-single.php';
	}
	return $single_template;
}
add_filter( "single_template", "shop_rental_template" ) ;



// if(!function_exists('shoprental_excerpt_max_charlength')):
// 	function shoprental_excerpt_max_charlength($charlength) {
// 		$excerpt = get_the_excerpt();
// 		$charlength++;
// 		if ( mb_strlen( $excerpt ) > $charlength ) {
// 			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
// 			$exwords = explode( ' ', $subex );
// 			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
// 			if ( $excut < 0 ) {
// 				return mb_substr( $subex, 0, $excut );
// 			} else {
// 				return $subex;
// 			}
// 		} else {
// 			return $excerpt;
// 		}
// 		echo 'AAA';
// 	}
// endif;


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_the_shop_rental() {

	$plugin = new The_Shop_Rental();
	$plugin->run();

}
run_the_shop_rental();

add_action('wp_enqueue_scripts', 'qg_enqueue');
function qg_enqueue() {

	wp_enqueue_style( 'jqueryui', plugin_dir_url( __FILE__ ) . 'public/css/jquery-ui.theme.min.css', array(), false, false );
	wp_enqueue_style( 'jqueryui-min', plugin_dir_url( __FILE__ ) . 'public/css/jquery-ui.theme.min.css', array(), false, false );
	wp_enqueue_script( 'shop-jquery-ui', plugin_dir_url( __FILE__ ) . 'public/js/jquery-ui.min.js', array( 'jquery' ), false, false );
}

add_action( 'wp_footer', 'checkout_datepciker' );
function checkout_datepciker() {
	?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.input-date').datepicker({
			yearRange: "-100:+0",
			changeYear: true,
			changeMonth: true,
			dateFormat: 'dd-mm-yy' 
		});
	})
</script>
	<?php
}

add_image_size('rental_size_img', 248, 248, true);

