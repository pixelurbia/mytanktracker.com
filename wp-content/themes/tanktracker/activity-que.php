<?php
/*
Template Name: Activity Que
*/
?>

<?php 
//get vars
$tank_id = $_GET['tank_id'];
$date_start = $_GET['date_start'];
$date_end = $_GET['date_end'];


//init classes
$user_tanks = new Tanks();

$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;
$user = $user_tanks->user_info();


if (!isset( $date_start ) && !isset( $date_end )){
  $date_end = date('Y-m-31');
  $date_start = date('Y-m-01');  
}

$activity = new Activities();
$activities = $activity->get_activities_order_by_created_date($tank_id,$date_start,$date_end);



 echo '<div class="full-param">';

         echo '<div class="activity-table full">';    
 echo '<table>';
         echo '<tr>';
         echo '<th>Activity Type</th>';
         echo '<th>Product</th>';
         echo '<th>Quantity</th>';
         echo '<th>Date Performed</th>';
         echo '<th></th>';
  echo '</tr>';
  echo '<tr id="new-activity-row" class="new-activity-row" tank_id="'.$tank_id.'">';
        echo '<td><i class="fal fa-angle-down"></i><select class="activity_type" type="select" name="type">
                                <option value="Activity">Activity</option>
                                <option name="Water Change" value="Water Change">Water Change</option>
                                <option value="Chemical Dose">Chemical Dose</option>
                                <option value="Addative">Addative</option>
                            </select></td></td>';
        echo '<td contenteditable="true"><input class="product" type="text" placeholder="Product"></td>';
        echo '<td contenteditable="true"><input class="quantity" type="text" placeholder="Amount/Volume"></td>';
        echo '<td>--</td>';
        echo '<td><a class="input-action del-activity" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_del_param").'"><i class="fal ia-icon fa-times"></a></td>';
    
    
  echo '</tr>';
  
             foreach($activities as $activity){
            $pdate = strtotime($activity->created_date);
             $pdate = date('m-d-Y',$pdate);

                        echo '<tr class="saved-row" tank_id="'.$tank_id.'" param_id="'.$activity->activity_id.'">';
                            echo '<td class="activity_type">'.$activity->activity_type.'</td>';
                            echo '<td class="product">'.$activity->product.'</td>'; 
                            echo '<td class="product">'.$activity->quantity.'</td>';
                            echo '<td class="created_date">'.$pdate.'</td>';
                            // echo '<td><a param_id="'.$param->param_id.'" class="input-action save-param-input" ><i class="fas ia-icon fa-save"></i></a></td>';
                            // echo '<td class="save-btn hide"><a class="input-action save-param-input" ><i class="fal ia-icon fa-save"></i></a></td>';
                            // echo '<td class="edit-btn"><a class="input-action edit-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_edit_param").'"><i class="fas ia-icon fa-edit"></i></a></td>';
                            echo '<td><a param_id="'.$param->param_id.'" class="input-action del-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_del_param").'"><i class="fal ia-icon fa-times"></a></td>';
                        echo '</tr>';
                     }

        echo '</table>';
        echo '</div>'; 
        echo '</div>'; 

?>            
       