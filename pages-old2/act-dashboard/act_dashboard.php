<?php
include_once("../../config/config.php");
include_once("rs_lang.admin.php");
$ObjKfiDash = new ActDashboard();
$ObjKfiDash2 = new ActDashboard();
$ObjKfiDash3 = new ActDashboard();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Activity Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
   <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- <link rel="stylesheet" href="../../vendors/datatables.net-bs4/dataTables.bootstrap4.css"> -->
  <!-- <link rel="stylesheet" href="../../js/select.dataTables.min.css"> -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../css/basic-styles.css">
 <!-- endinject -->
 
  <script src="../../js/jquery.min.js"></script>
  <script type="text/javascript" src="../../datepickercode/jquery-ui.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
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
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'CCORR-02-Construction of Ring Road'
            },
            subtitle: {
                text: 'Progress To-Date '
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
                    text: '% Done'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' ';
                }
            },
            legend: {
            layout: 'vertical',
            align: 'left',
            x: 90,
            verticalAlign: 'top',
            y: 50,
            floating: true/*,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'*/
        },
            series: [
		{
                name: 'Actual Progress: <span style="color:blue">83.25%</span>',
                
                data: [
				[Date.UTC(2015,4,31) , 22374878 ] , [Date.UTC(2015,5,30) , 55926499 ] , [Date.UTC(2015,6,31) , 91706721 ] , [Date.UTC(2015,7,31) , 128979764 ] , [Date.UTC(2015,8,30) , 167294405 ] , [Date.UTC(2015,9,31) , 206482645 ] , [Date.UTC(2015,10,30) , 246760811 ] , [Date.UTC(2015,11,31) , 288172707 ] , [Date.UTC(2016,0,31) , 338087671 ] , [Date.UTC(2016,1,29) , 401141794 ] , [Date.UTC(2016,2,31) , 471589279 ] , [Date.UTC(2016,3,30) , 544921049 ] , [Date.UTC(2016,4,31) , 626971115 ] , [Date.UTC(2016,5,30) , 747131376 ] , [Date.UTC(2016,6,31) , 910726249 ] , [Date.UTC(2016,7,31) , 1134587541 ] , [Date.UTC(2016,8,30) , 1419130050 ] , [Date.UTC(2016,9,31) , 1752825091 ] , [Date.UTC(2016,10,30) , 2146801166 ] , [Date.UTC(2016,11,31) , 2603940295 ] , [Date.UTC(2017,0,31) , 3127234245 ] , [Date.UTC(2017,1,28) , 3722087424 ] , [Date.UTC(2017,2,31) , 4395605721 ] , [Date.UTC(2017,3,30) , 5146338600 ] , [Date.UTC(2017,4,31) , 5975368481 ] , [Date.UTC(2017,5,30) , 6850574181 ] , [Date.UTC(2017,6,31) , 7797242519 ] , [Date.UTC(2017,7,31) , 8813397733 ] , [Date.UTC(2017,8,30) , 9879576157 ] , [Date.UTC(2017,9,31) , 10984574176 ] , [Date.UTC(2017,10,30) , 12301922981 ] , [Date.UTC(2017,11,31) , 13909070552 ] , [Date.UTC(2018,0,31) , 15822539326 ] , [Date.UTC(2018,1,28) , 18058657603 ] , [Date.UTC(2018,2,31) , 20553062069 ] , [Date.UTC(2018,3,30) , 23232964717 ] , [Date.UTC(2018,4,31) , 26094976638 ] , [Date.UTC(2018,5,30) , 29085254802 ] , [Date.UTC(2018,6,31) , 32245723186 ] , [Date.UTC(2018,7,31) , 35539956156 ] , [Date.UTC(2018,8,30) , 39159349810 ] , [Date.UTC(2018,9,31) , 43314963764 ] , [Date.UTC(2018,10,30) , 47934826554 ] , [Date.UTC(2018,11,31) , 53286411988 ] , [Date.UTC(2019,0,31) , 58996725922 ] , [Date.UTC(2019,1,28) , 65012115923 ] , [Date.UTC(2019,2,31) , 71275331659 ] , [Date.UTC(2019,3,30) , 77785569776 ] , [Date.UTC(2019,4,31) , 84649994945 ] , [Date.UTC(2019,5,30) , 91791462004 ] , [Date.UTC(2019,6,31) , 99152830525 ] , [Date.UTC(2019,7,31) , 106614299275 ] , [Date.UTC(2019,8,30) , 114193142558 ] , [Date.UTC(2019,9,31) , 121881049695 ] , [Date.UTC(2019,10,30) , 129666083491 ] , [Date.UTC(2019,11,31) , 137485218691 ] , [Date.UTC(2020,0,31) , 145462037812 ]       
                ],
				marker: {
               
                 radius : 1
            }
            }
			
			,{
                name: 'Planned: <span style="color:blue">91.82%</span>',
                data: [
				[Date.UTC(2015,4,31) , 22374878 ] , [Date.UTC(2015,5,30) , 55926499 ] , [Date.UTC(2015,6,31) , 91706721 ] , [Date.UTC(2015,7,31) , 128979764 ] , [Date.UTC(2015,8,30) , 167294405 ] , [Date.UTC(2015,9,31) , 206482645 ] , [Date.UTC(2015,10,30) , 246760811 ] , [Date.UTC(2015,11,31) , 288172707 ] , [Date.UTC(2016,0,31) , 338087671 ] , [Date.UTC(2016,1,29) , 401141794 ] , [Date.UTC(2016,2,31) , 471589279 ] , [Date.UTC(2016,3,30) , 544921049 ] , [Date.UTC(2016,4,31) , 626971115 ] , [Date.UTC(2016,5,30) , 747131376 ] , [Date.UTC(2016,6,31) , 910726249 ] , [Date.UTC(2016,7,31) , 1134587541 ] , [Date.UTC(2016,8,30) , 1419130050 ] , [Date.UTC(2016,9,31) , 1752825091 ] , [Date.UTC(2016,10,30) , 2146801166 ] , [Date.UTC(2016,11,31) , 2603940295 ] , [Date.UTC(2017,0,31) , 3127234245 ] , [Date.UTC(2017,1,28) , 3722087424 ] , [Date.UTC(2017,2,31) , 4395605721 ] , [Date.UTC(2017,3,30) , 5146338600 ] , [Date.UTC(2017,4,31) , 5975368481 ] , [Date.UTC(2017,5,30) , 6850574181 ] , [Date.UTC(2017,6,31) , 7797242519 ] , [Date.UTC(2017,7,31) , 8813397734 ] , [Date.UTC(2017,8,30) , 9879576158 ] , [Date.UTC(2017,9,31) , 10984574177 ] , [Date.UTC(2017,10,30) , 12301922981 ] , [Date.UTC(2017,11,31) , 13910045552 ] , [Date.UTC(2018,0,31) , 15826214326 ] , [Date.UTC(2018,1,28) , 18065084009 ] , [Date.UTC(2018,2,31) , 20566819382 ] , [Date.UTC(2018,3,30) , 23260853614 ] , [Date.UTC(2018,4,31) , 26136997118 ] , [Date.UTC(2018,5,30) , 29142306865 ] , [Date.UTC(2018,6,31) , 32317806832 ] , [Date.UTC(2018,7,31) , 35627579525 ] , [Date.UTC(2018,8,30) , 39263807070 ] , [Date.UTC(2018,9,31) , 43441101068 ] , [Date.UTC(2018,10,30) , 48089780661 ] , [Date.UTC(2018,11,31) , 53505998486 ] , [Date.UTC(2019,0,31) , 59417686898 ] , [Date.UTC(2019,1,28) , 65734621748 ] , [Date.UTC(2019,2,31) , 72307290622 ] , [Date.UTC(2019,3,30) , 79137930496 ] , [Date.UTC(2019,4,31) , 86363127210 ] , [Date.UTC(2019,5,30) , 93963618662 ] , [Date.UTC(2019,6,31) , 101960797480 ] , [Date.UTC(2019,7,31) , 110151366260 ] , [Date.UTC(2019,8,30) , 118474417551 ] , [Date.UTC(2019,9,31) , 126997663021 ] , [Date.UTC(2019,10,30) , 135681085030 ] , [Date.UTC(2019,11,31) , 144478427830 ] , [Date.UTC(2020,0,31) , 153582379680 ] , [Date.UTC(2020,1,29) , 162893804000 ] , [Date.UTC(2020,2,31) , 172340688841 ] , [Date.UTC(2020,3,30) , 181815270759 ] , [Date.UTC(2020,4,31) , 191329881147 ] , [Date.UTC(2020,5,30) , 200902354681 ] , [Date.UTC(2020,6,31) , 210483578215 ]                  
                ]
            ,
				marker: {
               
                 radius : 1
            }}
			,
			{ name: 'Current Work Rate (Per Day): <span style="color:blue">0.05%</span>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Required Rate (Per Day): <span style="color:blue">0.11%</span>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Projected Completion Date with Current Rate: <span style="color:blue">08-Jan-2021</span>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }},
				{ name: 'Planned Completion Date: <span style="color:blue">04-Jul-2020</span>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
			]
        });
    });
    

		</script>
 <!--  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

// Load the Visualization API and the piechart package.
google.charts.load('current', {'packages':['corechart']});
	
</script>-->

</head>

<body>
     
  <!-- Spinner -->
  <div class="text-center" style="  position: absolute; left: 50%; top: 50%; z-index: 1;">
      <div id="spinner" style="width: 60px; height: 60px;" class="spinner-border text-primary" role="status">
           <span class="sr-only"></span>
      </div>
  </div>
 <!-- Spinner -->

  <div class="container-scroller">
    
     <!-- partial:partials/_navbar.html -->
     <div id="partials-navbar"></div>
     <!-- partial -->
 
     <div class="container-fluid page-body-wrapper" id="pagebodywraper">
     
 
       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->

      <div class="main-panel " id="mainpanel">
      <div class="content-wrapper" style="padding : 20px 29.5px ;">
      <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" onclick="location.reload();" role="tab" aria-controls="overview" aria-selected="true">Back to Top</a>
                    </li>
                  
                    <li class="nav-item">
                    <a id="offcanvabutton" class="nav-link" id="filter-tab"  data-bs-toggle="offcanvas" 
                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" href="#demographics" role="tab" aria-selected="false">Filter by Items</a>
                    </li>
                    
                    
                  </ul>
                  <div>
                    <div class="btn-wrapper">
                      <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                      <a href="#" class="btn btn-otline-dark" ><i class="icon-printer"></i> Print</a>
                      <a href="#" class="btn btn-primary text-white me-0" onclick="exportReportToExcel('xlsx')"><i class="icon-download"></i> Export</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      </div>






          <!-- Page Data Goes Here -->
            <!-- Page Data Goes Here -->

            <!-- OFF CANVAS -->
            <!-- OFF CANVAS -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
              <div class="offcanvas-header">
                <h2 class="offcanvas-title" id="offcanvasExampleLabel">Activity Monitoring Dashboard</h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <!-- <div>
                Please Choose From Dropdowns...
                </div> -->

                <div class="row" style="margin-top: 20px;">

                  <div class="form-group" id="formgrop1">

                <form class="forms-sample" style="text-align: center;" action="#">

                  <select class="form-control" style="color: #444;" id="selectBox1" onchange="getprolevel(this);">
                        <option class="text-muted" value="0">Component/Package</option>

                      <?php        

                          $ObjKfiDash->setProperty("prolvlid",0); 
						  
                          $kfiprojectlevel = $ObjKfiDash->getActvityLevel(); 
 
                        while($plevelrows=$ObjKfiDash->dbFetchArray())
                          {
							  $project_name=$plevelrows['itemname'];
                            ?>
                           
                           <option value="<?php echo $plevelrows['itemid']; ?>"><?php echo $plevelrows['itemname']; ?></option>; 

                            <?php
                          }

                        ?>

                   </select>

                   <div id="seconddiv"></div>

                   <div id="thirddiv"></div>


                  <input type="hidden" name="lastSelectedDropID" id="lastSelectedDropID" value="1111"/> 
                  <input type="hidden" name="lastSelectedDropItemName" id="lastSelectedDropItemName" value="vvvv"/>   
                  

                  <button type="button" onclick="reportgenButton(lastSelectedDropID.value,lastSelectedDropItemName.value)" class= "btn btn-success" data-bs-toggle="offcanvas"  style="text-align: center; margin-top: 20px;">Generate Report</button>


                </form>

                </div>

                  </div>  


              </div>
            </div>
              <!-- OFF CANVAS -->
              <!-- OFF CANVAS -->

              <br/>
              <div class="row">

                       <table width="100%"  align="left" border="0" style="margin:0">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container1" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table>

                    </div>
 				
                        <!--  <div id="line_chart"></div>    
                                -->
              <div class="table-responsive" id="table_report" style = "margin: auto; align-items: center; justify-content: center;"  >
 
             
              

                    </div>
                   

              <!-- Page Data Goes Here -->
                <!-- Page Data Goes Here -->

   
        <!-- partial:../../partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->

         </div>     <!--content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
 <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../../vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  
  <!-- Custom js for this page-->
  <script src="../../js/dashboard.js"></script>
  <script src="../../js/Chart.roundedBarCharts.js"></script>
  <!-- <script src="js/navtype_session.js"></script> -->
  <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

  <!-- End custom js for this page-->


  <!-- End custom js for this page-->



  <script>
    $(function(){
      $("#partials-navbar").load("../../partials/_navbar.php");
    });
</script>

<script>
  $(function(){
    $("#partials-theme-setting-wrapper").load("../../partials/_settings-panel.php");
  });
</script>

<script>
  $(function(){
    $("#partials-sidebar-offcanvas").load("../../partials/_sidebar.php");
  });
</script>

<script>
$(function(){
  $("#partials-footer").load("../../partials/_footer.php");
});
</script>


<script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }

function getprolevel(a){
    
  //alert(a.options[a.selectedIndex].value ) ; //project level value alert 
  var prolvlid = (a.value || a.options[a.selectedIndex].value);  
    var itemname = (a.text || a.options[a.selectedIndex].text); 

  if(prolvlid=="" || prolvlid==0)
  {
    //alert(itemname);
    document.getElementById("lastSelectedDropID").value = prolvlid;
    document.getElementById("lastSelectedDropItemName").value = itemname;
    document.getElementById("dynadiv"+prolvlid).style.display="none";
    document.getElementById("seconddiv").style.display="none";
  
  }
  else
  {
  
    document.getElementById("lastSelectedDropID").value = prolvlid;
    document.getElementById("lastSelectedDropItemName").value = itemname;
	  
    document.getElementById("dynadiv"+prolvlid).style.display="block";
	
    document.getElementById("seconddiv").style.display="block";
  }

    var strURL="getActivityLeveldata.php?prolvlid="+prolvlid;
    var req= getXMLHTTP();

    if(req)
    {
      req.onreadystatechange = function() {
            if (req.readyState == 4) {
              //alert(req.readyState);
            // alert(req.status);
              // only if "OK"
              if (req.status == 200) {
                
             document.getElementById("seconddiv").innerHTML=req.responseText;
              // alert(req.responseText);			
              } else {
                
                alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
              }
            }				
          }			
          req.open("GET", strURL, true);
          req.send(null);strURL
    }

}

function getsublevel(a){
 
  //alert(a.options[a.selectedIndex].value );
     // componant level and low levels alert
    var sublvlid = (a.value || a.options[a.selectedIndex].value);  
    var itemname = (a.text || a.options[a.selectedIndex].text); 

  

  if(sublvlid=="" || sublvlid==0)
  {
  
    document.getElementById("lastSelectedDropID").value = sublvlid;
    document.getElementById("lastSelectedDropItemName").value = itemname;
    document.getElementById("dynadiv"+sublvlid).style.display="none";
    //alert(sublvlid);

  }
  else
  {
    //defaultdivsPageLoad();
    //var preseleid =  document.getElementById("lastSelectedDropID").value;
    // document.getElementById("dynadiv"+preseleid).style.display="none";
    
    document.getElementById("lastSelectedDropID").value = sublvlid;
    document.getElementById("lastSelectedDropItemName").value = itemname;
    

    /////
    // var displayed = $('#thirddiv').filter(function() {
    // var element = $(this);

    // if(element.css('display') == 'block') {
    
    //     element.remove();
    //     return false;
    // }

    // return true;
    // });
    ////

    document.getElementById("dynadiv"+sublvlid).style.display="block";

    
  }

  var strURL="getActivityLeveldata.php?prolvlid="+sublvlid;
	var req= getXMLHTTP();

    if(req)
  {
    req.onreadystatechange = function() {
					if (req.readyState == 4) {
            //alert(req.readyState);
           // alert(req.status);
						// only if "OK"
						if (req.status == 200) {
              
							document.getElementById("dynadiv"+sublvlid).innerHTML=req.responseText;
             
             // alert(req.responseText);			
						} else {
              
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
  }
 
}

function justAlert(strr1,strr2)
{
  var itemid = strr1;
  var itemname = strr2;
  alert(itemid + itemname); 
}

function funcHideAndSeek(selector)
{
 
  
  var nodes = document.querySelectorAll( selector ),
      node,
      styleProperty = function(a, b) {
        return window.getComputedStyle ? window.getComputedStyle(a).getPropertyValue(b) : a.currentStyle[b];
      };

  [].forEach.call(nodes, function( a, b ) {
    node = a;

    node.style.display = styleProperty(node, 'display') === 'block' ? 'none' : 'block';
  });

 
}

function reportgenButton(strval,itemname) {
      
      
      var strURL="newTableReport_testing.php?itemids="+strval+"&itemname="+itemname;
        showSpinner();
          var req= getXMLHTTP();
		    

          if(req)
            {
              req.onreadystatechange = function() {
                    if (req.readyState == 4) {
                    
                      if (req.status == 200) {
                        
                        document.getElementById("table_report").innerHTML=req.responseText;
						hideSpinner();
                      		
                      } else {
                        
                        alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
                      }
                    }				
                  }			
                  req.open("GET", strURL, true);
                  req.send(null);
            }
			
			

var xhr = new XMLHttpRequest();
 
    xhr.open("GET", "graph.php", true);
    xhr.send(null);
     
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
        {
			
			var array_reponse = xhr.responseText;
			 var array_reponse = xhr.responseText.split("/");//separe les differents champs du str reponse
			var date_range;
			date_range = array_reponse[0];
			date_range=String(date_range);
			var opening;
			opening = array_reponse[3];
			opening=parseInt(opening);
			var planned_data;
			var data1 = new Array();
			planned_data = array_reponse[1].split(",");
			
			for (var i = 0; i < planned_data.length; i++)
			{
				data1[i] = parseFloat(planned_data[i]);
				
			}
			 var chart;
			  var options = {
        chart: {
           renderTo: 'container1',
           type: 'line',
        },
        title: {  text: 'Planned Vs. Actual Progress'
        },
        xAxis: {
           type: 'datetime'
        },
         subtitle: {
        text: 'Progress To-Date'
    },

    yAxis: {
        title: {
            text: '% Done'
        }
    },
		 legend: {
            layout: 'vertical',
            align: 'left',
            x: 50,
            verticalAlign: 'top',
            y: 50,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor)
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
		if(value[2]!=0)
		{
		val2.push([value[0], value[2]]);
		}
        });

        options.series[0].data = val1;
        options.series[1].data = val2;
        chart = new Highcharts.Chart(options);
     });

//-----------------------------------------------

       }
		
    } 
			


          }

function reportgenPageLoad(strval,strname) {
         
            
			var strURL="newTableReport_testing.php?itemids="+strval+"&itemname="+strname;
			
           //var strURL="newTableReport.php?itemids="+strval+"&itemname="+strname;

         var req= getXMLHTTP();
		
 
         if(req)
           {
             req.onreadystatechange = function() {
                   if (req.readyState == 4) {
                     //alert(req.readyState);
                    //alert(str);
                     // only if "OK"
                     if (req.status == 200) {
                       
                       document.getElementById("table_report").innerHTML=req.responseText;

                      hideSpinner();
                     // alert(req.responseText);			
                     } else {
                       
                       alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
                     }
                   }				
                 }			
                 req.open("GET", strURL, true);
                 req.send(null);
           }
		   
		 
		  var xhr = new XMLHttpRequest();
 
    xhr.open("GET", "graph.php", true);
    xhr.send(null);
     
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
        {
			
			var array_reponse = xhr.responseText;
			 var array_reponse = xhr.responseText.split("/");//separe les differents champs du str reponse
			var date_range;
			date_range = array_reponse[0];
			date_range=String(date_range);
			var opening;
			opening = array_reponse[3];
			opening=parseInt(opening);
			var planned_data;
			var data1 = new Array();
			planned_data = array_reponse[1].split(",");
			
			for (var i = 0; i < planned_data.length; i++)
			{
				data1[i] = parseFloat(planned_data[i]);
				
			}
			 var chart;
			  var options = {
        chart: {
           renderTo: 'container1',
           type: 'line',
        },
        title: {  text: 'Planned Vs. Actual Progress'
        },
        xAxis: {
           type: 'datetime'
        },
         subtitle: {
        text: 'Progress To-Date'
    },

    yAxis: {
        title: {
            text: '% Done'
        }
    },
		 legend: {
            layout: 'vertical',
            align: 'left',
            x: 50,
            verticalAlign: 'top',
            y: 50,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor)
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
		if(value[2]!=0)
		{
		
		val2.push([value[0], value[2]]);
		}
		
        });

        options.series[0].data = val1;
        options.series[1].data = val2;
        chart = new Highcharts.Chart(options);
     });

//-----------------------------------------------

       }
		
    } 
		

         }

function defaultdivsPageLoad()
 {
          var strURL="thirddiv_defaultdivs.php";

           var req= getXMLHTTP();
           if(req)
           {
             req.onreadystatechange = function() {
                   if (req.readyState == 4) {
                     //alert(req.readyState);
                    //alert(str);
                     // only if "OK"
                     if (req.status == 200) {
                       
                       document.getElementById("thirddiv").innerHTML=req.responseText;
                     // alert(req.responseText);			
                     } else {
                       
                       alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
                     }
                   }				
                 }			
                 req.open("GET", strURL, true);
                 req.send(null);
           }

         }

        function defaultPageLoadOverdues()
         {
          var secondOptionValue = document.getElementById('selectBox1').options[1].value; 
        var secondOptionText = document.getElementById('selectBox1').options[1].text; 

          var strURL="newTableReport_testing_overdues.php?itemids="+secondOptionValue+"&itemname="+secondOptionText;
           //var strURL="newTableReport.php?itemids="+strval+"&itemname="+strname;

         var req= getXMLHTTP();

         if(req)
           {
             req.onreadystatechange = function() {
                   if (req.readyState == 4) {
                     //alert(req.readyState);
                    //alert(str);
                     // only if "OK"
                     if (req.status == 200) {
                       
                       document.getElementById("table_report").innerHTML=req.responseText;
                     // alert(req.responseText);			
                     } else {
                       
                       alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
                     }
                   }				
                 }			
                 req.open("GET", strURL, true);
                 req.send(null);
           }
         }

          // Function to hide the Spinner
            function hideSpinner() {
                document.getElementById('spinner')
                        .style.display = 'none';
            } 

                  // Function to hide the Spinner
            function showSpinner() {

                    document.getElementById('spinner').style.display = 'block';

                    function refreshTime() {

                        if($('#collapseWidthExample').hasClass('collapse'))
                        {
                          document.getElementById('spinner').style.display = 'none';
                        }

                  }

                  setInterval(refreshTime, 10);

                
            } 


            function generatePDF()
            {
              const element = document.getElementById("table_report");

              var opt = {
                      filename:     'exported.pdf',
                      image:        { type: 'jpeg', quality: 0.98 },
                      html2canvas:  {width:2000,},
                      jsPDF:        { unit: 'in', format: 'A4', orientation: 'landscape' }
                    };

              html2pdf().set(opt).from(element).save();

            }


            function exportReportToExcel(type, fn, dl) {

              

              var tabletitlename = document.getElementById('tabletitlename').innerHTML;
//alert(tabletitlename);

            //   $("#table_report").table2excel({
            //     exclude: ".excludeThisClass",
            //     name: "Sheet 01",
            //     filename: "exporteddatea.xls", // do include extension
            //     preserveColors: false // set to true if you want background colors and font colors preserved
            // });

            var elt = document.getElementById('table_report');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet 1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || (tabletitlename+'.' + (type || 'xlsx')));


            }

</script>

<!-- Page Load Function -->
<!-- Page Load Function -->
  <script>
      window.onload = function() {
        var secondOptionValue = document.getElementById('selectBox1').options[1].value; 
        var secondOptionText = document.getElementById('selectBox1').options[1].text; 
        //var secondOptionText = document.getElementById('lastSelectedDropItemName').value; 
          //alert(secondOptionText);
          reportgenPageLoad(secondOptionValue,secondOptionText);

          defaultdivsPageLoad();
      };



  </script>


</body>

</html>