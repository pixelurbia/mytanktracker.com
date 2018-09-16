<?php
/*
Template Name: My Account
*/
?>

<?php get_template_part('templates/header'); ?>



<?php 
$profile = new Profile();	

$user = $profile->user_info();
?>

<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
<div class="tank_header">
		<h2><?php echo $user->display_name; ?> Account Settings</h2>
		<p></p>
		<a href="">Reset Password</a>
		<?php 
		donorbox_status();
		 ?>
	</div>
</section>

<?php get_template_part('templates/footer'); ?>
<?php get_template_part('templates/feed-scripts'); ?>


