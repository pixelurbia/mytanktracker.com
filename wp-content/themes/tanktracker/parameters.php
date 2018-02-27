<?php
/*
Template Name: Parameters
*/
?>


<?php get_template_part('templates/header'); ?>


<?php 

    $current_user = wp_get_current_user(); 
    $curuser = $current_user->ID;

    if( !isset( $_GET['tank_id'] )){
        $tank_id = 1;
    } else {
        $tank_id = $_GET['tank_id'];
    }


    $date = '';
    function get_params($param_type, $curuser, $tank_id) {
         global $wpdb;
         // global $date;
         $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $curuser 
            AND tank_id = $tank_id 
            AND user_tank_params.param_type = $param_type");
         //AND created_date >= DATE_ADD(CURDATE(), INTERVAL -5 DAY) limit 5
         // var_dump($params);
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
                                            display: false
                                            }
                                    }]
                                    }
                            }
                        });
                        </script>
                        <?php echo '</div>'; } ?>

<section class="full">
    <section class="frame"> 
        <?php  
            $tank = $wpdb->get_results("SELECT tank_name FROM user_tanks WHERE user_id = $curuser AND tank_id = $tank_id");
            echo '<h2 class="tank-name">'.$tank[0]->tank_name.'</h2>';
        ?>
        <a class="track-btn">
            <i class="fas fa-flask"></i> 
            <i class="text">Track</i>
        </a>
        <section class="params">
                <?php  
                    // $params = $wpdb->get_results("SELECT * from user_tank_params where (param_type, created_date) in ( select param_type, max(created_date) 
                    //      from user_tank_params 
                    //      group by param_type)");8
           
                $params_reported = $wpdb->get_results("SELECT DISTINCT param_type FROM user_tank_params WHERE user_id = $curuser AND tank_id = $tank_id");

                    //var_dump($params_reported);
                    // $salinity = array();
                        foreach($params_reported as $param_type){
                                $param_type = $param_type->param_type;
                                get_params($param_type,$curuser,$tank_id);
                        }
                ?>



        </section>


                        


    </section>
</section>

<?php get_template_part('templates/footer'); ?>
