<?php
/*
Template Name: Parameters table
*/
?>


<?php get_template_part('templates/header');      ?>

<?php 
//get vars
$tank_id = $_GET['tank_id'];


//init classes
$user_tanks = new Tanks();


$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;
$user = $user_tanks->user_info();


     

?>
    
    <section class="frame"> 

      <div class="tank_header">
            <h2><?php echo  $tank[0]->tank_name ?></h2>
            <p>
            <?php
                if ($tank[0]->tank_volume) {
                    echo  '<span>Volume: '.stripslashes($tank[0]->tank_volume).' Gallons </span>';
                } 
                if ($tank[0]->tank_dimensions){
                    echo '<span>Dimensions: '.stripslashes($tank[0]->tank_dimensions).'</span>';
                }
                if ($tank[0]->tank_model){
                    echo '<span>Model: '.stripslashes($tank[0]->tank_model).'</span>';
                }
                if ($tank[0]->tank_make){
                    echo '<span>Make: '.stripslashes($tank[0]->tank_make).'</span>'; 
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

         $date_end = date('Y-m-31');
         $date_start = date('Y-m-01');  
        
         ?>
            <div class="filters">
                <input type="text" id="datepicker-from" value="<?php echo  $date_start;?>">
                <input type="text" id="datepicker-to" value="<?php echo  $date_end;?>">
                <a class="option-btn param-table-filters">
                    <i class="fas fa-arrow-right"></i>
                </a> 
            </div>
        </section>
       
    
        <section class="parameter-frame frame">
            <section class="half">
            <h3>Parameters</h2> 
                <div class="table-actions">
                    <a class="add-param-input"><i class="fal fa-plus"></i> Add</a>
                    <a class="edit-param-input"><i class="fal fa-edit"></i> Edit</a>
                    <a class="save-param-input" nonce="<?php echo wp_create_nonce("ajax_form_nonce_save_param"); ?>"><i class="fal fa-save"></i> Save</a>
                </div>
                <div class="params">
                    <?php get_template_part('param-table-que');  ?>
                </div>
        </section><!-- 
        <section class="half">
        <h3>Activities</h2>
            <div class="table-actions">
                <a class="add-activity-input"><i class="fal fa-plus"></i> Add</a>
                <a class="edit-activity-input"><i class="fal fa-edit"></i> Edit</a>
                 <a class="save-activity-input" nonce="<?php echo wp_create_nonce("ajax_form_nonce_save_param"); ?>"><i class="fal fa-save"></i> Save</a>
            </div> -->
<?php 
 //               echo '<div class="full-param">';

 //         echo '<div class="activity-table full">';    
 // echo '<table>';
 //         echo '<tr>';
 //         echo '<th>Activity Type</th>';
 //         echo '<th>Product</th>';
 //         echo '<th>Quantity</th>';
 //         echo '<th>Date Performed</th>';
 //         echo '<th></th>';
 //  echo '</tr>';
 //  echo '<tr id="new-activity-row">';
 //        echo '<td><i class="fal fa-angle-down"></i><select class="activity_type" type="select" name="type">
 //                                <option value="Activity">Activity</option>
 //                                <option name="Water Change" value="1">Water Change</option>
 //                                <option value="Chemical Dose">Chemical Dose</option>
 //                                <option value="Addative">Addative</option>
 //                            </select></td></td>';
 //        echo '<td contenteditable="true"><input class="product" type="text" placeholder="Product"></td>';
 //        echo '<td contenteditable="true"><input class="amount" type="text" placeholder="Amount/Volume"></td>';
 //        echo '<td>--</td>';
 //        echo '<td><a param_id="'.$param->param_id.'" class="input-action del-param-input" tank_id="'.$tank_id.'" nonce="'. wp_create_nonce("ajax_form_nonce_del_param").'"><i class="fal ia-icon fa-times"></a></td>';
    
    
 //  echo '</tr>';
 //    echo '</table>';
 //    echo '</div>';
 //    echo '</div>';

 ?>
        <!-- </section> -->

        </section>
        <script type="text/javascript">
            var inputRow = $("<div />").append($('#input-row').clone()).html();
            var activityRow = $("<div />").append($('#new-activity-row').clone()).html();

        </script>
        <div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>        
<?php get_template_part('templates/footer'); ?>
