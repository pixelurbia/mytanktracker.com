<?php
/*
Template Name: stock
*/
// header('Content-Type: text/xml');
?>

<?php get_template_part('templates/header'); ?>

<?php
//tank object start
$tank_id = $_GET['tank_id'];
$user_tanks = new Tanks();
$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;   
$user = $user_tanks->user_info();
?>

<div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>

<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
    <div class="tank_header">
        <h2><?php echo  $tank[0]->tank_name ?> Livestock</h2>

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
        <p class="page-subnav">
            <a class="current">Fish / </a>
            <a>Coral / </a>
            <a>Plants / </a>
            <a>Inverts</a>
        </p>
     <a class="option-btn add-livestock">
            <i class="fas fa-plus"></i> 
            <i class="text">Add Livestock</i>
        </a>
         
    </div>
        


<section class="stock-list">
    <?php 
    $stock = new Stock(); 
    $stock = $stock->list_of_stock();
    ?>
</section>
</section>

<div class="form-contain add-livestock-form">
        <script type="text/javascript">
        //img preview
        var loadFile = function(event) {
            var output = document.getElementById('Livestock-output');
            output.src = URL.createObjectURL(event.target.files[0]);

            var dkrm = new Darkroom('#Livestock-output', {
            // Canvas initialization size
            minWidth: 100,
            minHeight: 100,
            maxWidth: 500,
            maxHeight: 500,
            
            // Plugins options
            plugins: {
                crop: {
                minHeight: 150,
                minWidth: 150,
                ratio: 1
                },
                save: {
                    callback: function() {
                            this.darkroom.selfDestroy(); // Cleanup
                            var item_image = dkrm.canvas.toDataURL();
                            // fileStorageLocation = newImage
                            
                            
                            var src = "data:image/jpeg;base64,";
                            src += item_image;
                            var newImage = document.createElement('img');
                            newImage.src = src;
                            // console.log(newImage);
                            // newImage.width = newImage.height = "80";
                            // document.querySelector('#imageContainer').innerHTML = newImage.outerHTML;//where to insert your image
                            // $('#stock-img').val(newImage);
                        }
                                        
                   

             }
            }
            });
        };
    </script>
    <a class="add-livestock param-close"><i class="fas fa-times"></i></a>
    <form id="livestock-form">
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
                <img id="Livestock-output">
                <label class="btn stock-img" for="stock-img">Upload a photo</label>
                <input type="file" name="file_upload" id="stock-img" class="inputfile hide" accept="image/*" onchange="loadFile(event)" />
                <?php wp_nonce_field('ajax_form_nonce_stock','ajax_form_nonce_stock', true, true ); ?>
                <input type="hidden" name="action" value="add_livestock">
                <input type="hidden" name="tankid" value="<?php echo $tank_id; ?>">
                <input type="submit" class="btn" value="Add Livestock" />
                
            </form>
</div>




<?php  get_template_part('templates/footer'); ?>
            