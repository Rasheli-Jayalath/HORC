<?php
include_once 'config.php';
if(isset($_POST['add']))
{	 
	$pvid=$_POST['pvid'];
		$locat1=$_POST['locat1'];
		// $date1=$_POST['date1'];
		// $photoup=$_POST['photoup'];

	//  $sql = "insert into uploadpv (loca, date, photo) values ('{$locat1}','{$date1}','{$photoup}')";
     $sql = "insert into uploadpv (loca) values ('{$locat1}')";
	 if (mysqli_query($con, $sql)) {
		echo "New record created successfully !";
	 } else {
		echo "Error: " . $sql . " " . mysqli_error($con);
	 }
	 mysqli_close($con);
}
?>