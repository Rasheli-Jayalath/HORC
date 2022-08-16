<?php
include_once("../../config/config.php");
$ObjKpiDash = new KpiDashboard();
$prolvlid = $_GET['prolvlid'];


if($prolvlid!="")
{
 ?>


<select class="form-control" id="subcatid_<?php echo $prolvlid; ?>" style="margin-top:5px;color: #444;" onchange="getsublevel(this);" name="subcatid_<?php echo $prolvlid; ?>" >
<option class="text-muted" value="0">Sub-KPI..</option>

<?php
  $ObjKpiDash->setProperty("prolvlid",$prolvlid);
   
$kpiprojectlevel = $ObjKpiDash->getActvityLevel();

while($plevelrows=$ObjKpiDash->dbFetchArray())
{
?>

<option value="<?php echo $plevelrows['kpiid']; ?>"><?php echo $plevelrows['itemname']; ?></option>; 

<?php
}

}

?>
</select>

