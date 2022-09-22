<?php

include_once("../../config/config.php");
require_once('../../rs_lang.admin.php');
require_once('../../rs_lang.eng.php');
$objDb  		    = new Database();
$objDb1  		    = new Database();
$objCommon 	  	= new Common();
$objAdminUser 	= new AdminUser();
$objNews 	    	= new News();
$superadmin 	= $_SESSION['ne_sadmin'];
$news_flag 		= $_SESSION['ne_news'];
$newsadm_flag 	= $_SESSION['ne_newsadm'];
$newsentry_flag = $_SESSION['ne_newsentry'];
$strusername 	= $_SESSION['ne_username'];

if($superadmin==0)
{
//header("Location: ./index.php?init=3");
}
if(($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['cancel']=="Cancel"))
{
//redirect('./?p=user_mgmt');
}
if(($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['refresh']=="Refresh"))
{
 $u_id= $_GET["user_cd"];
//redirect('./?p=update_rights&user_cd='.$u_id);
}

 $u_id= $_GET["user_cd"];
 $sql_name="Select first_name, last_name from mis_tbl_users where user_cd=".$u_id;
 $sql_name_q=$objDb->dbQuery($sql_name);
 $sql_name_res=$objDb->dbFetchArray();
 $firstnam=$sql_name_res['first_name'];
 $lastnam=$sql_name_res['last_name'];
 $name_full=$firstnam." ".$lastnam;
$mode	= "I";
if(($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['save']=="Save"))
{
	echo "dnfgjfdjgdfg";
	
	//////albums

$sql = "SELECT * FROM t031project_albums where parent_album=0 order by albumid";
$sqlresult = $objDb->dbQuery($sql);
while ($data = $objDb->dbFetchArray()) {

	$cdlist = array();
	
	
		$catsid = $data['albumid'];
		
		 $status_album= trim($_POST['statusalbum'.$catsid]);
		
		
		if($status_album==0)
				{
				if (strpos($data['user_ids'], $u_id) !== false) 
		   					{								
							$arr_ids=explode(",",$data['user_ids']);						
							$len=count($arr_ids);		
							if($len==1)
								{
									if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$data['user_ids']);
										$f_flag=1;
										}
									}
									else
									{
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$data['user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$data['user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $data['user_ids'];
							$concatrights= $data['user_right'];
							}
		
				}
				else
				{
					
				
					if(($data['user_ids']=="") && ($data['user_right']==""))
					{
						
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_album;
					}
					else
					{
						
						 if (strpos($data['user_ids'], $u_id) !== false) 
		   					{
								
								$arr_uid=explode(",",$data['user_ids']);
									
									 $len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$data['user_ids'];
											}
										}
								//$concatids=$cddata3['user_ids'];
								//$concatrights=$cddata3['user_right'];
									$arr_status1=explode(",",$data['user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_album)
											{
											
											$concatrights1=$data['user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_album;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$data['user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$data['user_ids'].",".$u_id;
							$concatrights=$data['user_right'].",".$u_id."_".$status_album;
							} 
					}
				}
			
			$sqlu="UPDATE t031project_albums set user_ids='$concatids',user_right='$concatrights' where albumid=$catsid"; 
				$sql_run=$objDb1->dbQuery($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				

	}
	
	
	
	
	//////Grawing albums

$sql = "SELECT * FROM t031project_drawingalbums where parent_id=0 order by albumid";
$sqlresult = $objDb->dbQuery($sql);
while ($data = $objDb->dbFetchArray()) {

	$cdlist = array();
	
	
		$catsid = $data['albumid'];
		
		 $status_d= trim($_POST['statusd'.$catsid]);
		
		
		if($status_d==0)
				{
				if (strpos($data['user_ids'], $u_id) !== false) 
		   					{								
							$arr_ids=explode(",",$data['user_ids']);						
							$len=count($arr_ids);		
							if($len==1)
								{
									if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$data['user_ids']);
										$f_flag=1;
										}
									}
									else
									{
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$data['user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$data['user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $data['user_ids'];
							$concatrights= $data['user_right'];
							}
		
				}
				else
				{
					
				
					if(($data['user_ids']=="") && ($data['user_right']==""))
					{
						
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_d;
					}
					else
					{
						
						 if (strpos($data['user_ids'], $u_id) !== false) 
		   					{
								
								$arr_uid=explode(",",$data['user_ids']);
									
									 $len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$data['user_ids'];
											}
										}
								//$concatids=$cddata3['user_ids'];
								//$concatrights=$cddata3['user_right'];
									$arr_status1=explode(",",$data['user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_album)
											{
											
											$concatrights1=$data['user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_d;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$data['user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$data['user_ids'].",".$u_id;
							$concatrights=$data['user_right'].",".$u_id."_".$status_d;
							} 
					}
				}
			
			$sqlu="UPDATE t031project_drawingalbums set user_ids='$concatids',user_right='$concatrights' where albumid=$catsid"; 
				$sql_run=$objDb1->dbQuery($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				

	}
	
		//////Project Issues

echo $sql = "SELECT * FROM structures order by lid";
$sqlresult = $objDb->dbQuery($sql);
while ($data = $objDb->dbFetchArray()) {

	$cdlist = array();
	
	
		$catsid = $data['lid'];
		
		 $status_iss= trim($_POST['statusiss'.$catsid]);
		
		
		if($status_iss==0)
				{
				if (strpos($data['issue_user_ids'], $u_id) !== false) 
		   					{								
							$arr_ids=explode(",",$data['issue_user_ids']);						
							$len=count($arr_ids);		
							if($len==1)
								{
									if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$data['issue_user_ids']);
										$f_flag=1;
										}
									}
									else
									{
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$data['issue_user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$data['issue_user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $data['issue_user_ids'];
							$concatrights= $data['issue_user_right'];
							}
		
				}
				else
				{
					
				
					if(($data['issue_user_ids']=="") && ($data['issue_user_right']==""))
					{
						
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_iss;
					}
					else
					{
						
						 if (strpos($data['issue_user_ids'], $u_id) !== false) 
		   					{
								
								$arr_uid=explode(",",$data['issue_user_ids']);
									
									 $len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$data['issue_user_ids'];
											}
										}
								//$concatids=$cddata3['issue_user_ids'];
								//$concatrights=$cddata3['issue_user_right'];
									$arr_status1=explode(",",$data['issue_user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_iss)
											{
											
											$concatrights1=$data['issue_user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_iss;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$data['issue_user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$data['issue_user_ids'].",".$u_id;
							$concatrights=$data['issue_user_right'].",".$u_id."_".$status_iss;
							} 
					}
				}
			
				$sqlu="UPDATE structures set issue_user_ids='$concatids',issue_user_right='$concatrights' where lid=$catsid"; 
				$sql_run=$objDb1->dbQuery($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				

	}	
	
	
	//////Non Confirmity Notices

$sql = "SELECT * FROM structures order by lid";
$sqlresult = $objDb->dbQuery($sql);
while ($data = $objDb->dbFetchArray()) {

	$cdlist = array();
	
	
		$catsid = $data['lid'];
		
		 $status_ncn= trim($_POST['statusncn'.$catsid]);
		
		
		if($status_ncn==0)
				{
				if (strpos($data['ncn_user_ids'], $u_id) !== false) 
		   					{								
							$arr_ids=explode(",",$data['ncn_user_ids']);						
							$len=count($arr_ids);		
							if($len==1)
								{
									if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$data['ncn_user_ids']);
										$f_flag=1;
										}
									}
									else
									{
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$data['ncn_user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$data['ncn_user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $data['ncn_user_ids'];
							$concatrights= $data['ncn_user_right'];
							}
		
				}
				else
				{
					
				
					if(($data['ncn_user_ids']=="") && ($data['ncn_user_right']==""))
					{
						
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_ncn;
					}
					else
					{
						
						 if (strpos($data['ncn_user_ids'], $u_id) !== false) 
		   					{
								
								$arr_uid=explode(",",$data['ncn_user_ids']);
									
									 $len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$data['ncn_user_ids'];
											}
										}
								//$concatids=$cddata3['ncn_user_ids'];
								//$concatrights=$cddata3['ncn_user_right'];
									$arr_status1=explode(",",$data['ncn_user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_ncn)
											{
											
											$concatrights1=$data['ncn_user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_ncn;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$data['ncn_user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$data['ncn_user_ids'].",".$u_id;
							$concatrights=$data['ncn_user_right'].",".$u_id."_".$status_ncn;
							} 
					}
				}
			
				$sqlu="UPDATE structures set ncn_user_ids='$concatids',ncn_user_right='$concatrights' where lid=$catsid"; 
				$sql_run=$objDb1->dbQuery($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				

	}
	
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('includes/metatag.php'); ?>
<script type="text/javascript">
function doFilter(frm){
	var qString = '';
	if(frm.user_name.value != ""){
		qString += '&user_name=' + escape(frm.user_name.value);
	}
	document.location = '?p=user_mgmt' + qString;
}
</script>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>User Management</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">

  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../css/basic-styles.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  
  <!-- CSS scrollbar style -->
  <link id="pagestyle" href="../../css/scrollbarStyle.css" rel="stylesheet" />

 <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- bootstrap -->
  <style>
        .margintopCSS {
          margin-top:10px;
        }   
        
        .text-34{
  background-color: #151563;
  border-radius: 10px;
  /* box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px; */
  padding-bottom: 12px;
  padding-top: 12px;
  border-radius: 5px 5px;
  color: white;
  font-size: 100%;
  /* margin-right: 5%; */
  /* right: 5%;
  left: 5%; */


}
.new_div li {
    list-style: outside none none;
}
        
.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("../../images/images/frame.png") no-repeat scroll 0 0;
    float: left;
    height: 130px;
    padding: 50px 0 0 6px;
    width: 152px;
	padding-left: 21px !important;
}

.imageTitle {
    color: #464646;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: normal;
}
.text-33{
  background-color: #151563;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  padding-bottom: 8px;
  padding-top: 8px;
  border-radius: 0px 20px;
  color: white;
  /* margin-right: 5%; */
  /* right: 5%;
  left: 5%; */


}
/*table{
    border:  double ;

    }*/
.shadow_table{
	box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
	  border-radius: 6px;
}
	
.text_width_table{
	max-width: 350px;
    word-wrap: initial;
}
.button-33 {
  background-color: #1a1a7d;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  color: white;
  cursor: pointer;
  font-weight: 600;
  margin-left:1%;
  display: inline-block;
  font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
  padding: 5px 2px;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 13px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-33:hover {
  box-shadow: rgba(22, 22, 51,.35) 0 -25px 18px -14px inset,rgba(22, 22, 51,.25) 0 1px 2px,rgba(22, 22, 51,.25) 0 2px 4px,rgba(22, 22, 51,.25) 0 4px 8px,rgba(22, 22, 51,.25) 0 8px 16px,rgba(22, 22, 51,.25) 0 16px 32px;
  transform: scale(1.1) ;
}
.button-34 {
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(26, 26, 125);
  color: #1a1a7d;
  /* box-shadow: rgba(34, 34, 199, .02) 0 -25px 18px -14px inset,rgba(34, 34, 199, .05) 0 1px 2px,rgba(34, 34, 199, .05) 0 2px 4px,rgba(34, 34, 199, .05) 0 4px 8px,rgba(34, 34, 199, .05) 0 8px 16px,rgba(34, 34, 199, .10) 0 16px 32px; */
  box-shadow: none;
  padding: 15px 1px;
  border-radius: 0px;
  font-size: 73%;

  font-weight: 900;
  margin-left:0%;
}
.button-34:hover {
  background-color: #1f1f91;
  color: #fff;
  font-weight: 900;
  font-size: 75%;
  transform: scale(1.05) ;
}
.button-35 {

  padding: 12px 2px;

  font-size: 73%;
  font-weight: 700;
  margin-left:0%;
}
.button-35:hover {
  transform: scale(1.0) ;
  font-size: 85%;
}
.sm-unLine {

  font-weight: 600;
  /* text-decoration-line: underline;
  text-decoration: underline solid #1f1f91 1px;
  text-underline-position: under; */
  
  /* border-bottom: 3px solid #f9dd94; */
 
}

/* .sm-unLine::after {
  content: "";
  display: block;

  padding-top: 3px;
  border-bottom: 2px solid #f9dd94;
} */

/* #u-border-head {
  height:3px;
  background-color: rgba(31, 31, 145 );

  border-radius:10px 30px;
  padding:3.8px;
} */
 

    </style>
<style>
.inactive
{
pointer-events: none;
opacity: 0.5;
background: #CCC;
}
</style>

<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.first_name.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_FIRSTNAME;?>";
		flag = false;
	}

	if(frm.email.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_EMAIL;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>

<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
	


	
		</script>
		


</head>
<body>

  <div class="container-scroller">
    
     <!-- partial:partials/_navbar.html -->
     <div id="partials-navbar"></div>
     <!-- partial -->
 
     <div class=" page-body-wrapper" id="pagebodywraper">
     
 
       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->

      <div class="main-panel " id="mainpanel">
      <div class="content-wrapper" style="">



    
<h4 class="text-center text-34" style="  letter-spacing: 4px"> User Management</h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-4 " style="  font-weight: 600;">  
	<?php

	 echo ($mode == "U") ? "Manage Rights &raquo; ".$name_full : "Manage Rights &raquo; ".$name_full?>
	</div>
    
		
		
	<div class="col-sm-8 text-end" >  
	
<button type="button" class="col-sm-2 button-33" onclick="location.href='user_mangement.php';" >  <?php echo "Back";?> </button>

	</div>
</div>

<div class="row pb-4 pt-3 text-end" >
<div style="margin-top:10px; font-size:14px; color:green"><?php echo $activity?></div>
</div>

	


                              
<div class="table-responsive">
  <form name="form1" method="post" action="">
		<table width="100%" border="1px solid" bgcolor="#EFEFEF">
        <tr><td colspan="2" style="font-size:16px; font-weight:bold; color:#000000">Gallery (Photos/Videos)</td></tr>
		 <tr>
<!--<td width="70%" align="right" style="font-weight:bold; font-size:12px">All rights will enable in one click</td>
<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status_all" value="2" onclick="Showactiveall(2,<?php echo $u_id; ?>)"  >R
  <input type="radio" name="status_all" value="1" onclick="Showactiveall(1,<?php echo $u_id; ?>)">R/W
  <input type="radio" name="status_all" value="3" onclick="Showactiveall(3,<?php echo $u_id; ?>)">R/W/D
  <input type="radio" name="status_all" value="0" onclick="Showactiveall(0,<?php echo $u_id; ?>)"> No
  </div>

		</td>-->
		</tr>
		</table>
		<div id="allalbum">
		<?php
 $sql = "SELECT * FROM t031project_albums where parent_album=0 order by albumid";
$sqlresult = $objDb->dbQuery($sql);
while ($data_t = $objDb->dbFetchArray()) {
	$cdlist_album=array();
	$comp_id=$data_t['albumid'];
	$comp_name=$data_t['album_name'];	
	?>
	
<div id="abcd_album<?php echo $comp_id;?>">
<table border="1px solid" width="100%" >

			<tr>			
						
			<?php
			$colorr="#FFF9F9";			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
				
			echo $comp_name;		  
		   ?>
		</td>
		<?php
		$colorr="";
		  $abc= $_GET["user_cd"];
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$data_t['user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if(isset($comp_id))
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$data_t['user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$data_t['user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($data_t['user_right'], $abc."_3") !== false) || (strpos($data_t['user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$data_t['user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="statusalbum<?php echo $comp_id;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> >R
  <input type="radio" name="statusalbum<?php echo $comp_id;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?>  >R/W
   <input type="radio" name="statusalbum<?php echo $comp_id;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?> >R/W/D
  <input type="radio" name="statusalbum<?php echo $comp_id;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> > No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist_album);
	
}
			?>
			</div>
            
           <br /> 
           <table width="100%" border="1px solid" bgcolor="#EFEFEF">
        <tr><td colspan="2" style="font-size:16px; font-weight:bold; color:#000000">Maps and Drawings</td></tr>
		 <tr>
<!--<td width="70%" align="right" style="font-weight:bold; font-size:12px">All rights will enable in one click</td>
<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status_all" value="2" onclick="Showactiveall(2,<?php echo $u_id; ?>)"  >R
  <input type="radio" name="status_all" value="1" onclick="Showactiveall(1,<?php echo $u_id; ?>)">R/W
  <input type="radio" name="status_all" value="3" onclick="Showactiveall(3,<?php echo $u_id; ?>)">R/W/D
  <input type="radio" name="status_all" value="0" onclick="Showactiveall(0,<?php echo $u_id; ?>)"> No
  </div>

		</td>-->
		</tr>
		</table>
       <div id="alld">
		<?php
 $sql = "SELECT * FROM t031project_drawingalbums where parent_id=0 order by albumid";
$sqlresult = $objDb->dbQuery($sql);
while ($data_t = $objDb->dbFetchArray()) {
	$cdlist_d=array();
	$comp_id=$data_t['albumid'];
	$comp_name=$data_t['album_name'];	
	?>
	
<div id="abcd_d<?php echo $comp_id;?>">
<table border="1px solid" width="100%" >

			<tr>			
						
			<?php
			$colorr="#FFF9F9";			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
				
			echo $comp_name;		  
		   ?>
		</td>
		<?php
		$colorr="";
		  $abc= $_GET["user_cd"];
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$data_t['user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if(isset($comp_id))
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$data_t['user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$data_t['user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($data_t['user_right'], $abc."_3") !== false) || (strpos($data_t['user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$data_t['user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="statusd<?php echo $comp_id;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> >R
  <input type="radio" name="statusd<?php echo $comp_id;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?>  >R/W
   <input type="radio" name="statusd<?php echo $comp_id;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?> >R/W/D
  <input type="radio" name="statusd<?php echo $comp_id;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> > No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist_d);
	
}
			?>
			</div>
            
            
            
            
            
            
            
             <br /> 
<table width="100%" border="1px solid" bgcolor="#EFEFEF">
           <tr><td colspan="2" style="font-size:16px; font-weight:bold; color:#000000">Project Issues</td></tr>
		 <!--<tr>
<td width="70%" align="right" style="font-weight:bold; font-size:12px">All rights will enable in one click</td>
<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status_all_ncn" value="2" onclick="Showactivealld(2,<?php echo $u_id; ?>)"  >R
  <input type="radio" name="status_all_ncn" value="1" onclick="Showactivealld(1,<?php echo $u_id; ?>)">R/W
  <input type="radio" name="status_all_ncn" value="3" onclick="Showactivealld(3,<?php echo $u_id; ?>)">R/W/D
  <input type="radio" name="status_all_ncn" value="0" onclick="Showactivealld(0,<?php echo $u_id; ?>)"> No
  </div>

		</td>
		</tr>-->
		</table>        
            
 <div id="alliss">
		<?php
		$sql = "SELECT * FROM structures  order by lid";
$sqlresult = $objDb->dbQuery($sql);
while ($data_t = $objDb->dbFetchArray()) {
	$cdlist_iss=array();
	$comp_id=$data_t['lid'];
	$comp_name=$data_t['title'];	
	?>
	
<div id="abcd_iss<?php echo $comp_id;?>">
<table border="1px solid" width="100%" >

			<tr>			
						
			<?php
			$colorr="#FFF9F9";			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
				
			echo $comp_name;		  
		   ?>
		</td>
		<?php
		$colorr="";
		  $abc= $_GET["user_cd"];
		if ((strpos($data_t['issue_user_right'], $abc."_1") !== false) || (strpos($data_t['issue_user_right'], $abc."_2") !== false) || (strpos($data_t['issue_user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$data_t['issue_user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if(isset($comp_id))
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($data_t['issue_user_right'], $abc."_1") !== false) || (strpos($data_t['issue_user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$data_t['issue_user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($data_t['issue_user_right'], $abc."_2") !== false) || (strpos($data_t['issue_user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$data_t['issue_user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($data_t['issue_user_right'], $abc."_3") !== false) || (strpos($data_t['issue_user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$data_t['issue_user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="statusiss<?php echo $comp_id;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> >R
  <input type="radio" name="statusiss<?php echo $comp_id;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?>  >R/W
   <input type="radio" name="statusiss<?php echo $comp_id;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?> >R/W/D
  <input type="radio" name="statusiss<?php echo $comp_id;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> > No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist_iss);
	
}
			?>
			</div>           
            
            
            
            
            
                <br /> 
                <table width="100%" border="1px solid" bgcolor="#EFEFEF">
           <tr><td colspan="2" style="font-size:16px; font-weight:bold; color:#000000">Non Confirmity Notices</td></tr>
		 <!--<tr>
<td width="70%" align="right" style="font-weight:bold; font-size:12px">All rights will enable in one click</td>
<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status_all_ncn" value="2" onclick="Showactivealld(2,<?php echo $u_id; ?>)"  >R
  <input type="radio" name="status_all_ncn" value="1" onclick="Showactivealld(1,<?php echo $u_id; ?>)">R/W
  <input type="radio" name="status_all_ncn" value="3" onclick="Showactivealld(3,<?php echo $u_id; ?>)">R/W/D
  <input type="radio" name="status_all_ncn" value="0" onclick="Showactivealld(0,<?php echo $u_id; ?>)"> No
  </div>

		</td>
		</tr>-->
		</table>  
                 <div id="allncn">
		<?php
		$sql = "SELECT * FROM structures  order by lid";
$sqlresult = $objDb->dbQuery($sql);
while ($data_t = $objDb->dbFetchArray()) {
	$cdlist_ncn=array();
	$comp_id=$data_t['lid'];
	$comp_name=$data_t['title'];	
	?>
	
<div id="abcd_ncn<?php echo $comp_id;?>">
<table border="1px solid" width="100%" >

			<tr>			
						
			<?php
			$colorr="#FFF9F9";			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
				
			echo $comp_name;		  
		   ?>
		</td>
		<?php
		$colorr="";
		  $abc= $_GET["user_cd"];
		if ((strpos($data_t['ncn_user_right'], $abc."_1") !== false) || (strpos($data_t['ncn_user_right'], $abc."_2") !== false) || (strpos($data_t['ncn_user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$data_t['ncn_user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if(isset($comp_id))
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($data_t['ncn_user_right'], $abc."_1") !== false) || (strpos($data_t['ncn_user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$data_t['ncn_user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($data_t['ncn_user_right'], $abc."_2") !== false) || (strpos($data_t['ncn_user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$data_t['ncn_user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($data_t['ncn_user_right'], $abc."_3") !== false) || (strpos($data_t['ncn_user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$data_t['ncn_user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="statusncn<?php echo $comp_id;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> >R
  <input type="radio" name="statusncn<?php echo $comp_id;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?>  >R/W
   <input type="radio" name="statusncn<?php echo $comp_id;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?> >R/W/D
  <input type="radio" name="statusncn<?php echo $comp_id;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> > No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist_ncn);
	
}
			?>
			</div>
                 
                
                
            
                        <br /> 
       
            
            
            
            
            
            
            
			<input type="submit" name="save" value="Save" />
			<input type="submit" name="cancel" value="Cancel" />
			<input type="submit" name="refresh" value="Refresh" />
			</form>
		</div>
  </div><!-- class="content-wrapper" -->

   
        <!-- partial:../../partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->

         </div>     <!--content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <!-- <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script> -->
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/chart.js"></script>
  <!-- <script src="../../js/navtype_session.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


  <!-- End custom js for this page-->



  <script>
    $(function(){
      $("#partials-navbar").load("../../partials/_navbar.php");
    });
</script>

<script>
  $(function(){
    $("#partials-theme-setting-wrapper").load("../../partials/_settings-panel.php");
  });
</script>

<script>
  $(function(){
    $("#partials-sidebar-offcanvas").load("../../partials/_sidebar.php");
  });
</script>

<script>
$(function(){
  $("#partials-footer").load("../../partials/_footer.php");
});
</script>


<script language="javascript" type="text/javascript">



</script>



</body>
</html>