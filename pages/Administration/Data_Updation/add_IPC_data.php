<?php
include_once "../../../config/config.php";
$IpcClassObj = new IpcClass();
$IpcClassObj2 = new IpcClass();
$IpcClassIpcMonth = new IpcClass();

$ipcid = $_POST['ipc_ipcid'];
$ipcno = $_POST['ipc_ipcno'];
$ipcmonth = $_POST['ipc_month'];
//$ipcmonth = substr($resultmonth, 0, 7);

$ipcstartdate = date("Y-m-d", strtotime($_POST['ipc_start_date']));
$ipcenddate = date("Y-m-d", strtotime($_POST['ipc_end_date']));
$ipcsubmitdate = date("Y-m-d", strtotime($_POST['ipc_submit_date']));
$ipcreceivedateID = date("Y-m-d", strtotime($_POST['ipc_receive_date']));

$status = $_POST['ipc_status'];

if (isset($_POST["SubmitAdd"])) {

    $IpcClassObj->setProperty("ipcno", $ipcno);
    $IpcClassObj->setProperty("ipcmonth", $ipcmonth);
    $IpcClassObj->setProperty("ipcstartdate", $ipcstartdate);
    $IpcClassObj->setProperty("ipcenddate", $ipcenddate);
    $IpcClassObj->setProperty("ipcsubmitdate", $ipcsubmitdate);
    $IpcClassObj->setProperty("ipcreceivedateID", $ipcreceivedateID);
    $IpcClassObj->setProperty("status", $status);

    $IpcClasslevel = $IpcClassObj->insertDataIpcTable();

}

if (isset($_POST["SubmitUpdate"])) {

    $IpcClassObj2->setProperty("ipcid", $ipcid);
    $IpcClassObj2->setProperty("ipcno", $ipcno);
    $IpcClassObj2->setProperty("ipcmonth", $ipcmonth);
    $IpcClassObj2->setProperty("ipcstartdate", $ipcstartdate);
    $IpcClassObj2->setProperty("ipcenddate", $ipcenddate);
    $IpcClassObj2->setProperty("ipcsubmitdate", $ipcsubmitdate);
    $IpcClassObj2->setProperty("ipcreceivedateID", $ipcreceivedateID);
    $IpcClassObj2->setProperty("status", $status);

    $IpcClasslevel = $IpcClassObj2->updateDataIpcTable();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add IPC Entry</title>

  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">
  <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
  <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../../css/basic-styles.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />

  <!-- CSS scrollbar style -->
  <link id="pagestyle" href="../../../css/scrollbarStyle.css" rel="stylesheet" />

  <style>
        .margintopCSS {
          margin-top:10px;
        }
    </style>

</head>

<body>
  <div class="container-scroller">

     <!-- partial:partials/_navbar.html -->
     <div id="partials-navbar"></div>
     <!-- partial -->

     <div class="container-fluid page-body-wrapper" id="pagebodywraper">


       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->

      <div class="main-panel" id="mainpanel">
      <div class="content-wrapper">
        <div class="row">

          <div class="col-md-10 m-auto  stretch-card">

            <div class="card bg-form">
                <div class="col-md-8 m-auto py-4" style="color:#fff">

                <h2 style="text-align:center">ADD IPC DATA</h2>
                <hr>

                    <form style="margin-top:10px" action="#" method="post" enctype="multipart/form-data" autocomplete="off" class=" ">

                    <input placeholder="IPC Id" type="hidden" name="ipc_ipcid" id="ipc_ipcid"  minlength="" maxlength=""     required  class="form-control form-control-enhanced" >


                    <div class="container">

                        <div class="row">

                            <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" >IPC No </label>
                                    <input placeholder="Enter IPC Number" type="text" name="ipc_ipcno" id="ipc_ipcno"   minlength="" maxlength=""     required  class="form-control form-control-enhanced" >
                                </div>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group row">

                                    <div class="col-md-12">
                                    <label >Month </label>
                                    <select name="ipc_month" id="ipc_month" class="col-sm-5  form-select  form-control form-control-enhanced" style = "width: 70%;" required>
                                            <option value="0" Checked >Select Month</option>

                                           <?php 
                                           $IpcClassIpcMonthss = $IpcClassIpcMonth->getKpiScaleMonths();

                                           while($ipcmonthrows=$IpcClassIpcMonth->dbFetchArray())
                                                {
                                                  ?>
                                                        <option value="<?php echo $ipcmonthrows['scmonth'].'-01'?>" ><?php echo $ipcmonthrows['scmonth'].'-01'?></option>
                                                  <?php
                                                }

                                           ?> 
                                            
                                        </select>
                                        <!-- <input type="text" name="ipc_month" id="ipc_month"    minlength="  " maxlength="  "     placeholder=""    required  class="form-control form-control-enhanced" > -->
                                    </div>
                              </div>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col">
                                      <div class="form-group row">

                                        <div class="col-md-12">
                                        <label for="">IPC Start Date</label>
                                            <input type="text" name="ipc_start_date" id="ipc_start_date" id="ipc_start_date"   minlength="  " maxlength="  "     placeholder="Select Start Date"    required  class="form-control form-control-enhanced"    >
                                        </div>
                                       </div>
                            </div>
                            <div class="col">
                                      <div class="form-group row">

                                            <div class="col-md-12">
                                            <label for=""  >IPC End Date</label>
                                                <input type="text" name="ipc_end_date" id="ipc_end_date"   minlength="  " maxlength="  "     placeholder="Select End Date"    required  class="form-control form-control-enhanced" >
                                            </div>
                                      </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col">

                                          <div class="form-group row">

                                                <div class="col-md-12">
                                                <label for="">IPC Submit Date</label>
                                                    <input type="text" name="ipc_submit_date" id="ipc_submit_date"   minlength="  " maxlength="  "     placeholder="Select Submit Date"    required  class="form-control form-control-enhanced" >
                                                </div>
                                          </div>
                            </div>
                            <div class="col">

                                <div class="form-group row">

                                      <div class="col-md-12">
                                      <label for=""  > IPC Receive Date	</label>
                                          <input type="text" name="ipc_receive_date" id="ipc_receive_date"   minlength="  " maxlength="  "     placeholder="Select Receive Date"    required  class=" form-control form-control-enhanced" >
                                      </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col">

                              <div class="form-group row">

                              <div class="col-md-12">
                              <label for=""> Status	</label>
                                          <select name="ipc_status" id="ipc_status" class="col-sm-5  form-select  form-control form-control-enhanced" style = "width: 70%;" required>
                                            <option value="0" Checked >Inactive</option>
                                            <option value="1" >Active</option>
                                        </select>
                              </div>
                              </div>

                            </div>

                            <div class="col">

                            </div>

                        </div>

                        <div class="row">

                            <div class="col">

                              <div class=" row">
                              <label for=""></label>
                              <div class="col-sm-6">
                              <button  type="submit" style="font-weight:500" name="SubmitAdd" id="SubmitAdd" value="submit" class="btn bg-success m-auto text-white btn-sm">Save</button>
                              <button   type="submit" style="font-weight:500;display:none;" name="SubmitUpdate" id="SubmitUpdate" value="submit" class="btn bg-warning m-auto text-white btn-sm ">Update</button>

                              </div>
                              </div>

                            </div>

                            <div class="col">

                            </div>

                        </div>


                    </div>




                    </form>

                </div>
            </div>
            </div>



         </div>

         <div class="row"  style = "margin-top: 20px;margin-right:15px; align-items: center; justify-content: center;">

         <table class="table table-striped">
              <tbody>
                <tr class="bg-form" style="font-size:12px; color:#CCC;">

                <th  width="5%"><strong>Sr. No.</strong></th>
                <th  width="2%"><strong>
              <input type="checkbox" name="txtChkAll" id="txtChkAll" form="reports" onclick="group_checkbox();">

                </strong></th>
                <th  width="8%"><strong>IPC No</strong></th>
                <th width="10%"><strong>IPC Month</strong></th>
                <th width="15%"><strong>IPC Start Date</strong></th>
              <th width="15%"><strong>IPC End Date</strong></th>
                <th width="15%"><strong>IPC Submit Date</strong></th>
              <th width="12%"><strong>IPC Receive Date</strong></th>
              <th width="5%" style="text-align:center;"><strong>Status</strong></th>
                <th  width="8%" style="text-align:center;"><strong>Action
              </strong></th>
            <th  width="10%"><strong>Log
              </strong></th>
              </tr>

              <?php

$IpcClassObj2data = $IpcClassObj2->getAllDataIpcTable();

$i = 1;
while ($ipcrows = $IpcClassObj2->dbFetchArray()) {
    ?>


                <tr>
                <td><?php echo $i ?></td>
                <td><input type="checkbox" name="txtChkAll" id="<?php echo $ipcrows['ipcid']; ?>" form="reports" onclick=" "></td>
                <td><?php echo $ipcrows['ipcno']; ?></td>
                <td><?php echo $ipcrows['ipcmonth']; ?></td>
                <td><?php echo $ipcrows['ipcstartdate']; ?></td>
                <td><?php echo $ipcrows['ipcenddate']; ?></td>
                <td><?php echo $ipcrows['ipcsubmitdate']; ?></td>
                <td><?php echo $ipcrows['ipcreceivedate']; ?></td>
                <td><?php if ($ipcrows['status'] == '1') {?><button style="width:70px;text-align:center;" type="button" class="btn btn-success btn-sm">Active</button> <?php } else {?><button style="width:70px;text-align:center;"  type="button" class="btn btn-danger btn-sm">Inactive</button> <?php }?></td>
                <td><button type="button" style="text-align:center;" class="btn btn-outline-info btn-sm" onclick="editbtnclick(<?php echo $ipcrows['ipcid']; ?>)">EDIT</button></td>
                <td><?php echo $ipcrows['status']; ?></td>
                </tr>

                  <?php
$i++;
}

?>


          </tbody>

</table>

         </div>

        <!-- partial:../../../partials/_footer.html -->
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
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../../js/off-canvas.js"></script>
  <script src="../../../js/hoverable-collapse.js"></script>
  <script src="../../../js/template.js"></script>
  <script src="../../../js/settings.js"></script>
  <script src="../../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../../js/chart.js"></script>
  <!-- <script src="../../../js/navtype_session.js"></script> -->
   <!--  commented because of date picker js files
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  -->
  <!-- End custom js for this page-->

 <script>
      $(function(){
        $("#partials-navbar").load("../../../partials/_navbar.php");
      });
  </script>

  <script>
    $(function(){
      $("#partials-theme-setting-wrapper").load("../../../partials/_settings-panel.php");
    });
  </script>

  <script>
    $(function(){
      $("#partials-sidebar-offcanvas").load("../../../partials/_sidebar.php");
    });
</script>

<script>
  $(function(){
    $("#partials-footer").load("../../../partials/_footer.php");
  });
</script>


<!-- Page Load Function -->

<script>
            $(document).ready(function() {

                $(function() {
                    $("#ipc_start_date").datepicker({});
                });

                $(function() {
                    $("#ipc_end_date").datepicker({});
                });

                $(function() {
                    $("#ipc_submit_date").datepicker({});
                });

                $(function() {
                    $("#ipc_receive_date").datepicker({});
                });

                $('#ipc_start_date').change(function() {
                    startDate = $(this).datepicker('getDate');
                    $("#ipc_end_date").datepicker("option", "minDate", startDate);
                })

                $('#ipc_end_date').change(function() {
                    endDate = $(this).datepicker('getDate');
                    $("#ipc_start_date").datepicker("option", "maxDate", endDate);
                })

                $('#ipc_submit_date').change(function() {
                    startDate = $(this).datepicker('getDate');
                    $("#ipc_receive_date").datepicker("option", "minDate", startDate);
                })

                $('#ipc_receive_date').change(function() {
                    endDate = $(this).datepicker('getDate');
                    $("#ipc_submit_date").datepicker("option", "maxDate", endDate);
                })
            })
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

function editbtnclick(ipcid){
  //alert(ipcid);

  var strURL="fetchipcdatafrm_id.php?ipcid="+ipcid;
    var req= getXMLHTTP();

    if(req)
    {
      req.onreadystatechange = function() {
            if (req.readyState == 4) {
              //alert(req.readyState);
            // alert(req.status);
              // only if "OK"
              if (req.status == 200) {

            //alert(req.responseText);

            var ipcid,ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status;

                      var jsonData = JSON.parse(req.responseText);
                      for (var i = 0; i < jsonData.Ipc_detail.length; i++) {
                          var Ipc_detail = jsonData.Ipc_detail[i];

                         ipcid = Ipc_detail.ipcid;
                         ipcno = Ipc_detail.ipcno;
                         ipcmonth = Ipc_detail.ipcmonth;
                         ipcstartdate = Ipc_detail.ipcstartdate;
                         ipcenddate = Ipc_detail.ipcenddate;
                         ipcsubmitdate = Ipc_detail.ipcsubmitdate;
                         ipcreceivedate = Ipc_detail.ipcreceivedate;
                         status = Ipc_detail.status;
                      }
                      //alert(status);
                      document.getElementById("ipc_ipcid").value = ipcid;
                      document.getElementById("ipc_ipcno").value = ipcno;
                      document.getElementById("ipc_month").value = ipcmonth;
                      document.getElementById("ipc_start_date").value = ipcstartdate;
                      document.getElementById("ipc_end_date").value = ipcenddate;
                      document.getElementById("ipc_submit_date").value = ipcsubmitdate;
                      document.getElementById("ipc_receive_date").value = ipcreceivedate;
                      document.getElementById("ipc_status").value = status;
                      document.getElementById("SubmitUpdate").style.display = "block";
                      document.getElementById("SubmitAdd").style.display = "none";




              } else {

                alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
              }
            }
          }
          req.open("GET", strURL, true);
          req.send(null);
    }



}

</script>

</body>

</html>