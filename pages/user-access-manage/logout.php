<?php
include_once("../../config/config.php");

$objSDb  		= new Database();
$objCommon 		= new Common();
$objAdminUser 	= new AdminUser();
$user_cd = $objAdminUser->user_cd;
session_start();
$objAdminUser->setLogout();
header("location: signin.php");
?>