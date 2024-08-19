<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://InvestusDigital.com
 * @since             1.0.0
 * @package           investus_binary_mlm
 *
 * @wordpress-plugin
 * Plugin Name:       Investus Binary MLM
 * Plugin URI:        https://InvestusDigital.com
 * Description:       Our very own Binary MLM Platform that integrates to WooCommerce!
 * Version:           1.0.0
 * Author:            ASECC 2021
 * Author URI:        https://InvestusDigital.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       investus-binary-mlm
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
define( 'investus_binary_mlm_VERSION', '1.0.0' );
require_once("libs/encrypt_decrypt.php");


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-investus-binary-mlm-activator.php
 */
function activate_investus_binary_mlm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-investus-binary-mlm-activator.php';
	investus_binary_mlm_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-investus-binary-mlm-deactivator.php
 */
function deactivate_investus_binary_mlm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-investus-binary-mlm-deactivator.php';
	investus_binary_mlm_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_investus_binary_mlm' );
register_deactivation_hook( __FILE__, 'deactivate_investus_binary_mlm' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-investus-binary-mlm.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_investus_binary_mlm() {

	$plugin = new investus_binary_mlm();
	$plugin->run();

}
run_investus_binary_mlm();

// =========
// ENQUE SCRIPTS AND STYLES
// =========
function enqueue_admin_mlm_tools() {
    // Enqueue your script
    //wp_enqueue_script( 'googlechart', plugin_dir_url( __FILE__ ) . 'public/js/google-chart.min.js', array( 'jquery' ), '1.3', true );
    //wp_enqueue_style( 'orgchart', plugin_dir_url( __FILE__ ) . 'public/css/orgchart.css', array(), '1.0' );
}

add_action( 'admin_enqueue_scripts', 'enqueue_admin_mlm_tools' );


// ===========================
// CUSTOM CRON INTERVAL
// ===========================
function add_custom_cron_intervals( $schedules ) {
    $schedules['every_15_minutes'] = array(
        'interval' => 900, // 15 minutes in seconds (60 seconds * 15 minutes)
        'display'  => __( 'Every 15 Minutes' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'add_custom_cron_intervals' );

// ===========================
// REDIRECT USER LOGINS
// ===========================
function redirect_after_login() {
    wp_redirect('/account');
    exit;
}
add_action('wp_login', 'redirect_after_login', 10, 2);


// =========================
//
//
//
//
//
//
//
//
// GENERAL TOOLS
//
//
//
//
//
//
//
//
// =========================

// Function to convert a number to the full output of Satoshis
function number_to_bitcoin_full($input) {
    $satoshis = (float) $input;
    $bitcoin = $satoshis / 100000000; // 1 Bitcoin = 100,000,000 Satoshis
    $bitcoin_full = floatval($bitcoin);

    return $bitcoin_full;
}

function number_to_litecoin_full($input) {
	return floatval($input/100000000);
}

function number_to_ethereum_full($input) {
	return floatval($input/1000000000000000000);
}

function number_to_dollar_full($input) {
    $dollars = (float) $input;
    $dollar_full = number_format($dollars, 2);

    return $dollar_full;
}








// =========================
//
//
//
//
//
//
//
//
// ADMIN MLM CORE CODE
//
//
//
//
//
//
//
//
// =========================

// ADD ADMIN DASHBOARD LINK
add_action('admin_menu', 'imlm_admin_menu_dashboard');
function imlm_admin_menu_dashboard(){
    add_menu_page( 'Investus Binary MLM Dashboard', 'Investus Binary MLM Dashboard', 'manage_options', 'imlm-admin-dashboard', 'imlm_admin_dashboard',  "/wp-content/plugins/investus-binary-mlm/img/admin-menu.jpg");
}
 
function imlm_admin_dashboard(){
		
	global $wpdb;
	
	$action = "orgchart";
	if( isset($_REQUEST['action']) ){
		$action = $_REQUEST['action'];
	}
	
	/////////////////////////////////////
	//////////
	/////////////////////////////////////////
	//////////
	/////////////////////////////////////////
	//////////
	/////////////////////////////////////////
	//////////
	////
	
	?>

		<div class="wrap">
		
			<h1>Investus Digital Binary MLM Admin Dashboard</h1>
		
			<div style="padding:20px;">
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard" class="hide-if-no-js page-title-action">Autoship Team Volume</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=generational-comission" class="hide-if-no-js page-title-action">Generational Comission</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=distributors" class="hide-if-no-js page-title-action">Distributors</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=product-volumes" class="hide-if-no-js page-title-action">Product Volumes</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=ranks" class="hide-if-no-js page-title-action">Ranks</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=report-volumes" class="hide-if-no-js page-title-action">Report Volumes</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=report-volumes&finalize-check=1" class="hide-if-no-js page-title-action">Finalize Volumes</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=comissions" class="hide-if-no-js page-title-action">Distributor Comissions</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=corporate" class="hide-if-no-js page-title-action">Corporate Report</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=certificates" class="hide-if-no-js page-title-action">Print Certificates</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=certificates_fill" class="hide-if-no-js page-title-action">Fill Certificates</a>
				<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=wallets" class="hide-if-no-js page-title-action">Upload Wallets</a>
			</div>

		<?php
		
		// ---------------
		// DOWNLINE TEAM VOLUME
		// --------------------
		if($action=="orgchart"){
			//echo "<p>Viewing orgchart for user: 36</p>";
			//$orgchart = json_encode(get_users_with_downline("AndrewNormore"));
			//echo ($orgchart);
			
			?>
			<h1>Autoship Team Volume</h1>
			
					
			<script>
				var mlm_data = <?php echo json_encode(get_users_with_downline("AndrewNormore")); ?>;
			</script>
			
			<br />
			<div id="chart-container"></div>
			
			<link rel="stylesheet" href="https://dabeng.github.io/OrgChart/css/jquery.orgchart.css" />
			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
			<script src="https://dabeng.github.io/OrgChart/js/jquery.orgchart.js"></script>
			
			<style>
			
				.hierarchy, .orgchart {background:white !important;}
				#chart-container {
				  position: relative;
				  height: 1420px;
				  border: 1px solid #aaa;
				  margin: 0.5rem;
				  overflow: auto;
				  text-align: center;
				  background:white !important;
				}
			
				.orgchart {
					width:100%; height:1000px;
				}
				.orgchart .node .verticalEdge, .orgchart .node .horizontalEdge { 
					display: none; 
				}
				.orgchart .node:hover, .orgchart .node.focused { 
					background: none !important; 
				}
				.orgchart .nodes {
				  justify-content: center;
				}
				.orgchart .node .title {
				  width: auto;
				  text-align:center;
				  padding:0px 7px 0px 7px;
				  height:20px;
				  vertical-align: middle;
				}
				.orgchart .node .content {
				  width: auto;
				  text-align:center;
				  padding:0px 7px 0px 7px;
				  height:auto;
				  vertical-align: middle;
				}
				.parentNodeSymbol {display:none;}
				.nodeGuts{ height:auto; }
			</style>

			<script>
			   
				// Convert nested data to OrgChart-compatible format
				function convertToOrgChartFormat(data) {
					
					console.log(data);
					
					var orgChartData = {
					  id: data.wp_user_id,
					  title: data.imlm_distributor_id,
					  content: "<div class='nodeGuts'>" +
							"<b>Rank:</b> " + data.rank + "<br />" +
							"<b>Personal Volume</b>: " + data.monthly_personal_volume + "<br />" +
							
							"<hr />" +
							
							"<b>Total Team Volume</b>: " + data.monthly_total_volume + "<br />" +
							"<b>Left Leg Volume</b>: " + (parseInt(data.monthly_left_leg_volume)) + "<br />" +
							"<b>Right Leg Volume</b>: " + (parseInt(data.monthly_right_leg_volume)) + "<br />" +
							
							"<hr />" +
							
							"<b>Left Leg Carryover</b>: " + data.left_leg_carryover + "<br />" +
							"<b>Right Leg Carryover</b>: " + data.right_leg_carryover + "<br />" +
							"<b>Left Leg Distributors</b>: " + data.left_leg_distributors + "<br />" +
							"<b>Right Leg Distributors</b>: " + data.right_leg_distributors + "<br />" +
							"<b>Profit Leg</b>: " + data.profit_leg + "<br />" +
							"<b>Power Leg</b>: " + data.power_leg + "<br />" +
							
							"<hr />" +
							
							"<b>Team Volume Earnings</b>: $" + data.monthly_earnings + "<br />" +
							"<b>Generation Comission</b>: $0.00<br />" +
							"<b>Executive Bonus</b>: $0.00<br />" +
							"<b>First Time Orders</b>: $" + data.first_time_orders + "<br />" +
							"<b>Luxury Car Bonus</b>: $0.00<br />" +
							"<b>Leadership Retreat Allowance</b>: $0.00<br />" +
							
							"<hr />" +
							
							"<b>Total Payout</b>: $"+(parseFloat(data.first_time_orders)+parseFloat(data.monthly_earnings))+"<br />" +
							
							"<hr />" +
							
							"<a href=''>View Profile</a> | " +
							"<a href=''>Edit Member</a> | " +
							"<a href=''>Email</a>" +
						"</div>",
					  children: []
					};

				
					if (data.imlm_downline_left_distributor_id) {
						orgChartData.children.push(convertToOrgChartFormat(data.imlm_downline_left_distributor_id));
					} else {
						orgChartData.children.push({ id: "", title: "", content:"<a href='/wp-admin/admin.php?page=imlm-admin-dashboard&action=downline-add&left-or-right=left&imlm_distributor_id="+data.imlm_distributor_id+"'>Add Left Downline</a>", children: [], addMember: true });
					}

					if (data.imlm_downline_right_distributor_id) {
						orgChartData.children.push(convertToOrgChartFormat(data.imlm_downline_right_distributor_id));
					} else {
						orgChartData.children.push({ id: "", title: "", content:"<a href='/wp-admin/admin.php?page=imlm-admin-dashboard&action=downline-add&left-or-right=right&imlm_distributor_id="+data.imlm_distributor_id+"'>Add Right Downline</a>", children: [], addMember: true });
					}

					return orgChartData;
				}

				// Create the OrgChart
				$(document).ready(function() {
					var orgChartData = convertToOrgChartFormat(mlm_data);
					
					var orgchart = $("#chart-container").orgchart({
						data: orgChartData,
						nodeTitle: "title",
						nodeContent: "content",
						pan: true,
						zoom: true,
						grid: false,
					});

					orgchart.$chartContainer.on('touchmove', function(event) {
						event.preventDefault();
					});
				});
				

			</script>
	
	
	
	
			<?php
			
		}
		
		
		
		// ---------------
		// LEVERAGED MATCHING BONUS
		// --------------------
		if($action=="generational-comission"){
			
			//echo(json_encode(get_leveraged_matching_bonus_downline("AndrewNormore"), 128)); //testing output
			
			?>
			<h1>Generational Comission</h1>
			
			<br />
			<div id="chart-container"></div>
			
			<link rel="stylesheet" href="https://dabeng.github.io/OrgChart/css/jquery.orgchart.css" />
			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
			<script src="/wp-content/plugins/investus-binary-mlm/public/js/orgchart.js?v=12"></script>
			
			<style>
				.hierarchy, .orgchart {background:white !important;}
				#chart-container {
				  position: relative;
				  height: 1420px;
				  border: 1px solid #aaa;
				  margin: 0.5rem;
				  overflow: auto;
				  text-align: center;
				  background:white !important;
				}
			
				.orgchart {
					width:100%; height:1000px;
				}
				.orgchart .node .verticalEdge, .orgchart .node .horizontalEdge { 
					display: none; 
				}
				.orgchart .node:hover, .orgchart .node.focused { 
					background: none !important; 
				}
				.orgchart .nodes {
				  justify-content: center;
				}
				.orgchart .node .title {
				  width: auto;
				  text-align:center;
				  padding:0px 7px 0px 7px;
				  height:20px;
				  vertical-align: middle;
				}
				.orgchart .node .content {
				  width: auto;
				  text-align:center;
				  padding:0px 7px 0px 7px;
				  height:auto;
				  vertical-align: middle;
				}
				.parentNodeSymbol {display:none;}
				.nodeGuts{ height:auto; }
			</style>

		    <script>
   
			// Convert nested data to OrgChart-compatible format
			function convertToOrgChartFormat(data) {
				
				console.log(data);
				
				var orgChartData = {
				  id: data.wp_user_id,
				  title: data.imlm_distributor_id,
				  content: "<div class='nodeGuts'>" +
						"<b>Enrolment Level</b>: " + data.enrolment_level + "<br />" +
							"<b>Rank:</b> " + data.rank + "<br />" +
							"<b>Personal Volume</b>: " + data.monthly_personal_volume + "<br />" +
							
							"<hr />" +
							
							"<b>Total Team Volume</b>: " + data.monthly_total_volume + "<br />" +
							"<b>Left Leg Volume</b>: " + data.monthly_left_leg_volume + "<br />" +
							"<b>Right Leg Volume</b>: " + data.monthly_right_leg_volume + "<br />" +
							"<b>Left Leg Distributors</b>: " + data.left_leg_distributors + "<br />" +
							"<b>Right Leg Distributors</b>: " + data.right_leg_distributors + "<br />" +
							"<b>Profit Leg</b>: " + data.profit_leg + "<br />" +
							"<b>Power Leg</b>: " + data.power_leg + "<br />" +
							
							"<hr />" +
							
							"<b>Team Volume Earnings</b>: $" + data.monthly_earnings + "<br />" +
							"<b>Generation Comission</b>: $0.00<br />" +
							"<b>Executive Bonus</b>: $0.00<br />" +
							"<b>First Time Orders</b>: $" + data.first_time_orders + "<br />" +
							"<b>Luxury Car Bonus</b>: $0.00<br />" +
							"<b>Leadership Retreat Allowance</b>: $0.00<br />" +
							
							"<hr />" +
							
							"<b>Total Payout</b>: $"+(parseFloat(data.first_time_orders)+parseFloat(data.monthly_earnings))+"<br />" +
							
							"<hr />" +
							
							"<a href=''>View Profile</a> | " +
							"<a href=''>Edit Member</a> | " +
							"<a href=''>Email</a>" +
					"</div>",
				  children: []
				};
				
				if (data.children) {
					data.children.forEach(function(child){
						orgChartData.children.push(convertToOrgChartFormat(child));
					});
				}

				return orgChartData;
			}
			
			
	
			// Create the OrgChart
			$(document).ready(function() {
				
				var orgChartData = convertToOrgChartFormat(<?php echo json_encode(get_leveraged_matching_bonus_downline("AndrewNormore"), 128); ?>);
				
				var orgchart = $("#chart-container").orgchart({
					data: orgChartData,
					nodeTitle: "title",
					nodeContent: "content",
					pan: true,
					zoom: true,
					grid: false,
				});

				orgchart.$chartContainer.on('touchmove', function(event) {
					event.preventDefault();
				});
			});
		    </script>
	
	
	
	
			<?php
			
		}
		
		
		// ================== 
		// DISTRIBUTORS ADD NEW
		// ==================
		if($action=="add-new-distributor"){
			?>
				<h1>Add New Distributor</h1>
				
				<form action="/wp-admin/admin.php" method="GET">
					
					<input type="hidden" name="page" value="imlm-admin-dashboard" />
					<input type="hidden" name="action" value="save-new-distributor" />
					
					<label>first name</label>
					<input type="text" name="first_name" />
					<br/>
					
					<label>last name</label>
					<input type="text" name="last_name" />
					<br/>
					
					<label>email</label>
					<input type="text" name="email" />
					<br/>
					
					<label>phone</label>
					<input type="text" name="billing_phone" />
					<br/>
					
					<label>password</label>
					<input type="text" name="password" />
					<br/>
					
					<hr />
					
					<label>upline enroller id</label>
					<?php
					
						$args = array(
							'role' => 'subscriber',
						);
						$users = get_users($args);
						
						$select_html = '<select name="enroller_distributor_id">';
						$select_html .= '<option value="">... Select</option>';
						foreach ($users as $user) {
							$select_html .= '<option value="' . $user->user_login . '">' . $user->user_login . '</option>';
						}
						$select_html .= '</select>';
						
						echo $select_html;
					?>
					<br/>
					
					<label>upline distributor id</label>
					<?php
					
						$args = array(
							'role' => 'subscriber',
						);
						$users = get_users($args);
						
						$select_html = '<select name="upline_distributor_id">';
						$select_html .= '<option value="">... Select</option>';
						foreach ($users as $user) {
							$select_html .= '<option value="' . $user->user_login . '">' . $user->user_login . '</option>';
						}
						$select_html .= '</select>';
						
						echo $select_html;
					?>
					<br/>
					
					
					
					
					<hr />
					<input type="submit" value="Create Distributor"/>
				</form>
			
			<?php
			
		}
		
		if($action=="save-new-distributor"){
			
			$userdata = array(
				'user_login'  => $_GET['first_name'].$_GET['last_name'],
				'user_pass'   => $_GET['password'],
				'user_email'  => $_GET['email'],
				'role'        => 'subscriber' // Assign a role to the user (e.g., subscriber, editor, administrator)
			);

			$user_id = wp_insert_user($userdata);

			if (!is_wp_error($user_id)) {
				// User created successfully
				
				// Add some user meta where useful..
				update_user_meta($user_id, "billing_phone", $_GET['billing_phone']);
				update_user_meta($user_id, "billing_email", $_GET['email']);
				
				// Now let's add some custom mlm data!
				$table_name = $wpdb->prefix . 'imlm_distributors';
				$data = array(
					'timestamp' => time(),
					'wp_user_id' => $user_id,
					'imlm_distributor_id' => $_GET['first_name'].$_GET['last_name'],
					'imlm_upline_distributor_id' => $_GET['upline_distributor_id'],
					'imlm_enroller_distributor_id' => $_GET['enroller_distributor_id'],
				);
				$wpdb->insert(
					$table_name,
					$data
				);
				if ($wpdb->insert_id) {
					// Data inserted successfully
					//return $wpdb->insert_id;
					?>
						<p>Distributor data was addedd successfully</p>
					<?php
				} else {
					// Error occurred during data insertion
					?>
						<p>ERROR: Could not add distributor data, please contact technical support ASAP</p>
						<p><?php echo $wpdb->print_error(); ?></p>
					<?php
				}
				
				?>
				
					<h1>New Distributor Has Been Created</h1>
					<br />
					<a href="/wp-admin/admin.php?page=imlm-admin-dashboard">Return To Dashboard</a>
				
				<?php
			} else {
				?>
					<h1 style="color:red;">ERROR Creating user, please contact developers!</h1>
					<p><?php echo $user_id->get_error_message(); ?></p>
					<br />
					<a href="/wp-admin/admin.php?page=imlm-admin-dashboard">Return To Dashboard</a>
				
				<?php
				return false;
			}
			
			
		}
		
		// ================== 
		// ADD LEFT OR RIGHT
		// ==================
		if($action=="downline-add"){
			?>
				<h1><?php echo $_GET['imlm_distributor_id']; ?>: Select Distributor For "<?php echo $_GET['left-or-right']; ?>" Leg Downline</h1>
				
				<form action="/wp-admin/admin.php" method="GET">
					
					<input type="hidden" name="page" value="imlm-admin-dashboard" />
					<input type="hidden" name="action" value="downline-left-right-save" />
					<input type="hidden" name="imlm_distributor_id" value="<?php echo $_GET['imlm_distributor_id']; ?>" />
					<input type="hidden" name="left-or-right" value="<?php echo $_GET['left-or-right']; ?>" />
					
					<label>Select member to add to </label>
					<?php
					
						$args = array(
							'role' => 'subscriber',
						);
						$users = get_users($args);
						
						$select_html = '<select name="downline_imlm_distributor_id">';
						$select_html .= '<option value="">... Select</option>';
						foreach ($users as $user) {
							$select_html .= '<option value="' . $user->user_login . '">' . $user->user_login . '</option>';
						}
						$select_html .= '</select>';
						
						echo $select_html;
					?>
					<br/>
					
					
					<hr />
					<input type="submit" value="Add To Leg"/>
				</form>
				
			<?php
		}
		
		// ================== 
		// SAVE LEFT OR RIGHT
		// ==================
		if($action=="downline-left-right-save"){
			
			
			$table_name = $wpdb->prefix . 'imlm_distributors';
			$data = array(
				'imlm_downline_'.$_GET['left-or-right'].'_distributor_id' => $_GET['downline_imlm_distributor_id'],
			);
			$where = array(
				'imlm_distributor_id' => $_GET['imlm_distributor_id'], // Example condition
			);
			$wpdb->update( $table_name, $data, $where );

			?>
				<p>Downline added!</p>
			<?php
			
		}
		
		
		// ================== 
		// DISTRIBUTORS
		// ==================
		if($action=="distributors"){
			?>
				<h1>Distributors</h1>
				<style>
					.alternate{ background-color: #ccd5d5; }
				</style>
				<div style="padding:20px;">
					<a href="/wp-admin/admin.php?page=imlm-admin-dashboard&action=add-new-distributor" class="hide-if-no-js page-title-action">Add New Distributor</a>
				</div>

				<form class="imlm-payments" action="/wp-admin/admin.php?page=imlm-admin-dashboard" method="POST" >
				
					<input type="hidden" name="action" value="clear_needs_assignment" />
					
					<input class="page-title-action" type="submit" value="Clear Needs Assignment" />
					
					<table class="widefat fixed" cellspacing="0">
						<thead>
						<tr>
							<th id="columnname" class="manage-column column-columnname " scope="col">Select</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">wp_user_id</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Needs Assignment</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Earnings</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">DistributorID</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Enrolment Level</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Enroller</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Upline</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Left Downline</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Right Downline</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Rank</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Personal Volume</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Total Team Volume</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Left Leg Volume</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Right Leg Volume</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Left Leg Distributors</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Right Leg Distributors</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Profit Leg</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Power Leg</th>
						</tr>
						</thead>

						<tbody>
							
							<?php
							
							$row_counter = 0;
							
							$args = array(
								'role' => 'subscriber',
							);
							$users = get_users($args);
							foreach ($users as $user) {
								$row_counter+=1;
								$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE wp_user_id ='".$user->data->ID."'", );
								$imlm_distributor = $wpdb->get_row($query);
								//var_dump($imlm_distributor);
								
								?>
									<?php
									if($row_counter % 2 == 0){
										?><tr class="alternate"><?php
									}
									else{
										?><tr class=""><?php
									}
									?>
										<td class="column-columnname"><input class='mlm-checkbox' name='distributor[<?php echo $imlm_distributor->imlm_distributor_id;?>]' type="checkbox" value="<?php echo $imlm_distributor->imlm_distributor_id;?>"/></td>
										<td class="column-columnname"><?php echo $user->id; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->needs_assignment; ?></td>
										<td class="column-columnname">$<?php echo $imlm_distributor->monthly_earnings; ?></td>
										<td class="column-columnname"><?php echo $user->user_login; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->enrolment_level; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->imlm_enroller_distributor_id; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->imlm_upline_distributor_id; ?></td>
										<td class="column-columnname">
											<?php 
												if($imlm_distributor->imlm_downline_left_distributor_id){
													echo $imlm_distributor->imlm_downline_left_distributor_id; 
												}else{
													echo "<a href='/wp-admin/admin.php?page=imlm-admin-dashboard&action=downline-add&left-or-right=left&imlm_distributor_id=".$user->user_login."'>Add</a>";
												}
											?>
										</td>
										<td class="column-columnname">
											<?php 
												if($imlm_distributor->imlm_downline_right_distributor_id){
													echo $imlm_distributor->imlm_downline_right_distributor_id; 
												}else{
													echo "<a href='/wp-admin/admin.php?page=imlm-admin-dashboard&action=downline-add&left-or-right=right&imlm_distributor_id=".$user->user_login."'>Add</a>";
												}
											?>
										</td>
										
										<td class="column-columnname">Consultant</td>
										<td class="column-columnname"><?php echo $imlm_distributor->monthly_personal_volume; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->monthly_total_volume; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->monthly_left_leg_volume; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->monthly_right_leg_volume; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->left_leg_distributors; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->right_leg_distributors; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->profit_leg; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->power_leg; ?></td>
								
										
									</tr>
								<?php
							}?>
						
						</tbody>
						
					</table>
					
				</form>
			<?php
		}
		
		// ================== 
		// REPORT VOLUMES
		// ==================
		// Lets go left, lets go right, up down back and around..
		if($action=="report-volumes"){
		
			echo imlm_report_volume("read_only");
		
		}
		
		// ---------------
		// CLEAR NEEDS ASSIGNMENT
		// --------------------
		if($action=="clear_needs_assignment"){
			//var_dump($_REQUEST);
			foreach($_REQUEST['distributor'] as $imlm_distributor_id){
				echo "<p>- Clearing: ". $imlm_distributor_id. "</p>";
				
				// UPDATE
				// ----------
				$table_name = $wpdb->prefix . 'imlm_distributors';
				$data = array(
					'needs_assignment' => 0,
				);
				$where = array(
					'imlm_distributor_id' => $imlm_distributor_id, 
				);
				// Update the table
				$result = $wpdb->update( $table_name, $data, $where );
				
			}
			echo "<p>-- Done!</p>";
			
		}
		
		// ---------------
		// COMISSION PAYOUTS
		// --------------------
		if($action=="comissions"){
			
			
			if($_REQUEST['submit']=="paid"){
				foreach($_REQUEST['paid'] as $payment_id){
					
					// UPDATE
					// ----------
					$table_name = $wpdb->prefix . 'imlm_distributor_payments';
					$data = array(
						'paid' => 'yes',
					);
					$where = array(
						'id' => $payment_id, 
					);
					// Update the table
					$result = $wpdb->update( $table_name, $data, $where );
				}
				
				echo "<div class='alert-success'>Payments Paid</div>";
				
			}
			
			?>
				<style>
					.alternate{ background-color: #ccd5d5; }
				</style>
				<style>
					.alert-success{
						color: #155724;
						background-color: #d4edda;
						border-color: #c3e6cb;
					}
				</style>
				
				<script>
					setTimeout(function(){
						jQuery(".mlm-select-all").click(function(){
							console.log("SELECT ALL");
							
							jQuery('.imlm-payments input[type="checkbox"]').prop('checked', true);
						});
					},1000);
				</script>
				
				<form class="imlm-payments" action="/wp-admin/admin.php?page=imlm-admin-dashboard" method="POST" >
				
					<input type="hidden" name="action" value="comissions" />
					<input type="hidden" name="submit" value="paid" />
				
					<input class="page-title-action" type="submit" value="Mark As Paid" />
					
					<div class="page-title-action mlm-select-all">Select All</div>
					
					<table class="widefat fixed" cellspacing="0">
						<thead>
						<tr>
							<th id="columnname" class="manage-column column-columnname " scope="col">Select</th>
							
							<th id="columnname" class="manage-column column-columnname " scope="col">wp_user_id</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">DistributorID</th>
							
							<th id="columnname" class="manage-column column-columnname " scope="col">Date</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Description</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Status</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Dollar</th>
							
							<th id="columnname" class="manage-column column-columnname " scope="col">Etransfer</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Transit</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Instituion</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Account Number</th>
						</tr>
						</thead>

						<tbody>
							
							<?php
							
							$row_counter = 0;
							
							$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributor_payments WHERE paid='no' ORDER BY imlm_distributor_id ASC " );
							$distributor_payments = $wpdb->get_results($query);
							
							foreach ($distributor_payments as $distributor_payment) {
								
								$row_counter+=1;
								
								$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id='".$distributor_payment->imlm_distributor_id."' " );
								$imlm_distributor = $wpdb->get_row($query);
								
								?>
									<?php
									if($row_counter % 2 == 0){
										?><tr class="alternate"><?php
									}
									else{
										?><tr class=""><?php
									}
									?>
										<td class="column-columnname"><input class='mlm-checkbox' name='paid[<?php echo $distributor_payment->id;?>]' type="checkbox" value="<?php echo $distributor_payment->id;?>"/></td>
										<td class="column-columnname"><?php echo $distributor_payment->id; ?></td>
										<td class="column-columnname"><?php echo $distributor_payment->imlm_distributor_id; ?></td>
										
										<td class="column-columnname"><?php echo $distributor_payment->date; ?></td>
										<td class="column-columnname"><?php echo $distributor_payment->description; ?></td>
										<td class="column-columnname"><?php echo $distributor_payment->status; ?></td>
										<td class="column-columnname">$<?php echo number_format($distributor_payment->dollar_total,2); ?></td>
										
										<td class="column-columnname"><?php echo $imlm_distributor->payment_etransfer_email; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->payment_bank_transit; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->payment_bank_institution; ?></td>
										<td class="column-columnname"><?php echo $imlm_distributor->payment_bank_account_number; ?></td>
										
									</tr>
								<?php
							}?>
							
							
							
						
						</tbody>
						
					</table>
					
				</form>
				
			<?php
		}
		
		// ---------------
		// CORPORATE
		// --------------------
		if($action=="corporate"){
			?>
				Corporate
			<?php
		}
		
		// ================== 
		// PRINT CERTIFICATES
		// ==================
		if($action=="certificates"){
			?>
				<h1>Unprinted Certificates</h1>
				<style>
					.alternate{ background-color: #ccd5d5; }
				</style>

				<form class="imlm-certificates" action="/wp-admin/admin.php?page=imlm-admin-dashboard" method="POST" >
				
					<input type="hidden" name="action" value="print_certificates" />
					
					<input class="page-title-action" type="submit" value="Print Certificates And Mark Need Fill" />
					
					<table class="widefat fixed" cellspacing="0">
						<thead>
						<tr>
							<th id="columnname" class="manage-column column-columnname " scope="col">Select</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Distributor</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Status</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Issue Date</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Certificate Number</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Coin Type</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Coin Amount</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Coin Value At Issue</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Certificate Value At Issue</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Public Address</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Key (ENCRYPTED)</th>
						</tr>
						</thead>

						<tbody>
							
							<?php
							
							$row_counter = 0;
							$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_certificates WHERE status='new'", );
							$imlm_certificates = $wpdb->get_results($query);
							foreach($imlm_certificates as $imlm_certificate){
								$row_counter+=1;
								
								//var_dump($imlm_distributor);
								
								?>
									<?php
									if($row_counter % 2 == 0){
										?><tr class="alternate"><?php
									}
									else{
										?><tr class=""><?php
									}
									?>
										<td class="column-columnname"><input class='mlm-checkbox' name='certificate[<?php echo $imlm_certificate->id;?>]' type="checkbox" value="<?php echo $imlm_certificate->id;?>"/></td>
										<td class="column-columnname"><?php echo $imlm_certificate->imlm_distributor_id; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->status; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->issue_date; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->certificate_number; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->coin_type; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->coin_amount; ?></td>
										<td class="column-columnname">$<?php echo $imlm_certificate->coin_market_value_cad_at_issue; ?></td>
										<td class="column-columnname">$<?php echo $imlm_certificate->certificate_value_cad_at_issue; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->address; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->key_encrypted; ?></td>
										
										
									</tr>
								<?php
							}?>
						
						</tbody>
						
					</table>
					
				</form>
			<?php
		}
		
		
		// ---------------
		// PRINT CERTIFICATES
		// --------------------
		if($action=="print_certificates"){
			
			$certificate_ids = [];
			foreach($_REQUEST['certificate'] as $certificate_id){
				
				array_push($certificate_ids, $certificate_id); // User IDs of the certificate recipients

			}
			generate_and_zip_certificates($certificate_ids);
			update_option('batch_imlm_distributor_id', null); // Resets the function
			echo "<p>-- Done!</p>";
			
		}
		
		// ================== 
		// FILL CERTIFICATES
		// ==================
		if($action=="certificates_fill"){
			?>
				<h1>Unpaid Certificates</h1>
				<style>
					.alternate{ background-color: #ccd5d5; }
				</style>

				<form class="imlm-certificates" action="/wp-admin/admin.php?page=imlm-admin-dashboard" method="POST" >
				
					<input type="hidden" name="action" value="fill_certificates" />
					
					<input class="page-title-action" type="submit" value="Mark Certificates Filled" />
					
					<table class="widefat fixed" cellspacing="0">
						<thead>
						<tr>
							<th id="columnname" class="manage-column column-columnname " scope="col">Select</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Distributor</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Status</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Issue Date</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Certificate Number</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Coin Type</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Coin Amount</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Coin Value At Issue</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Certificate Value At Issue</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Public Address</th>
							<th id="columnname" class="manage-column column-columnname " scope="col">Key (ENCRYPTED)</th>
						</tr>
						</thead>

						<tbody>
							
							<?php
							
							$row_counter = 0;
							$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_certificates WHERE status='coins_pending'", );
							$imlm_certificates = $wpdb->get_results($query);
							foreach($imlm_certificates as $imlm_certificate){
								$row_counter+=1;
								
								//var_dump($imlm_distributor);
								
								?>
									<?php
									if($row_counter % 2 == 0){
										?><tr class="alternate"><?php
									}
									else{
										?><tr class=""><?php
									}
									?>
										<td class="column-columnname"><input class='mlm-checkbox' name='certificate[<?php echo $imlm_certificate->id;?>]' type="checkbox" value="<?php echo $imlm_certificate->id;?>"/></td>
										<td class="column-columnname"><?php echo $imlm_certificate->imlm_distributor_id; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->status; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->issue_date; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->certificate_number; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->coin_type; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->coin_amount; ?></td>
										<td class="column-columnname">$<?php echo $imlm_certificate->coin_market_value_cad_at_issue; ?></td>
										<td class="column-columnname">$<?php echo $imlm_certificate->certificate_value_cad_at_issue; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->address; ?></td>
										<td class="column-columnname"><?php echo $imlm_certificate->key_encrypted; ?></td>
										
										
									</tr>
								<?php
							}?>
						
						</tbody>
						
					</table>
					
				</form>
			<?php
		}
		
		// ---------------
		// PRINT CERTIFICATES
		// --------------------
		if($action=="fill_certificates"){
			
			foreach($_REQUEST['certificate'] as $certificate_id){
					
				// UPDATE
				// ----------
				$table_name = $wpdb->prefix . 'imlm_certificates';
				$data = array(
					'status' => 'complete',
				);
				$where = array(
					'id' => $certificate_id, 
				);
				$result = $wpdb->update( $table_name, $data, $where );

			}
			
			
			echo "<p>-- Done!</p>";
			
		}
		
		// ---------------
		// UPLOAD WALLETS
		// --------------------
		if($action=="wallets"){
			?>
				<h1>Upload Wallets</h1>
				<p>Format:</p>
				<p>new,bitcoin,pubic,private</p>
				<p>new,litecoin,pubic,private</p>
				<p>new,ethereum,pubic,private</p>
				
				<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="page" value="imlm-admin-dashboard" />
					<input type="hidden" name="action" value="wallets_process" />
					<input type="file" name="csv_file" accept=".csv">
					<input type="submit" name="submit" value="Process New Wallets">
				</form>

			<?php
		}
		
		// ---------------
		// PROCESS WALLETS
		// --------------------
		if($action=="wallets_process"){
			?>
				<h1>Processing Wallets...</h1>
			<?php
			
			if (isset($_POST['submit']) && !empty($_FILES['csv_file'])) {
				
				$file_path = $_FILES['csv_file']['tmp_name'];

				$table_name = $wpdb->prefix . 'imlm_wallets'; // Replace 'coin_data' with your table name
    
				if (($handle = fopen($file_path, "r")) !== FALSE) {
					while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
						
						// Prepare data for database insertion
						$insert = array(
							'status' => 'encrypted',
							'cointype' => $data[1],
							'address' => $data[2],
							'key_encrypted' => imlm_encrypt($data[3]),
						);
						
						// Insert data into the database table
						$wpdb->insert($table_name, $insert);
					}
					fclose($handle);
				}
			}
			
			?>
				<h1><br />...DONE!</h1>
			<?php

		}
		
		
	?>
	</div>
	<?php
}


function imlm_report_volume($read_or_finalize){
	
	global $wpdb;
	$finalize_report = false;
	$autoship_total = 0;
	
	if(isset($_GET['finalize-check']) && $_GET['finalize-check']==1){
		echo "<p>CONFIRM FINALIZE REPORT?</p>"; 
		echo "<hr />";
		echo "<hr />";
		echo "<a href='/wp-admin/admin.php?page=imlm-admin-dashboard&action=report-volumes&finalize-check=2'>CONFIRM</a>";
		echo "<hr />";
		echo "<hr />";
	}
	
	if(isset($_GET['finalize-check']) && $_GET['finalize-check']==2){
		
		$finalize_report = true;
		
		echo "<hr />";
		echo "<hr />";
		echo "<p style='color:red;font-size:30px;'>FINALIZING REPORT</p>"; 
		echo "<hr />";
		echo "<hr />";
	}
	
	
	// ------------------
	//
	//
	// Autoship Team Volume
	//
	//
	// ------------------
	
	echo "<h1>- Starting: Autoship Team Volume</h1>";
			
	$query = $wpdb->prepare(
		"SELECT * FROM ".$wpdb->prefix."imlm_distributors",
	);
	$imlm_distributors = $wpdb->get_results($query);
	foreach($imlm_distributors as $imlm_distributor){
		echo "<p>-- Report For: ".$imlm_distributor->imlm_distributor_id."</p>";
		
		// GENERATE DATA
		// -----------------------
		$distributor_downline_full = get_distributor_downline($imlm_distributor->imlm_distributor_id);
		
		$distributor_downline_left = get_distributor_downline($imlm_distributor->imlm_downline_left_distributor_id);
		$distributor_downline_right = get_distributor_downline($imlm_distributor->imlm_downline_right_distributor_id);
		
		
		// PREAPRE DATA
		// -----------------------
		$monthly_personal_volume = calculate_monthly_personal_volume_from_new_volumes($imlm_distributor->imlm_distributor_id);
		$monthly_total_volume = calculate_monthly_downline_volume($distributor_downline_full) - $monthly_personal_volume;
		$monthly_left_leg_volume = calculate_monthly_downline_volume($distributor_downline_left);
		$monthly_right_leg_volume = calculate_monthly_downline_volume($distributor_downline_right);

		// For some reason it would count NULL values on the root and give people with 0 downline a 1. 
		// This fixes it.
		if(isset($distributor_downline_left['imlm_distributor_id'])){
			$left_leg_distributors = countDownline($distributor_downline_left, "left");
		}else{
			$left_leg_distributors = 0;
		}
		if(isset($distributor_downline_right['imlm_distributor_id'])){
			$right_leg_distributors = countDownline($distributor_downline_right, "right");
		}else{
			$right_leg_distributors = 0;
		}
		
		
		// POWER PROFIT LEGS
		// Which leg is the shortest? 
		// If tied, choose the leg with the lesser team volume
		// -----------------------
		
		$power_leg = "";
		$profit_leg = "";
		$monthly_earning = 0;
		
		// WHICH LEG HAS MORE OUTER DISTRIBUTORS?
		$profit_leg = "left";
		$power_leg = "right";
		
		if($left_leg_distributors > $right_leg_distributors){
			$profit_leg = "right";
			$power_leg = "left";
		}
		
		// TIE
		if($left_leg_distributors == $right_leg_distributors){
				
			if($monthly_left_leg_volume < $monthly_right_leg_volume){
				$profit_leg = "left";
				$power_leg = "right";
			}
			if($monthly_right_leg_volume < $monthly_left_leg_volume){
				$profit_leg = "right";
				$power_leg = "left";
			}
			
			// This is super edge case where left and right distributors are the same
			// AND both team volumes are the same... so it doesn't matter where we pay from at all.
			if($monthly_left_leg_volume == $monthly_right_leg_volume){
				$profit_leg = "left";
				$power_leg = "right";
			}
			
		}
		
		// PROFIT + carryover
		// ----------
		$monthly_leg_volume = 0;
		if($profit_leg == "left"){
			$monthly_earning = $monthly_left_leg_volume * 0.10;
			$monthly_leg_volume = $monthly_left_leg_volume + $imlm_distributor->left_leg_carryover;
		}
		if($profit_leg == "right"){
			$monthly_earning = $monthly_right_leg_volume * 0.10;
			$monthly_leg_volume = $monthly_right_leg_volume + $imlm_distributor->right_leg_carryover;
		}
		
		// Add to global report
		$autoship_total += $monthly_earning;
		
		// Check for distributor paystub for this report period, create if no, update if yes
		// -----------------------
		$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributor_payments WHERE imlm_distributor_id ='".$imlm_distributor->imlm_distributor_id."' AND status='new' AND description ='Autoship Team Volume' ");
		$distributor_payment = $wpdb->get_row($query);
		if(isset($distributor_payment)){
			
			// UPDATE
			// ----------
			$table_name = $wpdb->prefix . 'imlm_distributors';
			$data = array(
				'timestamp' => time(),
				'date' => date("Y-m-d"),
				'description' => "Autoship Team Volume", 
				'status' => "new",
				'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id,
				'imlm_from_distributor_id' => "",
				'volume_total' => $monthly_leg_volume,
				'dollar_total' => $monthly_earning,
				'dollar_currency' => "CAD",
			);
			$where = array(
				'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id, 
			);

			// Update the table
			$result = $wpdb->update( $table_name, $data, $where );
			
		}else{
			
			// INSERT
			// ----------
			$table_name = $wpdb->prefix . 'imlm_distributor_payments';
			$data = array(
				'timestamp' => time(),
				'description' => "Autoship Team Volume",
				'status' => "new",
				'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id,
				'imlm_from_distributor_id' => "",
				'volume_total' => $monthly_leg_volume,
				'dollar_total' => $monthly_earning,
				'dollar_currency' => "CAD",
			);
			$wpdb->insert(
				$table_name,
				$data
			);
			
		}
	
		
		// Show Data
		// -----------------------
		echo "<p>--- NEW PV: ".$monthly_personal_volume."</p>";
		echo "<p>--- TOTAL TV: ".$monthly_total_volume."</p>";
		echo "<p>---- LEFT TV: ".$monthly_left_leg_volume."</p>";
		echo "<p>---- RIGHT TV: ".$monthly_right_leg_volume."</p>";
		echo "<p>---- LEFT DISTRIBUTORS: ".$left_leg_distributors."</p>";
		echo "<p>---- RIGHT DISTRIBUTORS: ".$right_leg_distributors."</p>";
		echo "<p>---- profit_leg: ".$profit_leg."</p>";
		echo "<p>---- power_leg: ".$power_leg."</p>";
		echo "<p>---- PROFIT: ".$monthly_earning."</p>";
		echo "<p>----- ------- -----</p>";
		
		// RANK DATA
		// -----------------------
		echo "<p>----- Rank Check -----</p>";
		
		$check_volume = 0;
		if($profit_leg == "left"){
			$check_volume = $monthly_left_leg_volume;
		}
		if($profit_leg == "right"){
			$check_volume = $monthly_right_leg_volume;
		}
		echo "<p>----- Rank Volume Amount: ".$check_volume."</p>";
		
		
		$query = $wpdb->prepare(
			"SELECT * FROM ".$wpdb->prefix."imlm_ranks ORDER BY required_team_volume ASC",
		);
		$imlm_ranks = $wpdb->get_results($query);
		foreach($imlm_ranks as $imlm_rank){
			
			echo "<p>----- Rank: ".$imlm_rank->rank_title." : " .$imlm_rank->required_team_volume ."</p>";
			if($check_volume >= $imlm_rank->required_team_volume){
				echo "<p>------ RANK UP!</p>";
				
				if($imlm_distributor->rank_number <= $imlm_rank->rank_number){
					
					// Save data
					// -----------------------
					$table_name = $wpdb->prefix . 'imlm_distributors';
					$data = array(
						'rank' => $imlm_rank->rank_title,
						'rank_number' => $imlm_rank->rank_number,
					);
					$where = array(
						'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id, 
					);

					// Update the table
					$result = $wpdb->update( $table_name, $data, $where );
					if($result === false){
						$error_message = $wpdb->last_error;
						echo "Update failed. Error: " . $error_message;
					}else{
						echo "<p>--- Updated Rank!</p>";					
					}
					
				}
				
				
			}
			
		}
	
	
		// Save data!
		// -----------------------
		$table_name = $wpdb->prefix . 'imlm_distributors';
		$data = array(
			'monthly_personal_volume' => $monthly_personal_volume,
			'monthly_total_volume' => $monthly_total_volume,
			'monthly_left_leg_volume' => $monthly_left_leg_volume,
			'monthly_right_leg_volume' => $monthly_right_leg_volume,
			'left_leg_distributors' => $left_leg_distributors,
			'right_leg_distributors' => $right_leg_distributors,
			'profit_leg' => $profit_leg,
			'power_leg' => $power_leg,
			'monthly_earnings' => $monthly_earning,
		);
		$where = array(
			'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id, 
		);

		// Update the table
		$result = $wpdb->update( $table_name, $data, $where );
		if($result === false){
			$error_message = $wpdb->last_error;
			echo "Update failed. Error: " . $error_message;
		}else{
			echo "<p>--- SAVED: True</p>";					
		}
	
		
		
		echo "----------------------------------<br />";
	}
	
	// ------------------
	//
	//
	// BONUSES
	//
	//
	// ------------------
	
	
	// FIRST ENROLMENT BONUS
	// ----------------------------
	echo "<h1>Starting: Executive Bonuses</h1>";
	
	// For each distributor
	// Count number of orders
	// If orders_count = 1
	// Total the Team Volume order
	// If over 200 -> standard
	// if over 1000 -> executive
	// Note: we are not checking 'new' orders here because it would make this code run AGAIN next month and reward them $200 bucks
	
	$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors");
	$imlm_distributors = $wpdb->get_results($query);
	foreach($imlm_distributors as $imlm_distributor){
		
		echo "<p>-- Executive Bonus For: ".$imlm_distributor->imlm_distributor_id."</p>";
		
		// Quickly count the amount of orders placed.
		$total_orders = 0;
		$query = $wpdb->prepare("SELECT id,timestamp,woocommerce_order_id FROM ".$wpdb->prefix."imlm_volumes WHERE imlm_distributor_id ='".$imlm_distributor->imlm_distributor_id."' GROUP BY woocommerce_order_id ");
		$total_orders = $wpdb->get_results($query);
		//var_dump($total_orders);
		
		if(count($total_orders) >= 1){
			
			echo "<p>--- User has: ".count($total_orders)." orders</p>";
			
			
			// Find the lowest woocommerce order ID and assume it's their first order in the system.
			$lowest_id = 9999999999999999;
			$lowest_woocommerce_order_id = 0;
			foreach($total_orders as $order){
				if(intval($order->woocommerce_order_id) < intval($lowest_id)){
					$lowest_id = intval($order->woocommerce_order_id);
					$lowest_woocommerce_order_id = $order->woocommerce_order_id;
				}
				
			}
			echo "<p>---- First Order ID: ".$lowest_woocommerce_order_id." </p>";
			
			// Find their upline and reward them the Executive Bonus
			$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id ='".$imlm_distributor->imlm_enroller_distributor_id."' ");
			$imlm_enroller = $wpdb->get_row($query);
			
			if(isset($imlm_enroller->imlm_distributor_id)){
				echo "<p>----- This user was enrolled by: ".$imlm_enroller->imlm_distributor_id." </p>";
				
				// Calculate First Order Volume
				// -------------
				$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_volumes WHERE imlm_distributor_id ='".$imlm_distributor->imlm_distributor_id."' AND woocommerce_order_id='".$lowest_woocommerce_order_id."' AND status='new'");
				$first_order = $wpdb->get_results($query);
				//var_dump($first_order);
				
				$first_order_volume = 0;
				foreach($first_order as $items){
					$first_order_volume += $items->volume;
				}
				echo "<p>----- First order volume was: ".$first_order_volume." </p>";
				
				
				// Rank Promotions
				// ---------------
				$return_check = false;
				
				// $1000 dollar level -> Executive
				if($first_order_volume>900 && $return_check == false){
					echo "<p>----- Rank: <span style='color:green'>Executive</span></p>";
					
					// $200 Comission to enroller
					// -------------------------
					// CHECK: See if this user already received this one time payment
					$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributor_payments WHERE imlm_distributor_id ='".$imlm_enroller->imlm_distributor_id."' AND imlm_from_distributor_id='".$imlm_distributor->imlm_distributor_id."' AND description ='First Time Order Bonus: Executive' AND status='new'");
					$first_time_order_bonus = $wpdb->get_row($query);
					
					if(isset($first_time_order_bonus)){
						echo "<p>----- COMISSION: $200 First time order bonus has been paid</p>";
					}else{
						echo "<p>----- COMISSION: $200 First time order bonus DO PAYOUT</p>";
						
						// ISSUE PAYMENT
						// -------------
						$table_name = $wpdb->prefix . 'imlm_distributor_payments';
						$data = array(
							'timestamp' => time(),
							'description' => "First Time Order Bonus: Executive",
							'status' => "new",
							'imlm_distributor_id' => $imlm_enroller->imlm_distributor_id,
							'imlm_from_distributor_id' => $imlm_distributor->imlm_distributor_id,
							'volume_total' => 0,
							'dollar_total' => "200.00",
							'dollar_currency' => "CAD",
						);
						$wpdb->insert(
							$table_name,
							$data
						);
						if ($wpdb->insert_id) {
							// Data inserted successfully
							//return $wpdb->insert_id;
							echo "<p>----- PAID: $200</p>";
						} else {
							// Error occurred during data insertion
							echo $wpdb->print_error();
						}
						
					}
					
					// Update the table
					$wpdb->update( 
						$wpdb->prefix.'imlm_distributors', 
						array(
							'enrolment_level' => "Executive",
						),
						array(
							'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id
						)
					);
					
					$return_check = true;
					
				}
				
				// $250 dollar level -> Consultant
				if($first_order_volume>100 && $return_check == false){
					
					// $35 Comission to enroller
					// -------------------------
					// CHECK: See if this user already received this one time payment
					$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributor_payments WHERE imlm_distributor_id ='".$imlm_enroller->imlm_distributor_id."' AND imlm_from_distributor_id='".$imlm_distributor->imlm_distributor_id."' AND description ='First Time Order Bonus: Consultant' AND status='new'");
					$first_time_order_bonus = $wpdb->get_row($query);
					if(isset($first_time_order_bonus)){
						echo "<p>----- COMISSION: $35 First time order bonus has been paid</p>";
					}else{
						echo "<p>----- COMISSION: $35 First time order bonus DO PAYOUT</p>";
						
						// ISSUE PAYMENT
						// -------------
						$table_name = $wpdb->prefix . 'imlm_distributor_payments';
						$data = array(
							'timestamp' => time(),
							'date' => date("Y-m-d"),
							'description' => "First Time Order Bonus: Consultant",
							'status' => "new",
							'imlm_distributor_id' => $imlm_enroller->imlm_distributor_id,
							'imlm_from_distributor_id' => $imlm_distributor->imlm_distributor_id,
							'volume_total' => 0,
							'dollar_total' => "35.00",
							'dollar_currency' => "CAD",
						);
						$wpdb->insert(
							$table_name,
							$data
						);
						if ($wpdb->insert_id) {
							// Data inserted successfully
							//return $wpdb->insert_id;
							echo "<p>----- PAID: $35</p>";
						} else {
							// Error occurred during data insertion
							echo $wpdb->print_error();
						}
						
					}
					
					
					// Promote
					echo "<p>----- Rank: Consultant</p>";
					
					// Update the table
					$wpdb->update( 
						$wpdb->prefix.'imlm_distributors', 
						array(
							'enrolment_level' => "Standard",
						),
						array(
							'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id
						)
					);
					
					$return_check = true;
					
				}
				
				
				
			}else{
				echo "<p>----- <span style='color:red;'>ERROR</span>: User has no enroller! </p>";
			}
			
		}else{
			echo "<p>--- User has not placed any orders</p>";
		}
		
	}
	
	
	// ------------------
	//
	//
	// 7 GENERATIONS REPORT
	//
	//
	// ------------------
	// 
	// Rank: Generations: %array
	// Consultant: 0
	// Supervisor: 0
	// Manager: 0
	// Senior Manager: 0
	// --------------------------
	// Director: 				1: 25
	// Regional Director: 		2: 30,7
	// Senior Director: 		3: 35,7,7 
	// Corporate Director: 		4: 40,7,7,7
	// Diamond Director: 		5: 45,7,7,7,7
	// Double Diamond Director: 6: 50,7,7,7,7,7
	// Triple Diamond Director: 7: 50,7,7,7,7,7,7
	
	echo "<h1>- Starting: 7 Generations Report</h1>";
	
	// Fetch all distributors.
	$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors");
	$imlm_distributors = $wpdb->get_results($query);
	foreach($imlm_distributors as $imlm_distributor){
		echo "<p>-- 7 Generation Comission For: ".$imlm_distributor->imlm_distributor_id."</p>";
		echo "<p>--- Rank Check: ".$imlm_distributor->rank_number." </p>";
		
		if($imlm_distributor->rank_number >= 5){
			
			echo "<p>---- Rank Check: Is at least a Director, begin Generation Calculation</p>";
			
		
			// Select the root user.
			// -----------------
			$query = $wpdb->prepare(
				"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id = '".$imlm_distributor->imlm_distributor_id."'",
			);
			$root_distributor = $wpdb->get_row($query);
			$root_distributor->children = [];
			
			
			// Add generation 1.
			// -----------------
			$query = $wpdb->prepare(
				"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$root_distributor->imlm_distributor_id."'",
			);
			$children = $wpdb->get_results($query);
			
			$distributors_generation_downline[0] = $root_distributor;
			
			$index = 0;
			foreach($children as $enrolle){
				$distributors_generation_downline[1][$index] = $enrolle;
				$index++;
			}
			
			$root_distributor->children = $distributors_generation_downline[1];
			
		}else{
			echo "<p>---- Rank Check: Required rank is not unlocked</p>";
		}
		

		// Add generation 2.
		// -----------------
		if(isset($root_distributor->children)){
			foreach($root_distributor->children as $gen2){
				
				$gen2->children = [];
				$query = $wpdb->prepare(
					"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen2->imlm_distributor_id."'",
				);
				$gen2_enrolles = $wpdb->get_results($query);
				$gen2->children = $gen2_enrolles;
				
				// Add generation 3.
				// -----------------
				if(isset($gen2->children)){
					foreach($gen2->children as $gen3){
						
						$gen3->children = [];
						$query = $wpdb->prepare(
							"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen3->imlm_distributor_id."'",
						);
						$gen3_enrolles = $wpdb->get_results($query);
						if($gen3_enrolles){
							$gen3->children = $gen3_enrolles;
							
							// Add generation 4.
							// -----------------
							if(isset($gen3->children)){
								foreach($gen3->children as $gen4){
									
									$gen4->children = [];
									$query = $wpdb->prepare(
										"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen4->imlm_distributor_id."'",
									);
									$gen4_enrolles = $wpdb->get_results($query);
									if($gen4_enrolles){
										$gen4->children = $gen4_enrolles;
									}
									
									// Add generation 5.
									// -----------------
									if(isset($gen4->children)){
										foreach($gen4->children as $gen5){
											
											$gen5->children = [];
											$query = $wpdb->prepare(
												"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen5->imlm_distributor_id."'",
											);
											$gen5_enrolles = $wpdb->get_results($query);
											if($gen5_enrolles){
												$gen5->children = $gen5_enrolles;
											}
											
											// Add generation 6.
											// -----------------
											if(isset($gen5->children)){
												foreach($gen5->children as $gen6){
													
													$gen6->children = [];
													$query = $wpdb->prepare(
														"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen6->imlm_distributor_id."'",
													);
													$gen6_enrolles = $wpdb->get_results($query);
													if($gen6_enrolles){
														$gen6->children = $gen6_enrolles;
													}
													
													// Add generation 7.
													// -----------------
													if(isset($gen6->children)){
														foreach($gen6->children as $gen7){
															
															$gen7->children = [];
															$query = $wpdb->prepare(
																"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen7->imlm_distributor_id."'",
															);
															$gen7_enrolles = $wpdb->get_results($query);
															if($gen7_enrolles){
																$gen7-> children = $gen7_enrolles;
															}
															
														}
													}
													
												}
											}
											
										}
									}
									
								}
							}
						}
						
					}
				}
				
			}
		}

	}
	
	// ------------------
	//
	//
	// CORPORATE REVENUE REPORT CARDS
	//
	//
	// ------------------
	// Let's find out how much we made this month
	echo "<h1>- Starting: Corporate Revenue Report</h1>";
	
	// Income By Volumes
	// ------------------
	$corporate_gross_revenue = 0;
	$corporate_taxes = 0;
	$corporate_shipping = 0;
	$query = $wpdb->prepare(
		"SELECT * FROM ".$wpdb->prefix."imlm_volumes WHERE status = 'new' ORDER BY woocommerce_order_id",
	);
	$volumes = $wpdb->get_results($query);
	foreach($volumes as $volume){
		echo "<p>-- Woo Order ID: ".$volume->woocommerce_order_id." </p>";
		echo "<p>-- From: ".$volume->imlm_distributor_id." </p>";
		echo "<p>-- Volume: ".$volume->woocommerce_item_total." </p>";
		$corporate_gross_revenue += number_format(floatval($volume->woocommerce_item_total), 2);
		$corporate_taxes += number_format(floatval($volume->woocommerce_item_total_tax), 2);
		//$corporate_shipping += number_format(floatval($volume->woocommerce_item_total_tax), 2);
		echo "<p>~~~~~~~~~~</p>";
	}
	echo "<p>- Total corporate income this report period: $".(floatval($corporate_gross_revenue))." </p>";
	echo "<p>- Total seperated taxes this report period: $".(floatval($corporate_taxes))." </p>";
	
	$balance = (float)$corporate_gross_revenue;
	
	// Payouts Owed
	// ------------------
	$autoship_team_volume_dollars = 0;
	$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributor_payments WHERE status='new' ");
	$payments = $wpdb->get_results($query);
	//var_dump($executive_bonuses);
	if(isset($payments)){
		foreach($payments as $payment){
			$autoship_team_volume_dollars += (float)($payment->dollar_total);
		}
	}
	
	// Autoship Comissions
	// ------------------
	$balance = (float)$corporate_gross_revenue - (float)$autoship_team_volume_dollars;
	echo "<p>-- <b>Autoship Team Volume Comission Payouts (status='new')</b>: $".(float)$autoship_team_volume_dollars." is pending to payout</p>";
	echo "<p>- Autoship Calculation Total Was (should match): $".(float)$autoship_total." </p>";
	echo "<p>- Balance: $".(float)$balance." </p>";
	
	
	// 7 Generations MLB
	// ------------------
	// Todo
	echo "<p>--<b>7 Generations MLB</b>: $0.00 </p>";
	echo "<p>- Balance: $".(float)$balance." </p>";
	
	
	// Executive Bonuses
	// ------------------
	$executive_bonus = $balance * 0.03;
	$balance = (float)$balance - (float)$executive_bonus;
	
	$query = $wpdb->prepare(
		"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE enrolment_level = 'Executive'",
	);
	$executives = $wpdb->get_results($query);
	$executive_count = $wpdb->num_rows;
	
	echo "<p>-- <b>Executive Bonus Pool</b>: $".(float)$executive_bonus." </p>";
	echo "<p>- Executives: ".(int)$executive_count." </p>";
	echo "<p>- Payouts: $".( (float)$executive_bonus / (int)$executive_count)." </p>";
	echo "<p>- Balance: $".(float)$balance." </p>";
	
	// Car Bonuses
	// ------------------
	echo "<p>-- <b>Car Bonuses</b>: $0.00 </p>";
	echo "<p>- Balance: $".(float)$balance." </p>";
	
	// Vacation Bonuses
	// ------------------
	echo "<p>-- <b>Vacation Bonuses</b>: $0.00 </p>";
	echo "<p>- Balance: $".(float)$balance." </p>";
	
	// ------------------
	//
	//
	// Crypto Wallet Prepping
	//
	//
	// ------------------
	echo "<p>-- <b>Preparring New Wallets</b></p>";
	
	//imlm_encrypt
	
	// ------------------
	//
	//
	// Crypto Purchases
	//
	//
	// ------------------
	
	$fatal_error_no_wallets_available = false;
	
	
	$volume_total_bitcoin = 0;
	$volume_total_litecoin = 0;
	$volume_total_ethereum = 0;
	$volume_total = 0;
	
	$certificates_of_bitcoin = 0;
	$certificates_of_litecoin = 0;
	$certificates_of_ethereum = 0;
	
	$company_comission = 0.20;
	$crypto_spend = (float)$balance * (1.00-$company_comission);
	$balance = (float)$balance - (float)$crypto_spend;
	echo "<p>-- <b>Crypto Budget (".((1-$company_comission)*100)."%)</b>: $".(float)$crypto_spend." </p>";
	echo "<p>- Balance: Corporate Net Revenue (".(($company_comission)*100)."%): $".number_format(($balance))." </p>";
	
		// Fetch current prices
		// -----------------------
		
		// FETCH BTC 
		// ----------------------
		$cad_api_url = 'https://api.coindesk.com/v1/bpi/currentprice/CAD.json';
		$response = file_get_contents($cad_api_url);
		$data = json_decode($response, true);
		
		$market_price_bitcoin = $data['bpi']['CAD']['rate_float'];
		echo "<p>- Price of Bitcoin: $".$market_price_bitcoin."</p>";
		
		// FETCH LTC 
		// ----------------------
		$cad_api_url = 'https://api.coingecko.com/api/v3/simple/price?ids=litecoin&vs_currencies=cad';
		$response = file_get_contents($cad_api_url);
		$data = json_decode($response, true);
		//var_dump($data);
		
		$market_price_litecoin = $data['litecoin']['cad'];
		echo "<p>- Price of Litecoin: $".$market_price_litecoin."</p>";
		
		// FETCH Ethereum
		// ----------------------
		$cad_api_url = 'https://api.coingecko.com/api/v3/simple/price?ids=ethereum&vs_currencies=cad';
		$response = file_get_contents($cad_api_url);
		$data = json_decode($response, true);
		//var_dump($data);
		
		$market_price_ethereum = $data['ethereum']['cad'];
		echo "<p>- Price of Ethereum: $".$market_price_ethereum."</p>";

	// Fetch each distributors order and total up how many certificates they bought
	$query = $wpdb->prepare(
		"SELECT * FROM ".$wpdb->prefix."imlm_volumes WHERE status = 'new' ORDER BY imlm_distributor_id ASC",
	);
	$volumes = $wpdb->get_results($query);
	
	// CALCULATE COIN TYPE SPENDING TOTALS
	// ---------------------------
	foreach($volumes as $volume){

		$quantity = $volume->woocommerce_quantity;
		
		$cointype = "";
		$is_certificate_type = false;
		if($volume->woocommerce_product_title == "Bitcoin Certificate GOLD"){
			$volume_total_bitcoin += 100;
			$volume_total += 100;
			$certificates_of_bitcoin += 1;
		}
		if($volume->woocommerce_product_title == "Litecoin Certificate GOLD"){
			$volume_total_litecoin += 100;
			$volume_total += 100;
			$certificates_of_litecoin += 1;
		}
		if($volume->woocommerce_product_title == "Ethereum Certificate GOLD"){
			$volume_total_ethereum += 100;
			$volume_total += 100;
			$certificates_of_ethereum += 1;
		}
		
		
	}
	
	$volume_dollars = $crypto_spend / $volume_total;
	
	$purchase_percent_bitcoin = (($volume_total_bitcoin / $volume_total)*100);
	$purchase_percent_litetcoin = (($volume_total_litecoin / $volume_total)*100);
	$purchase_percent_ethereum = (($volume_total_ethereum / $volume_total)*100);
	
	$purchase_bitcoin = $volume_dollars * $volume_total_bitcoin;
	$purchase_litecoin = $volume_dollars * $volume_total_litecoin;
	$purchase_ethereum = $volume_dollars * $volume_total_ethereum;
	
	$purchase_total = (float)$purchase_bitcoin + (float)$purchase_litecoin + (float)$purchase_ethereum;
	
	echo "<p>- Crypto Volume Total: ".$volume_total."</p>";
	echo "<p>- Crypto Volume Dollars: $".$volume_dollars."</p>";
	echo "<p>- Crypto Spend Bitcoin: ".$volume_total_bitcoin." volume : ". $purchase_percent_bitcoin ."% : $". $purchase_bitcoin ."</p>";
	echo "<p>- Crypto Spend Litecoin: ".$volume_total_litecoin." volume : ". $purchase_percent_litetcoin ."% : $". $purchase_litecoin ."</p>";
	echo "<p>- Crypto Spend Ethereum: ".$volume_total_ethereum." volume : ". $purchase_percent_ethereum ."% : $". $purchase_ethereum ."</p>";
	echo "<p>- Crypto Check: $". $crypto_spend ." / $". $purchase_total ." = ". ($crypto_spend / $purchase_total) ."</p>";
	
	
	// BUILD CERTIFICATES
	// ------------------
	foreach($volumes as $volume){

		$quantity = $volume->woocommerce_quantity;
		
		$cointype = "";
		$is_certificate_type = false;
		if($volume->woocommerce_product_title == "Bitcoin Certificate GOLD"){
			$cointype = "bitcoin";
			$is_certificate_type = true;
		}
		if($volume->woocommerce_product_title == "Litecoin Certificate GOLD"){
			$cointype = "litecoin";
			$is_certificate_type = true;
		}
		if($volume->woocommerce_product_title == "Ethereum Certificate GOLD"){
			$cointype = "ethereum";
			$is_certificate_type = true;
		}
		
		// Build Certificates
		// ------------------
		if($is_certificate_type == true){
			for($index = 1; $index <= $quantity; $index++){
				
				$certificate_number = "0000-".$cointype."-".$index."-".$volume->woocommerce_quantity."-".$volume->woocommerce_order_id;
				
				$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_certificates WHERE certificate_number ='".$certificate_number."' ");
				$certificate = $wpdb->get_row($query);
				
				if(isset($certificate)){
					
					echo "<p style='color:green;'>---- READY CERTIFICATE ".$certificate->coin_type.": Public Address: ".$certificate->address." : ".(float)$certificate->coin_amount." ".$certificate->coin_type." ".$certificate->issue_date." Market Value: $".$certificate->coin_market_value_cad_at_issue." Certificate Value: $".$certificate->certificate_value_cad_at_issue."</p>";
					
				}else{
					
					echo "<p>-- Create New Certificate: Distributor: ".$volume->imlm_distributor_id." ".$cointype." : Certificate Number: ".$certificate_number."</p>";
					
					// Bitcoin
					// ---------
					if($cointype == "bitcoin"){
					
						// Wallet data
						$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_wallets WHERE status='encrypted' AND cointype='bitcoin' ");
						$wallet = $wpdb->get_row($query);

						if(isset($wallet->id)){
							
							$wpdb->delete($wpdb->prefix."imlm_wallets", array("id"=>$wallet->id) ); // Certificate has been claimed!

							echo "<p style='color:purple;'>--- NEW CERTIFICATE: Coin Amount: $". $market_price_bitcoin  ." #OfCerts: " .$certificates_of_bitcoin." / CryptoSpendBitcoin: ".$purchase_bitcoin." = $".($purchase_bitcoin/$certificates_of_bitcoin)." | ".(($purchase_bitcoin/$certificates_of_bitcoin)/$market_price_bitcoin)." BTC</p>";
							echo "<p>--- Public Address: ".$wallet->address."</p>";
					
							// INSERT
							// ----------
							$table_name = $wpdb->prefix . 'imlm_certificates';
							$data = array(
								'timestamp' => time(),
								'issue_date' => date("Y-m-d"),
								'status' => 'new',
								
								'woocommerce_order_id' => $volume->woocommerce_order_id, //1006
								'certificate_number' => $certificate_number, // 0000-bitcoin-1-1-1006
								'imlm_distributor_id' => $volume->imlm_distributor_id, // AndrewNormor1231
								
								'coin_type' => 'bitcoin', // bitcoin
								'coin_amount' => number_format(floatval((($purchase_bitcoin/$certificates_of_bitcoin)/$market_price_bitcoin)),9), // 0.0018232 
								'coin_market_value_cad_at_issue' => number_format(floatval($market_price_bitcoin),2), //$28,023
								'certificate_value_cad_at_issue' => number_format(floatval(($purchase_bitcoin/$certificates_of_bitcoin)),2), // $71.23
								
								'address' => $wallet->address,
								'key_encrypted' => $wallet->key_encrypted,
							);
							$wpdb->insert(
								$table_name,
								$data
							);
							
						}else{
						
							echo "<p style='color:red;'>--- ERROR: No Bitcoin Wallets are available</p>";
						
						}
						
						
					}
					
					// Litecoin
					// ---------
					if($cointype == "litecoin"){
						
						$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_wallets WHERE status='encrypted' AND cointype='litecoin' ");
						$wallet = $wpdb->get_row($query);
						if(isset($wallet->id)){
							
							$wpdb->delete($wpdb->prefix."imlm_wallets", array("id"=>$wallet->id) );
							
							echo "<p style='color:purple;'>--- NEW CERTIFICATE: Coin Amount: $". $market_price_litecoin  ." #OfCerts: " .$certificates_of_litecoin." / CryptoSpendBitcoin: ".$purchase_litecoin." = $".($purchase_litecoin/$certificates_of_litecoin)." | ".(($purchase_litecoin/$certificates_of_litecoin)/$market_price_litecoin)." LTC</p>";
							echo "<p>--- Public Address: ".$wallet->address."</p>";
							
							// INSERT
							// ----------
							$table_name = $wpdb->prefix . 'imlm_certificates';
							$data = array(
								'timestamp' => time(),
								'issue_date' => date("Y-m-d"),
								'status' => 'new',
								
								'woocommerce_order_id' => $volume->woocommerce_order_id, //1006
								'certificate_number' => $certificate_number, // 0000-litecoin-1-1-1006
								'imlm_distributor_id' => $volume->imlm_distributor_id, // AndrewNormor1231
								
								'coin_type' => 'litecoin', // litecoin
								'coin_amount' => number_format(floatval((($purchase_bitcoin/$certificates_of_litecoin)/$market_price_litecoin)),9), // 0.0018232
								'coin_market_value_cad_at_issue' => number_format(floatval($market_price_litecoin),2), //$28,023
								'certificate_value_cad_at_issue' => number_format(floatval(($purchase_litecoin/$certificates_of_litecoin)),2), // $71.23
								
								'address' => $wallet->address,
								'key_encrypted' => $wallet->key_encrypted,
							);
							$wpdb->insert(
								$table_name,
								$data
							);
							
						}else{
							echo "<p style='color:red;'>--- ERROR: No Litecoin Wallets are available</p>";
						}
					}
					
					// Ethereum
					// ---------
					if($cointype == "ethereum"){
						
						$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_wallets WHERE status='encrypted' AND cointype='ethereum' ");
						$wallet = $wpdb->get_row($query);
						if(isset($wallet->id)){
							
							$wpdb->delete($wpdb->prefix."imlm_wallets", array("id"=>$wallet->id) );
							
							echo "<p style='color:purple;'>--- NEW CERTIFICATE: Coin Amount: $". $market_price_ethereum  ." #OfCerts: " .$certificates_of_ethereum." / CryptoSpendBitcoin: ".$purchase_ethereum." = $".($purchase_ethereum/$certificates_of_ethereum)." | ".(($purchase_ethereum/$certificates_of_ethereum)/$market_price_ethereum)." ETH</p>";
							echo "<p>--- Public Address: ".$wallet->address."</p>";
							
							// INSERT
							// ----------
							$table_name = $wpdb->prefix . 'imlm_certificates';
							$data = array(
								'timestamp' => time(),
								'issue_date' => date("Y-m-d"),
								'status' => 'new',
								
								'woocommerce_order_id' => $volume->woocommerce_order_id, //1006
								'certificate_number' => $certificate_number, // 0000-ethereum-1-1-1006
								'imlm_distributor_id' => $volume->imlm_distributor_id, // AndrewNormor1231
								
								'coin_type' => 'ethereum', // ethereum
								'coin_amount' => number_format(floatval((($purchase_ethereum/$certificates_of_ethereum)/$market_price_ethereum)),18), // 0.0018232
								'coin_market_value_cad_at_issue' => number_format(floatval($market_price_ethereum),2), //$28,023
								'certificate_value_cad_at_issue' => number_format(floatval(($purchase_ethereum/$certificates_of_ethereum)),2), // $71.23
								
								'address' => $wallet->address,
								'key_encrypted' => $wallet->key_encrypted,
							);
							$wpdb->insert(
								$table_name,
								$data
							);
							
						}else{
							echo "<p style='color:red;'>--- ERROR: No Ethereum Wallets are available</p>";
						}
						
					}
					
				}
				
				
				
				
				
			}
		}
	
	}





	
	
	// Save to database
	// ----------------
	echo "<p>---- Report Card Date: ".date("Y-m-d")." </p>";   

	$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_corporate WHERE report_date ='".date("Y-m-d")."' ");
	$report_card = $wpdb->get_row($query);
	if(isset($report_card)){
		
		// UPDATE
		// ----------
		$table_name = $wpdb->prefix . 'imlm_corporate';
		$data = array(
			'timestamp' => time(),
			'report_date' => date("Y-m-d"),
			'autoship_team_volume' => number_format(floatval($autoship_team_volume_dollars), 2),
			'generational_lmb' => number_format(floatval(0), 2),
			'executive_bonus' => number_format(floatval($executive_bonus), 2),
			'car_bonus' => number_format(floatval(0), 2),
			'vacation_bonus' => number_format(floatval(0), 2),
			'crypto_budget' => number_format(floatval($balance), 2),
			'corporate_revenue' => number_format(floatval($balance), 2),
		);
		$where = array(
			'report_date' => date("Y-m-d"), 
		);
		$result = $wpdb->update( $table_name, $data, $where );
		
	}else{
		
		// INSERT
		// ----------
		$table_name = $wpdb->prefix . 'imlm_corporate';
		$data = array(
			'timestamp' => time(),
			'report_date' => date("Y-m-d"),
			'autoship_team_volume' => number_format(floatval($autoship_team_volume_dollars), 2),
			'generational_lmb' => number_format(floatval(0), 2),
			'executive_bonus' => number_format(floatval($executive_bonus), 2),
			'car_bonus' => number_format(floatval(0), 2),
			'vacation_bonus' => number_format(floatval(0), 2),
			'crypto_budget' => number_format(floatval($balance), 2),
			'corporate_revenue' => number_format(floatval($balance), 2),
		);
		$wpdb->insert(
			$table_name,
			$data
		);
		//var_dump($wpdb->last_error);
		
	}
	
	// Close the volumes and pay stubs
	// ---------------------------------
	// Volumes
	// -----------------
	if($finalize_report == true){
	$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_volumes WHERE status='new' ");
		$volumes = $wpdb->get_results($query);
		if(isset($volumes)){
			foreach($volumes as $volume){
				
				// UPDATE
				// ----------
				$table_name = $wpdb->prefix . 'imlm_volumes';
				$data = array(
					'timestamp' => time(),
					'status' => "complete",
				);
				$where = array(
					'imlm_distributor_id' => $volume->imlm_distributor_id, 
				);

				// Update the table
				$result = $wpdb->update( $table_name, $data, $where );
				
				echo "<p>---- Finalized Volume: ".$volume->description." : " .$volume->volume ."</p>";
				
			}
		}
	}
	
	// Finalize Distributor Payments
	// ----------------------------
	if($finalize_report == true){
		
		// Finalize Payments
		// -----------------
		echo "<p>--- FINALIZING PAYMENTS</p>";
		$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributor_payments WHERE status='new'");
		$distributor_payments = $wpdb->get_results($query);
			
		if(isset($distributor_payments)){
			foreach($distributor_payments as $distributor_payment){
				// UPDATE
				// ----------
				$table_name = $wpdb->prefix . 'imlm_distributor_payments';
				$data = array(
					'timestamp' => time(),
					'status' => "complete",
				);
				$where = array(
					'imlm_distributor_id' => $distributor_payment->imlm_distributor_id, 
				);
				$result = $wpdb->update( $table_name, $data, $where );
				
				echo "<p>---- Finalized Payment: ".$distributor_payment->imlm_distributor_id."</p>";
			}
			
		}
		
	}
	
	// ------------------
	//
	//
	// CARRY OVER USER RESET
	//
	//
	// ------------------
	// At the end of the month we need to carryover the power leg earning
	// Then reset the users volume card
	if($finalize_report == true){
		
		echo "<h1>--- CARRY OVER FOR USERS</h1>";
		
		// Settle each user.
		$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors");
		$imlm_distributors = $wpdb->get_results($query);
		foreach($imlm_distributors as $imlm_distributor){
		
			if($imlm_distributor->power_leg == "left"){
				
				// UPDATE
				// ----------
				$table_name = $wpdb->prefix . 'imlm_distributors';
				$data = array(
					'timestamp' => time(),
					'right_leg_carryover' => 0,
					'left_leg_carryover' => $imlm_distributor->monthly_left_leg_volume,
				);
				$where = array(
					'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id,
				);
				$result = $wpdb->update( $table_name, $data, $where );
				
				echo "<p>---- ".$imlm_distributor->imlm_distributor." LEFT CARRYOVER: ".$imlm_distributor->monthly_left_leg_volume."</p>";
				
			}
			if($imlm_distributor->power_leg == "right"){
				
				// UPDATE
				// ----------
				$table_name = $wpdb->prefix . 'imlm_distributors';
				$data = array(
					'timestamp' => time(),
					'right_leg_carryover' => $imlm_distributor->monthly_right_leg_volume,
					'left_leg_carryover' => 0,
				);
				$where = array(
					'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id,
				);
				$result = $wpdb->update( $table_name, $data, $where );		

				echo "<p>---- ".$imlm_distributor->imlm_distributor." RIGHT CARRYOVER: ".$imlm_distributor->monthly_right_leg_volume."</p>";
				
			}
			
			// Clear User For New Month
			// ------------------------
			$table_name = $wpdb->prefix . 'imlm_distributors';
			$data = array(
				'timestamp' => time(),
				'monthly_personal_volume' => 0,
				'monthly_total_volume' => 0,
				'monthly_left_leg_volume' => 0,
				'monthly_right_leg_volume' => 0,
				'monthly_earnings' => 0,
			);
			$where = array(
				'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id,
			);
			$result = $wpdb->update( $table_name, $data, $where );
			
		
		}
		
	}
	
}
add_action( 'imlm_action_do_report_volume', 'imlm_report_volume' );




////////////////////
// get_users_with_downline
////////////////////
function get_users_with_downline($imlm_distributor_id = null) {
    global $wpdb;

    // Define the table name
    $table_name = $wpdb->prefix . 'imlm_distributors';

    // Query to fetch user and their downline
    $query = "SELECT *
              FROM $table_name AS d
              WHERE d.imlm_distributor_id = '".$imlm_distributor_id."'
              ORDER BY d.imlm_downline_left_distributor_id ASC, d.imlm_downline_right_distributor_id ASC";

    // Execute the query
    $results = $wpdb->get_results($wpdb->prepare($query));

    $user = null;

    if ($results) {
		//var_dump($results);
        $result = $results[0];
        $wp_user_id = $result->wp_user_id;
        $imlm_distributor_id = $result->imlm_distributor_id;
        $imlm_downline_left_distributor_id = $result->imlm_downline_left_distributor_id;
        $imlm_downline_right_distributor_id = $result->imlm_downline_right_distributor_id;
		
		$first_time_order_bonus_amount = 0;
		$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributor_payments WHERE (imlm_distributor_id='".$result->imlm_distributor_id."' AND status='new' AND description = 'First Time Order Bonus: Executive') OR (imlm_distributor_id='".$result->imlm_distributor_id."' AND status='new' AND description = 'First Time Order Bonus: Consultant') ");
		
		$first_time_orders = $wpdb->get_results($query);
		//var_dump($executive_bonuses);
		if(isset($first_time_orders)){
			foreach($first_time_orders as $first_time_order){
				$first_time_order_bonus_amount += (int)($first_time_order->dollar_total);
			}
		}

        $user = array(
            'wp_user_id' => $wp_user_id,
            'imlm_distributor_id' => $imlm_distributor_id,
			'enrolment_level' => $result->enrolment_level,
            'imlm_downline_left_distributor_id' => get_users_with_downline($imlm_downline_left_distributor_id),
            'imlm_downline_right_distributor_id' => get_users_with_downline($imlm_downline_right_distributor_id),
			'monthly_personal_volume' => $result->monthly_personal_volume,
			'monthly_total_volume' => $result->monthly_total_volume,
			'monthly_left_leg_volume' => $result->monthly_left_leg_volume,
			'monthly_right_leg_volume' => $result->monthly_right_leg_volume,
			'left_leg_carryover' => $result->left_leg_carryover,
			'right_leg_carryover' => $result->right_leg_carryover,
			'left_leg_distributors' => $result->left_leg_distributors,
			'right_leg_distributors' => $result->right_leg_distributors,
			'power_leg' => $result->power_leg,
			'profit_leg' => $result->profit_leg,
			'monthly_earnings' => $result->monthly_earnings,
			'rank' => $result->rank,
			'first_time_orders' => $first_time_order_bonus_amount,
        );
    }

    return $user;
}



// ========================
// ========================
// get_distributor_downline
// ========================
// ========================
function get_distributor_downline($imlm_distributor_id) {
    
	global $wpdb;
	$monthly_personal_volume = 0;

    $query = $wpdb->prepare(
        "SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id = '".$imlm_distributor_id."'",
    );
    $user_data = $wpdb->get_row($query);
	if(isset($user_data->monthly_personal_volume)){
		$monthly_personal_volume = $user_data->monthly_personal_volume;
	}

    $report_data = array(
        'imlm_distributor_id' => $imlm_distributor_id,
        'imlm_downline_left_distributor_id' => array(),
        'imlm_downline_right_distributor_id' => array(),
		'personal_volume' => calculate_monthly_personal_volume_from_new_volumes($imlm_distributor_id),
    );
	
	// Fetch the downlines and keep going
	// -----------------------

    // Retrieve downline left data
    if (isset($user_data->imlm_downline_left_distributor_id)) {
        $imlm_downline_left_distributor_id = get_distributor_downline($user_data->imlm_downline_left_distributor_id);
        if ($imlm_downline_left_distributor_id) {
            $report_data['imlm_downline_left_distributor_id'][] = $imlm_downline_left_distributor_id;			
        }
    }
    // Retrieve downline right data
    if (isset($user_data->imlm_downline_right_distributor_id)) {
        $imlm_downline_right_distributor_id = get_distributor_downline($user_data->imlm_downline_right_distributor_id);
        if ($imlm_downline_right_distributor_id) {
            $report_data['imlm_downline_right_distributor_id'][] = $imlm_downline_right_distributor_id;
        }
    }

    return $report_data;
}




function countPersonalVolumeTotal($array) {
	//var_dump($array);
	
    $total = 0;
    foreach ($array as $key => $value) {
		
        if ($key === 'personal_volume') {
            $total += $value;
        } elseif (is_array($value)) {
            $total += countPersonalVolumeTotal($value);
        }
		
    }
    return $total;
}

function countDownline($data, $left_or_right) {
	$count = 0;
	// var_dump($data);
	// var_dump($left_or_right);
	// var_dump("C:".count($data['imlm_downline_'.$left_or_right.'_distributor_id']));

    if (isset($data['imlm_downline_'.$left_or_right.'_distributor_id']) && is_array($data['imlm_downline_'.$left_or_right.'_distributor_id'])) {
        $count++;
        foreach ($data['imlm_downline_'.$left_or_right.'_distributor_id'] as $child) {
            $count += countDownline($child, $left_or_right);
        }
    }

    return $count;
}



function calculate_monthly_personal_volume_from_new_volumes($imlm_distributor_id){
	
	global $wpdb;
	$monthly_personal_volume = 0;

    $query = $wpdb->prepare(
        "SELECT * FROM ".$wpdb->prefix."imlm_volumes WHERE status='new' AND imlm_distributor_id = '".$imlm_distributor_id."'",
    );
    $volumes = $wpdb->get_results($query);
	foreach($volumes as $volume){
		$monthly_personal_volume += $volume->volume;
	}
	return $monthly_personal_volume;
	
}


function calculate_monthly_downline_volume($data) {
    $totalVolume = 0;
    
    if (isset($data['personal_volume'])) {
        $totalVolume += (int) $data['personal_volume'];
    }
    
    if (isset($data['imlm_downline_left_distributor_id'])) {
        foreach ($data['imlm_downline_left_distributor_id'] as $node) {
            $totalVolume += calculate_monthly_downline_volume($node) ?? 0; 
        }
    }
    
    if (isset($data['imlm_downline_right_distributor_id'])) {
        foreach ($data['imlm_downline_right_distributor_id'] as $node) {
            $totalVolume += calculate_monthly_downline_volume($node) ?? 0;
        }
    }
    
    return $totalVolume;
}




// =========================
//
//
//
//
//
//
//
//
// LEVERAGED MATCHING BONUS
//
//
//
//
//
//
//
//
// =========================

////////////////////
// get_leveraged_matching_bonus_downline
////////////////////
// AndrewNormore 
// - 1: Acacia, Karl, Zack, Doug
// - 2: Immaneul, Jasmine, Diane, Stephanie | (none for zack) | (none for doug)

function get_leveraged_matching_bonus_downline($search_imlm_distributor_id) {
	
	global $wpdb;
    
	// Select the root user.
	// -----------------
	$query = $wpdb->prepare(
        "SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id = '".$search_imlm_distributor_id."'",
    );
    $root_distributor = $wpdb->get_row($query);
	$root_distributor->children = [];
	
	
	
	
	// Add generation 1.
	// -----------------
	$query = $wpdb->prepare(
        "SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$root_distributor->imlm_distributor_id."'",
    );
    $children = $wpdb->get_results($query);
	
	$distributors_generation_downline[0] = $root_distributor;
	
	$index = 0;
	foreach($children as $enrolle){
		$distributors_generation_downline[1][$index] = $enrolle;
		$index++;
	}
	
	$root_distributor->children = $distributors_generation_downline[1];
	
	
	// Add generation 2.
	// -----------------
	if(isset($root_distributor->children)){
		foreach($root_distributor->children as $gen2){
			
			$gen2->children = [];
			$query = $wpdb->prepare(
				"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen2->imlm_distributor_id."'",
			);
			$gen2_enrolles = $wpdb->get_results($query);
			$gen2->children = $gen2_enrolles;
			
			// Add generation 3.
			// -----------------
			if(isset($gen2->children)){
				foreach($gen2->children as $gen3){
					
					$gen3->children = [];
					$query = $wpdb->prepare(
						"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen3->imlm_distributor_id."'",
					);
					$gen3_enrolles = $wpdb->get_results($query);
					if($gen3_enrolles){
						$gen3->children = $gen3_enrolles;
						
						// Add generation 4.
						// -----------------
						if(isset($gen3->children)){
							foreach($gen3->children as $gen4){
								
								$gen4->children = [];
								$query = $wpdb->prepare(
									"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen4->imlm_distributor_id."'",
								);
								$gen4_enrolles = $wpdb->get_results($query);
								if($gen4_enrolles){
									$gen4->children = $gen4_enrolles;
								}
								
								// Add generation 5.
								// -----------------
								if(isset($gen4->children)){
									foreach($gen4->children as $gen5){
										
										$gen5->children = [];
										$query = $wpdb->prepare(
											"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen5->imlm_distributor_id."'",
										);
										$gen5_enrolles = $wpdb->get_results($query);
										if($gen5_enrolles){
											$gen5->children = $gen5_enrolles;
										}
										
										// Add generation 6.
										// -----------------
										if(isset($gen5->children)){
											foreach($gen5->children as $gen6){
												
												$gen6->children = [];
												$query = $wpdb->prepare(
													"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen6->imlm_distributor_id."'",
												);
												$gen6_enrolles = $wpdb->get_results($query);
												if($gen6_enrolles){
													$gen6->children = $gen6_enrolles;
												}
												
												// Add generation 7.
												// -----------------
												if(isset($gen6->children)){
													foreach($gen6->children as $gen7){
														
														$gen7->children = [];
														$query = $wpdb->prepare(
															"SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_enroller_distributor_id = '".$gen7->imlm_distributor_id."'",
														);
														$gen7_enrolles = $wpdb->get_results($query);
														if($gen7_enrolles){
															$gen7-> children = $gen7_enrolles;
														}
														
													}
												}
												
											}
										}
										
									}
								}
								
							}
						}
					}
					
				}
			}
			
		}
	}

	
	return($root_distributor);
	
}





// =========================
//
//
//
//
//
//
//
//
// WOOCOMMERCE CUSTOMIZATIONS
//
//
//
//
//
//
//
//
// =========================


// Register "Accepted" order status
// ------------------------------------------
function custom_register_order_status() {
    register_post_status('wc-accepted', array(
        'label'                     => 'Accepted',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Accepted <span class="count">(%s)</span>', 'Accepted <span class="count">(%s)</span>')
    ));
}
add_action('init', 'custom_register_order_status');
	
// Add "Accepted" order status to the list of statuses
// ------------------------------------------
function custom_add_order_statuses($order_statuses) {
    $order_statuses['wc-accepted'] = 'Accepted';
    return $order_statuses;
}
add_filter('wc_order_statuses', 'custom_add_order_statuses');

// Custom hook function for "Accepted" order status
// ------------------------------------------
function custom_order_status_accepted($order_id) {
	global $wpdb;
	
    $order = wc_get_order($order_id);
	
	$user = $order->get_user();
	$user_id = $order->get_user_id();
	
	$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE wp_user_id ='".$user_id."'", );
	$imlm_distributor = $wpdb->get_row($query);
		


	// ORDER LOOP
	// --------------
    foreach ($order->get_items() as $item_id => $item) {
		
		$product_id = $item->get_product_id();
		$quantity = $item->get_quantity();
		$product_title = $item->get_name();
		
		// FETCH PRODUCT VOLUME
		// -------------
		$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_product_volumes WHERE woocommerce_product_id ='".$product_id."'", );
		$imlm_product_volume = $wpdb->get_row($query);
		
		// ADD TO VOLUME
		// -------------
		$table_name = $wpdb->prefix . 'imlm_volumes';
		$data = array(
			'timestamp' => time(),
			'description' => "Regular Order Volume",
			'status' => "new",
			'imlm_distributor_id' => $imlm_distributor->imlm_distributor_id,
			'volume' => $imlm_product_volume->volume * $quantity,
			'woocommerce_order_id' => $order_id,
			'woocommerce_product_title' => $product_title,
			'woocommerce_product_id' => $product_id,
			'woocommerce_quantity' => $quantity,
			'woocommerce_item_total' => number_format($item->get_total(),2),
			'woocommerce_item_total_tax' => number_format($item->get_total_tax(),2),
			'woocommerce_order_item_shipping_tax_amount' => number_format($order->get_item_shipping_tax_amount($item),2),
			'woocommerce_item_shipping_amount' => number_format($order->get_item_shipping_amount($item),2),
		);
		$wpdb->insert(
			$table_name,
			$data
		);
		
    }
	
	

	
}
add_action('woocommerce_order_status_accepted', 'custom_order_status_accepted', 10, 1);


// Automatically change "Processing" orders to "Accepted" status by default
function custom_auto_update_order_status($order_id) {
    // Get the order object
    $order = wc_get_order($order_id);
    
    // Check if the order status is "processing"
    if ($order->get_status() === 'processing') {
        // Update the order status to "Accepted"
        $order->update_status('accepted');
    }
}
add_action('woocommerce_thankyou', 'custom_auto_update_order_status', 10, 1); //Standard /thank-you page



// ADD TO BULK ACTIONS
// Add "Accepted" as a bulk action in WooCommerce orders page
function custom_add_bulk_action($actions) {
    $actions['mark_accepted'] = 'Mark as Accepted';
    return $actions;
}
add_filter('bulk_actions-edit-shop_order', 'custom_add_bulk_action', 20, 1);

// Handle the "Mark as Accepted" bulk action
function custom_handle_bulk_action() {
    // Verify the action
    if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'mark_accepted') {
        // Get selected order IDs
        $order_ids = isset($_REQUEST['post']) ? array_map('intval', $_REQUEST['post']) : array();
        
        // Loop through selected orders and update the status to "Accepted"
        foreach ($order_ids as $order_id) {
            $order = wc_get_order($order_id);
            
            // Check if the current status is "Processing"
            if ($order->get_status() === 'processing') {
                // Update the order status to "Accepted"
                $order->update_status('accepted');
            }
        }
        
        // Redirect back to the orders page after bulk action
        $redirect_url = admin_url('edit.php?post_type=shop_order');
        wp_redirect($redirect_url);
        exit;
    }
}
add_action('admin_action_mark_accepted', 'custom_handle_bulk_action');





// WooCommerce Subscription processing -> Accepted
// ---------------------------------------------
function woocommerce_subscription_processing_to_accepted(){

	global $wpdb;
	
	$orders = wc_get_orders(array(
		'status' => 'processing',
		'limit' => -1, // Retrieve all orders, use a positive number for a specific limit
	));

	// Loop through the orders
	foreach ($orders as $order) {
		
		// Check if the order status is "processing"
		if ($order->get_status() === 'processing') {
			// Update the order status to "Accepted"
			$order->update_status('accepted');
		}
		
	}
	
}
add_action( 'imlm_action_processing_to_accepted', 'woocommerce_subscription_processing_to_accepted' );






// ===============================
//
//
//
//
//
//
// FRONT END SHORTCODE
//
//
//
//
//
//
// ===============================

// Bitcoin
function qrcode_btc_rewrite() {
    add_rewrite_rule('^pricecheck/btc/([^/]+)/?', 'index.php?address=$matches[1]', 'top');
}
add_action('init', 'qrcode_btc_rewrite');

// Litecoin
function qrcode_ltc_rewrite() {
    add_rewrite_rule('^pricecheck/ltc/([^/]+)/?', 'index.php?address=$matches[1]', 'top');
}
add_action('init', 'qrcode_ltc_rewrite');

// Ethereum
function qrcode_eth_rewrite() {
    add_rewrite_rule('^pricecheck/eth/([^/]+)/?', 'index.php?address=$matches[1]', 'top');
}
add_action('init', 'qrcode_eth_rewrite');


add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'address';
    return $query_vars;
} );

add_action( 'template_include', function( $template ) {
	
    if ( get_query_var( 'address' ) == false || get_query_var( 'address' ) == '' ) {
        return $template;
    }
	get_header(); 
	
	$url = $_SERVER['REQUEST_URI'];
    $path = parse_url($url, PHP_URL_PATH);
    $last_value = basename($path);
	
	$paths = explode("/",$url);
	//var_dump($paths);
	
	$coin_type = "UNSET";
	if($paths[2]=="btc"){
		$coin_type = "btc";
	}
	if($paths[2]=="ltc"){
		$coin_type = "ltc";
	}
	if($paths[2]=="eth"){
		$coin_type = "eth";
	}
	
	
	// BITCOIN
	// ---------
	if($coin_type == "btc"){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.blockcypher.com/v1/btc/main/addrs/' . $last_value);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

		$output = json_decode(curl_exec($ch));

		// Check for cURL errors
		if (curl_errno($ch)) {
			$error_message = curl_error($ch);
			// Handle the error accordingly
			// For example: echo "cURL Error: " . $error_message;
		}

		// Close cURL session
		curl_close($ch);
		
		//var_dump($output);
		
		// FETCH CANADIAN DOLLAR
		// ----------------------
		$cad_api_url = 'https://api.coindesk.com/v1/bpi/currentprice/CAD.json';
		$response = file_get_contents($cad_api_url);
		$data = json_decode($response, true);

		?>
			<div style="width:100%; background:black; color:white; text-align:center; padding:4px;"><a href="/?src=from_qr_scanner" style='color:white;'>Click Here To Start Your Own Bitcoin Business Today!</a></div>
		<?php

		echo( "<h2>Bitcoin Certificate Address: $output->address</h2>" );
		echo( "<p style='color:green;'><strong>This Bitcoin Certificate Value CAD: $".number_to_dollar_full((number_to_bitcoin_full($output->balance)*$data['bpi']['CAD']['rate_float']))."</strong></p>" );
		echo( "<p>Bitcoin Certificate Balance: ".number_to_bitcoin_full($output->balance)."</p>" );
		echo( "<p>1 Bitcoin Current Value CAD: $".number_to_dollar_full($data['bpi']['CAD']['rate_float'])."</p>" );
		echo( "<p>Received: ".number_to_bitcoin_full($output->total_received)."</p>" );
		echo( "<p>Sent: ".number_to_bitcoin_full($output->total_sent)."</p>" );
		
		echo "<h3>Transactions:</h3>";
		echo "<hr />";
		if(isset($output->txrefs)){
			foreach($output->txrefs as $tx){
				echo( "<p>Transaction Date: $tx->confirmed</p>" );
				echo( "<p>Bitcoin Value: ".number_to_bitcoin_full($tx->value)."</p>" );
				echo( "<p>CAD Value: $".number_to_dollar_full(number_to_bitcoin_full($tx->value)*$data['bpi']['CAD']['rate_float'])."</p>" );
				echo( "<p>tx_input_n: $tx->tx_input_n</p>" );
				echo( "<p>tx_output_n: $tx->tx_output_n</p>" );
				echo( "<p>ref_balance: $tx->ref_balance</p>" );
				echo( "<p>confirmations: $tx->confirmations</p>" );
				echo "<hr />";
			}
		}
	}
	
	// LITECOIN
	// ---------
	if($coin_type == "ltc"){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.blockcypher.com/v1/ltc/main/addrs/' . $last_value);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

		$output = json_decode(curl_exec($ch));

		// Check for cURL errors
		if (curl_errno($ch)) {
			$error_message = curl_error($ch);
			// Handle the error accordingly
			// For example: echo "cURL Error: " . $error_message;
		}

		// Close cURL session
		curl_close($ch);
		//var_dump($output);
		
		// FETCH CANADIAN DOLLAR
		// ----------------------
		$cad_api_url = 'https://api.coingecko.com/api/v3/simple/price?ids=litecoin&vs_currencies=cad';
		$response = file_get_contents($cad_api_url);
		$data = json_decode($response, true);
		// var_dump($data['litecoin']['cad']);
		
		$litecoin_balance = (float)$output->balance;
		$litecoin_price = $data['litecoin']['cad'];
		var_dump(number_to_litecoin_full($litecoin_balance));
		var_dump($litecoin_price);
		var_dump(number_to_dollar_full((number_to_litecoin_full($litecoin_balance)*$litecoin_price)));
		
		
		?>
			<div style="width:100%; background:black; color:white; text-align:center; padding:4px;"><a href="/?src=from_qr_scanner" style='color:white;'>Click Here To Start Your Own Bitcoin Business Today!</a></div>
		<?php

		echo( "<h2>Litecoin Certificate Address: $output->address</h2>" );
		echo( "<p style='color:green;'><strong>This Litecoin Certificate Value CAD: $".number_to_dollar_full((number_to_litecoin_full($litecoin_balance)*$litecoin_price))."</strong></p>" );
		echo( "<p>Litecoin Certificate Balance: ".number_to_litecoin_full($litecoin_balance)."</p>" );
		echo( "<p>1 Litecoin Current Value CAD: $".number_to_dollar_full($litecoin_price)."</p>" );
		echo( "<p>Received: ".number_to_litecoin_full($output->total_received)."</p>" );
		echo( "<p>Sent: ".number_to_litecoin_full($output->total_sent)."</p>" );
		
		echo "<h3>Transactions:</h3>";
		echo "<hr />";
		if(isset($output->txrefs)){
			foreach($output->txrefs as $tx){
				echo( "<p>Transaction Date: $tx->confirmed</p>" );
				echo( "<p>Litecoin Value: ".number_to_litecoin_full($tx->value)."</p>" );
				echo( "<p>CAD Value: $".number_to_dollar_full(number_to_litecoin_full($tx->value)*$litecoin_price)."</p>" );
				echo( "<p>tx_input_n: $tx->tx_input_n</p>" );
				echo( "<p>tx_output_n: $tx->tx_output_n</p>" );
				echo( "<p>ref_balance: $tx->ref_balance</p>" );
				echo( "<p>confirmations: $tx->confirmations</p>" );
				echo "<hr />";
			}
		}
	}
	
	// ETHEREUM
	// ---------
	if($coin_type == "eth"){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.blockcypher.com/v1/eth/main/addrs/' . $last_value);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

		$output = json_decode(curl_exec($ch));

		// Check for cURL errors
		if (curl_errno($ch)) {
			$error_message = curl_error($ch);
			// Handle the error accordingly
			// For example: echo "cURL Error: " . $error_message;
		}

		// Close cURL session
		curl_close($ch);
		// var_dump($output->balance);
		// var_dump(number_to_ethereum_full($output->balance));
		
		// FETCH CANADIAN DOLLAR
		// ----------------------
		$cad_api_url = 'https://api.coingecko.com/api/v3/simple/price?ids=ethereum&vs_currencies=cad';
		$response = file_get_contents($cad_api_url);
		$data = json_decode($response, true);
		// var_dump($data['litecoin']['cad']);
		
		$ethereum_balance = (float)$output->balance;
		$ethereum_price = $data['ethereum']['cad'];
		//var_dump($ethereum_price);
		
		?>
			<div style="width:100%; background:black; color:white; text-align:center; padding:4px;"><a href="/?src=from_qr_scanner" style='color:white;'>Click Here To Start Your Own Bitcoin Business Today!</a></div>
		<?php

		echo( "<h2>Ethereum Certificate Address: $output->address</h2>" );
		echo( "<p style='color:green;'><strong>This Ethereum Certificate Value CAD: $".number_to_dollar_full((number_to_ethereum_full($ethereum_balance)*(int)$ethereum_price))."</strong></p>" );
		echo( "<p>Ethereum Certificate Balance: ".number_to_ethereum_full($output->balance)."</p>" );
		echo( "<p>1 Ethereum Current Value CAD: $".number_to_dollar_full($ethereum_price)."</p>" );
		echo( "<p>Received: ".number_to_ethereum_full($output->total_received)."</p>" );
		echo( "<p>Sent: ".number_to_ethereum_full($output->total_sent)."</p>" );
		
		echo "<h3>Transactions:</h3>";
		echo "<hr />";
		if(isset($output->txrefs)){
			foreach($output->txrefs as $tx){
				echo( "<p>Transaction Date: $tx->confirmed</p>" );
				echo( "<p>Ethereum Value: ".number_to_ethereum_full($tx->value)."</p>" );
				echo( "<p>CAD Value: $".number_to_dollar_full(number_to_ethereum_full($tx->value)*$ethereum_price)."</p>" );
				echo( "<p>tx_input_n: $tx->tx_input_n</p>" );
				echo( "<p>tx_output_n: $tx->tx_output_n</p>" );
				echo( "<p>ref_balance: $tx->ref_balance</p>" );
				echo( "<p>confirmations: $tx->confirmations</p>" );
				echo "<hr />";
			}
		}
	}
	
	
	
	
	// ALL DONE
	// ----------
	get_footer();

} );











// =========================
//
//
//
//
//
//
//
//
// FRONT END
//
//
//
//
//
//
//
//
// =========================
function function_imlm_autoship_team_volume($atts) {
    
	
	// Get the current user's login name
    $current_user = wp_get_current_user();
    $login_name = $current_user->user_login;

    ?>
			
	<script>
		var mlm_data = <?php echo json_encode(get_users_with_downline($login_name)); ?>;
	</script>
	
	<br />
	<div id="chart-container"></div>
	
	<link rel="stylesheet" href="https://dabeng.github.io/OrgChart/css/jquery.orgchart.css" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://dabeng.github.io/OrgChart/js/jquery.orgchart.js"></script>
	
	<style>
	
		.hierarchy, .orgchart {background:white !important;}
		#chart-container {
		  position: relative;
		  height: 1420px;
		  border: 1px solid #aaa;
		  margin: 0.5rem;
		  overflow: auto;
		  text-align: center;
		  background:white !important;
		}
	
		.orgchart {
			width:100%; height:1000px;
		}
		.orgchart .node .verticalEdge, .orgchart .node .horizontalEdge { 
			display: none; 
		}
		.orgchart .node:hover, .orgchart .node.focused { 
			background: none !important; 
		}
		.orgchart .nodes {
		  justify-content: center;
		}
		.orgchart .node .title {
		  width: auto;
		  text-align:center;
		  padding:0px 7px 0px 7px;
		  height:20px;
		  vertical-align: middle;
		}
		.orgchart .node .content {
		  width: auto;
		  text-align:center;
		  padding:0px 7px 0px 7px;
		  height:auto;
		  vertical-align: middle;
		}
		.parentNodeSymbol {display:none;}
		.nodeGuts{ height:auto; }
	</style>

	<script>
	   
		// Convert nested data to OrgChart-compatible format
		function convertToOrgChartFormat(data) {
			
			console.log(data);
			
			var orgChartData = {
			  id: data.wp_user_id,
			  title: data.imlm_distributor_id,
			  content: "<div class='nodeGuts'>" +
					"<b>Rank:</b> " + data.rank + "<br />" +
					"<b>Personal Volume</b>: " + data.monthly_personal_volume + "<br />" +
					
					"<hr />" +
					
					"<b>Total Team Volume</b>: " + data.monthly_total_volume + "<br />" +
					"<b>Left Leg Volume</b>: " + (parseInt(data.monthly_left_leg_volume)) + "<br />" +
					"<b>Right Leg Volume</b>: " + (parseInt(data.monthly_right_leg_volume)) + "<br />" +
					
					"<hr />" +
					
					"<b>Left Leg Carryover</b>: " + data.left_leg_carryover + "<br />" +
					"<b>Right Leg Carryover</b>: " + data.right_leg_carryover + "<br />" +
					"<b>Left Leg Distributors</b>: " + data.left_leg_distributors + "<br />" +
					"<b>Right Leg Distributors</b>: " + data.right_leg_distributors + "<br />" +
					"<b>Profit Leg</b>: " + data.profit_leg + "<br />" +
					"<b>Power Leg</b>: " + data.power_leg + "<br />" +
					
					"<hr />" +
					
					"<b>Team Volume Earnings</b>: $" + data.monthly_earnings + "<br />" +
					"<b>Generation Comission</b>: $0.00<br />" +
					"<b>Executive Bonus</b>: $0.00<br />" +
					"<b>First Time Orders</b>: $" + data.first_time_orders + "<br />" +
					"<b>Luxury Car Bonus</b>: $0.00<br />" +
					"<b>Leadership Retreat Allowance</b>: $0.00<br />" +
					
					"<hr />" +
					
					"<b>Total Payout</b>: $"+(parseFloat(data.first_time_orders)+parseFloat(data.monthly_earnings))+"<br />" +
					
					"<hr />" +
					
					"<a href=''>View Profile</a> | " +
					"<a href=''>Edit Member</a> | " +
					"<a href=''>Email</a>" +
				"</div>",
			  children: []
			};

		
			if (data.imlm_downline_left_distributor_id) {
				orgChartData.children.push(convertToOrgChartFormat(data.imlm_downline_left_distributor_id));
			} else {
				orgChartData.children.push({ id: "", title: "", content:"<a href='/wp-admin/admin.php?page=imlm-admin-dashboard&action=downline-add&left-or-right=left&imlm_distributor_id="+data.imlm_distributor_id+"'>Add Left Downline</a>", children: [], addMember: true });
			}

			if (data.imlm_downline_right_distributor_id) {
				orgChartData.children.push(convertToOrgChartFormat(data.imlm_downline_right_distributor_id));
			} else {
				orgChartData.children.push({ id: "", title: "", content:"<a href='/wp-admin/admin.php?page=imlm-admin-dashboard&action=downline-add&left-or-right=right&imlm_distributor_id="+data.imlm_distributor_id+"'>Add Right Downline</a>", children: [], addMember: true });
			}

			return orgChartData;
		}

		// Create the OrgChart
		$(document).ready(function() {
			var orgChartData = convertToOrgChartFormat(mlm_data);
			
			var orgchart = $("#chart-container").orgchart({
				data: orgChartData,
				nodeTitle: "title",
				nodeContent: "content",
				pan: true,
				zoom: true,
				grid: false,
			});

			orgchart.$chartContainer.on('touchmove', function(event) {
				event.preventDefault();
			});
		});
		

	</script>
			
	<?php
}
add_shortcode('imlm_autoship_team_volume', 'function_imlm_autoship_team_volume');


function function_imlm_imlm_7generations($atts) {
    
	
	// Get the current user's login name
    $current_user = wp_get_current_user();
    $login_name = $current_user->user_login;

    ?>
			
	<div id="chart-container"></div>
			
		<link rel="stylesheet" href="https://dabeng.github.io/OrgChart/css/jquery.orgchart.css" />
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="/wp-content/plugins/investus-binary-mlm/public/js/orgchart.js?v=12"></script>
		
		<style>
			.hierarchy, .orgchart {background:white !important;}
			#chart-container {
			  position: relative;
			  height: 1420px;
			  border: 1px solid #aaa;
			  margin: 0.5rem;
			  overflow: auto;
			  text-align: center;
			  background:white !important;
			}
		
			.orgchart {
				width:100%; height:1000px;
			}
			.orgchart .node .verticalEdge, .orgchart .node .horizontalEdge { 
				display: none; 
			}
			.orgchart .node:hover, .orgchart .node.focused { 
				background: none !important; 
			}
			.orgchart .nodes {
			  justify-content: center;
			}
			.orgchart .node .title {
			  width: auto;
			  text-align:center;
			  padding:0px 7px 0px 7px;
			  height:20px;
			  vertical-align: middle;
			}
			.orgchart .node .content {
			  width: auto;
			  text-align:center;
			  padding:0px 7px 0px 7px;
			  height:auto;
			  vertical-align: middle;
			}
			.parentNodeSymbol {display:none;}
			.nodeGuts{ height:auto; }
		</style>

		<script>

		// Convert nested data to OrgChart-compatible format
		function convertToOrgChartFormat(data) {
			
			console.log(data);
			
			var orgChartData = {
			  id: data.wp_user_id,
			  title: data.imlm_distributor_id,
			  content: "<div class='nodeGuts'>" +
					"<b>Enrolment Level</b>: " + data.enrolment_level + "<br />" +
						"<b>Rank:</b> " + data.rank + "<br />" +
						"<b>Personal Volume</b>: " + data.monthly_personal_volume + "<br />" +
						
						"<hr />" +
						
						"<b>Total Team Volume</b>: " + data.monthly_total_volume + "<br />" +
						"<b>Left Leg Volume</b>: " + data.monthly_left_leg_volume + "<br />" +
						"<b>Right Leg Volume</b>: " + data.monthly_right_leg_volume + "<br />" +
						"<b>Left Leg Distributors</b>: " + data.left_leg_distributors + "<br />" +
						"<b>Right Leg Distributors</b>: " + data.right_leg_distributors + "<br />" +
						"<b>Profit Leg</b>: " + data.profit_leg + "<br />" +
						"<b>Power Leg</b>: " + data.power_leg + "<br />" +
						
						"<hr />" +
						
						"<b>Team Volume Earnings</b>: $" + data.monthly_earnings + "<br />" +
						"<b>Generation Comission</b>: $0.00<br />" +
						"<b>Executive Bonus</b>: $0.00<br />" +
						"<b>First Time Orders</b>: $" + data.first_time_orders + "<br />" +
						"<b>Luxury Car Bonus</b>: $0.00<br />" +
						"<b>Leadership Retreat Allowance</b>: $0.00<br />" +
						
						"<hr />" +
						
						"<b>Total Payout</b>: $"+(parseFloat(data.first_time_orders)+parseFloat(data.monthly_earnings))+"<br />" +
						
						"<hr />" +
						
						"<a href=''>View Profile</a> | " +
						"<a href=''>Edit Member</a> | " +
						"<a href=''>Email</a>" +
				"</div>",
			  children: []
			};
			
			if (data.children) {
				data.children.forEach(function(child){
					orgChartData.children.push(convertToOrgChartFormat(child));
				});
			}

			return orgChartData;
		}
		
		

		// Create the OrgChart
		$(document).ready(function() {
			
			var orgChartData = convertToOrgChartFormat(<?php echo json_encode(get_leveraged_matching_bonus_downline($login_name), 128); ?>);
			console.log(orgChartData);
			
			var orgchart = $("#chart-container").orgchart({
				data: orgChartData,
				nodeTitle: "title",
				nodeContent: "content",
				pan: true,
				zoom: true,
				grid: false,
			});

			orgchart.$chartContainer.on('touchmove', function(event) {
				event.preventDefault();
			});
		});
	  </script>
			
	<?php
}
add_shortcode('imlm_7generations', 'function_imlm_imlm_7generations');

function function_imlm_my_team($atts) {
    
	global $wpdb;
	
	// Get the current user's login name
    $current_user = wp_get_current_user();
    $login_name = $current_user->user_login;
	
	$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id = '".$login_name."'");
    $this_distributor = $wpdb->get_row($query);
		
	
	$downlines = get_users_with_downline($login_name);
	$extracted = extract_downline_data($downlines);
	
	$users_list = array($login_name);
	foreach($extracted as $extract){
		array_push($users_list, $extract['imlm_distributor_id']);
	}
	
	
	$distributors = array();
	foreach($users_list as $search_user){
		$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id = '".$search_user."'");
		$distributor = $wpdb->get_row($query);
		array_push($distributors, $distributor);
	}
	
	
	?>
    <style>
		.alternate{ background-color: #ccd5d5; }
	</style>
		
		<table class="widefat fixed" cellspacing="0">
			<thead>
			<tr>
				<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Earnings</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">DistributorID</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Enrolment Level</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Enroller</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Upline</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Left Downline</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Right Downline</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Rank</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Personal Volume</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Total Team Volume</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Left Leg Volume</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Monthly Right Leg Volume</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Left Leg Distributors</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Right Leg Distributors</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Profit Leg</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Power Leg</th>
			</tr>
			</thead>

			<tbody>
				
				<?php
				
				$row_counter = 0;
				
				
				foreach ($distributors as $imlm_distributor) {
					
					//var_dump($imlm_distributor->id);
					
					$row_counter+=1;
				
					
					?>
						<?php
						if($row_counter % 2 == 0){
							?><tr class="alternate"><?php
						}
						else{
							?><tr class=""><?php
						}
						?>
							<td class="column-columnname">$<?php echo $imlm_distributor->monthly_earnings; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->imlm_distributor_id; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->enrolment_level; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->imlm_enroller_distributor_id; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->imlm_upline_distributor_id; ?></td>
							<td class="column-columnname">
								<?php 
									if($imlm_distributor->imlm_downline_left_distributor_id){
										echo $imlm_distributor->imlm_downline_left_distributor_id; 
									}
								?>
							</td>
							<td class="column-columnname">
								<?php 
									if($imlm_distributor->imlm_downline_right_distributor_id){
										echo $imlm_distributor->imlm_downline_right_distributor_id; 
									}
								?>
							</td>
							
							<td class="column-columnname">Consultant</td>
							<td class="column-columnname"><?php echo $imlm_distributor->monthly_personal_volume; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->monthly_total_volume; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->monthly_left_leg_volume; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->monthly_right_leg_volume; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->left_leg_distributors; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->right_leg_distributors; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->profit_leg; ?></td>
							<td class="column-columnname"><?php echo $imlm_distributor->power_leg; ?></td>
					
							
						</tr>
					<?php
				}?>
				
				
				
			
			</tbody>
			
		</table>
	<?php
	
}
add_shortcode('imlm_my_team', 'function_imlm_my_team');

function extract_downline_data($data) {
    $extracted_data = array();

    // Recursively traverse the data
    $recursive_extraction = function ($data) use (&$recursive_extraction, &$extracted_data) {
        foreach ($data as $key => $value) {
            if ($key === 'imlm_downline_left_distributor_id' || $key === 'imlm_downline_right_distributor_id') {
                if (is_array($value)) {
                    $extracted_data[] = $value;
                    $recursive_extraction($value);
                }
            } elseif (is_array($value)) {
                $recursive_extraction($value);
            }
        }
    };

    // Start extraction
    $recursive_extraction($data);

    return $extracted_data;
}


// MY EARNINGS
// --------------------
function function_imlm_my_earnings($atts) {
    
	global $wpdb;
	
	// Get the current user's login name
    $current_user = wp_get_current_user();
    $login_name = $current_user->user_login;
	
	$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributor_payments WHERE imlm_distributor_id = '".$login_name."'");
    $paymments = $wpdb->get_results($query);
	
	?>
    <style>
		.alternate{ background-color: #ccd5d5; }
	</style>
		
		<table class="widefat fixed" cellspacing="0">
			<thead>
			<tr>
				<th id="columnname" class="manage-column column-columnname " scope="col">Date</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Description</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Status</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Paid</th>
				<th id="columnname" class="manage-column column-columnname " scope="col">Amount</th>
			</tr>
			</thead>

			<tbody>
				
				<?php
				
				$row_counter = 0;
				
				
				foreach ($paymments as $payment) {
					
					$row_counter+=1;
					
					?>
						<?php
						if($row_counter % 2 == 0){
							?><tr class="alternate"><?php
						}
						else{
							?><tr class=""><?php
						}
						?>
							<td class="column-columnname"><?php echo $payment->date; ?></td>
							<td class="column-columnname"><?php echo $payment->description; ?></td>
							<td class="column-columnname"><?php echo $payment->status; ?></td>
							<td class="column-columnname"><?php echo $payment->paid; ?></td>
							<td class="column-columnname">$<?php echo $payment->dollar_total; ?></td>
					
							
						</tr>
					<?php
				}?>
				
				
				
			
			</tbody>
			
		</table>
	<?php
	
}
add_shortcode('imlm_my_earnings', 'function_imlm_my_earnings');

// PAYMENT INFORMATION
// --------------------
function function_imlm_payment_information($atts) {
	
	global $wpdb;
	
	// Get the current user
    $current_user = wp_get_current_user();
	
	
	// Get the current user's login name
    $current_user = wp_get_current_user();
    $login_name = $current_user->user_login;
	
	$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id = '".$login_name."'");
    $imlm_distributor = $wpdb->get_row($query);
	
	if(isset($_GET['action']) && $_GET['action'] == "updated"){
		?>
			<div class="alert-success">Payment Information Updated!</div>
			
			<style>
				.alert-success{
					color: #155724;
					background-color: #d4edda;
					border-color: #c3e6cb;
				}
			</style>
		<?php
	}
    
    // Check if the user is logged in
    if ( $current_user->ID != 0 ) {
        ob_start();
        ?>
        <form method="POST">
            
			<h3>E-Transfer Email Address</h3>
			<label for="etransfer_email">eTransfer Email:</label>
            <input type="email" name="payment_etransfer_email" id="payment_etransfer_email" value="<?php echo( $imlm_distributor->payment_etransfer_email )?>" >
			
			<h3>Direct Deposit Banking Information</h3>
            <label for="bank_transit">Bank Transit:</label>
            <input type="text" name="payment_bank_transit" id="payment_bank_transit" value="<?php echo( $imlm_distributor->payment_bank_transit )?>" >

            <label for="bank_institution">Bank Institution:</label>
            <input type="text" name="payment_bank_institution" id="payment_bank_institution" value="<?php echo( $imlm_distributor->payment_bank_institution )?>" >

            <label for="bank_account_number">Bank Account Number:</label>
            <input type="text" name="payment_bank_account_number" id="payment_bank_account_number" value="<?php echo( $imlm_distributor->payment_bank_account_number )?>" >

            <input type="submit" value="Save Banking Information">
        </form>
        <?php
        return ob_get_clean();
    } else {
        return 'You must be logged in to view this form.';
    }

}
add_shortcode('imlm_payment_information', 'function_imlm_payment_information');

// COLLECT INFORMATION
// --------------------
function save_payment_information() {
	
	global $wpdb;
	
    // Check if the form is submitted
    if ( isset( $_POST['payment_etransfer_email'] ) && isset( $_POST['payment_bank_transit'] ) && isset( $_POST['payment_bank_institution'] ) && isset( $_POST['payment_bank_account_number'] ) ) {
        // Get the current user
        $current_user = wp_get_current_user();
        
        // Get the submitted payment information
        $payment_etransfer_email = sanitize_email( $_POST['payment_etransfer_email'] );
        $payment_bank_transit = sanitize_text_field( $_POST['payment_bank_transit'] );
        $payment_bank_institution = sanitize_text_field( $_POST['payment_bank_institution'] );
        $payment_bank_account_number = sanitize_text_field( $_POST['payment_bank_account_number'] );
        
		$table_name = $wpdb->prefix . 'imlm_distributors';
		$data = array(
			'payment_etransfer_email' => $payment_etransfer_email,
			'payment_bank_transit' => $payment_bank_transit,
			'payment_bank_institution' => $payment_bank_institution,
			'payment_bank_account_number' => $payment_bank_account_number,
		);
		$where = array(
			'wp_user_id' => $current_user->ID, // Example condition
		);
		$wpdb->update( $table_name, $data, $where );
        
        wp_redirect( home_url( '/account/payment-information?action=updated' ) );
        exit;
    }
}
add_action( 'init', 'save_payment_information' );






// =========================
//
//
//
//
//
//
//
//
// USER SIGNUPS
//
//
//
//
//
//
//
//
// =========================

function add_product_to_cart_by_name($product_name, $quantity = 1) {
    // Search for the product by name
    $product = get_page_by_title($product_name, OBJECT, 'product');
    
    // Check if the product exists
    if ($product) {
        // Get the product ID
        $product_id = $product->ID;
        
        // Add the product to the cart
        WC()->cart->add_to_cart($product_id, $quantity);
        
    }
}

// JOIN AS CONSULTANT
// ----------------------------
function function_imlm_woocommerce_consultant_cart($atts) {
   
   echo 'Adding to cart...';
   
   WC()->cart->empty_cart();
   
   add_product_to_cart_by_name("Distributors Membership License",1);
   add_product_to_cart_by_name("Bitcoin Certificate GOLD",1);
   add_product_to_cart_by_name("Ethereum Certificate GOLD",1);
   
   wp_redirect(wc_get_cart_url());
   exit;
   
}
add_shortcode('imlm_woocommerce_consultant_cart', 'function_imlm_woocommerce_consultant_cart');

// JOIN AS EXECUTIVE CART SETUP
// ----------------------------
function function_imlm_woocommerce_executive_cart($atts) {
   
   echo 'Adding to cart...';
   
   WC()->cart->empty_cart();
   
   add_product_to_cart_by_name("Distributors Membership License",1);
   add_product_to_cart_by_name("Bitcoin Certificate GOLD",4);
    add_product_to_cart_by_name("Litecoin Certificate GOLD",3);
   add_product_to_cart_by_name("Ethereum Certificate GOLD",3);
   
   wp_redirect(wc_get_cart_url());
   exit;
   
}
add_shortcode('imlm_woocommerce_executive_cart', 'function_imlm_woocommerce_executive_cart');



// WOOCOMMERCE SELECT YOUR ENROLLER
// -----------------------------
function imlm_checkout_add_enroller($fields) {
	
	$subscribers = get_users(array('role' => 'subscriber'));

    $options = array('' => __('Select Your Enroller', 'your-domain'));

    foreach ($subscribers as $subscriber) {
        $options[$subscriber->user_login] = $subscriber->user_login;
    }

    $fields['billing']['enroller_username'] = array(
        'label'     => __('Please select the Investus Digital who enrolled you (IMPORTANT: DO NOT GET THIS WRONG!)', 'your-domain'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => true,
        'type'      => 'select',
        'options'   => $options,
    );
    return $fields;
	
}
add_filter('woocommerce_checkout_fields', 'imlm_checkout_add_enroller');

// WOOCOMMERCE SELECT YOUR UPLINE
// -----------------------------
function imlm_checkout_add_upline($fields) {
	
	$subscribers = get_users(array('role' => 'subscriber'));

    $options = array('' => __('Select Your Upline', 'your-domain'));

    foreach ($subscribers as $subscriber) {
        $options[$subscriber->user_login] = $subscriber->user_login;
    }

    $fields['billing']['upline_username'] = array(
        'label'     => __('Select your Investus Digital Upline Distributor (ASK YOUR UPLINE IF YOU ARE NOT SURE)', 'your-domain'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => true,
        'type'      => 'select',
        'options'   => $options,
    );
    return $fields;
	
}
add_filter('woocommerce_checkout_fields', 'imlm_checkout_add_upline');

// CUSTOMIZE USERNAME TO THE PROPER FORMAT
// -----------------------------
function imlm_change_username_on_registration($customer_id) {
	
	global $wpdb;
    $user = get_userdata($customer_id);

    // Extract the user's first name and last name
    $first_name = $user->first_name;
    $last_name = $user->last_name;

    // Format the username (e.g., FirstNameLastName)
    $username = ucfirst($first_name).ucfirst($last_name). rand(1000, 9999);

    // Update the user's username
    //wp_update_user(array('ID' => $customer_id, 'user_login' => $username));
	
	$table_name = $wpdb->prefix . 'users';
	$data = array(
		'user_login' => $username,
	);
	$where = array(
		'ID' => $customer_id, // Example condition
	);
	$wpdb->update( $table_name, $data, $where );
	
}
add_action('user_register', 'imlm_change_username_on_registration', 1, 1);


// FRONT END ADD NEW DISTRIBUTOR
// -----------------------------
function imlm_frontend_create_distributor($order, $data) {
	
	global $wpdb;
		
	$current_user = wp_get_current_user();
	$login_name = $current_user->user_login;

	// Now let's add some custom mlm data!
	$table_name = $wpdb->prefix . 'imlm_distributors';
	$data = array(
		'timestamp' => time(),
		'wp_user_id' => $current_user->id,
		'needs_assignment' => 1,
		'imlm_distributor_id' => $login_name,
		'imlm_upline_distributor_id' => $_POST['upline_username'],
		'imlm_enroller_distributor_id' => $_POST['enroller_username'],
	);
	$wpdb->insert(
		$table_name,
		$data
	);
	
}
add_action('woocommerce_checkout_create_order', 'imlm_frontend_create_distributor', 10, 2);

















// =========================
//
//
//
//
//
//
//
//
// PRINT CERTIFICATES
//
//
//
//
//
//
//
//
// =========================

/**
 * Generate and Zip PDF Certificates using TCPDF.
 */
function generate_and_zip_certificates($certificate_ids) {
	
	global $wpdb;
	$demo = false;
	
    // Load TCPDF library
    require_once( ABSPATH . '/wp-content/plugins/investus-binary-mlm/vendor/tcpdf/tcpdf.php');

    // Create a temporary directory to store generated certificates
    $temp_dir = sys_get_temp_dir() . '/certificates';
    if (!is_dir($temp_dir)) {
        mkdir($temp_dir);
    }
	
	// Create a new TCPDF object
	$pdf = new TCPDF('P', 'mm', 'Letter', true, 'UTF-8', false);
	
    // Generate and save individual PDF certificates
    foreach ($certificate_ids as $certificate_id) {
		
		
		
		// Prepare Certificate
		// ------------------------
		$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_certificates WHERE id ='".$certificate_id."'", );
		$certificate = $wpdb->get_row($query);
		$certificate_coin_type_short = "";
		
		if($certificate->coin_type == "bitcoin"){
			$certificate_coin_type_short = "btc";
		}
		if($certificate->coin_type == "litecoin"){
			$certificate_coin_type_short = "ltc";
		}
		if($certificate->coin_type == "ethereum"){
			$certificate_coin_type_short = "eth";
		}
		
		
		// Batch Process Detection
		// ------------------------
		$batch_imlm_distributor_id = get_option('batch_imlm_distributor_id'); // Need to store this somewhere...
		$batch_change = false;
		
		// If this is not set, make it current
		if($batch_imlm_distributor_id == ""){
			
			update_option('batch_imlm_distributor_id', $certificate->imlm_distributor_id);
			$batch_imlm_distributor_id = $certificate->imlm_distributor_id;
			$batch_change = true;
			
		}
		
		// If certificate owner is different from this batch its time for a new shipping label
		if($batch_imlm_distributor_id != $certificate->imlm_distributor_id ){
			
			update_option('batch_imlm_distributor_id', $certificate->imlm_distributor_id);
			$batch_imlm_distributor_id = $certificate->imlm_distributor_id;
			$batch_change = true;
			
		}
		
		
		
		
		
		
		echo "<p>- Generating PDF for certificate_id: ". $certificate_id. "</p>";
		
		// // Set default header and footer data
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set margins
		$pdf->SetMargins(0, 0, 0);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);
		$pdf->SetAutoPageBreak(TRUE, 0);
		
		
		
		
		$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id ='".$batch_imlm_distributor_id."'", );
		$imlm_distributor = $wpdb->get_row($query);
		
		// Print Label
		// ------------
		if($batch_change == true){	
			
			// Add a new page
			$pdf->AddPage();
			
			// Fetch Distributor
			$query = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."imlm_distributors WHERE imlm_distributor_id ='".$batch_imlm_distributor_id."'", );
			$imlm_distributor = $wpdb->get_row($query);
			
			// Fetch Shipping Info
			$first_name = get_user_meta($imlm_distributor->wp_user_id, 'first_name', true);
			$last_name = get_user_meta($imlm_distributor->wp_user_id, 'last_name', true);
			$shipping_address = get_user_meta($imlm_distributor->wp_user_id, 'shipping_address_1', true);
			$shipping_city = get_user_meta($imlm_distributor->wp_user_id, 'shipping_city', true);
			$shipping_state = get_user_meta($imlm_distributor->wp_user_id, 'shipping_state', true);
			$shipping_postcode = get_user_meta($imlm_distributor->wp_user_id, 'shipping_postcode', true);
			$shipping_country = get_user_meta($imlm_distributor->wp_user_id, 'shipping_country', true);

			// Shipping Label
			// --------------
			$pdf->SetFont('helvetica', '', 10);
			
			$pdf->SetXY(0,0);
			$pdf->Cell(0, 100, $first_name." ".$last_name, 0, 1, 'L');
			
			$pdf->SetXY(0,5);
			$pdf->Cell(0, 100, $shipping_address, 0, 1, 'L');
			
			$pdf->SetXY(0,10);
			$pdf->Cell(0, 100, $shipping_city.", ".$shipping_state, 0, 1, 'L');
			
			$pdf->SetXY(0,15);
			$pdf->Cell(0, 100, $shipping_postcode, 0, 1, 'L');
			
			$pdf->SetXY(0,20);
			$pdf->Cell(0, 100, $shipping_country, 0, 1, 'L');
		}
		
		
		
		
		
		
		
        // Add a new page
        $pdf->AddPage();
		// set image scale factor
		//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // BACKGROUND
		// --------------
        $background_image = ABSPATH . '/wp-content/plugins/investus-binary-mlm/certificate_assets/certificate_blank_v7.jpg';
        $pdf->Image(
			$background_image,
			0, 
			0, 
			216, 
			284
		); 

		
		// CERTIFICATE ID
		// --------------
		$pdf->SetXY(
			27, 
			3,
		);
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->Cell(0, 10, $certificate->certificate_number, 0, 1, 'L');
		
		// COIN TYPE TITLE
		// --------------
		$pdf->SetXY(
			18, 
			18,
		);
		$pdf->SetFont('helvetica', 'B', 42);
        $pdf->Cell(0, 10, ucfirst($certificate->coin_type), 0, 1, 'L');
		
		// "CERTIFICATE"
		// --------------
		$pdf->SetXY(
			18, 
			18,
		);
		$pdf->SetFont('helvetica', 'B', 42);
        $pdf->Cell(0, 44, 'Certificate', 0, 1, 'L');
		
		
		// COIN LOGO
		// --------------
        $coin_image = ABSPATH . '/wp-content/plugins/investus-binary-mlm/certificate_assets/'.$certificate->coin_type.'.png';
        $pdf->Image(
			$coin_image,
			143, 
			5,
			60, 
			60, 
		);
		
		
		// PUBLIC ADDRESS TEXT
		// --------------
		$pdf->SetXY(
			18, 
			65,
		);
		$pdf->SetFont('helvetica', 'B', 8);
		if($demo){
			$pdf->Cell(0, 100, '1BzK87zuqidZn489Wb2oLSktrjKrX7TLKe', 0, 1, 'L');
		}else{
			$pdf->Cell(0, 100, $certificate->address, 0, 1, 'L');
		}
		
		// PUBLIC QR
		// --------------
		  $style = array(
			'border' => false,
			'padding' => 'auto',
			'fgcolor' => array(0, 0, 0),
			'bgcolor' => false
		);
		if($demo){
			$pdf->write2DBarcode(
				"https://investusdigital.com/pricecheck/btc/1BzK87zuqidZn489Wb2oLSktrjKrX7TLKe", 
				'QRCODE,H', 
				151.5,
				80.5,
				50, 
				50,
				$style, 
				'N'
			);
		}else{
			$pdf->write2DBarcode(
				"https://investusdigital.com/pricecheck/".$certificate_coin_type_short."/".$certificate->address, 
				'QRCODE,H', 
				151.5,
				80.5,
				50, 
				50,
				$style, 
				'N'
			);

		}
		
		
		// PRIVATE ADDRESS TEXT
		// --------------
		$pdf->SetXY(
			18, 
			125,
		);
		$pdf->SetFont('helvetica', '', 8);
		
		if($demo){
			$pdf->Cell(0, 100, 'demodemodemodemomdeomdeomdeomdeomdeomdeomdoemdoemo', 0, 1, 'L');
		}else{
			$pdf->Cell(0, 100, imlm_decrypt($certificate->key_encrypted), 0, 1, 'L');
		}
        
		
		// PRIVATE QR
		// --------------
		  $style = array(
			'border' => false,
			'padding' => 'auto',
			'fgcolor' => array(0, 0, 0),
			'bgcolor' => false
		);

		if($demo){
				
			$pdf->write2DBarcode(
				"demodemodemodemomdeomdeomdeomdeomdeomdeomdoemdoemo", 
				'QRCODE,H', 
				151.5, 
				140, 
				50, 
				50, 
				$style, 
				'N'
			);
			
		}else{
			
			$pdf->write2DBarcode(
				imlm_decrypt($certificate->key_encrypted), 
				'QRCODE,H', 
				151.5, 
				140, 
				50, 
				50, 
				$style, 
				'N'
			);

		}
		
		
		// COIN AMOUNT
		// --------------
		$pdf->SetXY(
			15, 
			70,
		);
		$pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 44, $certificate->coin_amount.' '.strtoupper($certificate_coin_type_short), 0, 1, 'L');
		
		
		// PURCHASE DATE
		// --------------
		$pdf->SetXY(
			18, 
			78,
		);
		$pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 100, 'Purchase Date: ' .$certificate->issue_date, 0, 1, 'L');
		
		// MARKET VALUE CAD
		// --------------
		$pdf->SetXY(
			18, 
			83,
		);
		$pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 100, 'Coin Market Value At Issue (CAD): $'.$certificate->coin_market_value_cad_at_issue, 0, 1, 'L');
		
		// PURCHASE VALUE CAD
		// --------------
		$pdf->SetXY(
			18, 
			88,
		);
		$pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 100, 'Certificate Value At Issue (CAD): $'.$certificate->certificate_value_cad_at_issue, 0, 1, 'L');
		
		// PURCHASE VALUE CAD
		// --------------
		$first_name = get_user_meta($imlm_distributor->wp_user_id, 'first_name', true);
		$last_name = get_user_meta($imlm_distributor->wp_user_id, 'last_name', true);
			
		$pdf->SetXY(
			18, 
			93,
		);
		$pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 100, 'Originally Issued To: '.$first_name.' '.$last_name, 0, 1, 'L');
		
		
		
		// UPDATE
		// ----------
		$table_name = $wpdb->prefix . 'imlm_certificates';
		$data = array(
			'status' => 'coins_pending',
		);
		$where = array(
			'id' => $certificate_id, 
		);
		$result = $wpdb->update( $table_name, $data, $where );

    }
	
	
	
	// CREATE DONWLOAD
	// ---------------
	
	// Set the PDF filename
	$filename = $temp_dir . '/certificate_'.$certificate_id.'.pdf';

	// Save the PDF certificate to disk
	$pdf->Output($filename, 'F');

    // Create a unique filename for the ZIP file
    $zip_filename = '_manifest.zip';

    // Create a new ZIP archive
    $zip = new ZipArchive();
    if ($zip->open($zip_filename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        // Add all PDF certificates to the ZIP archive
        $certificate_files = glob($temp_dir . '/*.pdf');
        foreach ($certificate_files as $certificate_file) {
            $zip->addFile($certificate_file, basename($certificate_file));
        }

        // Close the ZIP archive
		$zip->setPassword('grandELECTperfectSUBLIME878787878787878');    
        $zip->close();

        // Remove the temporary certificate directory
        array_map('unlink', glob($temp_dir . '/*.pdf'));
        rmdir($temp_dir);

        // Provide a download link for the ZIP file
        echo '<p><a href="' . $zip_filename . '">Download Certificates</a></p>';
		
    } else {
        echo 'Failed to create ZIP archive.';
    }
}




