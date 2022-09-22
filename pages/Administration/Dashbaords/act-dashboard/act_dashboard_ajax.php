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
  <link rel="stylesheet" href="../../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../css/basic-styles.css">
 <!-- endinject -->
 
  <script src="datepickercode/jquery.min.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
 <script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<script src="highcharts/js/modules/jquery.highchartTable.js"></script>
<script src="highcharts/js/highcharts-more.js"></script>
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'PAK-8144-Tarbela 4th Extension Hydropower Project'
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
                name: 'Actual Progress: <span style="color:blue">99.57%</span>',
                
                data: [
				[Date.UTC(2013,11,31) , 2364 ] , [Date.UTC(2014,0,31) , 15208 ] , [Date.UTC(2014,1,28) , 43217 ] , [Date.UTC(2014,2,31) , 96317 ] , [Date.UTC(2014,3,30) , 550798 ] , [Date.UTC(2014,4,31) , 1576484 ] , [Date.UTC(2014,5,30) , 3117950 ] , [Date.UTC(2014,6,31) , 4985665 ] , [Date.UTC(2014,7,31) , 7234425 ] , [Date.UTC(2014,8,30) , 9885431 ] , [Date.UTC(2014,9,31) , 13092744 ] , [Date.UTC(2014,10,30) , 17110416 ] , [Date.UTC(2014,11,31) , 22016765 ] , [Date.UTC(2015,0,31) , 27841158 ] , [Date.UTC(2015,1,28) , 34587221 ] , [Date.UTC(2015,2,31) , 42552357 ] , [Date.UTC(2015,3,30) , 51729051 ] , [Date.UTC(2015,4,31) , 61999580 ] , [Date.UTC(2015,5,30) , 73328819 ] , [Date.UTC(2015,6,31) , 85642104 ] , [Date.UTC(2015,7,31) , 98778653 ] , [Date.UTC(2015,8,30) , 113274021 ] , [Date.UTC(2015,9,31) , 129777919 ] , [Date.UTC(2015,10,30) , 149708582 ] , [Date.UTC(2015,11,31) , 173912116 ] , [Date.UTC(2016,0,31) , 202523456 ] , [Date.UTC(2016,1,29) , 235552204 ] , [Date.UTC(2016,2,31) , 273488901 ] , [Date.UTC(2016,3,30) , 316162742 ] , [Date.UTC(2016,4,31) , 363743506 ] , [Date.UTC(2016,5,30) , 416324579 ] , [Date.UTC(2016,6,31) , 473982863 ] , [Date.UTC(2016,7,31) , 536644665 ] , [Date.UTC(2016,8,30) , 604367474 ] , [Date.UTC(2016,9,31) , 677697466 ] , [Date.UTC(2016,10,30) , 756243358 ] , [Date.UTC(2016,11,31) , 839586296 ] , [Date.UTC(2017,0,31) , 927470805 ] , [Date.UTC(2017,1,28) , 1019370099 ] , [Date.UTC(2017,2,31) , 1115171833 ] , [Date.UTC(2017,3,30) , 1214369145 ] , [Date.UTC(2017,4,31) , 1315879270 ] , [Date.UTC(2017,5,30) , 1419347915 ] , [Date.UTC(2017,6,31) , 1524501647 ] , [Date.UTC(2017,7,31) , 1631178857 ] , [Date.UTC(2017,8,30) , 1739029901 ] , [Date.UTC(2017,9,31) , 1847319827 ] , [Date.UTC(2017,10,30) , 1955965642 ] , [Date.UTC(2017,11,31) , 2064984774 ] , [Date.UTC(2018,0,31) , 2174136912 ] , [Date.UTC(2018,1,28) , 2283624611 ] , [Date.UTC(2018,2,31) , 2393320347 ] , [Date.UTC(2018,3,30) , 2503171834 ] , [Date.UTC(2018,4,31) , 2613394404 ] , [Date.UTC(2018,5,30) , 2723637665 ]       
                ],
				marker: {
               
                 radius : 1
            }
            }
			
			,{
                name: 'Planned: <span style="color:blue">99.74%</span>',
                data: [
				[Date.UTC(2013,11,31) , 2364 ] , [Date.UTC(2014,0,31) , 15209 ] , [Date.UTC(2014,1,28) , 43218 ] , [Date.UTC(2014,2,31) , 96319 ] , [Date.UTC(2014,3,30) , 550800 ] , [Date.UTC(2014,4,31) , 1576487 ] , [Date.UTC(2014,5,30) , 3117953 ] , [Date.UTC(2014,6,31) , 4985667 ] , [Date.UTC(2014,7,31) , 7234427 ] , [Date.UTC(2014,8,30) , 9885432 ] , [Date.UTC(2014,9,31) , 13092744 ] , [Date.UTC(2014,10,30) , 17110414 ] , [Date.UTC(2014,11,31) , 22016762 ] , [Date.UTC(2015,0,31) , 27841155 ] , [Date.UTC(2015,1,28) , 34587218 ] , [Date.UTC(2015,2,31) , 42552355 ] , [Date.UTC(2015,3,30) , 51729048 ] , [Date.UTC(2015,4,31) , 61999580 ] , [Date.UTC(2015,5,30) , 73328812 ] , [Date.UTC(2015,6,31) , 85642096 ] , [Date.UTC(2015,7,31) , 98778644 ] , [Date.UTC(2015,8,30) , 113274008 ] , [Date.UTC(2015,9,31) , 129777866 ] , [Date.UTC(2015,10,30) , 149204188 ] , [Date.UTC(2015,11,31) , 172320542 ] , [Date.UTC(2016,0,31) , 199262006 ] , [Date.UTC(2016,1,29) , 232175877 ] , [Date.UTC(2016,2,31) , 271826215 ] , [Date.UTC(2016,3,30) , 317983231 ] , [Date.UTC(2016,4,31) , 370867584 ] , [Date.UTC(2016,5,30) , 430277653 ] , [Date.UTC(2016,6,31) , 493929722 ] , [Date.UTC(2016,7,31) , 561750095 ] , [Date.UTC(2016,8,30) , 633824084 ] , [Date.UTC(2016,9,31) , 710670085 ] , [Date.UTC(2016,10,30) , 791918549 ] , [Date.UTC(2016,11,31) , 877495190 ] , [Date.UTC(2017,0,31) , 967822782 ] , [Date.UTC(2017,1,28) , 1062354279 ] , [Date.UTC(2017,2,31) , 1160067919 ] , [Date.UTC(2017,3,30) , 1260627705 ] , [Date.UTC(2017,4,31) , 1362941911 ] , [Date.UTC(2017,5,30) , 1466678753 ] , [Date.UTC(2017,6,31) , 1571955316 ] , [Date.UTC(2017,7,31) , 1679030106 ] , [Date.UTC(2017,8,30) , 1787665044 ] , [Date.UTC(2017,9,31) , 1896795962 ] , [Date.UTC(2017,10,30) , 2006126193 ] , [Date.UTC(2017,11,31) , 2115792993 ] , [Date.UTC(2018,0,31) , 2225501215 ] , [Date.UTC(2018,1,28) , 2335481794 ] , [Date.UTC(2018,2,31) , 2445525129 ] , [Date.UTC(2018,3,30) , 2555844976 ] , [Date.UTC(2018,4,31) , 2666211504 ] , [Date.UTC(2018,5,30) , 2776622731 ] , [Date.UTC(2018,6,31) , 2887054562 ] , [Date.UTC(2018,7,31) , 2997486393 ] , [Date.UTC(2018,8,30) , 3107918224 ] , [Date.UTC(2018,9,31) , 3218350055 ] , [Date.UTC(2018,10,30) , 3328781886 ] , [Date.UTC(2018,11,31) , 3439213717 ] , [Date.UTC(2019,0,31) , 3549645548 ] , [Date.UTC(2019,1,28) , 3660077380 ] , [Date.UTC(2019,2,31) , 3660077380 ] , [Date.UTC(2019,3,30) , 3660077380 ] , [Date.UTC(2019,4,31) , 3660077380 ] , [Date.UTC(2019,5,30) , 3660077380 ] , [Date.UTC(2019,6,31) , 3660077380 ]                  
                ]
            ,
				marker: {
               
                 radius : 1
            }}
			,
			{ name: 'Current Work Rate (Per Day): <span style="color:blue">0.06%</span>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Required Rate (Per Day): <span style="color:blue">0.00%</span>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Projected Completion Date with Current Rate: <span style="color:blue">07-Jul-2018</span>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }},
				{ name: 'Planned Completion Date: <span style="color:blue">06-Jul-2019</span>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
			]
        });
    });
    

		</script>
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
                   
                    <!-- <button id="offcanvabutton" type="submit" class= "btn btn-warning" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" style="width: 80px; height:30px;"><i style="font-size:15px; text-align:center;" class="mdi mdi-filter-variant"></i></button> -->
                     
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
     <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table>

                    </div>
 				
                                     
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
      $("#partials-navbar").load("../../partials/_navbar.html");
    });
</script>

<script>
  $(function(){
    $("#partials-theme-setting-wrapper").load("../../partials/_settings-panel.html");
  });
</script>

<script>
  $(function(){
    $("#partials-sidebar-offcanvas").load("../../partials/_sidebar.html");
  });
</script>

<script>
$(function(){
  $("#partials-footer").load("../../partials/_footer.html");
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
          req.send(null);
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