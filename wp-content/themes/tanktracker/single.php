<?php
/*
Template Name: default single
*/
?>

<?php get_template_part('templates/header'); ?>

<div class=" single wow fadeInLeft">
  <div class="row">             
    <div class="contentwrap">
      <h1><?php the_title(); ?></h1>
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </div><!--contentwrap-->

  </div>
</div>
<?php get_template_part('templates/footer'); ?>