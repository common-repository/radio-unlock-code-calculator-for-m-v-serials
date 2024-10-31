<?php

add_action('admin_menu', 'rck_funlock_code');
add_action('admin_head', 'rck_funlock_code_admin_styles');

//admin page style
function rck_funlock_code_admin_styles() {
wp_enqueue_style( 'frdrad_unlock_rck_styles', plugins_url( '/assets/css/admin.css', __FILE__ ) );
}

function rck_funlock_code(){
    add_menu_page( 'Radio Unlock Code Calculator For M & V', 'Radio Unlock Code Calculator For M & V', 'manage_options', 'rck-unlock-code-frd', 'rck_funlock_code_admin', 'dashicons-car');
}
 
function rck_funlock_code_admin(){

if (isset($_GET["first"])){
delete_option( 'RCKDisableEndpoint' );	
}


echo '<h1 class="rck-title">Radio Unlock Code Calculator For Serials Starting M & V</h1><small><i>by RadioCodeKing.co.uk</i></small>';
	
if (get_option( 'RCKDisableEndpoint' ) == 'yes'){
// user must agree to TOS of API access

	$AdminReturnURLAfterSignup = get_admin_url( null, null, null ) . 'admin.php?page=rck-unlock-code-frd&first=yes';


echo '<h3>Thank you installing the plugin, please activate this plugin for 100% free API access instantly below:</h3>';

echo '<div style="height:15px" aria-hidden="true" class="admin-spacer"></div>';

echo '<div class="gen_button_sign"><a class="sign-up-button1" href="https://www.radiocodeking.co.uk/free-api-access/?site=' . get_option( 'siteurl' ) . '&return=' . esc_url($AdminReturnURLAfterSignup) . '" target="_blank"><b>SIGN UP/ACTIVATE FREE NOW!</b></a></div>';
echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="backend-font-heavy">Why Do i Need to Sign Up?</p>';
echo '<p class="backend-font-light">Sign up takes less than 30 seconds and only requires an email address, we require sign up to keep things fair and avoid abuse of the free API service which is called when a user requests a radio unlock code.</p>';
	


}else{
	
// switching API packages
if (isset($_POST['credit'])) {
if ($_POST['credit'] == 'yes'){
$json_api_upgrade_req = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://www.radiocodeking.co.uk/FreeAccess/RequestsChange.php?auth=LeCc0xMsd00fnsMF345o3&package=gold&site=' . '&site=' . get_option( 'siteurl' ))), true);
echo '<div class="notice notice-success is-dismissible">
        <p><strong>ALERT:</strong> You have upgraded to Gold API access - Refresh this page to view gold menu.</strong>
		</p>
    </div>';
delete_option( 'RCKAccLevel' );	
add_option( 'RCKAccLevel', 'gold' );//set access level	

}else{

$json_api_upgrade_req = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://www.radiocodeking.co.uk/FreeAccess/RequestsChange.php?auth=LeCc0xMsd00fnsMF345o3&package=bronze&site=' . '&site=' . get_option( 'siteurl' ))), true);
echo '<div class="notice notice-success is-dismissible">
        <p><strong>ALERT:</strong> You have downgraded to Bronze API access.</strong>
		</p>
    </div>';
delete_option( 'RCKAccLevel' );	
add_option( 'RCKAccLevel', 'bronze' );//set access level		
	
}	
}	
	
	
// API access status check
$json_api_usage = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://www.radiocodeking.co.uk/FreeAccess/Requests.php?auth=LeCc0xMsd00fnsMF345o3&site=' . '&site=' . get_option( 'siteurl' ))), true);
//sync access level with API
if (isset(($json_api_usage["Limit"]))){
if ($json_api_usage["Limit"] == '10'){
delete_option( 'RCKAccLevel' );	
add_option( 'RCKAccLevel', 'bronze' );//set access level	
}
}
if (isset(($json_api_usage["Limit"]))){
if ($json_api_usage["Limit"] == '500'){
delete_option( 'RCKAccLevel' );	
add_option( 'RCKAccLevel', 'gold' );//set access level	
}
}


// activated, admin backend
	echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';


	// how to use plugin area
	echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/question.png"> How To Use This Plugin</p>';	
	echo '<p class="clear-font-text">Simply use the shortcode below to show the ford M & V radio unlock code calculator:</p>';
	echo '<p class="clear-font-text"><strong>[mandv_radiounlock_search]</strong></p>';

echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';

if (get_option( 'RCKAccLevel' ) == 'bronze'){
//bronze api
echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/bronze-star.png"> Daily API Usage</p>';	

	echo '<p class="backend-api-stats">Usage statistics for: <strong>' . get_option( 'siteurl' ) . '</strong></p>';
	echo '<p class="backend-api-stats">API package: <strong>Bronze</strong></p>';		
	echo '<p class="backend-api-stats">Lookups made today: <strong>' . esc_html($json_api_usage["RequestsMade"]) . ' / ' . esc_html($json_api_usage["Limit"]) . '</strong></p>';
	echo '<p class="backend-api-stats">Lookups remaining today: <strong>' . esc_html($json_api_usage["RequestsLeft"]) . '</strong></p>';

//offer gold API upgrade	
echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';

echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/bronze-star.png"> Bronze API Access</p>';
echo '<p class="clear-font-text">You have bronze API access which includes (10 free unlock code lookups a day).</p>';
echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="clear-font-text"><strong>Upgrade to FREE gold access now:</strong></p>';
echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png" height="16" width="16"> <strike>10</strike> 500 free unlock code lookups a day.</p>';
echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png" height="16" width="16"> Priority email support.</p>';
echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png" height="16" width="16"> API status and maintainance alerts.</p>';
echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png" height="16" width="16"> Instant upgrade with no waiting.</p>';
echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png" height="16" width="16"> No payment or further details required.</p>';
echo '<div style="height:10px" aria-hidden="true" class="admin-spacer"></div>';

echo '<form id="creditlink" method="POST" action="">
	<input name="credit" id="credit" type="hidden" value="yes">
    <div class="gen_button_sign"><button type="submit" class="upgrade_fvd_button" id="Reg">UPGRADE TO GOLD API [FREE / INSTANT]</button></div></form>';
	
echo '<p class="backend-font-light">We offer free gold API access to users who show us their support by adding a powered by radio code king link, this link is automatically added under the serial code box when you upgrade.</p>';
echo '<p class="backend-font-light">We have spent many hours making this free and easy to use plugin and would really appreciate your support.</p>';



}else{
// gold api
echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png"> Daily API Usage</p>';

	echo '<p class="backend-api-stats">Usage statistics for: <strong>' . get_option( 'siteurl' ) . '</strong></p>';
	echo '<p class="backend-api-stats">API package: <strong>Gold</strong></p>';		
	echo '<p class="backend-api-stats">Lookups made today: <strong>' . esc_html($json_api_usage["RequestsMade"]) . ' / ' . esc_html($json_api_usage["Limit"]) . '</strong></p>';
	echo '<p class="backend-api-stats">Lookups remaining today: <strong>' . esc_html($json_api_usage["RequestsLeft"]) . '</strong></p>';

//offer bronze downgrade	
echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png"> Gold API Access</p>';
echo '<p class="clear-font-text">You have gold API access which includes:</p>';
echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png" height="16" width="16"> 500 radio unlock code lookups a day.</p>';
echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png" height="16" width="16"> Priority email support.</p>';
echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png" height="16" width="16"> API status and maintainance alerts.</p>';
echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png" height="16" width="16"> Priority email support (enquiries@radiocodeking.co.uk).</p>';
echo '<div style="height:10px" aria-hidden="true" class="admin-spacer"></div>';

echo '<form id="creditlink" method="POST" action="">
	<input name="credit" id="credit" type="hidden" value="no">
    <div class="gen_button_sign"><button type="submit" class="downgrade_fvd_button" id="Reg">DOWNGRADE TO BRONZE</button></div></form>';
echo '<p class="backend-font-light">Please think carefully before downgrading, if you downgrade to bronze you will have a lower daily lookup limit, no downtime warnings or notice and no priority email support.</p>';
echo '<p class="backend-font-light">We really appreciate and need your support; all we ask is you credit us and this is what keeps us working on and improving our free plugins (thanks for your support).</p>';

}


	echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';
	echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/crown.png"> Last 100 Search Log</p>';
	
	//LOG FILE OUTPUT:
	$LogFile = plugin_dir_path(__FILE__) . 'assets/log.txt';
	
	if (file_exists($LogFile)){
	
	$fileforlog = file($LogFile);
	$xlogcount = count($fileforlog);	
	$searchfilesize = file($LogFile, FILE_IGNORE_NEW_LINES);
	$limitsearch = 100;
	
	echo '<textarea id="searchlog" style="width: 450px!important;" class="box" rows="10">';
	//return log file..
	foreach($searchfilesize as $searchfilesize){
	if ($limitsearch <=0){
	}else{
	--$limitsearch;	
	--$xlogcount;
	echo esc_textarea($fileforlog[$xlogcount]);	
	}
	}
	echo '</textarea>';	
	echo '<br>To view all ' . count($fileforlog) . ' search records, <a href="' . plugin_dir_url(__FILE__) . 'assets/log.txt" target="_blank">View the full search log now</a>';
	echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';
	}else{
	echo 'Search log will appear here once first lookup is made!';
	echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';	
	}



echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';

echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/question.png"> How Does This Work?</p>';	
echo '<p class="clear-font-text">Once a user enters the serial and clicks the "Calculate Code" button the radiocodeking service is called and unlock code is returned within seconds.</p>';
	
echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';




}	

}
?>