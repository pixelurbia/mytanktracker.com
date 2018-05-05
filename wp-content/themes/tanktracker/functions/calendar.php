<?php


 


class Calendar {
 
 

function get_num_of_changes() {

		global $wpdb;
	    $current_user = wp_get_current_user(); 
    	$curuser = $current_user->ID;
 
		
      $events = $wpdb->get_results("
      		SELECT date(`created_date`) as created_date
            FROM `user_tank_params`
            WHERE user_id = $curuser 
            GROUP BY date(`created_date`)");
            // var_dump($dis);
	$event_dates = array();
	foreach($events as $event){
		// var_dump($event);
		$event_dates[] = date("m-d", strtotime($event->created_date));
		// echo $event_date.'<br>';
	}

	return $event_dates;
}



	 


function days_with_events() {

	$month = date("m");
	$day = date("d");
	$year = date("Y");
	$days = cal_days_in_month(CAL_GREGORIAN,$month,$year); 
	  

	//return event dates
 	$event_dates = $this->get_num_of_changes();
echo '<div class="monthly-updates">';

	// echo $days;
//prev month
	$prev_month_days = cal_days_in_month(CAL_GREGORIAN,$month-2,$year); 
	echo '<div class="month prev_month_days ">';
	for ($i = 1; $i < $prev_month_days+1; $i++) {
		// echo $i;
		$prev_second_month = date("m", strtotime("-2 months"));
		$i = str_pad($i,2,"0",STR_PAD_LEFT);
		$ps_tt_date = $prev_second_month.'-'.$i.'-'.date("Y"); //tool tip date
		$mo_date = $prev_second_month.'-'.$i;
		


		echo '<div class="day ';
		if (in_array($prev_second_month, $event_dates)){
			echo ' one-change';
		} else {
			echo ' no-change';
		}
		echo '" value="'.$ps_tt_date.'" ></div>';
	}
	echo '</div>';
//cur month
	$curn_month_days = cal_days_in_month(CAL_GREGORIAN,$month-1,$year); 
	echo '<div class="month curn_month_days ">';	
	for ($i = 1; $i < $curn_month_days+1; $i++) {
		// echo $i;
		$prev_month = date("m", strtotime("-1 months"));
		$i = str_pad($i,2,"0",STR_PAD_LEFT);
		$p_tt_date = $prev_month.'-'.$i.'-'.date("Y");//tool tip date
		$prev_month = $prev_month.'-'.$i;
		echo '<div class="day ';

		
	    if (in_array($prev_month, $event_dates)){
			echo ' one-change';
		} else {
			echo ' no-change';
		}
		echo '" value="'.$p_tt_date.'"></div>';
	}
	echo '</div>';
//next month
	$next_month_days = cal_days_in_month(CAL_GREGORIAN,$month,$year); 
	echo '<div class="month next_month_days ">';
	for ($i = 1; $i < $next_month_days+1; $i++) {
		// echo $i;
		$curr_month = date("m");
		$i = str_pad($i,2,"0",STR_PAD_LEFT);
		$c_tt_date = $curr_month.'-'.$i.'-'.date("Y");//tool tip date
		$curr_month = $curr_month.'-'.$i;

		echo '<div class="day ';

		if (in_array($curr_month, $event_dates)){
			echo ' one-change';
		} else {
			echo ' no-change';
		}
		echo '" value="'.$c_tt_date.'"></div>';
	}
	echo '</div>';

	echo '</div>';
}

// prev/lastmonth
// date('F', strtotime('-1 day', strtotime(date('Y-m-01'))));

}

