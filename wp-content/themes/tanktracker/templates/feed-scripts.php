
<script type="text/javascript">

	var ias = $.ias({
     container: "#feed",
     item: ".post",
      pagination: '#pagination',
    next:'#pagination a.next'
   });


    
  ias.extension(new IASTriggerExtension({offset: 9999}));
   // ias.extension(new IASSpinnerExtension());
   ias.extension(new IASNoneLeftExtension());
   ias.extension(new IASSpinnerExtension({
     html: '<div class="ias-spinner-idea" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>'
}));
</script>
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