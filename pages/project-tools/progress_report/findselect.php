<?php
include_once("../../../config/config.php");
$ObjPictoAna = new PictorialAnalysis();
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );

error_reporting(E_ALL & ~E_NOTICE);
//@require_once("requires/session.php");
//$uname = $_SESSION['uname'];
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
$isentry		= $_REQUEST['isentry'];
$itemid		= $_REQUEST['itemid'];
//@require_once("get_url.php");
$sCondition = '';

?>

<?php                    
if($itemid>=2 && $itemid<3){
    ?>
    <option value="">Select Lot</option>
    <?php    
}
?>
<?php                    
if($itemid>=3 && $itemid<4){
    ?>
    <option value="">Select Component </option>
    <?php    
}
?>
<?php                    
if($itemid>=4 && $itemid<5){
    ?>
    <option value="">Select Supply/Erection</option>
    <?php    
}
?>
<?php                    
if($itemid>=5 ){
    ?>
    <option value="">Select Location</option>
    <?php    
}
?>
<?php
     $pdSQLcn2 = "SELECT * FROM boqdata WHERE parentcd=$itemid";
                             $objDb->dbQuery($pdSQLcn2);
                             while($itemcount =$objDb->dbFetchArray())
                             {
?>
       <option value=<?php echo $itemcount['itemid'];?>><?php echo $itemcount['itemname'];?></option>
       <?php              }?>

  </select>