<!-- addlocation -->

<?php
include "config.php";
?>

<?php 
	
	$uid=$_POST["uid"];
	$inp1=mysqli_real_escape_string($con,$_POST["inp1"]);
	
	
	if($uid=="0"){
		$sql="insert into location (locat) values ('{$inp1}')";
		if($con->query($sql)){
			$uid=$con->insert_id;
			echo"<tr class='{$uid}'>
				<td>{$uid}</td>
				<td>{$inp1}</td>
				
				<td><a href='#' class='btn btn-primary edit' style='width:70px;' uid='{$uid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' style='width:70px;' uid='{$uid}'>Delete</a></td>					
			</tr>";
			
		}
	}else{
		$sql="update location set locat ='{$inp1}' where lid='{$uid}'";
		if($con->query($sql)){
			echo"
				<td>{$uid}</td>
				<td>{$inp1}</td>
				
				<td><a href='#' class='btn btn-primary edit' style='width:70px;' uid='{$uid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' style='width:70px;' uid='{$uid}'>Delete</a></td>					
			";
		}
	}
?>
 
 