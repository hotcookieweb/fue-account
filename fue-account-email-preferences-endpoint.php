<?php

/*
Plugin Name: FUE Account Email Preferences
Plugin URI: based on the My_Custom_My_Account_Endpoint plugin https://gist.github.com/claudiosanches/a79f4e3992ae96cb821d3b357834a005#file-custom-my-account-endpoint-php
Description: integrate FUE email preferences into account page
Author: Tony Roug
Version: 1.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: woocommerce
Domain Path: /languages/
*/

class FUE_Account_Endpoint {
	/**
	 * Plugin actions.
	 */
	public function __construct() {
		/**
		 * Custom endpoint name.
		 *
		 * @var string
		 */
		$this->pref_endpoint = get_option( 'fue_email_preferences_endpoint', 'email-preferences');
		$this->sub_endpoint = get_option( 'fue_email_subscriptions_endpoint', 'email-subscriptions');
		$this->unsub_endpoint = get_option( 'fue_unsubscribe_endpoint', 'unsubscribe');

		// Actions used to insert a new endpoint in the WordPress.
		add_action( 'init', array( $this, 'add_endpoints' ), 90);
		add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );

		// Change the My Account page title.
		add_filter( 'the_title', array( $this, 'endpoint_title' ) );

		// Insering your new tab/page into the My Account page.
		add_filter( 'woocommerce_account_menu_items', array( $this, 'new_menu_items' ) );
		// remove FUE default output for hook - from class-fue-query.php
		remove_filters_for_anonymous_class( 'template_redirect', 'FUE_Query', 'load_template', 0);
		// add processing from this class
		add_action( 'woocommerce_account_' . $this->pref_endpoint .  '_endpoint', array( $this, 'endpoint_content' ) );
		add_action( 'woocommerce_account_' . $this->sub_endpoint .  '_endpoint', array( $this, 'endpoint_content' ) );
		add_action( 'woocommerce_account_' . $this->unsub_endpoint .  '_endpoint', array( $this, 'endpoint_content' ) );
	}

	/**
	 * Register new endpoint to use inside My Account page.
	 *
	 * @see https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
	 */
	public function add_endpoints() {
		add_rewrite_endpoint( $this->pref_endpoint, EP_ROOT | EP_PAGES );
		add_rewrite_endpoint( $this->sub_endpoint, EP_ROOT | EP_PAGES );
		add_rewrite_endpoint( $this->unsub_endpoint, EP_ROOT | EP_PAGES );
		flush_rewrite_rules();
	}

	/**
	 * Add new query var.
	 *
	 * @param array $vars
	 * @return array
	 */
	public function add_query_vars( $vars ) {
		$vars[] = $this->pref_endpoint;
		$vars[] = $this->sub_endpoint;
		$vars[] = $this->unsub_endpoint;
		return $vars;
	}

	/**
	 * Set endpoint title.
	 *
	 * @param string $title
	 * @return string
	 */
	public function endpoint_title( $title ) {
		global $wp_query;

		$is_endpoint = isset( $wp_query->query_vars[ $this->pref_endpoint ] )  || isset( $wp_query->query_vars[ $this->sub_endpoint ] ) || isset( $wp_query->query_vars[ $this->unsub_endpoint ] );
		if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {

			$title = __( get_option( 'fue_email_subscriptions_page_title', 'Update Subscriptions' ), 'woocommerce' );

			remove_filter( 'the_title', array( $this, 'endpoint_title' ) );
		}

		return $title;
	}

	/**
	 * Insert the new endpoint into the My Account menu.
	 *
	 * @param array $items
	 * @return array
	 */
	public function new_menu_items( $items ) {
		// Remove the logout menu item.
		$logout = $items['customer-logout'];
		unset( $items['customer-logout'] );
		// Insert your custom endpoint.
		$items[ $this->pref_endpoint ] = __( get_option( 'fue_email_subscriptions_page_title', 'Update Subscriptions' ), 'woocommerce' );

		// Insert back the logout item.
		$items['customer-logout'] = $logout;

		return $items;
	}

	/**
	 * Endpoint HTML content.
	 */
	public function endpoint_content() {
		include_once( 'fue_account_emails.php' );
	}
}

function fue_account_init() {
	new FUE_Account_Endpoint();
}
add_action('init', 'fue_account_init', 90 );

/*
** if got to login form by unsubscribe redirect, add unsubscribe option below login and register
*/
function fue_account_unsubscribe() {
		global $wp_query;
		if (isset( $wp_query->query_vars[ get_option( 'fue_unsubscribe_endpoint', 'unsubscribe') ])) {
			include_once( 'email-unsubscribe.php' );
		}

}
add_action( 'woocommerce_after_customer_login_form', 'fue_account_unsubscribe');

/*
** fix bug in fue-functions.php fue_get_unsubscribe_url that forces unsubscribe to be under site.
** should be under account
*/
function fue_account_unsubscribe_url($url) {
	$unsubscribe = get_option( 'fue_unsubscribe_endpoint', 'unsubscribe' );
	$myaccount = wc_get_page_permalink( 'myaccount' );
	$site = site_url( "/$unsubscribe/" );
	return($site . $myaccount . $unsubscribe);
}
return add_filter( 'fue_email_unsubscribe_url', 'fue_account_unsubsribe_url', 1 );

/*
** nothing to do because object will be recreated on next page load.
function fue_account_update($data) {
}
add_action('fue_settings_subscribers_save', 'fue_account_update', 10, 1);
*/

/**
 * Allow to remove method for an hook when, it's a class method used and class don't have variable, but you know the class name :)
 */
function remove_filters_for_anonymous_class( $hook_name = '', $class_name = '', $method_name = '', $priority = 0 ) {
	global $wp_filter;

	// Take only filters on right hook name and priority
	if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
		return false;
	}

	// Loop on filters registered
	foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
		// Test if filter is an array ! (always for class/method)
		if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
			// Test if object is a class, class and method is equal to param !
			if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) == $class_name && $filter_array['function'][1] == $method_name ) {
				// Test for WordPress >= 4.7 WP_Hook class (https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/)
				if ( is_a( $wp_filter[ $hook_name ], 'WP_Hook' ) ) {
					unset( $wp_filter[ $hook_name ]->callbacks[ $priority ][ $unique_id ] );
				} else {
					unset( $wp_filter[ $hook_name ][ $priority ][ $unique_id ] );
				}
			}
		}

	}

	return false;
}
