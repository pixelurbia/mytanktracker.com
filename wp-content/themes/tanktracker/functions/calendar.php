<?php

function cmp($a, $b) {
	return strcmp($a["date"], $b["date"]);
}

function to_date_object($date) {
  $month = substr($date, 4, 2);
  $day = substr($date, 6, 2);
  $year = substr($date, 0, 4);
  return mktime(0, 0, 0, $month, $day, $year);
}

class Calendar {

	private $per_page;
	private $today;
	private $offset;
	private $end_offset;

	public $num_pages;

	public $tag;
	public $year_start;
	public $year_end;
	public $month_selected;
	public $year_selected;
	public $month_start;
	public $month_end;
	public $mid_month;
	public $days_in_month;
	public $empty_spaces;
	public $page;
	public $events = array();

	function __construct() {
		$this->per_page = 20;
		$this->page = 1;
		$this->offset = 0;
		$this->end_offset = $this->per_page;
		$this->today = date("Ymd");
		$this->tag = NULL;

		//year start
		$first_event_array = $this->first_event();
		$first_event = $first_event_array[0];
		$date_start = get_post_meta($first_event->ID, 'start_date', true);
		$this->year_start = substr($date_start, 0, 4);

		//year end
		$last_event_array = $this->last_event();
		$last_event = $last_event_array[0];
		$date_end = get_post_meta($last_event->ID, 'start_date', true);
		$this->year_end = substr($date_end, 0, 4);
	}

	function paginate_link($i, $text = "") {
		if($text == "") { $text = $i; }
		if($this->tag) {
			return '<a href="?type='. $this->tag .'&paginate='. $i .'">'. $text .'</a> ';
		} else {
			return '<a href="?paginate='. $i .'">'. $text .'</a> ';
		}
	}

	function tag_link($tag) {
		if($this->tag == $tag->slug) {
			return '<span>'. $tag->name . '</span>';
		} else {
			return '<a href="?type='. $tag->slug .'">'. $tag->name .'</a>';
		}
	}

	function set_page($page) {
		$this->page = $page;
		$this->offset = ($page-1) * $this->per_page;
		//$this->end_offset = $this->offset + $this->per_page;
		//$this->end_offset = $this->per_page;
	}

	function set_tag($tag) {
		$this->tag = $tag;
	}

	function this_month() {
		$this->month_selected = date("n");
		$this->year_selected = date("Y");
		$this->month_start = date("Ym01");
		$this->month_end = date("Ymt");
		$this->month_mid = date("Ym15");
		$this->days_in_month = date("t");
		$this->empty_spaces = date("N", mktime(0, 0, 0, $this->month_selected, 1, $this->year_selected))+1;
		if($this->empty_spaces == 8) {
			$this->empty_spaces = 1;
		}
	}

	function specify_month($month, $year) {
		$this->month_selected = date("n", mktime(0, 0, 0, $month, 1, $year));
		$this->year_selected = date("Y", mktime(0, 0, 0, $month, 1, $year));
		$this->month_start = date("Ym01", mktime(0, 0, 0, $month, 1, $year));
		$this->month_end = date("Ymt", mktime(0, 0, 0, $month, 1, $year));
		$this->days_in_month = date("t", mktime(0, 0, 0, $month, 1, $year));
		$this->empty_spaces = date("N", mktime(0, 0, 0, $month, 1, $year))+1;
		if($this->empty_spaces == 8) {
			$this->empty_spaces = 1;
		}
	}

	function load_month_events() {
		$query = $this->month_events();
		foreach ($query as $post) {
			$event = array();
			$event['title'] = $post->post_title;
			$event['date'] = get_post_meta($post->ID, 'start_date', true);
			$event['event_type'] = get_post_meta($post->ID, 'event_type', true);
			$event['end_date'] = get_post_meta($post->ID, 'end_date', true);
			$event['permalink'] = get_permalink($post->ID);
			$event['date_object'] = to_date_object($event['date']);
			$events_categories = wp_get_post_terms($post->ID, 'events_category');
			$neighborhood_string = "";
			foreach($events_categories as $category) {
				$neighborhood_string = $neighborhood_string . $category->slug . " ";
			}
			$event['neighborhood'] = $neighborhood_string;
			$this->events[] = $event; 
		}
		$this->duplicate_multiday();
		usort($this->events, "cmp");
	}

	function load_list_events() {
		if($this->tag == NULL) {
			$query = $this->events_after_today();
		} else {
			$query = $this->events_after_today_with_tag();
		}
		foreach ($query as $post) {
			$event = array();
			$event['title'] = $post->post_title;
			$event['date'] = get_post_meta($post->ID, 'start_date', true);
			$event['end_date'] = get_post_meta($post->ID, 'end_date', true);
			$event['permalink'] = get_permalink($post->ID);
			$event['date_object'] = to_date_object($event['date']);
			$this->events[] = $event;
		}
		$this->duplicate_multiday();
		usort($this->events, "cmp");

		//remove events before todays date (included becuase of end_date)
		for ($i = 0; $i <= count($this->events); $i++) {
			if($this->events[$i]['date'] < $this->today) {
				unset($this->events[$i]);
			} else {
				break;
			}
		}

		//set the total number of pages possible in pagination
		$this->num_pages = ceil(count($this->events) / $this->per_page);

		//remove events not in this pagination
		$this->events = array_slice($this->events, $this->offset, $this->end_offset);
	}

	function duplicate_multiday() {
		foreach($this->events as $event) {
			if($event['end_date'] && $event['date'] != $event['end_date']) {
				$date1 = new DateTime($event['date']);
	  		$date2 = new DateTime($event['end_date']);
	  		$interval = $date1->diff($date2);
	  		for($x=1; $x <= $interval->days; $x++) {
	  			$new_event = array();
	  			$new_event['title'] = $event['title'];
	  			$new_event['permalink'] = $event['permalink'];
	  			$new_event['neighborhood'] = $event['neighborhood'];
	  			error_log($event['neighborhood']);
	  			$new_event['date'] = date_format($date1->add(new DateInterval('P1D')), "Ymd");
	  			$new_event['date_object'] = to_date_object($new_event['date']);
	  			$this->events[] = $new_event;
	  		}
			}
		}
	}

	function set_page_old($page) {
		$this->page = $page-1;
		$this->offset = ($page-1) * $this->per_page;
		$this->end_offset = $this->offset + $this->per_page;
	}

	function set_today_page() {
		for($x = 0; $x < count($this->events); $x++) {
			if($this->events[$x]['date'] > $this->today) {
				$this->set_page(floor($x/$this->per_page) + 1);
				break;
			}
		}
	}

	function get_page_events() {
		$return_events = array();
		if($this->end_offset > count($this->events)) {
			$this->end_offset = count($this->events);
		}
		for($x = $this->offset; $x < $this->end_offset; $x++) {
			$return_events[] = $this->events[$x];
		}
		return $return_events;
	}

	function load_all_events() {
		$query = $this->all_events();
		foreach ($query as $post) {
			$event = array();
			$event['title'] = $post->post_title;
			$event['date'] = get_post_meta($post->ID, 'start_date', true);
			$event['end_date'] = get_post_meta($post->ID, 'end_date', true);
			$event['permalink'] = get_permalink($post->ID);
			$this->events[] = $event;
		}
		$this->duplicate_multiday();
		usort($this->events, "cmp");
	}

	function eblast_events() {
		$this->this_month();
		if(date('j') < 14) {
			$query = $this->events_after_today_until($this->month_mid);
		} else {
			$query = $this->events_after_today_until($this->month_end);
		}
		foreach ($query as $post) {
			$event = array();
			$event['ID'] = $post->ID;
			$event['post_title'] = $post->post_title;
			$event['post_date'] = $post->post_date;
			$event['date'] = get_post_meta($post->ID, 'start_date', true);
			$event['end_date'] = get_post_meta($post->ID, 'end_date', true);
			$event['permalink'] = get_permalink($post->ID);
			$event['date_object'] = to_date_object($event['date']);
			$event['post_content'] = $post->post_content;
			$this->events[] = $event;
		}
		//$this->duplicate_multiday();
		usort($this->events, "cmp");
		return $this->events;
	}



	function events_after_today_until($date) {
		global $wpdb;
		return $wpdb->get_results( 
		  "
		  SELECT *
			FROM wp_posts
			INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
			WHERE wp_posts.post_type = 'custom_events'
			AND wp_posts.post_status = 'publish'
			AND 
			(
			(wp_postmeta.meta_key = 'start_date' AND wp_postmeta.meta_value >= '$this->today')
			OR
			(wp_postmeta.meta_key = 'end_date' AND wp_postmeta.meta_value >= '$this->today')
			)
			AND
			(
			(wp_postmeta.meta_key = 'start_date' AND wp_postmeta.meta_value <= '$date')
			OR
			(wp_postmeta.meta_key = 'end_date' AND wp_postmeta.meta_value <= '$date')
			)
			GROUP BY wp_posts.ID
		  "
		);
	}

	function events_after_today() {
		global $wpdb;
		return $wpdb->get_results( 
		  "
		  SELECT ID, post_title
			FROM wp_posts
			INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
			WHERE wp_posts.post_type = 'custom_events'
			AND wp_posts.post_status = 'publish'
			AND 
			(
			(wp_postmeta.meta_key = 'start_date' AND wp_postmeta.meta_value >= '$this->today')
			OR
			(wp_postmeta.meta_key = 'end_date' AND wp_postmeta.meta_value >= '$this->today')
			)
			GROUP BY wp_posts.ID
		  "
		);
	}

	function events_after_today_with_tag() {
		global $wpdb;
		return $wpdb->get_results( 
		  "
		  SELECT ID, post_title
			FROM wp_posts
			INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
			INNER JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
			INNER JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
			INNER JOIN wp_terms ON (wp_terms.term_id = wp_term_taxonomy.term_id)
			WHERE wp_posts.post_type = 'custom_events'
			AND wp_posts.post_status = 'publish'
			AND 
			(
			(wp_postmeta.meta_key = 'start_date' AND wp_postmeta.meta_value >= '$this->today')
			OR
			(wp_postmeta.meta_key = 'end_date' AND wp_postmeta.meta_value >= '$this->today')
			)
			AND wp_term_taxonomy.taxonomy = 'custom_events'
			AND wp_terms.slug = '$this->tag'
			GROUP BY wp_posts.ID
		  "
		);
	}

	function first_event() {
		global $wpdb;
		return $wpdb->get_results( 
	    "
	    SELECT ID
	    FROM wp_posts
	    INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id) 
	    WHERE wp_posts.post_type = 'custom_events'
	    AND wp_posts.post_status = 'publish'
	    AND wp_postmeta.meta_key = 'start_date'
	    AND wp_postmeta.meta_value <> ''
	    GROUP BY wp_posts.ID
	    ORDER BY wp_postmeta.meta_value ASC
	    LIMIT 1
	    "
  	);
	}

	function last_event() {
		global $wpdb;
		return $wpdb->get_results( 
	    "
	    SELECT ID
	    FROM wp_posts
	    INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id) 
	    WHERE wp_posts.post_type = 'custom_events'
	    AND wp_posts.post_status = 'publish'
	    AND wp_postmeta.meta_key = 'start_date'
	    GROUP BY wp_posts.ID
	    ORDER BY wp_postmeta.meta_value DESC
	    LIMIT 1
	    "
  	);
	}

	function month_events() {
		global $wpdb;
		return $wpdb->get_results(
			"
			SELECT ID, post_title
			FROM wp_posts
			INNER JOIN wp_postmeta m1 ON (wp_posts.ID = m1.post_id)
			INNER JOIN wp_postmeta m2 ON (wp_posts.ID = m2.post_id)
			WHERE wp_posts.post_type = 'custom_events'
			AND wp_posts.post_status = 'publish'
			AND 
			(
			(m1.meta_key = 'start_date' AND m1.meta_value >= '$this->month_start' AND m1.meta_value <= '$this->month_end')
			OR
			(m2.meta_key = 'end_date' AND m2.meta_value >= '$this->month_start' AND m2.meta_value <= '$this->month_end')
			OR
			(m1.meta_key = 'start_date' AND m2.meta_key = 'end_date' AND m1.meta_value < '$this->month_start' AND m2.meta_value > '$this->month_end')
			)
			GROUP BY wp_posts.ID
			"
		);
	}

	function event_tags() {
		global $wpdb;
		return $wpdb->get_results(
			"
			SELECT name, slug
			FROM wp_terms
			INNER JOIN wp_term_taxonomy ON (wp_term_taxonomy.term_id = wp_terms.term_id)
			WHERE wp_term_taxonomy.taxonomy = 'custom_events'
			"
		);
	}

	function next_event() {
		global $wpdb;
		return $wpdb->get_results( 
	    "
	    SELECT ID
	    FROM wp_posts
	    INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id) 
	    WHERE wp_posts.post_type = 'custom_events'
	    AND wp_posts.post_status = 'publish'
	    AND wp_postmeta.meta_key = 'start_date'
	    AND wp_postmeta.meta_value >= '$this->today'
	    GROUP BY wp_posts.ID
	    ORDER BY wp_postmeta.meta_value ASC
	    LIMIT 1
	    "
  	);
	}

	function all_events() {
		global $wpdb;
		return $wpdb->get_results( 
	    "
	    SELECT ID, post_title
	    FROM wp_posts
	    INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id) 
	    WHERE wp_posts.post_type = 'custom_events'
	    AND wp_posts.post_status = 'publish'
	    AND wp_postmeta.meta_key = 'start_date'
	    AND wp_postmeta.meta_value <> ''
	    GROUP BY wp_posts.ID
	    ORDER BY wp_postmeta.meta_value ASC
	    "
	  );
	}

	function events_page() {
		global $wpdb;
		return $wpdb->get_results( 
		  "
		  SELECT ID, post_title
		  FROM wp_posts
		  INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id) 
		  WHERE wp_posts.post_type = 'custom_events'
		  AND wp_posts.post_status = 'publish'
		  AND wp_postmeta.meta_key = 'start_date'
		  AND wp_postmeta.meta_value <> ''
		  GROUP BY wp_posts.ID
		  ORDER BY wp_postmeta.meta_value ASC
		  LIMIT $this->offset, $this->per_page
		  "
		);
	}

}
