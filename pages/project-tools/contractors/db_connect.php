<?php
$host="localhost";
$dbnmame="assam_dms";
$dbuser="root";
$dpassword="SJ_Smec@egc_2012";
$con = new PDO("mysql:host=$host;dbname=$dbnmame;charset=UTF8", $dbuser, $dpassword, array(PDO::ATTR_PERSISTENT => true));
//$db = @mysql_connect("localhost:3307", "indacenadmin", "SJ_Smec@egc_2012") or die("Could not connect.");
	 /* }
	 else
	{
$db = mysql_connect("localhost", "root", "") or die("Could not connect.");
	} */ 
/*if(!$db) 
	die("no db");
	mysql_set_charset('UTF8',$db);
if(!@mysql_select_db("adselrp_dms",$db))
 	die("No database selected.");*/
	$pmis_db="demo_pmis";
	$report_url="../../../DMS/project_reports/";
	//$root_db="assam";

?>