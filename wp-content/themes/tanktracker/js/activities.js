// ///////////////////
// // Parameters functions JS File
// // by Andy 
// ///////////////////


// $(document).ready(function() {
      



// function getDateTime() {
//     var now     = new Date(); 
//     var year    = now.getFullYear();
//     var month   = now.getMonth()+1; 
//     var day     = now.getDate();
//     // var hour    = now.getHours();
//     var minute  = now.getMinutes();
//     var second  = now.getSeconds(); 
//     var hour = now.getHours();
//   if (hour > 12) {
//       hour -= 12;
//   } else if (hour === 0) {
//     hour = 12;
//   }

//     if(month.toString().length == 1) {
//          month = '0'+month;
//     }
//     if(day.toString().length == 1) {
//          day = '0'+day;
//     }   
//     if(hour.toString().length == 1) {
//          hour = '0'+hour;
//     }
//     if(minute.toString().length == 1) {
//          minute = '0'+minute;
//     }
//     if(second.toString().length == 1) {
//          second = '0'+second;
//     }   
//     var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;   
//      return dateTime;
// }


// // $('.global-message').on("click", ".activity-confirmation-btn", function(){

// //   var tank_id = $(this).attr('tank_id'),
// //     param_id = $(this).attr('param_id'),
// //     nonce = $(this).attr('nonce'),
// //     parent = $(this).attr('parent').
// //     parent = $('.'+parent);

// //  data = {action:'del_tank_params',ajax_form_nonce_del_param: nonce, tank_id: tank_id, param_id: param_id};
    
// //     console.log(data);

// //         $.ajax({
// //           url: ajaxurl,
// //           method: "post",
// //           data: data,
// //           success: function (data) {
// //               //success
// //             console.log(data);
// //             $('.removeParam').remove();
// //             closeGlobalMessage();

// //           },
// //           error: function (e) {
// //               //error
// //             console.log('Eror 6300');
      
// //           }
// //       });

// // });

// //get URL params
// var getUrlParameter = function getUrlParameter(sParam) {
//     var sPageURL = decodeURIComponent(window.location.search.substring(1)),
//         sURLVariables = sPageURL.split('&'),
//         sParameterName,
//         i;

//     for (i = 0; i < sURLVariables.length; i++) {
//         sParameterName = sURLVariables[i].split('=');

//         if (sParameterName[0] === sParam) {
//             return sParameterName[1] === undefined ? true : sParameterName[1];
//         }
//     }
// };



// // $('.param-table-filters').click(function() { 
  
// //     var date_start = $('#datepicker-from').datepicker("option", "dateFormat", "yy-mm-dd" ).val()
// //     var date_end = $('#datepicker-to').datepicker("option", "dateFormat", "yy-mm-dd" ).val()
// //     var tank_id = getUrlParameter('tank_id');
// //     // var url = "/paramque?" + "tank_id=" + tank_id + "&date_start=" + date_start +"&date_end=" + date_end;
// //     // console.log(url);
// //     // var filter = $(this).attr('value');
   
// //  $.ajax({
// //             url:"/paramtableque?" + "tank_id=" + tank_id + "&date_start=" + date_start +"&date_end=" + date_end,
// //             // url:"paramque?tank_id=admin-11111",
// //           success: function(data){
// //             console.log('working');
// //             console.log(data);
// //                 //is this even working?
// //                 $('.params').html(data);
// //             }
// //         }); // end ajax call
// //     });

// // $('.wrap').on("click", ".del-param-input", function(){

// //     var tank_id = $(this).attr('tank_id'),
// //     param_id = $(this).attr('param_id'),
// //     nonce = $(this).attr('nonce');
// //     $(this).parent().parent().addClass('removeParam');
  
// //     $('.global-message .message').text("Are you sure you want to delete this entry?");
// //     $('.confirmation-btn').attr('param_id',param_id);
// //     $('.confirmation-btn').attr('tank_id',tank_id);
// //     $('.confirmation-btn').attr('nonce',nonce);
// //     $('.confirmation-btn').attr('parent',parent);
// //     $('.confirmation-btn').addClass('param-confirmation-btn')
// //     $('.message-action').addClass('param-message-action')
    
// //     $('.global-message').fadeToggle();
// //     $('.overlay').fadeToggle();

// //   }); 

// // $('.wrap').on("click", ".edit-param-input", function(){

// //       $('.saved-row').find('.param_value').attr('contenteditable','true');
// //       $('.saved-row').find('.param_value').addClass('editable');
// //       // parent.toggleClass('edited-row');


//   // }); 



// $('.wrap').on("click", ".add-activity-input", function(){
//     $('.activity-table tr').first().next().before(activityRow);
// });

// // //dirty flag for edited stuff to only pull and save that specific data
// // $('body').on('focus', '.param_value', function() {

// // }).on('blur keyup paste input', '[contenteditable]', function() {
// //     $(this).parent().addClass('dirty');
// //     $(this).addClass('dirty');
// // });


// $('.wrap').on("click", ".save-param-input", function(){
  
//   nonce = $(this).attr('nonce');
  

// var dataEngine = {action: 'save_tank_params', ajax_form_nonce_save_param: nonce, newParams: [], editedParams: []};

// var valid = 0;

//   $('.param-table tr.new-input.dirty').each(function() {

//        var tank_id = $(this).attr('tank_id'),
//        type = $(this).find('.param_type').val(),
//        value = $(this).find('.param_value').val(),
//        dirty = $(this).find('.param_value').parent().hasClass('dirty');
// console.log(dirty);
//          //do some simple validation checks to make sure we have valid values and stuff 
    
//     if (type == 'Parameter'){
//       $(this).find('.param_type').parent().addClass('error-cell');
//       valid++;
//     } else {
//       valid - 1;
//     }
//     if ( !$.isNumeric(value) || dirty == false )  {
//        $(this).find('.param_value').parent().addClass('error-cell');
//       valid++;
//     } else {
//       valid - 1;
//     }


// console.log(valid);


//        //build inputs
//         param = {};
//         param ["param_type"] = type;
//         param ["value"] = value;
//         param ["tank_id"] = tank_id;


//         dataEngine.newParams.push(param);
//   });


//   add edited rows to the data object
//   $('.param-table tr.saved-row.dirty').each(function() {
//        var tank_id = $(this).attr('tank_id'),
//        param_id = $(this).attr('param_id'),
//        parent = $(this).parent().parent(),
//        type = $(this).find('.param_type').val(),
//        editValue = $(this).find('.param_value').text(),
//       dirty = $(this).find('.param_value').parent().hasClass('dirty');
//       console.log(dirty);

//     if ( !$.isNumeric(editValue) || dirty == false )  {
//        $(this).find('.param_value').parent().addClass('error-cell');
//       valid++;
//     } else {
//       valid - 1;
//     }


//         param = {};
//         param ["param_id"] = param_id;
//         param ["value"] = editValue;
//         param ["tank_id"] = tank_id;


//         dataEngine.editedParams.push(param);
//   });

//    console.log(dataEngine);




//  //    if (edited == true){
//  //      data = {action: 'save_tank_params', ajax_form_nonce_save_param: nonce, tank_id: tank_id, param_id: param_id, value: editValue};
//  //      console.log('save');

//  //      parent.find('.param_value').attr('contenteditable','false');
//  //      parent.find('.param_value').removeClass('editable');
//  //      parent.find('.save-btn').addClass('hide');
//  //      parent.find('.edit-btn').removeClass('hide');
//  //      parent.toggleClass('edited-row');

//  //    } else {
//  //      data = {action: 'new_tank_params', ajax_form_nonce_save_param: nonce, tank_id: tank_id, type: type, value: value};
   

//  //      console.log('new');
//  //    }

//  //    console.log(valid);
//     if (valid != 0){
//       $('.global-error').html('Please enter a parameter type and or correct parameter value.');
//       $('.global-error').addClass('show');
//       setTimeout(function() {
//           $('.global-error').removeClass('show');
//       }, 2500);
    
//     } else {
//       // parent.find('.date_logged').html(getDateTime);
//       // parent.find('.param_type').parent().removeClass('error-cell');
//       // parent.find('.param_value').parent().removeClass('error-cell');
  
 

//         $.ajax({
//           url: ajaxurl,
//           method: "post",
//           data: dataEngine,
//           success: function (dataEngine) {
//               //success
//             console.log(dataEngine);
//             // if (data != '0') {
//             //   $('.new-input .save-btn a').attr('param_id',data);
//             //   $('.new-input .edit-btn a').attr('param_id',data);
//             //   $('.new-input .del-btn a').attr('param_id',data);

//             //   //move the value to text for easier grabbing when editing 
//             //   var paramValue = $('.input-row').find('.param_value').val();
//             //   $('.input-row').find('.param_value').parent().addClass('param_value');
//             //   $('.input-row').find('input.param_value').remove();
//             //   $('.input-row').find('.param_value').text(paramValue);

//             //   //move the value to text for easier grabbing when editing 
//             //   var paramType = $('.input-row').find('.param_type').find('option:selected').attr('name');
//             //   $('.input-row').find('.param_type').parent().addClass('param_type');
//             //   $('.input-row').find('select.param_type').remove();
//             //   $('.input-row').find('.param_type').text(paramType);



//             //   $('.input-row').removeClass('new-input');
//             //   $('.input-row').find('.save-btn').addClass('hide');
//             //   $('.input-row').removeClass('input-row');
//             //   $('tbody tr').first().next().before(inputRow);
//             //  }
//           },
//           error: function (e) {
//               //error
//             console.log('Eror 6300');
      
//           }
//       });

//  }

//   }); 




// });
