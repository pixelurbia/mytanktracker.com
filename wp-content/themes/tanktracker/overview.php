<?php
/*
Template Name: Overview
*/
?>


<?php 
get_template_part('templates/header'); 
?>

<?php 

global $wpdb;
	$user = wp_get_current_user();
	$curuser = $user->ID;
	if( !isset( $_GET['tank_id'] )){
        $tank_id = $wpdb->get_var("SELECT id FROM user_tanks WHERE user_id = $curuser ORDER BY created_date limit 1 ");
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
		
	</div>


               
		
	
	<!-- <section class="reminders third"> 
		<a class="add-btn"><i class="fas fa-plus"></i></a>
	</section> -->
	<script type="text/javascript">
		var loadFile = function(event) {
    		var output = document.getElementById('output');
    		output.src = URL.createObjectURL(event.target.files[0]);
  		};
	</script>
	<section class="journals third">	
	<h3>Journals</h3>
		 <form id="journal-form" method="post">
		<input type="hidden" name="action" value="add_journal">
		<?php echo '<input type="hidden" name="tank_name" value="'.$tanks[0]->tank_name.'">' ?>
		<?php echo '<input type="hidden" name="user_id" value="'.$curuser.'">' ?>
		<?php wp_nonce_field('ajax_form_nonce_journal','ajax_form_nonce_journal', true, true ); ?>
		<div contenteditable="true" class="status" id='j-status'  >
				<i>How are the tanks today?</i>
		</div>
		<img id="output">	
		<input id="status-content" type="text-area" class="hide" name="journal" value="">
		<fieldset>
			<label class="button tank-img" for="journal-img"><i class="fas fa-images"></i></label>
			<input type="file" name="file_upload" id="journal-img" class="inputfile hide" accept="image/*" onchange="loadFile(event)"/>
			<button type="submit" name="submit">
			<i class="fas fa-paper-plane"></i>
		</button>
		</fieldset>
    </form>

		<?php  
		$journals = array(
			'author' => $curuser,
			'post_type' => 'user_journals', 
			'post_status' => 'publish'
		);
		echo '<table>';
		echo '<tr>';
		echo '<th>Journal</th>';
		echo '<th>Posted On</th>';
		echo '</tr>';
		$query = new WP_Query( $journals );
			if ( $query->have_posts() ) : ?>
    			<?php while ( $query->have_posts() ) : $query->the_post(); ?>   
        		
            		<?php 
            		$permlink = get_the_permalink();
            		$excerpt = get_the_excerpt();

            		echo '<tr>';
            		echo '<td>';
            		echo '<a href="'.$permlink.'">'.$excerpt.'</a>';
            		echo '</td>';
            		echo '<td>';
            		the_time('F jS, Y'); 
            		echo '</td>';
            		?>

    			<?php endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
				<?php endif; 
				echo '</table>';
				?>

	</section>
	<section class="timeline third">
			<h3>Recent Parameters</h3>
		<?php 


      	$cal = new Calendar();
        $cal->days_with_events();
        echo'<br>';
		function get_params($param_type, $curuser, $tank_id) {

         global $wpdb;
         // global $date;
           $params = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.id, user_tank_params.param_type, user_tank_params.param_value, param_ref.param_name, param_ref.param_short 
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_id = $curuser 
            AND tank_id = $tank_id
            AND user_tank_params.param_type = $param_type
            ORDER BY user_tank_params.created_date DESC
            LIMIT 1");
         //AND created_date >= DATE_ADD(CURDATE(), INTERVAL -5 DAY) limit 5
         // var_dump($params);
       
         
                     foreach($params as $param){
                        echo '<tr>';
                            echo '<td>'.$param->param_name.'</td>';
                            echo '<td>'.$param->param_value.'</td>';
                            echo '<td>'.$param->created_date.'</td>';

                        echo '</tr>';
                     }


                        // echo $date;

  
     	};
		 $params_reported = $wpdb->get_results("SELECT DISTINCT param_type FROM user_tank_params WHERE user_id = $curuser AND tank_id = $tank_id");

                    //var_dump($params_reported);
                    // $salinity = array();
		   				echo '<div class="param-table large" id="table-'.$param->param_type.'">';
         				echo '<table>';
         				echo '<tr>';
         				echo '<th>Parameter</th>';
         				echo '<th>Value</th>';
         				echo '<th>Date Logged</th>';
         				echo '</tr>';
                        foreach($params_reported as $param_type){
                                $param_type = $param_type->param_type;
                                get_params($param_type,$curuser,$tank_id);
                        }
                        
      					echo '</table>';
        				echo '</div>'; 
        				echo '</div>'; 
		 ?>
	</section>

										
	</div>
</section>


<div class="reminder form-contain">
    <a class="close"><i class="fas fa-times"></i></a>
    <form id="ajax-form" class="param-form" method="post">
		<input type="hidden" name="action" value="reminder_form">
		<?php echo '<input type="hidden" name="tank_id" value="'.$tank_id.'">' ?>
		<?php echo '<input type="hidden" name="user_id" value="'.$curuser.'">' ?>
		<?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
		<input type="text" name="Reminder" placeholder="Reminder">
		<input type="date" name="Reminder" >
		<input type="submit" name="submit" value="Log">
    </form>
</div>

<?php get_template_part('templates/footer'); ?>
