<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
$ObjMapDrawing  = new  MapsDrawings();
$ObjMapDrawing2 = new MapsDrawings();
$ObjMapDrawing3 = new MapsDrawings();
$ObjMapDrawing4 = new MapsDrawings();
$objAdminUser 	= new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$_SESSION['ne_user_type'];
//$user_cd=1;
//$_SESSION['ne_user_type']=1;
$data_url="drawings/";
$_SESSION['log_id']=1;

						 $pictomaxpid = $ObjMapDrawing->getMaxPid(); 
						 while($plevelrows=$ObjMapDrawing->dbFetchArray())
						{
						  $pid = $plevelrows['pid'];
						} 
						 
$parent_id=$_REQUEST['parent_id'];						 
						  $pdSQL2 = "SELECT user_right FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and albumid=".$parent_id;
$ObjMapDrawing->dbQuery($pdSQL2);
$result2 =$ObjMapDrawing->dbFetchArray();
//$result2 = mysql_fetch_array($pdSQLResult2);
 $result2['user_right'];
if($_SESSION['ne_user_type']==1)
			{
			}
			else
			{
				$u_rightr=$result2['user_right'];
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			   $arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}
							 if($read_right==2 || $read_right=="")
								  {
									  header("Location: index.php?init=3");
									  }
				
			}
				}
			}
			
if(isset($_REQUEST['delete'])&&isset($_REQUEST['albumid'])&$_REQUEST['albumid']!="")
{
$albumid=$_REQUEST['albumid'];

	   $sql2c="Select albumid from t031project_drawingalbums where parent_id=$albumid";
				$ObjMapDrawing->dbQuery($sql2c);
				if($ObjMapDrawing-> totalRecords()>= 1)
				/*if(mysql_num_rows($res2c)>=1)*/
				{
					
					//$message=  "<span style='color:red;'>You should delete its sub folders(s) first</span>";
					$message=4;
					$activity=$albumid." - You should delete its sub folder(s) firstt";
				
				}
				else
				{
				
			
				
				
			 $sql2t="Select * from t027project_drawings where album_id=$albumid";
				$ObjMapDrawing2->dbQuery($sql2t);
				$row2d =$ObjMapDrawing2->dbFetchArray();
				//$row2d=mysql_fetch_array($res2t);
					if($ObjMapDrawing2-> totalRecords()>= 1)
					{
						//$message=  "<span style='color:red;'>You should delete its Drawings first</span>";
						$message=5;
						 $activity=$albumid." - You should delete its Drawing first";
										
					}
					else
					{
					 $sdeletet= "Delete from t031project_drawingalbums where albumid=$albumid";
					   $ObjMapDrawing3->dbQuery($sdeletet);
						
						 //$message=  "<span style='color:green;'>Drawing folder deleted successfully</span>";
						 $message=3;
						 $activity=$albumid." - drawing folder deleted successfully";
						  
					
					}				
				
				
				}

$log_id = $_SESSION['log_id'];
	
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
$ObjMapDrawing2->dbQuery($iSQL);
header("Location: sp_drawingalbum_input.php?parent_id=".$parent_id."&msg_flg=$message");




/*$pdSQL1="SELECT dwgid, pid, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings  WHERE pid= ".$pid." and album_id= ".$albumid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
while($pdData1 = mysql_fetch_array($pdSQLResult1))
{
@unlink($file_path.$pdData1['al_file']);
 mysql_query("Delete from t027project_drawings where dwgid=".$pdData1['dwgid']." and album_id=".$albumid);
}
 mysql_query("Delete from t031project_drawingalbums where albumid=".$_REQUEST['albumid']);
  $message=  "<span style='color:green;'>album and all its photos deleted successfully</span>";
   header("Location: sp_drawingalbum_input.php?parent_id=".$parent_id."&msg_flg=3");*/
}
if(isset($_REQUEST['parent_id']))
{
$parent_id=$_REQUEST['parent_id'];
}
else
{
 $parent_id=0;
}

if(isset($_REQUEST['albumid']))
{
$albumid=$_REQUEST['albumid'];
$pdSQL1="SELECT albumid, pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and  albumid = ".$albumid." and parent_id=".$parent_id;
$ObjMapDrawing2->dbQuery($pdSQL1);
//$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 =$ObjMapDrawing2->dbFetchArray();
//$pdData1 = mysql_fetch_array($pdSQLResult1);
$status=$pdData1['status'];
$album_name=$pdData1['album_name'];

}
function RemoveSpecialChar($str){

    $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);
    return $res;
}
if(isset($_REQUEST['save']))
{ 
 
	 $album_name=RemoveSpecialChar($_REQUEST['album_name']);
	
	 $status=$_REQUEST['status'];
	 $sql2="INSERT INTO t031project_drawingalbums(parent_id,pid, album_name, status) Values( ".$parent_id.", ".$pid.",'".$album_name."', ".$status.")";
	$ObjMapDrawing->dbQuery($sql2);
	//getSQL
	$albmid=$con->lastInsertId();
	//$albmid=mysql_insert_id();
	if($parent_id==0)
		{
		//$parent_group=$category_cd;
			if(strlen($albmid)==1)
			{
			$parent_group="00".$albmid;
			}
			else if(strlen($albmid)==2)
			{
			$parent_group="0".$albmid;
			}
			else
			{
			$parent_group=$albmid;
			}
		}
		else
		{
		$parent_group1=$parent_id."_".$albmid;
		$sql="select parent_group from t031project_drawingalbums where albumid='$parent_id'";
		$ObjMapDrawing2->dbQuery($sql);
		$sqlrw1 =$ObjMapDrawing2->dbFetchArray();
		//$sqlrw1=mysql_fetch_array($sqlrw);
		
		if(strlen($albmid)==1)
			{
			$category_cd_pg="00".$albmid;
			}
			else if(strlen($albmid)==2)
			{
			$category_cd_pg="0".$albmid;
			}
			else
			{
			$category_cd_pg=$albmid;
			}
		
	$parent_group=$sqlrw1['parent_group']."_".$category_cd_pg;
		
		}
		$sql_pro="UPDATE t031project_drawingalbums SET parent_group='$parent_group' where albumid=$albmid and parent_id=$parent_id";
	
	$ObjMapDrawing3->dbQuery($sql_pro);
	if ($sql_pro == TRUE) {
    $message=  "1";
		$activity=  $albmid." - New Drawing Folder added successfully";
		
	} else {
    //$message= mysql_error($db);
	//$activity= mysql_error($db);
	}
	$log_id = $_SESSION['log_id'];
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
$ObjMapDrawing->dbQuery($iSQL);
header("Location: sp_drawingalbum_input.php?parent_id=".$parent_id."&msg_flg=".$message);	
	
}

if(isset($_REQUEST['update']))
{
$album_name=RemoveSpecialChar($_REQUEST['album_name']);
$status=$_REQUEST['status'];
$sql_pro="UPDATE t031project_drawingalbums SET album_name='$album_name',status='$status' where albumid=$albumid and parent_id=$parent_id";
	
	$ObjMapDrawing->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "2";
		$activity=  $albumid." - Drawing Folder updated successfully";
	} else {
		//$message= mysql_error($db);
		$activity= "Error in updating drawing album";
	}	
	$log_id = $_SESSION['log_id'];
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
$ObjMapDrawing2->dbQuery($iSQL);
	
header("Location: sp_drawingalbum_input.php?parent_id=".$parent_id."&msg_flg=".$message);
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
}
?>



<!DOCTYPE html>
<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Manage Drawing Folders</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../endors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../../css/basic-styles.css">
 <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
  <link href="css/style.css" rel="stylesheet" /> 

</head>

<body>


  
 <?php /*?> <link rel="stylesheet" type="text/css" media="all" href="calender/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <script type="text/javascript" src="calender/calendar.js"></script>
  <script type="text/javascript" src="calender/lang/calendar-en.js"></script>
  <script type="text/javascript" src="calender/calendar-setup.js"></script><?php */?>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>
<script>
function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
  
function required(){
	var x = document.forms["form1"]["album_name"].value;
  if (x == "") {
    alert("Folder Name must be filled out");
    return false;
  }
	
	
}
</script>
<style type="text/css">
<!--
.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
-->
</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 
<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	position: relative;
    display: inline-block;
	cursor:pointer;
   /* border-bottom: 1px dotted black;*/

}
.msg_head .tooltiptext {
	cursor:pointer;
    visibility: hidden;
    width: 80px;
    background-color: gray;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.msg_head:hover .tooltiptext {
    visibility: visible;
}
.msg_body{
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}

/*li {
    list-style: outside none none;
}*/

.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("frame.png") no-repeat scroll 0 0;
    float: left;
    height: 90px;
    padding: 50px 0 0 6px;
    width: 152px;
	padding-left: 21px !important;
}
.imageTitle {
    color: #464646;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: normal;
}
.ms-WPBody a:link {
    color: #0072bc;
    text-decoration: none;
}
/*div a {
    color: #767676 !important;
    font-family: arial;
    font-size: 12px;
    line-height: 17px;
    text-decoration: none !important;
}*/
img {
    border: medium none;
}

table{
      box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
    }
.top-alart-text{
	padding-bottom: 300px;
}
</style>


<script>
				
			window.onunload = function(){
  window.opener.location.reload();
};
				</script>
    <div class="container-fluid">
<div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">Manage Drawing Folders</h4>
		
				  <?php if($_REQUEST['msg_flg']=="1")
						{
						echo "<span class='top-alart-text'style='color:green; padding-top: 30px; margin-bottom: 50px;'>".DW_ADD_MSG." ! </span>";
						}
						else if($_REQUEST['msg_flg']=="2")
						{
						echo "<span style='color:green'>".DW_UPDATE_MSG."</span>";
						} 
						else if($_REQUEST['msg_flg']=="3")
						{
						echo "<span style='color:green'>".DW_DEL_MSG." !</span>";
						}
						else if($_REQUEST['msg_flg']=="4")
						{
						echo "<span style='color:red'>You should delete its sub folder(s) firstt</span>";
						}
						else if($_REQUEST['msg_flg']=="5")
						{
						echo "<span style='color:red'>You should delete its Drawing first</span>";
						}?>
                  <form class="forms-sample pt-3" name="form1" action="sp_drawingalbum_input.php" target="_self" method="post"  enctype="multipart/form-data"   onsubmit="return required()"> 

                    <div class="form-group row">
                    <div class="col-sm-5 text-end">
					<label>Drawing Folder Name:</label>
                      </div>
                      <div class="text-center col-sm-5">
					 
                        <input type="text" class="form-control text-center  " name="album_name" id="album_name" value="<?php echo $album_name;?>" placeholder="Drawing Folder Name " Required>
						<input class="form-control"   type="hidden" name="parent_id" id="parent_id" value="<?php echo $parent_id;?>"/>
                      
					</div>
                      <div class="text-center col-sm-2">
                      </div>
                    </div>
     
					
					<?php if(!isset($status))
						{
						$status=1;
						} ?>
						
                    <div class="form-group row">
                    <div class=" col-sm-5 text-end">
					<label>Status:</label>
                      </div>
                      <div class="text-center col-sm-5">

  <label class="form-check-label">
  <input  type="radio" class="form-check-input" name="status" value="1" <?php if($status==1){ echo "checked";} ?>/> <?php echo ACTIVE;?>
                            </label>
                            <label class="form-check-label " style="padding-left: 10%;">
                            <input  type="radio" name="status" class="form-check-input "  value="0" <?php if($status==0){ echo "checked";} ?> /> <?php echo INACTIVE;?>
                            </label>
                      </div>
                      <div class="text-center col-sm-2">
                      </div>
                    </div>

     
                    <div class="form-group row">
                    <div class="text-center col-sm-2">
                      </div>
                      <div class="text-center col-sm-8">
					  <?php if(isset($_REQUEST['albumid']))
	 {
		 
	 ?>
     <input type="hidden" name="albumid" id="albumid" value="<?php echo $_REQUEST['albumid']; ?>" />
     <input  type="submit" class="btn btn-primary me-2" name="update" id="update" style="width:30%" value="<?php echo UPDATE;?>" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <button  type="submit" class="btn btn-primary me-2"name="save" id="save" style="width:30%" value="<?php echo SAVE;?>" > Save </button>
	 <?php
	 }
	 ?> 
       <button  type="button" class="btn btn-light"  name="cancel" id="cancel" value="<?php echo CANCEL?>"  style="width:30%"  onclick="cancelButton();"> Cancel</button>
    
                      </div>
                      <div class="text-center col-sm-2">
                      </div>
                    </div>

     
                    <div class="form-group row">
                    <div class="text-center col-sm-2">
                      </div>
                      <div class="text-center col-sm-8">
						  
                      </div>
                      <div class="text-center col-sm-2">
                      </div>
                    </div>


                  </form>
                </div>
              </div>
            </div>
  


   <table class="reference table  table-hover"  > 
                             <thead class="" style="background-image: linear-gradient(180deg, #c9c9f5, #c9c9f5);" >  
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle; font-weight: 900;">#</th>
                                  <th width="40%" style="text-align:center; font-weight: 900;"><?php echo FOLDER_NAME;?></th>
                                  <th width="20%" style="text-align:center; font-weight: 900;"><?php echo STATUS;?></th>
								
								  
								  <th width="25%" colspan="2" style="text-align:center; font-weight: 900;"><?php echo ACTION;?></th>
								 
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
						$pdSQL = "SELECT albumid,parent_group, parent_id,pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and parent_id=".$parent_id." order by albumid";
						$ObjMapDrawing->dbQuery($pdSQL);
						// $pdSQLResult = mysql_query($pdSQL);
						$i=1;
						$ObjMapDrawing-> totalRecords();
						if($ObjMapDrawing-> totalRecords()>= 1)
							  //if(mysql_num_rows($pdSQLResult)>=1)
							  {
							while($pdData =$ObjMapDrawing->dbFetchArray())  
							  //while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							   $p_group=$pdData['parent_group'];
				$arr_gp=explode("_", $p_group);
				$get_album_id=$arr_gp[1];
				$pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_id;
			 $ObjMapDrawing2->dbQuery($pdSQL_get_right);
			 $result_get_right =$ObjMapDrawing2->dbFetchArray();
			// $result_get_right = mysql_fetch_array($pdSQLResult_get_right);
			 if($_SESSION['ne_user_type']==1)
			{
				?>
				<tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData['album_name'];?></td>
                          <td align="center">  <?php if($pdData['status']==1)
						  {
						  echo ACTIVE;
						  }
						  else
						  {
						  echo INACTIVE;
						  }?></td>
                       
						  
						   <td> <span style="float:right">
						   <form action="sp_drawingalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&parent_id=<?php echo $pdData['parent_id'] ?>" method="post">
						   <button class="btn btn-outline-warning btn-fw  py-1 " type="submit" name="edit" id="edit" value="Edit" >   <i class="ti-pencil btn-icon-prepend" ></i> EDIT </button></form></span>
						   </td>
						   <td a>
						   <span style="float:left"><form action="sp_drawingalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&parent_id=<?php echo $pdData['parent_id'] ?>" method="post">
						   <button class="btn btn-outline-danger btn-fw  py-1 "type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure, you want to delete this folder and its drawings?')" >
						   <i class="ti-trash btn-icon-prepend" ></i> DELETE</button></form></span>
						   
						  </td>
                        </tr>
				<?php
							  $i++;
			}
			else
			{
				
				
				
			$u_rightr=$result_get_right['user_right'];
			
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			$arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
						
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}
					
							?>
                            <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData['album_name'];?></td>
                          <td align="center">  <?php if($pdData['status']==1)
						  {
						  echo ACTIVE;
						  }
						  else
						  {
						  echo INACTIVE;
						  }?></td>
                       
						  <?php  if($read_right==1 || $read_right==3)
								  {
								   ?>
						    <td align="right"><span style="float:left">
							<form action="sp_drawingalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&parent_id=<?php echo $pdData['parent_id'] ?>" method="post">
							<button type="submit" name="edit" id="edit" value="Edit"class="btn btn-outline-warning btn-fw  py-1 " >  <i class="ti-pencil btn-icon-prepend" ></i> EDIT </button> </form></span>
						    <?php  
							}
							if($read_right==3)
								  {
								   ?>
						   <span style="float:right"><form action="sp_drawingalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&parent_id=<?php echo $pdData['parent_id'] ?>" method="post">
						   <button type="submit"  class="btn btn-outline-danger btn-fw  py-1 " name="delete" id="delete" value="delete" onclick="return confirm('Are you sure, you want to delete this folder and its drawings?')" >  
						    <i class="ti-trash btn-icon-prepend" ></i> DELETE</button></form></span>
						   
						   <?php
						   }
						   ?></td>
                        </tr>
                            <?php
						 $i++;
						}
				}
				 
			}
							  ?>
                        
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="4" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
                   
						</div><!-- class="container" -->
					</body>
					</html>