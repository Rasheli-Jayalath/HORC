<?php
class ProjectSetup extends Database
{

    /**
     * This is the constructor of the class IpcClass
     */
    public function __construct()
    {
        parent::__construct();
    }
	public function getProject()
    {
         $Sql = "Select * from project WHERE 
					1=1";
		if($this->isPropertySet("pid", "V"))
			$Sql .= " AND pid=" . $this->getProperty("pid");
		 

        return $this->dbQuery($Sql);
    }
	public function getProjectBackup()
    {
        $Sql = "Select * from project_backup";

        return $this->dbQuery($Sql);
    }
		public function getSector()
    {
		 $Sql = "Select * from rs_tbl_sectors where 1=1";
		if($this->isPropertySet("sector_id", "V"))
			$Sql .= " AND sector_id=" . $this->getProperty("sector_id");
        return $this->dbQuery($Sql);
    }
	public function getCountry()
    {
		
		 $Sql = "Select * from rs_tbl_countries where 1=1";
		if($this->isPropertySet("country_id", "V"))
			$Sql .= " AND country_id=" . $this->getProperty("country_id");

        return $this->dbQuery($Sql);
    }
	public function getCurrency()
    {
		 $Sql = "Select * from project_currency ";

        return $this->dbQuery($Sql);
    }
	public function getWeekDays()
    {
		 $Sql = "Select * from weekdays ";

        return $this->dbQuery($Sql);
    }
	public function getYearlyHolidays()
    {
		 $Sql = "Select * from yearly_holidays ";

        return $this->dbQuery($Sql);
    }
  

 	public function actProject($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO project(
						pid,
						pcode,
						pdetail,
						ptype, 
						pstart, 
						pend,
						client,
						funding_agency,
						contractor,
						pcost,
						sector_id,
						country_id,
						location,
						consultant,
						smec_code)
						VALUES(";
				$Sql .= $this->isPropertySet("pid", "V") ? $this->getProperty("pid") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pcode", "V") ? "'" . $this->getProperty("pcode") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pdetail", "V") ? "'" . $this->getProperty("pdetail") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ptype", "V") ? "'" . $this->getProperty("ptype") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pstart", "V") ? "'" . $this->getProperty("pstart") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pend", "V") ? "'" . $this->getProperty("pend") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("client", "V") ? "'" . $this->getProperty("client") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("funding_agency", "V") ? "'" . $this->getProperty("funding_agency") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("contractor", "V") ? "'" . $this->getProperty("contractor") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pcost", "V") ? "'" . $this->getProperty("pcost") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sector_id", "V") ? "'" . $this->getProperty("sector_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("country_id", "V") ? "'" . $this->getProperty("country_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("location", "V") ? "'" . $this->getProperty("location") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("consultant", "V") ? "'" . $this->getProperty("consultant") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("smec_code", "V") ? "'" . $this->getProperty("smec_code") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE project SET ";
				if($this->isPropertySet("pcode", "K")){
					$Sql .= "$con pcode='" . $this->getProperty("pcode") . "'";
					$con = ",";
				}
				if($this->isPropertySet("pdetail", "K")){
					$Sql .= "$con pdetail='" . $this->getProperty("pdetail") . "'";
					$con = ",";
				}
				if($this->isPropertySet("ptype", "K")){
					$Sql .= "$con ptype='" . $this->getProperty("ptype") . "'";
					$con = ",";
				}
				if($this->isPropertySet("pstart", "K")){
					$Sql .= "$con pstart='" . $this->getProperty("pstart") . "'";
					$con = ",";
				}
				if($this->isPropertySet("pend", "K")){
					$Sql .= "$con pend='" . $this->getProperty("pend") . "'";
					$con = ",";
				}
				if($this->isPropertySet("client", "K")){
					$Sql .= "$con client='" . $this->getProperty("client") . "'";
					$con = ",";
				}
				if($this->isPropertySet("funding_agency", "K")){
					$Sql .= "$con funding_agency='" . $this->getProperty("funding_agency") . "'";
					$con = ",";
				}
				if($this->isPropertySet("contractor", "K")){
					$Sql .= "$con contractor='" . $this->getProperty("contractor") . "'";
					$con = ",";
				}
				if($this->isPropertySet("pcost", "K")){
					$Sql .= "$con pcost='" . $this->getProperty("pcost") . "'";
					$con = ",";
				}
				if($this->isPropertySet("sector_id", "K")){
					$Sql .= "$con sector_id='" . $this->getProperty("sector_id") . "'";
					$con = ",";
				}
				if($this->isPropertySet("country_id", "K")){
					$Sql .= "$con country_id='" . $this->getProperty("country_id") . "'";
					$con = ",";
				}
				
				if($this->isPropertySet("location", "K")){
					$Sql .= "$con location='" . $this->getProperty("location") . "'";
					$con = ",";
				}
				if($this->isPropertySet("consultant", "K")){
					$Sql .= "$con consultant='" . $this->getProperty("consultant") . "'";
					$con = ",";
				}
				
				if($this->isPropertySet("smec_code", "K")){
					$Sql .= "$con smec_code='" . $this->getProperty("smec_code") . "'";
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND pid=" . $this->getProperty("pid");
				break;
			case "D":
				$Sql = "DELETE FROM 
							project 
						WHERE
							1=1 
							AND pid=" . $this->getProperty("pid");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	public function actCurrency($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO project_currency(base_cur,cur_1,cur_1_rate,cur_2,cur_2_rate,cur_3,cur_3_rate) VALUES(";
				
				$Sql .= $this->isPropertySet("base_cur", "V") ? "'" . $this->getProperty("base_cur") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cur_1", "V") ? "'" . $this->getProperty("cur_1") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cur_1_rate", "V") ? "'" . $this->getProperty("cur_1_rate") . "'" : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cur_2", "V") ? "'" . $this->getProperty("cur_2") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cur_2_rate", "V") ? "'" . $this->getProperty("cur_2_rate") . "'" : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cur_3", "V") ? "'" . $this->getProperty("cur_3") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cur_3_rate", "V") ? "'" . $this->getProperty("cur_3_rate") . "'" : "0";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE project_currency SET ";
				
				if($this->isPropertySet("base_cur", "K")){
					$Sql .= "$con base_cur='" . $this->getProperty("base_cur") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cur_1", "K")){
					$Sql .= "$con cur_1='" . $this->getProperty("cur_1") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cur_1_rate", "K")){
					$Sql .= "$con cur_1_rate='" . $this->getProperty("cur_1_rate") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cur_2", "K")){
					$Sql .= "$con cur_2='" . $this->getProperty("cur_2") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cur_2_rate", "K")){
					$Sql .= "$con cur_2_rate='" . $this->getProperty("cur_2_rate") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cur_3", "K")){
					$Sql .= "$con cur_3='" . $this->getProperty("cur_3") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cur_3_rate", "K")){
					$Sql .= "$con cur_3_rate='" . $this->getProperty("cur_3_rate") . "'";
					
				}
				
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND pcid=" . $this->getProperty("pcid");
				break;
			case "D":
				$Sql = "DELETE FROM 
							project_currency 
						WHERE
							1=1 
							AND pcid=" . $this->getProperty("pcid");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	public function actYearlyHolidays($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO yearly_holidays(
						yh_id,
						yh_title,
						yh_date,
						yh_status,
						pid)
						VALUES(";
				$Sql .= $this->isPropertySet("yh_id", "V") ? $this->getProperty("yh_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("yh_title", "V") ? "'" . $this->getProperty("yh_title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("yh_date", "V") ? "'" . $this->getProperty("yh_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("yh_status", "V") ? "'" . $this->getProperty("yh_status") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pid", "V") ? "'" . $this->getProperty("pid") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE yearly_holidays SET ";
				
				if($this->isPropertySet("yh_title", "K")){
					$Sql .= "$con yh_title='" . $this->getProperty("yh_title") . "'";
					$con = ",";
				}
				if($this->isPropertySet("yh_date", "K")){
					$Sql .= "$con yh_date='" . $this->getProperty("yh_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("yh_status", "K")){
					$Sql .= "$con yh_status='" . $this->getProperty("yh_status") . "'";
					$con = ",";
				}
				if($this->isPropertySet("pid", "K")){
					$Sql .= "$con pid='" . $this->getProperty("pid") . "'";
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND yh_id=" . $this->getProperty("yh_id");
				break;
			case "D":
				$Sql = "DELETE FROM 
							yearly_holidays 
						WHERE
							1=1 
							AND yh_id=" . $this->getProperty("yh_id");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}

public function updateWeekDays()
    {
        $Sql = "update weekdays SET status=0";

        return $this->dbQuery($Sql);
    }
public function UpdateAllWeekDays($work_day)
    {
        $Sql = "update weekdays SET status=1 where wd_id=$work_day";

        return $this->dbQuery($Sql);
    }
public function DataMaking($txtpstart,$txtpend,$mode)
    {
		if($mode=='U')
		{
			$this->dbQuery("TRUNCATE project_days");
		}
        $Sql = "INSERT INTO project_days (pd_date,pd_status) select v.selected_date, if(y.yh_status=0,y.yh_status,w.status)from 
(select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
(select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
(select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
(select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
(select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
(select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v left outer join weekdays w on (WEEKDAY(v.selected_date)=w.wd_day) left outer join yearly_holidays y on (v.selected_date=y.yh_date) 
where v.selected_date between '".$txtpstart."' and '".$txtpend."' order by v.selected_date";

        return $this->dbQuery($Sql);
    }

}
