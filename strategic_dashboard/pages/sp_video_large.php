<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
include("connect.php");
include_once("functions.php");

//===============================================

if(isset($_REQUEST["phid"]))
{
$phid=$_REQUEST['phid'];
}

$data_url="dashboard_data/";
} else {
	header("Location: index.php?msg=0");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tarbela 4th Extension  Hydropower Project</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:<?php echo pcolor($pid); ?> "><?php echo proj_name($pid); ?></h1>
<img src="nha1.jpg" alt="nha logo" width="68.12"  height="60.98" style="position:absolute; top: 0px; left: 20px;"  />
<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 130px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>

<img src="nha2.jpg" alt="nha logo" width="104.64" style="position:absolute; top: 20px; right: 20px;" />
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="sub_box">
  <table style="width:100%; height:100%">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span><?php  
			
			
			
			$pdSQL = "SELECT phid, pid, al_file, ph_cap FROM t027project_videos WHERE phid = ".$phid." order by phid";
			 $pdSQLResult = mysqli_query($db, $pdSQL);
			$result = mysqli_fetch_array($pdSQLResult);
			echo $result["ph_cap"];?></span><span style="float:right"><form action="sp_video.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center"><table width="650" class="table table-bordered">
                              <thead>
                              </thead>
                              <tbody>
				
                        <tr>
                          <td>
                          <video id="my-video" class="video-js" controls preload="auto" width="740" height="350"
  poster="photos/thumbs/vidoe.jpg" data-setup="{}">
   
    <source src="<?php echo $data_url.$result["al_file"];?>" type='video/mp4'>
  
    <p class="vjs-no-js">
      To view this video please enable JavaScript, and consider upgrading to a web browser that
      <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
  </video></td>
                        </tr>
                              </tbody>
      </table></td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
