<?php

add_action('init', 'create_taxonomies');

function create_taxonomies() {

	register_taxonomy('events_category', 'custom_events', 
		array(
			'publicly_queryable' => false,
			'labels' => array('name' => 'Events Categories'),
			'hierarchical' => true
		)
	);
		register_taxonomy('resources_category', 'resources', 
		array(
			'publicly_queryable' => false,
			'labels' => array('name' => 'Resources Categories'),
			'hierarchical' => true
		)
	);
	}