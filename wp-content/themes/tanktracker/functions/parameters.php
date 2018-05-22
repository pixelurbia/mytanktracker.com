<?php



class Parameters {

	function user_info() {
	 	
	 	$current_user = wp_get_current_user();
		$user = $current_user->ID;
		return $user;
	 }


	function get_params($param_type,$user,$tank_id,$limit) {
		
		   global $wpdb;
           $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.id, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $user
            AND tank_id = '$tank_id'
            AND user_tank_params.param_type = $param_type
            ORDER BY user_tank_params.created_date DESC
            LIMIT $limit");
       
			return $params; 

     	}

     function get_param_types_list($tank_id) {
		 $user = $this->user_info();
     	 
     	 global $wpdb;
     	 $get_param_types_list = $wpdb->get_results("SELECT DISTINCT param_type FROM user_tank_params WHERE user_id = $user AND tank_id = '$tank_id'");

     	 return $get_param_types_list;
     }	
	
	//returns a list of the most recent paramaters tracked for each param type
	function most_recent_param_list($tank_id) {
		$user = $this->user_info();
	
		global $wpdb;
		$params_reported = $wpdb->get_results("SELECT DISTINCT param_type FROM user_tank_params WHERE user_id = $user AND tank_id = '$tank_id'");

		echo '<table>';
		echo '<tr>';
		echo '<th>Parameter</th>';
		echo '<th>Value</th>';
		echo '<th>Date Logged</th>';
		echo '</tr>';
			foreach($params_reported as $param_type){
				$param_type = $param_type->param_type;
				$params = $this->get_params($param_type,$user,$tank_id,1);

				 foreach($params as $param){
                        echo '<tr>';
                            echo '<td>'.$param->param_name.'</td>';
                            echo '<td>'.$param->param_value.'</td>';
                            echo '<td>'.$param->created_date.'</td>';

                        echo '</tr>';
                     }
			}                    
		echo '</table>';
		echo '</div>'; 


	}


	function get_params_order_by_created_date($param_type,$tank_id){
		$user = $this->user_info();
		global $wpdb;
		
		if( isset( $param_type)){
       		$param_type = 'AND user_tank_params.param_type = $param_type';
    	} 
         
        $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $user 
            AND tank_id = '$tank_id'
            $param_type
            ORDER BY user_tank_params.created_date ASC
            $limit
            ");

        return $params;
	}

}




