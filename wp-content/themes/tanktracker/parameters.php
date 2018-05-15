<?php
/*
Template Name: Parameters
*/
?>


<?php get_template_part('templates/header'); 
 
     ?>
<div class="mouse-tool-tip"></div>

<?php 

$tank_id = $_GET['tank_id'];
$user_tanks = new Tanks();
$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->id;
$user = $user_tanks->user_info();


    function get_params($param_type, $user, $tank_id) {
         global $wpdb;
         // global $date;
         $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $user 
            AND tank_id = $tank_id 
            AND user_tank_params.param_type = $param_type
            ORDER BY user_tank_params.created_date ASC
            ");
         //AND created_date >= DATE_ADD(CURDATE(), INTERVAL -5 DAY) limit 5
         // var_dump($params);
         echo '<div class="aparam">';
         echo '<div class="param-chart">';
                $parameters = array();
                foreach($params as $param){
                        $parameters['parameter'][0] = array(
                            'name' => $param->param_name,
                            'short_name' => $param->param_short,
                            'type' => $param->param_type
                    );
                        $parameters['values'][] = array(
                           'date' => $param->created_date,
                            'value' => $param->param_value
                        );

                     }

                    $param_values = $parameters['values'];

                  
                     echo '<p class="name">'.$parameters['parameter'][0]['name'] .'</p>';
                     $chart_name = 'chart'.$parameters['parameter'][0]['type'];
                     $chart_long_name = $parameters['parameter'][0]['name'];
                     $chart_id = utf8_encode($parameters['parameter'][0]['short_name']);
                        foreach($param_values as $param_value) {
                                        // var_dump($param_value);
                            $originalDate = $param_value['date'];
                            $newDate = date("m-d-y", strtotime($originalDate));
                            $date .= '"'.$newDate.'", ';
                            $value .= $param_value['value'].', ';
                                    // echo  .' '. $param_value['short'];
                        }
                        // echo $date;
                        ?>
                        <canvas id="<?php echo $chart_name ?>" class="a-chart" width="auto" height="auto"></canvas>
                        <script>
                        var ctx = document.getElementById(<?php echo json_encode($chart_name) ?>);
                        var <?php echo $chart_name ?> = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: [<?php echo $date ?>],
                                datasets: [{
                                    label: <?php echo json_encode($chart_long_name) ?>,
                                    data: [<?php echo $value ?>],
                                        backgroundColor: [
                                        'rgba(255, 255, 255, 0  )',
                                        'rgba(255, 255, 255, 0)',
                                        'rgba(255, 255, 255, 0)',
                                        'rgba(255, 255, 255, 0)',
                                        'rgba(255, 255, 255, 0)',
                                        'rgba(255, 255, 255, 0)'
                                        ],
                                        borderWidth: 1,
                                    fill: [false],
                                    borderColor: ['rgb(75, 192, 192)'],
                                    lineTension: 1
                                }]
                            },
                            options: {
                                 layout: {
                                        padding: {
                                  left: 10,
                                  right: 10,
                                  top: 10,
                                  bottom: 10
                                   }
                                  },
                                responsive: false,
                                legend: { 
                                    display: false,
                                },
                                 scales: {
                                    xAxes: [{
                                        display: false,
                                        gridLines: {
                                         display: false,
                                         drawTicks: false,
                                         color:"rgba(255, 255, 255, 0)"
                                        },

                                        ticks: {
                                            display: false
                                            }
                                    }],
                                    yAxes: [{
                                        display: true,
                                        gridLines: {
                                            display: true,
                                            drawTicks: false,
                                            drawBorder: false,
                                            color:"rgba(255, 255, 255, 0.1)"
                                        },
                                        ticks: {
                                            display: false,
                                            maxTicksLimit: 5
                                            }
                                    }]
                                    }
                            }
                        });
                        </script>
<?php 
 echo '</div>';
 global $wpdb;
         // global $date;

         $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.id, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $user 
            AND tank_id = $tank_id
            AND user_tank_params.param_type = $param_type
            ORDER BY user_tank_params.created_date DESC
            LIMIT 5");
         //AND created_date >= DATE_ADD(CURDATE(), INTERVAL -5 DAY) limit 5
         // var_dump($params);
         echo '<div class="param-table " id="table-'.$param->param_type.'">';
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
        <a class="option-btn">
            <i class="fas fa-cog"></i> 
            <i class="text">Filter</i>
        </a>
     <!--     <a class="option-btn">
            <i class="fas fa-download"></i> 
            <i class="text">Export</i>
        </a>   -->
        <a href="<?php echo '/fullview?tank_id='.$tank_id;?>" class="option-btn">
            <i class="fas fa-download"></i> 
            <i class="text">View All Entries</i>
        </a>
    </div>


        </section>
        <?php 

      $cal = new Calendar();
        $cal->days_with_events();
        echo'<br>';
         ?>
        <section class="params">
                <?php  

                        $parameters = new Parameters();
                        $params_reported = $parameters->get_param_types_list($tank_id);

                        foreach($params_reported as $param_type){
                                $param_type = $param_type->param_type;
                                get_params($param_type,$user,$tank_id);
                        }

                ?>


            
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
