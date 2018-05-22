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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



	<script src="<?php echo get_template_directory_uri(); ?>/js/master.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/register-master.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/add-tank.js"></script>

	<script src="<?php echo get_template_directory_uri(); ?>/js/fontawesome-all.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/charts/dist/chart.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/validate/core.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<?php wp_head(); ?>


</head>
<body <?php body_class(); ?>>
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
	<div class="global-error"></div>
<div class="global-suc"></div>
	<div class="menu-bar">
		<div class="main-menu">
			<a class="menu-button"><i class="fas fa-bars"></i></a>
			<a class="journals-btn"><i class="fas fa-pencil-alt"></i></a>
			<!-- <a class="menu-button menu-button-open">Menu</a> -->
			<!-- <a class="menu-button menu-button-close">Close</a> -->
		</div>

		<div class="secondary_menu">			
			<a name="" href="/tanks" class="">My Tanks</a>
			<?php smart_menu($tank_id); ?>
			<a name="" href="https://discord.gg/xPtgFuG" class="">Tank Tracker Community</a>

			<span></span>
			
			<a name="" href="/" class="">My Profile</a>
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


 <form id="journal-form" method="post">
		<input type="hidden" name="action" value="add_journal">
		<?php echo '<input type="hidden" name="tank_name" value="'.$tanks[0]->tank_name.'">' ?>
		<?php echo '<input type="hidden" name="user_id" value="'.$curuser.'">' ?>
		<?php wp_nonce_field('ajax_form_nonce_journal','ajax_form_nonce_journal', true, true ); ?>
		<div contenteditable="true" class="status" id='j-status'  >
				<i>What is goin on today?</i>
		</div>
		<img id="output">	
		<input id="status-content" type="text-area" class="hide" name="journal" value="">
		<select>
			<option >Is this update for a specific tank?</option>
			<?php 
				$user_tanks = new Tanks();
				$tanks = $user_tanks->list_of_tanks();
				// var_dump($tanks);
				foreach ($tanks as $tank) {
					echo '<option value="'.$tank->id.'">'.$tank->tank_name.'</option>';
				}	
			 ?>
		</select> 
		<fieldset>
			<label class="button tank-img" for="journal-img"><i class="fas fa-images"></i></label>
			<input type="file" name="file_upload" id="journal-img" class="inputfile hide" accept="image/*" onchange="loadImg(event)"/>
			<button type="submit" name="submit">
			<i class="fas fa-paper-plane"></i>
		</button>
		</fieldset>
    </form>

<script type="text/javascript">
	//script for journal output form
	var loadImg = function(event) {
		var output = document.getElementById('output');
		output.src = URL.createObjectURL(event.target.files[0]);
	};
</script>


<div class="overlay"></div>
