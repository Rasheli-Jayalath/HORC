<?php   
include_once("../../config/config.php");
include_once("rs_lang.admin.php");
$ObjKpiDash = new KpiDashboard();
$ObjKpiDash2 = new KpiDashboard();
$ObjKpiDash3 = new KpiDashboard();
$kpiprojectlevel = $ObjKpiDash->getAllParentCd();
while($plevelrows=$ObjKpiDash->dbFetchArray())
{
    ?>
    <div id="<?php echo "dynadiv".$plevelrows['parentcd']; ?>" style="display:block" ></div>
    <?php
}
?>