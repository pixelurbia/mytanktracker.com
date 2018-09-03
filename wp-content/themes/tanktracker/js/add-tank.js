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




//Add Tank & register
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
  var delay = 1500; 
  setTimeout(function(){ window.location = '/tanks/'; }, delay);
}

//del tank func
$('.global-message').on("click", ".tank-confirmation-btn", function(){

  var tank_id = $(this).attr('tank_id'),
    nonce = $(this).attr('nonce'),
    parent = $(this).attr('parent').
    parent = $('.'+parent);

 data = {action:'del_tank',ajax_form_nonce_del_tank: nonce, tank_id: tank_id};
    
    console.log(data);

        $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
            console.log(data);
            $('.removeTank').remove();
            closeGlobalMessage();

          },
          error: function (e) {
              //error
            console.log('Eror 0937');
      
          }
      });

});

//del tank warning
$('.wrap').on("click", ".delete-tank", function(){

    var tank_id = $(this).attr('tank_id'),
    param_id = $(this).attr('param_id'),
    nonce = $(this).attr('nonce');
    $(this).parent().parent().parent().addClass('removeTank');
  
    $('.global-message .message').text("Are you sure you want to delete this entry and all of it's associated data? This includes, images, posts, favs, parameters and livestock. This cannot be undone.");
    $('.confirmation-btn').attr('tank_id',tank_id);
    $('.confirmation-btn').attr('nonce',nonce);
    $('.confirmation-btn').attr('parent',parent);
    $('.confirmation-btn').addClass('tank-confirmation-btn')
    $('.message-action').addClass('tank-message-action')
    
    $('.global-message').fadeToggle();
    $('.overlay').fadeToggle();

  }); 


//update tank data
//show the add tank form on the tanks page
  $('.edit-tank').click(function() { 
      var parent = $(this).parent().parent();
      parent.find('.tank_info').attr('contenteditable','true');
      parent.find('.tank_info').toggleClass('tankEditable');
      $(this).hide();
      parent.find('.save-edit-tank').show();
      parent.find('.delete-tank').show();
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
 
      var spinner ='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';
      $('.overlay').after(spinner);

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

//update tank image 

    $( '.tank-photo-img' ).change( function( event ) {
            
      event.preventDefault(); // Prevent the defau
      console.log('hello from the other side');
      //form validation 
      // var tank_name = $('#tank-form .tank-name').val();
      var parent = $(this).parent().parent();
      var data = new FormData();

      var spinner ='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';
      $('.overlay').after(spinner);
      

      // alert(this.files[0].size);


      console.log(parent);
      //Form data
      var form_data = parent.serializeArray();
      $.each(form_data, function (key, input) {
          data.append(input.name, input.value);
      });
      
      //File data
      var file = parent.find('.tank-photo-img')[0].files[0];
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
          console.log(data);
          console.log('working');
          tankForm();
          // location.reload();
          },
          error: function (e) {
              //error
        console.log(data);
        console.log('error');
          }
      });


            });



});


