///////////////////
// feed JS File
// by Andy 
///////////////////
$(document).ready(function() {

$('.category-filter a').click( function(){
	
	var cats = $(this).attr('value');
	$(this).parent().find('.current').removeClass('current');
  	$(this).addClass('current');
	
	var data = {action: 'get_main_feed', cats: cats};

      console.log(data);
      //Custom data
      // data.append('key', 'value');
      $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
              // console.log(data);
          	console.log('success');
          	$('.feed.full').html(data);
          		jQuery.ias().destroy();
          		var ias = $.ias({
     				container: "#feed",
     				item: ".post",
      				pagination: '#pagination',
    				next:'#pagination a.next'
   				});	
          	// $('.feed.full').html('');

          },
          error: function (e) {
              //error
			console.log('error 124');
			console.log(data);
          }
      });

});



//Favorites
$('.wrap').on("click", ".fave", function(event){
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




});