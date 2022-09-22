
 <?php
include "config.php";
?>
 <?php
{	 
	$pvid=$_POST["pvid"];
	$locat1=mysqli_real_escape_string($con,$_POST["locat1"]);
	$date1=mysqli_real_escape_string($con,$_POST["date1"]);
	$photoup=mysqli_real_escape_string($con,$_POST["photoup"]);

	
	
	if($pvid=="0"){
		$sql="insert into uploadpv (loca, date, photo) values ('{$locat1}','{$date1}','{$photoup}')";
		if($con->query($sql)){
			$pvid=$con->insert_id;
			echo"<tr class='{$pvid}'>
				<td>{$pvid}</td>
				<td>{$locat1}</td>
				<td>{$date1}</td>
				<td>{$photoup}</td>
				
				<td><a href='#' class='btn btn-primary edit' style='width:70px;' pvid='{$pvid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' style='width:70px;' pvid='{$pvid}'>Delete</a></td>					
			</tr>";
			
		}
	}else{
		$sql="update uploadpv set loca ='{$locat1}', date='{$date1}',photo='{$photoup}' where upvid ='{$pvid}'";
		if($con->query($sql)){
			echo"
			<td>{$pvid}</td>
			<td>{$locat1}</td>
			<td>{$date1}</td>
			<td>{$photoup}</td>
				
				<td><a href='#' class='btn btn-primary edit' style='width:70px;' pvid='{$pvid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' style='width:70px;' pvid='{$pvid}'>Delete</a></td>					
			";
		}
	}
}
?>

<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["photoup"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["add"])) {
  $check = getimagesize($_FILES["photoup"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["photoup"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["photoup"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["photoup"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>





 

