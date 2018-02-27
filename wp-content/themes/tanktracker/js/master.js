///////////////////
// Master JS File
// by Andy 
///////////////////


$(document).ready(function() {

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


$('.menu-button').click(function() { 
	$('.main-menu').toggleClass('open');
	$('.wrap').toggleClass('open');

});

$('.track-btn').click(function() { 
	$('.form-contain').fadeToggle();
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
        $( '#ajax-form' ).submit( function( event ) {
            
			event.preventDefault(); // Prevent the default form submit.            
			var ajax_form_data = $("#ajax-form").serializeObject();
			var action = ajax_form_data['action'];
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
		           $('.form-contain').fadeToggle();
				   $('.overlay').fadeToggle();
				} else {
					 $('.form-contain').html('There was an error - please contact the administrator. Error 78');
					console.log('form did not submit - error 78');
				}
           	    if ($('#'+type).length && action == 'param_form') {
           		    addData(chart, label, data);
           	    }
			}
       });



         $( '#regi-form' ).submit( function( event ) {
            
            event.preventDefault(); // Prevent the default form submit.            
            
            // serialize the form data
            var ajax_form_data = $("#regi-form").serializeObject();
            //add our own ajax check as X-Requested-With is not always reliable
            // ajax_form_data = ajax_form_data+'&ajaxrequest=true&submit=Submit+Form';
            // console.log(ajax_form_data);
          		
         


           $.post( 
        ajaxurl,
        ajax_form_data,
        function(response) { 
         	
         	reigform();
            
        })
       });       


function reigform(){
	console.log('reg and login work');
}

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

$('.a_tank').click(function() {
	var tank_id = $(this).attr('value');
	console.log(tank_id);
	$('.tank-menu a').each(function(){  
		var link = $(this).attr('name');
		var url = link+'?tank_id='+tank_id;
		$(this).attr('href', url);
	});

});
$('.select_tank').click(function() {
	var tank_id = $(this).attr('value');
	// console.log(tank_id);
	window.location.href = "/overview?tank_id="+tank_id;

});




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


    });


