<?php
include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$ObjMapDrawing  = new  MapsDrawings();
$ObjMapDrawing2 = new MapsDrawings();
$ObjMapDrawing3 = new MapsDrawings();
$ObjMapDrawing4 = new MapsDrawings();
$objAdminUser 	= new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$_SESSION['ne_user_type'];
//echo $_SESSION['ne_user_type']=1;
$data_url="drawings/";
//$file_path="pictorial_data";
//$data_url="photos/";
$log_id=1;
 $album_id=$_REQUEST['album_id'];

						 $pictomaxpid = $ObjMapDrawing->getMaxPid(); 
						 while($plevelrows=$ObjMapDrawing->dbFetchArray())
						{
						  $pid = $plevelrows['pid'];
						} 


 if(isset( $album_id))
 {
 $pdSQL_get_right1_d = "SELECT parent_group FROM  t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and albumid=".$album_id;
 $ObjMapDrawing->dbQuery($pdSQL_get_right1_d);
 $result_get_right1d =$ObjMapDrawing->dbFetchArray();

							 $p_groupd=$result_get_right1d['parent_group'];
				$arr_gpd=explode("_", $p_groupd);
				$group_countd=count($arr_gpd);
				if($group_countd>1)
				{
				 $get_album_idd=$arr_gpd[1];
				$pdSQL_get_rightd = "SELECT user_ids,user_right FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_idd;
				 $ObjMapDrawing2->dbQuery($pdSQL_get_rightd);
 				$result_get_right1d =$ObjMapDrawing2->dbFetchArray();

				}
 }
 
 
 if(isset($album_id)&&!empty( $album_id))
 {


 $sqlss="SELECT albumid, pid, parent_id, album_name,parent_group, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and  albumid = ".$album_id;
	$ObjMapDrawing->dbQuery($sqlss);
	$sqlrw1ss=$ObjMapDrawing->dbFetchArray();
	$par_groups=$sqlrw1ss['parent_group'];
	$album_name=$sqlrw1ss['album_name'];
	
	$parent_id=$sqlrw1ss['albumid']; 
 	 $prt_id=$sqlrw1ss['parent_id'];
	$status=$sqlrw1ss['status'];
	$par_arr=explode("_",$par_groups);
	$lenns=count($par_arr);
	$f_name="";
	for($i=0;$i<$lenns;$i++)
	{
	$sqlCN="select albumid,album_name,parent_id from t031project_drawingalbums where albumid='$par_arr[$i]' ";	
	$ObjMapDrawing2->dbQuery($sqlCN);
	//$sqlrCN=mysql_query($sqlCN);
	//$sqlCNrw=mysql_fetch_array($sqlrCN);
	$sqlCNrw=$ObjMapDrawing2->dbFetchArray();
	
	$f_name .='<a style="text-decoration:none" href="./dm_drawingmap.php?album_id='.$sqlCNrw['albumid'].'">'.$sqlCNrw['album_name'].'</a>';
	
	$f_name .="&nbsp;&raquo;&nbsp;";
	
	}
   $fold_name=$f_name;

 }
 else
 {
 $parent_id=0;
 }
 
if(isset($_REQUEST['lid']))
{
$lid=$_REQUEST['lid'];
$pdSQL1="SELECT lid, pid, title FROM  locations  WHERE  lid = ".$lid;
$ObjMapDrawing->dbQuery($pdSQL1);
//$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 =$ObjMapDrawing->dbFetchArray();
//$pdData1 = mysql_fetch_array($pdSQLResult1);

$title=$pdData1['title'];

}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['lid'])&$_REQUEST['lid']!="")
{

 $ObjMapDrawing->dbQuery("Delete from  locations where lid=".$_REQUEST['lid']);
 header("Location: location_form.php");
}

///Filter
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST["go_submit"])){
$dwg_type = $_POST['dwg_type'];

if(isset($_GET['cat_cd']))
{
$cat_cd_new='&cat_cd='.$_GET['cat_cd'];
}
if($dwg_type=='All')
{
header('Location:dm_drawingmap.php?album_id='.$_GET['album_id']);
}
else
{
header('Location:dm_drawingmap.php?album_id='.$_GET['album_id'].'&dwg_type='.$dwg_type );
}
}
///Filter End
 if(isset($_REQUEST['act'])&&isset($_REQUEST['dwgid'])&&isset($_REQUEST['album_id'])&&$_REQUEST['dwgid']!="" && $_REQUEST['act']=='delete')
{
$pdSQL1="SELECT al_file FROM  t027project_drawings  WHERE  dwgid = ".$_REQUEST['dwgid'];
$ObjMapDrawing->dbQuery($pdSQL1);
//$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 =$ObjMapDrawing->dbFetchArray();
//$pdData1 = mysql_fetch_array($pdSQLResult1);

$al_file=$pdData1['al_file'];
@unlink($data_url.$al_file);
$album_id=$_REQUEST['album_id'];
 $ObjMapDrawing3->dbQuery("Delete from t027project_drawings where dwgid=".$_REQUEST['dwgid']." and album_id=".$_REQUEST['album_id']);
 $activity="Folder id(".$_REQUEST['album_id'].") Drawing id(".$_REQUEST['dwgid'].") - Drawing record Deleted Successfully";
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
$ObjMapDrawing2->dbQuery($iSQL);
//mysql_query($iSQL);
 header("Location:dm_drawingmap.php?album_id=$album_id");
}


$pdSQLq="";
$pdSQLq = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title FROM  project_photos a inner join locations b on(a.ph_cap=b.lid) WHERE a.pid=".$pid;
		
		if(!empty($_GET['location'])){
			$location = urldecode($_GET['location']);
			$pdSQLq .=" AND ph_cap='".$location."'";
		}
		if(!empty($_GET['date_p'])){
			$date_p = urldecode($_GET['date_p']);
			$pdSQLq .=" AND (date_p='".$date_p."'";
		}
		if(!empty($_REQUEST['date_p2'])){
			$date_p2 = urldecode($_REQUEST['date_p2']);
			$pdSQLq .=" OR date_p='".$date_p2."' )";
		}
	//	echo $pdSQLq;
		
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Maps and Drawings</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../../css/basic-styles.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />
  
  <!-- CSS scrollbar style -->
  <link id="pagestyle" href="../../../css/scrollbarStyle.css" rel="stylesheet" />

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
.new_div li {
    list-style: outside none none;
} 
.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("../../../images/images/frame.png") no-repeat scroll 0 0;
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
.rl-p0{
  padding-left:0;
  padding-right:0;
  padding-bottom: 0;
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
.button-33 {
  background-color: #1a1a7d;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  color: white;
  cursor: pointer;
  font-weight: 600;
  margin-left:2%;
  display: inline-block;
  font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
  padding: 1% 3%;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 13px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  float: right;
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

#u-border-head {
  height:3px;
  background-color: rgba(31, 31, 145, 0.6 );

  border-radius:10px 30px;
  padding:3.8px;
}
 
    </style>

<script type="text/javascript">
function getGalleryView(month) 
	{
	
		var location=document.getElementById("location").value;  
			
		if (month!="") {
			var strURL="findGalleryView.php?date_p="+month+" &location="+location;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('Gallery_View').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		   
	}
function doFilter(frm){
	var qString = '';
	if(frm.location.value != ""){
		qString += 'location=' + escape(frm.location.value);
	}
	
	if(frm.date_p.value != ""){
		qString += '&date_p=' + frm.date_p.value;
	}
	if(frm.date_p2.value != ""){
		qString += '&date_p2=' + frm.date_p2.value;
	}

	document.location = 'analysis.php?' + qString;
}
</script>
<script>
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
	
function getDates(lid)
{
	
	if (lid!=0) {
			var strURL="finddate.php?lid="+lid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("location_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 

}
function required(){

	
}
</script>


  <script language="javascript" type="text/javascript">

function getsubcat(albumid) {

			if(albumid==""||albumid==0)
			{
			
			<?php
		
			$cquery = "select * from  t031project_drawingalbums";
			 $ObjMapDrawing2->dbQuery($cquery);
 				while ($cdata =$ObjMapDrawing2->dbFetchArray())
			//$cresult = mysql_query($cquery);
			//while ($cdata = mysql_fetch_array($cresult)) 
			{	
			$album_id=$cdata['albumid'];	

			?>
           document.getElementById("subcatdiv_"+<?php echo $cdata['albumid']?>).style.display="none";
		   document.getElementById("subcatidm").value=albumid;
		   
            <?php }?>
			}
			else
			{
			<?php
		
			$cqueryg = "select * from  t031project_drawingalbums";
			 $ObjMapDrawing->dbQuery($cqueryg);
 				while ($cdatag =$ObjMapDrawing->dbFetchArray())
			//$cresultg = mysql_query($cqueryg);
			//while ($cdatag = mysql_fetch_array($cresultg)) 
			{	
			$album_idg=$cdatag['albumid'];	

			?>
           document.getElementById("subcatdiv_"+<?php echo $cdatag['albumid']?>).style.display="none";
		   	
            <?php }?>

			
			 
           document.getElementById("subcatdiv_"+albumid).style.display="block";
		   document.getElementById("subcatidm").value=albumid;
		   
		   
	
           }
			
						
			var strURL="<?php echo $SITE_URL;?>sel_nextalbum.php?album_id="+albumid;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("subcatdiv_"+albumid).innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
	}
	
	function getXMLHTTP1() { //fuction to return the xml http object
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
	function subcatlisting(subalbumid,albumid,parent_id) {

		 if(albumid!="" && subalbumid==0)
		  {
		  var myArray = albumid.split('_');		  
		  var len=myArray.length;
		  var subalbum=myArray[len-1];
		   <?php
		 $cquery2 = "select * from  t031project_drawingalbums";	
		 	$ObjMapDrawing->dbQuery($cquery2);
 				while ($cdata2 =$ObjMapDrawing->dbFetchArray())	
			//$cresult2 = mysql_query($cquery2);
			//while ($cdata2 = mysql_fetch_array($cresult2)) 
			{	
			$album_id2=$cdata2['albumid'];
			?>
		    document.getElementById("subcatdiv_"+<?php echo $cdata2['albumid']?>).style.display="none";
			 <?php
		  }
		   ?>		   
		   for(var i=0; i<len; i++)
		   {
		    document.getElementById("subcatdiv_"+myArray[i]).style.display="block";
			 document.getElementById("subcatidm").value=myArray[i]; 		
		   }
		 	
		  }
		  else 
		  {
		 
		  var myArray1 = albumid.split('_');		  
		  var len1=myArray1.length;
		  var subalbum=myArray1[len1-1];
		   <?php
		 $cquery2 = "select * from  t031project_drawingalbums";			
			$ObjMapDrawing2->dbQuery($cquery2);
 				while ($cdata2 =$ObjMapDrawing2->dbFetchArray())	
			//$cresult2 = mysql_query($cquery2);
			//while ($cdata2 = mysql_fetch_array($cresult2))
			 {	
			$album_id2=$cdata2['albumid'];
			?>
		    document.getElementById("subcatdiv_"+<?php echo $cdata2['albumid']?>).style.display="none";
			 <?php
		  }
		   ?>		   
		   for(var j=0; j<len1; j++)
		   {
		    document.getElementById("subcatdiv_"+myArray1[j]).style.display="block";
			
		   }
		   document.getElementById("subcatdiv_"+subalbumid).style.display="block"; 
		  	 document.getElementById("subcatidm").value=subalbumid;
			
		  }
		
			var strURL1="sel_subalbum.php?subalbum_id="+subalbumid+"&albumid="+albumid;
			var req1 = getXMLHTTP1();			
			if (req1) {
			
				req1.onreadystatechange = function() {
					if (req1.readyState == 4) {
						// only if "OK"
						if (req1.status == 200) 
						{
					
						document.getElementById("subcatdiv_"+subalbumid).innerHTML=req1.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req1.statusText);
						}
					}				
				}			
				req1.open("GET", strURL1, true);
				req1.send(null);
			}
		
	}
	
	function advSearch(albumid,last_subalbum,dwg_type,dwg_no,dwg_title,dwg_date,revision_no,dwg_status) {
	if(albumid==0)
	{
		alert("Select Folder First");
	}
	else
	{

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	document.getElementById("advsearch").style.display="block"; 
      document.getElementById("advsearch").innerHTML=xmlhttp.responseText;
      document.getElementById("advsearch").style.border="";
    }
  }

  xmlhttp.open("GET","drawing_search.php?albumid="+albumid+"&last_subalbum="+last_subalbum+"&dwg_type="+dwg_type+"&dwg_no="+dwg_no+"&dwg_title="+dwg_title+"&dwg_date="+dwg_date+"&revision_no="+revision_no+"&dwg_status="+dwg_status,true);
  xmlhttp.send();
}
 }
//}
</script>

<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
</head>
<body>
<!--<div id="wrap">
  <?php //include 'includes/header.php'; ?>
<div id="content">-->
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
          <!-- Page Data Goes Here -->
  <div class="row">
 <div class="col-sm-4">
              <div  style="background-image: linear-gradient(180deg, #c9c9f5, white);  border-radius: 15px; margin-right: -5px; ">
                <div class="card-body ">
				<div id="advsearch" style="" ></div>
                  <h4 class="card-title text-center pt-1 pb-3" style="  color: #1a1a7d;font-size: 100%;font-weight: 900;">Search Drawings </h4>
                  
                  <form name="searchfrm" id="searchfrm" action="reports_search.php"  method="post"  class="forms-sample pb-4" onSubmit="return required()">
                 
                    <div class="form-group row" style="margin-bottom:0.2rem">
                      <label for="exampleInputUsername2" class="col-sm-4 col-form-label" style="font-weight: bold" ><?php echo FOLDER;?></label>
                      <div class="col-sm-8">
                      <select  name="album_id" id="album_id" onChange="getsubcat(this.value)"  class="form-control bg-light text-dark" style="font-size:0.8rem" >
  						<option value=0  ><?php echo SEL_FOL.".."; ?> </option>
						 <?php
                        $cquery = "select * from  t031project_drawingalbums WHERE parent_id = 0";
                             $ObjMapDrawing->dbQuery($cquery);
                                while($cdata =$ObjMapDrawing->dbFetchArray()) {
							if($_SESSION['ne_user_type']==1)
							{
							  ?>
                              
 <option value="<?php echo $cdata['albumid']; ?>" <?php if ($cat_idm == $cdata['albumid']) {echo ' selected="selected"';} ?>><?php echo $cdata['album_name']; ?></option>
   <?php }
   else
   {
	   
	   
			$u_rightr=$cdata['user_right'];			
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			$arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
						
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}
							
								  ?>
                                   <option value="<?php echo $cdata['albumid']; ?>" <?php if ($cat_idm == $cdata['albumid']) {echo ' selected="selected"';} ?>><?php echo $cdata['album_name']; ?></option>
                                  <?php
								  
						}
				}
							
   
   }
                ?>  
                     
                        <?php
                        }
                        ?>
					</select>
                      </div>
                    </div>
                    
                    <div class="form-group row" style="margin-bottom:0.2rem">
                   
			<?php
$cquery = "select albumid from  t031project_drawingalbums";
		
		 $ObjMapDrawing2->dbQuery($cquery);
 				while($cdata =$ObjMapDrawing2->dbFetchArray()){	
		$cat_id2=$cdata['albumid'];	
		?>
<div id="<?php echo "subcatdiv_".$cdata['albumid']?>" style="display:block" >
		</div>
<?php
}

?>
 <input type="hidden" name="subcatidm" id="subcatidm" value=""/>         
                    </div>
                    <div class="form-group row" style="margin-bottom:0.2rem">
                      <label for="exampleInputPassword2" class="col-sm-4 col-form-label" style="font-weight: bold">Type</label>
                      <div class="col-sm-8">
                      <select  name="dwg_type" id="dwg_type"  class="form-control bg-light text-dark" style="font-size:0.8rem"0>
 
  		
  		<option value="Design" <?php echo "selected";?>>Design</option>
		 <option value="Survey" <?php echo "selected";?>>Survey</option>
  		<option value="Others" <?php echo "selected";?>>Others</option>
        <option value="All" <?php  echo "selected";?>>All</option>
		
</select>
                      </div>
                    </div>
                    <div class="form-group row" style="margin-bottom:0.1rem">
                      <label for="exampleInputConfirmPassword2" class="col-sm-4 col-form-label" style="font-weight: bold"><?php echo DRW_NO;?></label>
                      <div class="col-sm-8">
                      <input type="text" name="dwg_no" id="dwg_no"  value="<?php echo $dwg_no;?>"   class="form-control"  placeholder="<?php echo DRW_NO;?>" style="font-size:0.8rem"/>
                       
                      </div>
                    </div>

                    <div class="form-group row" style="margin-bottom:0.2rem">
                      <label for="exampleInputEmail2" class="col-sm-4 col-form-label" style="font-weight: bold"><?php echo DRW_TITLE?></label>
                      <div class="col-sm-8">
                       <input type="text" name="dwg_title" id="dwg_title"  value="<?php echo $dwg_title;?>"   class="form-control"  placeholder="<?php echo DRW_TITLE;?>" style="font-size:0.8rem"/>
                       
                      </div>
                    </div>
                    <div class="form-group row" style="margin-bottom:0.2rem">
                      <label for="exampleInputEmail2" class="col-sm-4 col-form-label" style="font-weight: bold"><?php echo DRW_DATE?></label>
                      <div class="col-sm-8">
                       <input type="text" name="dwg_date"  id="dwg_date" value="<?php echo $dwg_date;?>"   class="form-control"  placeholder="<?php echo DRW_DATE;?>" style="font-size:0.8rem"/>
                       
                      </div>
                    </div>
                    <div class="form-group row" style="margin-bottom:0.2rem">
                      <label for="exampleInputEmail2" class="col-sm-4 col-form-label" style="font-weight: bold"><?php echo REV_NO?></label>
                      <div class="col-sm-8">
                       <input type="text" name="revision_no" id="revision_no" value="<?php echo $revision_no;?>"   class="form-control"  placeholder="<?php echo REV_NO;?>" style="font-size:0.8rem"/>
                       
                      </div>
                    </div>
                    <div class="form-group row" style="margin-bottom:0.2rem">
                      <label for="exampleInputPassword2" class="col-sm-4 col-form-label" style="font-weight: bold"><?php echo DRW_STA;?></label>
                      <div class="col-sm-8">
                      <select name="dwg_status" class="form-control bg-light text-dark" style="font-size:0.8rem">
        
		 <option value="1" <?php if($dwg_status=='1')echo "selected";?>>Initiated</option>
  		 <option value="2" <?php if($dwg_status=='2')echo "selected";?>>Approved</option>
  		<option value="3" <?php if($dwg_status=='3')echo "selected";?>>Not Approved</option>
  		<option value="4" <?php if($dwg_status=='4')echo "selected";?>>Under Review</option>
 		 <option value="5" <?php if($dwg_status=='5')echo "selected";?>>Response Awaited</option>
		  <option value="7" <?php if($dwg_status=='7')echo "selected";?>>Responded</option>
		</select>
                        
                      </div>
                    </div>
                     <button type="button" class=" button-33 button-35" style=" width:100%;" onClick="advSearch(album_id.value,subcatidm.value,dwg_type.value,dwg_no.value,dwg_title.value,dwg_date.value,revision_no.value,dwg_status.value)" value="<?php echo GO;?>" > View Results </button>
                  </form>
          
                </div>
              </div>
          
 
 </div> 
   
<div class="col-sm-8" >    

<div class="" >
<h4 class="text-center text-34" style="  letter-spacing: 4px"><?php echo strtoupper(MAPS_DRAWINGS);?></h4> 
</div> 

<div class="row pt-2" >
<?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]) &&!empty($parent_id))
{?>

 

  <div align="left" class="mb-2" style="height:30px; vertical-align:top" ><span style="text-align:left;font-family:Verdana, Geneva, sans-serif; font-size:12px"><?php  echo $fold_name;?></span>
 </div>

 <?php 
}?>  
<!--  Album name -->
<div class="col-sm-4 " >
<?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]) &&!empty($parent_id))
{?>

 
<div style="  font-weight: 600;"><?php echo ucwords($album_name); ?> </div>


 <?php 
}?>
 </div>
<!-- End  Album name -->
<div class="col-sm-8 pb-4"><span style=" ">
	<?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]))
	{?>
	<?php  
	if($_SESSION['ne_user_type']==1)
	{
	?>
    
    <button class=" button-33 "    style=""><a href="dm_drawingmap.php" style="text-decoration: none; color: #fff; " ><?php echo "View Main Folders";?></a></button>
	<button class=" button-33 "  href="javascript:void(null);" onClick="window.open('sp_drawingalbum_input.php?parent_id=<?php echo $_REQUEST["album_id"]; ?>', 'Manage Albums ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  ><?php echo MAN_DRW_FOLDER;?></button>
	<button class=" button-33 "  href="javascript:void(null);" onClick="window.open('sp_drawing_album_input.php?album_id=<?php echo $_REQUEST["album_id"]; ?>', 'Manage Albums ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  ><?php echo MAN_DRW;?></button>
	<?php }
	else if($_REQUEST['album_id'])
{
	
$cattid=$_REQUEST['album_id'];
			 $cqueryd = "select * from  t031project_drawingalbums  where albumid='$cattid'";
			 $ObjMapDrawing->dbQuery($cqueryd);
 				$cdatad =$ObjMapDrawing->dbFetchArray();
			$p_cdd=$cdatad['parent_id'];
			$pp_group=$cdatad['parent_group'];
			$arr_pp_group=explode("_",$pp_group);
			$getalbumid=$arr_pp_group[0];
			
			//if($p_cdd==0)
			//{
				
			?>
            
            <?php
			//}
			//else 
			
			 $cqueryd_r = "select user_right,user_ids from  t031project_drawingalbums  where albumid=$getalbumid";
			 $ObjMapDrawing->dbQuery($cqueryd_r);
 				$cdatad_r =$ObjMapDrawing->dbFetchArray();
			$u_right=$cdatad_r['user_right'];
			$arruright= explode(",",$u_right);
			$arr_right_users=count($arruright);		
			 foreach($arruright as $key => $val) 
			 	{
			   $arruright[$key] = trim($val);
			   $aright= explode("_", $arruright[$key]);
			    if($aright[0]==$user_cd)
						{
							if($aright[1]==1)
							{
							$read_right=1;
							?>
     <button class="SubmitButton button-33 "  href="dm_drawingmap.php"  style=""><a href="dm_drawingmap.php" style="text-decoration: none; color: #fff; " ><?php echo "View Main Folders";?></a></button>
	 <button class="SubmitButton button-33 "  href="javascript:void(null);" onClick="window.open('sp_drawingalbum_input.php?parent_id=<?php echo $_REQUEST["album_id"]; ?>', 'Manage Albums ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=""><?php echo MAN_DRW_FOLDER;?></button>
	 <button class="SubmitButton button-33 "  href="javascript:void(null);" onClick="window.open('sp_drawing_album_input.php?album_id=<?php echo $_REQUEST["album_id"]; ?>', 'Manage Albums ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=" "><?php echo MAN_DRW;?></button>

     <?php
							}
							else if($aright[1]==3)
							{
							$read_right=3;
							?>
     <button class="SubmitButton button-33 "  href="dm_drawingmap.php"  style=""><a href="dm_drawingmap.php" style="text-decoration: none; color: #fff; " ><?php echo "View Main Folders";?></a></button>
	 <button class="SubmitButton button-33 "  href="javascript:void(null);" onClick="window.open('sp_drawingalbum_input.php?parent_id=<?php echo $_REQUEST["album_id"]; ?>', 'Manage Albums ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=""><?php echo MAN_DRW_FOLDER;?></button>
	 <button class="SubmitButton button-33 "  href="javascript:void(null);" onClick="window.open('sp_drawing_album_input.php?album_id=<?php echo $_REQUEST["album_id"]; ?>', 'Manage Albums ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=" "><?php echo MAN_DRW;?></button>
    
     
     <?php
							}
							else if($aright[1]==2)
							{
							$read_right=2;
							?>
                             <button class="SubmitButton button-33 "  href="dm_drawingmap.php"  style=""><a href="dm_drawingmap.php" style="text-decoration: none; color: #fff; " ><?php echo "View Main Folders";?></a></button>
                            <?php
							
							
							}
					     }
				}
			
			
}
	
}
	?>
	
	</span>
</div>

</div>

<div class="table-responsive">  <!--   %%%% -->
   <div class="">    <!--   wwww -->              


  <!-- <tr ><td align="center"> -->
  <?php echo $message; ?>
<?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]) &&!empty($parent_id))
{
	?>
<div style=" height:auto; "  >


  <!--@@ -->
	<tr>
	<td align="center" valign="top">
	<?php 
		 $cm=0;
			 $pdSQL = "SELECT albumid, parent_id, parent_group,pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and parent_id=".$parent_id." order by albumid";
			 $ObjMapDrawing->dbQuery($pdSQL);
 				
			// $pdSQLResult = mysql_query($pdSQL);
			//echo $ObjMapDrawing-> totalRecords();
			if($ObjMapDrawing-> totalRecords()>= 1){
		
			?>
	 <div style="vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px;" >
	
    <table width="96%" style="margin:0px; border:0px; padding:0px">
			<tbody>
             
            <tr>
			<td width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
                            <?php  
			
		while($result =$ObjMapDrawing->dbFetchArray()){
				
				$album_id=$result['albumid'];
				 $result['album_name'];
				
				$p_group=$result['parent_group'];
				$arr_gp=explode("_", $p_group);
				$get_album_id=$arr_gp[0];
				 $pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_id;
			// $pdSQLResult_get_right = mysql_query($pdSQL_get_right);
			$ObjMapDrawing3->dbQuery($pdSQL_get_right);
			$result_get_right =$ObjMapDrawing3->dbFetchArray();
			 //$result_get_right = mysql_fetch_array($pdSQLResult_get_right);
				
				 $pdSQL_r = "SELECT dwgid, pid, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
			 //$pdSQLResult_r = mysql_query($pdSQL_r);
			 $ObjMapDrawing2->dbQuery($pdSQL_r);
			if($ObjMapDrawing2-> totalRecords()>= 1)
			//if(mysql_num_rows($pdSQLResult_r) >= 1)
			{
			
				//$result_r = mysql_fetch_array($pdSQLResult_r);
				$result_r =$ObjMapDrawing2->dbFetchArray();
				$al_file_r=$result_r['al_file'];
			}
			else
			{
			$al_file_r="no_image.png";
			}
			if($_SESSION['ne_user_type']==1)
			{
				
				?>
				
            <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
 <!--    <a  href="javascript:void(null);" onclick="window.open('sp_photo.php?album_id=<?php echo $result['albumid'];?>', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none" >-->
	    <a  href="dm_drawingmap.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery" style="padding-top:35px">	
	<img width="90" height="90" border="0" align="bottom" alt="" src="../../../images/Drawing-icon.png">
	</div>
	</a>
	<div align="center" class="imageTitle" style="margin-top:15px; font-weight:bold">
	<?php echo $result['album_name']; ?>				     </div>
	</div>
	</li>
	</div>


            <?php 
			
			$cm++;
			}
			else
			{
				
			
				 $u_rightr=$result_get_right['user_right'];
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			   $arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}

				?>
			<div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
	<a  href="dm_drawingmap.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery" style="padding-top:35px">	
	<img width="80" height="80" border="0" align="top" alt="" src="../../../images/Drawing-icon.png"; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?> </div>
	</div>
	</li>
	</div>
    <?php
			
			$cm++;}
				}
				
			}
			
			}?>
        </td>
		</tr>
		</tbody>
		</table>
		</div>
		<?Php
		}
		?>
		</td>
	</tr>  

  <!-- <tr>
  <td align="right" valign="top"> -->
 <form name="filter_1" id="filter_1" method="post" action="?album_id=<?php echo $_GET['album_id']?>" align="right"> 
<select  name="dwg_type" id="dwg_type" class="" style="">
 
  		<option value="All" <?php if(!isset($_GET['dwg_type']))echo "selected";?>>All Files</option>
        <option value="Design" <?php if($_GET['dwg_type']=='Design') echo "selected";?>>Design</option>
		 <option value="Survey" <?php if($_GET['dwg_type']=='Survey') echo "selected";?>>Survey</option>
  		<option value="Others" <?php if($_GET['dwg_type']=='Others') echo "selected";?>>Others</option>
		
</select>
		
		<button type="submit" form="filter_1" name="go_submit" id="go_submit" value="GO" class="button-33 " style="padding-top: 2px; padding-bottom: 3px; border-radius: 0; margin-right:1%;"> Go </button></form>
   <!-- start resposive table *** -->
 <div class="table-responsive">      
  <table class="table table-hover ">
                              <thead>
                                <tr class="" style="font-size:12px; color:#CCC; background-color: #151563; ">
                                 
                                   <th >#</th>
                                  <th >Drawing No</th>
								  <th >Title</th>
                                  <th >Type</th>
								  <th >Date</th>
								   <th ><?php echo REV_NO;?></th>
								  <th >Status</th>
                                  <th >File</th>
								
								 
								  <th colspan="2" class="text-center"><?php echo ACTION;?></th>
								
                                </tr>
                              </thead>
                              <tbody>

							  <?php
							  if(isset($_GET['dwg_type']))
							  {
								  $type_d=$_GET['dwg_type'];
								  
								  $pdSQL = "SELECT dwgid, pid,album_id, dwg_type,dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and dwg_type='$type_d' and album_id=".$parent_id." order by dwgid";
							  }
							  else
							  {
								   $pdSQL = "SELECT dwgid, pid,album_id, dwg_type,dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$parent_id." order by dwgid";
}
						 
						
						$ObjMapDrawing->dbQuery($pdSQL);
						$i=0;
							  if($ObjMapDrawing-> totalRecords()>= 1)
							
							  {
							while($pdData =$ObjMapDrawing->dbFetchArray())
							  { 
							  $i++;
							  ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td ><?php echo $pdData['dwg_no'];?></td>
						  <td ><?php echo $pdData['dwg_title'];?></td>
                          <td ><?php echo $pdData['dwg_type'];?></td>
						  <td ><?php echo $pdData['dwg_date'];?></td>
						  <td ><?php echo $pdData['revision_no'];?></td>
						  <td >
					<?php
			 		if($pdData['dwg_status']=='1')
					{
					echo "Initiated";
					} 
					else if($pdData['dwg_status']=='2')
					{
					echo "Approved";
					}
					else if($pdData['dwg_status']=='3')
					{
					echo  "Not Approved";
					}
					else if($pdData['dwg_status']=='4')
					{
					echo "Under Review";
					}
					else if($pdData['dwg_status']=='5')
					{
					echo "Response Awaited";
					}
					else if($pdData['dwg_status']=='7')
					{
					echo "Responded";
					}?>
					</td>	  
						  <td align="left"><a href="<?php echo $data_url.$pdData["al_file"];?>" target="_blank"><img src="../../../images/pdf.png"  width="50" title="<?php echo $pdData["al_file"];?>"/></a></td>
						  
						   <?php if($_SESSION['ne_user_type']==1)
			{
								   ?>
						   <td align="center">
						   <span style=" vertical-align:middle;  text-align:center; ">
						   <button  title="Edit" href="javascript:void(null);" class="btn btn-outline-warning btn-fw px-1 py-1 " 
						   onClick="window.open('sp_drawing_album_input.php?dwgid=<?php echo $pdData['dwgid']; ?>&album_id=<?php echo $pdData['album_id']; ?>', 'Manage drawings ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=" font-size: 100%;">
						   <i class="ti-pencil btn-icon-prepend" style="font-size: 15px;"></i>  </button>
						   </span>
						   </td>
						   <td align="center">
						   <span style=" ">
						   <a  class="btn btn-outline-danger btn-fw px-1  py-1 " href="dm_drawingmap.php?dwgid=<?php echo $pdData['dwgid'] ?>&album_id=<?php echo $pdData['album_id']; ?>&act=delete"  onClick="return confirm('Are you sure, you want to delete this Drawing Record?')"><i class="ti-trash btn-icon-prepend" style="font-size: 15px;" ></i> </a>
						   
						   </span>
						   </td>
						   <?php  
							}
							else
							{
								
				
				
				$u_rightr=$result_get_rightd['user_right'];
			
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			$arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
						
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}
                       
						 if($read_right==1 || $read_right==3)
								  {
								   ?>
						 <td align="right">
						   <span style="float:left; vertical-align:middle;  text-align:center; margin-top:15px; margin-left:15px">
						   <button class="SubmitButton btn btn-outline-warning btn-fw px-1 py-1" title="Edit" href="javascript:void(null);" onClick="window.open('sp_drawing_album_input.php?dwgid=<?php echo $pdData['dwgid']; ?>&album_id=<?php echo $pdData['album_id']; ?>', 'Manage drawings ','width=870px,height=800px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=" font-size: 100%;">
						   <i class="ti-pencil btn-icon-prepend" style="font-size: 15px;"></i> </button>
						   
						  
						</span>
						   
						   </td>
                           
						   <?php  
							}
							else
							{
								?>
                                <td></td>
                                <?php
							}
							if($read_right==3)
								  {
								   ?>
						  <td align="right">
						   <span style="float:right; margin-top:15px; margin-right:10px">
						   <a  class="btn btn-outline-danger btn-fw px-1  py-1 " href="dm_drawingmap.php?dwgid=<?php echo $pdData['dwgid'] ?>&album_id=<?php echo $pdData['album_id']; ?>&act=delete"  onClick="return confirm('Are you sure, you want to delete this Drawing Record?')"><i class="ti-trash btn-icon-prepend" style="font-size: 15px;" ></i> </a>
						 
						   </span>
						   </td>
						   <?php
						   }
						}
				}
			
							}
						   ?>
                       
						
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="9" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
   
   </div>
      <!-- End resposive tbl *** -->
   

  <!-- </td></tr> -->
  
  </div>
  <div style="clear:both; margin-top:10px"></div>
  
<?php }
else
{
	?>
	
<!-- <div style="border:1px solid #ccc; border-radius:6px;  vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 30px 5px; "> -->
 

<div style=" vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; ">
 
   <table width="100%" style="margin:0px; border:0px; padding:0px">
			<tbody><tr>
			<td width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
                            <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT albumid,  parent_id,pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and parent_id=".$parent_id." order by albumid";
			$ObjMapDrawing->dbQuery($pdSQL);
			 if($ObjMapDrawing-> totalRecords()>= 1)
			{
			while($result =$ObjMapDrawing->dbFetchArray())
				{
				$album_id=$result['albumid'];
				  $pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and albumid=".$album_id;
			// $pdSQLResult_get_right = mysql_query($pdSQL_get_right);
			$ObjMapDrawing3->dbQuery($pdSQL_get_right);
			$result_get_right =$ObjMapDrawing3->dbFetchArray();
				$pdSQL_r = "SELECT dwgid, pid, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
				
				$ObjMapDrawing2->dbQuery($pdSQL_r);
			 if($ObjMapDrawing2-> totalRecords()>= 1)
			{
			$result_r =$ObjMapDrawing2->dbFetchArray();
			
				$al_file_r=$result_r['al_file'];
			}
			else
			{
			$al_file_r="no_image.jpg";
			}
				
				?>
			<?php
			if($_SESSION['ne_user_type']==1)
			{
				
				?>
				
            <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
 <!--    <a  href="javascript:void(null);" onclick="window.open('sp_photo.php?album_id=<?php echo $result['albumid'];?>', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none" >-->
	    <a  href="dm_drawingmap.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery" style="padding-top:35px">	
	<img width="90" height="90" border="0" align="bottom" alt="" src="../../../images/Drawing-icon.png">
	</div>
	</a>
	<div align="center" class="imageTitle" style="margin-top:15px; font-weight:bold">
	<?php echo $result['album_name']; ?>				     </div>
	</div>
	</li>
	</div>


            <?php 
			
			$cm++;
			}
			else
			{
				
			
				 $u_rightr=$result_get_right['user_right'];
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			   $arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}

				?>
			<div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
	<a  href="dm_drawingmap.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery" style="padding-top:35px">	
	<img width="80" height="80" border="0" align="top" alt="" src="../../../images/Drawing-icon.png"; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?> </div>
	</div>
	</li>
	</div>
    <?php
			
			$cm++;}
				}
				
			}
			?>	
            

            <?php 
			$cm++;
			
			}}?>
        </td>
		</tr>
		</tbody>
		</table>
		</div>
		
	<?php 
	}?>

  <!-- </td></tr> -->
  
</div>   <!--  www -->
  </div>   <!--   %%%% -->
  </div>    


   </div><!-- class="row" -->

              <!-- Page Data Goes Here -->
        <div id="partials-footer"></div>
        <!-- partial -->

         </div>     <!--content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
    </div>
    </div>
<!--</div>
 
</div>-->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../../../js/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
  <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


  <!-- End custom js for this page-->

  <script>
    $(function(){
      $("#partials-navbar").load("../../../partials/_navbar.php");
    });
</script>

<script>
  $(function(){
    $("#partials-theme-setting-wrapper").load("../../../partials/_settings-panel.php");
  });
</script>

<script>
  $(function(){
    $("#partials-sidebar-offcanvas").load("../../../partials/_sidebar.php");
  });
</script>

<script>
$(function(){
  $("#partials-footer").load("../../../partials/_footer.php");
});
</script>
</body>
</html>
<?php
	//$objDb  -> close( );
?>
