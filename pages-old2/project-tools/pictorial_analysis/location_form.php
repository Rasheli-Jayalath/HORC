<?php 	
include_once("../../../config/config.php");
//@require_once("../../../config/session.php");
require_once('../../../rs_lang.admin.php');
	$ObjPictoAna1 = new PictorialAnalysis();
	$ObjPictoAna = new PictorialAnalysis();
	$module		= "Manage Locations";
/*if ($uname==null  ) {
header("Location: ../../../index.php?init=3");
} 
else if ($pic_flag==0  ) {
header("Location: ../../../index.php?init=3");
}*/

$objDb  		= new Database( );
$objDb1  		= new Database( );
	$pictomaxpid = $ObjPictoAna1->getMaxPid(); 
	while($plevelrows=$ObjPictoAna1->dbFetchArray())
	{
	  $maxpid = $plevelrows['pid'];
	 $pid= $maxpid;
	}

if(isset($_REQUEST['lcid']))
{
$lcid=$_REQUEST['lcid'];
$pdSQL1="SELECT lcid,lid, pid, title FROM  locations_component  WHERE  lcid = ".$lcid;
$pdSQLResult1 = $objDb->dbQuery($pdSQL1);
$pdData1 = $objDb->dbFetchArray();

$title=$pdData1['title'];
$lid=$pdData1['lid'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['lcid'])&$_REQUEST['lcid']!="")
{

$pdSQL = "SELECT * FROM  project_photos WHERE pid = ".$pid." and lcid=".$lcid." and ph_cap=$lid";
$pdSQLResult = $objDb->dbQuery($pdSQL);
$sql_num=$objDb-> totalRecords();
if($sql_num>=1)
{
	$message="Delete its photos first, then you will be able to delete canal";
	 $activity= $lid."_".$_REQUEST['lcid']." - Delete its photos first, then you will be able to delete canal";
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
$objDb1->dbQuery($iSQL);
}
else
{
 $objDb1->dbQuery("Delete from  locations_component where lcid=".$_REQUEST['lcid']);
 $message="Canal deleted successfully";
 $activity= $lid."_".$_REQUEST['lcid']." - Canal deleted successfully";
// $iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb->dbQuery($iSQL);
 header("Location: location_form.php");
}
// header("Location: location_form.php");
}


if(isset($_REQUEST['save']))
{ 
    $title=$_REQUEST['title'];
	$lid=$_REQUEST['lid'];
	//echo "INSERT INTO  locations_component(lid,pid, title) Values(".$lid.",".$pid.", '".$title."' )";
	$sql_pro=$objDb->dbQuery("INSERT INTO  locations_component(lid,pid, title) Values(".$lid.",".$pid.", '".$title."' )");
	$insert_record=$con->lastInsertId();
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity= $lid."_".$insert_record." - New  record added successfully";
	} else {
    $message= "Error in adding sub component record";
	$activity= "Error in adding sub component record";
	}
	
	//$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objDb1->dbQuery($iSQL);
	$title="";
	$lid="";
	//header("Location: location_form.php");
	
}
if(isset($_REQUEST['update']))
{
$title=$_REQUEST['title'];
$lid=$_REQUEST['lid'];
	 $sql_pro="UPDATE  locations_component SET title='$title',lid=$lid where lcid=$lcid";
	
	$sql_proresult=$objDb->dbQuery($sql_pro);
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity= $lid."_".$lcid." -  Record updated successfully";
	} else {
		$message= "Add sub Componnet Record not updated";
		$activity= "Add sub Componnet Record not updated";
	}
	//$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//mysql_query($iSQL);
	$title="";
	$lid="";
//header("Location: location_form.php");
}

?>


<!DOCTYPE html>
<html lang="en">



<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Location Form</title>
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
  <script>
window.onunload = function(){
window.opener.location.reload();
};


  function required(){
	
	var x =document.getElementById("component").value;
	var subtitle =document.getElementById("subtitle").value;
	
	 if (x == 0) {
    alert("Select Component first");
    return false;
  		}
		else if(subtitle == "") {
    alert("Enter Sub Component Name first");
    return false;
  		}
  
  }
  function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
</script>
</head>
<body>
    
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

	button.hidden {
		display: none;
	}

	thead {
		text-align: center;	
	}

	tbody {
		text-align: center;	
	}

    #inp1{
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    #back{
        float:right;
    }
    table{
      box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
    }
	
       
    </style>
    <div class="container-fluid">
    <div class="row">

    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #fff, #c9c9f5);">
                <div class="card-body text-center">
                  <h4 class="card-title">Sub Component</h4>

                  <form class="forms-sample" action="location_form.php" method="post" id='frm' enctype="multipart/form-data"  onsubmit="return required();">
                    <div class="form-group row">
                    <div class="text-center col-sm-4"><?php echo $message; ?>
                      </div>
                      <div class="text-center col-sm-4">
                      <label for="exampleSelectGender" style="font-weight: bold;margin-top:25px">Select Component</label>
                        
                        <select  style="font-size: 14px; color: #000;background-color: #fff;" onchange="" class="form-control" id="lid" name="lid" >
                        <option value="0"><?php echo "SelectComponent"; ?></option>
  		<?php  $pdSQL = "SELECT lid, pid, album_name, user_right, user_ids FROM  t031project_albums  WHERE parent_album=0 order by lid";
						 $pdSQLResult = $objDb1->dbQuery($pdSQL);
						$i=0;
							  if($objDb1-> totalRecords()>=1)
							  {
							  while($pdData = $objDb1->dbFetchArray())
							  { 
							  $i++;
							  if($_SESSION['ne_user_type']==1)
							{?>
  <option value="<?php echo $pdData["lid"];?>" <?php if($lid==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["album_name"];?></option>
   <?php }
   else
   {
	   
								$u_rightr=$pdData['user_right'];			
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
							if($read_right==1 || $read_right==3)
								  {	
								  ?>
                                  <option value="<?php echo $pdData["lid"];?>" <?php if($ph_cap==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
                                  <?php
								  }
						}
				}
							
	   
   }} 
   }?>
  </select>
                          </div>
                      <div class="text-center col-sm-4">
                      </div>
                    </div>
     
                    <div class="form-group row">
                    <div class="text-center col-sm-4">
                      </div>
                      <div class="text-center col-sm-4">
                      <label for="exampleSelectGender" style="font-weight: bold;margin-top:15px">Enter Sub Component</label>
                      <input type="text" class="form-control text-center "  id="title" name="title"  value="<?php echo $title;?>">
                      </div>
                      <div class="text-center col-sm-4">
                      </div>
                    </div>
                    
    <input type="hidden" class="form-control" name="uid" id='uid' required value='0' placeholder="">

           <?php if(isset($_REQUEST['lcid']))
	 {
		 
	 ?>
     <input type="hidden" name="lcid" id="lcid" value="<?php echo $_REQUEST['lcid']; ?>" />
      <button type="submit" class="btn btn-primary me-2" name="update" id="update" style="width:20%">Update</button>
     <!--<input  type="submit" name="update" id="update" value="<?php echo UPDATE;?>" />-->
	 <?php
	 }
	 else
	 {
	 ?>
     <button type="submit" class="btn btn-primary me-2" name="save" id="save" style="width:20%"><?php echo SAVE;?></button>
	<!-- <input  type="submit" name="save" id="save" value="<?php echo SAVE;?>" />-->
	 <?php
	 }
	 ?>
     <button class="btn btn-primary me-2" type="button" style="width:20%"  onclick="javascript:window.close()"> Cancel</button>
    
                  </form>
                </div>
              </div>
            </div>
            

    <div class="col-sm-12" style=";" id="tworow">
    <table class="table table-hover" id='table' >
                              <thead>
                                <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
                                  <th style="text-align:center; vertical-align:middle">#</th>
                                  <th width="20%" style="text-align:center"><?php echo "Component Name";?></th>
                                  <th width="50%" style="text-align:center"><?php echo "Sub-Component Name";?></th>
                                
								
								 
								  <th style="text-align:center"><?php echo "Action";?></th>
								
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						
						  $pdSQL = "SELECT lcid,lid, pid, title FROM  locations_component WHERE pid=".$maxpid." order by lid";
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=0;
							  if($objDb-> totalRecords()>=1)
							  {
							  while($pdData = $objDb->dbFetchArray())
							  { 
							  				 $lid=$pdData['lid'];
							  		 $pdSQL1 = "SELECT title FROM  structures WHERE lid=$lid";
						 			$pdSQLResult1 = $objDb1->dbQuery($pdSQL1);
									$pdData1 = $objDb1->dbFetchArray();
							  $i++;
							  ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData1['title'];?></td>
                          <td align="center"><?php echo $pdData['title'];?></td>
                         
						   <td align="right"><span style="float:left"><form action="location_form.php?lcid=<?php echo $pdData['lcid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="location_form.php?lcid=<?php echo $pdData['lcid'] ?>" method="post">
						    
						   <input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo "Are you sure, You want to delete this canal and its photos";?>')" /></form>
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
    </div><!-- tworow -->
</div><!-- class="row" -->
    </div><!-- class="container" -->

    

</body>
</html>