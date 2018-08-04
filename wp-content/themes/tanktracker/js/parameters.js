///////////////////
// Parameters functions JS File
// by Andy 
///////////////////


$(document).ready(function() {
      

// $('.track-btn').click(function() { 
//   // $('.form-contain').toggleClass('show');
//   // $('.overlay').fadeToggle();
//   // $('.menu-bar').toggleClass('extended');
//   $('tbody tr').first().next().before(inputRow);
// });

function getDateTime() {
    var now     = new Date(); 
    var year    = now.getFullYear();
    var month   = now.getMonth()+1; 
    var day     = now.getDate();
    // var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
    var hour = now.getHours();
  if (hour > 12) {
      hour -= 12;
  } else if (hour === 0) {
    hour = 12;
  }

    if(month.toString().length == 1) {
         month = '0'+month;
    }
    if(day.toString().length == 1) {
         day = '0'+day;
    }   
    if(hour.toString().length == 1) {
         hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
         minute = '0'+minute;
    }
    if(second.toString().length == 1) {
         second = '0'+second;
    }   
    var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;   
     return dateTime;
}


$('.global-message').on("click", ".param-confirmation-btn", function(){

  var tank_id = $(this).attr('tank_id'),
    param_id = $(this).attr('param_id'),
    nonce = $(this).attr('nonce'),
    parent = $(this).attr('parent').
    parent = $('.'+parent);

 data = {action:'del_tank_params',ajax_form_nonce_del_param: nonce, tank_id: tank_id, param_id: param_id};
    
    console.log(data);

        $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
            console.log(data);
            $('.removeParam').remove();
            closeGlobalMessage();

          },
          error: function (e) {
              //error
            console.log('Eror 6300');
      
          }
      });

});


$('.param-table').on("click", ".del-param-input", function(){

    var tank_id = $(this).attr('tank_id'),
    param_id = $(this).attr('param_id'),
    nonce = $(this).attr('nonce');
    $(this).parent().parent().addClass('removeParam');
  
    $('.global-message .message').text("Are you sure you want to delete this entry?");
    $('.confirmation-btn').attr('param_id',param_id);
    $('.confirmation-btn').attr('tank_id',tank_id);
    $('.confirmation-btn').attr('nonce',nonce);
    $('.confirmation-btn').attr('parent',parent);
    $('.confirmation-btn').addClass('param-confirmation-btn')
    $('.message-action').addClass('param-message-action')
    
    $('.global-message').fadeToggle();
    $('.overlay').fadeToggle();

  }); 




$('.param-table').on("click", ".save-param-input", function(){



    var tank_id = $(this).attr('tank_id'),
    nonce = $(this).attr('nonce'),
    parent = $(this).parent().parent(),
    type = parent.find('.param_type').val();
    value = parent.find('.param_value').val();

    var valid = 0;

    if (type == 'Parameter'){
      parent.find('.param_type').parent().addClass('error-cell');
      var valid = 0;
    } else {
      valid++;
    } 
    if ( !$.isNumeric(value) )  {
      parent.find('.param_value').parent().addClass('error-cell');
      var valid = 0;
    } else {
      valid++;
    }

    console.log(valid);
    if (valid != 2){
     $('.global-error').html('Please enter a parameter type and or correct parameter value.');
       $('.global-error').addClass('show');
    setTimeout(function() {
        $('.global-error').removeClass('show');
    }, 2000);
       
    }
     else {

    
    parent.find('.date_logged').html(getDateTime);
    data = {action:'new_tank_params',ajax_form_nonce_save_param: nonce, tank_id: tank_id, type: type, value: value};
    parent.find('.param_type').parent().removeClass('error-cell');
  parent.find('.param_value').parent().removeClass('error-cell');
    
    console.log(data);

        $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
            console.log(data);
            $('tbody tr').first().next().before(inputRow);

          },
          error: function (e) {
              //error
            console.log('Eror 6300');
      
          }
      });
  } //end if validation

  }); 




});
