<?php
session_start();
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
$adminflag=$_SESSION['adminflag'];
if($_SESSION['adminflag']!=1)
{
header("Location: chart1.php");
}
$adminflag=$_SESSION['adminflag'];
include_once("connect.php");
include_once("functions.php");
//===============================================
$file_path="dashboard_data/";
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
function getExtention($type){
	if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
		return "jpg";
	elseif($type == "image/png")
		return "png";
	elseif($type == "image/gif")
		return "gif";
	elseif($type == "application/pdf")
		return "pdf";
	elseif($type == "application/msword")
		return "doc";
	elseif($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		return "docx";
	elseif($type == "text/plain")
		return "doc";
		
}
if(isset($_REQUEST['phid']))
{
$phid=$_REQUEST['phid'];
$pdSQL1="SELECT phid, pid, al_file, ph_cap FROM t027project_gphotos  WHERE pid= ".$pid." and  phid = ".$phid;
$pdSQLResult1 = mysqli_query($db, $pdSQL1) or die(mysqli_error());
$pdData1 = mysqli_fetch_array($pdSQLResult1);
$al_file=$pdData1['al_file'];
$ph_cap=$pdData1['ph_cap'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['phid'])&$_REQUEST['phid']!="")
{
@unlink($al_file.$al_file);
 mysqli_query($db, "Delete from t027project_gphotos where phid=".$_REQUEST['phid']);
 header("Location: sp_gphoto_input.php");
}
$size=50;
$max_size=($size * 1024 * 1024);
if(isset($_REQUEST['save']))
{ 
    $ph_cap=$_REQUEST['ph_cap'];
	//echo $name_array = $_FILES['al_file']['name'];
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	$file_name=genRandom(5)."-".$pid. ".".$extension;
   
	if(($_FILES["al_file"]["type"] == "application/pdf")|| ($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png")&&($_FILES["al_file"]["size"] < $max_size))
	{ 
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
	$sql_pro=mysqli_query($db, "INSERT INTO t027project_gphotos(pid, al_file,ph_cap) Values(".$pid.", '".$file_name."', '".$ph_cap."' )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	} else {
    $message= mysqli_error($db);
	}
	}
	}
	}
	$al_file='';
	
	header("Location: sp_gphoto_input.php");
	
}

if(isset($_REQUEST['update']))
{
$ph_cap=$_REQUEST['ph_cap'];
$pdSQL = "SELECT a.phid, a.pid, a.al_file FROM t027project_gphotos a WHERE pid = ".$pid." and phid=".$phid." order by phid";
$pdSQLResult = mysqli_query($db, $pdSQL);
$sql_num=mysqli_num_rows($pdSQLResult);
$pdData = mysqli_fetch_array($pdSQLResult);
$phid=$_REQUEST['phid'];
$old_al_file= $pdData["al_file"];
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path . $old_al_file);
			}
					
				}
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
		$extension=getExtention($_FILES["al_file"]["type"]);
		$file_name=genRandom(5)."-".$pid. ".".$extension;
  
	if(
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png")&&($_FILES["al_file"]["size"] < $max_size))
	{ 
	
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
    $sql_pro="UPDATE t027project_gphotos SET ph_cap='$ph_cap', al_file='$file_name' where phid=$phid";
	
	$sql_proresult=mysqli_query($db, $sql_pro) or die(mysqli_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysqli_error($db);
	}
	}
	}
	else
	{
	echo "Invalid File Format";
	}
	}
	else
	{
	 $sql_pro="UPDATE t027project_gphotos SET ph_cap='$ph_cap' where phid=$phid";
	
	$sql_proresult=mysqli_query($db, $sql_pro) or die(mysqli_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysqli_error($db);
	}
	}
header("Location: sp_gphoto_input.php");
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Strategic Dashboard </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
    <style>
      .btn-37 {
        padding: 10px;
        box-shadow: 5px 6px 8px #888888;
      } 
      .btn-37:hover {
        padding: 10px;
        box-shadow: 5px 3px 8px #888888;
      } 
      .text-33{
  background-color: #151563;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  padding-bottom: 8px;
  padding-top: 8px;
  border-radius: 10px 10px;
  color: white;
  /* margin-right: 5%; */
  /* right: 5%;
  left: 5%; */
}

.button-33 {
  background-color: #1a1a7d;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  color: white;
  cursor: pointer;
  font-weight: 600;
  margin-left:1%;
  display: inline-block;
  font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
  padding: 5px 2px;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 13px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-33:hover {
  box-shadow: rgba(22, 22, 51,.35) 0 -25px 18px -14px inset,rgba(22, 22, 51,.25) 0 1px 2px,rgba(22, 22, 51,.25) 0 2px 4px,rgba(22, 22, 51,.25) 0 4px 8px,rgba(22, 22, 51,.25) 0 8px 16px,rgba(22, 22, 51,.25) 0 16px 32px;
  transform: scale(1.1) ;
}
      </style>
      </style>



</head>
<body>
<div class="container-scroller" >
    <div class="container-fluid page-body-wrapper full-page-wrapper " >
      <div class="content-wrapper " style="padding-top: 80px; padding-bottom: 50px;">
    <!-- partial:partials/_navbar.php -->   <?php include '../partials/_navbar.php';?>  <!-- partial -->
   

<!-- Page content  -->
<h4 class="text-center text-33" style="  letter-spacing: 4px ; font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"> Photos/Videos </h4> 


<!--  -->

<div class="row" > 
<div class=" col-sm-2" > </div>
  <form id="inputForm"  action="sp_gphoto_input.php" target="_self" method="post" class=" col-sm-8" >

  <div class=" grid-margin stretch-card pt-4" >
              <div class="card " >
                <div class="card-body text-center pb-5 " style="padding-right: 40px;">

				  <?php echo $message; ?>

            <div class="row pt-4 ">
          
            <div class="col-md-1"></div>
                        <div class="col-md-9 ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Photo/Video Caption : </label>
                            <div class="col-sm-8 text-start">
                            <input placeholder="" class=" form-control bg-light text-dark "  type="text" name="ph_cap" id="ph_cap" value="<?php echo $ph_cap;?>"  />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2"> </div>
                        
            </div>

            <div class="row pb-5">
                       <div class="col-md-1"></div>
                        <div class="col-md-9 ">
                          <div class="form-group row">
                            <label class="col-sm-4 text-end pt-1" style="font-weight: 500; font-size: 14px;  ">  Photo : </label>
                            <div class="col-sm-8 text-start">
                            <input placeholder="" class=" form-control bg-light text-dark "  type="file"   name="al_file" id="al_file" value="<?php echo $al_file; ?>"  />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2"> </div>
            </div>
            
    
               

            <?php if(isset($_REQUEST['phid']))
	 {
		 
	 ?>
     <input type="hidden" name="phid" id="phid" value="<?php echo $_REQUEST['phid']; ?>" />
     <button type="submit" name="update" id="update" class="btn btn-primary me-2"  value="Update" style="width:20%;  margin-left: 40px; "> Update </button>
	 <?php
	 }
	 else
	 {
	 ?>
   <button type="submit" name="save" id="save" class="btn btn-primary me-2"  value="Save" style="width:20%; "> Save </button>
   <button class="btn btn-secondary" type="button" style="width:20% ; margin-left : 20px "  onclick="javascript:document.getElementById('inputForm').reset()"  name="cancel" id="cancel" value="Cancel" >Cancel</button>

    
	 <?php
	 }
	 ?> 


            </div>
            
              </div>
            </div>


	  
	  
  
  
  </form> 
  <div class=" col-sm-2 pt-4" > <button type="button" class="col-sm-11 button-33" onclick="history.back()" >  Back </button> </div>
  </div>
<!-- Page content -->

<div style="" class="table-responsive bg-light">
  <table width="100%" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="40%" style="text-align:center">Caption</th>
                                  <th width="45%" style="text-align:center">Photo</th>
								
								  <?php if($adminflag==1)
								  {
								   ?>
								  <th width="10%" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						 $pdSQL = "SELECT phid, pid, al_file, ph_cap FROM t027project_gphotos WHERE pid = ".$pid." order by phid";
						 $pdSQLResult = mysqli_query($db, $pdSQL);
						$i=0;
							  if(mysqli_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysqli_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  ?>
                        <tr>
                          <td class="py-2" align="center"><?php echo $i;?></td>
                          <td class="py-2"  align="center"><?php echo $pdData['ph_cap'];?></td>
                          <td class="py-2"  align="left">  <img src="<?php echo $file_path.$pdData["al_file"];?>"  width="50" height="50"/></td>
                       
						  <?php if($adminflag==1)
								  {
								   ?>
						   <td class="py-2"  align="right">
							   <span style="float:left"><form action="sp_gphoto_input.php?phid=<?php echo $pdData['phid'] ?>" method="post">
                 <button type="submit" name="edit" id="edit" value="Edit" class="btn btn-outline-primary btn-fw px-1  py-1 " >
               <i class="ti-pencil btn-icon-prepend"  style="font-size: 11px;"></i>  
                            </button>
                </form></span><span style="float:right"><form action="sp_gphoto_input.php?phid=<?php echo $pdData['phid'] ?>" method="post">
                <button type="submit" name="delete" id="delete" class="btn btn-outline-danger btn-fw px-1 py-1 m-0" value="Del" onclick="return confirm('Are you sure?')" >
            	   <i class="ti-trash btn-icon-prepend"  style="font-size: 11px;"></i> 
        					</button>
              </form></span>
						   <?php
						   }
						   ?></td>
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

      <!-- partial:partials/_footer.php --> <div class="fixed-bottom">  <?php include '../partials/_footer.php';?> </div><!-- partial -->
  
      </div>

      <!-- content-wrapper ends -->

      
    </div>      

    <!-- page-body-wrapper ends -->
  </div> 
  <!-- container-scroller -->



  <!-- plugins:js -->
  <!-- <script src="../vendors/js/vendor.bundle.base.js"></script> -->
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../vendors/chart.js/Chart.min.js"></script>
  <script src="../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>
  <script src="../js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

