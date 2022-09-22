   xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
        {
			
			var array_reponse = xhr.responseText;
			 var array_reponse = xhr.responseText.split("/");//separe les differents champs du str reponse
			
			
			var date_range;
			date_range = array_reponse[0];
			date_range=String(date_range);
		
			var planned_data;
			var data1 = new Array();
			planned_data = array_reponse[1].split(",");
			
			for (var i = 0; i < planned_data.length; i++)
			{
				data1[i] = parseInt(planned_data[i]);
				
			}
			alert(data1);
           
//-----------------------------------------------	
//construit le graph


			Highcharts.chart('container1', {

    title: {
        text: 'Solar Employment Growth by Sector, 2010-2016'
    },

    subtitle: {
        text: 'Source: thesolarfoundation.com'
    },

    yAxis: {
        title: {
            text: 'Number of Employees'
        }
    },

    xAxis: {
        accessibility: {
            rangeDescription: 'date_range'
        }
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 2010
        }
    },

    series: [{
        name: 'Planned',
        data: data1
    }, {
        name: 'Actual',
        data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});

//-----------------------------------------------

       }
		else
		{
			//document.getElementById("text_test").innerHTML = "wait...";
		}
    }	