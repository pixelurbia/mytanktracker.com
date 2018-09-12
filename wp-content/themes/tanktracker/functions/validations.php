<?php

add_action('wp_ajax_validate_regi_form', 'validate_regi_form');
add_action('wp_ajax_nopriv_validate_regi_form', 'validate_regi_form');

function validate_regi_form($attribute) {


	$attribute = $_REQUEST['attribute'];
	$checker = $_REQUEST['checker'];
	$nonce = $_REQUEST['nonce'];

	  // Verify nonce
 if( !isset( $nonce ) || !wp_verify_nonce( $nonce  , 'ajax_form_nonce' ) )
    die( 'Ooops, something went wrong, please try again later.' );

	 global $wpdb;

        $results = $wpdb->get_var("SELECT COUNT($checker) FROM tt_users WHERE $checker = '$attribute'");
  
        // var_dump($results);
        // echo $attribute;
        // echo $results;
        die($results);
}






