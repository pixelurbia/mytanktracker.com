<?php
/*
Template Name: mod tools
*/
?>

<?php get_template_part('templates/header'); ?>


<?php 
$secure = new Security();
?>


<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
	<div class="tank_header">
		<h2>Mod Tools</h2>
		<p class="page-subnav">
			<a>To Review / </a>
			<a>approved / </a>
			<a>removed</a>
		</p>
		
	</div>

	<section class="full">
		<?php 
			$secure->reported_posts();
		?>
	</section>	
	
</section>

<?php get_template_part('templates/footer'); ?>

