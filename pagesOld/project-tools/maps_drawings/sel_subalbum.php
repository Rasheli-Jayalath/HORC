<?php
include_once("../../../config/config.php");
error_reporting(E_ALL & ~E_NOTICE);
/*@require_once("requires/session.php");
$module		= "Manage Drawing Albums";

if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($draw_flag==0  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );*/

require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$ObjMapDrawing  = new  MapsDrawings();
$ObjMapDrawing2 = new MapsDrawings();
$ObjMapDrawing3 = new MapsDrawings();
$ObjMapDrawing4 = new MapsDrawings();
$user_cd=1;
$_SESSION['ne_user_type']=1;
//@require_once("get_url.php");
$file_path="drawings/";
 $pictomaxpid = $ObjMapDrawing->getMaxPid(); 
						 while($plevelrows=$ObjMapDrawing->dbFetchArray())
						{
						  $pid = $plevelrows['pid'];
						} 
?>
<table width="90%" cellspacing="1" cellpadding="1" >
<?php
$subalbum_id= $_REQUEST['subalbum_id'];
$albumid= $_REQUEST['albumid'];

if($subalbum_id!="" && $subalbum_id!=0)
{

?>
<?php 

$tquery = "select * from  t031project_drawingalbums where parent_id = ".$subalbum_id . " order by albumid ASC";
 $ObjMapDrawing3->dbQuery($tquery);
 $mysql_rows=$ObjMapDrawing3-> totalRecords();


if($mysql_rows>0)
{
 $con_albumid=$albumid."_".$subalbum_id;

?>

<div class="form-group row" style="margin-bottom:0.2rem">
 <label for="exampleInputUsername2" class="col-sm-4 col-form-label" style="font-weight: bold" ><?php echo "Sub Folder";?></label>

<div class="col-sm-8">
<!--<tr>
<td width="40%" align="left"><?php echo "Sub Folder";?> 
       </td>
<td width="60%">-->
<select name="subcatid_<?php echo $subalbum_id; ?>" id="subcatid_<?php echo $subalbum_id; ?>" onchange="subcatlisting(this.value,'<?php echo $con_albumid; ?>',<?php echo $subalbum_id; ?>)" class="form-control bg-light text-dark" style="font-size:0.8rem"  >
<option value="0">Select Sub Component..</option>
<?php
 while($tdata =$ObjMapDrawing3->dbFetchArray())

{
?>
	<option value="<?php echo $tdata['albumid']; ?>" <?php if ($subalbum_id == $tdata['albumid']) {echo ' selected="selected"';} ?>><?php echo $tdata['album_name']; ?></option>
<?php
}
?>
</select>
</div>
</div>
<?php
}
}
else
{
echo "empty";
}

?>

</table>

