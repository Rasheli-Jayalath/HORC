<?php
$request_uri = $_SERVER['REQUEST_URI'];
//$_SESSION['log_id']=1;
$log_id = $_SESSION['log_id'];
echo $iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$request_uri')");
$objDb->dbQuery($iSQL);
?>