<?php   
include_once("../../config/config.php");
$ObjKfiDash = new KfiDashboard();
$ObjKfiDash2 = new KfiDashboard();
$ObjKfiDash3 = new KfiDashboard();     
$kfiprojectlevel = $ObjKfiDash->getAllParentCd();
while($plevelrows=$ObjKfiDash->dbFetchArray())
{
?>
<div id="<?php echo "dynadiv".$plevelrows['itemid']; ?>" style="display:block" ></div>
<?php
}
?>