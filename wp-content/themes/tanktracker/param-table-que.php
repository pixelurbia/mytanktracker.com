<?php
/*
Template Name: Parameters table que
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

$parameters = new Parameters();
$params = $parameters->get_params_order_by_created_date($param_type,$tank_id,$date_start,$date_end);


                       echo '<div class="full-param">';

         echo '<div class="param-table full" id="table-'.$param->param_type.'">';    
         echo '<table>';
         echo '<tr>';
         echo '<th>Type</th>';
         echo '<th>Value</th>';
         echo '<th>Date Logged</th>';
         echo '<th></th>';
         echo '<th></th>';
         echo '</tr>';    
           echo '<tr id="input-row" class="input-row new-input">';
         echo '<td><select class="param_type" type="select" name="type">
                                <option value="Parameter" >Parameter Selection</option>
                                <option shortname="SG" name="Salinity" value="1">Salinity</option>
                                <option shortname="pH" name="PH" value="2">pH</option>
                                <option shortname="dKH" name="Alkalinity-Dkh" value="3">Alkalinity/Dkh</option>
                                <option shortname="NH3" name="Ammonia" value="4">Ammonia</option>
                                <option shortname="NO2" name="Nitrites" value="5">Nitrites</option>
                                <option shortname="NO3" name="Nitrates" value="6">Nitrates</option>
                                <option shortname="F" name="Tempature" value="7">Tempature</option>
                                <option shortname="Mg" name="Magnisium" value="8">Magnisium</option>
                                <option shortname="Ca" name="Calcium" value="9">Calcium</option>
                                <option shortname="TDS" name="TDS" value="10">TDS</option>
                                <option shortname="Po4" name="Phosphates" value="11">Phosphates</option>
                            </select></td>';
         echo '<td contenteditable="true"><input class="param_value" type="text" placeholder="Enter Value"></td>';
         echo '<td class="date_logged">--</td>';
         echo '<td class="save-btn"><a class="input-action save-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_save_param").'"><i class="fas ia-icon fa-save"></i></a></td>';
                 echo '<td class="edit-btn"><a class="input-action edit-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_save_param").'"><i class="fas ia-icon fa-edit"></i></a></td>';
                  echo '<td class="del-btn"><a class="input-action del-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_del_param").'"><i class="fas ia-icon fa-trash"></i></a></td>';
         echo '<td></td>';
         echo '</tr>';
             foreach($params as $param){
                        echo '<tr>';
                            echo '<td class="param_type">'.$param->param_name.'</td>';
                            echo '<td class="param_value">'.$param->param_value.'</td>';
                            echo '<td class="created_date">'.$param->created_date.'</td>';
                            // echo '<td><a param_id="'.$param->param_id.'" class="input-action save-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_save_param").'"><i class="fas ia-icon fa-save"></i></a></td>';
                            echo '<td class="save-btn hide"><a class="input-action save-param-input" tank_id="'.$tank_id.'" param_id="'.$param->param_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_save_param").'"><i class="fas ia-icon fa-save"></i></a></td>';
                            echo '<td class="edit-btn"><a class="input-action edit-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_edit_param").'"><i class="fas ia-icon fa-edit"></i></a></td>';
                            echo '<td><a param_id="'.$param->param_id.'" class="input-action del-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_del_param").'"><i class="fas ia-icon fa-trash-alt"></a></td>';
                        echo '</tr>';
                     }

        echo '</table>';
        echo '</div>'; 
        echo '</div>'; 

?>            
       