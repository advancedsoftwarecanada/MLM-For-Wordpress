<?php

/**
 * Fired during plugin activation
 *
 * @link       https://asecc2021.com/andrew-normore
 * @since      1.0.0
 *
 * @package    investus_binary_mlm
 * @subpackage investus_binary_mlm/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    investus_binary_mlm
 * @subpackage investus_binary_mlm/includes
 * @author     Andrew Normore <andy@asecc2021.com>
 */
class investus_binary_mlm_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	 

	public static function activate() {

		global $wpdb;
		global $imlm_db_version;
		$imlm_db_version = '1.0';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		
		add_option( 'imlm_db_version_clients', $imlm_db_version );
		add_option( 'imlm_db_version_', $imlm_db_version );
		add_option( 'imlm_db_version_alerts', $imlm_db_version );
		
		
		$wpdb->query( "CREATE TABLE ".$wpdb->prefix."imlm_distributors (
			id mediumint(20)  AUTO_INCREMENT,
			timestamp varchar(100),
			wp_user_id mediumint(100),
			imlm_distributor_id varchar(100),
			imlm_upline_distributor_id varchar(100),
			imlm_enroller_distributor_id varchar(100),
			imlm_downline_left_distributor_id varchar(100),
			imlm_downline_right_distributor_id varchar(100),
			
			monthly_personal_volume varchar(100),
			monthly_team_volume varchar(100),
			total_team_volume varchar(100),
			
			PRIMARY KEY  (id)
		)");
		
		$wpdb->query( "CREATE TABLE ".$wpdb->prefix."imlm_distributor_payments (
			id mediumint(20)  AUTO_INCREMENT,
			timestamp varchar(100),
			imlm_distributor_id mediumint(100),
			volume_total mediumint(100),
			dollar_total mediumint(100),
			dollar_currency mediumint(100),
			PRIMARY KEY  (id)
		)");

		$wpdb->query(   "CREATE TABLE ".$wpdb->prefix."imlm_product_volumes (
			id mediumint(20)  AUTO_INCREMENT,
			volume mediumint(100),
			woocommerce_product_id mediumint(100),
			PRIMARY KEY  (id)
		)");
		
		$wpdb->query(   "CREATE TABLE ".$wpdb->prefix."imlm_volumes (
			id mediumint(20)  AUTO_INCREMENT,
			timestamp varchar(100),
			status varchar(100),
			volume mediumint(100),
			imlm_distributor_id mediumint(100),
			woocommerce_order_id mediumint(100),
			PRIMARY KEY  (id)
		)");
		
		
		$wpdb->query(  "CREATE TABLE ".$wpdb->prefix."imlm_ranks (
			id mediumint(20)  AUTO_INCREMENT,
			rank_title varchar(100),
			commission_percent varchar(100),
			required_team_volume varchar(100),
			PRIMARY KEY  (id)
		)");
		
		
		$wpdb->query(  "CREATE TABLE ".$wpdb->prefix."imlm_corporate (
			id mediumint(20)  AUTO_INCREMENT,
			PRIMARY KEY  (id)
		)");
		
		

	}

}
