 <!--  @@ albums -->

 <div align="center" valign="top">
	<?php 
		 $cm=0;
			$pdSQL = "SELECT albumid, parent_id, parent_group,pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and parent_id=".$parent_id." order by albumid";
			 $ObjMapDrawing->dbQuery($pdSQL);
 				
			// $pdSQLResult = mysql_query($pdSQL);
			if($ObjMapDrawing-> totalRecords()>= 1){
			//if(mysql_num_rows($pdSQLResult) >= 1){
			?>
	 <div style="border:1px solid #000; border-radius:6px; vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; ">
	<div style="margin:0px; border:0px; padding:0px">
			
         
			<div width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
                            <?php  
			
		while($result =$ObjMapDrawing->dbFetchArray()){
				//while($result = mysql_fetch_array($pdSQLResult)){
				$album_id=$result['albumid'];
				
				$p_group=$result['parent_group'];
				$arr_gp=explode("_", $p_group);
				$get_album_id=$arr_gp[1];
				 $pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_id;
			// $pdSQLResult_get_right = mysql_query($pdSQL_get_right);
			$ObjMapDrawing->dbQuery($pdSQL_get_right);
			$result_get_right =$ObjMapDrawing->dbFetchArray();
			 //$result_get_right = mysql_fetch_array($pdSQLResult_get_right);
				
				 $pdSQL_r = "SELECT dwgid, pid, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
			 //$pdSQLResult_r = mysql_query($pdSQL_r);
			 $ObjMapDrawing2->dbQuery($pdSQL_r);
			if($ObjMapDrawing2-> totalRecords()>= 1)
			//if(mysql_num_rows($pdSQLResult_r) >= 1)
			{
			
				//$result_r = mysql_fetch_array($pdSQLResult_r);
				$result_r =$ObjMapDrawing2->dbFetchArray();
				$al_file_r=$result_r['al_file'];
			}
			else
			{
			$al_file_r="no_image.png";
			}
			if($_SESSION['ne_user_type']==1)
			{
				
				?>
				
            <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
 <!--    <a  href="javascript:void(null);" onclick="window.open('sp_photo.php?album_id=<?php echo $result['albumid'];?>', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none" >-->
	    <a  href="dm_drawingmap.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery" style="padding-top:35px">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url; ?>Drawing-icon.png">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?>				     </div>
	</div>
	</li>
	</div>

            <?php 
			
			$cm++;
			}
			else
			{
				
			
				$u_rightr=$result_get_right['user_right'];
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			   $arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}
						
						
					
			
				?>
			<div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
	<a  href="dm_drawingmap.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery" style="padding-top:35px">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url."Drawing-icon.png"; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?> </div>
	</div>
	</li>
	</div>
    <?php
			$cm++;
			}
				}
				
			}
			
			}?>
      	</div>
	
		</div>
		</div>
		<?Php
		}
		?>
		</div>
	<!-- @@ albums @@@ -->
	
	