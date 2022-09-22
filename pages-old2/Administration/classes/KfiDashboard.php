<?php

class KfiDashboard extends Database{

    /**
	* This is the constructor of the class KfiDashboard
	*/
	public function __construct(){
		parent::__construct();
	}

    public function getAllParentCd()
	{

        $Sql = "SELECT 
		a.itemid
		FROM boqdata a";

        return $this->dbQuery($Sql);
    }
    public function getParentCById()
	{
        $itemid = $this->getProperty("itemid");

        $Sql = "SELECT 
		a.parentcd
		FROM boqdata a WHERE a.itemid=".$itemid;

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
        a.activities,
        a.isentry,
        a.resources,
        a.aorder
		FROM boqdata a
				WHERE 
                a.parentcd=".$proid;

        return $this->dbQuery($Sql);
        
    }
	 public function getDataFromBoq()
	{
        $boqitemid = $this->getProperty("boqitemid");

       //$Sql = "SELECT * FROM boq a WHERE a.itemid=".$boqitemid;
       $Sql = "SELECT (boq_cur_1_rate*boqqty) as x, (boq_cur_2_rate*boqqty) as y FROM boq WHERE itemid=".$boqitemid;

        return $this->dbQuery($Sql);
        
    }
    public function getDataFromBoqLevel()
	{
        $boqitemid = $this->getProperty("boqitemid");

       $Sql = "SELECT (boq_cur_1_rate*boqqty) as x, (boq_cur_2_rate*boqqty) as y FROM boq WHERE boqid=".$boqitemid;

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
		FROM boqdata a
				WHERE 
                a.parentgroup LIKE '%".$parentgroup."%'"." AND a.isentry=1";

        return $this->dbQuery($Sql);
        
    }

    public function getParentGroup()
	{
        $itemids = $this->getProperty("itemids");

        $Sql = "SELECT 
		a.parentgroup
		FROM boqdata a
				WHERE 
                a.itemid=".$itemids;

        return $this->dbQuery($Sql);
        
    }


    // Default Loading Page
    public function getActivity_LevelData()
	{
        $itemids = $this->getProperty("itemids");
        $Sql = "SELECT *
        FROM boqdata
        WHERE parentcd = ".$itemids." 
        UNION ALL
        SELECT *
        FROM boqdata
        WHERE itemid = ".$itemids." AND
              NOT EXISTS (SELECT 1 FROM boqdata WHERE parentcd = ".$itemids.")";

        return $this->dbQuery($Sql);
        
    }

     public function getBOQ_LevelData()
	{
        $itemids = $this->getProperty("itemids");
        $Sql = "SELECT *
        FROM boq
        WHERE itemid = ".$itemids;

        return $this->dbQuery($Sql);
        
    }

 public function getBOQ_Data()
	{
        $boqid = $this->getProperty("boqid");
        $Sql = "SELECT *
        FROM boq
        WHERE boqid = ".$boqid;

        return $this->dbQuery($Sql);
        
    }

    public function getItemsWithIstype2()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT 
		a.itemid,a.parentgroup
		FROM boqdata a
				WHERE 
                a.parentgroup LIKE '%".$parentgroup."%'"." AND a.isentry=1";

        return $this->dbQuery($Sql);
        
    }
	
	public function getItemsWithIstype2BOQ()
	{
        $itemid = $this->getProperty("itemid");

        $Sql = "SELECT * FROM boq a
				WHERE 
                a.itemid=".$itemid;

        return $this->dbQuery($Sql);
        
    }
	public function getItemsWithBOQ()
	{
        $boqid = $this->getProperty("boqid");

        $Sql = "SELECT * FROM boq a
				WHERE 
                a.boqid=".$boqid;

        return $this->dbQuery($Sql);
        
    }

    public function getItemName()
	{
        $activitylevel = $this->getProperty("activitylevel");

        $Sql = "SELECT 
		*
		FROM boqdata a
				WHERE 
                a.activitylevel=".$activitylevel;

        return $this->dbQuery($Sql);
        
    }

    public function getAllActivityLevels()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT 
        DISTINCT a.activitylevel
		FROM boqdata a
				WHERE
                a.parentgroup LIKE '%".$parentgroup."%' ORDER BY a.activitylevel ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllActivityLevels2()
	{
        $parentgroup = $this->getProperty("parentgroup");

        $Sql = "SELECT *
		FROM boqdata a
				WHERE
                a.parentgroup LIKE '%".$parentgroup."%' ORDER BY a.activitylevel ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllDataOrderByItemid()
	{
        $Sql = "SELECT * FROM boqdata ORDER BY itemid ASC";

        return $this->dbQuery($Sql);
        
    }

    public function getAllDataOrderByAorder()
	{
        $Sql = "SELECT * FROM boqdata ORDER BY aorder ASC";

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
	
	public function getAllIpcVBOQ()
	{
      $Sql = "SELECT (a.boq_cur_1_rate*b.ipcqty) as zp, (a.boq_cur_2_rate*b.ipcqty) as qu FROM boq a INNER JOIN ipcv b ON a.boqid=b.boqid WHERE 1=1  ";
		
		
		if($this->isPropertySet("boqid", "V"))
			$Sql .= " AND a.boqid='" . $this->getProperty("boqid")."'";
			
			
		
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
	
	 public function getAllIpcVExupBOQ()
	{
        $Sql = "SELECT (a.boq_cur_1_rate*b.ipcqty) as xx,(a.boq_cur_2_rate*b.ipcqty) as yy FROM boq a INNER JOIN ipcv b ON a.boqid=b.boqid WHERE 1=1  ";
		
		
		if($this->isPropertySet("boqid", "V"))
			$Sql .= " AND a.boqid='" . $this->getProperty("boqid")."'";
			
			
		
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
	
	public function getAllIpcVPInBOQ()
	{
        
		
        $Sql = "SELECT (a.boq_cur_1_rate*b.ipcqty) as xx,(a.boq_cur_2_rate*b.ipcqty) as yy FROM boq a INNER JOIN ipcv b ON a.boqid=b.boqid WHERE 1=1  ";
		
		
		if($this->isPropertySet("boqid", "V"))
			$Sql .= " AND a.boqid='" . $this->getProperty("boqid")."'";
			
			
		
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

}


?>