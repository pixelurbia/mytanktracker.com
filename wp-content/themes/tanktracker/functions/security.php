<?php

class Security {
    
    function user_info() {
        
        $current_user = wp_get_current_user();
        $user = $current_user->ID;
        return $user;
     }
     
    function reported_posts(){
        global $wpdb;
        $reported_posts = $wpdb->get_results("SELECT * FROM mod_log");
    
            echo '<table>';
            echo '<tr>';
            echo '<th>Reporting User</th>';
            echo '<th>Ref ID</th>';
            echo '<th>Reported User ID</th>';
            echo '<th>Content type</th>';
            echo '<th>Date Reported</th>';
            echo '<th>Mod Approval</th>';
            echo '<th>Mod Approval ID</th>';
            echo '<th>Approve?</th>';
            echo '<th>Reject?</th>';
            echo '</tr>';
                foreach($reported_posts as $report){
                    $post_link = get_post_permalink($report->ref_id);
                    echo '<tr>';
                        echo '<td>'.$report->reporting_user_id.'</td>';
                        echo '<td><a href="'.$post_link.'">'.$report->ref_id.'</a></td>';
                        echo '<td>'.$report->author_id.'</td>';
                        echo '<td>'.$report->content_type.'</td>';
                        echo '<td>'.$report->date_reported.'</td>';
                        echo '<td>'.$report->mod_approved.'</td>';
                        echo '<td>'.$report->mod_id.'</td>';
                        echo '<td>Approve</td>';
                        echo '<td>Reject</td>';
                    echo '</tr>';
                }                    
            echo '</table>';
            echo '</div>'; 
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
        $okay_pages = array('/stock/','/gallery/','/overview/','/livestock','/livestock/','/profile/','/wp-admin/','/wp-content/','/user-login/');

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
    $user = $current_user->ID;

    //check if this is the users tank or not because otherwise this aint that smart of a menu
    $my_tank = $wpdb->get_var("SELECT COUNT(tank_id) FROM user_tanks WHERE user_id = $user AND tank_id = '$tank_id'");

    $name = $post->post_name;
    if (  ($name == 'user-login') OR ($name == 'register') ){
        return; //no need to show on the login/reg pages
    }

    echo '<div class="menu-bar">';
    echo '<div class="main-menu">';
    if ( is_user_logged_in() ) {
            echo '<a class="menu-button"><i class="fas fa-bars"></i></a>';
            echo '<a class="journals-btn"><i class="fas fa-pencil-alt"></i></a>';
            echo '<a target="_blank" href="https://trello.com/b/fYOldyoi">Report Bugs</a>';
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
        echo '<a href="/profile?user_id='.$user.'"  class="">My Profile</a>';
        echo '<a name="myaccount" href="/my-account" class="myaccount">My Account</a>';
        echo '<a href="'.wp_logout_url('$index.php').'">Logout</a>';
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
    
$wpdb->insert('mod_log',array(
        'reporting_user_id' => $reporting_user_id,
        'ref_id' => $ref_id,
        'author_id' => $author_id,
        'content_type' => $content_type,
        'mod_approved' => 'no',
        'date_reported'=> date("Y-m-d H:i:s")
        ));

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
    $bad_pages = array('/mod_tools/','/mod_tools','mod_tools','/wp-admin/','/wp-admin','/wp-admin/edit.php');


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
    $okay_pages = array('','/terms-of-service/','/user-login/','/register/','/profile/','/overview/','/livestock/','/wp-login/','/wp-admin/');
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
    if ( !current_user_can( 'administrator' ) )
        exit( wp_safe_redirect( '/tanks/',301 )  );
}
add_action( 'admin_init', 'wpse66093_no_admin_access', 100 );


