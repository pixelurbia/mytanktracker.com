<?php
/*
Template Name: Parameters table
*/
?>


<?php get_template_part('templates/header'); 
 
     ?>


<?php 

    $current_user = wp_get_current_user(); 
    $curuser = $current_user->ID;

    if( !isset( $_GET['tank_id'] )){
        $tank_id = 1;
        $param_type = 1;
    } else {
        $tank_id = $_GET['tank_id'];
        $param_type = $_GET['param_type'];
    }
        ?>
<?php
/*
Template Name: Parameters
*/

    $date = '';
    function get_params($param_type, $curuser, $tank_id) {
         global $wpdb;
         echo '<div class="full-param">';

         // global $date;

        $link = '/fullview?tank_id='.$tank_id.'&param_type='.$param_type;
         $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.id, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $curuser 
            AND tank_id = $tank_id
            ORDER BY user_tank_params.created_date DESC");
         //AND created_date >= DATE_ADD(CURDATE(), INTERVAL -5 DAY) limit 5
         // var_dump($params);
         echo '<div class="param-table" id="table-'.$param->param_type.'">';    
         echo '<table>';
         echo '<tr>';
         echo '<th>Value</th>';
         echo '<th>Date Logged</th>';
         echo '</tr>';
         
                     foreach($params as $param){
                        echo '<tr>';
                            echo '<td>'.$param->param_value.'</td>';
                            echo '<td>'.$param->created_date.'</td>';

                        echo '</tr>';
                     }


                        // echo $date;

        echo '</table>';
        echo '</div>'; 
        echo '</div>'; 




                     } ?>

    <section class="frame"> 
         <?php  
            $tanks = $wpdb->get_results("SELECT * FROM user_tanks WHERE user_id = $curuser AND id = $tank_id");
        ?>
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
    
        <a class="option-btn track-btn" >
            <i class="fas fa-flask"></i> 
            <i class="text">Track</i>
        </a>
        <a class="option-btn">
            <i class="fas fa-cog"></i> 
            <i class="text">Filter</i>
        </a>
         <a class="option-btn" id="export" param_type="<?php echo $param_type; ?>"
                curuser="<?php echo $curuser; ?>" tank_id="<?php echo $tank_id; ?>">
            <i class="fas fa-download"></i> 
            <i class="text" >Export</i>
        </a>
    </div>

        </section>
        <?php 
          $cal = new Calendar();
        $cal->days_with_events();
        echo'<br>';
        
         ?>
        <section class="params">
                <?php  get_params($param_type,$curuser,$tank_id); ?>            
        </section>
        <div class="tank_img_bg" style="background:url(<?php echo $tanks[0]->tank_image ?>)"></div>        


<div class="form-contain">
    <a class="track-btn param-close "><i class="fas fa-times"></i></a>
    <form id="ajax-form" class="param-form" method="post">

                            <input type="hidden" name="action" value="param_form">
                            <?php echo '<input type="hidden" name="tank_id" value="'.$tank_id.'">' ?>
                            <?php echo '<input type="hidden" name="user_id" value="'.$curuser.'">' ?>
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
