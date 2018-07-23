<!DOCTYPE HTML>
<html class="no-js" lang="en" >

<head>
	<title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" href=""/>
	<link rel="icon" type="image/x-icon" href="" />
  	<!-- //libs -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ias.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/polyfill.js"></script>
	<!-- TT specific -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/master.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/register-master.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/add-tank.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/add-photo.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/feed.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/add-stock.js"></script>

	<link href="<?php echo get_template_directory_uri(); ?>/js/select/select2.css" rel="stylesheet" />
	<script src="<?php echo get_template_directory_uri(); ?>/js/select/select2.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/fontawesome-all.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/charts/dist/chart.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/validate/core.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/cropie/croppie.min.js"></script>
	<link href="<?php echo get_template_directory_uri(); ?>/js/cropie/croppie.css" rel="stylesheet" />

	
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<?php wp_head(); ?>


</head>
<body <?php body_class(); ?>>
	<div class="global-error"></div>
	<div class="global-suc"></div>
	<div class="global-message">
		<p class="message">Are you sure you want to delete this entry?</p>
		<div class="option-btn-container">
			<a class="option-btn confirmation-btn">Yes</a>
			<a class="option-btn message-action">No</a>
		</div>
	</div>
<?php 
     


      if(!is_user_logged_in()) {  
      	 $logged_in = false;
		} else {
		 $logged_in = true;
			 } 
			 if ($logged_in == true){
	
	$tank_id = $_GET['tank_id'];
	$user_tanks = new Tanks();
	$tank = $user_tanks->get_tank_data($tank_id);	
	$tank_id = $tank[0]->tank_id;
	$user = $user_tanks->user_info();
 ?>


	<div class="menu-bar">
		<div class="main-menu">
			<a class="menu-button"><i class="fas fa-bars"></i></a>
			<a class="journals-btn"><i class="fas fa-pencil-alt"></i></a>
			<a target="_blank" href="https://trello.com/b/lc0xTRgJ/tank-tracker-bug-tracker">Report Bugs</a>
			<!-- <a class="menu-button menu-button-open">Menu</a> -->
			<!-- <a class="menu-button menu-button-close">Close</a> -->
		</div>

		<div class="secondary_menu">			
			<a name="" href="/tanks" class="">My Tanks</a>
			<?php smart_menu($tank_id); ?>
			<a name="" href="/community" class="">Tank Tracker Community</a>
			<a name="" href="https://discord.gg/xPtgFuG" class="">Tank Tracker Discord</a>

			<span></span>
			
			<a href="/profile?user_id=<?php echo $user?>"  class="">My Profile</a>
			<a name="myaccount" href="/my-account" class="myaccount">My Account</a>
			<?php  echo '<a href="'.wp_logout_url('$index.php').'">Logout</a>'; ?>
		
		</div>
	</div>
	

	

<section class="wrap">
<?php }  
		$login = $_GET['login'];
		if (isset( $login ) && $login == 'failed') { 
			echo '<div class="global-error show">The username or password you provided did not match our records.</div>';
		}
			?>


 <form id="journal-form" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="add_journal">
		<?php echo '<input type="hidden" name="user_id" value="'.$user.'">' ?>
		<?php wp_nonce_field('ajax_form_nonce_journal','ajax_form_nonce_journal', true, true ); ?>
		<div class="post-content-wrap">
			<select class="js-example-basic-multiple" name="tanks[]" multiple="multiple">
			<?php 
				$user_tanks = new Tanks();
				$user_stock = new Stock();
				$tanks = $user_tanks->list_of_tanks();
				$stocks = $user_stock->list_of_livestock();
				// var_dump($tanks);
				foreach ($tanks as $tank) {
					echo '<option value="'.$tank->tank_id.'">'.$tank->tank_name.'</option>';
				}	
				foreach ($stocks as $stock) {
					echo '<option value="'.$stock->stock_id.'">'.$stock->stock_name.'</option>';
				}	
			 ?>
		</select> 
			<div contenteditable="true" class="status" id='j-status'>
				<i>What is goin on today?</i>
			</div>
			<div class="post-images"></div>
		</div>
		
		<input id="status-content" type="text-area" class="hide" name="journal" value="" >
		

		<fieldset>
			<label class="button tank-img" for="journal-img"><i class="fas fa-images"></i></label>
			<input type="file" name="file_upload[]" multiple="" id="journal-img" class="inputfile hide" accept="image/*" onchange="loadImg(event)"/>
			<button type="submit" name="submit">
			<i class="fas fa-paper-plane"></i>
		</button>
		</fieldset>
    </form>



<script type="text/javascript">
	//script for journal output form to show images 
	var loadImg = function(event) {

		var files = event.target.files;
		console.log(files);

		var fileCount = 0;
	for (var i = 0, f; f = files[i]; i++) {
			console.log(files[i]);
			var outSrc = URL.createObjectURL(event.target.files[i]);		

    		console.log('eh?');
    		var imgData = '<div class="img-contain"><img class="img_'+fileCount+'" src="'+outSrc+'"></div>';
        	$('.post-images').append(imgData);
		}
		
	};
</script>


<div class="overlay"></div>
