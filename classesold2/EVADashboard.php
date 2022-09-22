<?php

class EVADashboard extends Database{

    /**
	* This is the constructor of the class KfiDashboard
	*/
	public function __construct(){
		parent::__construct();
	}

function GetPlannedData($start,$end)
{
	$reportquery ="SELECT *
	FROM `s006-eva-budget` where bmonth >='".$start."' AND bmonth <='".$end."' order by bmonth ASC";
	
				$reportresult = $this->dbQuery($reportquery);
				
				$num=$this->totalRecords();
				
				$ii=0;
			
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
		if($reportdata["bcommulativecost"]!=0&&$reportdata["bcommulativecost"]!="")
		{	
				$month=date('m',strtotime($reportdata["bmonth"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["bmonth"])). ",".$month.
					 ",".date('d',strtotime($reportdata["bmonth"])). ") , ".round($reportdata["bcommulativecost"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetEarnedData($start,$end)
{
	$reportquery ="SELECT * FROM `s007-eva-earned` where emonth >='".$start."' AND emonth <='".$end."' order by emonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
		if($reportdata["ecommulativecost"]!=0&&$reportdata["ecommulativecost"]!="")
		{
			
			$month=date('m',strtotime($reportdata["emonth"]))-1;
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["emonth"])). ",".$month.
					 ",".date('d',strtotime($reportdata["emonth"])). ") , ".round($reportdata["ecommulativecost"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetActualData($start,$end)
{
	$reportquery ="SELECT *
	FROM `s008-eva-actual` where amonth >='".$start."' AND amonth <='".$end."' order by amonth";
	
				$this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
		if($reportdata["acommulativecost"]!=0&&$reportdata["acommulativecost"]!="")
		{	
		$month=date('m',strtotime($reportdata["amonth"]))-1;
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["amonth"])). ",".$month.
					 ",".date('d',strtotime($reportdata["amonth"])). ") , ".round($reportdata["acommulativecost"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetCPIData($start,$end)
{
	$reportquery ="SELECT * FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth ASC";
	
				$this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
			
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
		if($reportdata["cpi"]!="")
		{	
				$month=date('m',strtotime($reportdata["rmonth"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["rmonth"])). ",".$month.
					 ",".date('d',strtotime($reportdata["rmonth"])). ") , ".number_format($reportdata["cpi"],2)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetSPIData($start,$end)
{
	$reportquery ="SELECT * FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth ASC";
	
				$this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
			
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
		if($reportdata["spi"]!="")
		{	
				$month=date('m',strtotime($reportdata["rmonth"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["rmonth"])). ",".$month.
					 ",".date('d',strtotime($reportdata["rmonth"])). ") , ".number_format($reportdata["spi"],2)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetCPIValue($last)
{
	 $reportquery ="SELECT * FROM `s009-eva-results` where rmonth ='".$last."'  order by rmonth";
	
				$this->dbQuery($reportquery);
			
				
}
function GetSPIValue($last)
{
	$reportquery ="SELECT * FROM `s009-eva-results` where rmonth ='".$last."'  order by rmonth";
	
			
			
				$this->dbQuery($reportquery);
}

function GetTCPI_1Value($last)
{
	$reportquery ="SELECT * FROM `s009-eva-results` where rmonth ='".$last."'  order by rmonth";
	
				$this->dbQuery($reportquery);
}
function GetCostVarianceDatabck($start,$end)
{
	$reportquery ="SELECT *
	FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
		if($reportdata["cv"]!=0&&$reportdata["cv"]!="")
		{	
		$month=date('m',strtotime($reportdata["rmonth"]))-1;
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["rmonth"])). ",".$month.
					 ",".date('d',strtotime($reportdata["rmonth"])). ") , ".round($reportdata["cv"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}

function GetCostVarianceData($start,$end)
{
	$reportquery ="SELECT *
	FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
		if($reportdata["cv"]!=0&&$reportdata["cv"]!="")
		{	
		
				$code_str .=round($reportdata["cv"]);
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}

function GetCostVarianceMonth($start,$end)
{
	$reportquery ="SELECT *
	FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
					if($reportdata["cv"]!=0&&$reportdata["cv"]!="")
					{	
					$month=date('m',strtotime($reportdata["rmonth"]));
					$code_str .='"'.$month.'-'.date('Y',strtotime($reportdata["rmonth"])).'"';
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}

function  GetScheduleVarianceData($start,$end)
{
	$reportquery ="SELECT *
	FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
		if($reportdata["sv"]!=0&&$reportdata["sv"]!="")
		{	
		
				$code_str .=round($reportdata["sv"]);
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}

function GetScheduleVarianceMonth($start,$end)
{
	$reportquery ="SELECT *
	FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
					if($reportdata["sv"]!=0&&$reportdata["sv"]!="")
					{	
					$month=date('m',strtotime($reportdata["rmonth"]));
					$code_str .='"'.$month.'-'.date('Y',strtotime($reportdata["rmonth"])).'"';
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}



function GetForecastingMonths($start,$end)
{
	$reportquery ="SELECT *
	FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				while ($reportdata = $this->dbFetchArray()) {
					
					$ii++;
						
					$month=date('M',strtotime($reportdata["rmonth"]));
					$code_str .='<th>'.$month.'-'.date('Y',strtotime($reportdata["rmonth"])).'</th>';
					
		
					 
				}
				
	return $code_str;
}
function GetForecastingMonthsCount($start,$end)
{
	$reportquery ="SELECT *
	FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				
				
	return $num;
}

function GetMonthlyForecasting($start,$end)
{
	$reportquery ="SELECT *
	FROM `s009-eva-results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				
				
	return $reportresult;
}
function GetMonthlyIndicators($start,$end)
{
	$reportquery ="SELECT *
	FROM `results` where rmonth >='".$start."' AND rmonth <='".$end."' order by rmonth";
	
				$reportresult = $this->dbQuery($reportquery);
				$num=$this->totalRecords();
				$ii=0;
				
				
				
	return $reportresult;
}

function GetMonthlyIndicatorsValue($last)
{
	$reportquery ="SELECT * FROM `results` where rmonth ='".$last."'  order by rmonth";
	
				$this->dbQuery($reportquery);
				
			
}
}
	?>