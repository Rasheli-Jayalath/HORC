<?php
include_once("../../../config/config.php");
	
/*	$pic_flag			= $_SESSION['ne_pic'];
	$picadm_flag		= $_SESSION['ne_picadm'];
	$picentry_flag		=$_SESSION['ne_picentry'];*/
	$pic_flag			= 1;
	$picadm_flag		= 1;
	$picentry_flag		=1;
	$uid				= $_SESSION['ne_user_cd']; 
	$uname				= $_SESSION['ne_username'];
	$superadmin_flag 		= $_SESSION['ne_sadmin'];
if ($uname==null  ) {
header("Location: ../../../index.php?init=3");
} 
else if ($pic_flag==0  ) {
header("Location: ../../../index.php?init=3");
}	

$edit			= $_GET['edit'];
$objDb  		= new Database( );
$objDb1  		= new Database( );

function RemoveSpecialChar($str){

    $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);
    return $res;
}

//@require_once("get_url.php");
$file_path="photos/";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = $objDb->dbQuery($pSQL);
						 $pData = $objDb->dbFetchArray();
						 $pid=$pData["pid"];
 $aid=$_REQUEST['cat_id'];
 $pdSQL2 = "SELECT user_right FROM t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$aid;
$pdSQLResult2 = $objDb->dbQuery($pdSQL2);

$result2 = $objDb->dbFetchArray();
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
				
			}
				}
			}




if(isset($_REQUEST['delete'])&&isset($_REQUEST['albumid'])&$_REQUEST['albumid']!=""){
				 $category_cd_c = $_GET['albumid'];
				$cat_id = $_GET['cat_id'];
				
			   $sql2c="Select * from t031project_albums where parent_album=$category_cd_c";
				$res2c=$objDb->dbQuery($sql2c);
				if($objDb->totalRecords()>=1)
				{
					
					$message=  "<span style='color:red;'>You should delete its sub folders(s) first</span>";
					$activity=$category_cd_c." - You should delete its sub album(s) firstt";
				
				}
				else
				{
				
			
				
				
			 $sql2t="Select * from t027project_photos where album_id=$category_cd_c";
				$res2t=$objDb1->dbQuery($sql2t);
				
				$row2d=$objDb1->dbFetchArray();
					if($objDb1->totalRecords()>=1)
					{
						$message=  "<span style='color:red;'>You should delete its Photos first</span>";
						 $activity=$category_cd_c." - You should delete its Photos first";
										
					}
					else
					{
					 $sdeletet= "Delete from t031project_albums where albumid=$category_cd_c";
					  $objDb->dbQuery($sdeletet);
						
						 $message=  "<span style='color:green;'>album deleted successfully</span>";
						 $activity=$category_cd_c." - album deleted successfully";
					
					}				
				
				
				}
	
	$log_id = $_SESSION['log_id'];
	//echo $message;
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);

}





if(isset($_REQUEST['albumid']))
{
$albumid=$_REQUEST['albumid'];
$pdSQL1="SELECT albumid, pid, album_name,album_order, status, parent_album FROM t031project_albums  WHERE pid= ".$pid." and  albumid = ".$albumid. " order by album_order asc";
$pdSQLResult1 = $objDb->dbQuery($pdSQL1);
$pdData1 = $objDb->dbFetchArray();
$status=$pdData1['status'];
$album_name=$pdData1['album_name'];
$album_order=$pdData1['album_order'];
$parent_album=$pdData1['parent_album'];
}
if(isset($_REQUEST['save']))
{ 
     $album_name=RemoveSpecialChar($_REQUEST['album_name']);
	  $album_order=$_REQUEST['album_order'];
	  if( $album_order!=="")
	  {
		  $album_order=$album_order;
	  }
	  else
	  {
		  $album_order=0;
	  }
	 $status=$_REQUEST['status'];
	 
	 
	 $created_by	= $_SESSION['ne_fullname_name'];
	 $userid_owner	= $uid;
	
	$datt=date('Y-m-d H:i:s');
	$creater=$created_by." ".$datt;
	$last_modified_by="";
	 
	 $parent_album=$_REQUEST['parent_album'];
	if($_SESSION['ne_user_type']==1)
	{
	}
	else
	{
	$user_rs=$uid."_".$read_right;		
	$user_ids=$uid;
	}
	
$sql_pro1="INSERT INTO t031project_albums(pid, album_name, status,user_ids, user_right,parent_album, creater, creater_id,last_modified_by, album_order) Values(".$pid.", '".$album_name."', ".$status.",'".$user_ids."','".$user_rs."', '".$parent_album."' , '".$creater."', ".$userid_owner.", '".$last_modified_by."', ".$album_order.")";
	$sql_pro=$objDb1->dbQuery($sql_pro1);
	$album_id=$con->lastInsertId();
	if($parent_album==0)
		{
		//$parent_group=$category_cd;
			if(strlen($album_id)==1)
			{
			$parent_group="00".$album_id;
			}
			else if(strlen($album_id)==2)
			{
			$parent_group="0".$album_id;
			}
			else
			{
			$parent_group=$album_id;
			}
		}
	else
	{
		$parent_group1=$parent_album."_".$album_id;
		$sql="select parent_group from t031project_albums where albumid='$parent_album'";
		$sqlrw=$objDb->dbQuery($sql);
		$sqlrw1=$objDb->dbFetchArray();
		
		if(strlen($album_id)==1)
			{
			$category_cd_pg="00".$album_id;
			}
			else if(strlen($album_id)==2)
			{
			$category_cd_pg="0".$album_id;
			}
			else
			{
			$category_cd_pg=$album_id;
			}
		
		$parent_group=$sqlrw1['parent_group']."_".$category_cd_pg;
	}
	
	$sql_pro="UPDATE t031project_albums SET parent_group='$parent_group' where albumid=$album_id";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity=  $album_id." - New Album added successfully";
	} else {
    $message= "Error in uploading record";
	$activity= "Error in uploading Albums";
	}
	
	$log_id = $_SESSION['log_id'];
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);
	
	$album_name="";
	$album_order="";
	
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "</script>";
	
}

if(isset($_REQUEST['update']))
{
$album_name=RemoveSpecialChar($_REQUEST['album_name']);
$album_order=$_REQUEST['album_order'];
if( $album_order!=="")
	  {
		  $album_order=$album_order;
	  }
	  else
	  {
		  $album_order=0;
	  }
$status=$_REQUEST['status'];
 $parent_album=$_REQUEST['parent_album'];
 $created_by	= $_SESSION['ne_fullname_name'];
	 $userid_owner	= $uid;
	
	$datt=date('Y-m-d H:i:s');
	
	$last_modified_by=$created_by." ".$datt;
 
 if($parent_album==0)
		{
		//$parent_group=$category_cd;
			if(strlen($album_id)==1)
			{
			$parent_group="00".$album_id;
			}
			else if(strlen($album_id)==2)
			{
			$parent_group="0".$album_id;
			}
			else
			{
			$parent_group=$album_id;
			}
		}
	else
	{
		$parent_group1=$parent_album."_".$album_id;
		$sql="select parent_group from t031project_albums where albumid='$parent_album'";
		$sqlrw=$objDb1->dbQuery($sql);
		$sqlrw1=$objDb1->dbFetchArray();
		
		if(strlen($album_id)==1)
			{
			$category_cd_pg="00".$album_id;
			}
			else if(strlen($album_id)==2)
			{
			$category_cd_pg="0".$album_id;
			}
			else
			{
			$category_cd_pg=$album_id;
			}
		
		$parent_group=$sqlrw1['parent_group']."_".$category_cd_pg;
	}
$sql_pro="UPDATE t031project_albums SET album_name='$album_name',status='$status', parent_album='$parent_album', creater_id=$userid_owner, last_modified_by='$last_modified_by', album_order=$album_order where albumid=$albumid";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $albumid." - Album updated successfully";
	} else {
		 $message= "Error in uploading record";
	$activity= "Error in updating Albums";
	}	
	$log_id = $_SESSION['log_id'];
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);
	$album_name="";
	$album_order="";
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "</script>";

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
<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>Manage Albums</title>
</head> -->
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Manage Albums</title>
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
</head>
<body>
<script>
function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
</script>
  <style>
    .col-sm-6{
      text-align: center;
      background-color:lavender;
      display: block;
      margin-left: auto;
      margin-right: auto;
      padding: 20px;
    }

    #tworow{
      padding: 20px;
    }

    h3{
      font-family: Arial, Helvetica, sans-serif;
    }

    label {
      font-weight: bold;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 100%;
    }
    #inp1{
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    table{
      box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
    }
  </style>
    <div class="container-fluid">
    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">Manage Albums</h4>

                  <form class="forms-sample"  action="sp_subalbum_input.php?cat_id=<?php echo $aid;?>" target="_self" method="post"  enctype="multipart/form-data"  id="add_details" >
                   <input type="hidden" name="parent_album" id="parent_album" value="<?php echo $aid;?>" />
                    <div class="form-group row">
                    <div class="text-center col-sm-4">
                      </div>
                      <div class="text-center col-sm-4">
                       
                      <input class="form-control"  type="text"  id="album_name" name="album_name" placeholder="Enter The Album Name Here" value="<?php echo $album_name;?>" Required maxlength="245">
                      </div>
                      <div class="text-center col-sm-4">
                      </div>
                    </div>
                    
                    <div class="form-group row">
                    <div class="text-center col-sm-4">
                      </div>
                      <div class="text-center col-sm-4">
                       
                          <input class="form-control"  type="number"  id="album_order" name="album_order" placeholder="Enter The Album Order Here" value="<?php echo $album_order;?>" >
                      		<b>Note:</b> Numbers only
                      </div>
                      <div class="text-center col-sm-4">
                      </div>
                    </div>
      <?php if(!isset($status))
  {
  $status=1;
  } ?>
                    <div class="form-group row">
                    <div class="text-center col-sm-2">
                      </div>
                      <div class="text-center col-sm-8">
                      <label class="form-check-label">
                              <input type="radio" class="form-check-input"  name="status" value="1" <?php if($status==1){ echo "checked";} ?> >
                              Active
                            </label>
                            <label class="form-check-label" style="padding-left: 10%">
                              <input type="radio" class="form-check-input" name="status"   value="0" <?php if($status==0){ echo "checked";} ?>>
                              Inactive
                            </label>
                      </div>
                      <div class="text-center col-sm-2">
                      </div>
                    </div>
<?php if(isset($_REQUEST['albumid']))
	 {
		 
	 ?>
     <button type="submit" class="btn btn-primary me-2" name="update" id="update" style="width:20%"> Update</button>
     <input type="hidden" name="albumid" id="albumid" value="<?php echo $_REQUEST['albumid']; ?>" />
     <!--<input  type="submit" name="update" id="update" value="<?php echo UPDATE;?>" />-->
     <?php
	 }
	 else
	 {
	 ?>
	 <!--<input  type="submit" name="save" id="save" value="<?php echo SAVE;?>" />-->
      <button type="submit" class="btn btn-primary me-2" name="save" id="save" style="width:20%"> Submit </button>
	 <?php
	 }  
	 ?> 
    
      <button type="submit" class="btn btn-primary me-2" name="cancel" id="cancel" style="width:20%" onclick="cancelButton();">Cancel</button>

                  </form>

                </div>
              </div>
            </div>
    <div class="row">

    <div class="col-sm-12" style="" id="tworow">

<table class="table table-hover">
    <thead class="" style="background-image: linear-gradient(180deg, #c9c9f5, #c9c9f5);" >
        <th style="font-weight: 900;">#</th>
        <th style="font-weight: 900;">Album Name</th>
        <th style="font-weight: 900;">Album Order</th>
        <th style="font-weight: 900;">Status</th>
        <th class="text-center " style="font-weight: 900;">Action</th>
    </thead>

    <tbody id="table_data">


  
							  <?php
							  
						 $pdSQL = "SELECT albumid,parent_group, pid, album_name,user_right, status, album_order FROM t031project_albums  WHERE pid= ".$pid." and parent_album=".$aid."   order by album_order desc";
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=1;
							  if($objDb->totalRecords()>=1)
							  {
							  while($pdData = $objDb->dbFetchArray())
							  { 
							  
							  $p_group=$pdData['parent_group'];
				$arr_gp=explode("_", $p_group);
				$get_album_id=$arr_gp[1];
				 $pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_id;
			 $pdSQLResult_get_right = $objDb1->dbQuery($pdSQL_get_right);
			 $result_get_right = $objDb1->dbFetchArray();
							  
							
							  if($_SESSION['ne_user_type']==1)
			{
				
							  ?>
                              
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData['album_name'];?></td>
                          <td align="center"><?php echo $pdData['album_order'];?></td>
                          <td align="center">  <?php if($pdData['status']==1)
						  {
						  echo "active";
						  }
						  else
						  {
						  echo "Inactive";
						  }?></td>
                       
						  
						   <td align="right"><span style="float:left"><form action="sp_subalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&cat_id=<?php echo $aid ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						   
						   <span style="float:right"><form action="sp_subalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&cat_id=<?php echo $aid ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure, you want to delete this album and its photos?')" /></form></span>
						   
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
						  echo "Active";
						  }
						  else
						  {
						  echo "Inactive";
						  }?></td>
                       
						  <?php  if($read_right==1 || $read_right==3)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_subalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&cat_id=<?php echo $aid ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						    <?php  
							}
							if($read_right==3)
								  {
								   ?>
						   <span style="float:right"><form action="sp_subalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&cat_id=<?php echo $aid ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure, you want to delete this album and its photos?')" /></form></span>
						   
						   <?php
						   }
						   ?></td>
                        </tr>
                            <?php
						 $i++;
						}
				}
				 
			}
						
						
						
						
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



<script>

</script>
<br>
</div><!-- tworow -->
</div><!-- class="row" -->
    </div><!-- class="container" -->
</body>
</html>