<?php
/*
Template Name: page
*/
?>

<?php get_template_part('templates/header'); ?>
<section class="frame page">
<article class="page">
	<h2><?php the_title(); ?></h2>
     <br>
     <br>
     <br>
      <div class="tags"><?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?></div>
      <?php while ( have_posts() ) : the_post(); ?>
      	 <?php 

		the_content();

		endwhile; ?>
</article>


</section>
<?php get_template_part('templates/footer'); ?>


