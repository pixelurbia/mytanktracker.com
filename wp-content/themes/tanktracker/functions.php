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

add_theme_support( 'post-thumbnails' );


// add_action('wp_head', 'show_template'); 

// function show_template() {  
// global $template;
// print_r($template);
// } 

function get_excerpt($limit, $source = null){

    if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt.'...';
    return $excerpt;
}


add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login
function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}


//setting dev/prod env
function set_env() {
	$env = $_SERVER["HTTP_HOST"];

	if ($env == 'localhost:8888') {
		$environment = 'DEV';
	} else {
		$environment = 'PROD';
	}
return($environment);
}
//redicted for those not logged in
// add_action( 'template_redirect', 'redirect_to_specific_page' );
// function redirect_to_specific_page() {
//     if ( is_page('register') && !is_user_logged_in() ) {

//     } elseif ( !is_page('user-login') && ! is_user_logged_in() ) {
// 	wp_redirect( '/user-login/',301 ); 
//         // exit;
//     }
//     // } elseif { is_user_logged_in() 

//     // }
// };

//smart menu

function smart_menu($tank_id) {
	
    if ( !is_page('tanks') && is_user_logged_in() ) {
		echo '<div class="sub_menu">';
		echo '<a name="tanks" href="/overview?tank_id='.$tank_id.'" class="overview">Overview</a>';
		echo '<a name="parameters" href="/parameters?tank_id='.$tank_id .'" class="parameters">Parameters</a>';
		echo '<a name="stock" href="/stock?tank_id='.$tank_id.'" class="stock">Stock</a>';
		echo '<a name="equipment" href="/equipment?tank_id='.$tank_id.'" class="equipment">Equipment</a>';
		echo '</div>';
    }
};

  // if(!is_user_logged_in()) { 
  //     	 $logged_in = false;
		// } else {
		//  $logged_in = true;
		// 	 } 
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
        die('sucess');
    } else {
       die($user_id->get_error_message()); 
    }

 

 
}

// Populate the uniKeyGen field, by creating or updating the unique key. This keeps our forms grouped together by event_id. 
add_filter('gform_field_value_uniKeyGen', 'uni_key_gen');

function uni_key_gen(){

	$user = wp_get_current_user();
	$user = $user->user_nicename;

	for ($i = -1; $i <= 4; $i++) {
		$bytes = openssl_random_pseudo_bytes($i, $cstrong);
		$hex   = bin2hex($bytes);
	}

	$hex = $user .'-'. $hex;

	return  $hex; 
}



add_action('wp_ajax_add_tank', 'add_user_tank');
add_action('wp_ajax_nopriv_add_tank', 'add_user_tank');

/**
 * Add Tank
 *
 */

function add_user_tank( $file = array() ) {    

 require_once( ABSPATH . 'wp-admin/includes/admin.php' );
	  // Verify nonce
  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  $user_name = $user->display_name;
  $validation = $_REQUEST['verfication-username'];

 if( !isset( $_POST['ajax_form_nonce_tank'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_tank'], 'ajax_form_nonce_tank' ) ){
	} else if( !isset( $validation ) && $validation == $user_name ) 
    die( 'Ooops, something went wrong, please try again later.'.$validation );
   

		$upload_dir = wp_upload_dir();
 		//construct new upload dir from upload base dir and the username of the current user
 		// $sourcePath = $_FILES['file']['tmp_name']; 
 	$environment = set_env(); 
	if ( $environment == 'DEV') {
	   $new_file_dir = '/Users/bear/Documents/tanktracker/wp-content/uploads/user_tanks/';
	} else {
		   $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_tanks/';
	}
     
   
		move_uploaded_file($_FILES["file"]["tmp_name"], $new_file_dir.$_FILES["file"]["name"]);
		$fileurl = $new_file_dir.$_FILES["file"]["name"];
		$filepath = '/wp-content/uploads/user_tanks/'.$_FILES["file"]["name"];
		

  $hex = uni_key_gen();
  
  $user_id = $user->ID;
  $user_id = $user->ID;
  $tank_name = $_REQUEST['tankname'];
  $tank_type = $_REQUEST['tanktype'];
  $tank_volume = $_REQUEST['volume'];
  $tank_dimensions = $_REQUEST['dimensions'];
  $tank_model = $_REQUEST['model'];
  $tank_make = $_REQUEST['make'];
  $tank_image = $filepath;
	

  $wpdb->insert('user_tanks',array(
  'user_id'=> $user_id,
  'tank_id'=> $hex,
  'tank_name'=> $tank_name,
  'tank_type'=> $tank_type,
  'tank_volume'=> $tank_volume,
  'tank_dimensions'=> $tank_dimensions,
  'tank_model'=> $tank_model,
  'tank_make'=> $tank_make,
  'tank_image'=> $tank_image,
  'created_date'=> date("Y-m-d H:i:s")


)
    );


    return false;
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
            AND tank_id = $tank_id
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
}
 

