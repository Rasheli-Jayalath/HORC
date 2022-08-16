<?php
 /* if($_SERVER['HTTP_HOST'] == "mysqlcluster10.registeredsite.com" )
	{ */

	$db = mysqli_connect("localhost", "root", "SJ_Smec@egc_2012") or die("Could not connect.");
	 /* }
	 else
	{
$db = mysql_connect("localhost", "root", "") or die("Could not connect.");
	} */ 
// if(!$db) 
// 	die("no db");
// if(!mysqli_select_db("t4e_dashboard",$db))
//  	die("No database selected.");

$db_select = mysqli_select_db($db, "t4e_dashboard");
if (!$db_select) {
    error_log("Database selection failed: " . mysqli_error($db));
    die('Internal server error');
}

?>

