<?php
include_once("../../../config/config.php");
$ObjPictoAna = new PictorialAnalysis();
error_reporting(E_ALL & ~E_NOTICE);
//@require_once("requires/session.php");
//$uname = $_SESSION['uname'];
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
$isentry		= $_REQUEST['isentry'];
$lid		= $_REQUEST['lid'];
//@require_once("get_url.php");
$sCondition = '';

?>
<select  id="canal_name" name="canal_name" onchange="getDates(this.value,<?php echo $lid;?>)"  class="form-control"  style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);">
                        <option value="0">Select Sub Component</option>

                        <?php
                        
                            $ObjPictoAna->setProperty("lid",$lid); 
                            $pictoalbumname = $ObjPictoAna->getAllSubComponents(); 
                            while($rowsallcompo=$ObjPictoAna->dbFetchArray())
                            {
                                $lcid = $rowsallcompo['lcid'];
                                $title = $rowsallcompo['title'];
                        ?>
                        <option value="<?php echo $lcid;?>"><?php echo $title;?></option>
                                  
                        <?php
                            }
                           ?>

  </select>