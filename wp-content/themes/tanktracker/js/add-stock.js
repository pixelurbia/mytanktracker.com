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
     

$('.stock-next-step').click(function() { 
  $('#livestock-form .step-one').fadeToggle('fast');
  $('#livestock-form .step-two').fadeToggle('slow');
});

$('.stock-prev-step').click(function() { 
  $('#livestock-form .step-one').fadeToggle('slow');
  $('#livestock-form .step-two').fadeToggle('fast');
});



$('.stock-message-action').click(function() { 
    var stock_id = $(this).attr('stock_id');
    var nonce = $(this).attr('nonce');
    console.log('stock-message-action');
  
    $('.global-message .message').text("Are you sure you want to delete this entry?");
    $('.confirmation-btn').attr('stock_id',stock_id);
    $('.confirmation-btn').attr('nonce',nonce);
    $('.confirmation-btn').addClass('stock-confirmation-btn');
    $('.message-action').addClass('stock-message-action');

 
    $('.global-message').fadeToggle();
    $('.overlay').fadeToggle();

});


  $('.global-message').on("click", ".stock-confirmation-btn", function(){

    var nonce = $(this).attr('nonce');
    var stock_id = $(this).attr('stock_id');
    data = {action:'del_livestock',ajax_form_nonce_del_stock: nonce, stock_id, stock_id};

    console.log(data);

        $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
            console.log('Entry Deleted');
            stockForm();
          },
          error: function (e) {
              //error
            console.log('Eror 8373');
      
          }
      });

});


//stock filter functions

$('#stock_filter a').click(function() {
  $(this).parent().find('.current').removeClass('current');
  $(this).addClass('current');
    var stock_type = $(this).attr('value');
    var tank_id = $(this).parent().attr('tank_id');

    var spinner ='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';
    $('.overlay').after(spinner);

    data = {action:'list_of_stock',tank_id: tank_id, stock_type: stock_type};

    console.log(data);

        $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
            $('.stock-list').html(data); 
            $('.spinner-loader').remove();
          },
          error: function (e) {
              //error
            console.log('Eror 3439');
      
          }
      });

});

//show the add tank form on the tanks page
  $('.add-livestock').click(function() { 
    $('.add-livestock-form').toggleClass('extended');
    $('.overlay').fadeToggle();
    $('.menu-bar').toggleClass('extended-more');
  }); 
  

//livestock form controls


//Add livestock
    $( '#livestock-form' ).submit( function( event ) {
            
      event.preventDefault(); // Prevent the defau

      if (!$('#livestock-form .stock-name').val()) {
            $('.global-error').html('Your livestock needs a name.');
             $('.global-error').addClass('show');
            return;
        } else {
                 $('.global-error').removeClass('show');

        }

      var data = new FormData();
      
      //Form data
      var form_data = $('#livestock-form').serializeArray();
      $.each(form_data, function (key, input) {
          data.append(input.name, input.value);
      });
      
      //File data
      // var file = $('#stock-img')[0].files[0];

      //File data
      var file = $('#Livestock-output').attr('src');
      // var file = $('#stock_img').src();


      data.append("file", file);
      
      for (var pair of data.entries()) {
          console.log(pair[0]+ ', ' + pair[1]); 
      }
      
      //Custom data
      // data.append('key', 'value');
      // console.log(data);
      $.ajax({
          url: ajaxurl,
          method: "post",
          processData: false,
          contentType: false,
          data: data,
          success: function (data) {
              //success
          console.log(data);
           // stockForm();
          },
          error: function (e) {
              //error
              console.log(data);
      
          }
      });


            });


//update livestock data
//show the add tank form on the tanks page
  $('.edit-stock').click(function() { 
      var parent = $(this).parent();

      if (parent.find('li').hasClass('hide')){
          parent.find('li.hide span').text('Edit Value');
          parent.find('li.hide').addClass('new-value');
          parent.find('li').removeClass('hide');
          
      }
 
      parent.find('li span').attr('contenteditable','true');
      parent.find('li span').toggleClass('tankEditable');
      $(this).hide();
      parent.find('.save-tank-stock').removeClass('hide');
      parent.find('.del-stock').removeClass('hide');
      parent.find('.stock-update-img').removeClass('hide');
  }); 


   $('.save-tank-stock').click(function() { 

      $( "li.new-value span" ).each(function() {
          var editValue = $(this).text();
          // console.log(editValue);
        if ( editValue == 'Edit Value'){
            $(this).text('');
        }
      }); 

      var stock_id = $(this).attr('stock_id'),
      nonce = $(this).attr('nonce'),
      parent = $(this).parent(),
      stock_name = parent.find('.name span').text(),
      stock_species = parent.find('.species span').text(),
      stock_age = parent.find('.age span').text(),
      stock_status = parent.find('.status span').text(),
      stock_sex = parent.find('.sex span').text(),
      stock_count = parent.find('.count span').text();


      var spinner ='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';
      $('.overlay').after(spinner);

      data = {action:'update_user_stock',ajax_form_nonce_save_stock: nonce, stock_id: stock_id, stock_name: stock_name, stock_species: stock_species, stock_age: stock_age, stock_status: stock_status, stock_sex: stock_sex, stock_count: stock_count};


    console.log(data);

        $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
              console.log(data);
            console.log('Entry Updated');
            stockForm();
          },
          error: function (e) {
              //error
            console.log('Eror 8937987');
      
          }
      });
  }); 



    $( '.stock-photo-img' ).change( function( event ) {
            
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
      var file = parent.find('.stock-photo-img')[0].files[0];
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
          stockForm();  
          },
          error: function (e) {
              //error
        console.log(data);
        console.log('error 9890890');
          }
      });


            });






function stockForm(){
  // console.log('reg and login work');
  var delay = 500; 
  setTimeout(function(){  location.reload(); }, delay);
}




});
