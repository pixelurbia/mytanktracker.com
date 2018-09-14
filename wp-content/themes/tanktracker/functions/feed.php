<?php


class Feed {

	function user_info() {
	 	
	 	$current_user = wp_get_current_user();
		$user = $current_user->ID;
		return $user;
	 }


	 function cats() {
		global $wpdb;

		$cats = $wpdb->get_results("SELECT term_id, name FROM tt_terms");

		return $cats;
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

function get_post_images($post_id){
	
	// $post_id = $_GET['post_id'];
    $user = $this-> user_info();

    global $wpdb;     
    $images = $wpdb->get_results("SELECT photo_url,photo_thumb_url FROM user_photos WHERE user_id = $user AND ref_id = $post_id");
    // echo '<p>'.$numOfImages.' Photos</p>';
    $i = 0;
    if ($images){
    	 echo '<ul class="gallery post-gallery">';
      foreach ($images as $img){
        echo '<li class="gallery-item item-'.$i.'">';
          echo '<img src="'.$img->photo_url.'">';
        echo '</li>';
        $i++;
    	}
    	
    	echo '</ul>';
    }
   
}

function get_feed_images($post_id){
	
	// $post_id = $_GET['post_id'];
    $user = $this-> user_info();
    $permlink = get_the_permalink($post_id);
    global $wpdb;     
    $numOfImages = $wpdb->get_var("SELECT COUNT(photo_url) FROM user_photos WHERE user_id = $user AND ref_id = $post_id");
    $images = $wpdb->get_results("SELECT photo_url,photo_thumb_url FROM user_photos WHERE user_id = $user AND ref_id = $post_id LIMIT 1");

    $i = 0;
    if ($images){
    	 echo '<ul class="gallery feed-gallery gallery-of-1">';
      foreach ($images as $img){
        echo '<li class="gallery-item">';
	  	if ($numOfImages > 1 ){
	  		echo '<a class="photo-link btn" href="'.$permlink.'">'.$numOfImages.'</a>';
        }
      	echo '<img full="'.$img->photo_url.'" src="'.$img->photo_thumb_url.'">';
        echo '</li>';
        $i++;
    	}
    	echo '</ul>';

    }
   
}

	function get_stock_feed($stock_id) {


		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$posts = array(
			'author' => $user,
			'posts_per_page' => 15,
			'post_type' => 'user_journals', 
			'post_status' => 'publish',
			'meta_key'  => 'tt_tank_ref',
			'meta_value'  => $stock_id,
			'paged' => $paged,
			);

		$query = new WP_Query( $posts );
			if ( $query->have_posts() ) : ?>
    			<?php while ( $query->have_posts() ) : $query->the_post(); ?>   
        		
            		<?php 
            		$permlink = get_the_permalink();
            		            		// $excerpt = get_excerpt(50);
            		$excerpt = get_the_excerpt();
            		$name = get_the_author_meta('display_name');
            		$time = get_the_time('F jS, Y');
            		$user_id = $this->user_info();
            		$post_id = get_the_ID();
            		$comment_count = wp_count_comments( $post_id );
            		$comment_count = $comment_count->total_comments;

            		echo '<article class="grid-item post" >';
            		echo '<a class="post-options"><i class="fas fa-ellipsis-v"></i></a>';
            		echo '<div class="post-options-menu">';
            			echo '<a class="report-this-post" post_id="'.$post_id.'" reporting_user="'.$user_id.'" content_type="post" auth_id="'.$auth_id.'" report_nonce="'.wp_create_nonce( 'report_ajax_nonce' ).'">Report Post</a>';
            		echo '</div>';
            		$this->get_feed_images($post_id);
					echo '<div class="post-data">';
            			echo '<div class="user-info">';
						echo get_avatar( get_the_author_meta( 'ID' ), 32 ); 
            			echo '<p><span>'.$name.' on '. $time .'</span></p>';
            			echo'</div>';
            			echo exclude_post_categories('1');
            		
            			// echo '<a href="'.$permlink.'">Read More </a>';
						echo '<p class="excerpt">'.$excerpt.'</p>';
            			echo '<div class="post-info">';

            			$this->is_faved($user_id,$post_id);
						if ( $comment_count == 0 ) {
            				echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> comment</a>';
            			} elseif ( $comment_count == 1 ) {
            				echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> '.$comment_count.' comment</a>';
            			} else {
							echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> '.$comment_count.' comment</a>';
            				}
            			
            		echo '</div>';
            		echo '</div>';
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
            		// $excerpt = get_excerpt(50);
            		$excerpt = get_the_excerpt();
            		$name = get_the_author_meta('display_name');
            		$time = get_the_time('F jS, Y');
            		$user_id = $this->user_info();
            		$post_id = get_the_ID();
            		$comment_count = wp_count_comments( $post_id );
            		$comment_count = $comment_count->total_comments;

            		echo '<article class="grid-item post" >';
            		$this->get_feed_images($post_id);
					echo '<div class="post-data">';
            			echo '<div class="user-info">';
						echo get_avatar( get_the_author_meta( 'ID' ), 32 ); 
            			echo '<p><span><a href="/profile/?user_id='.$user_id.'">'.$name.'</a> on '. $time .'</span></p>';
            				echo '<a class="post-options"><i class="fas fa-ellipsis-v"></i></a>';
            				echo '<div class="post-options-menu">';
            				echo '<a class="report-this-post" post_id="'.$post_id.'" reporting_user="'.$user_id.'" content_type="post" auth_id="'.$auth_id.'" report_nonce="'.wp_create_nonce( 'report_ajax_nonce' ).'">Report Post</a>';
            				echo '</div>';
            			echo'</div>';
            			echo exclude_post_categories('1');
            		
            			// echo '<a href="'.$permlink.'">Read More </a>';
						echo '<p class="excerpt">'.$excerpt.'</p>';
            			echo '<div class="post-info">';

            			$this->is_faved($user_id,$post_id);
						if ( $comment_count == 0 ) {
            				echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> comment</a>';
            			} elseif ( $comment_count == 1 ) {
            				echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> '.$comment_count.' comment</a>';
            			} else {
							echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> '.$comment_count.' comment</a>';
            				}
            			
            		echo '</div>';
            		echo '</div>';
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


public function get_main_feed() {
		$feed = new Feed();
		global $wpdb;
  		global $post;

	function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
       var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }

    

		$cat = $_GET['cats'];

		//check if a post was reported 
		$reported_posts = $wpdb->get_results("SELECT DISTINCT ref_id FROM mod_log WHERE content_type = 'post' AND mod_approved = 'no'");
 		$ids = array();
    	foreach ($reported_posts as $post) {
    		$ids[] .= $post->ref_id;
		}

		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$posts = array(
			'posts_per_page' => 10,
			'post_type' => 'user_journals', 
			'post_status' => 'publish',
			'post__not_in' => $ids,
			'cat' => $cat, 
			'paged' => $paged,
			);

		$query = new WP_Query( $posts );
			if ( $query->have_posts() ) : ?>
    			<?php while ( $query->have_posts() ) : $query->the_post(); ?>   
        		
            		<?php 
            		$permlink = get_the_permalink();
            		// $excerpt = get_excerpt(50);
            		$excerpt = get_the_excerpt();
            		$name = get_the_author_meta('display_name');
            		$auth_id = get_the_author_meta('id');
            		$time = get_the_time('F jS, Y');
					
					$current_user = wp_get_current_user();
					$user_id = $current_user->ID;

            		$post_id = get_the_ID();
            		$comment_count = wp_count_comments( $post_id );
            		$comment_count = $comment_count->total_comments;

            		echo '<article class="grid-item post" >';
            		echo '<a class="post-options"><i class="fas fa-ellipsis-v"></i></a>';
            		echo '<div class="post-options-menu">';
            			echo '<a class="report-this-post" post_id="'.$post_id.'" reporting_user="'.$user_id.'" content_type="post" auth_id="'.$auth_id.'" report_nonce="'.wp_create_nonce( 'report_ajax_nonce' ).'">Report Post</a>';
            		echo '</div>';
            		$feed->get_feed_images($post_id);
					echo '<div class="post-data">';
            			echo '<div class="user-info">';
						echo get_avatar( get_the_author_meta( 'ID' ), 32 ); 
            			echo '<p><span><a href="/profile/?user_id='.$user_id.'">'.$name.'</a> on '. $time .'</span></p>';
            			echo'</div>';
            			echo exclude_post_categories('1');
            		
            			// echo '<a href="'.$permlink.'">Read More </a>';
						echo '<p class="excerpt">'.$excerpt.'</p>';
            			echo '<div class="post-info">';

            			$feed->is_faved($user_id,$post_id);
						if ( $comment_count == 0 ) {
            				echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> comment</a>';
            			} elseif ( $comment_count == 1 ) {
            				echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> '.$comment_count.' comment</a>';
            			} else {
							echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> '.$comment_count.' comment</a>';
            				}
            			
            		echo '</div>';
            		echo '</div>';
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
	function profile_all_user_posts() {
		
		  $user = $this->user_info();

		  $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$posts = array(
			'author' => $user,
			'posts_per_page' => 15,
			'post_type' => 'user_journals', 
			'post_status' => 'publish',
			'paged' => $paged,
			);

		$query = new WP_Query( $posts );
			if ( $query->have_posts() ) : ?>
    			<?php while ( $query->have_posts() ) : $query->the_post(); ?>   
        		
            		<?php 
            		$permlink = get_the_permalink();
            		$excerpt = get_the_excerpt();
            		$name = get_the_author_meta('display_name');
            		$time = get_the_time('F jS, Y');
            		$user_id = $this->user_info();
            		$post_id = get_the_ID();
            		$comment_count = wp_count_comments( $post_id );
            		$comment_count = $comment_count->total_comments;

            		echo '<article class="grid-item post" >';
            		$this->get_feed_images($post_id);
					echo '<div class="post-data">';
            			echo '<div class="user-info">';
						echo get_avatar( get_the_author_meta( 'ID' ), 32 ); 
            			echo '<p><span><a href="/profile/?user_id='.$user_id.'">'.$name.'</a> on '. $time .'</span></p>';
            			echo'</div>';
            			echo exclude_post_categories('1');
            		
            			// echo '<a href="'.$permlink.'">Read More </a>';
						echo '<p class="excerpt">'.$excerpt.'</p>';
            			echo '<div class="post-info">';

            			$this->is_faved($user_id,$post_id);
						if ( $comment_count == 0 ) {
            				echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> comment</a>';
            			} elseif ( $comment_count == 1 ) {
            				echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> '.$comment_count.' comment</a>';
            			} else {
							echo '<a class="comments" href="'.$permlink.'"><i class="fas fa-comments"></i> '.$comment_count.' comment</a>';
            				}
            			
            		echo '</div>';
            		echo '</div>';
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

  add_action( 'wp_ajax_get_main_feed', array( 'Feed', 'get_main_feed' ) ); 
  add_action( 'wp_ajax_nopriv_get_main_feed', array( 'Feed', 'get_main_feed' ) );

