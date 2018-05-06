///////////////////
// add tank workflow JS File
// by Andy 
///////////////////


$(document).ready(function() {
      

//skip Tank add
  $('#skip-add-tank').click(function() { 
    tankForm();
  }); 


//show the add tank form on the tanks page
  $('.add-tank').click(function() { 
    $('.form-contain').fadeToggle();
    $('.overlay').fadeToggle();
  }); 

//Add Tank register
    $( '#tank-form' ).submit( function( event ) {
            
      event.preventDefault(); // Prevent the defau
      //form validation 
      var tank_name = $('#tank-form .tank-name').val();

      if (tank_name == null) {
             $('.global-error').html('Your tank needs a name.');
             $('.global-error').addClass('show');
            return;
        } else {
             $('.global-error').removeClass('show');
        }

      var username = $('#regi-form .username').val();
      $('#tank-form .verfication').attr('value', username);

      console.log($('#tank-form .verfication').val());

      var data = new FormData();
      
      //Form data
      var form_data = $('#tank-form').serializeArray();
      $.each(form_data, function (key, input) {
          data.append(input.name, input.value);
      });
      
      //File data
      var file = $('#tank-img')[0].files[0];
      data.append("file", file);
      
      for (var pair of data.entries()) {
          console.log(pair[0]+ ', ' + pair[1]); 
      }
      
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
          tankForm();
          },
          error: function (e) {
              //error
      
          }
      });

      // $.post( 
   //              ajaxurl,
   //              data,
   //              function(data) { 
   //                // location.reload();
   //                  console.log(data);
   //              })
            });


function tankForm(){
  // console.log('reg and login work');
  $('.frost').fadeOut();
  // $('.step-three').delay( 400 ).fadeIn();
  var delay = 1500; 
  setTimeout(function(){ window.location = '/tanks/'; }, delay);
}




});
