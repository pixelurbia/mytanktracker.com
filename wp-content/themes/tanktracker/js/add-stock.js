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



$('.message-action').click(function() { 
    var stock_id = $(this).attr('stock_id');
    var nonce = $(this).attr('nonce');
  
    $('.global-message .message').text("Are you sure you want to delete this entry?");
    $('.confirmation-btn').attr('stock_id',stock_id);
    $('.confirmation-btn').attr('nonce',nonce);
    
    $('.global-message').fadeToggle();
    $('.overlay').fadeToggle();
});


$('.confirmation-btn').click(function() {

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

//show the add tank form on the tanks page
  $('.add-livestock').click(function() { 
    $('.add-livestock-form').toggleClass('extended');
    $('.overlay').fadeToggle();
    $('.menu-bar').toggleClass('extended-more');
  }); 
  

//Add Tank register
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
           stockForm();
          },
          error: function (e) {
              //error
              console.log(data);
      
          }
      });


            });


function stockForm(){
  // console.log('reg and login work');
  var delay = 500; 
  setTimeout(function(){  location.reload(); }, delay);
}




});
