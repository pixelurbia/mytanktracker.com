<?php
/*
Template Name: Donations
*/
?>

<?php get_template_part('templates/header'); ?>
<section class="frame page">

<article class="page">
	<h2><?php the_title(); ?></h2>
	<br><br><br>
	 <div class="tags"><?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?></div>
      <?php while ( have_posts() ) : the_post(); ?>
      	 <div class="main_content">
      	 <?php 

		the_content();

		endwhile; ?>
		</div>
	<br><br><br>
<script src="https://donorbox.org/widget.js" paypalExpress="true"></script><iframe src="https://donorbox.org/embed/tanktracker-donations?show_content=true" height="685px" width="100%" style="max-width:100%; min-width:100%; max-height:none!important" seamless="seamless" name="donorbox" frameborder="0" scrolling="no" allowpaymentrequest></iframe>

</article>


</section>
<?php get_template_part('templates/footer'); ?>


