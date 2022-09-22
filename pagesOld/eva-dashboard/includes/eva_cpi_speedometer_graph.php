<table border="0" cellpadding="0px" cellspacing="0px" align="left" width="100%"  style="padding:0; margin:0;" > 
<tr> 
<td align="left" valign="top" width="50%" >

       <?php  $objEva->GetCPIValue($last);
	   while($reportdata = $objEva->dbFetchArray())
	   {
				$CPI=$reportdata['cpi'];
				if($CPI!=0)
				{
				$CPI=$CPI;
				}
				else
				{
					$CPI=0;
				}
	   }
	   $CPI=number_format($CPI,2);
	   $mi=date('m',strtotime($last));
	$yi=date('Y',strtotime($last));
	$days=cal_days_in_month(CAL_GREGORIAN,$mi,$yi);
	
	$last_date=$last;
		?>
        <script type="text/javascript">
$(function () {
	
    $('#container_cpi').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: 'Cost Performance Index'
	    },
	    subtitle: {
                text: 'as on <?php echo date('M, d, Y',strtotime($last_date));?>'
            },
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 2,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'CPI'
	        },
	        plotBands: [{
	            from: 0,
	            to: 0.8,
	            color: '#DF5353' // red
	        }, {
	            from: 0.8,
	            to: 2,
	            color: '#55BF3B' // yellow
	        }]        
	    },
	
	    series: [{
	        name: 'CPI',
	        data: [<?php echo $CPI;?>],
	        tooltip: {
	            valueSuffix: ' '
	        }
	    }]
	
	}
	);
});
		</script>
      <?php /*?>   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
       <?php */?>
        <?php /*?><script>
        $(document).ready(function(){

google.charts.load('current', {'packages':['gauge']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

var data = google.visualization.arrayToDataTable([
['Label', 'Value'],
['Memory', 80],
['CPU', 55],
['Network', 68]
]);

var options = {
width: 400, height: 120,
redFrom: 90, redTo: 100,
yellowFrom:75, yellowTo: 90,
minorTicks: 5
};

var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

chart.draw(data, options);

setInterval(function() {
data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
chart.draw(data, options);
}, 13000);
setInterval(function() {
data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
chart.draw(data, options);
}, 5000);
setInterval(function() {
data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
chart.draw(data, options);
}, 26000);
}

});
</script><?php */?>

        <table width="90%"  align="right" border="0" style="margin:5px 10px 5px 10px">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <?php /*?><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script><?php */?>
<?php /*?><div class="container d-flex justify-container-center">
    <div class="row">
        <div class="col-md-12">
            <div id="chart_div" style="width: 400px; height: 120px;"></div>
        </div>
    </div>
</div><?php */?>
     <div id="container_cpi" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table>
