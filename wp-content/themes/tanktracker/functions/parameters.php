<?php



class Parameters {

	function user_info() {
	 	
	 	$current_user = wp_get_current_user();
		$user = $current_user->ID;
		return $user;
	 }


	function get_params($param_type,$user,$tank_id) {
		

		   global $wpdb;
           $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.id, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $user
            AND tank_id = $tank_id
            AND user_tank_params.param_type = $param_type
            ORDER BY user_tank_params.created_date DESC
            LIMIT 1");
       
                     foreach($params as $param){
                        echo '<tr>';
                            echo '<td>'.$param->param_name.'</td>';
                            echo '<td>'.$param->param_value.'</td>';
                            echo '<td>'.$param->created_date.'</td>';

                        echo '</tr>';
                     }

     	}
	
	function most_recent_param_list($tank_id) {
		$user = $this->user_info();
	
		global $wpdb;
		$params_reported = $wpdb->get_results("SELECT DISTINCT param_type FROM user_tank_params WHERE user_id = $user AND tank_id = $tank_id");
		echo '<div class="param-table large" >';
		echo '<table>';
		echo '<tr>';
		echo '<th>Parameter</th>';
		echo '<th>Value</th>';
		echo '<th>Date Logged</th>';
		echo '</tr>';
			foreach($params_reported as $param_type){
				$param_type = $param_type->param_type;
				$this->get_params($param_type,$user,$tank_id);
			}                    
		echo '</table>';
		echo '</div>'; 
		echo '</div>'; 

	}


}




