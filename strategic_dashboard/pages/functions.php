<?php
function proj_name($pid)
{
include_once("connect.php");
global $db;
$sql="Select proj_name from t002project where pid=".$pid;
$res= $db->query ($sql);
$resset=$res->fetch_array();
$proj_name=$resset['proj_name'];
return $proj_name;
}

function pcolor($pid)
{
include_once("connect.php");
global $db;
$sql="Select pcolor from t002project where pid=".$pid;
$res= $db->query ($sql);
$resset=$res->fetch_array();
$pcolor=$resset['pcolor'];
return $pcolor;
}
?>