<?php

if (!defined('ABSPATH'))exit;
    /*
    Plugin Name: Radio Unlock Code Calculator For M & V Serials
    Plugin URI:  https://www.radiocodeking.co.uk
    Description: Add a free radio unlock code calculator for serials starting M & V to your website.
    Version:     1.0.0
    Author:      Radio Code King
    Author URI:  https://www.radiocodeking.co.uk/about/
    License:     GPL2

    Radio Code Calculator For M & V: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    any later version.

    Radio Code Calculator For M & V WordPress Plugin is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Radio Code Calculator For M & V. If not, see https://www.gnu.org/licenses/gpl.txt.
    */
    if ( !defined('ABSPATH') ) {
        die("-1");   
    }
    
    require_once('radio_code_calc_mv_shortcodes.php');
    require_once('admin_area.php');
	
	add_action( 'wp_enqueue_scripts', 'radio_calc_m_v_plugin_assets' );
    function radio_calc_m_v_plugin_assets() {
	   wp_enqueue_style( 'radcalcmvplga', plugin_dir_url( __FILE__ ) . 'assets/css/stylex.css' );
    }
	
	
	function rck_lookup_by_ser() {
	$json_return = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://www.radiocodeking.co.uk/FreeAccess/?auth=ACCESSAPIENDPOINT&serial='. $_POST['Serial'] . '&site='. get_option( 'siteurl' ))), true);
	
	//Log Request Locally
	if (isset($_POST['Serial'])){
	$SerialEntered = sanitize_text_field( $_POST['Serial'] );
	$SerialEntered = strtoupper($SerialEntered);
	
	$LogFile = plugin_dir_path(__FILE__) . '/assets/log.txt';
	$LocalLog = date("d M Y") . ' @ ' . date("H:i") . ' - ' . $SerialEntered;
	file_put_contents($LogFile, $LocalLog.PHP_EOL , FILE_APPEND);
	}

	if (!isset($json_return)){
	echo '<h2 class="RCKresult">ERROR</h2>';
	}else{
	// RESULT RETURNED!
	if (isset($json_return["Results"]["Code"])){//check the code is set
	echo '<div="coderescont"><h4>Your Unlock Code</h4><br>';
	echo '<h2 class="RCKresult">'.esc_html($json_return["Results"]["Code"]).'</h2></div>';
	}
	}
	die();	
	}
	
add_action( 'wp_ajax_nopriv_rck_lookup_by_ser', 'rck_lookup_by_ser' );
add_action( 'wp_ajax_rck_lookup_by_ser', 'rck_lookup_by_ser' );	


	//PLUGIN OPTIONS [ ON PLUGIN ACTIVATION ]
	register_activation_hook( __FILE__, 'add_settings_for_rck_f' );
	function add_settings_for_rck_f(){

	if (get_option( 'RCKCreditLink' ) == false){
	$selectone = array("https://www.radiocodeking.co.uk/", "https://www.radiocodeking.co.uk/all-manufacturers/", "https://www.radiocodeking.co.uk/about/", "https://www.radiocodeking.co.uk/free-ford-radio-codes");	
	$kxx = array_rand($selectone);
	$vxx = $selectone[$kxx];
	add_option( 'RCKCreditLink', $vxx );//Set credit us option
	}
	
	if (get_option( 'RCKDisableEndpoint' ) == false){
	add_option( 'RCKDisableEndpoint', 'yes' );//disable endpoint until TOS agreed to
	}

	if (get_option( 'RCKAccLevel' ) == false){
	add_option( 'RCKAccLevel', 'bronze' );//set access level	
	}	
	
	
	}

	
?>