<?php

add_action('init', 'create_post_types');

function create_post_types() {

	register_post_type('user_journals', 
		array(
			'labels' => array(
				'name' => 'Journals',
				'singular_name' => 'Journal',
				'add_new' => 'New Journal',
				'add_new_item' => 'Add New Journal',
				'edit_item' => 'Edit Journals',
				'all_items' => 'All Journals'
			),
		'publicly_queryable' => true,
	  	'public' => true,
			'taxonomies' => array('post_tag', 'user_journals'),
			'supports' =>	array('title', 'editor', 'thumbnail')
		)
	);

		register_post_type('resources', 
		array(
			'labels' => array(
				'name' => 'Resources',
				'singular_name' => 'Resources',
				'add_new' => 'New Resource',
				'add_new_item' => 'Add New Resource',
				'edit_item' => 'Edit Resources',
				'all_items' => 'All Resources'
			),
	  	'public' => true,
			'taxonomies' => array('post_tag', 'resources'),
			'supports' =>	array('title', 'editor', 'thumbnail')
		)
	);
			register_post_type('faqs', 
		array(
			'labels' => array(
				'name' => 'FAQs',
				'singular_name' => 'FAQs',
				'add_new' => 'New FAQs',
				'add_new_item' => 'Add New FAQs',
				'edit_item' => 'Edit FAQs',
				'all_items' => 'All FAQs'
			),
	  	'public' => true,
			'taxonomies' => array('post_tag', 'faqs'),
			'supports' =>	array('title', 'editor', 'thumbnail')
		)
	);
}
