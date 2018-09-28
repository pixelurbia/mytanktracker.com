<?php
/*
Template Name: Parameters
*/
?>


<?php get_template_part('templates/header'); 
 $tank_id = $_GET['tank_id'];
$user_tanks = new Tanks();
$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;
$user = $user_tanks->user_info();
     ?>


    <section class="frame"> 
        <?php  
          
        ?>
        <div class="tank_header">
            <h2><?php echo  stripslashes($tank[0]->tank_name) ?></h2>
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
    
<!--         <a class="option-btn track-btn">
            <i class="fas fa-flask"></i> 
            <i class="text">Track</i>
        </a> -->
     <!--     <a class="option-btn">
            <i class="fas fa-download"></i> 
            <i class="text">Export</i>
        </a>   -->
        <a href="<?php echo '/fullview?tank_id='.$tank_id;?>" class="option-btn">
            <i class="fas fa-search"></i>
            <i class="text">Parameter Tracker</i>
        </a>
    </div>
        <?php 

            $cal = new Calendar();
            $cal->days_with_events();
            echo'<br>';
         ?>
    <div class="filters">
        <input type="text" id="datepicker-from" placeholder="Date From">
        <input type="text" id="datepicker-to" placeholder="Date To">
        <a class="option-btn param-filters">
            <i class="fas fa-arrow-right"></i>
        </a> 
    </div>

</section>
<section class="parameter_overview">
    <?php get_template_part('param-que');  ?>
</section>
<div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>        


<?php get_template_part('templates/footer'); ?>
