<?php require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
$log_id = 1;
$edit			= $_GET['edit'];
$rfi_id			= $_GET['rfi_id'];

$revert			= $_GET['revert'];
$objDb  		= new Database();
$objSDb  		= new Database();
$objVSDb  		= new Database();
$objCSDb  		= new Database();
$file_path="rfi_docs/";
 $pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
$pid=$pData["pid"];
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
function getExtention($type){
	if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
		return "jpg";
	elseif($type == "image/png")
		return "png";
	elseif($type == "image/gif")
		return "gif";
	elseif($type == "application/pdf")
		return "pdf";
	elseif($type == "application/msword")
		return "doc";
	elseif($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		return "docx";
	elseif($type == "text/plain")
		return "doc";
		
}

if(isset($_REQUEST['save']))
{


		$lid=$_REQUEST['lid'];
	$contractor_no=$_REQUEST['contractor_no'];
	$section=$_REQUEST['section'];
	$site=$_REQUEST['site'];
	$rfi_number=$_REQUEST['rfi_number'];
	$rfi_prev_ref=$_REQUEST['rfi_prev_ref'];
	 $rfi_Date=$_REQUEST['rfi_Date'];
	if($rfi_Date=='')
	{
		
		$rfi_Date='0000-00-00';
	}
	
	$rfi_sub_date_time=$_REQUEST['rfi_sub_date_time'];

  if($rfi_sub_date_time=='')
	{
		
		 $rfi_sub_date_time ='00:00:00';
	}
	$rfi_activity_detail=$_REQUEST['rfi_activity_detail'];
	$rfi_activity_location=$_REQUEST['rfi_activity_location'];
	$rfi_activity_location_from=$_REQUEST['rfi_activity_location_from'];
	$rfi_activity_location_to=$_REQUEST['rfi_activity_location_to'];
	$rfi_contractor_rep_name=$_REQUEST['rfi_contractor_rep_name'];
	$RFI_Received_by=$_REQUEST['RFI_Received_by'];
	$RFI_Received_date_time=$_REQUEST['RFI_Received_date_time'];
  if($RFI_Received_date_time=='')
	{
		
		$RFI_Received_date_time='00:00:00';
	}

  $rfi_time=$_REQUEST['rfi_time'];
  if($rfi_time=='')
	{
		
		$rfi_time='00:00:00';
	}
	$RFI_Scanned_document=$_REQUEST['RFI_Scanned_document'];
	
	

	
	
	
	

	// insert query

	
	
	$message="";
	$pgid=1;
	if(isset($_FILES["Approval_documents"]["name"])&&$_FILES["Approval_documents"]["name"]!="")
	{
	$extension=getExtention($_FILES["Approval_documents"]["type"]);
	 $file_name=genRandom(5)."-".$lid;
   
	if(($_FILES["Approval_documents"]["type"] == "application/pdf")|| ($_FILES["Approval_documents"]["type"] == "application/msword") || 
	($_FILES["Approval_documents"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["Approval_documents"]["type"] == "text/plain") || 
	($_FILES["Approval_documents"]["type"] == "image/jpg")|| 
	($_FILES["Approval_documents"]["type"] == "image/jpeg")|| 
	($_FILES["Approval_documents"]["type"] == "image/gif") || 
	($_FILES["Approval_documents"]["type"] == "image/png"))
	{ 
	$Approval_documents=$file_name.".".$extension;
	  $target_file=$file_path.$Approval_documents;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['Approval_documents']['tmp_name'], $target_file);	
	
	
	}
	}
	if(isset($_FILES["RFI_Scanned_document"]["name"])&&$_FILES["RFI_Scanned_document"]["name"]!="")
	{
	$extension1=getExtention($_FILES["RFI_Scanned_document"]["type"]);
	 $RFI_Scanned_document_file_name=genRandom(5)."-".$lid;
   
	if(($_FILES["RFI_Scanned_document"]["type"] == "application/pdf")|| ($_FILES["RFI_Scanned_document"]["type"] == "application/msword") || 
	($_FILES["RFI_Scanned_document"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["RFI_Scanned_document"]["type"] == "text/plain") || 
	($_FILES["RFI_Scanned_document"]["type"] == "image/jpg")|| 
	($_FILES["RFI_Scanned_document"]["type"] == "image/jpeg")|| 
	($_FILES["RFI_Scanned_document"]["type"] == "image/gif") || 
	($_FILES["RFI_Scanned_document"]["type"] == "image/png"))
	{ 
	$RFI_Scanned_documentfile=$RFI_Scanned_document_file_name.".".$extension1;
	  $target_file1=$file_path.$RFI_Scanned_documentfile;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['RFI_Scanned_document']['tmp_name'], $target_file1);	
	
	
	}
	}
	if(isset($_FILES["Quality_test_report_document"]["name"])&&$_FILES["Quality_test_report_document"]["name"]!="")
	{
	$extension2=getExtention($_FILES["Quality_test_report_document"]["type"]);
	 $Quality_test_report_document_file_name=genRandom(5)."-".$lid;
	if(($_FILES["Quality_test_report_document"]["type"] == "application/pdf")|| ($_FILES["Quality_test_report_document"]["type"] == "application/msword") || 
	($_FILES["Quality_test_report_document"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["Quality_test_report_document"]["type"] == "text/plain") || 
	($_FILES["Quality_test_report_document"]["type"] == "image/jpg")|| 
	($_FILES["Quality_test_report_document"]["type"] == "image/jpeg")|| 
	($_FILES["Quality_test_report_document"]["type"] == "image/gif") || 
	($_FILES["Quality_test_report_document"]["type"] == "image/png"))
	{ 
	$Quality_test_report_documentfile=$Quality_test_report_document_file_name.".".$extension2;
	  $target_file2=$file_path.$Quality_test_report_documentfile;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['Quality_test_report_document']['tmp_name'], $target_file2);	
	
	
	}
	}
//    echo $insert_q="INSERT INTO tbl_rfi_lab( contractor_no, section, site, rfi_number, rfi_prev_ref, rfi_Date, rfi_sub_date_time, 
// rfi_activity_detail, rfi_activity_location, rfi_activity_location_from, rfi_activity_location_to, rfi_contractor_rep_name, 
// RFI_Received_by, RFI_Received_date_time, RFI_Scanned_document, Survey_Surveyor_name, Survey_Date_time, Survey_report, Survey_comments,
//  Survey_document, Inspection_inspector_name, Inspection_Date_time, Inspection_report, Inspection_comments, Inspection_document,
//   Quality_MT_Engineer_name, Quality_testing_Date_time, Quality_test_perfomed, Quality_test_sample_numbers, Quality_test_report, 
//   Quality_test_result, Quality_test_comments, Quality_test_report_document, Approval_authority, Approval_authority_name, 
//   Approval_status, Approval_comments, Approval_documents) VALUES ('$contractor_no','$section','$site','$rfi_number',
//   '$rfi_prev_ref','$rfi_Date','$rfi_sub_date_time','$rfi_activity_detail','$rfi_activity_location','$rfi_activity_location_from',
  
//   '$rfi_activity_location_to','$rfi_contractor_rep_nam','$RFI_Received_by','$RFI_Received_date_time','$RFI_Scanned_document'
//   ,'$Survey_Surveyor_name','$Survey_Date_time','$Survey_report','$Survey_comments','$Survey_document','$Inspection_inspector_name',
//   '$Inspection_Date_time','$Inspection_report','$Inspection_comments','$Inspection_document','$Quality_MT_Engineer_name',
  
//   '$Quality_testing_Date_time','$Quality_test_perfomed','$Quality_test_sample_numbers','$Quality_test_report',
//   '$Quality_test_result','$Quality_test_comments','$Quality_test_report_document','$Approval_authority','$Approval_authority_name',
  
//   '$Approval_status','$Approval_comments','$Approval_documents')";





$insert_q="INSERT INTO tbl_rfi_lab(lid, contractor_no, section, site, rfi_number, rfi_prev_ref, rfi_Date, rfi_sub_date_time, rfi_activity_detail, rfi_activity_location, 
rfi_activity_location_from, rfi_activity_location_to, rfi_contractor_rep_name, RFI_Received_by, RFI_Received_date_time,rfi_time, RFI_Scanned_document)
 VALUES ('$lid','$contractor_no','$section','$site','$rfi_number','$rfi_prev_ref','$rfi_Date','$rfi_sub_date_time','$rfi_activity_detail','$rfi_activity_location',
 '$rfi_activity_location_from','$rfi_activity_location_to','$rfi_contractor_rep_nam','$RFI_Received_by','$RFI_Received_date_time','$rfi_time','$RFI_Scanned_documentfile')";
$sql_pro= $objDb->dbQuery($insert_q);
/*$sql_pro= $objSDb->dbQuery("INSERT INTO tbl_rfi_lab( contractor_no, section, site, rfi_number, rfi_prev_ref, rfi_Date, rfi_sub_date_time, rfi_activity_detail, rfi_activity_location, rfi_activity_location_from, rfi_activity_location_to, rfi_contractor_rep_name, RFI_Received_by, RFI_Received_date_time, RFI_Scanned_document)VALUES('$contractor_no','$section','$site','$rfi_number','$rfi_prev_ref','$rfi_Date','$rfi_sub_date_time','$rfi_activity_detail','$rfi_activity_location','$rfi_activity_location_from','$rfi_activity_location_to','$rfi_contractor_rep_nam','$RFI_Received_by','$RFI_Received_date_time','$RFI_Scanned_document')");*/
//echo $pSQL="INSERT INTO tbl_rfi_lab( contractor_no,section,site,rfi_number) VALUES('11','22','22','22')";
//$sql_pro=$objDb->dbQuery($pSQL);
//$objSDb->dbQuery("INSERT INTO tbl_rfi_lab( contractor_no,section,site,rfi_number) VALUES('$contractor_no','$section','$site','$rfi_number')");
 //$insertid=$con->lastInsertId();
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity=$insertid." - New record for issues added successfully";
} else {
    $message= "Error in adding record";
	$activity="Error in adding record";
	
}
//$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
//$objSDb->dbQuery($iSQL);

	
	$iss_no='';
	$iss_date='';
	$iss_title='';
	$iss_detail='';
	$iss_status='';
	$iss_action='';
	$iss_remarks='';
	$al_file='';

 




}
if(isset($_REQUEST['update1'])){

	$Survey_Surveyor_name=$_REQUEST['Survey_Surveyor_name'];
	 $Survey_Date_time=$_REQUEST['Survey_Date_time'];
	if($Survey_Date_time=='')
	{
		
		$Survey_Date_time='00:00:00';
	}

	$Survey_report=$_REQUEST['Survey_report'];
	$Survey_comments=$_REQUEST['Survey_comments'];
	$Survey_document=$_REQUEST['Survey_document'];
  $survey_time=$_REQUEST['survey_time'];

  if($survey_time=='')
	{
		
		$survey_time='00:00:00';
	}




  
  if(isset($_FILES["Survey_document"]["name"])&&$_FILES["Survey_document"]["name"]!="")
	{
	$extension=getExtention($_FILES["Survey_document"]["type"]);
	 $file_name=genRandom(5)."-".$Survey_document;
   
	if(($_FILES["Survey_document"]["type"] == "application/pdf")|| ($_FILES["Survey_document"]["type"] == "application/msword") || 
	($_FILES["Survey_document"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["Survey_document"]["type"] == "text/plain") || 
	($_FILES["Survey_document"]["type"] == "image/jpg")|| 
	($_FILES["Survey_document"]["type"] == "image/jpeg")|| 
	($_FILES["Survey_document"]["type"] == "image/gif") || 
	($_FILES["Survey_document"]["type"] == "image/png"))
	{ 
	$Survey_document=$file_name.".".$extension;
	  $target_file=$file_path.$Survey_document;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['Survey_document']['tmp_name'], $target_file);	
	
	
	}
	}
echo $Survey_document;
  $insert_q2="UPDATE tbl_rfi_lab SET Survey_Surveyor_name='$Survey_Surveyor_name', Survey_Date_time='$Survey_Date_time',survey_time='$survey_time', Survey_report='$Survey_report',
   Survey_comments='$Survey_comments', Survey_document='$Survey_document' WHERE rfi_id='$rfi_id'";
  $sql_pro2= $objDb->dbQuery($insert_q2);
if ($sql_pro2 == TRUE) {
  $message=  "New record added successfully";
$activity=$insertid." - New record for issues added successfully";
} else {
  $message= "Error in adding record";
}
}

if(isset($_REQUEST['update2'])){

	
	$Inspection_inspector_name=$_REQUEST['Inspection_inspector_name'];
	$Inspection_Date_time=$_REQUEST['Inspection_Date_time'];
  if($Inspection_Date_time=='')
	{
		
		$Inspection_Date_time='00:00:00';
	}
	$Inspection_report=$_REQUEST['Inspection_report'];
	$Inspection_comments=$_REQUEST['Inspection_comments'];
	$Inspection_document=$_REQUEST['Inspection_document'];
	$Inspect_time=$_REQUEST['Inspect_time'];
  if($Inspect_time=='')
	{
		
		$Inspect_time='00:00:00';
	}
  if(isset($_FILES["Inspection_document"]["name"])&&$_FILES["Inspection_document"]["name"]!="")
	{
	$extension=getExtention($_FILES["Inspection_document"]["type"]);
	 $file_name=genRandom(5)."-".$Approval_documents;
   
	if(($_FILES["Inspection_document"]["type"] == "application/pdf")|| ($_FILES["Inspection_document"]["type"] == "application/msword") || 
	($_FILES["Inspection_document"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["Inspection_document"]["type"] == "text/plain") || 
	($_FILES["Inspection_document"]["type"] == "image/jpg")|| 
	($_FILES["Inspection_document"]["type"] == "image/jpeg")|| 
	($_FILES["Inspection_document"]["type"] == "image/gif") || 
	($_FILES["Inspection_document"]["type"] == "image/png"))
	{ 
	$Inspection_document=$file_name.".".$extension;
	  $target_file=$file_path.$Inspection_document;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['Inspection_document']['tmp_name'], $target_file);	
	
	
	}
	}

  $insert_q3="UPDATE tbl_rfi_lab SET Inspection_inspector_name='$Inspection_inspector_name', Inspection_Date_time='$Inspection_Date_time',Inspect_time='$Inspect_time', Inspection_report='$Inspection_report',
   Inspection_comments='$Inspection_comments', Inspection_document='$Inspection_document' WHERE rfi_id='$rfi_id'";
  $sql_pro3= $objDb->dbQuery($insert_q3);
if ($sql_pro3 == TRUE) {
  $message=  "New record added successfully";
$activity=$insertid." - New record for issues added successfully";
} else {
  $message= "Error in adding record";
}
}


if(isset($_REQUEST['update3'])){

	
	$Quality_MT_Engineer_name=$_REQUEST['Quality_MT_Engineer_name'];
	$Quality_testing_Date_time=$_REQUEST['Quality_testing_Date_time'];
  if($Quality_testing_Date_time=='')
	{
		
		$Quality_testing_Date_time='00:00:00';
	}
	$Quality_test_perfomed=$_REQUEST['Quality_test_perfomed'];
	$Quality_test_sample_numbers=$_REQUEST['Quality_test_sample_numbers'];
	$Quality_test_report=$_REQUEST['Quality_test_report'];
	$Quality_test_result=$_REQUEST['Quality_test_result'];
	$Quality_test_comments=$_REQUEST['Quality_test_comments'];
	$Quality_test_report_document=$_REQUEST['Quality_test_report_document'];
	$Quality_time=$_REQUEST['Quality_time'];
  if($Quality_time=='')
	{
		
		$Quality_time='00:00:00';
	}
  if(isset($_FILES["Quality_test_report_document"]["name"])&&$_FILES["Quality_test_report_document"]["name"]!="")
	{
	$extension2=getExtention($_FILES["Quality_test_report_document"]["type"]);
	 $Quality_test_report_document_file_name=genRandom(5)."-".$lid;

	if(($_FILES["Quality_test_report_document"]["type"] == "application/pdf")|| ($_FILES["Quality_test_report_document"]["type"] == "application/msword") || 
	($_FILES["Quality_test_report_document"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["Quality_test_report_document"]["type"] == "text/plain") || 
	($_FILES["Quality_test_report_document"]["type"] == "image/jpg")|| 
	($_FILES["Quality_test_report_document"]["type"] == "image/jpeg")|| 
	($_FILES["Quality_test_report_document"]["type"] == "image/gif") || 
	($_FILES["Quality_test_report_document"]["type"] == "image/png"))
	{ 
	$Quality_test_report_documentfile=$Quality_test_report_document_file_name.".".$extension2;
	  $target_file2=$file_path.$Quality_test_report_documentfile;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);

	move_uploaded_file($_FILES['Quality_test_report_document']['tmp_name'], $target_file2);	
	
	
	}
	}

  $insert_q4="UPDATE tbl_rfi_lab SET Quality_MT_Engineer_name='$Quality_MT_Engineer_name', Quality_testing_Date_time='$Quality_testing_Date_time',Quality_time='$Quality_time', Quality_test_perfomed='$Quality_test_perfomed',
   Quality_test_sample_numbers='$Quality_test_sample_numbers', Quality_test_report='$Quality_test_report' , Quality_test_result='$Quality_test_result',
   Quality_test_comments='$Quality_test_comments' , Quality_test_report_document='$Quality_test_report_documentfile' WHERE rfi_id='$rfi_id'";
    echo $insert_q4;

  $sql_pro4= $objDb->dbQuery($insert_q4);
if ($sql_pro4 == TRUE) {
  $message=  "New record added successfully";
$activity=$insertid." - New record for issues added successfully";
} else {
  $message= "Error in adding record";
}
}


if(isset($_REQUEST['update4'])){


	$Approval_authority=$_REQUEST['Approval_authority'];
	$Approval_authority_name=$_REQUEST['Approval_authority_name'];
	$Approval_status=$_REQUEST['Approval_status'];
	$Approval_comments=$_REQUEST['Approval_comments'];
	$Approval_documents=$_REQUEST['Approval_documents'];
	
	if(isset($_FILES["Approval_documents"]["name"])&&$_FILES["Approval_documents"]["name"]!="")
	{
	$extension=getExtention($_FILES["Approval_documents"]["type"]);
	 $file_name=genRandom(5)."-".$Approval_documents;
   
	if(($_FILES["Approval_documents"]["type"] == "application/pdf")|| ($_FILES["Approval_documents"]["type"] == "application/msword") || 
	($_FILES["Approval_documents"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["Approval_documents"]["type"] == "text/plain") || 
	($_FILES["Approval_documents"]["type"] == "image/jpg")|| 
	($_FILES["Approval_documents"]["type"] == "image/jpeg")|| 
	($_FILES["Approval_documents"]["type"] == "image/gif") || 
	($_FILES["Approval_documents"]["type"] == "image/png"))
	{ 
	$Approval_documents=$file_name.".".$extension;
	  $target_file=$file_path.$Approval_documents;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['Approval_documents']['tmp_name'], $target_file);	
	
	
	}
	}
  

  $insert_q5="UPDATE tbl_rfi_lab SET Approval_authority='$Approval_authority', Approval_authority_name='$Approval_authority_name', Approval_status='$Approval_status',
   Approval_comments='$Approval_comments', Approval_documents='$Approval_documents' WHERE rfi_id='$rfi_id'";
  $sql_pro5= $objDb->dbQuery($insert_q5);
if ($sql_pro5 == TRUE) {
  $message=  "New record added successfully";
$activity=$insertid." - New record for issues added successfully";
} else {
  $message= "Error in adding record";
}
}



if(isset($_REQUEST['update0'])){

  $lid=$_REQUEST['lid'];
	$contractor_no=$_REQUEST['contractor_no'];
	$section=$_REQUEST['section'];
	$site=$_REQUEST['site'];
	$rfi_number=$_REQUEST['rfi_number'];
	$rfi_prev_ref=$_REQUEST['rfi_prev_ref'];
	 $rfi_Date=trim($_REQUEST['rfi_Date']);
	if($rfi_Date=='')
	{
		
		$rfi_Date='0000-00-00';
	}
	else
	{
		$rfi_Date=$rfi_Date;
	}
	$rfi_sub_date_time=date('Y-m-d',strtotime($_REQUEST['rfi_sub_date_time']));
	$rfi_activity_detail=$_REQUEST['rfi_activity_detail'];
	$rfi_activity_location=$_REQUEST['rfi_activity_location'];
	$rfi_activity_location_from=$_REQUEST['rfi_activity_location_from'];
	$rfi_activity_location_to=$_REQUEST['rfi_activity_location_to'];
	$rfi_contractor_rep_name=$_REQUEST['rfi_contractor_rep_name'];
	$RFI_Received_by=$_REQUEST['RFI_Received_by'];
	$RFI_Received_date_time=$_REQUEST['RFI_Received_date_time'];
  $rfi_time=$_REQUEST['rfi_time'];
	$RFI_Scanned_document=$_REQUEST['RFI_Scanned_document'];
  
  if(isset($_FILES["RFI_Scanned_document"]["name"])&&$_FILES["RFI_Scanned_document"]["name"]!="")
	{
	$extension1=getExtention($_FILES["RFI_Scanned_document"]["type"]);
	 $RFI_Scanned_document_file_name=genRandom(5)."-".$RFI_Scanned_document;
   
	if(($_FILES["RFI_Scanned_document"]["type"] == "application/pdf")|| ($_FILES["RFI_Scanned_document"]["type"] == "application/msword") || 
	($_FILES["RFI_Scanned_document"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["RFI_Scanned_document"]["type"] == "text/plain") || 
	($_FILES["RFI_Scanned_document"]["type"] == "image/jpg")|| 
	($_FILES["RFI_Scanned_document"]["type"] == "image/jpeg")|| 
	($_FILES["RFI_Scanned_document"]["type"] == "image/gif") || 
	($_FILES["RFI_Scanned_document"]["type"] == "image/png"))
	{ 
	$RFI_Scanned_documentfile=$RFI_Scanned_document_file_name.".".$extension1;
	  $target_file1=$file_path.$RFI_Scanned_documentfile;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['RFI_Scanned_document']['tmp_name'], $target_file1);	
	
	
	}
	}


  $insert_q6="UPDATE tbl_rfi_lab SET lid='$lid',contractor_no='$contractor_no', section='$section', site='$site',
   rfi_number='$rfi_number', rfi_prev_ref='$rfi_prev_ref' , rfi_Date='$rfi_Date',
   rfi_sub_date_time='$rfi_sub_date_time' , rfi_activity_detail='$rfi_activity_detail', rfi_activity_location='$rfi_activity_location',
   rfi_activity_location_from='$rfi_activity_location_from', rfi_activity_location_to='$rfi_activity_location_to' , rfi_contractor_rep_name='$rfi_contractor_rep_name',
   RFI_Received_by='$RFI_Received_by' , RFI_Received_date_time='$RFI_Received_date_time',rfi_time='$rfi_time', RFI_Scanned_document='$RFI_Scanned_documentfile' WHERE rfi_id='$rfi_id'";
  $sql_pro6= $objDb->dbQuery($insert_q6);
if ($sql_pro6 == TRUE) {
  $message=  "New record added successfully";
$activity=$insertid." - New record for issues added successfully";
} else {
  $message= "Error in adding record";
}
}

if(isset($_REQUEST['rfi_id']))
{
$rfi_id=$_REQUEST['rfi_id'];

$pdSQL1="SELECT * FROM tbl_rfi_lab  WHERE rfi_id = '$rfi_id'";

$objDb->dbQuery($pdSQL1);
$pdData1=$objDb->dbFetchArray();
//$pdData1 = mysql_fetch_array($pdSQLResult1);
  
  $lid=$pdData1['lid'];
	$contractor_no=$pdData1['contractor_no'];
	$site=$pdData1['site'];
	$section=$pdData1['section'];
	$rfi_number=$pdData1['rfi_number'];
	$rfi_prev_ref=$pdData1['rfi_prev_ref'];
	$rfi_Date=$pdData1['rfi_Date'];
	$rfi_sub_date_time=$pdData1['rfi_sub_date_time'];
	$rfi_activity_detail=$pdData1['rfi_activity_detail'];
	$rfi_activity_location=$pdData1['rfi_activity_location'];
  $rfi_activity_location_from=$pdData1['rfi_activity_location_from'];
  $rfi_activity_location_to=$pdData1['rfi_activity_location_to'];;
  $rfi_contractor_rep_name=$pdData1['rfi_contractor_rep_name'];
  $RFI_Received_by=$pdData1['RFI_Received_by'];
  $RFI_Received_date_time=$pdData1['RFI_Received_date_time'];
  $rfi_time=$pdData1['rfi_time'];

  $RFI_Scanned_document=$pdData1['RFI_Scanned_document'];

  $Survey_Surveyor_name=$pdData1['Survey_Surveyor_name'];
  $Survey_Date_time=$pdData1['Survey_Date_time'];
  $Survey_report=$pdData1['Survey_report'];
  $Survey_comments=$pdData1['Survey_comments'];
  $Survey_document=$pdData1['Survey_document'];
  $survey_time=$pdData1['survey_time'];

  $Inspection_inspector_name=$pdData1['Inspection_inspector_name'];
	$Inspection_Date_time=$pdData1['Inspection_Date_time'];
	$Inspection_report=$pdData1['Inspection_report'];
	$Inspection_comments=$pdData1['Inspection_comments'];
	$Inspection_document=$pdData1['Inspection_document'];
  $Inspect_time=$pdData1['Inspect_time'];

  $Quality_MT_Engineer_name=$pdData1['Quality_MT_Engineer_name'];
	$Quality_testing_Date_time=$pdData1['Quality_testing_Date_time'];
	$Quality_test_perfomed=$pdData1['Quality_test_perfomed'];
	$Quality_test_sample_numbers=$pdData1['Quality_test_sample_numbers'];
	$Quality_test_report=$pdData1['Quality_test_report'];
	$Quality_test_result=$pdData1['Quality_test_result'];
	$Quality_test_comments=$pdData1['Quality_test_comments'];
	$Quality_test_report_document=$pdData1['Quality_test_report_document'];
  $Quality_time=$pdData1['Quality_time'];

  
	$Approval_authority=$pdData1['Approval_authority'];
	$Approval_authority_name=$pdData1['Approval_authority_name'];
	$Approval_status=$pdData1['Approval_status'];
	$Approval_comments=$pdData1['Approval_comments'];
	$Approval_documents=$pdData1['Approval_documents'];
	
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php //include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="scripts/JsCommon.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <script>
  function required(){
	
	var x =document.getElementById("lid").value;
	var file =document.getElementById("al_file").value;
	var old_file =document.getElementById("old_al_file").value;
	
	 if (x == 0) {
    alert("Select Component First");
    return false;
  		}
		
  
  }
  </script>


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Input - Project Issues</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">

  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
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
        
        .text-34{
  background-color: #151563;
  border-radius: 10px;
  /* box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px; */
  padding-bottom: 12px;
  padding-top: 12px;
  border-radius: 5px 5px;
  color: white;
  font-size: 100%;
}
table{
   
   border:  double ;
   }
.shadow_table{
	box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
	  border-radius: 6px;
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


<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.9.2/jquery-ui.min.js"></script>

  <script> 
$(document).ready(function () {
   var date = new Date(); 
$('#rfi_Date').datepicker({ dateFormat: 'yy-mm-dd'}); });

$(document).ready(function () {
   var date = new Date(); 
$('#rfi_sub_date_time').datepicker({ dateFormat: 'yy-mm-dd'}); });

$(document).ready(function () {
   var date = new Date(); 
$('#RFI_Received_date_time').datepicker({ dateFormat: 'yy-mm-dd'}); });

$(document).ready(function () {
   var date = new Date(); 
$('#Survey_Date_time').datepicker({ dateFormat: 'yy-mm-dd'}); });

$(document).ready(function () {
   var date = new Date(); 
$('#Inspection_Date_time').datepicker({ dateFormat: 'yy-mm-dd'}); });

$(document).ready(function () {
   var date = new Date(); 
$('#Quality_testing_Date_time').datepicker({ dateFormat: 'yy-mm-dd'}); });
</script> 


<link rel="stylesheet" href="../../../timepicker/wickedpicker.css">
<script type="text/javascript" src="../../../timepicker/wickedpicker.js"></script>



</head>

<body>
  <div class="container-scroller">
     <!-- partial:partials/_navbar.html --><div id="partials-navbar"></div> <!-- partial -->
     <div class=" page-body-wrapper" id="pagebodywraper">
       <!-- partial:partials/_sidebar.html --> 
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div><!-- partial -->

      <div class="main-panel " id="mainpanel">
      <div class="content-wrapper" style="">
        <h4 class="text-center text-34 mb-4" style="  letter-spacing: 4px">  REQUEST FOR INFORMATION (RFI) </h4> 
        <?php if($message!=""){?>
          <h3 class="text-center text-34 mb-4" style="  letter-spacing: 4px; color:#096"><?php echo $message;}?></h3>
     
          


              <div class="card ">
                <div class="card-body">


            <form class="form-sample" method="post" target="_self" method="post"  enctype="multipart/form-data">

            <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab"> 
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#rfi_details" role="tab" aria-controls="rfi_details" aria-selected="true"> RFI Details </a>
                    </li>
                   
                    <li class="nav-item">
                      <a class="nav-link" id="indicators-tab" data-bs-toggle="tab" <?php if(isset($rfi_id)&&$rfi_id!=0) { ?> href="#surv_details"<?php } else {?> href="#" <?php }?>  role="tab" aria-selected="false">Survey Details</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab" <?php if(isset($rfi_id)&&$rfi_id!=0) { ?> href="#inspect_details"<?php } else {?> href="#" <?php }?> role="tab" aria-selected="false">Inspection Details</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab" <?php if(isset($rfi_id)&&$rfi_id!=0) { ?> href="#qual_details"<?php } else {?> href="#" <?php }?> role="tab" aria-selected="false">Quality  Details</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab" <?php if(isset($rfi_id)&&$rfi_id!=0) { ?> href="#app_details"<?php } else {?> href="#" <?php }?> role="tab" aria-selected="false">Approved Details</a>
                    </li>

                 
                  </ul>
                  <div>
                    <div class="btn-wrapper">
                     
                    </div>
                  </div>
                </div>
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="rfi_details" role="tabpanel" aria-labelledby="rfi_details"> 
                    <div class="row">
            <div class="col-lg-12 grid-margin ">
            <h4 class="card-title text-center">RFI Details </h4>
            <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end ">Component Area :</label>
                          <div class="col-sm-9">
                          <select class="form-control  bg-light text-dark" id="lid" name="lid" style="width: 60%;" Required>
                          <option value="" >Select Component Area </option>

					<?php $pdSQL = "SELECT lid,pid,code,title FROM  structures  order by lid";
										$pdSQLResult = $objDb->dbQuery($pdSQL);
										$i=0;
										if($objDb-> totalRecords()>=1);
											
											{
											while($pdData=$objDb->dbFetchArray())
											{ 
											$i++;?>

				<option value="<?php echo $pdData["lid"];?>" <?php if($lid==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"] ?></option>

				<?php } 
				}?>
					</select>   
                               </div>
                        </div>
                      </div>
                      </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end ">Contract No :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="contractor_no" value="<?php echo $contractor_no; ?>" id="contractor_no" placeholder=""  required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end  ">Section :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="section"  value="<?php echo $section; ?>" id="section" placeholder="" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Site :</label>
                          <div class="col-sm-9">
                          <input type="text" class="form-control" name="site"  value="<?php echo $site; ?>" id="site" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">RFI Number</label>
                          <div class="col-sm-9">
                          <input type="text" class="form-control" name="rfi_number"  value="<?php echo $rfi_number; ?>"  id="rfi_number" placeholder="" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"> Reference RFI Number :</label>
                          <div class="col-sm-9">
                          <input type="text" class="form-control" name="rfi_prev_ref"  value="<?php echo $rfi_prev_ref; ?>" id="rfi_prev_ref" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"> RFI Date :</label>
                          <div class="col-sm-9">
                          <input class="form-control" id="rfi_Date" placeholder ="yyyy-mm-dd" type="date" name="rfi_Date" value="<?php echo substr($rfi_Date,0,10); ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
           
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">RFI Submission Date </label>
                          <div class="col-sm-9">
                            <input type="date" class="form-control" name="rfi_sub_date_time"  value="<?php echo substr($rfi_sub_date_time,0,10); ?>" id="rfi_sub_date_time" placeholder="yyyy-mm-dd" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">RFI Location</label>
                          <div class="col-sm-9">
                          <input type="text" class="form-control" name="rfi_activity_location"  value="<?php echo $rfi_activity_location; ?>"  id="rfi_activity_location" placeholder="" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Activity Location From :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="rfi_activity_location_from"  value="<?php echo $rfi_activity_location_from; ?>" id="rfi_activity_location_from" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Activity Location To :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="rfi_activity_location_to"  value="<?php echo $rfi_activity_location_to; ?>"  id="rfi_activity_location_to" placeholder="" />
                          </div>
                        </div>
                      </div>
                    </div>
 
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Contractor Rep Name:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="rfi_contractor_rep_name"  value="<?php echo $rfi_contractor_rep_name; ?>"  id="rfi_contractor_rep_name" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Received by:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="RFI_Received_by"  value="<?php echo $RFI_Received_by; ?>" id="RFI_Received_by" placeholder="" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Received Date</label>
                          <div class="col-sm-9">
                          <input type="date" class="form-control" name="RFI_Received_date_time"  value="<?php echo substr($RFI_Received_date_time,0,10); ?>" id="RFI_Received_date_time" placeholder="yyyy-mm-dd" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Received Time</label>
                          <div class="col-sm-9">
                            <input type="time" class="timepicker form-control" name="rfi_time"  value="<?php echo $rfi_time; ?>"  id="rfi_time" placeholder="yyyy-mm-dd" />
                            <script type="text/javascript">$('.timepicker').wickedpicker({now: '00:00', twentyFour: true, showSeconds: false});</script>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Activity Detail</label>
                          <div class="col-sm-9">
                            <textarea  class="form-control" rows="4" style=" height: 100px; "  name="rfi_activity_detail"   id="rfi_activity_detail"><?php echo $rfi_activity_detail; ?> </textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"> Scanned Document</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control bg-light" name="RFI_Scanned_document"  id="RFI_Scanned_document" value="<?php echo $pdData1['RFI_Scanned_document']; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                   
                <!-- Save button -->
            <div class="pt-2 text-end pb-3" > 
            <button type="button" class="col-sm-2 button-33" onclick="location.href='RFI_info.php'  ;" name="" id="" value=""> <?php echo "Back"?> </button>

                <button  class="col-sm-2 button-33" type="submit" <?php if(isset($rfi_id)&&$rfi_id!=0) { ?> name="update0" id="update0"<?php } else {?> name="save" id="save"<?php }?>
                  style="width:15%"> <?php if(isset($rfi_id)&&$rfi_id!=0) { echo "Update"; } else {echo "Save";}?>
</button>
            </div>
            <div class="style-five row" >  </div>


            </div>
          
          </div>
          
                  </div>
                  <div class="tab-pane fade show" id="surv_details" role="tabpanel" aria-labelledby="surv_details"> 
                     <div class="row">
            <div class="col-lg-12 grid-margin ">
              
        <h4 class="card-title text-center pt-4 pb-1">Survey Details</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Surveyor Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="Survey_Surveyor_name" value="<?php echo $Survey_Surveyor_name; ?>" id="Survey_Surveyor_name" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"> </label>
                          <div class="col-sm-9">
                           
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Survey Date</label>
                          <div class="col-sm-9">
                          <input type="date" class="form-control" name="Survey_Date_time" value="<?php echo substr($Survey_Date_time,0,10); ?>"  id="Survey_Date_time" placeholder="yyyy-mm-dd" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Survey Time</label>
                          <div class="col-sm-9">
                          <input type="time" class="timepicker form-control" name="survey_time" value="<?php echo $survey_time ?>" id="survey_time" placeholder="hh:mm:ss" />
                            <script type="text/javascript">$('.timepicker').wickedpicker({now: '00:00', twentyFour: true, showSeconds: false});</script>
                          </div>
                        </div>
                      </div>
                    </div> 
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Survey Report</label>
                          <div class="col-sm-9">
                          <textarea  class="form-control" rows="4" style=" height: 100px; "  name="Survey_report"  id="Survey_report" > <?php echo $Survey_report; ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Survey Comments</label>
                          <div class="col-sm-9">
                          <textarea  class="form-control" rows="4" style=" height: 100px; "  name="Survey_comments"  id="Survey_comments" ><?php echo $Survey_comments; ?> </textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Survey Document</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control bg-light" name="Survey_document" value="<?php echo $Survey_document; ?>" id="Survey_document" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"></label>
                          <div class="col-sm-9">
                           
                          </div>
                        </div>
                      </div>
                    </div>
    
            <!-- Save button -->
            <div class="pt-2 text-end pb-3" > 
            <button type="button" class="col-sm-2 button-33" onclick="location.href='RFI_info.php'  ;" name="" id="" value=""> <?php echo "Back"?> </button>

                <button  class="col-sm-2 button-33" type="submit" name="update1" id="update1"  style="width:15%">Update</button>
            </div>
            <div class="style-five row" >  </div>
            

            </div>
           
            
          </div>
                  </div>
                  
                  <div class="tab-pane fade show" id="inspect_details" role="tabpanel" aria-labelledby="inspect_details"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                    
                        
        <h4 class="card-title text-center pt-4 pb-1">Inspection Details</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Inspector Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="Inspection_inspector_name" value="<?php echo $Inspection_inspector_name; ?>" id="Inspection_inspector_name" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"> </label>
                          <div class="col-sm-9">
                           
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Inspection Date</label>
                          <div class="col-sm-9">
                          <input type="Date" class="form-control" name="Inspection_Date_time" value="<?php echo substr($Inspection_Date_time,0,10); ?>" id="Inspection_Date_time" placeholder="yyyy-mm-dd" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Inspection Time</label>
                          <div class="col-sm-9">
                          <input type="time" class="timepicker form-control" name="Inspect_time" value="<?php echo $Inspect_time; ?>" id="Inspect_time" placeholder="yyyy-mm-dd" />
                            <script type="text/javascript">$('.timepicker').wickedpicker({now: '00:00', twentyFour: true, showSeconds: false});</script>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Inspection Report</label>
                          <div class="col-sm-9">
                          <textarea  class="form-control" rows="4" style=" height: 100px; "  name="Inspection_report"  id="Inspection_report" > <?php echo $Inspection_report; ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Inspection Comments</label>
                          <div class="col-sm-9">
                          <textarea  class="form-control" rows="4" style=" height: 100px; "  name="Inspection_comments"  id="Inspection_comments" > <?php echo $Inspection_comments; ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Inspection Document</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control bg-light " name="Inspection_document" value="<?php echo $Inspection_document; ?>" id="Inspection_document" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"></label>
                          <div class="col-sm-9">
                           
                          </div>
                        </div>
                      </div>
                    </div>
   
            <!-- Save button -->
            <div class="pt-2 text-end pb-3" > 
            <button type="button" class="col-sm-2 button-33" onclick="location.href='RFI_info.php'  ;" name="" id="" value=""> <?php echo "Back"?> </button>

                <button  class="col-sm-2 button-33" type="submit" name="update2" id="update2" style="width:15%">Update</button>
            </div>
            <div class="style-five row" >  </div>

      
                      </div>
                
                </div>
              </div>
             
            </div>
            <div class="tab-pane fade show" id="qual_details" role="tabpanel" aria-labelledby="qual_details"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                    
                      <h4 class="card-title text-center pt-4 pb-1">Quality Details</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">MT Engineer Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="Quality_MT_Engineer_name" value="<?php echo $Quality_MT_Engineer_name; ?>"  id="Quality_MT_Engineer_name" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"> </label>
                          <div class="col-sm-9">
                           
                          </div>
                        </div>
                      </div>
                    </div>
                 
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"> Testing Date:</label>
                          <div class="col-sm-9">
                          <input type="date" class="form-control" name="Quality_testing_Date_time" value="<?php echo substr($Quality_testing_Date_time,0,10); ?>" id="Quality_testing_Date_time" placeholder="yyyy-mm-dd" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end"> Testing Time:</label>
                          <div class="col-sm-9">
                          <input type="time" class="timepicker form-control" name="Quality_time" value="<?php echo $Quality_time; ?>" id="Quality_time" placeholder="yyyy-mm-dd" />
                            <script type="text/javascript">$('.timepicker').wickedpicker({now: '00:00', twentyFour: true, showSeconds: false});</script>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Test Perfomed:</label>
                          <div class="col-sm-9">
                          <textarea  class="form-control" rows="4" style=" height: 100px; "  name="Quality_test_perfomed"  id="Quality_test_perfomed"><?php echo $Quality_test_perfomed; ?> </textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Test Sample Numbers:</label>
                          <div class="col-sm-9">
                          <input type="number"   class="form-control" type= rows="4" style=" height: 100px; "  name="Quality_test_sample_numbers"  id="Quality_test_sample_numbers" value="<?php echo $Quality_test_sample_numbers; ?>"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Test Report:</label>
                          <div class="col-sm-9">
                          <textarea  class="form-control" rows="4" style=" height: 100px; "  name="Quality_test_report"  id="Quality_test_report" > <?php echo $Quality_test_report; ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Test Result:</label>
                          <div class="col-sm-9">
                          <textarea  class="form-control" rows="4" style=" height: 100px; "  name="Quality_test_result"  id="Quality_test_result" ><?php echo $Quality_test_result; ?> </textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Test Comments</label>
                          <div class="col-sm-9">
                          <textarea  class="form-control" rows="4" style=" height: 100px; "  name="Quality_test_comments"  id="Quality_test_comments" ><?php echo $Quality_test_comments; ?> </textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Inspection Document:</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control bg-light " name="Quality_test_report_document"  value="<?php echo $Quality_test_report_document; ?>" id="Quality_test_report_document" placeholder="" />
                          </div>
                        </div>
                      </div>
                  
                    </div>
                        
    
            <!-- Save button -->
            <div class="pt-2 text-end pb-3" > 
            <button type="button" class="col-sm-2 button-33" onclick="location.href='RFI_info.php'  ;" name="" id="" value=""> <?php echo "Back"?> </button>

                <button  class="col-sm-2 button-33" type="submit" name="update3" id="update3" style="width:15%">Update</button>
            </div>
            <div class="style-five row" >  </div>

                      </div>
                
                </div>

              </div>
              </div>  

              
              <div class="tab-pane fade show" id="app_details" role="tabpanel" aria-labelledby="app_details"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
                      <h4 class="card-title text-center pt-4 pb-1">Approved Details</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Approved Authority :</label>
                          <div class="col-sm-9">
                          <select class="form-control bg-light text-dark" value="<?php echo $Approval_authority; ?>"  name="Approval_authority"  id="Approval_authority" >

                          <option value="1" <?php if($Approval_authority==1) {?> selected="selected" <?php }?>>Client</option>
                              <option value="2" <?php if($Approval_authority==2) {?> selected="selected" <?php }?>>Consultant</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end ">Approved Authority Name  </label>
                          <div class="col-sm-9">
                          <select class="form-control bg-light text-dark"  name="Approval_authority_name" value="<?php echo $Approval_authority_name; ?>" id="Approval_authority_name" >
                              <option value="1"<?php if($Approval_authority_name==1) {?> selected="selected" <?php }?>>option 1</option>
                              <option value="2"<?php if($Approval_authority_name==2) {?> selected="selected" <?php }?>>option 2</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Approved Comments:</label>
                          <div class="col-sm-9">
                          <textarea  class="form-control" rows="4" style=" height: 100px; "  name="Approval_comments"  id="Approval_comments" ><?php echo $Approval_comments; ?> </textarea>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 text-end">Approved Document:</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control bg-light " name="Approval_documents" value="<?php echo $Approval_documents; ?>"  id="Approval_documents" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                      
                            <label class="col-sm-3 text-end"> Approved Status: </label>
                            <div class="col-sm-9 text-start">
                              
                            <label class="form-check-label" style="padding-left: 1%; ">
                                  <input  type="radio" class="form-check-input"  id="" name="Approval_status" value="1"  checked="checked"/> Approved
                            </label>
                            

                              
                            <label class="form-check-label " style="padding-left: 5%;">
                                   <input  type="radio" class="form-check-input" id="" name="Approval_status" value="2" <?php if($Approval_status==2) echo 'checked="checked"';?> /> Rejected
                            </label>
                           
                            
                            <label class="form-check-label " style="padding-left: 5%;">
                                   <input  type="radio" class="form-check-input" id="" name="Approval_status" value="3" <?php if($Approval_status==3) echo 'checked="checked"';?> /> Partially Approved
                            </label>
                           
                            </div>
                          
                        </div>
                      </div>
                    </div>
                    
            <!-- Save button -->
            <div class="pt-2 text-end pb-3" > 
            <button type="button" class="col-sm-2 button-33" onclick="location.href='RFI_info.php'  ;" name="" id="" value=""> <?php echo "Back"?> </button>

                <button  class="col-sm-2 button-33" type="submit" name="update4"  id="update4"  style="width:15%">Update</button>
            </div>
            <div class="style-five row" >  </div>

    

                
                </div>
              </div>
              	
              
            </div>
            
          </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
            
          </div>
                  </div>
                </div>
              </div>
            </div>
           </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->
      </div>

         
       

     

            
                  </form>
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
    <!-- page-body-wrapper ends -->


  <!-- plugins:js -->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../../vendors/chart.js/Chart.min.js"></script>

  <!-- commented because of date picker -->
  <!-- <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script> -->
  <!-- Custom js for this page-->
  <script src="../../../js/chart.js"></script>

  <!-- commented because of date picker -->
  <!-- <script src="../../js/navtype_session.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->      
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->

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


<script language="javascript" type="text/javascript"></script>


</body>
</html>