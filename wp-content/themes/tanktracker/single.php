<?php
/*
Template Name: default single
*/
?>

<?php get_template_part('templates/header'); ?>
<section class="frame post">
<article class="post">
      <!-- <h2><?php the_title(); ?></h2> -->
     
      <div class="tags"><?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?></div>
      <?php while ( have_posts() ) : the_post(); ?>
      	 <?php 

	  $name = get_the_author_meta('display_name');
	  $time = get_the_time('F jS, Y');
	  $post_id = get_the_ID();
	  	echo '<p class="user-info">';
		echo get_avatar( get_the_author_meta( 'ID' ), 32 ); 
		echo '<span>'.$name.' on '. $time .'</span></p>';
		echo get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'alignleft' ) );
		the_content();

		$feed = new Feed();
		$feed->get_post_images($post_id);


		$args = array(
    'status' => 'approve'
);
 
// The comment Query
$comments = get_comments(array(
        'post_id' => $post->ID,
        'number' => '2' ));
    foreach($comments as $comment) {
        //format comments
    
        echo '<p>' . $comment->comment_author . '<br>';
        echo $comment->comment_content . '</p>';
        // var_dump($comment);

} 



     // comments_template();
comment_form();

		endwhile; ?>
</article>


</section>
<?php get_template_part('templates/footer'); ?>


