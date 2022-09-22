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
 
 
if(isset($_REQUEST['item_id']))
{
$item_id=$_REQUEST['item_id'];

$pdSQL1="SELECT item_id, pid, title, lid FROM  t014majoritems  WHERE  item_id = ".$item_id;
$pdSQLResult1 =$objDb->dbQuery($pdSQL1);
 $pdData1=$objDb->dbFetchArray();
$lid=$pdData1['lid'];
$title=$pdData1['title'];

}






if(isset($_REQUEST['delete'])&&isset($_REQUEST['item_id'])&$_REQUEST['item_id']!="")
{

 $objDb->dbQuery("Delete from  t014majoritems where item_id=".$_REQUEST['item_id']);
 header("Location: items_form.php");
}

if(isset($_REQUEST['save']))
{    $lid=$_REQUEST['lid'];
    $title=$_REQUEST['title'];
    if($lid!='0'){
	$sql_pro=$objDb->dbQuery("INSERT INTO  t014majoritems(pid, title,lid) Values(".$pid.", '".$title."', '".$lid."' )");
	if ($sql_pro == TRUE) {
     
    $message=  "New record added successfully";
    echo "<script type='text/javascript'>alert('$message');</script>";

  }
  
}else {
  $message= "Error in updating Record!! Please Choose a Componet Area First";
  echo "<script type='text/javascript'>alert(\"Error in updating Record!! Please Choose a Componet Area First\")</script>";

}
	header("Location: items_form.php");
	
}

if(isset($_REQUEST['update']))
{
$title=$_REQUEST['title'];
$pdSQL = "SELECT a.item_id, a.pid, lid FROM  t014majoritems a WHERE pid = ".$pid." and item_id=".$item_id." order by item_id";
$pdSQLResult = $objDb->dbQuery($pdSQL);
$sql_num=$objDb-> totalRecords();

$pdData=$objDb->dbFetchArray();

$item_id=$_REQUEST['item_id'];
$lid=$_REQUEST['lid'];
		
if($lid!='0'){
  $sql_pro="UPDATE  t014majoritems SET title='$title',lid='$lid' where item_id=$item_id ";
  $sql_proresult=$objSDb->dbQuery($sql_pro);
	
	
  if ($sql_proresult == TRUE) {
  $message=  "Record updated successfully";
  echo $message;
}
	 
	

	} else {
		$message= "Error in updating Record!! Please Choose a Componet Area First";
    
    echo $message;
	}
	
header("Location: items_form.php");
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
                  <h4 class="card-title">Major Items</h4>
				  <?php echo $message; ?>
                  <form class="forms-sample" action="items_form.php" target="_self" method="post"  enctype="multipart/form-data">
                    
				  <div class="form-group row">

          <div class="text-end col-sm-6"> <label>Componet Area : </label> </div>
                      <div class="text-start col-sm-4">
                   <select class="form-control" style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);"  id="lid" name="lid"    Required>
                        <option value="0"><?php echo COMP ?></option>
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

                    <div class="text-end col-sm-6"> <label>Item Description : </label> </div>
                      <div class="text-start col-sm-6">
					     <input class="form-control bg-light text-dark"  type="text"   name="title" id="title" value="<?php echo $title;?>"  style="width: 60%;" placeholder="Item Description " Required>
                      </div>
                 </div>	

				 <?php if(isset($_REQUEST['item_id']))
	 {
		 
	 ?>
     <input type="hidden" name="item_id" id="item_id" value="<?php echo $_REQUEST['item_id']; ?>" />
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
                                  <th width="70%" style="font-weight: 900; text-align:center">Title</th>
                                
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
						 $pdSQL = "SELECT a.item_id, a.pid, a.title,b.lid,b.title AS compTittle FROM  t014majoritems a left join structures b on (a.lid=b.lid) ORDER BY lid ";
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
                          <td align="center"><?php echo $pdData['title'];?></td>
                          <?php  if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
						   <td align="right"><span style="float:right"><form action="items_form.php?item_id=<?php echo $pdData['item_id'] ?>" method="post">
						   <button type="submit" class="btn btn-outline-warning btn-fw  py-1 " name="edit" id="edit" value="Edit" > <i class="ti-pencil" ></i> EDIT </button></form></span></td>
						    <?php  
							}
							if($ncfadm_flag==1)
								  {
								   ?>
						   <td align="right">
						   <span style="float:right">
						   </form></span><span style="float:right"><form action="items_form.php?item_id=<?php echo $pdData['item_id'] ?>" method="post">
						   
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