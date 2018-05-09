<?php
/*
Template Name: page
*/
?>

<?php get_template_part('templates/header'); ?>




<section class="page">
    <?php $query = new WP_Query( $journals ); if ( $query->have_posts() ) : ?>
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>   

    <article class="post">
        <h1><?php  the_title(); ?></h1>
        <?php the_content(); ?>
    </article>

    <?php endwhile; wp_reset_postdata(); ?>
    <?php else : ?>
    <?php endif;  ?>

</section>


<?php  get_template_part('templates/footer'); ?>
            