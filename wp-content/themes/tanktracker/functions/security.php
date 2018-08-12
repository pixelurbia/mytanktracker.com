<?php

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
        if (  ($name == 'user-login') OR ($name == 'register') OR ($name == 'profile') OR ($name == 'overview') OR ($name == 'stock') ) {
        //do nothing
         } else {
             wp_safe_redirect( '/user-login/',301 ); 
        }

    }
   




};
