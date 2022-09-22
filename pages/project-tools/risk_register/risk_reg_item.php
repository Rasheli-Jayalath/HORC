<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$_SESSION['ne_user_type']=1;
$user_cd=1;
$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
 $pid=$pData["pid"];
	
  $dpentry_flag=1;
 $dpadm_flag=1;		
 
 function RemoveSpecialChar($str){

    $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);

    return $res;
}
if(isset($_REQUEST['risk_con_id']))
{
$risk_con_id=$_REQUEST['risk_con_id'];
$pdSQL1="SELECT * FROM  tbl_risk_register_context  WHERE  risk_con_id = ".$risk_con_id;

$pdSQLResult1 =$objDb->dbQuery($pdSQL1);
 $pdData1=$objDb->dbFetchArray();

 $lid=$pdData1['lid'];
$risk_con_code=$pdData1['risk_con_code'];
$ris_con_desc=$pdData1['ris_con_desc'];

}






if(isset($_REQUEST['delete'])&&isset($_REQUEST['item_id'])&$_REQUEST['item_id']!="")
{

 $objDb->dbQuery("Delete from  t014majoritems where item_id=".$_REQUEST['item_id']);
 header("Location: risk_reg_item.php");
}

if(isset($_REQUEST['save']))
{    $risk_con_code=RemoveSpecialChar($_REQUEST['risk_con_code']);
    $ris_con_desc=RemoveSpecialChar($_REQUEST['ris_con_desc']);
    $lid=$_REQUEST['lid'];
    if($risk_con_code!='0'){
        $pSQL = "SELECT max(risk_con_id) as risk_con_id from tbl_risk_register_context";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
$risk_con_code=$pData["risk_con_id"]+1;
 $risk_con_code="R".$risk_con_code;
	$sql_pro=$objDb->dbQuery("INSERT INTO  tbl_risk_register_context (pid, risk_con_code,ris_con_desc,lid) Values(".$pid.", '".$risk_con_code."', '".$ris_con_desc."' , '".$lid."' )");
	if ($sql_pro == TRUE) {
     
    $message=  "New record added successfully";
    echo "<script type='text/javascript'>alert('$message');</script>";

  }
  
}else {
  $message= "Error in updating Record!! Please Choose a Componet Area First";
  echo "<script type='text/javascript'>alert(\"Error in updating Record!! Please Choose a Componet Area First\")</script>";

}
	header("Location: risk_reg_item.php");
	
}

if(isset($_REQUEST['update']))
{
$ris_con_desc=RemoveSpecialChar($_REQUEST['ris_con_desc']);

$pdSQL = "SELECT * FROM  tbl_risk_register_context a WHERE risk_con_id = ".$risk_con_id."";
$pdSQLResult = $objDb->dbQuery($pdSQL);
$sql_num=$objDb-> totalRecords();

$pdData=$objDb->dbFetchArray();

$risk_con_id=$_REQUEST['risk_con_id'];

$risk_con_code=$pdData['risk_con_code'];
$ris_con_desc=RemoveSpecialChar($_REQUEST['ris_con_desc']);
$lid=$_REQUEST['lid'];

		
if($risk_con_code!='0'){
  $sql_pro="UPDATE  tbl_risk_register_context SET risk_con_code='$risk_con_code',ris_con_desc='$ris_con_desc',lid='$lid' where risk_con_id=$risk_con_id ";
  $sql_proresult=$objSDb->dbQuery($sql_pro);
	
	
  if ($sql_proresult == TRUE) {
  $message=  "Record updated successfully";
  echo $message;
}
	 
	

	} else {
		$message= "Error in updating Record!! Please Choose a Componet Area First";
    
    echo $message;
	}
	
header("Location: risk_reg_item.php");
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.location.reload();";
    print "self.close();";
    print "</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<script>
window.onunload = function(){
window.opener.location.reload();
};
</script>
<link rel="stylesheet" type="text/css" href="css/style.css">

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Major Items </title>
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
  <style>
    .col-sm-6{

		
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

    <div class=" grid-margin stretch-card " style = "margin-top: 3%;"></div>
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">ADD RISK CONTEXT</h4>
				  <?php echo $message; ?>
                  <form class="forms-sample" action="risk_reg_item.php" target="_self" method="post"   enctype="multipart/form-data" >
                    
				  <div class="form-group row">

          <div class="text-end col-sm-6"> <label>Component Area : </label> </div>
                      <div class="text-start col-sm-4">
                   <select class="form-control" style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);"  id="lid" name="lid"    Required>
                        <option value=""><?php echo COMP ?></option>
                        <?php $pdSQL = "SELECT * FROM  structures WHERE pid=".$pid." order by lid";
                              $objDb->dbQuery($pdSQL);
                              $i=0;
                                if($objDb-> totalRecords()>= 1)
                                
                                  {
                                while($pdData=$objDb->dbFetchArray())
                                // while($pdData = mysql_fetch_array($pdSQLResult))
                                  { 
                                  $i++;
                                  if($_SESSION['ne_user_type']==1)
                                {?>
                    <option value="<?php echo $pdData["lid"];?>" <?php if($lid==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
                    <?php
                                }
                              
                                } 
                    }?>
                   </select>       
                          </div>
                          </div>
                           <div class="form-group row">

                    <div class="text-end col-sm-6"> <label>Item Description : </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control bg-light text-dark"  type="text"   name="ris_con_desc" id="ris_con_desc" value="<?php echo $ris_con_desc;?>" maxlength="250"  style="width: 60%;" placeholder="Item Description " Required>
                      </div>
                 </div>	

				 <?php if(isset($_REQUEST['risk_con_id']))
	 {
	 ?>
     <input type="hidden" name="risk_con_id" id="risk_con_id" value="<?php echo $_REQUEST['risk_con_id']; ?>" />
     <button type="submit" class="btn btn-primary me-2"  name="update" id="update" value="Update" style="width:20%">Update</button>
	 <button class="btn btn-light" type="button" style="width:20%" onclick="history.back()">Cancel</button>
	 <?php
	 }
	 else
	 {
	 ?>
	 <button type="submit" class="btn btn-primary me-2"  name="save" id="save" value="Save" style="width:20%">Save</button>
	 <button class="btn btn-light" type="button" style="width:20%" onclick="javascript:window.close()">Cancel</button>	
	 <?php
	 }
	 ?> 
       </form>
                </div>
              </div>
            </div>

    <div class="row">

    <div class="col-sm-12" style="" id="tworow">



	<table class="reference table table-hover" style="width:100%">
  <thead class="" style="background-image: linear-gradient(180deg, #c9c9f5, #c9c9f5);">
                                <tr style="">
                                  <th style="font-weight: 900; text-align:center; vertical-align:middle">S#</th>
                                  <th style="font-weight: 900; text-align:center; vertical-align:middle">Componet</th>
                                  <th style="font-weight: 900; text-align:center; vertical-align:middle">Context code</th>
                                  <th width="70%" style="font-weight: 900; text-align:center">Context Description</th>
                                
								  <?php if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
								 <th style="font-weight: 900; text-align:center" colspan="2">Action</th>
								  <?php
								  }
								  ?>
								 
								 
								
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						 $pdSQL = "SELECT a.risk_con_id,a.risk_con_code,a.ris_con_desc,b.lid,b.title AS compTittle FROM  tbl_risk_register_context a left join structures b on (a.lid=b.lid) ORDER BY risk_con_id ";
						 $pdSQLResult = $objDb->dbQuery($pdSQL);
						$i=0;
							  if($objDb-> totalRecords()>= 1)
							 // if(mysql_num_rows($pdSQLResult)>=1)
							  {
                  echo $pdData['title'];
							  while($pdData=$objDb->dbFetchArray())
							  //while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData['compTittle'];?></td>
                          <td align="center"><?php echo $pdData['risk_con_code'];?></td>
                          <td align="center"><?php echo $pdData['ris_con_desc'];?></td>
                          <?php  if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
						   <td align="right"><span style="float:right"><form action="risk_reg_item.php?risk_con_id=<?php echo $pdData['risk_con_id'] ?>" method="post">
						   <button type="submit" class="btn btn-outline-warning btn-fw  py-1 " name="edit" id="edit" value="Edit" > <i class="ti-pencil" ></i> EDIT </button></form></span></td>
						    <?php  
							}
							if($ncfadm_flag==1)
								  {
								   ?>
						   <td align="right">
						   <span style="float:right">
						   </form></span><span style="float:right"><form action="risk_reg_item.php?risk_con_id=<?php echo $pdData['risk_con_id'] ?>" method="post">
						   
						   <button type="submit" class="btn btn-outline-danger btn-fw  py-1 " name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" > <i class="ti-trash" ></i> DELETE </button> </form></span></td>
						  <?php
						   }
						   ?>
						  
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