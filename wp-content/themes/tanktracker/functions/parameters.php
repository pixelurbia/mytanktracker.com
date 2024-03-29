<?php



class Parameters {

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


	function get_params_order_by_created_date($param_type,$tank_id,$date_start,$date_end){
		$user = $this->user_info();
		global $wpdb;

		  

         
        $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.param_type, user_tank_params.param_id, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_tank_params.created_date BETWEEN '$date_start' AND '$date_end'
            AND tank_id = '$tank_id'
            ORDER BY user_tank_params.created_date DESC
            ");

        return $params;
	}

}



//new parameter
// add_action("wp_ajax_new_tank_params", "new_tank_params");
// add_action("wp_ajax_nopriv_new_tank_params", "new_tank_params");

// function new_tank_params() {

// if( !isset( $_POST['ajax_form_nonce_save_param'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_save_param'], 'ajax_form_nonce_save_param' ) )
//     die( 'Ooops, something went wrong, please try again later.' );

//   global $wpdb;
//   global $post;
//   $user = wp_get_current_user();
//   $user_id = $user->ID;

//   $tank_id = $_REQUEST['tank_id'];
//   $value = $_REQUEST['value'];
//   $type = $_REQUEST['type'];

//   $obj_type = 'param';

//   	for ($i = -1; $i <= 4; $i++) {
// 		$bytes = openssl_random_pseudo_bytes($i, $cstrong);
// 		$hex   = bin2hex($bytes);
// 	}

// 	$hex = $obj_type .'-'. $hex;

// $wpdb->insert('user_tank_params',array(
//   'tank_id'=> $tank_id,
//   'user_id'=> $user_id,
//   'param_value'=> $value,
//   'param_id'=> $hex,
//   'param_type'=> $type,
//   'created_date'=> date("Y-m-d H:i:s")

// )
//     );
// //return the same value sorted by latest date?? ugh
// echo $hex;
// exit;

// }

//new parameter
add_action("wp_ajax_save_tank_params", "save_tank_params");
add_action("wp_ajax_nopriv_save_tank_params", "save_tank_params");

function save_tank_params() {

if( !isset( $_POST['ajax_form_nonce_save_param'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_save_param'], 'ajax_form_nonce_save_param' ) )
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

  $newParams = $_REQUEST['newParams'];
  $editedParams = $_REQUEST['editedParams'];


    foreach ($newParams as $param) {
  	
  	$obj_type = 'param';

  	for ($i = -1; $i <= 4; $i++) {
		$bytes = openssl_random_pseudo_bytes($i, $cstrong);
		$hex   = bin2hex($bytes);
	}

	$hex = $obj_type .'-'. $hex;

		$wpdb->insert('user_tank_params',array(
  		'tank_id'=> $param['tank_id'],
  		'user_id'=> $user_id,
  		'param_value'=> $param['value'],
  		'param_id'=> $hex,
  		'param_type'=> $param['param_type'],
  		'created_date'=> date("Y-m-d H:i:s")
		
		)
    );

  }

  foreach ($editedParams as $param) {

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

//delete parameter
add_action("wp_ajax_del_tank_params", "del_tank_params");
add_action("wp_ajax_nopriv_del_tank_params", "del_tank_params");

function del_tank_params() {

if( !isset( $_POST['ajax_form_nonce_del_param'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_del_param'], 'ajax_form_nonce_del_param' ) )
    die( 'Ooops, something went wrong, please try again later.' );

  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  $user_id = $user->ID;
  $tank_id = $_REQUEST['tank_id'];
  $param_id = $_REQUEST['param_id'];

  $wpdb->delete('user_tank_params',array(
  'tank_id'=> $tank_id,
  'user_id'=> $user_id,
  'param_id'=> $param_id,
)
    );

}

