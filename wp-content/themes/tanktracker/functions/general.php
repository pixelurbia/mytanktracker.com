<?php


class General {


function resizeImageFiles($size,$load,$target) {
  
    $image = new SimpleImage();
    $image->load($load);
    $image->resizeToWidth($size);
    $image->save($target);
    // var_error_log($target_file);
    // return $target_file; //return name of saved file in case you want to store it in you database or show confirmation message to user   
}
}



// define the custom replacement callback
function get_myname() {
		 	$current_user = wp_get_current_user();
		$user = $current_user->ID;
		return $user;
}

// define the action for register yoast_variable replacments
function register_custom_yoast_variables() {
    wpseo_register_var_replacement( '%%myname%%', 'get_myname', 'advanced', 'some help text' );
}

// Add action
add_action('wpseo_register_extra_replacements', 'register_custom_yoast_variables');