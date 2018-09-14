<?php



add_filter( 'wp_title', 'custom_titles', 10, 2 );
function custom_titles( $title, $sep ) {
	global $wpdb;

	//get current page
    $site = $_SERVER['HTTP_HOST'];
    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
    $page = $uri_parts[0];
    # $bad_pages = array('/mod_tools/','/mod_tools','mod_tools','/wp-admin/','/wp-admin','/wp-admin/edit.php');


	//get user name from tank ID
	$tank_id = $_GET['tank_id'];
	$user_id = $wpdb->get_var("SELECT user_id FROM user_tanks WHERE tank_id = '$tank_id' limit 1 ");
	$user = get_userdata($user_id);
	$user_name = $user->user_nicename;
    

    //set custom titles per page
	if ($page == '/overview/') {
		$title = ' | '.$user_name."'s tank overview summary";
	} elseif ($page == '/stock/' || $page == '/livestock/' ) {
		$title = ' | '.$user_name."'s tank livestock";
	}
	// } elseif ($page == '/overview/') {
	// } elseif ($page == '/overview/') {
	// } el seif ($page == '/overview/') {
    
    

    return $title;
}