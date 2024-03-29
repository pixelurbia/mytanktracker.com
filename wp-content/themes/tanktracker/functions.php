<?php

require_once('functions/calendar.php');
require_once('functions/parameters.php'); //param queries
require_once('functions/validations.php'); //form validating forms
require_once('functions/tanks.php'); //tank queries
require_once('functions/theme.php');
require_once('functions/script.php');
require_once('functions/menu.php');
require_once('functions/widget.php');
require_once('functions/taxonomies.php');
require_once('functions/post-types.php');
require_once('functions/save-journals.php');
require_once('functions/profile.php');
require_once('functions/feed.php');
require_once('functions/stock.php');
require_once('functions/resize.php');
require_once('functions/security.php');
require_once('functions/general.php');
require_once('functions/roles.php');
require_once('functions/seo.php');
require_once('functions/activities.php');

add_theme_support( 'post-thumbnails' );
add_filter('show_admin_bar', '__return_false');

//remove comment form logout stuff
add_filter( 'comment_form_logged_in', '__return_empty_string' );



// add_action('wp_head', 'show_template'); 

// function show_template() {  
// global $template;
// print_r($template);
// } 


function custom_excerpt_length( $length ) {
        return 100;
    }
    add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );




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



 function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
       var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }

  // Post values
    $username = $_REQUEST['username'];
    $password = $_REQUEST['pass'];
    $email    = $_REQUEST['email'];
    $marketing  = $_REQUEST['marketing'];
 
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

    add_user_meta($user_id, 'marketing', $marketing);
 
    // Return
    if( !is_wp_error($user_id) ) {
 


            $ip = $_SERVER['REMOTE_ADDR'];
            $action = 'New User';
            $ref_id = 888;
            $description = 'user_id: '.$user_id.' User IP: '.$ip;
            audit_trail($user_id, $action, $ref_id, $description);

    $user = get_userdata($user_id);
    $user_name = $user->user_nicename;

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $to = $email;
    $subject = 'Welcome to TankTracker!';
    $message = '<br> Hello '.$username.'! <br> Welcome to TankTracker™ and welcome to the #FishFam! <br> We are excited to have you aboard.<br> <br> Regards,<br> The TankTracker™ team';


    $suc = wp_mail( $to, $subject, $message, $headers );


    // var_error_log($message);
    // var_error_log($email);


                   wp_set_current_user( $user_id, $username );
        wp_set_auth_cookie( $user_id );
        do_action( 'wp_login', $username );
        die('sucess');
    } else {
       die($user_id->get_error_message()); 
    }

       
 

   
 
}

// Populate the uniKeyGen field, by creating or updating the unique key. This keeps our forms grouped together by event_id. 
add_filter('gform_field_value_uniKeyGen', 'uni_key_gen');

function uni_key_gen($obj_type){


	for ($i = -1; $i <= 4; $i++) {
		$bytes = openssl_random_pseudo_bytes($i, $cstrong);
		$hex   = bin2hex($bytes);
	}

	$hex = $obj_type .'-'. $hex;

	return  $hex; 
}






add_action('wp_ajax_get_table_data', 'get_table_data');
add_action('wp_ajax_nopriv_get_table_data', 'get_table_data');

/**
 * Sort Table
 *
 */

function get_table_data() {  


  // Sorting
// if(isset($_GET['ordby'])){
//     $ordby = $_GET['ordby'];
// } else {
//     $ordby = 'event_date';
// }
// if(isset($_GET['sortby'])){
//     $a_or_d = $_GET['sortby'];
// } else {
//     $a_or_d = 'ASC';
//     // $a_or_d = 'DESC';
// }


  $tank_id = $_REQUEST['tank_id'];
  $curuser = $_REQUEST['user'];
  $param_type = $_REQUEST['param_type'];

  // echo $tank_id;
  // echo $curuser;
  // echo $param_type;


   global $wpdb;
         // global $date;
        $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.id, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $curuser 
            AND tank_id = '$tank_id'
            AND user_tank_params.param_type = $param_type
            ORDER BY user_tank_params.created_date DESC
            LIMIT 5");
         //AND created_date >= DATE_ADD(CURDATE(), INTERVAL -5 DAY) limit 5
         // var_dump($params);
         $output .= '<table>';
         $output .= '<tr>';
         $output .= '<th>Value</th>';
         $output .= '<th>Date Logged</th>';
         $output .= '</tr>';
         
                     foreach($params as $param){
                        $output .= '<tr>';
                            $output .= '<td>'.$param->param_value.'</td>';
                            $output .= '<td>'.$param->created_date.'</td>';

                        $output .= '</tr>';
                     }


                        // echo $date;

        $output .= '</table>';

	echo $output;
	die();
}
 

/**
 * Add Tank Photo
 *
 */

add_action('wp_ajax_add_user_photo', 'add_user_photo');
add_action('wp_ajax_nopriv_add_user_photo', 'add_user_photo');

function add_user_photo( $file = array() ) {    



if( !isset( $_POST['ajax_form_nonce_photo'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_photo'], 'ajax_form_nonce_photo' ) )
    die( 'Ooops, something went wrong, please try again later.' );

   require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    // Verify nonce
  global $wpdb;
  global $post;

   $upload_dir = wp_upload_dir();
    //construct new upload dir from upload base dir and the username of the current user
    // $sourcePath = $_FILES['file']['tmp_name']; 
  $environment = set_env(); 
  if ( $environment == 'DEV') {
     $new_file_dir = '/Users/bear/Documents/tanktracker/wp-content/uploads/user_tanks/';
  } else {
       $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_tanks/';
  }
     
  $obj_type = 'user-img';
  $hex = uni_key_gen($obj_type);
  $fileName =$hex.'-'.$_FILES["file"]["name"];

   move_uploaded_file($_FILES["file"]["tmp_name"], $new_file_dir.$fileName);
    
    $fileurl = $new_file_dir.$fileName;
    
    $filepath = '/wp-content/uploads/user_tanks/'.$fileName;
    

  $user_id = $_REQUEST['user_id'];
  $ref_id = $_REQUEST['ref_id'];
  $photo_url = $filepath;
  

  $wpdb->insert('user_photos',array(
  'user_id'=> $user_id,
  'photo_id'=> $hex,
  'ref_id'=> $ref_id,
  'photo_url'=> $photo_url,
  'inserted_date'=> date("Y-m-d H:i:s")
)
    );


    // echo 'I must have called a thousand times';
}

  add_action('wp_ajax_un_favorite_post', 'un_favorite_post');
  add_action('wp_ajax_nopriv_un_favorite_post', 'un_favorite_post');

  function un_favorite_post() {

  if( !isset( $_POST['fav_ajax_nonce'] ) || !wp_verify_nonce( $_POST['fav_ajax_nonce'], 'fav_ajax_nonce' ) )
    die( 'Ooops, something went wrong, please try again later.' );

    // Verify nonce
      global $wpdb;
      global $post;
      $obj_type = 'fav_post';
      $user_id = $_REQUEST['user'];
      $ref_id = $_REQUEST['ref_id'];
      
    
      $wpdb->delete('user_post_refs',array(
      'user_id'=> $user_id,
      'ref_key'=> $obj_type,
      'ref_id'=> $ref_id
    ));
      // return 'UGH';
      // die( 'Ooops, something went wrong, please try again later.' );
}

  add_action('wp_ajax_favorite_post', 'favorite_post');
  add_action('wp_ajax_nopriv_favorite_post', 'favorite_post');

  function favorite_post() {

  if( !isset( $_POST['fav_ajax_nonce'] ) || !wp_verify_nonce( $_POST['fav_ajax_nonce'], 'fav_ajax_nonce' ) )
    die( 'Ooops, something went wrong, please try again later.' );

    // Verify nonce
      global $wpdb;
      global $post;
      $obj_type = 'fav_post';
      $user_id = $_REQUEST['user'];
      $ref_id = $_REQUEST['ref_id'];
      
    
      $wpdb->insert('user_post_refs',array(
      'user_id'=> $user_id,
      'ref_key'=> $obj_type,
      'ref_id'=> $ref_id,
      'inserted_date'=> date("Y-m-d H:i:s")
    ));
      // return 'UGH';
      // die( 'Ooops, something went wrong, please try again later.' );
}


//exclude cats
function exclude_post_categories($excl=''){
  $categories = get_the_category($post->ID);
    if(!empty($categories)){
      $exclude=$excl;
      $exclude = explode(",", $exclude);
      $html = '';

  foreach ($categories as $cat) {
    if(!in_array($cat->cat_ID, $exclude)) {
    $html .= '<li cat_id="' . $cat->cat_ID . '">' . $cat->cat_name . '</li>';
  }
  }
echo '<ul class="categories">';
echo $html;
echo '</ul>';
}
}





