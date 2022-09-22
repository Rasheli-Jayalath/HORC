<?php
include_once "../../../config/config.php";
$IpcClassObj = new IpcClass();

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

        <div class="col-md-12" style="margin-bottom:10px;">
        <a class=" btn btn-warning  btn-md" href="/PMIS/pages/administration/Data_Updation/add_IPC_data.php">Add IPC Data</a>

<?php
$kfiprojectlevel = $IpcClassObj->getActiveIpcNo();

$ipcavailable = "";

while ($ipcrows = $IpcClassObj->dbFetchArray()) {
    $ipcavailable = $ipcrows['ipcno'];
    ?>
                           <button   type="button" class=" btn btn-success  btn-md"   style = "margin-right:5px;float: right;" >Active - <?php echo $ipcrows['ipcno']; ?></button>

<?php

}

if ($ipcavailable == "") {
    ?>

                            <button   type="button" class=" btn btn-danger  btn-md"   style = "margin-right:5px;float: right;" >No Active IPCs</button>

                            <?php
}

?>


      </div>

          <div class="col-md-12 stretch-card" style="padding-left:0px;">

              <!-- Table All Data DIV-->
              <div class="col-md-12" id="table_all_data">



              </div>
              <!-- Table All Data DIV-->

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

function reportgenPageLoad() {

         //var strURL="newTableReport.php?itemids="+strval+"&itemname="+strname;
      var strURL="fetch_controlpaneldata_test.php";
      var req= getXMLHTTP();

      if(req)
        {
          req.onreadystatechange = function() {
                if (req.readyState == 4) {
                  //alert(req.readyState);
                 //alert(str);
                  // only if "OK"
                  if (req.status == 200) {

                    document.getElementById("table_all_data").innerHTML=req.responseText;
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

      function insertipc_data(ipcvid,boqid,ipcqty) {

        //alert(ipcvid+boqid+ipcqty);

          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp1=new XMLHttpRequest();
          } else {  // code for IE6, IE5
            xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
          }

          xmlhttp1.onreadystatechange=function() {
            if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {

                //document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
            }
          }
          xmlhttp1.open("GET","add_ipcv_data.php?ipcvid="+ipcvid+"&boqid="+boqid+"&ipcqty="+ipcqty);
          xmlhttp1.send();
          }

          function updateipc_data(ipcid,boqid,ipcqty) {


                //alert(boqid+ipcqty);

                  if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp1=new XMLHttpRequest();
                  } else {  // code for IE6, IE5
                    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
                  }

                  xmlhttp1.onreadystatechange=function() {
                    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {

                        //document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
                    }
                  }
                  xmlhttp1.open("GET","update_ipcv_data.php?ipcid="+ipcid+"&boqid="+boqid+"&ipcqty="+ipcqty);
                  xmlhttp1.send();
                  }

      </script>



      <!-- Page Load Function -->

<!-- Page Load Function -->
  <script>
      window.onload = function() {

        //var secondOptionText = document.getElementById('lastSelectedDropItemName').value;
          //alert(secondOptionText);
          reportgenPageLoad();
      };
  </script>

</body>

</html>