<!-- addlocation -->

<?php 
	include "config.php";
	$uid=$_POST["id"];
	$sql="delete from location where lid='{$uid}'";
	if($con->query($sql)){
		echo true;
	}else{
		echo false;
	}
?>

<!-- photovedio -->

<?php 
	include "config.php";
	$pvid=$_POST["ptid"];
	$sql="delete from uploadpv where upvid ='{$pvid}'";
	if($con->query($sql)){
		echo true;
	}else{
		echo false;
	}
?>