<?php

class MapsDrawings extends Database{

    /**
	* This is the constructor of the class MapsDrawings
	*/
	public function __construct(){
		parent::__construct();
	}

	public function gett031project_albumsparent0()
	{
		$maxpid = $this->getProperty("maxpid");
		// $pdSQL = "SELECT albumid, pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$maxpid." and status=1 and parent_album=0 order by albumid desc";
		// return $this->dbQuery($pdSQL);
		
		$pdSQL = "SELECT albumid, pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$maxpid." and status=1 and parent_id=0 order by albumid desc";
		return $this->dbQuery($pdSQL);	
	}  

	public function gett031project_albums()
	{
		$maxpid = $this->getProperty("maxpid");
		$album_id = $this->getProperty("albumid");
		$pdSQL = "SELECT * FROM t031project_drawingalbums  WHERE pid= ".$maxpid." and status=1 and parent_id=".$album_id." order by albumid asc";
		return $this->dbQuery($pdSQL);	 
	}

	public function gett027project_photos()
	{
		$pid = $this->getProperty("maxpid");
		$album_id = $this->getProperty("albumid");
		$pdSQL_r = "SELECT dwgid, pid, al_file, dwg_title FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
			 
		return $this->dbQuery($pdSQL_r);	 
	}

	public function deletet027project_photos()
	{
		$dwgid = $this->getProperty("dwgid");
		$album_id = $this->getProperty("albumid");
		$pdSQL_r = "DELETE FROM t027project_drawings WHERE dwgid = ".$dwgid." AND album_id=".$album_id;
			 
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
		$pdSQL_r = "SELECT dwgid,album_id, pid, al_file, dwg_title FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." order by dwgid";
			 
		return $this->dbQuery($pdSQL_r);	 
	}


	public function gett031project_albums_alname()
	{
		$pid = $this->getProperty("maxpid");
		$album_id = $this->getProperty("albumid");
		$pdSQL11="SELECT albumid, pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and  albumid = ".$album_id;
			 
		return $this->dbQuery($pdSQL11);	 
	}


	public function getMaxPid()
	{
		$pSQL = "SELECT max(pid) as pid from project";

		return $this->dbQuery($pSQL);
	}

	public function getAllFolders()
	{
		$pid = $this->getProperty("maxpid");
		$pSQL = "SELECT * FROM  t031project_drawingalbums WHERE parent_id =0";

		return $this->dbQuery($pSQL);
	}

	public function getAllComponents()
	{
		$lid = $this->getProperty("lid");
		$pSQL = "SELECT * FROM  t031project_drawingalbums  WHERE  parent_id=".$lid." ";

		return $this->dbQuery($pSQL);
	}

	public function getAllSubComponents()
	{
		$lcid = $this->getProperty("lcid");
		$pSQL = "SELECT * FROM  t031project_drawingalbums  WHERE  parent_id=".$lcid." ";

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
		
		$pSQL = "INSERT INTO  locations_component(lid,pid,title) Values('$lid','$pid','$subtitle')";
	
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
		$album_id = $this->getProperty("album_id");
		$pSQL = "SELECT * FROM  t027project_drawings  WHERE pid=".$pid. " AND album_id='".$album_id."' ";

		return $this->dbQuery($pSQL);
	}


	public function setSpSubAlbum()
	{

  		$pid = $this->getProperty("pid");
		$album_name = $this->getProperty("album_name");
		$status = $this->getProperty("status");
		$parent_album = $this->getProperty("parental_id");
		
		$pSQL = "INSERT INTO t031project_drawingalbums(parent_id,parent_group,pid,album_name,status,user_ids, user_right, creater, creater_id,last_modified_by) 
		Values('$parent_album','','$pid', '$album_name', '$status','','' , '', '1', '')";
	
		// $message=  "New record added successfully";

		return $this->dbQuery($pSQL);
	}

	public function deleteSpSubAlbum()
	{

  		$albumid = $this->getProperty("albumid");
		
		$pSQL = "DELETE FROM t031project_drawingalbums WHERE albumid=".$albumid;
	
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
		
		$pSQL = "INSERT INTO t027project_drawings(pid, album_id, al_file, dwg_title, dwg_type) 
		Values('$pid','$album_id', '$alfile',  '$ph_cap', ' ')";
	
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