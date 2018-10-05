<?php



class Activities {

	function user_info() {
	 	
	 	$current_user = wp_get_current_user();
		$user = $current_user->ID;
		return $user;
	 }

	function get_params($param_type,$tank_id,$limit) {
		
		   global $wpdb;
           $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.id, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE tank_id = '$tank_id'
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

		global $wpdb;
		$params_reported = $wpdb->get_results("SELECT DISTINCT param_type FROM user_tank_params WHERE tank_id = '$tank_id'");

		echo '<table>';
		echo '<tr>';
		echo '<th>Parameter</th>';
		echo '<th>Value</th>';
		echo '<th>Date Logged</th>';
		echo '</tr>';
			foreach($params_reported as $param_type){
				$param_type = $param_type->param_type;
				$params = $this->get_params($param_type,$tank_id,1);

				 foreach($params as $param){
				 	$pdate = strtotime($param->created_date);
             $pdate = date('m-d-Y',$pdate);

                        echo '<tr>';
                            echo '<td>'.$param->param_name.'</td>';
                            echo '<td>'.$param->param_value.'</td>';
                            echo '<td>'.$pdate.'</td>';

                        echo '</tr>';
                     }
			}                    
		echo '</table>';
		echo '</div>'; 


	}


	function get_activities_order_by_created_date($tank_id,$date_start,$date_end){
		$user = $this->user_info();
		global $wpdb;
        $activities = $wpdb->get_results("SELECT * FROM user_tank_activities
            WHERE created_date BETWEEN '$date_start' AND '$date_end'
            AND tank_id = '$tank_id'
            ORDER BY created_date DESC
            ");

        return $activities;
	}

}





//new activity
add_action("wp_ajax_save_tank_activity", "save_tank_activity");
add_action("wp_ajax_nopriv_save_tank_activity", "save_tank_activity");

function save_tank_activity() {

if( !isset( $_POST['ajax_form_nonce_save_activity'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_save_activity'], 'ajax_form_nonce_save_activity' ) )
    die( 'Ooops, something went wrong, please try again later.' );

    //  function var_error_log( $object=null ){
    //     ob_start();                    // start buffer capture
    //    var_dump( $object );           // dump the values
    //     $contents = ob_get_contents(); // put the buffer into a variable
    //     ob_end_clean();                // end capture
    //     error_log( $contents );        // log contents of the result of var_dump( $object )
    // }


  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  $user_id = $user->ID;

  $newActivity = $_REQUEST['newActivity'];
  $editedActivity = $_REQUEST['editedActivity'];


    foreach ($newActivity as $activity) {
  	
  	$obj_type = 'activity';

  	for ($i = -1; $i <= 4; $i++) {
		$bytes = openssl_random_pseudo_bytes($i, $cstrong);
		$hex   = bin2hex($bytes);
	}

	$hex = $obj_type .'-'. $hex;

		$wpdb->insert('user_tank_activities',array(
  		'tank_id'=> $activity['tank_id'],
  		'user_id'=> $user_id,
  		'product'=> $activity['product'],
  		'activity_type'=> $activity['activity_type'],
  		'activity_id'=> $hex,
  		'quantity'=> $activity['quantity'],
  		'created_date'=> date("Y-m-d H:i:s")
		
		)
    );

  }

  foreach ($editedActivity as $activity) {

  	$wpdb->update('user_tank_params',array(
  			'param_value'=> $param['value']
		), array(
			'param_id'=> $param['param_id'],
  			'tank_id'=> $param['tank_id']
		)
    );

  }
  
  // $value = $_REQUEST['value'];
  // $param_id = $_REQUEST['param_id'];




}

// delete activity
add_action("wp_ajax_del_tank_activity", "del_tank_activity");
add_action("wp_ajax_nopriv_del_tank_activity", "del_tank_activity");

function del_tank_activity() {

if( !isset( $_POST['ajax_form_nonce_del_act'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_del_act'], 'ajax_form_nonce_del_act' ) )
    die( 'Ooops, something went wrong, please try again later.' );

  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  $user_id = $user->ID;
  $tank_id = $_REQUEST['tank_id'];
  $activity_id = $_REQUEST['activity_id'];

  $wpdb->delete('user_tank_activities',array(
  'tank_id'=> $tank_id,
  'user_id'=> $user_id,
  'activity_id'=> $activity_id,
)
    );

}

