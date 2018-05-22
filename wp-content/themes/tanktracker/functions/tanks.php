<?php


class Tanks {

	function user_info() {
	 	
	 	$current_user = wp_get_current_user();
		$user = $current_user->ID;
		return $user;
	 }

	function first_tank() {
		global $wpdb;

		$user = $this->user_info();

		$tank_id = $wpdb->get_var("SELECT tank_id FROM user_tanks WHERE user_id = $user ORDER BY created_date limit 1 ");

		return $tank_id;
	}

	function get_tank_data($tank_id) {
	
		if( !isset($tank_id)){
       		 $tank_id = $this->first_tank();
    	} else {
        	$tank_id = $_GET['tank_id'];
		}

		$user = $this-> user_info();

		global $wpdb;			
		$tank = $wpdb->get_results("SELECT * FROM user_tanks WHERE user_id = $user AND tank_id = '$tank_id'");
		
		// echo $tank_id;
		// echo $user;
		return $tank;
	}


	function list_of_tanks() {
	
		$user = $this->user_info();

		global $wpdb;			
		$tanks = $wpdb->get_results("SELECT tank_id,tank_name FROM user_tanks WHERE user_id = $user");
		
		return $tanks;
	}


}




