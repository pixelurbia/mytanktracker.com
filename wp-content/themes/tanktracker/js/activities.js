///////////////////
// Parameters functions JS File
// by Andy 
///////////////////


$(document).ready(function() {
      



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


$('.global-message').on("click", ".activity-confirmation-btn", function(){

  var tank_id = $(this).attr('tank_id'),
    activity_id = $(this).attr('activity_id'),
    nonce = $(this).attr('nonce'),
    parent = $(this).attr('parent').
    parent = $('.'+parent);

 data = {action:'del_tank_activity',ajax_form_nonce_del_act: nonce, tank_id: tank_id, activity_id: activity_id};
    
    console.log(data);

        $.ajax({
          url: ajaxurl,
          method: "post",
          data: data,
          success: function (data) {
              //success
            console.log(data);
            $('.removeActivity').remove();
            closeGlobalMessage();

          },
          error: function (e) {
              //error
            console.log('Eror 6300');
      
          }
      });

});

//get URL params
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};



function filter_activities() {

    var date_start = $('#datepicker-from').datepicker("option", "dateFormat", "yy-mm-dd" ).val()
    var date_end = $('#datepicker-to').datepicker("option", "dateFormat", "yy-mm-dd" ).val()
    var tank_id = getUrlParameter('tank_id');
    $('#ui-datepicker-div').css('display','none');
    // var url = "/paramque?" + "tank_id=" + tank_id + "&date_start=" + date_start +"&date_end=" + date_end;
    // console.log(url);
    // var filter = $(this).attr('value');
   
 $.ajax({
            url:"/activity-que?" + "tank_id=" + tank_id + "&date_start=" + date_start +"&date_end=" + date_end,
            // url:"paramque?tank_id=admin-11111",
          success: function(data){
            console.log('working');
            console.log(data);

                //is this even working?
                $('.activities').html(data);

            }
        }); // end ajax call
};

$('.wrap').on("click", ".del-activity", function(){

    var tank_id = $(this).attr('tank_id'),
    activity_id = $(this).attr('activity_id'),
    nonce = $(this).attr('nonce');
    $(this).parent().parent().addClass('removeActivity');
  
    $('.global-message .message').text("Are you sure you want to delete this entry?");
    $('.confirmation-btn').attr('activity_id',activity_id);
    $('.confirmation-btn').attr('tank_id',tank_id);
    $('.confirmation-btn').attr('nonce',nonce);
    $('.confirmation-btn').attr('parent',parent);
    $('.confirmation-btn').addClass('activity-confirmation-btn')
    $('.message-action').addClass('acticity-message-action')
    
    $('.global-message').fadeToggle();
    $('.overlay').fadeToggle();

  }); 

$('.wrap').on("click", ".edit-activity-input", function(){

      $('.saved-row').find('.product').attr('contenteditable','true');
      $('.saved-row').find('.product').addClass('editable');
      $('.saved-row').find('.quantity').attr('contenteditable','true');
      $('.saved-row').find('.quantity').addClass('editable');
      // parent.toggleClass('edited-row');


  }); 



$('.wrap').on("click", ".add-activity-input", function(){
    $('.activity-table tr').first().next().before(activityRow);
});

// //dirty flag for edited stuff to only pull and save that specific data
$('body').on('focus', '.check_field', function() {

}).on('blur keyup paste input', '[contenteditable]', function() {
    $(this).parent().addClass('dirty');
    $(this).addClass('dirty');
});


$('.wrap').on("click", ".save-activity-input", function(){
  
  nonce = $(this).attr('nonce');
  

var dataEngine = {action: 'save_tank_activity', ajax_form_nonce_save_activity: nonce, newActivity: [], editedActivity: []};

var valid = 0;

  $('.activity-table tr.new-activity-row.dirty').each(function() {

       var tank_id = $(this).attr('tank_id'),
       type = $(this).find('.activity_type').val(),
       product = $(this).find('.product').val(),
       quantity = $(this).find('.quantity').val();
       dirty = $(this).hasClass('dirty');
console.log(dirty);
         // do some simple validation checks to make sure we have valid values and stuff 
    
    if (dirty == true && !product && !quantity){
      valid++;
      $(this).find('.product').parent().addClass('error-cell');
      $(this).find('.quantity').parent().addClass('error-cell');
    } else {
      valid - 1;
    }
    


console.log(valid);


       //build inputs
        activity = {};
        activity ["tank_id"] = tank_id;
        activity ["activity_type"] = type;
        activity ["product"] = product;
        activity ["quantity"] = quantity;


        dataEngine.newActivity.push(activity);
  });


  // add edited rows to the data object
  $('.activity-table tr.saved-row.dirty').each(function() {
         var tank_id = $(this).attr('tank_id'),
       product = $(this).find('.product').text(),
       quantity = $(this).find('.quantity').text(),
       activity_id = $(this).attr('activity_id');
      dirty = $(this).find('.param_value').parent().hasClass('dirty');
      // console.log(dirty);


        activity = {};
        activity ["activity_id"] = activity_id;
        activity ["tank_id"] = tank_id;
        activity ["product"] = product;
        activity ["quantity"] = quantity;


        dataEngine.editedActivity.push(activity);
  });

   console.log(dataEngine);


 //    console.log(valid);
    if (valid != 0){
      $('.global-error').html('Please enter a value before saving.');
      $('.global-error').addClass('show');
      setTimeout(function() {
          $('.global-error').removeClass('show');
      }, 2500);
    
    } else {

      $(this).find('.product').parent().removeClass('error-cell');
      $(this).find('.quantity').parent().removeClass('error-cell');
  
 

        $.ajax({
          url: ajaxurl,
          method: "post",
          data: dataEngine,
          success: function (dataEngine) {
              //success
            console.log(dataEngine);
            filter_activities();
          },
          error: function (e) {
              //error
            console.log('Eror 6300');
      
          }
      });

 }

  }); 




});
