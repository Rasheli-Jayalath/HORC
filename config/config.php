<?php	

	ob_start();
	session_cache_expire(30);
	define('PNAME',"horc");
	session_name(PNAME);
	session_start();
	//error_reporting(E_ALL & ~E_NOTICE);
	$dbCfg = array();
	include_once(dirname(__FILE__) . '/global_config.php');
	
	// database configuration
	if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "117.254.109.209:8070" || $_SERVER['HTTP_HOST'] == "117.254.109.209")
	{
		$dbCfg['host']			= "localhost";
		$dbCfg['db_user']		= "root";
		$dbCfg['db_passwd']		= "";
		$dbCfg['db_name']		= "mpsip_new_pmis";
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

	define('PROJECT',     		'ASSAM');
	define('RESOURCE',     		'Resources');
	define('MAINDATA',     		'Main Data');
	define('MDATA',     		'Milestone Data');
	define('STRATEGIC_GOAL',   	'Strategic Goal');
	define('OUTCOME',     		'Outcome');
	define('OUTPUT',  			'Output');
	define('ACTIVITY',     		'Activity');	
	define('MILESTONE',     	'Milestone');
	define('KPI',     			'KPI');
	define('KPIDATA',     		'KPI Data');
	define('CAMDATA',     		'CAM Data');
	define('CAM',     			'CAM');
	define('BOQDATA',     		'BOQ Data');
	define('MILDATA',     		'Milestone Data');
	define('BOQ',     			'BOQ');
	define('MIL',     			'Milestone');
	define('ADD_PROGRESS',     	'Add Progress');
	define('ADD_IPC',     		'Add IPC');
	define('EVADATA',     		'EVA Data');
	define('EVA',     			'EVA');

	$host=HOST;
	$dbnmame=DBNAME;
	$con = new PDO("mysql:host=$host;dbname=$dbnmame;charset=UTF8", DBUSER, DBPASSWD, array(PDO::ATTR_PERSISTENT => true));

	// session_start();
	//$_SESSION["dbConnection"] = $con;
	
?>