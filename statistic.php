<?php
/* This is the Training Statistic page that will show the latest completed induction data. 
   It will show a dynamic chart.
*/

//#Region Import API
   ob_start();
   session_start();
   date_default_timezone_set('Australia/Melbourne');

//#End Region   
?>

<html>
<head>
      <!-- [START css] -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" /> 
<link type="text/css" rel="stylesheet" href="/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>

<?php

 $strUserName = $_SESSION['UserName'];
 
?>
    <!-- [END css] -->
	<script type="text/javascript">

$(document).ready(function () {

var ctx = $("#myChart").get(0).getContext("2d");

var datasetvalue = [];
var labels = [];
var dataarr = [];

$.ajax({
	type: "GET",
	url: "getdata.php",
	contentType: "application/json; charset=utf-8",
	dataType: "json",
	success: function (data) {
	
	var objData = JSON.stringify(data);

	for (var key in data) {
       if (data.hasOwnProperty(key))
	    labels.push(key);
		dataarr.push(data[key]);
      }


	datasetvalue[0] = {
			title: 'Category',
			label: 'Category',
			backgroundColor: '#2c3e50',
			strokeColor: "navyblue",
			data: dataarr
		}

		CreateChart(ctx, labels, datasetvalue, false, 'bar', 0, -5, 16, ctx.canvas.width, ctx.canvas.height, objData);

	}
});


function updateBarGraph(chart, label, chartOptions, data) {
	chart.data.datasets.pop();
	chart.data.datasets.push({
		label: label,
		data: data,
		title: 'Category',
		backgroundColor: '#2c3e50',
		strokeColor: "navyblue",
		options: chartOptions
	});
	
	chart.update();
}
function addData(chart, label, data) {
    chart.data.labels = label
    chart.data.datasets.forEach((dataset) => {
        dataset.data = data;
    });
    chart.update();
}
function CreateChart(ctx, labels, data, showlegend, chartType, xvaluepos, yvaluepos, valueFontSize, canvasWidth, canvasHeight,arrvalue) {

	$(function () {
		//Chart options
	
		ctx.canvas.originalwidth = canvasWidth;
		ctx.canvas.originalheight = canvasHeight;

		var chartOptions = {
			legend: {
				display: showlegend,
				position: 'top',
				labels: {
					fontColor: 'rgba(54, 162, 235, 10)',
					fontSize: 16

				}
			},
			title: { text: '', display: true, padding: 10 },
			animation: {
				onComplete: function () {
					var chartType = '';
					var chartInstance = this.chart,
					ctx = chartInstance.ctx;
					// ctx.font = Chart.helpers.fontString(Chart,defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
					ctx.font = Chart.helpers.fontString(Chart, valueFontSize, 'bold', Chart.defaults.global.defaultFontFamily);
					ctx.textAlign = 'center';
					ctx.textBaseline = 'bottom';

					this.data.datasets.forEach(function (dataset, i) {
						chartType = dataset.type;
						ctx.fillStyle = dataset.strokeColor;

						var meta = chartInstance.controller.getDatasetMeta(i);

						meta.data.forEach(function (bar, index) {
							var data = dataset.data[index];

							if (chartType == 'line') {

								if (index == 5) {
									ctx.fillStyle = '#1B2631';
								}

								ctx.fillText(data, bar._model.x + xvaluepos + 15, bar._model.y + xvaluepos);
							}
							else {
								ctx.fillText(data, bar._model.x + xvaluepos, bar._model.y + xvaluepos);
							}


						});
					});
				}
	
			},
			maintainAspectRatio: true,
			scales: {
				xAxes: [{
					display: true,
					ticks: {
						suggestedMax: 60
					},
					gridLines: {
						display: false
					}
				}],
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontSize: 16

					},
					gridLines: {
						display: false
					}
				}]
			}
		};


		//Setup chart
		var myChart = new Chart(ctx, {
			type: chartType,
			data: {
				labels: labels,
				datasets: data

			},
			options: chartOptions
		});

	  
		var dataarr = arrvalue;
		//dataarr = data;
		var newdataarr;

		setInterval(function () {
						
			$.ajax({
				type: "GET",
				url: "getdata.php",
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function (data) {
			        var updatedarr= [];
					newdataarr = data;
					labels=[];
					for (var key in data) {
				   	if (data.hasOwnProperty(key))
						labels.push(key);
						updatedarr.push(data[key]);
					}
				  
				 
					if (JSON.stringify(data) !== dataarr) {
					    addData(myChart, labels, updatedarr);
						dataarr = JSON.stringify(data);

					}
					  
				}
					});
			
		}, 3000);
	
	});
}

});

</script>

<style type="text/css">
	.login-form {
		width: 390px;
		margin: 50px auto;
	}
    .login-form form {        
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
 	.input-group-addon .fa {
        font-size: 18px;
    }
    .input-group{
        width:330px!important;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
        width:50px;
    }
    .TextCenter{
        Text-align:center!important;
    }
    .Message{
        color:LightBlue!important;
    }
    .Padding{
	  padding:10px!important;
	}
	.darkred{
		color:darkred!important;
		margin-left:40px;
		margin-top:-10px;
	}
	canvas{
text-align:center;
width:950px !important;
height:400px !important;

}
    th{
	 background-color: #EFEFEF!important;
	} 
    .table.dataTable tbody td { font-size: 14px!important }
    .table.dataTable thead th, table.dataTable thead td { font-size: 14px!important }
</style>
    </head>
<body>

<form action="/statistic.php" method="post">
<div class="darkred"><h3>Top 5 Completed Courses</h3></div>
<div class="container-fluid padding">
<canvas id="myChart" style="width:800px;height:340px" ></canvas>
</div>

</form>
    
</body>
</html>