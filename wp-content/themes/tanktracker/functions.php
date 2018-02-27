<?php

require_once('functions/theme.php');
require_once('functions/script.php');
require_once('functions/menu.php');
require_once('functions/widget.php');
require_once('functions/taxonomies.php');
require_once('functions/post-types.php');


add_filter('show_admin_bar', '__return_false');
add_action("wp_ajax_param_form", "tank_params");

//use this version for if you want the callback to work for users who are not logged in
add_action("wp_ajax_nopriv_param_form", "tank_params");

function tank_params() {

if( !isset( $_POST['ajax_form_nonce'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce'], 'ajax_form_nonce' ) )
    die( 'Ooops, something went wrong, please try again later.' );

  global $wpdb;
  global $post;
  $tank_id = $_REQUEST['tank_id'];
  $user_id = $_REQUEST['user_id'];
  $value = $_REQUEST['value'];
  $type = $_REQUEST['type'];

  $wpdb->insert('user_tank_params',array(
  'tank_id'=> $tank_id,
  'user_id'=> $user_id,
  'param_value'=> $value,
  'param_type'=> $type,
  'created_date'=> date("Y-m-d H:i:s")


)
    );

}


add_action('wp_ajax_register_user', 'new_user');
add_action('wp_ajax_nopriv_register_user', 'new_user');

/**
 * New User registration
 *
 */
function new_user() {
 
  // Verify nonce
 if( !isset( $_POST['ajax_form_nonce'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce'], 'ajax_form_nonce' ) )
    die( 'Ooops, something went wrong, please try again later.' );

  // Post values
    $username = $_REQUEST['username'];
    $password = $_REQUEST['pass'];
    $email    = $_REQUEST['email'];
 
    /**
     * IMPORTANT: You should make server side validation here!
     *
     */
 
    $userdata = array(
        'user_login' => $username,
        'user_pass'  => $password,
        'user_email' => $email,
    );
 
    $user_id = wp_insert_user( $userdata ) ;
 
    // Return
    if( !is_wp_error($user_id) ) {
        wp_set_current_user( $user_id, $username );
        wp_set_auth_cookie( $user_id );
        do_action( 'wp_login', $username );
    } else {
        echo $user_id->get_error_message();
    }
echo 'redi';
 
// die();
 
}



// add_action('wp_ajax_add_tank', 'add_user_tank');
// add_action('wp_ajax_nopriv_add_tank', 'add_user_tank');

// /**
//  * Add Tank
//  *
//  */

// function add_user_tank( $file = array() ) {    

//  require_once( ABSPATH . 'wp-admin/includes/admin.php' );
// 	  // Verify nonce
//  if( !isset( $_POST['ajax_form_nonce'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce'], 'ajax_form_nonce' ) )
//     die( 'Ooops, something went wrong, please try again later.' );


//     $file_return = wp_handle_upload( $file, array('test_form' => false ) );
//     if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
//         return false;
//     } else {
//         $filename = $file_return['file'];
//         $attachment = array(
//             'post_mime_type' => $file_return['type'],
//             'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
//             'post_content' => '',
//             'post_status' => 'inherit',
//             'guid' => $file_return['url']
//         );
//         $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
//         require_once(ABSPATH . 'wp-admin/includes/image.php');
//         $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
//         wp_update_attachment_metadata( $attachment_id, $attachment_data );
//         if( 0 < intval( $attachment_id ) ) {
//           return $attachment_id;
//         }
//     }
//     return false;
// }
 





