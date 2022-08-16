<?php	

	ob_start();
	session_cache_expire(30);
	define('PNAME',"PMIS");
	session_name(PNAME);
	session_start();
	//error_reporting(E_ALL & ~E_NOTICE);
	$dbCfg = array();
	include_once(dirname(__FILE__) . '/global_config.php');
	
	// database configuration
	if($_SERVER['HTTP_HOST'] == "localhost")
	{
		$dbCfg['host']			= "localhost";
		$dbCfg['db_user']		= "root";
		$dbCfg['db_passwd']		= "";
		$dbCfg['db_name']		= "pmst16_pmis";
	}
	
		/*********** Define the values *********/
		
			/**
	 * import()
	 *
	 * @param mixed $className
	 * @return
	 */
	function import($className){
		if($className && $className != ""){
			$className = "classes/class." . $className . ".php";
			if(file_exists(SITE_PATH . $className)){
				require_once(SITE_PATH . $className);
			}
		}
	}
		
		/**
	 * doDefine()
	 *
	 * @param mixed $configs
	 * @return
	 */
	function doDefine($configs){
		$str = "";
		if($configs){
			foreach($configs as $key=>$value){
				$str .= "define(\"" . strtoupper($key) . "\",\"" . $value . "\");\n";
			}
		}
		return $str;
	}
		
		/*********** Define the values *********/
	$defines = doDefine($_CONFIG);
	echo eval($defines);

/**
	 * redirect()
	 *
	 * @param string $url
	 * @param integer $refSecond
	 * @return
	 */
	function redirect($url = "", $refSecond = 0){
		header("Location:" . $url);
		die();
	}
  /**
	 * __autoload()
	 *
	 * @param string $class_name
	 * @return
	 */
	function __autoload($class_name){
		// class directories
		$dirs = array(
			'classes/',
			'classes/core/'
		);
		
		// for each directory
		foreach($dirs as $dir){
			// see if the file exsists
						if(file_exists(SITE_PATH . $dir . $class_name . '.php')){
				require_once(SITE_PATH . $dir . $class_name . '.php');
				// only require the class once, so quit after to save effort (if you got more, then name them something else
			return;
			}
		}
	}
	
	/*********** Define the values *********/
	define("HOST", $dbCfg['host']);
	define("DBUSER", $dbCfg['db_user']);
	define("DBPASSWD", $dbCfg['db_passwd']);
	define("DBNAME", $dbCfg['db_name']);
	// define("SITE_URL", 'ROOT_HOST');

	$host=HOST;
	$dbnmame=DBNAME;
	$con = new PDO("mysql:host=$host;dbname=$dbnmame;charset=UTF8", DBUSER, DBPASSWD, array(PDO::ATTR_PERSISTENT => true));

	// session_start();
	//$_SESSION["dbConnection"] = $con;
	
?>