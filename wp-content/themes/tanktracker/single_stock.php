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
                if ($tanks[0]->tank_volume) {
                    echo  '<span>Volume: '.$tanks[0]->tank_volume.' Gallons </span>';
                } 
                if ($tanks[0]->tank_dimensions){
                    echo '<span>Dimensions: '.$tanks[0]->tank_dimensions.'</span>';
                }
                if ($tanks[0]->tank_model){
                    echo '<span>Model: '.$tanks[0]->tank_model.'</span>';
                }
                if ($tanks[0]->tank_make){
                    echo '<span>Make: '.$tanks[0]->tank_make.'</span>'; 
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
    $feed->get_stock_feed($stock_id); 
    ?>
</section>




</section>

<div class="form-contain add-livestock-form">
        <script type="text/javascript">
        //img preview
        var loadFile = function(event) {
            var output = document.getElementById('Livestock-output');
            output.src = URL.createObjectURL(event.target.files[0]);

           var cropImg  = $('#Livestock-output').croppie({
                viewport: { width: 100, height: 100 },
                boundary: { width: 300, height: 300 },
                showZoomer: false,
                enableOrientation: true
            });
            $('.crop-img').show();
            $('.crop-img').click(function() { 
                cropImg.croppie('result', 'base64').then(function(base64) {

                    // var imgSrc = window.URL.createObjectURL(base64);
                    $('#Livestock-output').attr('src',base64);
                    console.log(base64);
                    cropImg.croppie('destroy');
                    $('.crop-img').hide();
                });
            });
        };
    </script>
    <a class="add-livestock param-close"><i class="fas fa-times"></i></a>
    <form id="livestock-form">
           <fieldset class="step step-one">
            <div class="type-menu">
            <a class="menu-item-contain" value="coral"><div class="menu-item coral"></div></a>
            <a class="menu-item-contain" value="fish"><div class="menu-item fish"></div></a>
            <a class="menu-item-contain" value="plant"><div class="menu-item plant"></div></a>
            <a class="menu-item-contain" value="invert"><div class="menu-item invert"></div></a>
            </div>
                <input type="text" name="stockname"  placeholder="Livestock Name" class="form-control stock-name" />
                <input type="text" name="stockspecies"  placeholder="Livestock species" class="form-control" />
                <input type="hidden" name="stocktype"  class="form-control stocktype" />
                <input type="text" name="sotckage"  placeholder="Livestock age" class="form-control" />
                <input type="text" name="stockhealth"  placeholder="Livestock Health" class="form-control" />
                <input type="text" name="stocksex"  placeholder="Livestock Sex" class="form-control" />
                <!-- <input id="tank-img" type="file" name="file_upload"> -->
                <div class="option-btn stock-next-step">Next Step</div>
                </fieldset>
                <fieldset class="step step-two">
                <div id="crop-img-contain">
                    <img id="Livestock-output">
                </div>
                
                <label class="btn stock-img" for="stock-img">Upload a photo</label>
                <input type="file" name="file_upload" id="stock-img" class="inputfile hide" accept="image/*" onchange="loadFile(event)" />
                <?php wp_nonce_field('ajax_form_nonce_stock','ajax_form_nonce_stock', true, true ); ?>
                
                <input type="hidden" name="action" value="add_livestock">
                <input type="hidden" name="tankid" value="<?php echo $tank_id; ?>">
                <div class="step-actions">
                    <div class="option-btn stock-prev-step">Previous Step</div>
                    <div class="option-btn crop-img">Save Image</div>
                </div>
                <input type="submit" class="btn" value="Add Livestock" />
                </fieldset>
            </form>
</div>




<?php  get_template_part('templates/footer'); ?>
            