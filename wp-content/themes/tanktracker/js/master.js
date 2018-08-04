///////////////////
// Master JS File
// by Andy 
///////////////////


$(document).ready(function() {

$('.type-menu .menu-item-contain').click( function() {
	$('.type-menu .menu-item-contain').removeClass('selected');
	$(this).addClass('selected');
	var value = $(this).attr('value');
	$('.stocktype').attr('value',value);
});

 $('.js-example-basic-multiple').select2({
  placeholder: {
    id: '-1', // the value of the option
    text: 'Tag a tank or livestock'
  }
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
$( "#datepicker-to" ).datepicker();
$( "#datepicker-from" ).datepicker();

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


$('.day.one-change')

$('#loginform #user_login').attr('placeholder','Username');
$('#loginform #user_pass').attr('placeholder','Password');

$('.menu-button').click(function(event) { 
	event.preventDefault(); // Prevent the default form submit.
	$('.menu-bar').toggleClass('open');
	// $('.wrap').toggleClass('open');

});

$('.track-btn').click(function() { 
	// $('.form-contain').toggleClass('show');
	// $('.overlay').fadeToggle();
	// $('.menu-bar').toggleClass('extended');
	var dataRow = $('.input-row').html();
	var dataRow = '<tr class="input-row">'+dataRow+'</tr>';
	$('tbody tr').first().next().before(dataRow);
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
	//update chart ui without re-query db

	     function addData(chart, label, data) {
            chart.data.labels.push(label);
            chart.data.datasets.forEach((dataset) => {
            dataset.data.push(data);
        });
            chart.update();
        }

function chartDataConstructor(ajax_form_data) {
	  	//date contructor
			var d = new Date();
			var curr_date = d.getDate();
			var curr_month = d.getMonth();
			curr_month++;
			var curr_year = d.getFullYear().toString().substr(-2);
			//switch for types to get correct chart object name	
          	var type = parseInt(ajax_form_data["type"]);
          	
				switch (type) {
				    case 1:
				        var chart = chart1;
				        break;
				    case 2:
				        var chart = chart2;
				        break;
				    case 3:
				  		 var chart = chart3;
				        break;
				    case 4:
				  		 var chart = chart4;
				        break;
				    case 5:
				   		var chart = chart5;
				        break;
				    case 56:
				   		var chart = chart6;
				        break;
				    case 7:
				   		var chart = chart7;
				        break;   
				    case 8:
				   		var chart = chart8;
				        break;
					case 9:
				   		var chart = chart9;
				        break;
				    case 10:
				   		var chart = chart10;
				        break;
				    case 11:
				   		var chart = chart11;
				        break;
				    case 12:
				   		var chart = chart12;
				        break;

				     default: 
						console.log('Error on switch');
				}
			//get data input from form (param value)
           	var	data = ajax_form_data["value"];
           	var	data = parseInt(data);
           	//create date lable (today)
           	var label = curr_month + '-' + curr_date + '-' + curr_year;
     		var label = String(label);
     		//return data
     		// console.log('chart data from chartDataConstructor');
     		// console.log(chart);
     		// console.log(label);
     		// console.log(data);
     		return [chart, label, data];
}

		
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
			if ( $('#'+type).length && action == 'param_form' ) {
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

//journals
         $( '#journal-form' ).submit( function( event ) {
            
  			event.preventDefault(); // Prevent the defau
			// var file_data = $('#tank-img').prop('files')[0]; 
			// console.log(file_data);
   //          var ajax_form_data = $("#tank-form").append('file', file_data);
   //          console.log(ajax_form_data);
   //          var ajax_form_data = $("#tank-form").serializeObject();
   //          console.log(ajax_form_data);



   			console.log('journal submited');
			var data = new FormData(this);
			
			//Form data
			// var form_data = $('#journal-form').serializeArray();
			// $.each(form_data, function (key, input) {
   //  			data.append(input.name, input.value);
			// });
			
			//File data
			// var fileData = $('#journal-img')[0].files[0];
			// var filedata = $('#journal-img');
			// data.append("file", file);


			// $.each($("input[type='file']")[0].files, function(i, file) {
   //  			data.append('file', file);
			// });

			// i = 0;
			for (var pair of data.entries()) {
    			console.log(pair[0]+ ', ' + pair[1]); 
    			// console.log(i++);
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
					$('.global-suc').html('Journal has been logged.');
					$('.global-suc').fadeToggle();
  					$('.global-suc').delay( 2000 ).fadeToggle();
  					$('#journal-form').toggleClass('show');
  					$('.menu-bar').toggleClass('extended');
  					$('.overlay').fadeToggle();
  					$('#journal-form .status').html('What is goin on today?');
    			},
    			error: function (e) {
        			//error
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





//form validation

	 $.validator.addMethod("valueNotEquals", function(value, element, arg){
			  return arg !== value;
			 }, "Please select a parameter type.");

			$('#ajax-form' ).validate({
				rules: {
					value: {
						required: true,
						number: true
					},
					type: { 
						valueNotEquals: "Parameter" 
					}

				},
			 	 invalidHandler: function(event, validator) {
			    // 'this' refers to the form
			    var errors = validator.numberOfInvalids();
			    if (errors) {
			    	console.log('Error 222');
			    } else {
			    	
			    }
			  }
			});

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

//parameters filters
$('.param-filters').click(function() { 
console.log('start');
    var date_start = $('#datepicker-from').datepicker("option", "dateFormat", "yy-mm-dd" ).val()
    var date_end = $('#datepicker-to').datepicker("option", "dateFormat", "yy-mm-dd" ).val()
    var tank_id = getUrlParameter('tank_id');
    var url = "/paramque?" + "tank_id=" + tank_id + "&date_start=" + date_start +"&date_end=" + date_end;
    console.log(url);
  var filter = $(this).attr('value');
    $.ajax({
            url:"/paramque?" + "tank_id=" + tank_id + "&date_start=" + date_start +"&date_end=" + date_end,
            // url:"paramque?tank_id=admin-11111",
          success: function(data){
          	console.log('working');
          	console.log(data);
                //is this even working?
                $('.parameter_overview').html(data);
            }
        }); // end ajax call
    });





    });



