<?php
/**
*
* This is a class Property
*
**/
class Property{
	protected $propertyTable 	= array();
	private $tmpArray 			= array();
	private $tmpVar;
	
	/**
	* This is the constructor of the class Property
	*/
	public function __construct(){
		parent::__construct();
	}

	/**
	* This method is used to set the property
	* @param : $key, $value
	*/
	public function setProperty($key, $value, $flag = false){
		
		if(is_array($value)){
			foreach($value as $k=>$v){
				if($flag){
					//if(get_magic_quotes_gpc())
						$v = stripslashes($v);
					//$this->tmpArray[$k] = mysql_real_escape_string($v);
				}
				else{
					$this->tmpArray[$k] = $v;
				}
			}
			$this->propertyTable[$key] = $this->tmpArray;
			unset($this->tmpArray);
		}
		else{
			if($flag){
				//if(get_magic_quotes_gpc())
					$value = stripslashes($value);
				//$this->propertyTable[$key] = mysql_real_escape_string($value);
			}
			else{
				$this->propertyTable[$key] = $value;
			}
		}
	}
	
	/**
	* This method is used to get the property value
	* @param : $key
	*/
	public function getProperty($key){
		if(array_key_exists($key, $this->propertyTable)){
			return $this->propertyTable[$key];
		}
		else{
			return NULL;
		}
	}
	
	/**
	* This method is used to check whether the property is set or not
	* @param : $key,$p
	*/
	public function isPropertySet($key, $p = "V"){
		if($p == "K")
			if(array_key_exists($key, $this->propertyTable))
				return true;
			else
				return false;
		else if($p == "V"){
			if(isset($this->propertyTable[$key]) && !empty($this->propertyTable[$key]))
				return true;
			else
				return false;
		}
	}
	
	/**
	* This method is used to dump the set properties
	*/
	public function getPropertyDump(){
		if(count($this->propertyTable) >= 1){
			print_r($this->propertyTable);
		}
	}
	
	/**
	* This method is used to unset the set property
	* @param : $key
	*/
	public function unsetProperty($key){
		if(isset($this->propertyTable[$key]) and array_key_exists($key, $this->propertyTable)){
			unset($this->propertyTable[$key]);
		}
	}

	/**
	* This method is used to reset the set property
	* @param : $key
	*/
	public function resetProperty(){
		$this->propertyTable = array();
	}
}
?>