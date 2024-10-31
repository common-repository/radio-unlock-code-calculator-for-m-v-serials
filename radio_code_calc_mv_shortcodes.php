<?php
    if (!defined('ABSPATH')) exit;
    // Script for handling short codes.

    // Shortcodes available
	add_shortcode("mandv_radiounlock_search",'mandv_radiounlock_search');
	
	function mandv_radiounlock_search($atts) {
		
	wp_enqueue_script( 'rckserialsearchsc', plugin_dir_url( __FILE__ ) . 'assets/js/RadioCodeKingSearch.js', array('jquery'), '1.0' );

	
	$scriptData = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'loadinghtm' => '<h3 style="text-align:center;"> <img src="'.plugin_dir_url( __FILE__ ) . 'assets/images/serial-search.gif'.'" alt="Loading" class="centerloadingimg1" width="246" height="150"><div style="height:20px" aria-hidden="true" class="mot-spacer"></div> </h3>',
    );	
	wp_localize_script('rckserialsearchsc', 'my_options', $scriptData);
		
	$SerialSearchBox = '<div class="RadioCodeKing"><input id="CodeSearchBox" class="CodeSearchBoxT" maxlength="7" name="Serial" placeholder="V109201" type="text" value=""></div>
    <div class="RadioCodeKing"><button class="rck-btn-searchT" onclick="checkthestatus()" id="CalcCode">Calculate Code >></button></div>';	
	
	$SerialSearchBox = '<div id="content123"><h2 class="has-text-align-center">Ford M & V Radio Unlock Code Calculator</h2></div>'. $SerialSearchBox;
	
	if (get_option( 'RCKAccLevel' ) == 'gold'){
	
	if (get_option( 'RCKCreditLink' ) == false){
	$SerialSearchBox = $SerialSearchBox . '<p class="rckcredit"><a href="https://www.radiocodeking.co.uk/" target="_blank">Powered By Radio Code King</a></p>';		
	}else{
	$CreditLink = get_option( 'RCKCreditLink' );
	$SerialSearchBox = $SerialSearchBox . '<p class="rckcredit"><a href="'.$CreditLink.'" target="_blank">Powered By Radio Code King</a></p>';		
	}
	
	}
			
	return $SerialSearchBox;
	}
?>