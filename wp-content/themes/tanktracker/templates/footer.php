</section>
<?php 
$environment = set_env(); 
if ( $environment == 'DEV'){
	// echo '<div class="admin-bar">You are in '.$environment.	' - Tank Tracker Alpha </div>'; 
}
?>

<div class="footer">
	<link href="<?php echo get_template_directory_uri(); ?>/js/darkroom/darkroom.css" rel="stylesheet" />
	<script src="<?php echo get_template_directory_uri(); ?>/js/darkroom/fabric.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/darkroom/darkroom.js"></script>
</div>
<?php wp_footer(); ?>
</div>
</body>
</html>
