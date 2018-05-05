<?php
/*
Template Name: stock
*/
// header('Content-Type: text/xml');
?>

<?php get_template_part('templates/header'); ?>


<?php 

global $wpdb;
    $user = wp_get_current_user();
    $curuser = $user->ID;
    if( !isset( $_GET['tank_id'] )){
        $tank_id = 1;
    } else {
        $tank_id = $_GET['tank_id'];
    }
    //main query                            
    $tanks = $wpdb->get_results("SELECT * FROM user_tanks WHERE user_id = $curuser AND id = $tank_id");
                        ?>
    <div class="tank_img_bg" style="background:url(<?php echo $tanks[0]->tank_image ?>)"></div>
    <section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
        <div class="tank_header">
            <h2><?php echo  $tanks[0]->tank_name ?></h2>
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


<section class="stock-list">
    <article class="stock-item">
        <div class="stock-img"></div>
        <div class="stock-data">
            <ul>
                <li class="name">Fozzy</li>
                <li class="name"></li>
                <li class="species">The Dwarf Fuzzy Lionfish</li>
                <li class="age data">Age: 2 years</li>
                <li class="status data">Status: Healthy</li>
            </ul>
        </div>
    </article>
</section>

<form id="stock-form">
            

                <input type="text" name="tankname" value="" placeholder="Tank Name" class="form-control" />
                <select type="text" name="tanktype" value="" placeholder="Tank Type" class="form-control">
                    <option>Tank Type</option>
                    <option>Fresh Water</option>
                    <option>Salt Water</option>
                </select>
                <input type="text" name="volume" value="" placeholder="Tank Total Volume" class="form-control" />
                <input type="text" name="dimensions" value="" placeholder="Tank Dimensions" class="form-control" />
                <input type="text" name="model" value="" placeholder="Tank Model" class="form-control" />
                <input type="text" name="make" value="" placeholder="Tank Make" class="form-control" />
                <!-- <input id="tank-img" type="file" name="file_upload"> -->
                <label class="btn tank-img" for="tank-img">Upload a tank photo</label>
                <input type="file" name="file_upload" id="tank-img" class="inputfile" />
                
                <?php wp_nonce_field('ajax_form_nonce_tank','ajax_form_nonce_tank', true, true ); ?>
                <input type="hidden" name="action" value="add_tank">
                <input type="submit" class="btn" value="Add Your First Tank" />
            </form>


<?php  get_template_part('templates/footer'); ?>
            