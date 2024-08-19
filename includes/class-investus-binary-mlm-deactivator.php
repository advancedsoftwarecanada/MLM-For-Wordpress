<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://asecc2021.com/andrew-normore
 * @since      1.0.0
 *
 * @package    investus_binary_mlm
 * @subpackage investus_binary_mlm/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    investus_binary_mlm
 * @subpackage investus_binary_mlm/includes
 * @author     Andrew Normore <andy@asecc2021.com>
 */
class investus_binary_mlm_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		
		global $wpdb;
		global $asecc_ca_db_version;
		$asecc_ca_db_version = '1.0';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		
		// Lets DEACTIVATE, maybe add a call back for uninstall and prompt for data deletion
		// $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}imlm_distributors" );
		// $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}imlm_distributor_payments" );
		// $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}imlm_product_volumes" );
		// $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}imlm_volumes" );
		// $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}imlm_ranks" );
		// $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}imlm_corporate" );
	
		
		
		
		
		

	}

}
