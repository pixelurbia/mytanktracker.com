<?php
/*
Template Name: Overview
*/
?>

<?php get_template_part('templates/header'); ?>



<?php 
//tank object start
$tank_id = $_GET['tank_id'];
$user_tanks = new Tanks();
$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;	
$user = $user_tanks->user_info();
?>

<div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>

<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
	<div class="tank_header">
		<h2><?php echo  $tank[0]->tank_name ?></h2>
		<p>
			<?php
				if ($tank[0]->tank_volume) {
					echo  '<span>Volume: '.$tank[0]->tank_volume.' Gallons </span>';
				} 
				if ($tank[0]->tank_dimensions){
					echo '<span>Dimensions: '.$tank[0]->tank_dimensions.'</span>';
				}
				if ($tank[0]->tank_model){
					echo '<span>Model: '.$tank[0]->tank_model.'</span>';
				}
				if ($tank[0]->tank_make){
					echo '<span>Make: '.$tank[0]->tank_make.'</span>';	
				}
			?> 
			</p>
        <!-- 	 <form id="photo-form" method="post">
		<input type="hidden" name="action" value="add_user_photo">
		<?php echo '<input type="hidden" name="tank_id" value="'.$tank_id.'">' ?>
		<?php echo '<input type="hidden" name="user_id" value="'.$user.'">' ?>
		<?php wp_nonce_field('ajax_form_nonce_photo','ajax_form_nonce_photo', true, true ); ?>
			<a class="option-btn add-photo-btn" >
            	<label class="tank-img" for="photo-img">
            		<i class="fas fa-images"></i>   	
            		<i class="text">Add Image</i>
            	</label>
         
            	<input type="file" name="file_upload" id="photo-img" class="inputfile hide" accept="image/*" />
        	</a>
   </form>     -->
	</div>

		<section class="feed half" id="feed">
<!-- 		<p class="page-subnav">
			<a>All Posts / </a>
			<a>Images </a>
		</p> -->
		<?php 
			$feed = new Feed();
			$feed->get_tank_feed($tank_id); 
			?>


</section>	

		<section class="third recent_params">
			<h3>Most Recent Parameters</h3>
		<?php 
    	$params = new Parameters();
        $params->most_recent_param_list($tank_id);

		 ?>
	</section>
	
										
	</div>
</section>



<script type="text/javascript">

	var ias = $.ias({
     container: "#feed",
     item: ".post",
      pagination: '#pagination',
    next:       '#pagination a.next'
   });


    
  ias.extension(new IASTriggerExtension({offset: 9999}));
   // ias.extension(new IASSpinnerExtension());
   ias.extension(new IASNoneLeftExtension());
   ias.extension(new IASSpinnerExtension({
     html: '<div class="ias-spinner-idea" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>'
}));
</script>


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

<script type="text/javascript">
	ias.on('rendered', function(items) {
	$('.fave').click(function(event) { 
		event.preventDefault(); // Prevent the default
		
		if ($(this).hasClass('static')) {
			var action = 'un_favorite_post';
			$(this).removeClass('static');
		} else {
			var action = 'favorite_post';
			$(this).addClass('static');
          	$(this).html('<i class="fas fa-heart"></i> Faved');
		}
	
		var ref_id = $(this).attr('ref_id');
		var fav_ajax_nonce = $(this).attr('fav_ajax_nonce');
		var user = $(this).attr('user');
    	// console.log(ref_id);        
		var data = {ref_id: ref_id, user: user, action: action, fav_ajax_nonce: fav_ajax_nonce};


      console.log(data);
      //Custom data
      // data.append('key', 'value');
      $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
          	console.log('success');

          },
          error: function (e) {
              //error
			console.log('error 124');
			console.log(data);
          }
      });
	});
})
</script>