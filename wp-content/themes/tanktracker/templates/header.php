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
  	<!-- //Jquery Source -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!-- //Infinate scroll -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ias.min.js"></script>
	<!-- //poly fill for older browser support -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/polyfill.js"></script>
	<!-- //select 2 -->
	<link href="<?php echo get_template_directory_uri(); ?>/js/select/select2.css" rel="stylesheet" />
	<script src="<?php echo get_template_directory_uri(); ?>/js/select/select2.js"></script>
	<!-- //FontAwesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!-- //charts -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/charts/dist/chart.js"></script>
	<!-- //Validation -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/validate/core.js"></script>
	<!-- //Image Croppping -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/cropie/croppie.min.js"></script>
	<link href="<?php echo get_template_directory_uri(); ?>/js/cropie/croppie.css" rel="stylesheet" />
	<!-- TT specific -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/master-min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/chart-handlers.js"></script>
	<!-- //Google fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">


<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-125182216-1');
</script>


	<?php wp_head(); ?>

<!-- FAVICONS -->
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-16x16.png">
<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/images/favicons/site.webmanifest">
<link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

</head>
<body <?php body_class(); ?>>
	<div class="global-error"></div>
	<div class="global-suc"></div>
	<div class="global-message">
		<p class="message">Are you sure you want to delete this entry?</p>
		<div class="option-btn-container">
			<a class="option-btn confirmation-btn">Yes</a>
			<a class="option-btn close-message-action">No</a>
		</div>
	</div>
	<?php 
     
	$tank_id = $_GET['tank_id'];
	$user_tanks = new Tanks();
	$tank = $user_tanks->get_tank_data($tank_id);	
	$tank_id = $tank[0]->tank_id;
	$user = $user_tanks->user_info();

	smart_menu(); 

	?>

<section class="wrap">
<?php 
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
			<select class="tankstock-js-example-basic-multiple js-example-basic-multiple" name="tanks[]" multiple="multiple">
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
		<select class="cat-js-example-basic-multiple js-example-basic-multiple" name="cats[]" multiple="multiple">
			<?php 
				$cats = $user_tanks->cats();
				foreach ($cats as $cat) {
					echo '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';
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

  // var files = $('#journal-img')[0].files;
  var files = event.target.files;

  for (var i = 0; i < files.length; i++) {

    fileSize = files[i].size;
    var fileCount = 0;

  if(fileSize > 10000000){
    alert("You have exceeded the maximum file upload size for one or more of your images. Please correct this before submiting.");
    	$('#journal-img').value = '';
    	$('#post-images').html('');
} else {

			console.log(files[i]);
			var outSrc = URL.createObjectURL(event.target.files[i]);		

    		console.log('eh?');
    		var imgData = '<div class="img-contain"><img class="img_'+fileCount+'" src="'+outSrc+'"></div>';
        	$('.post-images').append(imgData);
		}
	}
		
		
	};

	 function closeGlobalMessage() { 
	$('.global-message').fadeToggle();
    $('.overlay').fadeToggle();
}

</script>


<div class="overlay"></div>

