<?php


function smart_menu($tank_id) {

    global $post;
    $current_user = wp_get_current_user();
    $user = $current_user->ID;

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
                if ( !is_page('tanks') && is_user_logged_in() ) {
                    echo '<div class="sub_menu">';
                    echo '<a name="tanks" href="/overview?tank_id='.$tank_id.'" class="overview">Overview</a>';
                    echo '<a name="parameters" href="/parameters?tank_id='.$tank_id .'" class="parameters">Parameters</a>';
                    echo '<a name="stock" href="/stock?tank_id='.$tank_id.'" class="stock">Stock</a>';
                    // echo '<a name="equipment" href="/equipment?tank_id='.$tank_id.'" class="equipment">Equipment</a>';
                    echo '</div>';
                }
        if ( is_user_logged_in() ) {
        echo '<a name="" href="/community" class="">Tank Tracker Community</a>';
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


//redicted for those not logged in
add_action( 'template_redirect', 'redirect_to_specific_page' );
function redirect_to_specific_page() {

    global $post;
    $debug = $_GET['debug'];
    $name = $post->post_name;
    $login = is_user_logged_in();

    if ( $debug == 'on') {
        echo '<div class="debug-panel">';
        echo 'Debug mode is on<br>';
        echo '<br>Page Name: '.$name;
        echo '<br>is_user_logged_in: '.$login;
        echo '</div>';
    }

  if ( is_user_logged_in() ) {
        return;
    }

    if ( !is_user_logged_in() ) {
                 //check by postID
        if (  ($name == 'user-login') OR ($name == 'register') OR ($name == 'profile') OR ($name == 'overview') OR ($name == 'livestock') ) {
        //do nothing
         } else {
             wp_safe_redirect( '/user-login/',301 ); 
        }

    }
   
//smart menu






};
