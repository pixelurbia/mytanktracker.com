///////////////////
// Register user workflow JS File
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
      
//seralizer
 $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

//regisrtation form main user creation and validation queries 

$( '#pass-reset-form' ).submit( function( event ) {
        event.preventDefault(); // Prevent the default form submit.            
        
           var data = new FormData();
      
      //Form data
      var form_data = $(this).serializeArray();
      $.each(form_data, function (key, input) {
          data.append(input.name, input.value);
      });

      // for (var pair of data.entries()) {
      //     console.log(pair[0]+ ', ' + pair[1]); 
      // }

      var spinner ='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';
      $('.overlay').after(spinner);


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
            $('.global-suc').html('An email has been sent to the provided email.');
            $('.global-suc').fadeToggle();
            $('.global-suc').delay( 2000 ).fadeToggle();
            var delay = 2000; 
          setTimeout(function(){ window.location = '/user-login/'; }, delay);
          },
          error: function (e) {
              //error
              // console.log(e);
          }
      });


       });       

//the actual changing of the password
$( '#pass-reseting-form' ).submit( function( event ) {
        event.preventDefault(); // Prevent the default form submit.            
        
           var data = new FormData();
      
      //Form data
      var form_data = $(this).serializeArray();
      $.each(form_data, function (key, input) {
          data.append(input.name, input.value);
      });

      // for (var pair of data.entries()) {
      //     console.log(pair[0]+ ', ' + pair[1]); 
      // }

      var spinner ='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';
      $('.overlay').after(spinner);


          $.ajax({
          url: ajaxurl,
          method: "post",
          processData: false,
          contentType: false,
          data: data,
          success: function (data) {
              //success
          console.log(data);
          $('.spinner-loader').remove();
            $('.global-suc').html('Your password has been succesfully changed.');
            $('.global-suc').fadeToggle();
            $('.global-suc').delay( 2000 ).fadeToggle();
          var delay = 2000; 
          setTimeout(function(){ window.location = '/user-login/'; }, delay);
          },
          error: function (e) {
              //error
              console.log(e);
          }
      });


       });       



//username validation
$( '#pass-reset-form .email-validate' ).keyup(function() {

  
  var attribute = $(this).val();
  var nonce = $('#ajax_form_nonce').val();
  // console.log(nonce);


    var checker = 'user_email';
    var data = {attribute: attribute, nonce: nonce, checker: checker, action: 'validate_regi_form'};


    if (attribute.indexOf("@") >= 0){

            // console.log(data);
      $.post( 
        ajaxurl,
        data,
        function(data) { 
  
        // console.log(data);
        if (data == 1 ) {
          $('.btn.pass-reset').removeClass('hide');
          $('.bad-btn').hide();
          $('.global-error').removeClass('show');
         
        } else {
          $('.btn.pass-reset').addClass('hide');
          $('.bad-btn').show();
          $('.global-error').html('That email does not match our records.');
          $('.global-error').addClass('show');
        }
  
      })

    }



  });

//validate password
$( '#pass-reseting-form .pass-2' ).keyup(function() {

  var pass2 = $(this).val();
  var pass1 = $('.pass-1').val();

  if (pass2 == pass1 || pass1 == pass2) {
    $('#pass-reseting-form .pass-1').css({'color':'#fff'});
    $('#pass-reseting-form .pass-2').css({'color':'#fff'});
    $('.global-error').removeClass('show');
    $('.btn.pass-reset').removeClass('hide');
    $('.bad-btn').hide();

  } else {
    $('#pass-reseting-form .pass-1').css({'color':'#ff5050'});
    $('#pass-reseting-form .pass-2').css({'color':'#ff5050'});
    $('.global-error').html('Hmm, your passwords do not match, please fix that before we continue.');
    $('.global-error').addClass('show');
    $('.btn.pass-reset').addClass('hide');
    $('.bad-btn').show();

  }

});




});
