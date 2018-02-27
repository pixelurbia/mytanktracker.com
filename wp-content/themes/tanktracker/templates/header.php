<!DOCTYPE HTML>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]--> 
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]--> 
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]--> 
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]--> 
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->

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
	<script src="<?php echo get_template_directory_uri(); ?>/js/fontawesome-all.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/charts/dist/chart.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/validate/core.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
	<?php wp_head(); ?>


</head>
<?php 




	if(!is_user_logged_in()) { 

		?>

<section class="full">
	<section class="frame">
		<div class="buffer-50"></div>		
		<div class="reg-form">
		<div class="logo"></div>
		<!-- 	<div class="tank-menu">
					<a  href="/register/">Register</a>|
					<a class="login-header">Login</a>'			
			</div> -->
	<?php	wp_login_form(); 
	echo '<a class="register" href="/register/">Need an Account? Register Today!</a> ';
	echo '<a class="register" href="/password-reset//">Forgot Password?</a> ';
	?>
		</div>
		</section>
		</section>
<?php
		} else {

	global $wpdb;
    $current_user = wp_get_current_user(); 
    $curuser = $current_user->ID;

    if( !isset( $_GET['tank_id'] )){
        $tank_id = 1;
    } else {
        $tank_id = $_GET['tank_id'];
    }
 ?>
	
	<div class="menu-bar">
		<div class="menu-button"></div>
	</div>
	<div class="main-menu">
		<a name="" href="/tanks" class="">My Tanks</a>
		<a name="tanks" href="/overview<?php echo '?tank_id='.$tank_id; ?>" class="overview">Overview</a>
			<a name="parameters" href="/parameters<?php echo '?tank_id='.$tank_id; ?>" class="parameters">Parameters</a>
			<a name="stock" href="/stock<?php echo '?tank_id='.$tank_id; ?>" class="stock">Stock</a>
			<a name="equipment" href="/equipment<?php echo '?tank_id='.$tank_id; ?>" class="equipment">Equipment</a>	
		<a name="" href="/" class="">Community</a>	
		<br>
		<br>
		<a name="myaccount" href="/my-account" class="myaccount">My Account</a>
		<a name="" href="/" class="">Linked Accounts</a>
		<?php  echo '<a href="'.wp_logout_url('$index.php').'">Logout</a>'; ?>
		
	</div>
<body <?php body_class(); ?> >

<?php 
 
				if( !isset( $_GET['tank_id'] )){
					$tank_id = 1;
				} else {
					$tank_id = $_GET['tank_id'];
				}


 ?>

<section class="wrap">

	<?php } ?>
<div class="form-contain">
	<a class="track-btn close"><i class="fas fa-times"></i></a>
	<form id="ajax-form" class="param-form" method="post">

                            <input type="hidden" name="action" value="param_form">
                            <?php echo '<input type="hidden" name="tank_id" value="'.$tank_id.'">' ?>
                        	<?php echo '<input type="hidden" name="user_id" value="'.$curuser.'">' ?>
                        	 <?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
                        	<input type="text" name="value" placeholder="Value">
                            <select type="select" name="type">
                                <option value="Parameter" >Parameter</option>
                                <option shortname="SG" name="Salinity" value="1">Salinity</option>
                                <option shortname="pH" name="PH" value="2">PH</option>
                                <option shortname="dKH" name="Alkalinity-Dkh" value="3">Alkalinity/Dkh</option>
                                <option shortname="NH3" name="Ammonia" value="4">Ammonia</option>
                                <option shortname="NO2" name="Nitrites" value="5">Nitrites</option>
                                <option shortname="NO3" name="Nitrates" value="6">Nitrates</option>
                                <option shortname="F" name="Tempature" value="7">Tempature</option>
                                <option shortname="Mg" name="Magnisium" value="8">Magnisium</option>
                                <option shortname="Ca" name="Calcium" value="9">Calcium</option>
                                <option shortname="TDS" name="TDS" value="10">TDS</option>
                                <option shortname="Po4" name="Phosphates" value="11">Phosphates</option>
                            </select>
                        	<input type="submit" name="submit" value="Log">
	</form>
</div>
<div class="overlay"></div>
