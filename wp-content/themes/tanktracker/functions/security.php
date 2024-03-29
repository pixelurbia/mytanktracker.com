<?php

class Security {
    
    function user_info() {
        $current_user = wp_get_current_user();
        $user = $current_user->ID;
        return $user;
     }

     function limit_posting() {
        global $wpdb;
        $user = $this->user_info();
        $last_post_datetime = $wpdb->get_results("SELECT post_date FROM tt_posts WHERE post_author = $user ORDER BY post_date DESC limit 1");

        $date = $last_post_datetime[0]->post_date;

        if(strtotime($date) + 60 < time()) {
                return 'yes';
             } else {
                return 'no';
             }

             }
       

       
}

    add_action('init', 'secure_my_tank');

    //function to prevent users from interacting with other users data
    function secure_my_tank(){
        global $wpdb;

        $tank_id = $_GET['tank_id'];
        $current_user = wp_get_current_user();
        $user = $current_user->ID;
        $site = $_SERVER['HTTP_HOST'];
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

        $my_tank = $wpdb->get_var("
            SELECT COUNT(tank_id) 
            FROM user_tanks 
            WHERE user_id = $user 
            AND tank_id = '$tank_id'
            ");
//check if ajax first or not or if there is no tank id so no looping happens
    if (!$_GET['tank_id'] || wp_doing_ajax() ){
        return;
    } else {
        //if not
        //page validation because not all pages need to have this security element only those with user controls
        $page = $uri_parts[0];
        $okay_pages = array('/stock/','/gallery/','/gallery','/overview/','/livestock','/livestock/','/profile/','/wp-admin/','/wp-content/','/user-login/','/pass-reset/','/report-a-bug/');

        if (!in_array($page, $okay_pages)) {
            // return $my_tank;
            if ($my_tank == 0){
    
                $tank_id = $wpdb->get_var("SELECT tank_id FROM user_tanks WHERE user_id = $user ORDER BY created_date limit 1 ");
                header("Location: http://".$site.$uri_parts[0]."?tank_id=".$tank_id."");
                die();
            
            } 
        } else {
            return;    
            }//end redirect
            
            }//end okay pages
        }//end ajax call



    //function to prevent users from interacting with other users data
    function this_my_tank(){
        global $wpdb;

        $tank_id = $_GET['tank_id'];
        $current_user = wp_get_current_user();
        $user = $current_user->ID;
        $site = $_SERVER['HTTP_HOST'];
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

        $my_tank = $wpdb->get_var("
            SELECT COUNT(tank_id) 
            FROM user_tanks 
            WHERE user_id = $user 
            AND tank_id = '$tank_id'
            ");

            return $my_tank;

        }


function smart_menu() {

    global $post;
    global $wpdb;
    $tank_id = $_GET['tank_id'];

    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    //check if this is the users tank or not because otherwise this aint that smart of a menu
    $my_tank = $wpdb->get_var("SELECT COUNT(tank_id) FROM user_tanks WHERE user_id = $user_id AND tank_id = '$tank_id'");

    $name = $post->post_name;
    if (  ($name == 'user-login') OR ($name == 'register') OR ($name == 'pass-reset') ){
        return; //no need to show on the login/reg pages
    }

    echo '<div class="menu-bar">';
    echo '<div class="main-menu">';
    if ( is_user_logged_in() ) {
            echo '<a class="menu-button"><i class="fas fa-bars"></i></a>';
            echo '<a class="journals-btn"><i class="fas fa-pencil-alt"></i></a>';
            echo '<a href="/donate/">Donate</a>';
            echo '<a href="/sponsors/">Sponsors</a>';
            if ( in_array( 'administrator', (array) $current_user->roles ) || in_array( 'moderator', (array) $current_user->roles ) ) {
                echo '<a href="/mod_tools/">Mod Tools</a>';
            }

            echo '<!-- <a class="menu-button menu-button-open">Menu</a> -->';
            echo '<!-- <a class="menu-button menu-button-close">Close</a> -->';
    
    } else {
        echo '<a href="/user-login">Login</a>';
        echo '<a href="/reigster">Register</a>';
    }
    echo '</div>';
        echo '<div class="secondary_menu">';
            echo '<a name="" href="/tanks" class="">My Tanks</a>';
                if ( !is_page('tanks') && is_user_logged_in() && $my_tank > 0) {
                    echo '<div class="sub_menu">';
                    echo '<a name="tanks" href="/overview?tank_id='.$tank_id.'" class="overview">Overview</a>';
                    echo '<a name="parameters" href="/fullview?tank_id='.$tank_id .'" class="parameters">Parameters</a>';
                    echo '<a name="stock" href="/stock?tank_id='.$tank_id.'" class="stock">Stock</a>';
                    // echo '<a name="equipment" href="/equipment?tank_id='.$tank_id.'" class="equipment">Equipment</a>';
                    echo '</div>';
                }
        if ( is_user_logged_in() ) {
        echo '<a name="" href="/community/" class="">Tank Tracker Community</a>';
        echo '<a name="" href="https://discord.gg/xPtgFuG" class="">Tank Tracker Discord</a>';
        echo '<span></span>';            
        echo '<a href="/profile?user_id='.$user_id.'"  class="">My Profile</a>';
        echo '<a name="myaccount" href="/my-account" class="myaccount">My Account</a>';
        echo '<a href="'.wp_logout_url('$index.php').'">Logout</a>';
        echo '<span></span>'; 
        echo '<div class="support-links">';
        echo '<a href="/support/">Support</a>';
        echo '<a href="/my-tickets/">My Tickets</a>';
        echo '<a href="/bugs-and-features/">Log Feature Request</a>';
        echo '</div>';
        } 
         
    echo '</div>';
    echo '</div>';
    
   
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

//audit logging
function audit_trail($user_id, $action, $ref_id, $description) {

  global $wpdb;
  global $post;

    
$wpdb->insert('audit_log',array(
        'user_id'=> $user_id,
        'action'=>$action,
        'ref_id'=> $ref_id,
        'description'=> $description,
        'date_of_action'=> date("Y-m-d H:i:s")
        ));

}

function login_check() {
        if ( !is_user_logged_in() ){
         die( 'You need to be logged in.' );
      }
}

add_action('wp_ajax_mod_log', 'mod_log');
add_action('wp_ajax_nopriv_mod_log', 'mod_log');

function mod_log() {

    login_check();  

 if( !isset( $_POST['report_ajax_nonce'] ) || !wp_verify_nonce( $_POST['report_ajax_nonce'], 'report_ajax_nonce' ) )
    die( 'Ooops, something went wrong, please try again later.' );
   

  global $wpdb;
  global $post;

  // reporting_user_id
  // ref_id
  // author_id
  // mod_notes
  // date_reported
  // mod_approved
  // mod_id

    $reporting_user_id = $_REQUEST['reporting_user_id'];
    $ref_id = $_REQUEST['ref_id'];
    $author_id = $_REQUEST['author_id'];
    $content_type = $_REQUEST['content_type'];
    
    $obj_type_new = 'report';
        $hex = uni_key_gen($obj_type_new);
    
$wpdb->insert('mod_log',array(
        'report_id' => $hex,
        'reporting_user_id' => $reporting_user_id,
        'ref_id' => $ref_id,
        'author_id' => $author_id,
        'content_type' => $content_type,
        'mod_approved' => 'no',
        'date_reported'=> date("Y-m-d H:i:s")
        ));

}

add_action('wp_ajax_update_mod_log', 'update_mod_log');
add_action('wp_ajax_nopriv_update_mod_log', 'update_mod_log');

function update_mod_log() {

    login_check();  

 if( !isset( $_POST['ajax_form_mod_log'] ) || !wp_verify_nonce( $_POST['ajax_form_mod_log'], 'ajax_form_mod_log' ) )
    die( 'Ooops, something went wrong, please try again later.' );
   

  global $wpdb;
  global $post;

  // reporting_user_id
  // ref_id
  // author_id
  // mod_notes
  // date_reported
  // mod_approved
  // mod_id

    $report_id = $_REQUEST['report_id'];
    $mod_approval = $_REQUEST['mod_approval'];
    $current_user = wp_get_current_user();
    $user = $current_user->ID;
    


  $wpdb->update('mod_log',array(
    'mod_approved'=> $mod_approval,
    'mod_id'=> $user,
    'last_updated_date'=> date("Y-m-d H:i:s")
    ), array(
        'report_id'=> $report_id)
    );

}


//redicted for those not logged in
// add_action( 'template_redirect', 'redirect_to_specific_page' );
// function redirect_to_specific_page() {

//     global $post;
//     $debug = $_GET['debug'];
//     $name = $post->post_name;
//     $login = is_user_logged_in();

//     if ( $debug == 'on') {
//         echo '<div class="debug-panel">';
//         echo 'Debug mode is on<br>';
//         echo '<br>Page Name: '.$name;
//         echo '<br>is_user_logged_in: '.$login;
//         echo '</div>';
//     }

//   if ( is_user_logged_in() ) {
//         return;
//     }

//     if ( !is_user_logged_in() ) {
//                  //check by postID
//         if (  ($name == 'user-login') OR ($name == 'register') OR ($name == 'profile') OR ($name == 'overview') OR ($name == 'livestock') ) {
//         //do nothing
//          } else {
//              wp_safe_redirect( '/user-login/',301 ); 
//         }

//     }
   


// };



add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
    wp_safe_redirect( '/user-login/',301 ); 
    die();
}



//redicted for those not logged in
add_action( 'template_redirect', 'mod_tools' );
function mod_tools() {

       global $post;
    // $debug = $_GET['debug'];

    $site = $_SERVER['HTTP_HOST'];
    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
    $page = $uri_parts[0];
    $bad_pages = array('/mod_tools/','/mod_tools','mod_tools','/modtoolsque/','/modtoolsque','modtoolsque','/wp-admin/','/wp-admin','/wp-admin/edit.php');


    $user = wp_get_current_user();
    $allowed_roles = array('administrator', 'moderator');

if (in_array($page, $bad_pages)){
    if( !array_intersect($allowed_roles, $user->roles ) ) {  
        wp_safe_redirect( '/tanks/',301 ); 
    } 
}


}


//redicted for those not logged in
add_action( 'template_redirect', 'redirect_to_specific_page' );
function redirect_to_specific_page() {

    global $post;
    // $debug = $_GET['debug'];

    $site = $_SERVER['HTTP_HOST'];
    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
    $page = $uri_parts[0];
    $okay_pages = array('','/pass-reset/','/terms-of-service/','/user-login/','/register/','/profile/','/overview/','/livestock/','/wp-login/','/wp-admin/');
    $login = is_user_logged_in();

    // if ( $debug == 'on') {
    //     echo '<div class="debug-panel">';
    //     echo 'Debug mode is on<br>';
    //     echo '<br>Page Name: '.$page;
    //     echo '<br>is_user_logged_in: '.$login;
    //     echo '</div>';
    // }

  if ( is_user_logged_in() && $page == '/user-login/') {
        wp_safe_redirect( '/tanks/',301 ); 
    } elseif (is_user_logged_in()) {
        return;
    }
    

    if ( !is_user_logged_in() ) {

        if (!in_array($page, $okay_pages)) {
             wp_safe_redirect( '/user-login/',301 ); 
             die();
        } 
    }
   };



function wpse66093_no_admin_access()
{
    if ( !current_user_can( 'administrator' ) && !wp_doing_ajax())
        exit( wp_safe_redirect( '/tanks/',301 )  );
}
add_action( 'admin_init', 'wpse66093_no_admin_access', 100 );


add_action('wp_ajax_update_user_pass', 'send_pass_link');
add_action('wp_ajax_nopriv_update_user_pass', 'send_pass_link');

function send_pass_link() {


 if( !isset( $_POST['ajax_form_nonce'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce'], 'ajax_form_nonce' ) )
    die( 'Ooops, something went wrong, please try again later.' );
   

    global $wpdb;
    global $post;

    $environment = set_env(); 

    if ( $environment == 'DEV') {
        $env ='http://localhost:8888';
    } else {
        $env ='https://mytanktracker.com';
    }
    $email = $_REQUEST['email'];
    $user_id = $wpdb->get_var("SELECT ID FROM tt_users WHERE user_email = '$email'");

    //generate unqiue secure ID
    for ($i = -1; $i <= 35; $i++) {
        $bytes = openssl_random_pseudo_bytes($i, $cstrong);
        $secure_id   = bin2hex($bytes);
    }
  
    $user = get_userdata($user_id);
    $user_name = $user->user_nicename;

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $to = $email;
    $subject = 'Password reset';
    $message = 'Hello '.$user_name.'! <br> Someone, and we hope it was you, requested a password reset for the account: '.$email.' Please click the link below to reset your password. This link will expire in 24 hours.<br><br>
    <a href="'.$env.'/pass-reset/?secure_id='.$secure_id.'">Reset Password</a><br><br>If you did not request this email, you can safely ignore it.';


    $suc = wp_mail( $to, $subject, $message, $headers );


//     $ref_id = $_REQUEST['ref_id'];
//     $author_id = $_REQUEST['author_id'];
//     $content_type = $_REQUEST['content_type'];
    
$wpdb->insert('pass_recovery',array(
        'email' => $email,
        'user_id' => $user_id,
        'secure_id' => $secure_id,
        'date_created'=> date("Y-m-d H:i:s")
        ));

}


add_action('wp_ajax_pass_reset', 'change_pass');
add_action('wp_ajax_nopriv_pass_reset', 'change_pass');

function change_pass() {

 if( !isset( $_POST['ajax_pass_reset_nonce'] ) || !wp_verify_nonce( $_POST['ajax_pass_reset_nonce'], 'ajax_pass_reset_nonce' ) )
    die( 'Ooops, something went wrong, please try again later.' );
   

    global $wpdb;
    global $post;


    $secure_id = $_REQUEST['secure_id'];
    $password = $_REQUEST['pass'];
    $user_id = $wpdb->get_var("SELECT user_id FROM pass_recovery WHERE secure_id = '$secure_id'");

    $user = get_userdata($user_id);
    $user_name = $user->user_nicename;

    wp_set_password( $password, $user_id );

  
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $to = $email;
    $subject = 'Your password has reset';
    $message = 'Hello '.$user_name.'! <br> Your password has been reset. If this is in error please contact support at support@tanktracker.com';


    $suc = wp_mail( $to, $subject, $message, $headers );
    // var_error_log($suc);

    $wpdb->query( "DELETE FROM pass_recovery WHERE secure_id = '$secure_id'");

}




