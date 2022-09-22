<?php
include_once("../../config/config.php");
$ObjKfiDash = new ActDashboard();

$prolvlid = $_GET['prolvlid'];


if($prolvlid!="")
{
 ?>


<select class="form-control" id="subcatid_<?php echo $prolvlid; ?>" style="margin-top:5px;color: #444;" onchange="getsublevel(this);" name="subcatid_<?php echo $prolvlid; ?>" >
<option class="text-muted" value="0">Select Activity..</option>

<?php
  $ObjKfiDash->setProperty("prolvlid",$prolvlid);
   
$kfiprojectlevel = $ObjKfiDash->getActvityLevel();

while($plevelrows=$ObjKfiDash->dbFetchArray())
{
?>

<option value="<?php echo $plevelrows['itemid']; ?>"><?php echo $plevelrows['itemname']; ?></option>; 

<?php
}

}

?>
</select>

