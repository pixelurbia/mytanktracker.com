<?php
/*
Template Name: default single
*/
?>

<?php get_template_part('templates/header'); ?>

<section class="frame post">



      <!-- <h2><?php the_title(); ?></h2> -->
<article class="post">
      <div class="tags"><?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?></div>
      <?php while ( have_posts() ) : the_post(); ?>
      	 <?php 

      	 $edit_mode = $_GET['edit'];
$auth_id = get_the_author_meta('id');
$current_user = wp_get_current_user();
$user_id = $current_user->ID;


	  $name = get_the_author_meta('display_name');
	  $time = get_the_time('F jS, Y');
	  $post_id = get_the_ID();
		$auth_id = get_the_author_meta('id');

	  	echo '<p class="user-info">';
		echo get_avatar( get_the_author_meta( 'ID' ), 32 ); 
		
		echo '<span><a href="/profile/?user_id='.$auth_id.'">'.$name.'</a> on '. $time .'</span>';
		echo get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'alignleft' ) );
		echo '<div class="the_post_content ';
		if ($edit_mode == 'yes' && $auth_id == $user_id){ 
			echo ' editable" contenteditable="true">'; 
		} else {
		echo '">';	
		}
		
		the_content();
		echo '</div>';
		if ($edit_mode == 'yes' && $auth_id == $user_id){ 
			 echo '<a class="post-action save-user-post" nonce="'.wp_create_nonce("ajax_form_nonce_save_post").'" post_id="'.$post_id.'"><i class="fas save-post larger-icon fa-save"></i> Save Post</a>';
		}
		$feed = new Feed();
		$feed->get_post_images($post_id);


		$args = array(
    'status' => 'approve'
);
 
// The comment Query
$comments = get_comments(array(
        'post_id' => $post->ID,
        'number' => '2' ));
echo '</article>';
echo '<br>';
echo '<br>';
echo '<article class="post">';
echo '<h3>Comments</h3>';
echo '<br>';
    foreach($comments as $comment) {
        //format comments
        // var_dump($comment);
        echo '<div class="comment">';
  
        	echo '<a class="post-options"><i class="fas fa-ellipsis-v"></i></a>';
            		echo '<div class="post-options-menu">';
            			echo '<a class="report-this-post" post_id="'.$comment->comment_post_ID.'" comment_id="'.$comment->comment_ID.'" reporting_user="'.$user_id.'" auth_id="'.$comment->post_author.'" content_type="comment" report_nonce="'.wp_create_nonce( 'report_ajax_nonce' ).'">Report Post</a>';
            		echo '</div>';
			echo '<p class="comment-owner">'.$comment->comment_author . '<p>';
        	echo '<p>'.$comment->comment_content . '</p>';
        echo '</div>';
} 



     // comments_template();
comment_form();

		endwhile; ?>
</article>


</section>
<?php get_template_part('templates/footer'); ?>


