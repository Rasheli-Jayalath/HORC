<?php
$_CONFIG['site_name'] 			= "Project Monitoring and Management Information System (PMIS)";
$_CONFIG['site_short_name'] 	= "PMIS";

 if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "localhost:8070" || $_SERVER['HTTP_HOST'] == "117.254.109.209:8070" || $_SERVER['HTTP_HOST'] == "117.254.109.209")
{# For local
	$_CONFIG['site_url'] 		= "http://".$_SERVER['HTTP_HOST']."/HORC/";
	$_CONFIG['site_path'] 		= $_SERVER['DOCUMENT_ROOT'] . "/HORC/";
}
$_CONFIG['news_url']   = $_CONFIG['site_url'] . "pages/project-tools/news/news/";
$_CONFIG['news_path']  = $_CONFIG['site_path'] . "pages/project-tools/news/news/";

?>