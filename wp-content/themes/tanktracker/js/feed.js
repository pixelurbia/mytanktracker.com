///////////////////
// feed JS File
// by Andy 
///////////////////
$(document).ready(function() {


$('.wrap').on("click", ".post-options", function(){ 
	$(this).parent().find('.post-options-menu').fadeToggle();
});
$('.wrap').on("click", ".report-this-post", function(){ 
	  console.log('report');

	var ref_id = $(this).attr('post_id');
	var reporting_user_id = $(this).attr('reporting_user');
	var author_id = $(this).attr('auth_id');
	var report_ajax_nonce = $(this).attr('report_nonce');
	var content_type = $(this).attr('content_type');
 
	var data = {action: 'mod_log', ref_id: ref_id, content_type: content_type,reporting_user_id: reporting_user_id, author_id: author_id, report_ajax_nonce: report_ajax_nonce};


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
          	$('.post-options-menu').hide();
					$('.global-suc').html('Thank you for your report.');
					$('.global-suc').fadeToggle();
  					$('.global-suc').delay( 2000 ).fadeToggle();

          },
          error: function (e) {
              //error
			console.log('error 97897');
			console.log(data);
          }
      });


});

$('.category-filter a').click( function(){


var cats = $(this).attr('value');
//https://samaxes.com/2011/09/change-url-parameters-with-jquery/
/*
 * queryParameters -> handles the query string parameters
 * queryString -> the query string without the fist '?' character
 * re -> the regular expression
 * m -> holds the string matching the regular expression
 */
var queryParameters = {}, queryString = location.search.substring(1),
    re = /([^&=]+)=([^&]*)/g, m;

// Creates a map with the query string parameters
while (m = re.exec(queryString)) {
    queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
}

// Add new parameters or update existing ones
queryParameters['cats'] = cats;

/*
 * Replace the query portion of the URL.
 * jQuery.param() -> create a serialized representation of an array or
 *     object, suitable for use in a URL query string or Ajax request.
 */
location.search = $.param(queryParameters); // Causes page to reload

	// jQuery.ias().destroy(); //destory current ias instance
	// // $.ias("destroy")
	// var cats = $(this).attr('value');
	// $(this).parent().find('.current').removeClass('current');
 //  	$(this).addClass('current');
	
	// var data = {action: 'get_main_feed', cats: cats};

 //      console.log(data);
 //      //Custom data
 //      // data.append('key', 'value');

 //      $.ajax({
 //          url: ajaxurl,
 //          method: "post",
 //          data: data,
 //          success: function (data) {
 //              //success
 //              // console.log(data);
 //          	console.log('success');

 //          	$('.feed.full').html(data);
 //  			ias.bind();
	
 //          	// $('.feed.full').html('');

 //          },
 //          error: function (e) {
 //              //error
	// 		console.log('error 124');
	// 		console.log(data);
 //          }
 //      });

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