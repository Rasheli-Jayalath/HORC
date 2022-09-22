<?php

class PictorialAnalysis extends Database{

    /**
	* This is the constructor of the class PictorialAnalysis
	*/
	public function __construct(){
		parent::__construct();
	}

	public function gett031project_albumsparent0()
	{
		$maxpid = $this->getProperty("maxpid");
		$pdSQL = "SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$maxpid." and status=1 and parent_album=0 order by albumid desc";
		return $this->dbQuery($pdSQL);	 
	}

	public function gett031project_albums()
	{
		$maxpid = $this->getProperty("maxpid");
		$album_id = $this->getProperty("albumid");
		$pdSQL = "SELECT * FROM t031project_albums  WHERE pid= ".$maxpid." and status=1 and parent_album=".$album_id." order by albumid asc";
		return $this->dbQuery($pdSQL);	 
	}

	public function getroject_album()
	{
		$maxpid = $this->getProperty("maxpid");
		$album_id = $this->getProperty("albumid");
		$pdSQL = "SELECT * FROM t031project_albums  WHERE pid= ".$maxpid." and status=1 and albumid=".$album_id." order by albumid asc";
		return $this->dbQuery($pdSQL);	 
	}

	public function gett027project_photos()
	{
		$pid = $this->getProperty("maxpid");
		$album_id = $this->getProperty("albumid");
		$pdSQL_r = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
			 
		return $this->dbQuery($pdSQL_r);	 
	}

	public function deletet027project_photos()
	{
		$phid = $this->getProperty("phid");
		$album_id = $this->getProperty("albumid");
		$pdSQL_r = "DELETE FROM t027project_photos WHERE phid = ".$phid." AND album_id=".$album_id;
			 
		return $this->dbQuery($pdSQL_r);	 
	}


	public function deletet027project_videos()
	{
		$vid = $this->getProperty("vid");
		$album_id = $this->getProperty("albumid");
		$pdSQL_r = "DELETE FROM t32project_videos WHERE vid = ".$vid." AND album_id=".$album_id;
			 
		return $this->dbQuery($pdSQL_r);	 
	}
	

	public function gett027project_video_selectvideos()
	{
		$pid = $this->getProperty("maxpid");
		$album_id = $this->getProperty("albumid");
		$pdSQL_r = "SELECT vid,album_id, pid,v_al_file, v_cap FROM t32project_videos WHERE pid = ".$pid." and album_id=".$album_id." order by vid";
			 
		return $this->dbQuery($pdSQL_r);	 
	}

	public function gett027project_photos_selectphotos()
	{
		$pid = $this->getProperty("maxpid");
		$album_id = $this->getProperty("albumid");
		$pdSQL_r = "SELECT phid,album_id, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." order by phid";
			 
		return $this->dbQuery($pdSQL_r);	 
	}


	public function gett031project_albums_alname()
	{
		$pid = $this->getProperty("maxpid");
		$album_id = $this->getProperty("albumid");
		$pdSQL11="SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$pid." and  albumid = ".$album_id;
			 
		return $this->dbQuery($pdSQL11);	 
	}


	public function getMaxPid()
	{
		$pSQL = "SELECT max(pid) as pid from project";

		return $this->dbQuery($pSQL);
	}
	public function getAllMajor()
	{
		$lid = $this->getProperty("lid");
		$pSQL = "SELECT * FROM  t014majoritems WHERE lid=".$lid." ";

		return $this->dbQuery($pSQL);
	}
	public function getAllContext()
	{
		$lid = $this->getProperty("lid");
		$pSQL = "SELECT * FROM  tbl_risk_register_context WHERE lid=".$lid." ";

		return $this->dbQuery($pSQL);
	}
	public function getAllComponents()
	{
		$pid = $this->getProperty("maxpid");
		$pSQL = "SELECT * FROM  locations WHERE pid=".$pid." order by lid";

		return $this->dbQuery($pSQL);
	}

	public function getAllSubComponents()
	{
		$lid = $this->getProperty("lid");
		$pSQL = "SELECT lcid,title FROM  locations_component  WHERE  lid=".$lid." order by title ASC";

		return $this->dbQuery($pSQL);
	}

	public function getAllDates()
	{
		$lid = $this->getProperty("lid");
		$lcid = $this->getProperty("lcid");

		$pSQL = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE  ph_cap=".$lid." and lcid=".$lcid." order by date_p  ASC";

		return $this->dbQuery($pSQL);
	}

	public function setLocationComponent()
	{
		$pid = $this->getProperty("pid");
		$title = $this->getProperty("title");
		
		$pSQL = "INSERT INTO locations(pid, title) Values('$pid','$title')";
	
		// $message=  "New record added successfully";

		return $this->dbQuery($pSQL);
	}

	public function setSubLocationComponent()
	{
		$lid = $this->getProperty("lid");
		$pid = $this->getProperty("pid");
		$subtitle = $this->getProperty("subtitle");
		
		$pSQL = "INSERT INTO  locations_component(lid,pid,title,giscode) Values('$lid','$pid','$subtitle','0')";
	
		// $message=  "New record added successfully";

		return $this->dbQuery($pSQL);
	}


	public function setProjectPhotos()
	{

  		$pid = $this->getProperty("pid");
		$file_name = $this->getProperty("file_name");
		$ph_cap = $this->getProperty("ph_cap");
		$lcid = $this->getProperty("lcid");
		$date_p = $this->getProperty("date_p");
		$giscode = $this->getProperty("giscode");
		
		$pSQL = "INSERT INTO  project_photos(pid, al_file,ph_cap,lcid,date_p,giscode) 
		Values('$pid', '$file_name', '$ph_cap','$lcid', '$date_p','$giscode' )";
	
		// $message=  "New record added successfully";

		return $this->dbQuery($pSQL);
	}

	public function getGisCode()
	{
		$lid = $this->getProperty("lid");
		$lcid = $this->getProperty("lcid");

		$pSQL = "SELECT giscode from locations_component where lid=".$lid." AND lcid=".$lcid;

		return $this->dbQuery($pSQL);
	}


	public function getGalleryPictures()
	{

		$pid = $this->getProperty("pid");
		$ph_cap = $this->getProperty("ph_cap");
		$lcid = $this->getProperty("lcid");
		$date_p = $this->getProperty("date_p");
		$date_p2 = $this->getProperty("date_p2");

		$pSQL = "SELECT a.phid, a.lcid,a.pid, a.al_file, a.ph_cap, a.date_p, b.title,b.lcid,b.lid 
		FROM  project_photos a inner join locations_component b on(a.lcid=b.lcid) WHERE a.pid=".$pid.
		" AND ph_cap='".$ph_cap."'"." AND a.lcid='".$lcid."'"." AND (date_p='".$date_p."'"." OR date_p='".$date_p2."' ) order by date_p DESC";

		return $this->dbQuery($pSQL);
	}


	public function setSpSubAlbum()
	{

  		$pid = $this->getProperty("pid");
		$album_name = $this->getProperty("album_name");
		$status = $this->getProperty("status");
		$parent_album = $this->getProperty("parental_id");
		
		$pSQL = "INSERT INTO t031project_albums(parent_album,parent_group,pid,album_name,status,user_ids, user_right, creater, creater_id,last_modified_by) 
		Values('$parent_album','','$pid', '$album_name', '$status','','' , '', '0100', '')";
	
		// $message=  "New record added successfully";

		return $this->dbQuery($pSQL);
	}

	public function deleteSpSubAlbum()
	{

  		$albumid = $this->getProperty("albumid");
		
		$pSQL = "DELETE FROM t031project_albums WHERE albumid=".$albumid;
	
		// $message=  "New record added successfully";

		return $this->dbQuery($pSQL);
	}

	

	public function setT027ProjectPhotos()
	{

  		$pid = $this->getProperty("pid");
		$orifile_name = $this->getProperty("orifile_name");
		$ph_cap = $this->getProperty("ph_cap");
		$alfile = $this->getProperty("alfile");
		$album_id = $this->getProperty("album_id");
		
		$pSQL = "INSERT INTO t027project_photos(pid, album_id, al_file, original_file_name,ph_cap) 
		Values('$pid','$album_id', '$alfile', '$orifile_name', '$ph_cap' )";
	
		// $message=  "New record added successfully";

		return $this->dbQuery($pSQL);
	}

	public function setT027ProjectVideos()
	{

  		$pid = $this->getProperty("pid");
		$v_cap = $this->getProperty("v_cap");
		$file_name = $this->getProperty("alfile");
		$album_id = $this->getProperty("album_id");
		
		$pSQL = "INSERT INTO t32project_videos(pid,album_id,v_cap,v_al_file) Values('$pid','$album_id', '$v_cap', '$file_name' )";
	
		// $message=  "New record added successfully";

		return $this->dbQuery($pSQL);
	}

	

	





	
	
	


	

}

?>