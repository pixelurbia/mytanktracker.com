///////////////////
// Register user workflow JS File
// by Andy 
///////////////////


$(document).ready(function() {
      
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

$( '#regi-form' ).submit( function( event ) {
            event.preventDefault(); // Prevent the default form submit.            
            
        var pass2 = $('.pass-2').val();
        var pass1 = $('.pass-1').val();
        var email = $('.email').val();
        console.log($('.email').val());
        
       

        String.prototype.contains = function(it) { return this.indexOf(it) != -1; };
        
        if (pass2 != pass1 || pass1 == "undefined" || pass1 == null ) {
          return;
        }

        if (email != null && email.contains("@") ) {
     
        } else {
             $('.global-error').html('A valid Email is required.');
             $('.global-error').addClass('show');
            return;
        }
        
         var tos = $('.tos-agreement:checkbox:checked').length > 0;
        // console.log('tos: '+tos);

        if (tos == false) {
             $('.global-error').html('You must read and agree to the Terms of Service');
             $('.global-error').addClass('show');
            return;
        }


            
            var ajax_form_data = $("#regi-form").serializeObject();
            //add our own ajax check as X-Requested-With is not always reliable
            // ajax_form_data = ajax_form_data+'&ajaxrequest=true&submit=Submit+Form';
            // console.log(ajax_form_data);
        console.log(ajax_form_data);
           $.post( 
        ajaxurl,
        ajax_form_data,
        function(response) { 
          console.log(response);
          if (response == 'sucess') {
            reigform(); 
          } else {
            $('.global-error').html(response);
            $('.global-error').addClass('show');
          }
          
            
        })
       });       


//step two transition
function reigform(){
  // console.log('reg and login work');
  $('.step-one').fadeOut();
  $('.frost').css({'height':'570px'})
  $('.step-two').delay( 400 ).fadeIn();
}

//username validation
$( '#regi-form .marketing-agreement' ).change( function() {
  $(this).val('no');
 });
$( '#regi-form .regi-validate' ).change( function() {

  
  var attribute = $(this).val();
  var nonce = $('#ajax_form_nonce').val();
  console.log(nonce);

  if ($(this).hasClass('username')){
    var checker = 'user_nicename';
  } else {
    var checker = 'user_email';
  }
  
  var data = {attribute: attribute, nonce: nonce, checker: checker, action: 'validate_regi_form'};

    console.log(data);
    $.post( 
      ajaxurl,
      data,
      function(data) { 

      console.log(data);
      if (data == 1 ) {
        console.log('conflict');
        $('#regi-form .username').css({'color':'#ff5050'});
        $('#regi-form .email').css({'color':'#ff5050'});
       $('.global-error').html('Sorry about that, that username or email already exist.');
       $('.global-error').addClass('show');
      } else {
        console.log('no conflict');
       $('#regi-form .username').css({'color':'#fff'});
       $('#regi-form .email').css({'color':'#fff'});
       $('.global-error').removeClass('show');
      }

    })

  });

//validate password
$( '#regi-form .pass-2' ).keyup(function() {

  var pass2 = $(this).val();
  var pass1 = $('.pass-1').val();

  if (pass2 == pass1) {
    $('#regi-form .pass-1').css({'color':'#fff'});
    $('#regi-form .pass-2').css({'color':'#fff'});
    $('.global-error').removeClass('show');
    $('.account-reg').css({'opacity':'1'});

  } else {
    $('.account-reg').css({'opacity':'0.3'});
    $('#regi-form .pass-1').css({'color':'#ff5050'});
    $('#regi-form .pass-2').css({'color':'#ff5050'});
    $('.global-error').html('Hmm, your passwords do not match, please fix that before we continue.');
    $('.global-error').addClass('show');

  }

});




});
