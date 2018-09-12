<?php
/*
Template Name: page
*/
?>

<?php get_template_part('templates/header'); ?>
<section class="frame page">
<article class="page">
	<h2><?php the_title(); ?></h2>
     
      <div class="tags"><?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?></div>
      <?php while ( have_posts() ) : the_post(); ?>
      	 <?php 

	  $name = get_the_author_meta('display_name');
	  $time = get_the_time('F jS, Y');
	  $post_id = get_the_ID();
	  	echo '<p class="user-info">';
		echo '<span>Last updated on '. $time .'</span></p>';
		the_content();

		endwhile; ?>
</article>


</section>
<?php get_template_part('templates/footer'); ?>


