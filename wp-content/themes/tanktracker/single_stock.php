<?php
/*
Template Name: singlestock
*/
// header('Content-Type: text/xml');
?>

<?php get_template_part('templates/header'); ?>

<?php
//get browser values 
$stock_id = $_GET['stock_id'];
$tank_id = $_GET['tank_id'];

//init Objects
$feed = new Feed();
$stock = new Stock();
$user_tanks = new Tanks();

$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;   
$user = $user_tanks->user_info();

$single_stock = $stock->single_stock($stock_id);

?>

<div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>

<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
    <div class="tank_header">
        <h2><?php echo  $single_stock[0]->stock_name.' the '. $single_stock[0]->stock_species?> </h2>

            <p>
            <?php

                  if ($single_stock[0]->stock_name){
                    echo '<span>Name:'.$single_stock[0]->stock_name.'</span>';
                  }
                  if ($single_stock[0]->stock_species){
                    echo '<span>Species: '.$single_stock[0]->stock_species.'</span></li>';
                  }
                  if ($single_stock[0]->stock_age){
                    echo '<span>Age: '.$single_stock[0]->stock_age.'</span></li>';
                  }
                  if ($single_stock[0]->stock_health){
                    echo ' <span>Status: '.$single_stock[0]->stock_health.'</span></li>';
                  }
                  if ($single_stock[0]->stock_sex){
                    echo '<span>Sex: '.$single_stock[0]->stock_sex.'</span></li>';
                  }
                  if ($single_stock[0]->stock_count){
                    echo '<span>Count: '.$single_stock[0]->stock_count.'</span></li>';
                  }
            ?> 
        </p>
              <!-- <form id="photo-form" method="post">
        <input type="hidden" name="action" value="add_user_photo">
        <?php echo '<input type="hidden" name="ref_id" value="'.$stock_id.'">' ?>
        <?php echo '<input type="hidden" name="user_id" value="'.$user.'">' ?>
        <?php wp_nonce_field('ajax_form_nonce_photo','ajax_form_nonce_photo', true, true ); ?>
            <a class="option-btn add-photo-btn" >
                <label class="tank-img" for="photo-img">
                    <i class="fas fa-images"></i>       
                    <i class="text">Add Image</i>
                </label>
         
                <input type="file" name="file_upload" id="photo-img" class="inputfile hide" accept="image/*" />
            </a>
   </form>      -->
    </div>

<section class="third" id="feed">
    <?php 
        $stock->the_stock_gallery($stock_id,6); 
        $params = new Parameters();
        $params->most_recent_param_list($tank_id);
    ?>
    
</section>
<section class="feed half" id="feed">
    
    <?php 
    $feed->get_tank_stock_feed($stock_id); 
    ?>
</section>




</section>





<?php  get_template_part('templates/footer'); ?>
            