<?php
/*
Template Name: Home Page
*/
?>


<?php get_template_part('templates/header'); ?>

<div class="content-wrap wow fadeInLeft">
    <div class="row bo">    
         <?php while ( have_posts() ) : the_post(); ?>
               <div class="home-overlay">
                        <?php the_content(); ?>
                        Tank Tracker v 0.1
                    </div>
        <?php endwhile; ?>
    </div>
</div>

<?php get_template_part('templates/footer'); ?>