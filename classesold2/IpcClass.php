<?php
class IpcClass extends Database
{

    /**
     * This is the constructor of the class IpcClass
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function insertDataIpcTable()
    {

        $ipcno = $this->getProperty("ipcno");
        $ipcmonth = $this->getProperty("ipcmonth");
        $ipcstartdate = $this->getProperty("ipcstartdate");
        $ipcenddate = $this->getProperty("ipcenddate");
        $ipcsubmitdate = $this->getProperty("ipcsubmitdate");
        $ipcreceivedate = $this->getProperty("ipcreceivedateID");
        $status = $this->getProperty("status");

        $Sql = "INSERT INTO ipc(ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status)
        VALUES ('$ipcno','$ipcmonth','$ipcstartdate','$ipcenddate','$ipcsubmitdate','$ipcreceivedate','$status')";

        return $this->dbQuery($Sql);
    }

    public function insertDataIpcvTable()
    {

        $ipcid = $this->getProperty("ipcid");
        $boqid = $this->getProperty("boqid");
        $ipcqty = $this->getProperty("ipcqty");

        $Sql = "INSERT INTO ipcv(ipcid,boqid,ipcqty)
        VALUES ('$ipcid','$boqid','$ipcqty')";

        return $this->dbQuery($Sql);
    }

    public function updateDataIpcvTable()
    {
        $ipcid = $this->getProperty("ipcvid");
        $boqid = $this->getProperty("boqid");
        $ipcqty = $this->getProperty("ipcqty");

        $Sql = "UPDATE ipcv SET ipcid='$ipcid',ipcqty='$ipcqty'
        WHERE boqid='$boqid'";

        return $this->dbQuery($Sql);
    }

    public function checkexistIpcIdIpcvTable()
    {
        $boqid = $this->getProperty("boqiddd");

        $Sql = "SELECT * FROM ipcv WHERE boqid=" . $boqid;

        return $this->dbQuery($Sql);
    }

    public function getAllDataIpcTable()
    {
        $Sql = "SELECT *
		FROM ipc";

        return $this->dbQuery($Sql);
    }

    public function getAllDataIpcFrmId()
    {
        $ipcid = $this->getProperty("ipcid");

        $Sql = "SELECT *
		FROM ipc WHERE ipcid=" . $ipcid;

        return $this->dbQuery($Sql);
    }

    public function updateDataIpcTable()
    {
        $ipcid = $this->getProperty("ipcid");
        $ipcno = $this->getProperty("ipcno");
        $ipcmonth = $this->getProperty("ipcmonth");
        $ipcstartdate = $this->getProperty("ipcstartdate");
        $ipcenddate = $this->getProperty("ipcenddate");
        $ipcsubmitdate = $this->getProperty("ipcsubmitdate");
        $ipcreceivedate = $this->getProperty("ipcreceivedateID");
        $status = $this->getProperty("status");

        $Sql = "UPDATE ipc SET ipcno='$ipcno',ipcmonth='$ipcmonth',ipcstartdate='$ipcstartdate',ipcenddate='$ipcenddate',ipcsubmitdate='$ipcsubmitdate',ipcreceivedate='$ipcreceivedate',status='$status'
        WHERE ipcid='$ipcid'";

        return $this->dbQuery($Sql);
    }

    public function getActiveIpcNo()
    {
        $ipcid = $this->getProperty("ipcid");

        $Sql = "SELECT *
		FROM ipc WHERE status=1";

        return $this->dbQuery($Sql);
    }

    public function getParentItemByZero()
    {

        $Sql = "SELECT *
		FROM boqdata WHERE activitylevel=0";

        return $this->dbQuery($Sql);
    }

    public function getKpiScaleMonths()
    {

        $Sql = "SELECT scmonth
		FROM kpiscale";

        return $this->dbQuery($Sql);
    }

    public function getAllActivitylevels()
    {
        $Sql = "SELECT DISTINCT activitylevel FROM boqdata";

        return $this->dbQuery($Sql);
    }

    public function getIpcByBoqid()
    {
        $boqid = $this->getProperty("boqid");

        $Sql = "SELECT *
		FROM ipc WHERE boqid="+$boqid;

        return $this->dbQuery($Sql);
    }

    public function getDataFromBoq()
	{
        $itemid = $this->getProperty("itemid");

       $Sql = "SELECT * FROM boq a WHERE a.itemid=".$itemid;
        return $this->dbQuery($Sql);
        
    }



}
