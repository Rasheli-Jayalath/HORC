<?php include_once("../../config/config.php"); 
$objDb  		= new Database();
$objDb3 		= new Database();
?>
<style>
.highcharts-figure,
.highcharts-data-table table {
    min-width: 360px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}</style>

<!DOCTYPE html>
<head>
 <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
      <script src = "https://code.highcharts.com/highcharts.js"></script> 
      <script src = "https://code.highcharts.com/highcharts-more.js"></script>    
      <script src = "https://code.highcharts.com/modules/data.js"></script>  
  <script>
  var chart;
  $(document).ready(function() {
	   
     var options = {
        chart: {
           renderTo: 'container',
           type: 'line',
        },
        title: {
        },
        xAxis: {
           type: 'datetime'
        },
        yAxis: {
        },
        series: [{
           name: 'Planned',
           data: []
       }, {
           name: 'Actual',
           data: []
        }]
     };
     $.getJSON('act_graph.php', function(json) {
		
        val1 = [];
        val2 = [];
        $.each(json, function(key,value) {
        val1.push([value[0], value[1]]);
		val2.push([value[0], value[2]]);
        });

        options.series[0].data = val1;
        options.series[1].data = val2;
        chart = new Highcharts.Chart(options);
     });
  });
  </script>
</head>

<div id="container"></div>