///////////////////
// Chart stuff since getting errors when minifying ugh
// by Andy 
///////////////////

$(document).ready(function() {

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

		});