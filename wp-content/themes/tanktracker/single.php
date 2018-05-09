<?php
/*
Template Name: default single
*/
?>

<?php get_template_part('templates/header'); ?>
<section class="frame post">
<article class="post">
      <h2><?php the_title(); ?></h2>
      <div class="tags"><?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?></div>
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
</article>


</section>
<?php get_template_part('templates/footer'); ?>


