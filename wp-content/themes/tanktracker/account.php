<?php
/*
Template Name: My Account
*/
?>

<?php get_template_part('templates/header'); ?>



<?php 
$profile = new Profile();	

$user = $profile->user_info();
$user_id = $user->ID;
?>

<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
<div class="tank_header">
		<h2><?php echo $user->display_name; ?> Account Settings</h2>
		<p></p>
		<?php 
				if ( in_array( 'donor', (array) $user->roles ) ) {
    					echo '<div class="user-info">';
    					echo '<div class="donor">';
            			echo '<div class="donnor-banner"></div>';
							echo get_avatar( $user_id ); 
						echo '</div>';
						echo '</div>';
						echo '<p>You have a Donor Level Account</p><p>Thanks for being a donor! We appreciate it very much!</p>';
					} elseif ( in_array( 'administrator', (array) $user->roles ) || in_array( 'moderator', (array) $user->roles ) ) {

						echo '<div class="user-info">';
						echo get_avatar( $user_id ); 
						echo '</div>';
						echo '<p>You have a Moderator/Admin account</p>';

					} else {
						echo '<div class="user-info">';
						echo get_avatar( $user_id ); 
						echo '</div>';
						echo '<p>You have a Basic Account</p>';

					}

		 ?>
		<p></p>
		<div class="accout-actions third">
			<a class="btn" target="_blank" href="https://en.gravatar.com/">Change Avatar</a>
			<a class="btn" href="/pass-reset/">Reset Password</a>
		</div>
		<?php 

		 ?>
	</div>
</section>

<?php get_template_part('templates/footer'); ?>
<?php get_template_part('templates/feed-scripts'); ?>


