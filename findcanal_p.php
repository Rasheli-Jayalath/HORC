<?php
include_once("config/config.php");
//@require_once("config/session.php");
require_once('rs_lang.admin.php');
	$ObjPictoAna1 = new PictorialAnalysis();
	$ObjPictoAna = new PictorialAnalysis();
$module		= "Manage Photos";
/*if ($uname==null  ) {
header("Location: index.php?init=3");
}*/

$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
$isentry		= $_REQUEST['isentry'];
$lid		= $_REQUEST['lid'];
$objDb  = new Database( );
//@require_once("get_url.php");
$sCondition = '';
?>
<select id="canal_name" name="canal_name"  style="font-size: 14px; color: #000;background-color: #fff;"  class="form-control">
     <option value="0">Select Sub Component</option>
  		<?php 
		
		echo $pdSQLd = "SELECT lcid,title FROM  locations_component  WHERE  lid=".$lid." order by title ASC";
						 $pdSQLResultd = $objDb->dbQuery($pdSQLd);
						$i=0;
							  if($objDb->totalRecords()>=1)
							  {
							  while($pdDatad = $objDb->dbFetchArray())
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatad["lcid"];?>"><?php echo $pdDatad["title"];?></option>
   <?php } 
   }?>
  </select>
  

