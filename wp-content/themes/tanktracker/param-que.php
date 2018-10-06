<?php
/*
Template Name: Parameters que
*/
?>

<?php 

$tank_id = $_GET['tank_id'];
$date_start = $_GET['date_start'];
$date_end = $_GET['date_end'];
$user_tanks = new Tanks();
$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;
$user = $user_tanks->user_info();

if (isset( $date_start ) && isset( $date_end )){
	$datetime = "AND (user_tank_params.created_date BETWEEN '$date_start' AND '$date_end')";
}


    function get_params($param_type, $user, $tank_id, $datetime) {
         global $wpdb;
         // global $date;
         $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $user 
            $datetime
            AND tank_id = '$tank_id'
            AND user_tank_params.param_type = $param_type
            ORDER BY user_tank_params.created_date DESC
            LIMIT 10
            ");
         //AND created_date >= DATE_ADD(CURDATE(), INTERVAL -5 DAY) limit 5
         // var_dump($params);
         echo '<div class="aparam">';
         echo '<div class="param-chart">';
                $parameters = array();
                asort($params);
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
                                // color: ['pink', 'red', 'orange', 'yellow', 'green', 'blue', 'indigo', 'purple']
//                                 var chart_type = <?php echo json_encode($parameters['parameter'][0]['name']); ?>;
// function chart_colors(){
//     if (chart_type == 'Alkalinity'){
//  color: ['pink', 'red', 'orange', 'yellow', 'grey', 'grey', 'grey', 'grey']
//     } else {
//         color:"rgba(255, 255, 255, 0.1)"
//     }

// }


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
                                    lineTension: 0,
                                    // steppedLine:true,
                                }]
                            },
                            options: {
                                 layout: {
                                        padding: {
                                  left: 10,
                                  right: 25,
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
                                            drawTicks: true,
                                            drawBorder: true,
                                            color:"rgba(255, 255, 255, 0.1)",

                                        },
                                        ticks: {
                                            display: true,
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
            AND tank_id = '$tank_id'
            AND user_tank_params.param_type = $param_type
            $datetime
            ORDER BY user_tank_params.created_date DESC
            LIMIT 5");
         //AND created_date >= DATE_ADD(CURDATE(), INTERVAL -5 DAY) limit 5
         // var_dump($params);
         echo '<div class="param-table breakout" id="table-'.$param->param_type.'">';
         echo '<table>';
         echo '<tr>';
         echo '<th>Value</th>';
         echo '<th>Date Logged</th>';
         echo '</tr>';
         
                     foreach($params as $param){
                        $pdate = strtotime($param->created_date);
             $pdate = date('m-d-Y',$pdate);

                        echo '<tr>';
                            echo '<td>'.$param->param_value.'</td>';
                            echo '<td>'.$pdate.'</td>';

                        echo '</tr>';
                     }


                        // echo $date;

        echo '</table>';
        echo '</div>'; 
        echo '</div>'; 




                     } ?>


        <section class="params">
                <?php  

                        $parameters = new Parameters();
                        $params_reported = $parameters->get_param_types_list($tank_id);

                        foreach($params_reported as $param_type){
                                $param_type = $param_type->param_type;
                                get_params($param_type,$user,$tank_id,$datetime);
                        }

                ?>


            
        </section>