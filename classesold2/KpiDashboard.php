<?php

class KpiDashboard extends Database{

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
		FROM kpidata a";

        return $this->dbQuery($Sql);
    }
    public function getParentCById()
	{
        $itemid = $this->getProperty("itemid");

        $Sql = "SELECT 
		a.parentcd
		FROM kpidata a WHERE a.itemid=".$itemid;

        return $this->dbQuery($Sql);
    }

    public function getActvityLevel()
	{
        $proid = $this->getProperty("prolvlid");
		

        $Sql = "SELECT 
		a.kpiid, 
		a.parentcd, 
		a.parentgroup, 
		a.activitylevel,
        a.itemcode,
        a.itemname,
        a.weight,
        a.isentry,
        a.aorder,
		a.kpi_temp_id,
		a.lid
		FROM kpidata a
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
		FROM kpidata a
				WHERE 
                a.parentgroup LIKE '%".$parentgroup."%'"." AND a.isentry=1";

        return $this->dbQuery($Sql);
        
    }

    public function getParentGroup()
	{
        $itemids = $this->getProperty("itemids");

        $Sql = "SELECT 
		a.parentgroup
		FROM kpidata a
				WHERE 
                a.itemid=".$itemids;

        return $this->dbQuery($Sql);
        
    }


    // Default Loading Page
    public function getActivity_LevelData()
	{
        $itemids = $this->getProperty("itemids");
        $Sql = "SELECT *
        FROM kpidata
        WHERE parentcd = ".$itemids." 
        UNION ALL
        SELECT *
        FROM kpidata
        WHERE itemid = ".$itemids." AND
              NOT EXISTS (SELECT 1 FROM kpidata WHERE parentcd = ".$itemids.")";

        return $this->dbQuery($Sql);
        
    }

    public function getItemsWithIstype2()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT 
		a.itemid,a.parentgroup
		FROM kpidata a
				WHERE 
                a.parentgroup LIKE '%".$parentgroup."%'"." AND a.isentry=1";

        return $this->dbQuery($Sql);
        
    }

    public function getItemName()
	{
        $activitylevel = $this->getProperty("activitylevel");

        $Sql = "SELECT 
		*
		FROM kpidata a
				WHERE 
                a.activitylevel=".$activitylevel;

        return $this->dbQuery($Sql);
        
    }

    public function getAllActivityLevels()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT 
        DISTINCT a.activitylevel
		FROM kpidata a
				WHERE
                a.parentgroup LIKE '%".$parentgroup."%' ORDER BY a.activitylevel ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllActivityLevels2()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT *
		FROM kpidata a
				WHERE
                a.parentgroup LIKE '%".$parentgroup."%' ORDER BY a.activitylevel ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllDataOrderByItemid()
	{
        $Sql = "SELECT * FROM kpidata ORDER BY itemid ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllDataOrderByAorder()
	{
        $Sql = "SELECT * FROM kpidata ORDER BY aorder ASC";

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
$reportquery ="SELECT count(pd_date) as total_planned_days FROM project_days WHERE pd_status=1 AND pd_date>='".$startdate."'". " AND pd_date<='".$enddate."'";
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
function GetlastDateOutput($parentgroup)
{
$sql="select max(progressdate) as last_date from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b)" ;
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
$sql="select min(progressdate) as actual_start_date from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b)" ;
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
$reportquery="select sum(c.progressqty) as total_till_today_qty ,c.itemid,c.progressdate from progress c where  itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b) GROUP BY c.itemid";
 $this->dbQuery($reportquery);
$amountresult=$this->totalRecords();
if($amountresult!=0)
{
while($reportdata = $this->dbFetchArray())
{
	$wgt_query="select weight from kpidata where itemid=".$reportdata["itemid"];
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
function PlannedProgressOutput($parentgroup,$current_date,$planned_start_date)
{
	
	$planned_prog=0;
	 $reportquery="select sum(c.budgetqty) as total_planned_qty ,c.itemid,c.budgetdate from planned c where budgetdate>='".$planned_start_date."' AND budgetdate<='".$current_date."' "." AND itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b) GROUP BY c.itemid";
	
	

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
 $reportquery="SELECT max(b.progressdate) as actual_finish_date from kpidata a inner join progress b on(a.itemid=b.itemid) where a.itemid=".$aid ;
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
/*$scale_query="Select max(progressdate) as enddate , min(progressdate) as startdate from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b)";*/
$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b";
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

$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b";
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
$scale_query="Select max(progressdate) as enddate , min(progressdate) as startdate from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b)";
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
					   $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 AND a.temp_id='$temp_id' GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b";
					
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
function GetPlannedQtysOutputLevel($aparentgroup,$temp_id)
{
	
	
	// Get Plan Scale
	$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY kpidata.activitylevel)) b";
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
				  $total_planned_perc=0;
				  $planned_perc=0;
				  $planned=0;
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					  $scale_datef=$vyear.$vmonth.$vmonth_days;
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN 
					  (SELECT itemid FROM kpidata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 AND a.temp_id='$temp_id' GROUP BY activitylevel, parentcd 
					  ORDER BY kpidata.activitylevel)) b";
					  $reportresult = $this->dbQuery($reportquery);			
					  while ($reportdata =$this->dbFetchArray()) {
						
						  $planned_progress=$this->PlannedProgressBase($reportdata['itemid'],$scale_datef,$reportdata['rid']);
						  
						  //$item_factor=GetFactor($reportdata['itemid']);
						  $planned_perc=$planned_progress;
						  $total_planned_perc +=$planned_perc;
						   
					}
					 $planned +=$total_planned_perc;
				    // echo "<br/>";
					/*if($planned!=0 && $planned!=""&& $planned!=NULL)
					{*/
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($planned)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					//}
					
				   $total_planned_perc=0;
				  $planned_perc=0;
				 // $planned=0; 
			  }
		 $code_str;		
					
	return $code_str;
}
function getProjectCommProgC($scid,$kpiid,$scmonth)
{
	 $vmonth= date('m',strtotime($scmonth));
					  $vyear= date('Y',strtotime($scmonth));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scmonth=$scmonth."-".$vmonth_days;
					 
					 
					 
	  $sql="SELECT sum(a.perc_actual) as milestone_actual  FROM kpidata0 a WHERE a.kpiid=".$kpiid." AND a.budgetdate<='$scmonth' ";

 
 $this->dbQuery($sql);
 $amountresult=$this->totalRecords();
if($amountresult!=0)
{
 $data=$this->dbFetchArray();
 
 $milestone_targets=$data["milestone_actual"];
 
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
}
function getComponentCommProgC($lastMonth,$data_level_id,$latest_month)
{

$latest_achieved=0;
$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, sum(b.baseline) as baseline,z.parentgroup,z.activitylevel FROM maindata z left outer join kpi_activity a on (z.itemid=a.kpiid) left outer join activity b on (a.activityid=b.aid) left outer join mildata c on (b.itemid=c.itemid AND b.rid=c.rid) where z.parentcd=".$data_level_id." Group by z.itemid";
$this->dbQuery($sql);
 $counter=$this->totalRecords();

while ($reportdata =$this->dbFetchArray()) {
	 //$latest_month=getLatestMonth($reportdata['aid']);
  if($latest_month!=0)
  {
  $latest_achieved=getSubComponentCommProgC($lastMonth,$reportdata['itemid'],$latest_month);
  }
if($latest_achieved!=0)
 {
 $comm_progress+=($latest_achieved)*($reportdata['weight']/100);
 $latest_achieved=0;
 }
 
}
if($comm_progress!=0)
{
	$res=$comm_progress;
}
else
{
	$res=0;
}
return $res;
}
function getSubComponentCommProgC($lastMonth,$data_level_id,$latest_month)
{

$latest_achieved=0;
$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, sum(b.baseline) as baseline,z.parentgroup, z.activitylevel FROM maindata z inner join kpi_activity a on (z.itemid=a.kpiid) inner join activity b on (a.activityid=b.aid) inner join mildata c on (b.itemid=c.itemid AND b.rid=c.rid) where z.parentcd=".$data_level_id."  Group by z.itemid";
//$reportquery ="SELECT aid, baseline as milestoneBaseline, assig FROM mis_tbl_4_milstones where s_id=".$s_id." Group by s_id,aid order by s_id";
$this->dbQuery($sql);
 $counter=$this->totalRecords();
while ($reportdata = $this->dbFetchArray()) {
	$baseline=$reportdata['baseline'];
  if($latest_month!=0)
  {
  $ptodate=getMilestoneTotalAchieveCLatest($latest_month,$reportdata['itemid']);
  }
if($ptodate!=0&&$baseline!=0)
 {
	 $comm_progress+=($ptodate/$baseline)*($reportdata['weight']/100);
 $ptodate=0;
 }
 
}
if($comm_progress!=0)
{
$res=$comm_progress;	
}
else
{
	$res=0;
}
return $res;
}

function getProjectCommTargC($scid,$kpiid,$scmonth)
{

 //$sql="SELECT  weighted_planned as milestone_targets FROM kpidata_result  where scid=".$scid." AND kpiid=".$kpiid." ";
  $vmonth= date('m',strtotime($scmonth));
					  $vyear= date('Y',strtotime($scmonth));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scmonth=$scmonth."-".$vmonth_days;
					 
					 
					 
	 $sql="SELECT sum(a.perc_planned) as milestone_targets FROM kpidata0 a  where  a.kpiid=".$kpiid." AND a.budgetdate<='$scmonth' ";
 $this->dbQuery($sql);
 $amountresult=$this->totalRecords();
if($amountresult!=0)
{
 $data=$this->dbFetchArray();
 
 $milestone_targets=$data["milestone_targets"];
 
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
}
function getMilestoneTotalTargetsCLast($till_end,$kpiid,$scmonth)
{
	$vmonth= date('m',strtotime($scmonth));
	 $vyear= date('Y',strtotime($scmonth));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scmonth=$scmonth."-".$vmonth_days;

	$sql="SELECT  kpi_comm_planned as milestone_targets FROM kpidata_result  where scid=".$till_end." AND kpiid=".$kpiid." ";
	 "SELECT sum(a.budgetqty) as milestone_targets FROM planned a inner join kpi_activity b on (a.itemid=b.itemid) where  b.kpiid=".$kpiid." 
	AND a.budgetdate='$scmonth' Group By b.kpiid";
 $this->dbQuery($sql);
 $amountresult=$this->totalRecords();
if($amountresult!=0)
{
 $data=$this->dbFetchArray();
 $total_milestone_targets=$data["milestone_targets"];
}
else
{
$total_milestone_targets=0;
}
return $total_milestone_targets;
	} 
	
function getMilestoneTotalAchieveCLast($till_end,$kpiid)
{

$sql="SELECT  kpi_comm_actual as milestone_achieved FROM kpidata_result  where scid=".$till_end." AND kpiid=".$kpiid." ";
$this->dbQuery($sql);
 $amountresult=$this->totalRecords();
if($amountresult!=0)
{
 $data=$this->dbFetchArray();
 $total_milestone_targets=$data["milestone_achieved"];
}
else
{
$total_milestone_targets=0;
}
return $total_milestone_targets;
	} 
function getMilestoneTotalTargetsCLatest($end,$itemid)
{

 $sql="SELECT  sum(kpi_planned) as milestone_targets FROM planned  where scid<=".$end." AND kpiid=".$kpiid." ";
$this->dbQuery($sql);
 $amountresult=$this->totalRecords();

if($amountresult!=0)
{
 $data=$this->dbFetchArray();
 $total_milestone_targets=$data["milestone_targets"];
}
else
{
$total_milestone_targets=0;
}
return $total_milestone_targets;
	} 
	
function getMilestoneTotalAchieveCLatest($end,$kpiid)
{

	 $sql="SELECT  sum(kpi_actual) as milestone_achieved FROM kpi_base_level_report  where scid<=".$end." AND kpiid=".$kpiid." ";
$this->dbQuery($sql);
 $amountresult=$this->totalRecords();

if($amountresult!=0)
{
 $data=$this->dbFetchArray();
 $total_milestone_targets=$data["milestone_achieved"];
}
else
{
$total_milestone_targets=0;
}
return $total_milestone_targets;
	} 
	
	
function getMilestoneAchieveCCC($scid,$kpiid,$scmonth)
{

 $vmonth= date('m',strtotime($scmonth));
					  $vyear= date('Y',strtotime($scmonth));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scmonth=$scmonth."-".$vmonth_days;
	 $sql="SELECT sum(a.actual_qty) as milestone_achieved, b.kaweight FROM planned a inner join kpi_activity b on (a.itemid=b.itemid) where  b.kpiid=".$kpiid." AND budgetdate<='".$scmonth."' Group By b.kpiid";
	// $sql="SELECT  sum(kpi_actual) as milestone_achieved FROM kpi_base_level_report  where kpiid=".$kpiid." AND scid<=".$scid;
	$this->dbQuery($sql);
 $amountresult=$this->totalRecords();
	if($amountresult!=0)
	{
	 $data=$this->dbFetchArray();
	$milestone_achieved=$data["milestone_achieved"];
	}
	else
	{
		$milestone_achieved=0;
	}
return $milestone_achieved;
	} 
	
	
function getMilestoneTargetsCCC($scid,$kpiid,$scmonth)
{
 $vmonth= date('m',strtotime($scmonth));
					  $vyear= date('Y',strtotime($scmonth));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scmonth=$scmonth."-".$vmonth_days;
	$sql="SELECT sum(a.budgetqty) as milestone_targets, b.kaweight FROM planned a inner join kpi_activity b on (a.itemid=b.itemid) where  b.kpiid=".$kpiid." AND budgetdate<='".$scmonth."' Group By b.kpiid";
//$sql="SELECT  sum(kpi_planned) as milestone_targets FROM kpi_base_level_report  where kpiid=".$kpiid." AND scid<=".$scid;
$this->dbQuery($sql);
 $amountresult=$this->totalRecords();
if($amountresult!=0)
{
 $data=$this->dbFetchArray();
 $milestone_targets=$data["milestone_targets"];
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
	} 
	
function getMilestoneAchievePC($scid,$kpiid,$scmonth)
{

	$vmonth= date('m',strtotime($scmonth));
					  $vyear= date('Y',strtotime($scmonth));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scmonth=$scmonth."-".$vmonth_days;
	$sql="SELECT sum(a.actual_qty) as milestone_achieved, b.kaweight FROM planned a inner join kpi_activity b on (a.itemid=b.itemid) where  b.kpiid=".$kpiid." AND budgetdate='".$scmonth."' Group By b.kpiid";
	//$sql="SELECT  sum(kpi_actual) as milestone_achieved FROM kpi_base_level_report  where kpiid=".$kpiid." AND scid=".$scid;
 $this->dbQuery($sql);
 $amountresult=$this->totalRecords();
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=$this->dbFetchArray();
$milestone_achieved=$data["milestone_achieved"];
}
else
{
	$milestone_achieved=0;
}
return $milestone_achieved;
	} 
	
	
function getMilestoneTargetsPC($scid,$kpiid,$scmonth)
{
	 
	 $vmonth= date('m',strtotime($scmonth));
					  $vyear= date('Y',strtotime($scmonth));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scmonth=$scmonth."-".$vmonth_days;
	$sql="SELECT sum(a.budgetqty) as milestone_targets, b.kaweight FROM planned a inner join kpi_activity b on (a.itemid=b.itemid) where  b.kpiid=".$kpiid." AND budgetdate='".$scmonth."' Group By b.kpiid";
	// $sql="SELECT  sum(kpi_planned) as milestone_targets FROM kpi_base_level_report  where kpiid=".$kpiid." AND scid=".$scid;
 $this->dbQuery($sql);
 $amountresult=$this->totalRecords();
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=$this->dbFetchArray();
 $milestone_targets=$data["milestone_targets"];
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
	}
}



?>