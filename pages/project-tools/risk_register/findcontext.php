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
<select  id="risk_con_id" name="risk_con_id"  class="form-control"  style="font-size: 14px; color: #000;   background-color: rgba(255, 255, 255);" >
                        <option value="">Select Risk Context</option>

                        <?php
                        
                            $ObjPictoAna->setProperty("lid",$lid); 
                            $pictoalbumname = $ObjPictoAna->getAllContext(); 
                            while($rowsallcompo=$ObjPictoAna->dbFetchArray())
                            {
                                $lid = $rowsallcompo['lid'];
                                $ris_con_desc = $rowsallcompo['ris_con_desc'];
                                $risk_con_id=$rowsallcompo['risk_con_id'];
                        ?>
                        <option value="<?php echo $rowsallcompo['risk_con_id'];?>"><?php echo $ris_con_desc; ?></option>
                                  
                        <?php
                            }
                           ?>

  </select>