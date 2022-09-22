<?php

/**
*
* This is a class which is the collection of database related methods
**/
class Database extends Property{
	
	 private static  $dbCon;			/* member variable that holds the database connectivity resource */
	protected $rsResource;	/* member variable that holds the result/resource */
	protected $sql;
	
	
	
	/**
	* This is the constructor of the class Database
	* which initializes the database connectivity
	*/
	public function __construct(){
		
	
	
	
	
		
	$host=HOST;
	$dbnmame=DBNAME;
	$con = new PDO("mysql:host=$host;dbname=$dbnmame;charset=UTF8", DBUSER, DBPASSWD, array(PDO::ATTR_PERSISTENT => true));

	$this->dbCon = $con;
	
	}

	/**
	* This method is used to execute the query
	* @param : $sql
	*/
	public function dbQuery($sql){
		
		
		if(!$sql || $sql == ""){
			die('Empty SQL statement found!');
		}
		if($this->rsResource!=NULL)
			{
			$this->rsResource->closeCursor( );
			}
		
		$this->rsResource=$this->dbCon->query($sql);
		
		
			if (!$this->rsResource)
			{
				
				$this->sError = $this->rsResource->errorInfo();

				return false;
			}

			else
			{
				
				return $this->rsResource;
			}

	}
	
	
	/**
	
	* @param : $sql
	* @return : resource / result
	*/
	public function dbQueryReturn($sql = ""){
		if(!$sql || $sql == ""){
			die('Empty SQL statement found!');
		}
		$this->rsResource = mysql_query($sql);
		if($this->rsResource){
			$this->sql = $sql;
			return $this->rsResource;
		}
		else{
			return false;
		}
	}
	
	/**
	* This method is used to get the current sql;
	* @return : integer
	*/
	public function getSQL(){
		if(is_resource($this->rsResource) && $this->sql){
			return $this->sql;
		}
	}
	
	/**
	* This method is used to get the total records of a result
	* @return : integer
	*/
	public function totalRecords(){
		
		return $this->rsResource->rowCount();
		
	}
	
	/**
	* This method is used to fetch the result/resource row as associative array
	* @param : $retType = return array type (1=ASSOC / 2 = NUM / 3 = OBJECT)
	* @param : $dbResource = query resource/result
	* @return : Array
	*/
	public function dbFetchArray($retType = 1){
		$dbResource = null;
		if(is_resource($dbResource)){
			if($retType == 1)
				return mysql_fetch_array($dbResource, MYSQL_ASSOC);
			else if($retType == 2)
				return mysql_fetch_assoc($dbResource);
			else if($retType == 3)
				return mysql_fetch_object($dbResource);
		}
		else if($this->rsResource){
			 
			if($retType == 1)
			
			return $this->rsResource->fetch();
				
			else if($retType == 2)
				return mysql_fetch_assoc($this->rsResource);
			else if($retType == 3)
				return mysql_fetch_object($this->rsResource);
		}
		else{
			die('Invalid resource!');
		}
	}
	/**
	* This method is used to fetch the result/resource row as associative array
	* @param : $retType = return array type (1=ASSOC / 2 = NUM / 3 = OBJECT)
	* @param : $dbResource = query resource/result
	* @return : Array
	*/
	public function dbFetchArray7($retType = 1){
	   
		if(is_resource($dbResource)){
			if($retType == 1)
				return $dbResource->fetch(PDO::FETCH_ASSOC);
			else if($retType == 2)
				return mysql_fetch_assoc($dbResource);
			else if($retType == 3)
				return mysql_fetch_object($dbResource);
		}
		else if($this->rsResource){
			if($retType == 1)
				return $this->rsResource->fetch(PDO::FETCH_ASSOC);
			else if($retType == 2)
				return $this->rsResource->fetch(PDO::FETCH_NUM);
			else if($retType == 3)
				return $this->rsResource->fetch(PDO::FETCH_OBJ);
		}
		else{
			die('Invalid resource!');
		}
	}
	
	/**
	* This method is used to free the database result/resource
	* @return : bool
	*/
	public function dbFree($dbResource){
		if(is_resource($dbResource)){
			mysql_free_result($dbResource);
		}
		else if(is_resource($this->rsResource)){
			mysql_free_result($this->rsResource);
		}
	}
	
	/**
	* This method is used to get the new code/id for the table.
	* @return : bool
	*/
	public function genCode($table, $field){
		$Sql = "SELECT 
					MAX(" . $field . ") + 1 AS MaxVal
				FROM 
					" . $table . "
				WHERE
					1=1";
		$this->dbQuery($Sql);
		$rows = $this->dbFetchArray(1);
		if($rows['MaxVal'] != NULL && $rows['MaxVal'] != "")
			return $rows['MaxVal'];
		else
			return 1;
	}

	/**
	* This method is used to append the limiting sql
	* @return : bool
	*/
	public function appendLimit($perpage){
		$page = isset($_GET['page']) ? trim($_GET['page']) : 1;
		$start = (intval($page) - 1) * $perpage;
		$Sql = " LIMIT $start, $perpage";
		return $Sql;
	}
	
	/*
	* This method is used to append the limiting sql
	* @return : bool
	*/
	public function getTotal($sql){
		$result = mysql_query($sql) or die(mysql_error());
		$rows = mysql_fetch_array($result);
		if(!empty($rows['total_records']) && $rows['total_records'] >= 1){
			return $rows['total_records'];
		}
		else{
			return 0;
		}
	}
}

