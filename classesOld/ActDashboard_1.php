<?php

class ActDashboard extends Database{

    /**
	* This is the constructor of the class KfiDashboard
	*/
	public function __construct(){
		parent::__construct();
	}

    public function getAllParentCd()
	{

        $Sql = "SELECT 
		a.parentcd
		FROM maindata a";

        return $this->dbQuery($Sql);
    }
    public function getParentCById()
	{
        $itemid = $this->getProperty("itemid");

        $Sql = "SELECT 
		a.parentcd
		FROM maindata a WHERE a.itemid=".$itemid;

        return $this->dbQuery($Sql);
    }

    public function getActvityLevel()
	{
        $proid = $this->getProperty("prolvlid");
		

        $Sql = "SELECT 
		a.itemid, 
		a.parentcd, 
		a.parentgroup, 
		a.activitylevel,
        a.stage,
        a.factor,
        a.itemcode,
        a.itemname,
        a.weight,
        a.isentry,
        a.resources,
        a.aorder
		FROM maindata a
				WHERE 
                a.parentcd=".$proid;;

        return $this->dbQuery($Sql);
        
    }
    public function getDataFromBoq()
	{
        $boqitemid = $this->getProperty("boqitemid");

       //$Sql = "SELECT * FROM boq a WHERE a.itemid=".$boqitemid;
       $Sql = "SELECT (boq_cur_1_rate*boqqty) as x, (boq_cur_2_rate*boqqty) as y FROM boq WHERE itemid=".$boqitemid;

        return $this->dbQuery($Sql);
        
    }

    public function getDataFromBoqMonthlyIpc()
	{
        $boqitemid = $this->getProperty("boqitemid");

        $Sql = "SELECT (a.boq_cur_1_rate*a.boqqty) as x, (a.boq_cur_2_rate*a.boqqty) as y,(a.boq_cur_1_rate*b.ipcqty) as xx,(a.boq_cur_2_rate*b.ipcqty) as yy FROM ipcv b  INNER JOIN boq a ON b.boqid=a.boqid WHERE a.itemid=".$boqitemid; 
        return $this->dbQuery($Sql);
        
    }
    

    public function getItemsWithIstype1()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT 
		a.itemid,a.parentgroup
		FROM maindata a
				WHERE 
                a.parentgroup LIKE '%".$parentgroup."%'"." AND a.isentry=1";

        return $this->dbQuery($Sql);
        
    }

    public function getParentGroup()
	{
        $itemids = $this->getProperty("itemids");

        $Sql = "SELECT 
		a.parentgroup
		FROM maindata a
				WHERE 
                a.itemid=".$itemids;

        return $this->dbQuery($Sql);
        
    }


    // Default Loading Page
    public function getActivity_LevelData()
	{
        $itemids = $this->getProperty("itemids");
        $Sql = "SELECT *
        FROM maindata
        WHERE parentcd = ".$itemids." 
        UNION ALL
        SELECT *
        FROM maindata
        WHERE itemid = ".$itemids." AND
              NOT EXISTS (SELECT 1 FROM maindata WHERE parentcd = ".$itemids.")";

        return $this->dbQuery($Sql);
        
    }

    public function getItemsWithIstype2()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT 
		a.itemid,a.parentgroup
		FROM maindata a
				WHERE 
                a.parentgroup LIKE '%".$parentgroup."%'"." AND a.isentry=1";

        return $this->dbQuery($Sql);
        
    }

    public function getItemName()
	{
        $activitylevel = $this->getProperty("activitylevel");

        $Sql = "SELECT 
		*
		FROM maindata a
				WHERE 
                a.activitylevel=".$activitylevel;

        return $this->dbQuery($Sql);
        
    }

    public function getAllActivityLevels()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT 
        DISTINCT a.activitylevel
		FROM maindata a
				WHERE
                a.parentgroup LIKE '%".$parentgroup."%' ORDER BY a.activitylevel ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllActivityLevels2()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT *
		FROM maindata a
				WHERE
                a.parentgroup LIKE '%".$parentgroup."%' ORDER BY a.activitylevel ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllDataOrderByItemid()
	{
        $Sql = "SELECT * FROM maindata ORDER BY itemid ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllDataOrderByAorder()
	{
        $Sql = "SELECT * FROM maindata ORDER BY aorder ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllIpcNo()
	{
    
        $Sql = "SELECT * FROM ipc WHERE ipcno LIKE '%IPC-%'  ORDER BY ipcid ASC ";

        return $this->dbQuery($Sql);
        
    }

    public function getLastIpcNo()
	{
		
    
        $Sql = "SELECT * FROM ipc WHERE 1=1  ";
		
		
		if($this->isPropertySet("ipcno", "V"))
			$Sql .= " AND ipcno='" . $this->getProperty("ipcno")."'";
			
		
		if($this->isPropertySet("ipcmonth", "V"))
			$Sql .= " AND ipcmonth='" . $this->getProperty("ipcmonth")."'";
			
		
		if($this->isPropertySet("lid", "V"))
			$Sql .= " AND lid=" . $this->getProperty("lid");
			
			
			$Sql .= " ORDER BY ipcid ";

        return $this->dbQuery($Sql);
        
    }

    public function getSecondLastIpcNo()
	{
    
         $Sql = "SELECT  ipcno, ipcid, ipcmonth, ipcsubmitdate, ipcstartdate, ipcenddate, ipcsubmitdate, lid, status, ipcreceivedate FROM ipc WHERE 1=1  ";
		
		
		if($this->isPropertySet("lastipcno", "V"))
			$Sql .= " AND ipcno='" . $this->getProperty("lastipcno")."'";
			
		
		//if($this->isPropertySet("ipcmonth", "V"))
		//	$Sql .= " AND ipcmonth='" . $this->getProperty("ipcmonth")."'";
			
		
		if($this->isPropertySet("lid", "V"))
			$Sql .= " AND lid=" . $this->getProperty("lid");
			
			
			$Sql .= "  ORDER BY ipcid  ";

       
	

        return $this->dbQuery($Sql);
        
    }

    public function getAllIpcV()
	{
      $Sql = "SELECT (a.boq_cur_1_rate*b.ipcqty) as zp, (a.boq_cur_2_rate*b.ipcqty) as qu FROM boq a INNER JOIN ipcv b ON a.boqid=b.boqid WHERE 1=1  ";
		
		
		if($this->isPropertySet("itemid", "V"))
			$Sql .= " AND a.itemid='" . $this->getProperty("itemid")."'";
			
			
		
		if($this->isPropertySet("lastipcid", "V"))
			$Sql .= " AND b.ipcid<=" . $this->getProperty("lastipcid");
			
			
			$Sql .= " ORDER BY b.ipcid ";
			
			 return $this->dbQuery($Sql);
    }
	
	  public function getAllIpcV_old()
	{
        $itemid = $this->getProperty("itemid");
        $lastipcid = $this->getProperty("lastipcid");

        //$Sql = "SELECT * FROM ipcv a WHERE a.ipcid < ".$lastipcid." AND a.boqid=".$boqid;
        
       $Sql = "SELECT (a.boq_cur_1_rate*b.ipcqty) as zp, (a.boq_cur_2_rate*b.ipcqty) as qu FROM boq a INNER JOIN ipcv b ON a.boqid=b.boqid WHERE a.itemid=".$itemid." AND b.ipcid<".$lastipcid;
       
        //$Sql = "SELECT SUM(boq.boq_cur_1_rate*ipcv.ipcqty) as x,SUM(boq.boq_cur_2_rate*ipcv.ipcqty) as y FROM boq INNER JOIN ipcv ON boq.boqid=ipcv.boqid WHERE ipcv.ipcid < ".$lastipcid." AND boq.boqid=".$boqid;
        
        return $this->dbQuery($Sql);
        
    }
	
	 public function getAllIpcVExup_old()
	{
        $itemid = $this->getProperty("itemid");
        $lastipcid = $this->getProperty("lastipcid");

        //$Sql = "SELECT * FROM ipcv a WHERE a.ipcid <= ".$lastipcid." AND a.boqid=".$boqid;
        $Sql = "SELECT (a.boq_cur_1_rate*b.ipcqty) as xx,(a.boq_cur_2_rate*b.ipcqty) as yy FROM boq a INNER JOIN ipcv b ON a.boqid=b.boqid WHERE a.itemid=".$itemid." AND b.ipcid = ".$lastipcid;
       
        return $this->dbQuery($Sql);
        
    }

    public function getAllIpcVExup()
	{
        $Sql = "SELECT (a.boq_cur_1_rate*b.ipcqty) as xx,(a.boq_cur_2_rate*b.ipcqty) as yy FROM boq a INNER JOIN ipcv b ON a.boqid=b.boqid WHERE 1=1  ";
		
		
		if($this->isPropertySet("itemid", "V"))
			$Sql .= " AND a.itemid='" . $this->getProperty("itemid")."'";
			
			
		
		if($this->isPropertySet("lastipcid", "V"))
			$Sql .= " AND b.ipcid=" . $this->getProperty("lastipcid");
			
			
			$Sql .= " ORDER BY b.ipcid ";

        
       
        return $this->dbQuery($Sql);
        
    }

    public function getAllIpcVPIn_old()
	{
        $itemid = $this->getProperty("itemid");
        $lastipcid = $this->getProperty("lastipcid");

        //$Sql = "SELECT * FROM ipcv a WHERE a.ipcid = ".$lastipcid." AND a.boqid=".$boqid;
        $Sql = "SELECT (a.boq_cur_1_rate*b.ipcqty) as xx,(a.boq_cur_2_rate*b.ipcqty) as yy FROM boq a INNER JOIN ipcv b ON a.boqid=b.boqid WHERE a.itemid=".$itemid." AND b.ipcid <= ".$lastipcid;
       
        return $this->dbQuery($Sql);
        
    }

    public function getAllIpcVPIn()
	{
        
		
        $Sql = "SELECT (a.boq_cur_1_rate*b.ipcqty) as xx,(a.boq_cur_2_rate*b.ipcqty) as yy FROM boq a INNER JOIN ipcv b ON a.boqid=b.boqid WHERE 1=1  ";
		
		
		if($this->isPropertySet("itemid", "V"))
			$Sql .= " AND a.itemid='" . $this->getProperty("itemid")."'";
			
			
		
		if($this->isPropertySet("lastipcid", "V"))
			$Sql .= " AND b.ipcid<=" . $this->getProperty("lastipcid");
			
			
			$Sql .= " ORDER BY b.ipcid ";

        
       
        return $this->dbQuery($Sql);
        
    }

    public function getIpcvQty()
	{
        $boqidd = $this->getProperty("boqidd");

        $Sql = "SELECT * FROM ipcv WHERE boqid= ".$boqidd;
       
        return $this->dbQuery($Sql);
        
    }

    public function getBoqid()
	{
        $itemid = $this->getProperty("itemid");

        $Sql = "SELECT * FROM boq WHERE itemid= ".$itemid;
       
        return $this->dbQuery($Sql);
        
    }
	function CalculateActualPlannedDays($enddate,$startdate)
{
	$enddate=date('Y-m-d',strtotime($enddate));
	 $m=date('m',strtotime($enddate));
	 $y=date('Y',strtotime($enddate));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $enddate=$y."-".$m;
	 $startdate=date('Y-m-d',strtotime($startdate));
	 $m=date('m',strtotime($startdate));
	 $y=date('Y',strtotime($startdate));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $startdate=$y."-".$m;
$reportquery ="SELECT sum(wdays) as total_planned_days FROM kpiscale WHERE scmonth>='".$startdate."'". " AND scmonth<='".$enddate."'";
$reportresult = $this->dbQuery($reportquery);
if($reportresult!=0)
{
$reportdata = $this->dbFetchArray();
$total_planned_days=$reportdata["total_planned_days"];
}
else
{
	$total_planned_days=0;
}
return $total_planned_days;
}
function GetlastDateOutput($itemid)
{
$sql="select max(progressmonth) as last_date from activity where itemid=".$itemid ;
 $this->dbQuery($sql);
 $amountresult=$this->totalRecords();
 if($amountresult!=0)
 {
 $data=$this->dbFetchArray();
 $actual_finish_date=$data["last_date"];
 $fmonth= date('m',strtotime($actual_finish_date));
		$fyear= date('Y',strtotime($actual_finish_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_finish_date=$fyear."-".$fmonth."-".$fmonth_days;
 }
 else
 {
	 $actual_finish_date=0;
 }

return $actual_finish_date;
	} 
	
function ActualStartDateOutput($parentgroup)
{
$sql="select min(progressdate) as actual_start_date from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)" ;
 $this->dbQuery($sql);
 $amountresult=$this->totalRecords();
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=$this->dbFetchArray();
 $actual_start_date=$data["actual_start_date"];
 $fmonth= date('m',strtotime($actual_start_date));
		$fyear= date('Y',strtotime($actual_start_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_start_date=$fyear."-".$fmonth."-".$fmonth_days;
 }
 else
 {
	 $actual_start_date=0;
 }

return $actual_start_date;
	} 
	
function ActualProgressOutput($parentgroup)
{

$actual_prog_perc=0;
$actual_prog=0;
$total_actual_prog=0;
$reportquery="select sum(c.progressqty) as total_till_today_qty ,c.itemid,c.progressdate from progress c where  itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b) GROUP BY c.itemid";
 $this->dbQuery($reportquery);
$amountresult=$this->totalRecords();
if($amountresult!=0)
{
while($reportdata = $this->dbFetchArray())
{
	$wgt_query="select weight from maindata where itemid=".$reportdata["itemid"];
	 $this->dbQuery($wgt_query);
	$wgtdata= $this->dbFetchArray();
	$weight=$wgtdata["weight"];
	$bs_query="select baseline from activity where itemid=".$reportdata["itemid"];
	$this->dbQuery($bs_query);
	$basedata= $this->dbFetchArray();
	$baseline=$basedata["baseline"];
	$total_till_today_qty= $reportdata["total_till_today_qty"];
	//$planned_prog=($total_planned_qty/$baseline)*$weight;
	$actual_prog=($total_till_today_qty);
	//echo "<br/>";
	$total_actual_prog +=$actual_prog;
}
$actual_prog_perc=$total_actual_prog;
}
else
{
	$actual_prog_perc=0;
}
return $actual_prog_perc;
}
function PlannedProgressOutput($itemid,$current_date,$planned_end_date, $planned_start_date,$isentry)
{
	
	$planned_prog=0;
	if($isentry==1)
	{
	   $reportquery="select sum(c.budgetqty) as total_planned_qty ,c.itemid,c.budgetdate from planned c where budgetdate>='".$planned_start_date."' AND budgetdate<='".$current_date."' "." AND itemid=".$itemid;
	  
	}
	else
	{
		 $reportquery="select sum(c.total_baseline) as total_planned_qty ,c.itemid,c.budgetdate from activity0 c where budgetdate>='".$planned_start_date."' AND budgetdate<='".$planned_end_date."' "." AND itemid=".$itemid;
	}

$this->dbQuery($reportquery);
$amountresult=$this->totalRecords();
if($amountresult!=0)
{
while($reportdata =$this->dbFetchArray())
{

	$total_planned_qty= $reportdata["total_planned_qty"];
	$planned_prog=($total_planned_qty);
	$total_planned_prog +=$planned_prog;
}
 $planned_prog_perc=$total_planned_prog;
}
else
{
	$planned_prog_perc=0;
}
return $planned_prog_perc;
}

function ActualFinishDateActivity($aid)
{
 $reportquery="SELECT max(b.progressdate) as actual_finish_date from maindata a inner join progress b on(a.itemid=b.itemid) where a.itemid=".$aid ;
 $this->dbQuery($reportquery);
 $amountresult=$this->totalRecords();
if($amountresult!=0)
{
$reportdata = $this->dbFetchArray();
$actual_finish_date= $reportdata["actual_finish_date"];
$fmonth= date('m',strtotime($actual_finish_date));
		$fyear= date('Y',strtotime($actual_finish_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_finish_date=$fyear."-".$fmonth."-".$fmonth_days;
}
else
{
	$actual_finish_date="";
}
return $actual_finish_date;
}
function CalculateElapsedDays($enddate,$startdate)
{
$reportquery ="SELECT count(pd_date) as total_planned_days FROM project_days WHERE pd_status=1 AND pd_date>='".$startdate."'". " AND pd_date<='".$enddate."'";
$this->dbQuery($reportquery);
 $amountresult=$this->totalRecords();
if($amountresult!=0)
{
$reportdata = $this->dbFetchArray();
$total_planned_days=$reportdata["total_planned_days"];
}
else
{
	$total_planned_days=0;
}
return $total_planned_days;
}
function GetActualQtysOutputLevelG($aparentgroup,$aweight)
{
// Get Plan Scale
$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$this->dbQuery($scale_query);
 $amountresult=$this->totalRecords();
	$reportdata_scale=$this->dbFetchArray();
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	 $till_today_qty=$this->ActualProgressOutput($aparentgroup);
					
					
	return $till_today_qty;
}
function  GetPlannedQtysOutputLevelG($aparentgroup)
{

$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$this->dbQuery($scale_query);
     $amountresult=$this->totalRecords();
	$reportdata_scale=$this->dbFetchArray();
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
	 $last_date=date('Y-m-d',strtotime($reportdata_scale['enddate']));;
  	$start_date=$syear."-".$smonth."-30";
	$planned_progress=$this->PlannedProgressOutput($aparentgroup,$last_date,$reportdata_scale['startdate']);
					
					
	return $planned_progress;
}
function GetActualQtysOutputLevel($aparentgroup,$temp_id)
{

	// Get Plan Scale
$scale_query="Select max(progressdate) as enddate , min(progressdate) as startdate from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)";
	$this->dbQuery($scale_query);
     $amountresult=$this->totalRecords();
	$reportdata_scale=$this->dbFetchArray();
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= $this->dateRange($start_date, $reportdata_scale['enddate']);
				$num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				 $total_actual_perc=0;
				  $actual_perc=0;
				  $actual=0; 
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
				      $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
				      $scale_datef=$vyear.$vmonth.$vmonth_days;
					   $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 AND a.temp_id='$temp_id' GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
					
					  $reportresult = $this->dbQuery($reportquery);		
					  while ($reportdata = $this->dbFetchArray()) {
						
						   $actual_progress= $this->ActualProgressBase($reportdata['itemid'],$scale_datef,$reportdata['rid']);
						   //$item_factor=GetFactor($reportdata['itemid']);
						   $actual_perc=$actual_progress;
						   $total_actual_perc +=$actual_perc;
						   
					}
					
					$actual +=$total_actual_perc;
				
					if($actual!=0 && $actual!=""&& $actual!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($actual)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_actual_perc=0;
				  $actual_perc=0;
				 // $actual=0; 
			  }
					
					
	return $code_str;
}
 function dateRange($first, $last, $step = '+1 month', $format = 'Y-m-d H:i:s' ) {
    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);
	
    while( $current <= $last ) {	
        $dates[] = date($format, $current);
        $current = strtotime($step, $current);
    }
    return $dates;
}

function ActualProgressBase($aid,$actual_start_date,$rid)
{
$lastMonth=date('Y-m-d',strtotime($actual_start_date));
	 $m=date('m',strtotime($lastMonth));
	 $y=date('Y',strtotime($lastMonth));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $actual_start_date=$y."-".$m."-".$days;
   //$actual_start_date = str_replace("-","",$actual_start_date);	
 $reportquery ="SELECT total_actual as total_till_today_qty FROM kpi_total_baseline WHERE itemid=".$aid. " AND rid=".$rid . " AND progress_month='".$actual_start_date."'";
$this->dbQuery($reportquery);
     $amountresult=$this->totalRecords();
if($amountresult!=0)
{
$reportdata = $this->dbFetchArray();
$total_till_today_qty= $reportdata["total_till_today_qty"];

}
else
{
	$total_till_today_qty=0;
}
return $total_till_today_qty;
}
function PlannedProgressBase($aid,$planned_date,$rid)
{
	$lastMonth=date('Y-m-d',strtotime($planned_date));
	 $m=date('m',strtotime($lastMonth));
	 $y=date('Y',strtotime($lastMonth));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $planned_date=$y."-".$m."-".$days;
    
	$reportquery ="SELECT total_planned as total_planned_qty FROM kpi_total_baseline WHERE itemid=".$aid. " AND rid=".$rid . " AND progress_month='".$planned_date."'";
   
$this->dbQuery($reportquery);
     $amountresult=$this->totalRecords();
if($amountresult!=0)
{
$reportdata = $this->dbFetchArray();

 $total_planned_qty= $reportdata["total_planned_qty"];

}
else
{
	$total_planned_qty=0;
}
return $total_planned_qty;
}
function GetPlannedQtysOutputLevel($parentgroup,$itemid,$current_date,$planned_end_date, $planned_start_date,$isentry)
{
	//echo $current_date;
	$this->dbQuery("TRUNCATE activity_dashboard_graph");
	$smonth= date('m',strtotime($planned_start_date));
  	$syear= date('Y',strtotime($planned_start_date));
  	$planned_start_date=$syear."-".$smonth."-01";
	 $dates=array();
				$dates_planned= $this->dateRange($planned_start_date, $planned_end_date);
			    $num=sizeof($dates_planned);
				$dates_actual= $this->dateRange($planned_start_date, $current_date);
			    $nump=sizeof($dates_actual);
				//print_r($dates);
				  $ii=0;
				  $total_planned_perc=0;
				  $planned_perc=0;
				  $actual_progress=0;
				  $total_progress=0;
				  $gtotal=0;
				  $gtotalp=0;
				  $planned=0;
				   $t_reportquery="select sum(baseline) as total_planned_qty  from activity";
				  $this->dbQuery($t_reportquery);	
				  $reportresult_total=$this->dbFetchArray();
				  $total_baseline=$reportresult_total['total_planned_qty'];
				foreach($dates_planned as $values)
				{	
				$ii++;
				
					  $lastMonth=date('Y-m-d',strtotime($values));
	 $m=date('m',strtotime($values));
	 $y=date('Y',strtotime($values));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $scale_datef=$y."-".$m."-".$days;
					  					  	
						if($isentry==1)
						{
			 $reportquery="select sum(c.budgetqty) as total_planned_qty ,c.itemid,c.budgetdate from planned c where budgetdate='".$scale_datef."'  AND itemid=".$itemid;
						  
						}
						else
						{
			   $reportquery="select sum(a.budgetqty) as total_planned_qty ,a.itemid,a.budgetdate From planned a where a.budgetdate='".$scale_datef."' AND a.itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%'  GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel);";
		
						}
					  $reportresult = $this->dbQuery($reportquery);			
					  $reportdata =$this->dbFetchArray();
						
						  $planned_progress=$reportdata['total_planned_qty'];
						  
			               if($total_baseline!=0)
						   {
						  $total_planned_perc= $planned_progress/$total_baseline*100;
						  
						  $gtotal=$gtotal+$total_planned_perc;
						 						  
						   }
						  if($gtotal!=0)
						  {
							  $gtotal=number_format($gtotal,4);
							  
						   $insert_query="INSERT INTO activity_dashboard_graph (a_month,planned,actual) Values ('".$scale_datef."',".$gtotal.",".$gtotalp.")";
						   $this->dbQuery($insert_query);	
						  }
					
					 
					
				  
			  }
			  	foreach($dates_actual as $values)
				{	
				$ii++;
				
					  $lastMonth=date('Y-m-d',strtotime($values));
	 $m=date('m',strtotime($values));
	 $y=date('Y',strtotime($values));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $scale_datef=$y."-".$m."-".$days;
					  					  	
						if($isentry==1)
						{
			 $reportquery="select c.itemid,c.budgetdate,sum(c.actual_qty) as total_progress_qty from planned c where budgetdate='".$scale_datef."'  AND itemid=".$itemid;
						  
						}
						else
						{
			   $reportquery="select a.itemid,a.budgetdate, sum(a.actual_qty) as total_progress_qty From planned a where a.budgetdate='".$scale_datef."' AND a.itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%'  GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel);";
		//echo  $reportquery="select sum(c.total_baseline) as total_planned_qty ,c.itemid,c.budgetdate,sum(c.total_progress) as total_progress_qty from activity0 c where budgetdate='".$scale_datef."'  AND itemid=".$itemid;
		//echo "<br/>";
						}
					  $reportresult = $this->dbQuery($reportquery);			
					  $reportdata =$this->dbFetchArray();
						
						  $actual_progress=$reportdata['total_progress_qty'];
			               if($total_baseline!=0)
						   {
						  $total_actual_perc= $actual_progress/$total_baseline*100;
						  $gtotalp=$gtotalp+$total_actual_perc;
						   }
						  if($gtotalp!=0)
						  {
							  $gtotalp=number_format($gtotalp,4);
							  
						   $insert_query="UPDATE activity_dashboard_graph SET actual=".$gtotalp." WHERE a_month='".$scale_datef."'";
						   $this->dbQuery($insert_query);	
						  }
					
					 
					
				  
			  }
		
	
}
}


?>