<?php
include_once("../../../config/config.php");
$IpcClassObj = new IpcClass();

$ipcid = $_GET['ipcid'];


$result = array();
$ipcDataArray = array();
$response = array();

if($ipcid!="")
{

    $IpcClassObj->setProperty("ipcid",$ipcid);
    $kfiprojectlevel = $IpcClassObj->getAllDataIpcFrmId();

    while($ipcrows=$IpcClassObj->dbFetchArray())
    {  
        $ipcDataArray["ipcid"] = $ipcrows['ipcid'];
        $ipcDataArray["ipcno"] = $ipcrows['ipcno'];
        $ipcDataArray["ipcmonth"] = $ipcrows['ipcmonth'];

       // $ipcDataArray["ipcstartdate"] = $ipcrows['ipcstartdate'];
        $ipcDataArray["ipcstartdate"] = date("m/d/Y", strtotime($ipcrows['ipcstartdate']));  
        $ipcDataArray["ipcenddate"] = date("m/d/Y", strtotime($ipcrows['ipcenddate'])); 
        $ipcDataArray["ipcsubmitdate"] = date("m/d/Y", strtotime($ipcrows['ipcsubmitdate'])); 
        $ipcDataArray["ipcreceivedate"] = date("m/d/Y", strtotime($ipcrows['ipcreceivedate']));

        $ipcDataArray["status"] = $ipcrows['status']; 

        $result[]=$ipcDataArray;


    }

    $response["success"] = 1;
	$response["Ipc_detail"] = $result;


}

echo json_encode($response);
?>