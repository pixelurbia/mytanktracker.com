<?php
/*
Template Name: Parameters table
*/
?>


<?php get_template_part('templates/header');      ?>

<?php 

$tank_id = $_GET['tank_id'];
$user_tanks = new Tanks();
$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;
$user = $user_tanks->user_info();
     

?>
    <div class="mouse-tool-tip"></div>
    <section class="frame"> 

      <div class="tank_header">
            <h2><?php echo  $tank[0]->tank_name ?></h2>
            <p>
            <?php
                if ($tank[0]->tank_volume) {
                    echo  '<span>Volume: '.$tank[0]->tank_volume.' Gallons </span>';
                } 
                if ($tank[0]->tank_dimensions){
                    echo '<span>Dimensions: '.$tank[0]->tank_dimensions.'</span>';
                }
                if ($tank[0]->tank_model){
                    echo '<span>Model: '.$tank[0]->tank_model.'</span>';
                }
                if ($tank[0]->tank_make){
                    echo '<span>Make: '.$tank[0]->tank_make.'</span>'; 
                }
            ?> 
            </p>
   <!--  
        <a class="option-btn track-btn" >
            <i class="fas fa-flask"></i> 
            <i class="text">Track</i>
        </a> -->
      <!--   <a class="option-btn">
            <i class="fas fa-cog"></i> 
            <i class="text">Filter</i>
        </a> -->
        <a href="<?php echo '/parameters?tank_id='.$tank_id;?>" class="option-btn">
            <i class="fas fa-search"></i>
            <i class="text">Parameter Breakout</i>
        </a>
         <a class="option-btn" id="export" param_type="<?php echo $param_type; ?>"
                curuser="<?php echo $curuser; ?>" tank_id="<?php echo $tank_id; ?>">
            <i class="fas fa-download"></i> 
            <i class="text" >Export</i>
        </a>
    </div>
 <?php 
        $cal = new Calendar();
        $cal->days_with_events();
        echo'<br>';
        
         ?>
        </section>
       
        <section class="params">
                <?php  
                    $parameters = new Parameters();
                    $params = $parameters->get_params_order_by_created_date($param_type,$tank_id);
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
         echo '<tr id="input-row" class="input-row">';
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
         echo '<td><a class="input-action save-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_save_param").'"><i class="fas ia-icon fa-save"></i></a></td>';
         echo '</tr>';
             foreach($params as $param){
                        echo '<tr>';
                            echo '<td>'.$param->param_name.'</td>';
                            echo '<td>'.$param->param_value.'</td>';
                            echo '<td>'.$param->created_date.'</td>';
                            echo '<td><a param_id="'.$param->param_id.'" class="input-action save-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_save_param").'"><i class="fas ia-icon fa-save"></i></a></td>';
                            echo '<td><a param_id="'.$param->param_id.'" class="input-action del-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_del_param").'"><i class="fas ia-icon fa-trash-alt"></a></td>';
                        echo '</tr>';
                     }

        echo '</table>';
        echo '</div>'; 
        echo '</div>'; 
?>            
        </section>
        <script type="text/javascript">
            var inputRow = $("<div />").append($('#input-row').clone()).html();
        </script>
        <div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>        
<?php get_template_part('templates/footer'); ?>
