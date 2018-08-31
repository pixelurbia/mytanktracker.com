<?php
/*
Template Name: profile
*/
?>

<?php get_template_part('templates/header'); ?>



<?php 
$profile = new Profile();
$feed = new Feed();
$user = $_GET['user_id'];
$user = get_userdata($user);

$user = get_userdata($user->ID);
// $user = $profile->user_info('display_name');

?>

<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
	<div class="tank_header">
		<h2><?php echo $user->display_name; ?></h2>
		<p><?php echo '<span>'.$profile->get_params($user->ID) .' Parameters Logged</span>';	?></p>
		<p><?php echo '<span>'.$profile->get_tanks($user->ID) .' Tanks Active</span>';	?></p>
		<p><?php echo '<span>Member since '.$user->user_registered .'</span>';		?></p>
	</div>

	
<section class="third">
	<?php 
	echo $profile->list_tanks($user->ID); ?>
</section>
<section class="half feed" id="feed">
	<?php 
	echo $feed->profile_all_user_posts($user->ID); ?>
</section>
										
	</div>
</section>


<div class="reminder form-contain">
    <a class="close"><i class="fas fa-times"></i></a>
    <form id="ajax-form" class="param-form" method="post">
		<input type="hidden" name="action" value="reminder_form">
		<?php echo '<input type="hidden" name="tank_id" value="'.$tank_id.'">' ?>
		<?php echo '<input type="hidden" name="user_id" value="'.$curuser.'">' ?>
		<?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
		<input type="text" name="Reminder" placeholder="Reminder">
		<input type="date" name="Reminder" >
		<input type="submit" name="submit" value="Log">
    </form>
</div>

<?php get_template_part('templates/footer'); ?>
<?php get_template_part('templates/feed-scripts'); ?>
