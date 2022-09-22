<?php   
include_once("../../config/config.php");
$ObjKfiDash = new ActDashboard();
$ObjKfiDash2 = new ActDashboard();
$ObjKfiDash3 = new ActDashboard();     

$kfiprojectlevel = $ObjKfiDash->getAllParentCd();
while($plevelrows=$ObjKfiDash->dbFetchArray())
{
    ?>
    <div id="<?php echo "dynadiv".$plevelrows['parentcd']; ?>" style="display:block" ></div>
    <?php
}
?>