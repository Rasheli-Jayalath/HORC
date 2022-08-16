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
$lcid		= $_REQUEST['lcid'];

$objDb  = new Database( );
//@require_once("get_url.php");
$sCondition = '';
?>
<select id="date_p" name="date_p"  class="form-control"  style="width: 160px;font-size: 14px; color: #000;background-color: rgba(255, 255, 255);">
     <option value="0">Date 1</option>


                 <?php
                        
                        $ObjPictoAna->setProperty("lid",$lid); 
                        $ObjPictoAna->setProperty("lcid",$lcid); 
                        $pictoalbumname = $ObjPictoAna->getAllDates(); 
                        while($rowsallcompo=$ObjPictoAna->dbFetchArray())
                        {
                            $date_p = $rowsallcompo['date_p'];
                    ?>
                    <option value="<?php echo $date_p;?>"><?php echo date('d-m-Y',strtotime($date_p));?></option>
                              
                    <?php
                        }
                       ?>
  </select>
  <select id="date_p2" name="date_p2"  class="form-control"  style="width: 160px;font-size: 14px; color: #000;background-color: rgba(255, 255, 255); margin-left: 10px;">
     <option value="0">Date 2</option>
  		
     <?php
                        
                        $ObjPictoAna->setProperty("lid",$lid); 
                        $ObjPictoAna->setProperty("lcid",$lcid); 
                        $pictoalbumname = $ObjPictoAna->getAllDates(); 
                        while($rowsallcompo=$ObjPictoAna->dbFetchArray())
                        {
                            $date_p = $rowsallcompo['date_p'];
                    ?>
                    <option value="<?php echo $date_p;?>"><?php echo date('d-m-Y',strtotime($date_p));?></option>
                              
                    <?php
                        }
                       ?>

  </select>

