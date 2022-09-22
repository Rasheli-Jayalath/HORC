<?php
include_once "../../../config/config.php";
$IpcClassObj = new IpcClass();
$IpcClassObj2 = new IpcClass();

$ipciddd = $_GET['ipcid'];
$boqiddd = $_GET['boqid'];
$ipcqtydd = $_GET['ipcqty'];

$IpcClassObj2->setProperty("boqiddd", $boqiddd);
$IpcClasslevel = $IpcClassObj2->checkexistIpcIdIpcvTable();

//$isdataavailable=$IpcClassObj2->dbFetchArray();
if ($isdataavailable = $IpcClassObj2->dbFetchArray()) //if available
{
    $IpcClassObj->setProperty("ipcvid", $ipciddd);
    $IpcClassObj->setProperty("boqid", $boqiddd);
    $IpcClassObj->setProperty("ipcqty", $ipcqtydd);

    $IpcClasslevel = $IpcClassObj->updateDataIpcvTable();
}
