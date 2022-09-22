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
<select  id="item_id" name="item_id"  class="form-control"  style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);">
                        <option value="0">Select Major Component</option>

                        <?php
                        
                            $ObjPictoAna->setProperty("lid",$lid); 
                            $pictoalbumname = $ObjPictoAna->getAllMajor(); 
                            while($rowsallcompo=$ObjPictoAna->dbFetchArray())
                            {
                                $lid = $rowsallcompo['lid'];
                                $title = $rowsallcompo['title'];
                                $item_id=$rowsallcompo['item_id'];
                        ?>
                        <option value="<?php echo $rowsallcompo['item_id'];?>"><?php echo $title; ?></option>
                                  
                        <?php
                            }
                           ?>

  </select>