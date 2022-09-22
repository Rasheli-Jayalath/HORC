<?php
include_once "../../../config/config.php";

$objDb  		= new Database();
$objDb1  		= new Database();
$objAdminUser   = new AdminUser();
@require_once("get_url.php");
$pSQL = "SELECT max(pid) as pid from project";

						 $pSQLResult = $objDb->dbQuery($pSQL);
						 $pData = $objDb->dbFetchArray();
						 $pid=$pData["pid"];
						 
if(isset($_REQUEST['lid']))
{
$lid=$_REQUEST['lid'];
$pdSQL1="SELECT * FROM structures WHERE  lid = ".$lid;
 $pdSQLResult1 = $objDb->dbQuery($pdSQL1);
 $pdData1 = $objDb->dbFetchArray();
 $title=$pdData1['title'];
 $code=$pdData1['code'];
 $lid=$pdData1['lid'];
}
if(isset($_REQUEST['action'])&&$_REQUEST['action']=='del'&&isset($_REQUEST['lid'])&$_REQUEST['lid']!="")
{

//$pdSQL = "SELECT * FROM  project_photos WHERE pid = ".$pid." and lid=".$lid." and ph_cap=$lid";
//$objDb->dbQuery($pdSQL);
//$sql_num = $objDb->totalRecords();
/*if($sql_num>=1)
{
	$message="Delete its photos first, then you will be able to delete";
	 $activity= $lid."_".$_REQUEST['lid']." - Delete its photos first, then you will be able to delete";
	//$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
	//$objDb->dbQuery($iSQL);
}
else
{*/
 $objDb->dbQuery("Delete from structures where lid=".$_REQUEST['lid']);
 $message="Component deleted successfully";
 $activity= $lid."_".$_REQUEST['lid']." - deleted successfully";
 $iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb->dbQuery($iSQL);
 header("Location: project_structure.php");
//}

}


if(isset($_REQUEST['save']))
 {
	 ///BOQ Project Level Details///////////
	 $bSQL = "SELECT * FROM  boqdata where itemid=1";
	 $pSQLResult = $objDb->dbQuery($bSQL);
	 $bData = $objDb->dbFetchArray();
	 $parentcd=$bData["itemid"];
	 $parentgroup1=$bData["parentgroup"];
						
    $title=$_REQUEST['title'];
	$code=$_REQUEST['code'];
	$parent_album=0;
	$lid=$objAdminUser->genCode("structures", "lid");
	$sql_pro=$objDb1->dbQuery("INSERT INTO  structures(pid, title,code) Values(".$pid.", '".$title."' , '".$code."' )");
	$insert_record=$lid;
	$parent_album=0;
	$status=1;
	$album_name=$title;
	if ($sql_pro == TRUE) {
		$albumid=$objAdminUser->genCode("t031project_albums", "albumid");
		$sql_pro0="INSERT INTO t031project_albums(albumid,pid, album_name, status,parent_album,lid) 
		Values(".$albumid.", ".$pid.", '".$album_name."' , ".$status.", '".$parent_album."', ".$lid.")";
	$sql_pro=$objDb->dbQuery($sql_pro0);
	
	if($parent_album==0)
		{
		
			if(strlen($albumid)==1)
			{
			$parent_group="00".$albumid;
			}
			else if(strlen($albumid)==2)
			{
			$parent_group="0".$albumid;
			}
			else
			{
			$parent_group=$albumid;
			}
		}
	$sql_pro="UPDATE t031project_albums SET parent_group='$parent_group' where albumid=$albumid";
	
	$sql_proresult=$objDb1->dbQuery($sql_pro);
	///////////////////////////Map & Drawing//////////////////////
		$albumid=$objAdminUser->genCode("t031project_drawingalbums", "albumid");
		$sql_pro1="INSERT INTO t031project_drawingalbums(albumid,pid, album_name, status,parent_id,lid) 
		Values(".$albumid.", ".$pid.", '".$album_name."' , ".$status.", '".$parent_album."', '".$lid."')";
		$sql_pro=$objDb->dbQuery($sql_pro1);
	
	if($parent_album==0)
		{
		
			if(strlen($albumid)==1)
			{
			$parent_group="00".$albumid;
			}
			else if(strlen($albumid)==2)
			{
			$parent_group="0".$albumid;
			}
			else
			{
			$parent_group=$albumid;
			}
		}
	$sql_pro="UPDATE t031project_drawingalbums SET parent_group='$parent_group' where albumid=$albumid";
	
	$sql_proresult=$objDb1->dbQuery($sql_pro);
	
	//End Maps and Drawing Entry
	
	///////////////////////////BOQ Entry//////////////////////
		$itemid=$objAdminUser->genCode("boqdata", "itemid");
		$activitylevel=1;
		$stage="BOQ";
		$factor=0;
		$itemcode=$code;
		$itemname=$title;
		$weight=0;
		$isentry=0;
		$aorder=0;
		
		echo $sql_pro1="INSERT INTO boqdata(itemid,parentcd, parentgroup, activitylevel,stage,factor,itemcode,itemname,weight, isentry, aorder,lid) 
		Values(".$itemid.", ".$parentcd.", '".$parentgroup1."' , '".$activitylevel."' , '".$stage."' , '".$factor."' , '".$itemcode."' , '".$itemname."' , '".$weight."' , '".$isentry."' , '".$aorder."' , '".$lid."')";
		$sql_pro=$objDb->dbQuery($sql_pro1);
	 
	if($parentcd==1)
		{		
			if(strlen($itemid)==1)
			{
			$parent_group="00000".$itemid;
			}
			else if(strlen($itemid)==2)
			{
			$parent_group="0000".$itemid;
			}
			else if(strlen($itemid)==3)
			{
			$parent_group="000".$itemid;
			}
			else if(strlen($itemid)==4)
			{
			$parent_group="00".$itemid;
			}
			else if(strlen($itemid)==5)
			{
			$parent_group="0".$itemid;
			}
			else
			{
			$parent_group=$itemid;
			}
		}
		$parent_group=$parentgroup1."_".$parent_group;
	$sql_pro="UPDATE boqdata SET parentgroup='$parent_group' where itemid=$itemid";
	
	$sql_proresult=$objDb1->dbQuery($sql_pro);
	
	//End BOQ entry
	
    $message=  "New record added successfully";
	$activity= $lid."_".$insert_record." - New record added successfully";
	} 
	
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
	$objDb->dbQuery($iSQL);
	$title="";
	$lid="";
	//header("Location: project_structure.php");
	
}

if(isset($_REQUEST['action'])&&$_REQUEST['action']=="edit"&&$_SERVER['REQUEST_METHOD'] == "POST"&&isset($_REQUEST['lid']))
{
 $title=$_REQUEST['title'];
	$code=$_REQUEST['code'];	

 $lid=$_REQUEST['lid'];
	  $sql_pro="UPDATE  structures SET title='$title', code='$code' where lid=$lid";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	$sql_pro="UPDATE  t031project_albums SET album_name='$title' where lid=$lid";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	$sql_pro="UPDATE  t031project_drawingalbums SET album_name='$title' where lid=$lid";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
		$sql_pro="UPDATE  boqdata SET itemname='$title', itemcode='$code' where lid=$lid";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity= $lid."_".$lid." - Record updated successfully";
	} else {
		$message= mysqli_error($db);
		$activity= mysqli_error($db);
	}
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb->dbQuery($iSQL);
	$title="";
	$lid="";
header("Location: project_structure.php");
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.location.reload();";
    print "self.close();";
    print "</script>";
}
?>
<script>
  function required(){
	
	var x =document.getElementById("title").value;
	
	 if (x == "") {
    alert("Provide Structure Name");
    return false;
  		}
		
  
  }
</script>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Project</title>

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
<script type="text/javascript" src="../../../JsCommon.js"></script>
<script>


function CheckProjectDetail(frm){
	var msg = "<?php echo "Please do the following:";?>\r\n-----------------------------------------";
	var flag = true;

	if(frm.txtpdetail.value == ""){
		msg = msg + "\r\n<?php echo "Project Detail is required field";?>";
		flag = false;
	}
	if(frm.txtpstart.value == ""){
		msg = msg + "\r\n<?php echo "Project Start Date is required field";?>";
		flag = false;
	}
	if(frm.txtpend.value == ""){
		msg = msg + "\r\n<?php echo "Project End Date is required field";?>";
		flag = false;
	}
	
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>

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

                <h2 style="text-align:center">Project Structure</h2>
                <hr>

                    <form action="" target="_self" method="post"  enctype="multipart/form-data" onsubmit="return required();">

                   

                    <div class="container">

                        <div class="row">
  <h3 style="text-align:center"><?php echo $message; ?></h3>
                            <div class="col">
                             <div class="form-group row">

                                <div class="col-md-12">
                                <label for="" class="col-sm-6" >Structure Code </label>
                                    <input placeholder="Enter Code" type="text" name="code" id="code"   minlength="" maxlength=""     required  class="form-control form-control-enhanced" >
                                </div>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group row">

                                    <div class="col-md-12">
                                    <label >Structure Title </label>
                                      <input placeholder="Enter Title" type="text" name="title" id="title"   minlength="" maxlength=""     required  class="form-control form-control-enhanced" >
                                       
                                    </div>
                              </div>
                            </div>


                        </div>
                        <div class="row">

                            <div class="col">

                              <div class=" row">
                              <label for=""></label>
                              <div class="col-sm-6">
                              <?php if(isset($_REQUEST['lid']))
	 {
		 
	 ?>
     <input type="hidden" name="lid" id="lid" value="<?php echo $_REQUEST['lid']; ?>" />
    <button   type="submit" name="update" id="update" value="<?php echo "Update";?>" class="btn bg-success m-auto text-white btn-sm" style="font-weight:500"/>
	 <?php
	 }
	 else
	 {
	 ?>
	 <input   type="submit" name="save" id="save" value="<?php echo "Save";?>" class="btn bg-success m-auto text-white btn-sm" style="font-weight:500"/>
	 <?php
	 }
	 ?> 
                             
                              

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
          <br/>
        <div class="row">

          <div class="col-md-10 m-auto  stretch-card">

            <div class="card">
            
                <div class="col-md-10 m-auto py-4">
				
                <h2 style="text-align:center"> </h2>
               
<div class="table-responsive">
 
   
  <table class="table table-striped">
                              <thead>
                                <tr class="bg-form" style="font-size:12px; color:#CCC;">
                                  <th >#</th>
                                   <th ><?php echo "Structure Code";?></th>
                                  <th ><?php echo "Structure Name";?></th>
                                   <th style="text-align:center"><?php echo "Actions";?></th>
								
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						
						 $pdSQL = "SELECT lid, pid, title,code FROM  structures WHERE pid=".$pData["pid"]." order by lid";
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=0;
							  if($objDb->totalRecords()>=1)
							  {
							  while($pdData = $objDb->dbFetchArray())
							  { 
							  $i++;
							  ?>
                        <tr>
                          <td ><?php echo $i;?></td>
                          <td ><?php echo $pdData['code'];?></td>
                          
                          <td align="left"><?php echo $pdData['title'];?></td>
                         
						   <td align="right"><a href="project_structure.php?lid=<?php echo $pdData['lid'] ?>&action=edit" class="btn btn-outline-info btn-sm">Edit</a><?php /*?><a href="project_structure.php?lid=<?php echo $pdData['lid'] ?>&action=del" onclick="return confirm('<?php echo "Are you sure, You want to delete this component and its photos";?>')" class="btn btn-primary btn-rounded btn-fw">Delete</a><?php */?>
						    
						  </span>
						 </td>
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
      </div>                  
                    
       </div>         </div>
            </div>
            </div>



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





</body>

</html>