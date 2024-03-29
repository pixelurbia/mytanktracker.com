///////////////////
// Master JS File
// by Andy 
///////////////////


// @codekit-append "master.js", ,"add-photo.js","add-stock.js","add-tank.js","feed.js","parameters.js","activities.js","register-master.js","trello-integration.js","user-settings.js";


$(document).ready(function() {

//ticket system fixes

$('.aiosc-uploader').parent().hide();


$('.type-menu .menu-item-contain').click( function() {
	$('.type-menu .menu-item-contain').removeClass('selected');
	$(this).addClass('selected');
	var value = $(this).attr('value');
	$('.stocktype').attr('value',value);
});

 $('.tankstock-js-example-basic-multiple').select2({
  placeholder: {
    id: '-1', // the value of the option
    text: 'Tag a tank or livestock'
  }
});

 $('.cat-js-example-basic-multiple').select2({
  placeholder: {
    id: '-1', // the value of the option
    text: 'Add a category to your post'
  }
});

//global message close
$('.close-message-action').click(function() { 
	closeGlobalMessage();
});





// When the user scrolls the page, execute myFunction 
// window.onscroll = function() {
// 	var wrap = $('.recent_params');
// 	// console.log(pageYOffset);
// 	 if (pageYOffset > 147) {
//     	wrap.addClass("sticky");
//  	 } else {
//     	wrap.removeClass("sticky");
//   }

// };

//strip markup from journal entries 
document.querySelector('div[contenteditable="true"]').addEventListener("paste", function(e) {
        e.preventDefault();
        var text = e.clipboardData.getData("text/plain");
        document.execCommand("insertHTML", false, text);
    });


// $('#ajax-contact-form').submit(function(e){
//     var name = $("#name").val();
//     $.ajax({ 
//          data: {action: 'contact_form', name:name},
//          type: 'post',
//          url: ajaxurl,
//          success: function(data) {
//               alert(data); //should print out the name since you sent it along

//         }
//     });

// });

//date picker
$( "#datepicker-to" ).datepicker({
    dateFormat: 'yy-mm-dd'
});
$( "#datepicker-from" ).datepicker({
    dateFormat: 'yy-mm-dd'
});

//tooltip

var tooltipSpan = $('.mouse-tool-tip');

$('.one-change').hover(function(){
	var date_of_change = $(this).attr('value');
 	tooltipSpan.show();
 	tooltipSpan.html(date_of_change);
 }, function(){
 	tooltipSpan.hide();
});

window.onmousemove = function (e) {
	var tooltipSpan = $('.mouse-tool-tip');
    var x = e.clientX,
        y = e.clientY;
    tooltipSpan.css('top', (y + 20) + 'px');
    tooltipSpan.css('left', (x + 20) + 'px');
};

 
$('.tip').hover(function(){
	var content = $(this).attr('tip');
 	tooltipSpan.show();
 	tooltipSpan.html(content);
 }, function(){
 	tooltipSpan.hide();
});

$('.day.one-change')

$('#loginform #user_login').attr('placeholder','Username');
$('#loginform #user_pass').attr('placeholder','Password');

$('.menu-button').click(function(event) { 
	event.preventDefault(); // Prevent the default form submit.
	$('.menu-bar').toggleClass('open');
	// $('.wrap').toggleClass('open');

});





/*
$('.param-table table th:nth-child(2)').css('width','150px');

use this to resize the tables

*/


$('.journals-btn').click(function() { 
	$('#journal-form').toggleClass('show');
	$('.menu-bar').toggleClass('extended');
	$('.overlay').fadeToggle();
});

$('.journals .close').click(function() { 
	$('.journals.form-contain').fadeToggle();
	$('.overlay').fadeToggle();
});




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

		
//Ajax Form Handler 
//param-form
        $( '#ajax-form' ).submit( function( event ) {
            
			event.preventDefault(); // Prevent the default form submit.            
			var ajax_form_data = $("#ajax-form").serializeObject();
			var action = ajax_form_data['action'];
			var tank_id = ajax_form_data['tank_id'];
			var param_type = ajax_form_data['type'];
			var user = ajax_form_data['user_id'];
			var type = ajax_form_data['type'];
			var type = 'chart'+type;
			// console.log(ajax_form_data);
			// console.log(type);
			// console.log($('#'+type).length);
			//check if this is a parameter form and if there is one to update
			if ( $('#'+type).length && action == 'new_tank_params' ) {
				// console.log('A chart is dedected and it is a param form');
				var chartData = chartDataConstructor(ajax_form_data);
					// console.log('chart data returned');
     				// console.log(chartData);
     				var chart = chartData[0];
     				var label = chartData[1];
     				var data = chartData[2];
			}
			//form validation

			if ($(this).valid() == false ){
				console.log('Form not valid - Error 201');
			} else {
                $.post( 
        		     ajaxurl,
        		     ajax_form_data,
        		     function(ajax_form_data) { 
            	     // location.reload();
           		     console.log(ajax_form_data);
       		     })
		        console.log(ajax_form_data);
		        //If param form update chart 
		        if (ajax_form_data = '0' ){
		           // $('.form-contain').fadeToggle();
				   $('.overlay').fadeToggle();
				   $('.menu-bar').toggleClass('extended');
				   $('.form-contain').toggleClass('show');
				} else {
					 $('.form-contain').html('There was an error - please contact the administrator. Error 78');
					console.log('form did not submit - error 78');
				}
           	    if ($('#'+type).length && action == 'param_form') {
           		    addData(chart, label, data);
           		    get_tables(tank_id, param_type, user);
           		    
					
           	    }

				
			}
       });

//update tables ajax
function get_tables(tank_id, param_type, user ){

	var data = {tank_id: tank_id, param_type: param_type, user: user, action: 'get_table_data'};
	//data: {status: status, name: name},

	console.log(data);
	$.post( 
		ajaxurl,
		data,
		function(data) { 
		// location.reload();
		// console.log('this working?');
		
		$('#table-'+param_type).html(data);
		
	})

}
//validate image sie
$('#journal-img').on('change', function() {

  var filename = this.value;
  var lastIndex = filename.lastIndexOf("\\");
  if (lastIndex >= 0) {
    filename = filename.substring(lastIndex + 1);
  }
  var files = $('#journal-img')[0].files;

  for (var i = 0; i < files.length; i++) {

    fileSize = files[i].size;

  if(fileSize > 10000000){
    alert("You have exceeded the maximum file upload size for one or more of your images. Please correct this before submiting.");
    $('#journal-img').value = '';
   }
   	$('#post-images').html('');
    return false;
  }

});


//journals
         $( '#journal-form' ).submit( function( event ) {
            
  			event.preventDefault(); // Prevent the defau
			// var file_data = $('#tank-img').prop('files')[0]; 
			// console.log(file_data);
   //          var ajax_form_data = $("#tank-form").append('file', file_data);
   //          console.log(ajax_form_data);
   //          var ajax_form_data = $("#tank-form").serializeObject();
   //          console.log(ajax_form_data);

   			var spinner ='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';
   			$('.overlay').after(spinner);


   			// console.log('journal submited');
			var data = new FormData(this);

			$.ajax({
    			url: ajaxurl,
    			method: "post",
    			processData: false,
    			contentType: false,
    			data: data,
    			success: function (data) {


				if ( data == 'limit'){
    				$('.global-error').html('You need to wait at least 60 seconds before posting again.');
					$('.global-error').fadeToggle();
  					$('.global-error').delay( 2000 ).fadeToggle();
  					$('#journal-form').toggleClass('show');
  					$('.menu-bar').toggleClass('extended');
  					$('.overlay').fadeToggle();
  					$('#journal-form .status').html('What is goin on today?');
  					$('.spinner-loader').remove();
    				
    					
    				} else {
					$('.global-suc').html('Journal has been logged.');
					$('.global-suc').fadeToggle();
  					$('.global-suc').delay( 2000 ).fadeToggle();
  					$('#journal-form').toggleClass('show');
  					$('.menu-bar').toggleClass('extended');
  					$('.overlay').fadeToggle();
  					$('#journal-form .status').html('What is goin on today?');
  					$('.spinner-loader').remove();
  					$('#journal-img').value = '';
    				$('#post-images').html('');
    			}
    			},
    			error: function (e) {
    				
    			}
			});
       });  
//journal status area stuff
$('#j-status').focus(function() {
	$(this).find('i').remove();
});
$('#j-status').focusout(function() {
	var content = $(this).html();
	$('#status-content').attr('value', content);

});





//form validation Old?
 // $.validator.addMethod("valueNotEquals", function(value, element, arg){
	// 		  return arg !== value;
	// 		 }, "Please select a parameter type.");

	// 		$('#ajax-form' ).validate({
	// 			rules: {
	// 				value: {
	// 					required: true,
	// 					number: true
	// 				},
	// 				type: { 
	// 					valueNotEquals: "Parameter" 
	// 				}

	// 			},
	// 		 	 invalidHandler: function(event, validator) {
	// 		    // 'this' refers to the form
	// 		    var errors = validator.numberOfInvalids();
	// 		    if (errors) {
	// 		    	console.log('Error 222');
	// 		    } else {
			    	
	// 		    }
	// 		  }
	// 		});
	

//tank selection 
// set urls

// $('.a_tank').click(function() {
// 	var tank_id = $(this).attr('value');
// 	console.log(tank_id);
// 	$('.tank-menu a').each(function(){  
// 		var link = $(this).attr('name');
// 		var url = link+'?tank_id='+tank_id;
// 		$(this).attr('href', url);
// 	});

// });
$('.select_tank .fa-search').click(function() {
	var tank_id = $(this).attr('tankid');
		$('.tank-menu a').each(function(){  
		var link = $(this).attr('name');
		var url = link+'?tank_id='+tank_id;
		$(this).attr('href', url);
	});
	// window.location.href = "/overview?tank_id="+tank_id;

});
$('.select_tank .fa-flask').click(function() {
	var tank_id = $(this).attr('tankid');
	// console.log(tank_id);
	$('.tank-menu a').each(function(){  
		var link = $(this).attr('name');
		var url = link+'?tank_id='+tank_id;
		$(this).attr('href', url);
	});
	window.location.href = "/parameters?tank_id="+tank_id;

});

//export 

$( '#export' ).click( function( event ) {
            event.preventDefault(); // Prevent the defau
            var param_type = $(this).attr('param_type');
            var curuser = $(this).attr('curuser');
            var tank_id = $(this).attr('tank_id');

       window.open('/export-param-table?tank_id='+tank_id+'&curuser='+curuser+'&param_type='+param_type+'', '_blank');
		
		
       });  
//journal status area stuff
$('#j-status').focus(function() {
	$(this).find('i').remove();
});
$('#j-status').focusout(function() {
	var content = $(this).html();
	$('#status-content').attr('value', content);

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

function resize() {
    $(".gallery-expanded").css({
    width:  $(window).width(),
    height: $(window).height()
});
}

// $.validator.addMethod("valueNotEquals", function(value, element, arg){
//   return arg !== value;
//  }, "Value must not equal arg.");

//  // configure your validation
//  $("form").validate({
//   rules: {
//    SelectName: { valueNotEquals: "default" }
//   },
//   messages: {
//    SelectName: { valueNotEquals: "Please select an item!" }
//   }  
//  });



//gallery item controls 

$('.wrap').on("click", ".gallery-item", function(){ 
	var fullImg = $(this).find('img').attr('full');
	var imgContain = '<div class="gallery-expanded"><div class="gal-close"><i class="fas fa-times-circle fa-lg"></i></div><img src="'+fullImg+'"></div>';
	$('.overlay').show();
	$('.overlay').before(imgContain);
	$('.menu-bar').css('top','-50px');
	resize();
});

$('.wrap').on("click", ".gal-close", function(){

	$('.overlay').hide();
	$('.gallery-expanded').remove();
	$('.menu-bar').css('top','0px');
	$(this).remove();

});


 
$(window).resize(function(){
 	resize();
});


});



