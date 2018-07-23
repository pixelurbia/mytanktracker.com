<?php
/*
Template Name: My Account
*/
?>

<?php get_template_part('templates/header'); ?>



<?php 
$profile = new Profile();
$feed = new Feed();

$user = $profile->user_info();
// $user = $profile->user_info('display_name');
?>

<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
	<h3>Work in progresss</h3>
</section>

<?php get_template_part('templates/footer'); ?>
<?php get_template_part('templates/feed-scripts'); ?>
