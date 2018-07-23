///////////////////
// add tank workflow JS File
// by Andy 
///////////////////


$(document).ready(function() {
      

Object.entries = function( obj ){ 
    var ownProps = Object.keys( obj ),
        i = ownProps.length,
        resArray = new Array(i); // preallocate the Array
    while (i--)
      resArray[i] = [ownProps[i], obj[ownProps[i]]];

    return resArray;
};
     

//skip Tank add
  $('#skip-add-tank').click(function() { 
    tankForm();
  }); 


//show the add tank form on the tanks page
  $('.add-tank').click(function() { 
    $('.add-tank-form').toggleClass('extended');
    $('.overlay').fadeToggle();
    $('.menu-bar').toggleClass('extended-more');
  }); 
  
//edit tank




//Add Tank register
    $( '#tank-form' ).submit( function( event ) {
            
      event.preventDefault(); // Prevent the defau
      //form validation 
      // var tank_name = $('#tank-form .tank-name').val();

      if (!$('#tank-form .tank-name').val()) {
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
  $('.step-three').delay( 400 ).fadeIn();
  $('.step-three').css('height','570px');
  var delay = 1500; 
  setTimeout(function(){ window.location = '/tanks/'; }, delay);
}


//update tank data
//show the add tank form on the tanks page
  $('.edit-tank').click(function() { 
      var parent = $(this).parent().parent();
      parent.find('.tank_info').attr('contenteditable','true');
      parent.find('.tank_info').toggleClass('tankEditable');
      $(this).hide();
      parent.find('.save-edit-tank').show();
      parent.parent().find('.image-change').show();

  }); 

  $('.save-edit-tank').click(function() { 
      var tank_id = $(this).attr('tank_id'),
      nonce = $(this).attr('nonce'),
      parent = $(this).parent().parent(),
      tank_name = parent.find('.tank_name').html(),
      tank_volume = parent.find('.tank_volume').html(),
      tank_dimensions = parent.find('.tank_dimensions').html(),
      tank_model = parent.find('.tank_model').html(),
      tank_make = parent.find('.tank_make').html();
 

    data = {action:'update_user_tank',ajax_form_nonce_update_tank: nonce, tank_id: tank_id, tank_name: tank_name, tank_volume: tank_volume, tank_dimensions: tank_dimensions, tank_model: tank_model, tank_make: tank_make};

    console.log(data);

        $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
            console.log('Entry Updated');
            tankForm();
          },
          error: function (e) {
              //error
            console.log('Eror 976524');
      
          }
      });
  }); 






});
