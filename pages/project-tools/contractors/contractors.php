<?php
include_once("../../../config/config.php");
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$objAdminUser 	= new AdminUser();
$user_cd=$_SESSION['ne_user_cd'];
$_SESSION['ne_user_type'];

include ("db_connect.php");?>
<?php
		
$user_cd=1;
 $user_type=1;


//$report_path = REPORT_PATH;

$category_cd = $_REQUEST['category_cd'];
$subcategory_cd = $_REQUEST['subcategory_cd'];
$cid = $_REQUEST['cid'];



if(isset($_GET['cat_cd']))
	{
	 $cat_cd=$_GET['cat_cd'];
	}
	if(isset($_REQUEST['sort']))
	{
	 
	 if($_REQUEST['sort']=="asc")
	 {
	 $sort="asc";
	 $order="desc";
	 }
	 else if($_REQUEST['sort']=="desc")
	 {
	 $sort="desc";
	 $order="asc";
	 }
	 
	}
	else
	{
	$order="asc";
	}
	
	




?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Contractors</title>
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

table.issues
{
font-family:'Soleto', sans-serif; 
line-height:15px;border-radius: 4px; 
font-size:12px;
/*border:1px solid #d4d4d4;*/
width:100%;
background-color: #EDEDED;
	border: 1px double #505050;
	padding: 3px 6px;
	outline: none;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-moz-box-shadow: -1px 1px 0px #fff;
	-webkit-box-shadow: -1px 1px 0px #fff;
	box-shadow: -1px 1px 0px #fff;
	moz-transition: all 0.3s ease-out;
	-o-transition: all 0.3s ease-out;
	-webkit-transition: all 0.3s ease-out;	
	border-image: initial;

}
table.issues tr:nth-child(odd)	{background-color:#ffffff;}
table.issues tr:nth-child(even){background-color:#ffffff;}

table.issues tr.fixzebra	{background-color:#f1f1f1;}

table.issues th{
	color:#ffffff;background-color:#555555;border:1px solid #555555;padding:12px;vertical-align:top;text-align:left;
}
table.issues td{
	
	padding:7px;
	vertical-align:center;
	border:1; border-color:#505050; background-color:#FFF;
	text-align:left;
	font-family: 'Soleto', sans-serif;
}
table.issues td a{
	font-family: 'Soleto', sans-serif;
	text-decoration:none;
	color:#000;
	font-size:12px;
	line-height:15px;
}
table.issues td.detail
{

font-size:22px; padding-top:15px; padding-bottom:15px;

}
table.issues_info
{
padding:0px;
border:1px solid #d4d4d4;
border-collapse:collapse;width:100%;

}
table.issues_info tr:nth-child(odd)	{background-color:#ffffff;}
table.issues_info tr:nth-child(even){background-color:#ffffff;}

table.issues_info tr.fixzebra	{background-color:#f1f1f1;}

table.issues_info th{
	color:#ffffff;background-color:#555555;border:1px solid #555555;padding:9px;vertical-align:top;text-align:left;
}

table.issues_info th a:link,table.reference th a:visited{
	color:#000000;
	border:1px solid #d4d4d4;
	
	padding:6px;
	margin:6px;
	width:120px;
}
table.issues_info th a:hover,table.reference th a:active{
	color:#EE872A;
	border:1px solid #d4d4d4;
	padding:6px;
	margin:6px;
	width:120px;
}

table.issues_info td{
	border:1px solid #d4d4d4;padding:5px;padding-top
	
	:7px;padding-bottom:7px;vertical-align:top;
}

table.issues_info td.example_code
{
vertical-align:bottom;
}
 
    </style>

<script>
function doFilter(frm){
	var qString = '';
	if(frm.comp_id.value != ""){
		qString += 'comp_id=' + escape(frm.comp_id.value);
	}
	if(frm.contract_id.value != ""){
		qString += '&contract_id=' + escape(frm.contract_id.value);
	}
	
	document.location = 'drawing_reg.php?' + qString;
}

</script>



  

<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
</head>
<body>
<!--<div id="wrap">
  <?php //include 'includes/header.php'; ?>
<div id="content">-->
<div class="container-scroller">
     <!-- partial:partials/_navbar.html --><div id="partials-navbar"></div> <!-- partial -->
     <div class=" page-body-wrapper" id="pagebodywraper">
       <!-- partial:partials/_sidebar.html --> <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div><!-- partial -->

      <div class="main-panel " id="mainpanel">
      <div class="content-wrapper" style="">
           <h4 class="text-center text-34" style="  letter-spacing: 4px"> Contractors</h4> 

		   <!-- <div class="row pt-4 pb-4" >
					<div class="col-sm-2 " style="  font-weight: 600;">  </div>
					<div class="col-sm-10 text-end" >  
					<?php if($pid != ""&&$pid!=0){?>

				<button type="button" class="col-sm-2 button-33" onclick="window.open('project_nonconfirmity_input.php', 'newwindow', 'left=600,top=60,width=1000,height=800');return false;"> <?php echo ADD_NEW_REC;?> </button>
     			<?php } 

				?>
					</div>
		  </div> -->


      <div id="content">


<?php      $sqlss="select parent_group, category_status from rs_tbl_category where category_cd='$category_cd'";
	$sqlrwss=$con->query($sqlss);
	$sqlrw1ss=$sqlrwss->fetch();
	$par_groups=$sqlrw1ss['parent_group'];
	$category_status=$sqlrw1ss['category_status'];
	$par_arr=explode("_",$par_groups);
	$lenns=count($par_arr);
	$category_name="";
	for($i=0;$i<$lenns;$i++)
	{
	 $sqlCN="select category_name,parent_cd,cid from rs_tbl_category where category_cd='$par_arr[$i]' ";
		
	$sqlrCN=$con->query($sqlCN);
	$sqlCNrw=$sqlrCN->fetch();
	if($sqlCNrw["category_name"]=="P - Contractors")
	{
		$contractors="Contractors";
	}
	else{
		$contractors=$sqlCNrw["category_name"];
	}
	$category_name .='<a  style="font-size:14px;" href="?p=reports&cid='.$sqlCNrw["cid"].'&cat_cd='.$sqlCNrw["parent_cd"].'&category_cd='.$par_arr[$i].'">'.$contractors.'</a>';
	
	$category_name .="&nbsp;&raquo;&nbsp;";
	
	//$category_name .=$category_name;
	}
	?>
	
    <?php
   $report_category=$category_name;
	$sql="Select * from rs_tbl_category where category_cd=".$category_cd;
			$res=$con->query($sql);
			$row3=$res->fetch();
			
				//$report_category=$row3['category_name'];
				$parent_cd=$row3['parent_cd'];
				
			?>
         
		
	
    <?php //echo $objCommon->displayMessage();?>
	<div id="tableContainer"  >
	
    
  
    <div align="left" style=" margin-bottom:20px; margin-left:10px; font-weight:bold" ><?php echo $report_category;?></div>
    <table class="issues" align="center" border="0"  style="margin-left:10px; width:98%">




	
	<?php
	
			  
	$sql2="Select * from rs_tbl_category where parent_cd=".$category_cd;
			$res2=$con->query($sql2);
		$total_num=$res2->rowCount();
			if($total_num>=1)
			{
			?>
			<tr style="background-color:#151563">
<td height="99" colspan="5"   style="line-height:18px;"  >

<span style="font-size:16px; font-weight:bold">Folders</span>
<table class="issues"  border="1px"  align="left" cellspacing="0" style="margin-top:5px; margin-bottom:20px" >

<tr >

<th style="color:#fff" width="2%">S#</th>
<?php
 $temp2="select * from rs_tbl_category_template where cat_id='$category_cd' order by cat_temp_order asc";
$res_temp2=$con->query($temp2);
$res_temp2=$res_temp2->fetch();
 $res_temp2['cat_title_text'];
?>
<th style="color:#fff" width="40%"><?php echo $res_temp2['cat_title_text'] ?></th>
<!--<td style="color:#000066" width="25%">Created By</td>
<td style="color:#000066" width="25%">Last Modified By</td>
<td style="color:#000066" colspan="2">Actions</td>-->
<?php

?>

 </tr>
 <?php
 $y=1;
 while($row2=$res2->fetch())
			 {
				$report_subcategory=$row2['category_name'];
				$category_cd."<br/>";
				$subcategory_id=$row2['category_cd'];
			$sub_folder="Select * from rs_tbl_category where parent_cd=".$subcategory_id;
			$sub_folders=$con->query($sub_folder);
		    $total_subfolder=$sub_folders->rowCount();
		    $files="Select * from rs_tbl_documents where report_category=".$subcategory_id;
			$files1=$con->query($files);
		    $total_files=$files1->rowCount();
				
				?>
				<tr>
<td style="color:#000066"><?php echo $y;?></td>
<td style="color:#000066"><img  src="images/folder1.png"/>&nbsp;<a href="?p=reports&category_cd=<?php echo $subcategory_id; ?>&cat_cd=<?php echo $category_cd; ?>&cid=<?php echo $cid; ?>"><?php echo $report_subcategory?></a></td>
<?php /*?><td><?php echo $row2['creater'];?><br /><font size="-5"><?php echo "folders: ".$total_subfolder."&nbsp;&nbsp; Files: ".$total_files; ?></font></td>
<td><?php echo $row2['last_modified_by'];?></td>
<td style="color:#000066" align="right"><a href="javascript:void(null);" onclick="window.open('category.php?category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $cid;?>', 'INV','width=850,height=700,scrollbars=yes');" >
<img src="./images/edit.gif" border="0" /></a></td>
<td style="color:#000066" align="right">&nbsp;<a href="?p=reports&sel_category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd'])
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd']; ?>&mode=cat_delete"  onclick="return confirm('Are you sure, You want to delete category?')"><img  src="./images/delete.gif"/></a></td><?php */?>

 </tr>
				<?php
				$y++;
				
				
				
			}
 ?>
</table>

</td>
</tr>
			<?php
			}
			
				
	?>
	
<tr>	

<td  colspan="5"  style="line-height:18px; text-align:justify">
<form name="reports_cat" id="reports_cat" method="post" action="" onSubmit="return atleast_onecheckbox(event)"> </form>
<span style=" font-size:16px; font-weight:bold">Files</span>
<?php if($category_status==1){ ?>
<span style="font-size:16px; font-weight:bold; float:right">
<?php if(isset($_GET['cat_cd']))
{
$cat_cd1="&cat_cd=".$_GET['cat_cd'];
} ?>

</span>
<?php
}
?>


<table class="issues" align="right" cellspacing="0" border="1px" style="margin-top:5px; margin-bottom:20px; "  >

<tr style="background:#151563">
<th style="color:#fff" width="2%">S#</th>
<!--<td style="color:#000066" width="2%"><input  type="checkbox" name="chkAll" id=
          "chkAll" value="1" form="reports_cat" onclick="selectAllUnSelectAll(this,'file_download[]',reports_cat);"/></td>-->

<?php
$templ="select * from rs_tbl_category_template where cat_id='$category_cd'  and cat_field_name='report_title' order by cat_temp_order asc";
$res_temp=$con->query($templ);
$total=$res_temp->rowCount();
while($res_temp1=$res_temp->fetch())
{
//echo $cat_field_namee $res_temp1['cat_field_name'];
?>
<?php if(isset($_GET['status']))
{
$stats="&status=".$_GET['status'];
} ?>
<th style="color:#fff"><?php echo $res_temp1['cat_title_text'] ?> 
 <a href="?p=reports&category_cd=<?php echo $category_cd; ?>&<?php if($cat_cd=="")
{
}
else
{ ?>cat_cd=<?php echo $cat_cd;}?>&cid=<?php echo $cid;?><?php echo $stats; ?>&field=<?php echo $res_temp1['cat_field_name'];?>&sort=<?php echo $order;?>"><?php if($order=="asc"){?><img src="images/asc.png" title="Ascending" alt="Ascending"/><?php }else{?> <img src="images/desc.png" title="Descending" alt="Descending"/><?php } ?> </a></th>

<?php
}

?>
<th style="color:#fff" width="10%">Uploaded Date</th>
<!--<td style="color:#000066" width="15%">Created By</td>
<td style="color:#000066" width="15%">Last Modified By</td>-->
<?php if($category_status==1){ ?>
<th style="color:#fff" width="20%">Status</th>
<?php
}
?>
<!--<td width="2%" colspan="2">Action </td>-->
 </tr>
 
 <?php
	//$objProduct->resetProperty();
	//$objProduct->setProperty("limit", PERPAGE);
	//$objProduct->setProperty("report_status", "1");
	$limit=100;
	if(isset($_GET['cat_cd']))
	{
	 $cat_cd=$_GET['cat_cd'];
	 
	 $sqls="select parent_group from rs_tbl_category where category_cd='$category_cd' and parent_cd='$cat_cd'";
	$sqlrws=$con->query($sqls);
	$sqlrw1s=$sqlrws->fetch();
	$par_group=$sqlrw1s['parent_group'];
	$par_arr=explode("_",$par_group);
	$lenns=count($par_arr);
	$cat_cds=$par_arr[0];
	$str_ids1="";
	for($i=1;$i<$lenns;$i++)
	{
	if($i==($lenns-1))
	{
	$str_ids=$par_arr[$i];
	}
	else
	{
	$str_ids=$par_arr[$i]."_";
	}
	$str_ids1=$str_ids1.$str_ids;
	
	}
	//echo $str_ids1;
	$report_category=$_REQUEST["category_cd"];
	//$objProduct->setProperty("report_category", $_REQUEST["category_cd"]);
	if(isset($_REQUEST["status"]))
	{
		$report_status=$_REQUEST["status"];
	//$objProduct->setProperty("report_status", $_REQUEST["status"]);
	}
	//$objProduct->setProperty("report_subcategory", $cat_cds);
	if(isset($sort) && isset($_REQUEST['field']))
	{
	$column_name=$_REQUEST['field'];
	//$objProduct->setProperty("column_name", $column_name);
	//$objProduct->setProperty("sort", $sort);
	//$objProduct->lstReportSort();
	
	 $Sql = "SELECT 
						report_id,
						report_category,
						report_subcategory,
						report_title,
						report_file,						
						doc_issue_date,
						report_status,
						period,
						doc_upload_date,
						revision,
						doc_closing_date,
						document_no,
						reference_no,
						received_date,
						file_from,
						file_to,
						file_no,
						drawing_series,
						file_category,
						remarks,
						uploading_file_date,
						doc_creater,
						doc_creater_id,
						doc_last_modified_by
				FROM
					rs_tbl_documents
				WHERE 1=1 and report_category='$report_category' and report_status='$report_status' order by $column_name $sort";
	}
	else
	{
	 $Sql = "SELECT 
						report_id,
						report_category,
						report_subcategory,
						report_title,
						report_file,						
						doc_issue_date,
						report_status,
						period,
						doc_upload_date,
						revision,
						doc_closing_date,
						document_no,
						reference_no,
						rep_reference_no,
						received_date,
						file_from,
						file_to,
						file_no,
						drawing_series,
						file_category,
						remarks,
						uploading_file_date,
						doc_creater,
						doc_creater_id,
						doc_last_modified_by
				FROM
					rs_tbl_documents
				WHERE 
					1=1 and report_category='$report_category'  and report_status='$report_status'";
	//$objProduct->lstReport();
	}
	//echo $objProduct->getSQL();
	}
	else
	{
	$report_subcategory12='is NULL';
	$report_category=$category_cd;
	$report_subcategory=$report_subcategory12;
	
	//$objProduct->setProperty("report_category", $category_cd);
	//$objProduct->setProperty("report_subcategory", $report_subcategory12);
	if(isset($_REQUEST["status"]))
	{
		$report_status=$_REQUEST["status"];
	//$objProduct->setProperty("report_status", $_REQUEST["status"]);
	}
	if(isset($sort) && isset($_REQUEST['field']))
	{
	$column_name=$_REQUEST['field'];
	//$objProduct->setProperty("column_name", $column_name);
//$objProduct->setProperty("sort", $sort);
	//$objProduct->lstReportsub_nullSort();
 $Sql = "SELECT 
						report_id,
						report_category,
						report_subcategory,
						report_title,
						report_file,						
						doc_issue_date,
						report_status,
						period,
						doc_upload_date,
						revision,
						doc_closing_date,
						document_no,
						reference_no,
						received_date,
						file_from,
						file_to,
						file_no,
						drawing_series,
						file_category,
						remarks,
						uploading_file_date,
						doc_creater,
						doc_creater_id,
						doc_last_modified_by
				FROM
					rs_tbl_documents
				WHERE 
					1=1 and (report_subcategory is null OR report_subcategory='') and  report_category='$report_category'  order by $column_name $sort";
	}
	else
	{
	//$objProduct->lstReportsub_null();
	  $Sql = "SELECT 
						report_id,
						report_category,
						report_subcategory,
						report_title,
						report_file,						
						doc_issue_date,
						report_status,
						period,
						doc_upload_date,
						revision,
						doc_closing_date,
						document_no,
						reference_no,
						received_date,
						file_from,
						file_to,
						file_no,
						drawing_series,
						file_category,
						remarks,
						uploading_file_date,
						doc_creater,
						doc_creater_id,
						doc_last_modified_by
				FROM
					rs_tbl_documents
				WHERE 
					1=1 and (report_subcategory is null OR report_subcategory='') and  report_category='$report_category'  order by report_id ASC";
	}
	}
	
	$i=0;
	$isno=0;
	$qSql = $con->query($Sql);
	$totalRecords=$qSql->rowCount();
	//$objProduct->totalRecords();
	
	if($totalRecords >= 1){
		while($rows = $qSql->fetch()){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			$i++;
			
			?>
			<tr>

<td><?php $isno=$isno+1; echo  $isno;?></td>
<!--<td><input type="checkbox"    name="file_download[]"  value="<?php echo $rows['report_id'];?>" form="reports_cat" /></td>-->
<?php
$temp5="select * from rs_tbl_category_template where cat_id='$category_cd' and cat_field_name='report_title' order by cat_temp_order asc";
$res_temp5=$con->query($temp5);
$total=$res_temp5->rowCount();
while($ress_temp5=$res_temp5->fetch())
{
 $cat_field_namee =$ress_temp5['cat_field_name'];
?>
<td>

				<?php
				if ($cat_field_namee=="report_title")
				{
					if($rows['report_file']!="")
					{
					?>
					<a href="<?php echo $report_url.$rows['report_file'] ;?>" target="_blank"><?php echo $rows['report_title'];?></a>
					<?php
					}
					else
					{
					echo $rows['report_title'];
					}
				}
				
				else if($cat_field_namee=="doc_upload_date")
				{
					
					if($rows['doc_upload_date']=="" || $rows['doc_upload_date']==NULL || $rows['doc_upload_date']=="0000-00-00" || $rows['doc_upload_date']=="1970-01-01")
					{
					echo "";
					}
					else
					{
					echo date('d F Y',strtotime($rows['doc_upload_date']));
					}
				}
				
				/*else if($cat_field_namee=="report_status")
				{
					if($rows['report_status']==1)
					{
					echo "Active";
					}
					else if($rows['report_status']==2)
					{
					echo "Inactive";
					}
				}*/
				else
				{
				echo $rows[$cat_field_namee];
				}
				 
				 ?></td>
<?php }?>
<td style="color:#000066" ><?php echo date('d F Y',strtotime($rows['uploading_file_date'])); ?></td>
<!--<td style="color:#000066" ><?php echo $rows['doc_creater']; ?></td>
<td style="color:#000066" ><?php echo $rows['doc_last_modified_by']; ?></td>-->
<?php 
$sqldoc="Select * from rs_tbl_category where category_cd=".$_REQUEST['category_cd'];
			$res2doc=$con->query($sqldoc);
			$total_numdd=$res2doc->rowCount();
			if($total_numdd>=1)
			{
				 $f=1;
 			while($row2doc=$res2doc->fetch())
			 {
			
			 ?>
			 <?php if($category_status==1){ ?>
			  <td><?php
			 		if($rows['report_status']=='1')
					{
					echo "Initiated <span style='float:right'><img width='15' height='15'  src='images/initiated.png'  alt='Initiated' />";
					} 
					else if($rows['report_status']=='2')
					{
					echo "Approved <span style='float:right'><img width='15' height='15'  src='images/approved.png'  alt='Approved' /></span>";
					}
					else if($rows['report_status']=='3')
					{
					echo  "Not Approved <span style='float:right'><img width='15' height='15'  src='images/not_approved.png'  alt='Not Approved' /></span>";
					}
					else if($rows['report_status']=='4')
					{
					echo "Under Review <span style='float:right'><img width='15' height='15'  src='images/under_review.png'  alt='Under Review' /></span>";
					}
					else if($rows['report_status']=='5')
					{
					echo "Response Awaited <span style='float:right'><img width='15' height='15'  src='images/awaiting_decision.png'  alt='Awaiting Decision' /></span>";
					}
					else if($rows['report_status']=='7')
					{
					echo "Responded<span style='float:right'><img width='15' height='15'  src='images/responded.png'  alt='Responded' /></span>";
					}?></td>
					<?php
					}
					?>
<?php /*?><td><a href="javascript:void(null);" onclick="window.open('send_file.php?report_id=<?php echo $rows['report_id']; ?>', 'Email','width=550,height=400,scrollbars=yes');" ><img  src="./images/send_mail.png" title="Send Email"/></a></td><?php */?>
<?php	
			
			
			
			
			
				$f++;
				}
			}
?>
</tr>
			
			
			
	<?php		
			
		
			
		}
    }
	else{
	?>
    <tr>
	<?php $colspn=$total+6;?>
    	<td colspan="<?php echo $colspn; ?>" align="center" style="background-color:white"><?php echo "No record Found";?></td>
    </tr>
		<?php
        }
        ?>
</table>
</td>
</tr>




</table>
		
		</div>
 			
		
		
  
</div>

      
	  
      </div><!-- class="content-wrapper" -->
        <!-- partial:../../partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->
         </div>     <!--content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
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
