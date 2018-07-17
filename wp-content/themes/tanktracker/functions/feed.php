<?php


class Feed {

	function user_info() {
	 	
	 	$current_user = wp_get_current_user();
		$user = $current_user->ID;
		return $user;
	 }


	 function is_faved($user_id, $post_id) {

		global $wpdb;
		$favs = $wpdb->get_var("SELECT COUNT(ref_id) FROM user_post_refs WHERE user_id = '$user_id' AND ref_key = 'fav_post' AND ref_id = $post_id");


		if ($favs >= 1) {
			echo '<a class="fave static" user="'.$user_id.'" fav_ajax_nonce="'.wp_create_nonce( 'fav_ajax_nonce' ).'" ref_id="'.$post_id.'"><i class="fas fa-heart"></i> '.$this->faves_count($post_id).'</a>';
		} else {
			echo '<a class="fave" user="'.$user_id.'" fav_ajax_nonce="'.wp_create_nonce( 'fav_ajax_nonce' ).'" ref_id="'.$post_id.'"><i class="fas fa-heart"></i> '.$this->faves_count($post_id).'</a>';
		}
		// echo $favs;
		
}

	 function faves_count($post_id) {

		global $wpdb;
		$favs = $wpdb->get_var("SELECT COUNT(ref_id) FROM user_post_refs WHERE ref_key = 'fav_post' AND ref_id = $post_id");

		return $favs;
		// echo $favs;
		
}

	

	function get_tank_feed($tank_id) {


	
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$posts = array(
			'author' => $user,
			'posts_per_page' => 15,
			'post_type' => 'user_journals', 
			'post_status' => 'publish',
			'meta_key'  => 'tt_tank_ref',
			'meta_value'  => $tank_id,
			'paged' => $paged,
			);

		$query = new WP_Query( $posts );
			if ( $query->have_posts() ) : ?>
    			<?php while ( $query->have_posts() ) : $query->the_post(); ?>   
        		
            		<?php 
            		$permlink = get_the_permalink();
            		$excerpt = get_excerpt(500);
            		$name = get_the_author_meta('display_name');
            		$time = get_the_time('F jS, Y');
					$user_id = $this->user_info();
      				$post_id = get_the_ID();
      				$comment_count = wp_count_comments( $post_id );

            		echo '<article class="grid-item post" >';
            		echo '<p class="user-info">';
					echo get_avatar( get_the_author_meta( 'ID' ), 32 ); 
            		echo '<span>'.$name.' on '. $time .'</span></p>';
            		echo get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'alignleft' ) );
            		the_excerpt();
            		// echo '<a href="'.$permlink.'">Read More </a>';
            		echo '<a href="'.$permlink.'">'.$comment_count->total_comments .' comments</a>';
            		$this->is_faved($user_id,$post_id);
            		echo '</article>';

					endwhile; endif; 
				echo '<div id="pagination">';

				$big = 999999999; // need an unlikely integer
				
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $query->max_num_pages
				) );
			echo '</div>';


}


function get_main_feed() {
	
	
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$posts = array(
			'posts_per_page' => 10,
			'post_type' => 'user_journals', 
			'post_status' => 'publish',
			'paged' => $paged,
			);

		$query = new WP_Query( $posts );
			if ( $query->have_posts() ) : ?>
    			<?php while ( $query->have_posts() ) : $query->the_post(); ?>   
        		
            		<?php 
            		$permlink = get_the_permalink();
            		$excerpt = get_excerpt(500);
            		$name = get_the_author_meta('display_name');
            		$time = get_the_time('F jS, Y');
            		$user_id = $this->user_info();
            		$post_id = get_the_ID();


            		echo '<article class="grid-item post" >';
            		echo '<p class="user-info">';
					echo get_avatar( get_the_author_meta( 'ID' ), 32 ); 
            		echo '<span>'.$name.' on '. $time .'</span></p>';
            		echo get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'alignleft' ) );
            		the_excerpt();
            		
            		echo '<a href="'.$permlink.'">Read More</a>';
            		echo '<br>';
            		$this->is_faved($user_id,$post_id);	
            		echo '</article>';

					endwhile; endif; 
				echo '<div id="pagination">';

				$big = 999999999; // need an unlikely integer
				
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $query->max_num_pages
				) );
			echo '</div>';


}

function get_people_feed() {

		global $wpdb;
		$people = $wpdb->get_results("SELECT id, display_name FROM $wpdb->users ORDER BY RAND() LIMIT 10");

		
		// User Loop
		
			foreach ( $people as $person ) {
				echo '<div class="person">';
				echo '<p class="user-info">';
				echo get_avatar( get_the_author_meta( 'ID' ), 32 ); 
				echo '<span>'.$person->display_name.'</span></p>';
				echo '</div>';
			}
}


}
