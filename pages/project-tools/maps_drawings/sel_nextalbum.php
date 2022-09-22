<?php
include_once("../../../config/config.php");
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$ObjMapDrawing  = new  MapsDrawings();
$ObjMapDrawing2 = new MapsDrawings();
$ObjMapDrawing3 = new MapsDrawings();
$ObjMapDrawing4 = new MapsDrawings();
$user_cd=1;
$_SESSION['ne_user_type']=1;
/*$_SESSION['ne_user_type']=1;
@require_once("requires/session.php");
$module		= "Manage Drawing Albums";

if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($draw_flag==0  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
$user_cd=$uid;*/
//@require_once("get_url.php");
$file_path="drawings/";
 $pictomaxpid = $ObjMapDrawing->getMaxPid(); 
						 while($plevelrows=$ObjMapDrawing->dbFetchArray())
						{
						  $pid = $plevelrows['pid'];
						} 

?>
<table width="90%"  cellspacing="1" cellpadding="1" >
<?php 

$album_id = intval($_GET['album_id']);
if($album_id!="")
{
	if($_SESSION['ne_user_type']==1)
	{
	
	
	 $tquery = "select * from  t031project_drawingalbums where parent_id = ".$album_id . " order by albumid ASC";
	 $ObjMapDrawing->dbQuery($tquery);
	 $mysql_rows=$ObjMapDrawing-> totalRecords();

	}
	else
	{
		
$tquery1 = "select * from  t031project_drawingalbums where parent_id = ".$album_id . " order by albumid ASC";
 $ObjMapDrawing2->dbQuery($tquery1);
//$tresult1 = mysql_query($tquery1);
$c_id1="";
$g=0;
 while($cddata2 =$ObjMapDrawing2->dbFetchArray())

{
$catt_cdd=$cddata2['albumid'];
$arr_rst1=explode(",",$cddata2['user_ids']);
$len_rst21=count($arr_rst1);

for($ri1=0; $ri1<$len_rst21; $ri1++)
{ 

if($arr_rst1[$ri1]==$user_cd)
{
$g=$g+1;
	if($g==1)
	{ 
	$c_id1="albumid=".$catt_cdd ;
	}
	else
	{
	
	$c_id1.=" OR albumid=".$catt_cdd ;
	}

}

}
//$g=$g+1;

}	

	if($c_id1!="")
	{
	$tquery = "select * from  t031project_drawingalbums where ".$c_id1." order by albumid ASC";
	$ObjMapDrawing->dbQuery($tquery);
	 $mysql_rows=$ObjMapDrawing-> totalRecords();
	

	}
	else
	{
	$mysql_rows=0;
	?>
	
	<?php 
	}

	}


if($mysql_rows>0)
{


?>
 <div class="form-group row" style="margin-bottom:0.2rem">
 <label for="exampleInputUsername2" class="col-sm-4 col-form-label" style="font-weight: bold" ><?php echo "Sub Folder";?></label>
<!--<tr>
<td width="40%" align="left"><?php echo "Sub Folder";?> 
       </td>
<td width="60%">-->
<div class="col-sm-8">
<select name="subcatid_<?php echo $album_id; ?>" id="subcatid_<?php echo $album_id; ?>"  onchange="subcatlisting(this.value,'<?php echo $album_id?>',<?php echo $album_id; ?>)" class="form-control bg-light text-dark"  style="font-size:0.8rem">
<option value="0">Select Sub Component..</option>
<?php
 while($tdata =$ObjMapDrawing->dbFetchArray())

 {

?>
<option value="<?php echo $tdata['albumid']; ?>"><?php  echo $tdata['album_name']; ?></option>
<?php

}
?>
</select>
</div>
</div>
<?php

}

?>

<?php

}
?>
<!--</table>-->