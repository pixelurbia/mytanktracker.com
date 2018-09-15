
$(document).ready(function() {



    $( '#trello-form' ).submit( function( event ) {
            
      event.preventDefault(); // Prevent the defau

      var data = new FormData();
      
      //Form data
      var form_data = $(this).serializeArray();
      $.each(form_data, function (key, input) {
          data.append(input.name, input.value);
      });
      
      for (var pair of data.entries()) {
          console.log(pair[0]+ ', ' + pair[1]); 
      }

      var spinner ='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';
      $('.overlay').after(spinner);
      
      //Custom data
      // data.append('key', 'value');
      $.ajax({
          url: ajaxurl,
          method: "post",
          processData: false,
          contentType: false,
          data: data,
          success: function (data) {
              //success
          // console.log(data);
          $('.spinner-loader').remove();
          $('.global-suc').html('Thank you for your report.');
          $('.global-suc').fadeToggle();
          $('.global-suc').delay( 2000 ).fadeToggle();
          var delay = 2200; 
            setTimeout(function(){ window.location = '/tanks/'; }, delay);
          },

          error: function (e) {
              //error
      
          }
      });


});
});
