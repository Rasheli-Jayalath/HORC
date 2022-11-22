<?php
include_once "../../../config/config.php";
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
$module			= "IPC Data";
$objDb  		= new Database();
$objDb1  		= new Database();
$objDb2  		= new Database();


?>

<?php
       
       if(isset($_REQUEST['update']))
       {
         $ipcvid = $_REQUEST['ipcvid'];
         $ipcqty = $_REQUEST['ipcqty'];
       $sql_update ="UPDATE ipcv_copy SET  ipcqty='$ipcqty' where ipcvid=$ipcvid ";
         $sql_proresult = $objDb1->dbQuery($sql_update);
       $message ;
       if ($sql_proresult == TRUE) {
         $message=  "Record updated successfully";
       } else {
       
         $message= "error in updating ";
       }

       }
       
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit IPC Record</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../../vendors/css/vendor.bundle.base.css">

  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="../../../css/basic-styles.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />
  
  <!-- CSS scrollbar style -->
  <link id="pagestyle" href="../../../css/scrollbarStyle.css" rel="stylesheet" />

 <!-- bootstrap -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- bootstrap -->
<script>
window.onunload = function(){
window.opener.location.reload();
};
				</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>
<style type="text/css">

.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}

</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 
<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	position: relative;
    display: inline-block;
	cursor:pointer;
   /* border-bottom: 1px dotted black;*/

}
.msg_head .tooltiptext {
	cursor:pointer;
    visibility: hidden;
    width: 80px;
    background-color: gray;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.msg_head:hover .tooltiptext {
    visibility: visible;
}
.msg_body{
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}

.new_div li {
    list-style: outside none none;
}

.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("./images/frame.png") no-repeat scroll 0 0;
    float: left;
    height: 90px;
    padding: 50px 0 0 6px;
    width: 152px;
	padding-left: 21px !important;
}
.imageTitle {
    color: #464646;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: normal;
}
.ms-WPBody a:link {
    color: #0072bc;
    text-decoration: none;
}
/*div a {
    color: #767676 !important;
    font-family: arial;
    font-size: 12px;
    line-height: 17px;
    text-decoration: none !important;
}*/
img {
    border: medium none;
}
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.9.2/jquery-ui.min.js"></script>

<script> 
$(document).ready(function () {
    var date = new Date();
    $('#dwg_date').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script> 
</head>
<body>
<script type="text/javascript">

function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
function required(){
	
		
	    var x = document.forms["form2"]["dwg_title"].value;
		var uploadPhoto = document.forms["form2"]["al_file"].value;
		var uploadPhoto_old = document.forms["form2"]["old_al_file"].value;
		
	
  if (x == "") {
    alert("Title must be filled out");
    return false;
  }
   if (uploadPhoto == "" && uploadPhoto_old == "") {
    alert("Photo must be uploaded first");
    return false;
  }
	
	
}


function doFilter(frm){
	var qString = '';
	if(frm.location.value != ""){
		qString += 'location=' + escape(frm.location.value);
	}
	
	if(frm.date_p.value != ""){
		qString += '&date_p=' + frm.date_p.value;
	}
	
}
</script>
<script type="text/javascript">
		 
 $(function() {
   $('#dwg_date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  


</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
   <link href="css/style.css" rel="stylesheet" /> 

   <div class="container-fluid">
    <div class=" grid-margin stretch-card " style = "margin-top: 3%;">
              <div class="card" style="background-image: linear-gradient(180deg, #f0f0fc, #f0f0fc);">
                <div class="card-body text-center">
                  <h4 class="card-title">Verify Details</h4>
				  <?php echo $message; ?>

          <?php
       
          if(isset($_GET['ipcvid'])) { 
            $verifiedIPCId = $_GET['ipcvid'];
            $sSQL = "SELECT * FROM ipcv_copy where ipcvid= $verifiedIPCId " ;
            $objDb2->dbQuery($sSQL);
            $j=0;
            $res_e2=$objDb2->dbFetchArray();
          }
          ?>
          
			
                  <form class="forms-sample pt-3" name="form2" action="edit_before_verify.php?ipcvid=<?php echo $verifiedIPCId; ?>" target="_self" method="post"  enctype="multipart/form-data" onSubmit="return required()"  >


					<div class="form-group row">
                    <div class="text-end col-sm-6"><label><?php echo "BOQ Details:";?></label>
                      </div>
                      <div class="text-start col-sm-6" >
					  <span style="font-weight:bold" ><?php echo $res_e2['boqdetail'];?></span>
                      </div>
           
                    </div>


				 
				<div class="form-group row">
                    <div class="text-end col-sm-6"> <label><?php echo "IPC QTY :";?></label> </div>
                      <div class="text-start col-sm-6">
                      <?php  if(isset($_REQUEST['update'])) { ?>
                        <span style=" " ><?php echo $res_e2['ipcqty'];?></span>
           <?php } else { ?>
					  <input class="form-control"  type="text" name="ipcqty" id="ipcqty" value="<?php echo $res_e2['ipcqty'];?>"  style="width: 60%;"  placeholder=" Revision No " Required>
            <?php } ?>  
          </div>
        </div>



				<div class="form-group row pt-3">
				     <div class="text-end col-sm-6">
             <?php  if(isset($_REQUEST['update'])) { ?>
				
					 <?php }else if(isset($_GET['ipcvid'])) { ?>

						<button class="btn btn-primary me-2" type="submit" name="update" id="update" value="Update" style="width:40%"> Update </button>
						<?php
						}
						else
						{
						?>
						<button  class="btn btn-primary me-2" type="submit" name="save" id="save" value="Save" style="width:40%"> Submit </button>
						<?php
						}
					?> 
						</div>
						<div class="text-start col-sm-6">
            <?php  if(isset($_REQUEST['update'])) { ?>
              <button  type="button" class="btn btn-light" name="cancel" id="cancel" value="Cancel"  style="width:40%"  onclick="cancelButton();">Close</button>
				
            <?php }else if(isset($_GET['ipcvid'])) { ?>
                 <button  type="button" class="btn btn-light" name="cancel" id="cancel" value="Cancel"  style="width:40%"  onclick="cancelButton();">Cancel</button>
            <?php
            }
            ?>
					
					</div>
				</div>


</form>

                </div>
              </div>
            </div>
</div>

					</body>
					</html>