<?php
include_once("../../config/config.php");
$ObjKfiDash = new KfiDashboard();
$objDb  		= new Database();
$objDb1 		= new Database();
$objDb2 		= new Database();
 $prolvlid = $_GET['prolvlid'];

 if($prolvlid!="")
{
$str_g_query1 = "select * from boqdata where itemid=".$prolvlid;
				$str_g_result1 =  $objDb->dbQuery($str_g_query1);
				$str_g_data1 = $objDb->dbFetchArray();
				$is_entry=$str_g_data1["isentry"];
  $str_g_query = "select * from boqdata where parentcd=".$str_g_data1["itemid"];
				 	$objDb2->dbQuery($str_g_query);
					 $Count = $objDb2->totalRecords();
}
if($Count>0 || $is_entry==1)  
{
?>


<select class="form-control" id="subcatid_<?php echo $prolvlid; ?>" style="margin-top:5px;color: #444;" <?php if($is_entry==0){?>onchange="getsublevel(this);"<?php }else {?> onchange="getboqlevel(this);" <?php }?> name="subcatid_<?php echo $prolvlid; ?>" >
<option class="text-muted" value="0">Select BOQ Level..</option>

<?php
 
			  if($is_entry==1)
			  {
				$str_g_query = "select * from boq where itemid=".$prolvlid;
				$objDb1->dbQuery($str_g_query);
			  }
			  else
			  {
				  $str_g_query = "select * from boqdata where parentcd=".$prolvlid;
				 	$objDb1->dbQuery($str_g_query);
			   }
while($plevelrows=$objDb1->dbFetchArray())
{
				if($is_entry==1)
					{
					$value=$plevelrows['boqid']."-"."BOQ";
					$code=$plevelrows['boqcode'];
					$itemname=$plevelrows['boqitem'];
					}
					else
					{
					$value=$plevelrows['itemid'];
					$code=$plevelrows['itemcode'];
					$itemname=$plevelrows['itemname'];
					}
?>

<option value="<?php echo $value; ?>"><?php echo $code."-".$itemname; ?></option>; 

<?php
}
}

?>
</select>

