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
<div class="mouse-tool-tip"></div>

    <section class="frame"> 
        <?php  
          
        ?>
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
    
        <a class="option-btn track-btn">
            <i class="fas fa-flask"></i> 
            <i class="text">Track</i>
        </a>
     <!--     <a class="option-btn">
            <i class="fas fa-download"></i> 
            <i class="text">Export</i>
        </a>   -->
        <a href="<?php echo '/fullview?tank_id='.$tank_id;?>" class="option-btn">
            <i class="fas fa-search"></i>
            <i class="text">View All Entries</i>
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




<div class="form-contain">
    <a class="track-btn param-close"><i class="fas fa-times"></i></a>
    <form id="ajax-form" class="param-form" method="post">

                            <input type="hidden" name="action" value="param_form">
                            <?php echo '<input type="hidden" name="tank_id" value="'.$tank_id.'">' ?>
                            <?php echo '<input type="hidden" name="user_id" value="'.$user.'">' ?>
                             <?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
                            <input type="text" name="value" placeholder="Value">
                            <select type="select" name="type">
                                <option value="Parameter" >Parameter</option>
                                <option shortname="SG" name="Salinity" value="1">Salinity</option>
                                <option shortname="pH" name="PH" value="2">PH</option>
                                <option shortname="dKH" name="Alkalinity-Dkh" value="3">Alkalinity/Dkh</option>
                                <option shortname="NH3" name="Ammonia" value="4">Ammonia</option>
                                <option shortname="NO2" name="Nitrites" value="5">Nitrites</option>
                                <option shortname="NO3" name="Nitrates" value="6">Nitrates</option>
                                <option shortname="F" name="Tempature" value="7">Tempature</option>
                                <option shortname="Mg" name="Magnisium" value="8">Magnisium</option>
                                <option shortname="Ca" name="Calcium" value="9">Calcium</option>
                                <option shortname="TDS" name="TDS" value="10">TDS</option>
                                <option shortname="Po4" name="Phosphates" value="11">Phosphates</option>
                            </select>
                            <input type="submit" name="submit" value="Log">
    </form>
</div>

<?php get_template_part('templates/footer'); ?>
