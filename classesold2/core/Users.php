<?php
/**
*
* This is a class Users
*
**/
class Users extends DataBase{
	
	
	protected $u_id;
	protected $u_name;
	protected $u_business_name;
	protected $u_phone;
	protected $u_email;
	protected $u_area;
	protected $u_area_unit;
	
	/**
	* This is the constructor of the class users
	*/
	public function __construct(){
		parent::__construct();
	}

	
	public function getUsers()
	{
		$result=$this->dbQuery("select * from wh_002_users");
		/*while($rows=$result->fetch())
		{
			$u_id=$rows["u_id"];
			$u_name=$rows["u_name"];
			$u_business_name=$rows["u_business_name"];
			$u_area=$rows["u_phone"];
			$u_name=$rows["u_email"];
			$u_area=$rows["u_area"];
			$u_area_unit=$rows["u_area_unit"];
			
		}*/
		return $result;
	}
	public function getUserIds()
	{
		$result=$this->dbQuery("SELECT u_id from wh_002_users");
	   	return $result;
	
	}
}
?>