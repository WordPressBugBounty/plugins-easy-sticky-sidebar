<?php
/**
 * Plugin Name: WP CTA Pro
 * Description: WP CTA Pro - Call to action builder with tons of options. Ideal for ecommerce, lead generation, affiliate marketing and even regular blogs.
 * Version: 1.1.4
 * Author: WP CTA PRO
 * Author URI: https://wpctapro.com/
 * Text Domain: wp-cta-pro
 *
 * @package wordpress-cta-pro
 */
 
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define UTMV_PLUGIN_FILE PRO.
if (!defined('WORDPRESS_CTA_PRO_PLUGIN_FILE')) {
    define('WORDPRESS_CTA_PRO_PLUGIN_FILE', __FILE__);
}

//define Constants
define('WORDPRESS_CTA_PRO_VERSION', '1.1.4');
define('WORDPRESS_CTA_PRO_BASENAME', plugin_basename(__FILE__));
define('WORDPRESS_CTA_PRO_DIR', dirname(__FILE__));
define('WORDPRESS_CTA_PRO_URI', plugin_dir_url(__FILE__));
define('WORDPRESS_CTA_PRO_FILE', __FILE__);

 
if ( ! function_exists( '_is_sticky_installed' ) ) {
	function _is_sticky_installed() {
		$file_path = 'easy-sticky-sidebar/sticky-sidebar.php';
		$installed_plugins = get_plugins();
		return isset( $installed_plugins[ $file_path ] );
	}
}

add_action( 'plugins_loaded', function(){
	if (!class_exists('SSuprydpStickySidebar')) {
		add_action( 'admin_notices', 'ad_error_notice' );
	}

	function ad_error_notice() { 
		?>
	    <div class="error notice">		
			<?php
				$plugin = 'easy-sticky-sidebar/sticky-sidebar.php';
				if ( _is_sticky_installed() ) {
					if ( ! current_user_can( 'activate_plugins' ) ) {
						return;
					}

					$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
					$message =  '<p>' .  __( 'WP CTA Plugin Pro is not working because you need to activate the WordPress CTA Plugin FREE plugin. <br/> <a' ). '</p>';
					$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Activate WordPress CTA Plugin FREE Now', 'easy-sticky-sidebarPro' ) ) . '</p>';
					echo $message;
				} else {
					if ( ! current_user_can( 'install_plugins' ) ) {
						return;
					}

					/* Installed from wordpress.org */				
					$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=easy-sticky-sidebar' ), 'install-plugin_easy-sticky-sidebar' );
					
					$message = '<p>' . __( 'WP CTA Plugin Pro is not working because you need to install the WordPress CTA Plugin FREE plugin.', 'sticky-sidebar-pro' ) . '</p>';
					$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Install WordPress CTA Plugin FREE', 'sticky-sidebar-pro' ) ) . '</p>';
					echo $message;
				}
			?>		
	    </div><?php 
	}
});

include_once WORDPRESS_CTA_PRO_DIR . '/inc/helpers.php';
include_once WORDPRESS_CTA_PRO_DIR . '/inc/settings-hooks.php';
include_once WORDPRESS_CTA_PRO_DIR . '/inc/class-wordpress-cta-pro.php';

// Load WC_AM_Client class if it exists.
if ( ! class_exists( 'WC_AM_Client_2_8_1' ) ) {
	require_once WORDPRESS_CTA_PRO_DIR . '/inc/wc-am-client.php';
}

/**
 * Returns the main instance of Wordpress_CTA_Pro.
 * @since  1.0.0
 * @return Wordpress_CTA_Pro
 */
function Wordpress_CTA_Pro() {
    return Wordpress_CTA_Pro::instance();
}

// Global for backwards compatibility.
$GLOBALS['wordpress_cta_pro'] = Wordpress_CTA_Pro();

register_activation_hook( WORDPRESS_CTA_PRO_BASENAME, array( Wordpress_CTA_Pro(), 'activate' ) );