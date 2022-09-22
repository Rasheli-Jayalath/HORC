	  
if($saveBtn != "")
{

 $sSQLc = ("INSERT INTO project_currency(base_cur,cur_1,cur_1_rate,cur_2,cur_2_rate,cur_3,cur_3_rate)VALUES('$base_cur','$cur_1','$cur_1_rate','$cur_2','$cur_2_rate','$cur_3','$cur_3_rate')");
	$objIC->execute($sSQLc);

	
 $sSQL = ("INSERT INTO project (pcode,pdetail,ptype, pstart,pend,client,funding_agency,contractor,pcost,sector_id,country_id,location,consultant,smec_code)VALUES('$txtpcode','$txtpdetail','$ptype','$txtpstart','$txtpend','$client','$funding_agency','$contractor','$pcost','$sector_id','$country_id','$location','$consultant','$smec_code')");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$pid = $txtid;
	
	 #Check if the new dates are added
			$arr_yh_title 	= $_POST['yh_title'];
			$arr_yh_date 	= $_POST['yh_date'];
			$arr_yh_status 	= $_POST['yh_status'];
			if(count($arr_yh_title) >= 1 && count($arr_yh_date) == count($arr_yh_status)){
				for($i = 0; $i < count($arr_yh_title); $i++){
					if($arr_yh_title[$i] != "" && $arr_yh_date[$i] != "" && $arr_yh_status[$i] != ""){
						
						$yh_title 	= $arr_yh_title[$i];
						$yh_status	= $arr_yh_status[$i];
						$yh_date	= date('Y-m-d',strtotime($arr_yh_date[$i]));
						$yhSQL = ("INSERT INTO yearly_holidays(yh_title,yh_date,yh_status,pid) VALUES('$yh_title','$yh_date','$yh_status',$pid)");
						$objDb->execute($yhSQL);
					}
				}
			}
			$status=0;
			$yhSQLD = ("update weekdays SET status=0");
			$objDb->execute($yhSQLD);
			$arr_working_days 	= $_REQUEST['working_days'];
			$swSQL = " Select * from weekdays";
 			$objDb->query($swSQL);
			 $iwCount = $objDb->getCount( );
			 $wd_id						= $objDb->getField($i,wd_id);
	 		 $wd_day					= $objDb->getField($i,wd_day);
	  		 $status	 				= $objDb->getField($i,status);
			count($arr_working_days);
						foreach($arr_working_days as $work_day)
						{
				$yhSQL = ("update weekdays SET status=1 where wd_id=$work_day ");
						$objDb->execute($yhSQL);
						}
			
////////////////////////// Make Project Data

$pSql="INSERT INTO project_days (pd_date,pd_status) select v.selected_date, if(y.yh_status=0,y.yh_status,w.status)from 
(select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
(select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
(select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
(select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
(select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
(select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v left outer join weekdays w on (WEEKDAY(v.selected_date)=w.wd_day) left outer join yearly_holidays y on (v.selected_date=y.yh_date) 
where v.selected_date between '".$txtpstart."' and '".$txtpend."' order by v.selected_date";
$objDb->execute($pSql);

 $sSQLc = ("INSERT INTO t031project_albums(parent_album,parent_group,pid,album_name,status)VALUES('0','001','1','Photos/Videos','1')");
	$objIC->execute($sSQLc);


//include("basetable.php");
header("location: project_calender.php");
}
$objbck  		= new Database( );
$objrvt1  		= new Database( );
$objrvt2  		= new Database( );
$objrvt3  		= new Database( );
if($revert!="")
{

		$q13="TRUNCATE project";
		$objrvt1 ->query($q13) or die('ERROR');
		$q12="INSERT INTO project SELECT * FROM project_backup";
		$objrvt2 ->query($q12);	
		$q11="TRUNCATE project_backup ";
		$objrvt3 ->query($q11);
		
		$q14="TRUNCATE project_days";
		$objrvt1 ->query($q14) or die('ERROR');
		$q15="INSERT INTO project_days SELECT * FROM project_days_backup";
		$objrvt2 ->query($q15);	
		$q16="TRUNCATE project_days_backup ";
		$objrvt3 ->query($q16);
		

		$q20="TRUNCATE planned";
		$objrvt1 ->query($q20) or die('ERROR');
		$q21="INSERT INTO planned SELECT * FROM planned_backup";
		$objrvt2 ->query($q21);	
		$q22="TRUNCATE planned_backup ";
		$objrvt3 ->query($q22);
		
		
		$q23="TRUNCATE weekdays";
		$objrvt1 ->query($q23) or die('ERROR');
		$q24="INSERT INTO weekdays SELECT * FROM weekdays_backup";
		$objrvt2 ->query($q24);	
		$q25="TRUNCATE weekdays_backup ";
		$objrvt3 ->query($q25);
		
		$q26="TRUNCATE kpiscale";
		$objrvt1 ->query($q26) or die('ERROR');
		$q27="INSERT INTO kpiscale SELECT * FROM kpiscale_backup";
		$objrvt2 ->query($q27);	
		$q28="TRUNCATE kpiscale_backup ";
		$objrvt3 ->query($q28);
		
	header("location: project_calender.php");
	}
if($updateBtn !=""){
	
	$objDbPC 		= new Database( );
	$pid=$edit;
  $uSql ="Update project_currency SET 
			base_cur        		= '$base_cur',
			 cur_1  				= '$cur_1',
			 cur_1_rate             = '$cur_1_rate',
			 cur_2					= '$cur_2',
			 cur_2_rate				= '$cur_2_rate'	,
			 cur_3					= '$cur_3',
			 cur_3_rate				= '$cur_3_rate'				
			where pcid 				= $pid";
		  
 	if($objDbPC->execute($uSql)){
	
		}
	if($txtpstart!=$pstart||$txtpend!=$pend)
	{
		$q1="TRUNCATE project_backup ";
		$objbck ->query($q1);
		$q2="INSERT INTO project_backup SELECT * FROM project";
		$objbck ->query($q2);	
		$q3="TRUNCATE project_days_backup ";
		$objbck ->query($q3);
		$q4="INSERT INTO project_days_backup SELECT * FROM project_days";
		$objbck ->query($q4);	
		$q5="TRUNCATE planned_backup ";
		$objbck ->query($q5);
		$q6="INSERT INTO planned_backup SELECT * FROM planned";
		$objbck ->query($q6);
		$q7="TRUNCATE weekdays_backup ";
		$objbck ->query($q7);
		$q8="INSERT INTO weekdays_backup SELECT * FROM weekdays";
		$objbck ->query($q8);
		$q9="TRUNCATE kpiscale_backup ";
		$objbck ->query($q9);
		$q10="INSERT INTO kpiscale_backup SELECT * FROM  kpiscale";
		$objbck ->query($q10);
		
		
	}
	
	////////////////////// Change Planned Data//////////////////////////
$objDbP 		= new Database( );
$objDbPP		= new Database( );

if($txtpstart>$pstart)
{
$d1_m=date('m',	strtotime($txtpstart));
$d1_y=date('Y',	strtotime($txtpstart));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$txtpstart=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($pstart));
$d2_y=date('Y',	strtotime($pstart));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$pstart=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($txtpstart);
$d2 = strtotime($pstart);
 $min_date = min($d1, $d2);
 $max_date = max($d1, $d2);
$min_date = strtotime("-2 MONTH", $min_date);
$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) < $max_date) {

  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP  -> query($eSqls);
	$iCount = $objDbP->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$aid 	= $objDbP->getField($i,aid);
		$rid 	= $objDbP->getField($i,rid);
		$itemid 	= $objDbP->getField($i,itemid);
		 $planned_date=date('Y-m-d',$min_date);
		 $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		 $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		$qq="DELETE FROM planned WHERE itemid='$itemid ' AND  rid='$rid' AND budgetdate='$planned_date'";
		$objDbPP->execute($qq);
		
	}
 }
   $i++;
}	// end while
}
if($pstart>$txtpstart)
{
$d1_m=date('m',	strtotime($txtpstart));
$d1_y=date('Y',	strtotime($txtpstart));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$txtpstart=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($pstart));
$d2_y=date('Y',	strtotime($pstart));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$pstart=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($txtpstart);
$d2 = strtotime($pstart);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$min_date = strtotime("-2 MONTH", $min_date);
$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP  -> query($eSqls);
	$iCount = $objDbP->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$aid 	= $objDbP->getField($i,aid);
		$rid 	= $objDbP->getField($i,rid);
		$itemid 	= $objDbP->getField($i,itemid);
		 $planned_date=date('Y-m-d',$min_date);
		 $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		 $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		 $qq="INSERT INTO planned (itemid,rid,budgetdate,budgetqty) VALUES ('$itemid ', '$rid', '$planned_date', 0)";
		
		$objDbPP->execute($qq);
	}
 }
   $i++;
}	// end while
}
if($txtpend>$pend)
{
$d1_m=date('m',	strtotime($pend));
$d1_y=date('Y',	strtotime($pend));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$pend=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($txtpend));
$d2_y=date('Y',	strtotime($txtpend));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$txtpend=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($pend);
$d2 = strtotime($txtpend);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$min_date = strtotime("-1 MONTH", $min_date);
//$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP  -> query($eSqls);
	$iCount = $objDbP->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$aid 	= $objDbP->getField($i,aid);
		$rid 	= $objDbP->getField($i,rid);
		$itemid 	= $objDbP->getField($i,itemid);
		 $planned_date=date('Y-m-d',$min_date);
		 $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		 $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		 $qq="INSERT INTO planned (itemid,rid,budgetdate,budgetqty) VALUES ('$itemid ', '$rid', '$planned_date', 0)";
		
		$objDbPP->execute($qq);
	}
 }
   $i++;
}	// end while
}
if($txtpend<$pend)
{
$d1_m=date('m',	strtotime($pend));
$d1_y=date('Y',	strtotime($pend));
$d1_d=cal_days_in_month(CAL_GREGORIAN, $d1_m, $d1_y);
$pend=$d1_y."-".$d1_m."-".$d1_d;
$d2_m=date('m',	strtotime($txtpend));
$d2_y=date('Y',	strtotime($txtpend));
$d2_d=cal_days_in_month(CAL_GREGORIAN, $d2_m, $d2_y);
$txtpend=$d2_y."-".$d2_m."-".$d2_d;
$d1 = strtotime($pend);
$d2 = strtotime($txtpend);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$min_date = strtotime("-2 MONTH", $min_date);
$max_date = strtotime("-1 MONTH", $max_date);
while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
  $eSqls = "Select itemid,aid,rid from activity ";
  $objDbP  -> query($eSqls);
	$iCount = $objDbP->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$aid 	= $objDbP->getField($i,aid);
		$rid 	= $objDbP->getField($i,rid);
		$itemid = $objDbP->getField($i,itemid);
		 $planned_date=date('Y-m-d',$min_date);
		  $planned_date_m=date('m',strtotime($planned_date));
		 $planned_date_y=date('Y',strtotime($planned_date));
		$planned_date_d=cal_days_in_month(CAL_GREGORIAN, $planned_date_m, $planned_date_y);
		  $planned_date=$planned_date_y."-".$planned_date_m."-".$planned_date_d;
		 $qq="DELETE FROM planned WHERE itemid='$itemid ' AND  rid='$rid' AND budgetdate='$planned_date'";
		$objDbPP->execute($qq);
	}
 }
   
}	// end while
}
	
	$pid=$edit;
 $uSql ="Update project SET 
			 pcode         		= '$txtpcode',
			 pdetail  			= '$txtpdetail',
			 ptype  			= '$ptype',
			 client             = '$client',
			 funding_agency		= '$funding_agency',
			 contractor			= '$contractor',
			 pcost				= '$pcost',
			 sector_id			= '$sector_id',
			 country_id			= '$country_id',
			 location           = '$location',
			 consultant			= '$consultant',
			 smec_code			= '$smec_code',
			 pstart				= '$txtpstart',
			 pend				= '$txtpend'				
			where pid 			= $edit ";
		  
 	if($objDb->execute($uSql)){
	$eSql_l = "Select * from project where pid='$edit'";
  	$objDb -> query($eSql_l);
  	$eCount1 = $objDb->getCount();
		}
		# See if any child to be deleted (checked for deletion)
			$arr_yh_ids = $_POST['yh_id'];
			if(count($arr_yh_ids) >= 1){
				for($i = 0; $i < count($arr_yh_ids); $i++){
					$yh_id 	= $arr_yh_ids[$i];
					 $yhDSQL = ("DELETE FROM yearly_holidays where yh_id=$yh_id");
						$objDb->execute($yhDSQL);
				}
			}
			# See if any sizes are updated
			$swwSQL = " Select * from yearly_holidays ";
							 $objSDb->query($swwSQL);
							  $iiCount = $objSDb->getCount( );
					 if($iiCount>0)
					 {
						for ($j = 0 ; $j < $iiCount; $j ++)
						{
							
						 $yh_id= $objSDb->getField($j,yh_id);
						if($_POST['yh_title_' . $yh_id] && $_POST['yh_date_'. $yh_id])
						{
							
						$yh_title 	= $_POST['yh_title_' .$yh_id];
						$yh_status	= $_POST['yh_status_' . $yh_id];
						$yh_date 	= date('Y-m-d',strtotime($_POST['yh_date_' . $yh_id]));
						$yhSQL = ("Update yearly_holidays SET yh_title='$yh_title',yh_date='$yh_date',yh_status='$yh_status'  where yh_id=$yh_id");
						$objDb->execute($yhSQL);
						
					  }
				}
			}
			
	 #Check if the new dates are added
			$arr_yh_title 	= $_POST['yh_title'];
			$arr_yh_date 	= $_POST['yh_date'];
			$arr_yh_status 	= $_POST['yh_status'];
			if(count($arr_yh_title) >= 1 && count($arr_yh_date) == count($arr_yh_status)){
				for($i = 0; $i < count($arr_yh_title); $i++){
				if($arr_yh_title[$i] != "" && $arr_yh_date[$i] != "" && $arr_yh_status[$i] != ""){
						$yh_title 	= $arr_yh_title[$i];
						$yh_status	= $arr_yh_status[$i];
						$yh_date	= date('Y-m-d',strtotime($arr_yh_date[$i]));
						 $yhSQL = ("INSERT INTO yearly_holidays(yh_title,yh_date,yh_status,pid) VALUES('$yh_title','$yh_date','$yh_status',$pid)");
						$objDb->execute($yhSQL);
					}
				}
			}
	$status=0;
			$arr_working_days 	= $_REQUEST['working_days'];
			$swSQL = " Select * from weekdays";
 			$objDb->query($swSQL);
			 $iwCount = $objDb->getCount( );
		
				  $yhSQLD = ("update weekdays SET status=0");
				 $objDb->execute($yhSQLD);
			
			 $wd_id						= $objDb->getField($i,wd_id);
	 		 $wd_day					= $objDb->getField($i,wd_day);
	  		 $status	 				= $objDb->getField($i,status);
			
						foreach($arr_working_days as $work_day)
						{
			$yhSQL = ("update weekdays SET status=1 where wd_id=$work_day ");
				
						$objDb->execute($yhSQL);
						}
						$objDb->execute("TRUNCATE project_days");
						$pSql="INSERT INTO project_days (pd_date,pd_status) select v.selected_date, if(y.yh_status=0,y.yh_status,w.status)from 
(select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
(select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
(select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
(select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
(select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
(select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v left outer join weekdays w on (WEEKDAY(v.selected_date)=w.wd_day) left outer join yearly_holidays y on (v.selected_date=y.yh_date) 
where v.selected_date between '".$txtpstart."' and '".$txtpend."' order by v.selected_date";
$objDb->execute($pSql);
/*if($txtpstart!=$pstart||$txtpend!=$pend)
	{*/
//include("basetable_update.php");
	//}

header("location: project_calender.php");
}