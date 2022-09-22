 <script type="text/javascript">
		
$(function () {
	 Highcharts.setOptions({
      colors: ["#4572A7",'#89A54E',"#DC143C"]
    });
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Earned Value Analysis - Civilworks'
            },
            subtitle: {
                text: 'Period: <?php echo date('M, Y',strtotime($start))." to ".date('M, Y',strtotime($end));?>'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                   month: '%m-%Y',
                year: '%Y'
                }
            },
            yAxis: {
                title: {
                    text: '$ Cost'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' $';
                }
            },
            
            series: [
		{
                name: '<?php echo "Planned";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				<?php echo $objEva->GetPlannedData($start,$end);?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 3
            }
            }
			,
			{
                name: '<?php echo "Earned";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				
				<?php echo $objEva->GetEarnedData($start,$end);?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 3
            }
            }
			,
			{
                name: '<?php echo "Actual";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				
				<?php echo $objEva->GetActualData($start,$end);?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 3
            }
            }
			]
        });
    });
    

		</script>
        
     <div id="container" style="min-width:1200px; height: 400px;"></div>
  