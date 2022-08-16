<?php
require_once('../../../rs_lang.admin.php');
require_once('../../../rs_lang.eng.php');
include_once("../../../config/config.php");
//$ObjMapDrawing  = new  MapsDrawings();
//$ObjMapDrawing2 = new MapsDrawings();
//$ObjMapDrawing3 = new MapsDrawings();
//$ObjMapDrawing4 = new MapsDrawings();
//$user_cd=1;
//$_SESSION['ne_user_type']=1;
//$data_url="drawings/";
//$file_path="pictorial_data";
//$data_url="photos/";

 //$album_id=$_REQUEST['album_id'];

$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$query="'%000002_000003_000004_000005_%'";
$query2=5;
$package2=1;


if(isset($_REQUEST['view2']))
{


$package2=$_REQUEST['package2'];

}
if(isset($_REQUEST['view']))
{


  $query="";
$package=$_REQUEST['package'];
$lot=$_REQUEST['lot'];
$comp=$_REQUEST['comp'];
$location=$_REQUEST['location'];
$supp=$_REQUEST['supp'];
		
		
if(strlen($package)==1)
{
$parent_group="00000";
}
else if(strlen($package)==2)
{
$parent_group="0000";
}
else if(strlen($package)==3)
{
$parent_group="000";
}
else if(strlen($package)==4)
{
$parent_group="00";
}
else if(strlen($package)==5)
{
$parent_group="0";
}
else
{
$parent_group=$package;
}


	
  if(strlen($lot)==1)
  {
  $parent_group1="00000";
  }
  else if(strlen($lot)==2)
  {
  $parent_group1="0000";
  }
  else if(strlen($lot)==3)
  {
  $parent_group1="000";
  }
  else if(strlen($lot)==4)
  {
  $parent_group1="00";
  }
  else if(strlen($lot)==5)
  {
  $parent_group1="0";
  }
  else
  {
  $parent_group1=$lot;
  }


	
  if(strlen($comp)==1)
  {
  $parent_group2="00000";
  }
  else if(strlen($comp)==2)
  {
  $parent_group2="0000";
  }
  else if(strlen($comp)==3)
  {
  $parent_group2="000";
  }
  else if(strlen($comp)==4)
  {
  $parent_group2="00";
  }
  else if(strlen($comp)==5)
  {
  $parent_group2="0";
  }
  else
  {
  $parent_group2=$comp;
  }

	
  if(strlen($supp)==1)
  {
  $parent_group3="00000";
  }
  else if(strlen($supp)==2)
  {
  $parent_group3="0000";
  }
  else if(strlen($supp)==3)
  {
  $parent_group3="000";
  }
  else if(strlen($supp)==4)
  {
  $parent_group3="00";
  }
  else if(strlen($supp)==5)
  {
  $parent_group3="0";
  }
  else
  {
  $parent_group3=$supp;
  }
  
  if(strlen($location)==1)
  {
  $parent_group4="00000";
  }
  else if(strlen($location)==2)
  {
  $parent_group4="0000";
  }
  else if(strlen($location)==3)
  {
  $parent_group4="000";
  }
  else if(strlen($location)==4)
  {
  $parent_group4="00";
  }
  else if(strlen($location)==5)
  {
  $parent_group4="0";
  }
  else
  {
  $parent_group4=$location;
  }

if($package!=""){


$query="'%".$parent_group .$package."_%'";
$query2=$package;

}
if($lot!=""){
  $query=" '%".$parent_group .$package."_".$parent_group1.$lot."_%'";
  $query2=$lot;

  }
  if($comp!=""){
    $query=" '%".$parent_group .$package."_".$parent_group.$lot."_".$parent_group2.$comp."_%'";
    $query2=$comp;

    
    }
    if($supp!=""){
      $query=" '%".$parent_group .$package."_".$parent_group.$lot."_".$parent_group2.$comp."_".$parent_group3.$supp."_%'";
      $query2=$supp;

      }
    if($location!=""){
      $query="'%".$parent_group .$package."_".$parent_group.$lot."_".$parent_group2.$comp."_".$parent_group3.$supp."_".$parent_group4."_".$location."_%'";
      $query2=$location;

    }




     
}
                                            
                          $parentgroup=array();  
                          $qty=array();  
                          $rate=array();  
                          $amount=array();  

                          $pdSQLcn3 = "SELECT * FROM `boqdata` WHERE parentcd =$query2 ";

                          $objDb->dbQuery($pdSQLcn3);
                          while($itemcount =$objDb->dbFetchArray())
                          {
                            $parentgroup[]=$itemcount['parentgroup'];
                         



                          ?>

                          <?php
                            
                          }
                          $totals=array();
                          $total_final=0;   

                          foreach($parentgroup as $itemid){
                          $pdSQLcn = "SELECT SUM(boqqty*boq_cur_1_rate) AS total FROM boq a left join boqdata b on (a.itemid=b.itemid) WHERE b.parentgroup like '%".$itemid."%'";

                          $objDb->dbQuery($pdSQLcn);
                          $compdata =$objDb->dbFetchArray();
                          $totals[]=$compdata['total'];
                          $total_final=array_sum($totals);


                           }    





                          

                          

                                            

//@require_once("get_url.php");
//$user_cd=$uid;
$_SESSION['ne_user_type']=1;
$user_cd=1;
$pSQL = "SELECT max(pid) as pid from project";
$objDb->dbQuery($pSQL);
$pData =$objDb->dbFetchArray();
//$pData = mysql_fetch_array($pSQLResult);
 $pid=$pData["pid"];
//$edit			= $_GET['edit'];
//$objDb  		= new Database( );
//@require_once("get_url.php");
$file_path="issues/";


//===============================================

 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //include ('includes/metatag.php'); ?>
<script>
function doFilter(frm){
	var qString = '';
	if(frm.lid.value != ""){
		qString += 'lid=' + escape(frm.lid.value);
	}
	if(frm.iss_status.value != ""){
		qString += '&iss_status=' + escape(frm.iss_status.value);
	}
	
	document.location = 'project_issues_info.php?' + qString;
}


</script>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Project Issues</title>
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- bootstrap -->
  <style>

.margintopCSS {
          margin-top:10px;
        }   
        
        .text-34{
  background-color: #151563;
  border-radius: 10px;
  /* box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px; */
  padding-bottom: 12px;
  padding-top: 12px;
  border-radius: 5px 5px;
  color: white;
  font-size: 100%;
  /* margin-right: 5%; */
  /* right: 5%;
  left: 5%; */


}
.new_div li {
    list-style: outside none none;
}
        
.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("../../../images/images/frame.png") no-repeat scroll 0 0;
    float: left;
    height: 130px;
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
.text-33{
  background-color: #151563;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  padding-bottom: 8px;
  padding-top: 8px;
  border-radius: 0px 20px;
  color: white;
  /* margin-right: 5%; */
  /* right: 5%;
  left: 5%; */


}
/*table{
    border:  double ;

    }*/
.shadow_table{
	box-shadow: 0px 2px 5px 1px  rgba(0, 0, 0, 0.3);
	  border-radius: 6px;
}
	
.text_width_table{
	max-width: 350px;
    word-wrap: initial;
}
.table-striped{

  overflow-y: visible;
  overflow-x: visible;
  border-color: #1a1a7d;
  border-left: #151563;
}
.button-33 {
  background-color: #1a1a7d;
  border-radius: 10px;
  box-shadow: rgba(34, 34, 199, .2) 0 -25px 18px -14px inset,rgba(34, 34, 199, .15) 0 1px 2px,rgba(34, 34, 199, .15) 0 2px 4px,rgba(34, 34, 199, .15) 0 4px 8px,rgba(34, 34, 199, .15) 0 8px 16px,rgba(34, 34, 199, .15) 0 16px 32px;
  color: white;
  cursor: pointer;
  font-weight: 600;
  margin-left:1%;
  display: inline-block;
  font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
  padding: 5px 2px;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 13px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-33:hover {
  box-shadow: rgba(22, 22, 51,.35) 0 -25px 18px -14px inset,rgba(22, 22, 51,.25) 0 1px 2px,rgba(22, 22, 51,.25) 0 2px 4px,rgba(22, 22, 51,.25) 0 4px 8px,rgba(22, 22, 51,.25) 0 8px 16px,rgba(22, 22, 51,.25) 0 16px 32px;
  transform: scale(1.1) ;
}
.button-34 {
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(26, 26, 125);
  color: #1a1a7d;
  /* box-shadow: rgba(34, 34, 199, .02) 0 -25px 18px -14px inset,rgba(34, 34, 199, .05) 0 1px 2px,rgba(34, 34, 199, .05) 0 2px 4px,rgba(34, 34, 199, .05) 0 4px 8px,rgba(34, 34, 199, .05) 0 8px 16px,rgba(34, 34, 199, .10) 0 16px 32px; */
  box-shadow: none;
  padding: 15px 1px;
  border-radius: 0px;
  font-size: 73%;

  font-weight: 900;
  margin-left:0%;
}
.button-34:hover {
  background-color: #1f1f91;
  color: #fff;
  font-weight: 900;
  font-size: 75%;
  transform: scale(1.05) ;
}
.button-35 {

  padding: 12px 2px;

  font-size: 73%;
  font-weight: 700;
  margin-left:0%;
}
.button-35:hover {
  transform: scale(1.0) ;
  font-size: 85%;
}
.sm-unLine {

  font-weight: 600;
  /* text-decoration-line: underline;
  text-decoration: underline solid #1f1f91 1px;
  text-underline-position: under; */
  
  /* border-bottom: 3px solid #f9dd94; */
 
}

/* .sm-unLine::after {
  content: "";
  display: block;

  padding-top: 3px;
  border-bottom: 2px solid #f9dd94;
} */

/* #u-border-head {
  height:3px;
  background-color: rgba(31, 31, 145 );

  border-radius:10px 30px;
  padding:3.8px;
} */
 

    </style>


</head>
<body>
  <div class="container-scroller">
    
     <!-- partial:partials/_navbar.html -->
     <div id="partials-navbar"></div>
     <!-- partial -->
 
     <div class=" page-body-wrapper" id="pagebodywraper">
     
 
       <!-- partial:partials/_sidebar.html -->
       <div class="sidebar sidebar-offcanvas" id="partials-sidebar-offcanvas"></div>
       <!-- partial -->

      <div class="main-panel " id="mainpanel">
      <div class="content-wrapper" style="">



    
<h4 class="text-center text-34" style="  letter-spacing: 4px"> KFI Activity</h4> 

<div class="row pt-4 pb-4" >
	<div class="col-sm-2 " style="  font-weight: 600;">  
	<?php echo "KFI Activity";

?>
	</div>
	<div class="col-sm-10 text-end" >  
	<!-- <?php if($pid != ""&&$pid!=0){?>

<button type="button" class="col-sm-2 button-33" onclick="window.open('project_issues_input.php', 'newwindow', 'left=600,top=60,width=1000,height=680');return false;"> <?php echo ADD_NEW_REC;?> </button>
<button type="button" class="col-sm-2 button-33" onclick="location.href='project_issues_archieve.php';" >  <?php echo ARCH_ISS?> </button> -->
<?php } 

?>
	</div>
</div>

<div class="row pb-4 pt-3 text-start" >
<form action="" target="_self" method="post"  enctype="multipart/form-data"margin-top="5px">
<?php echo "Package"; ?>:  <select class="" id="package" name="package"  style="width:15%; margin-right: 1%;" onchange="getRisk(this.value);">
     	<option value="" ><?php echo "Select Packages" ?></option>
       <?php
       $pdSQLcn2 = "SELECT * FROM `boqdata` WHERE parentcd=1";
                               $objDb->dbQuery($pdSQLcn2);
                               while($itemcount =$objDb->dbFetchArray())
                               {
?>
       <option value=<?php echo $itemcount['itemid'];?><?php if($_REQUEST['package']==$itemcount['itemid']) {?> selected="selected" <?php }?>><?php echo $itemcount['itemname'];?></option>
         <?php              }
  		 
							
   ?>
  </select> 
  Lot : <select id="lot" name="lot"  style="width:15%;margin-right: 1%;" onchange="getRisk2(this.value);" >
  <option value="">Select Lot</option>
  
  </select>
  </select> 
  <lebel>Component : </lebel>
  <select id="comp" name="comp"  style="width:15%;margin-right: 1%; "  onchange="getRisk3(this.value);">
  <option value="">Select Component</option>

  </select>
  </select> Supply/Erection : <select id="supp" name="supp"  style="width:15%;margin-right: 1%;margin-top: 2%; "onchange="getRisk4(this.value);"  >
  <option value="">Select Supply/Erection</option> 
 
  
  </select>
  </select> 

 
 
  <div class="row">
  <div class="form-group row">



  <button  class="col-sm-2 button-33" type="submit" name="view" id="view" style="width:15%; margin-left: 70%; margin-top: 2%;"> <?php echo "VIEW";?> 
</div>
  </div>

  </form>
</div>

	


 
<div class="main-panel2" id="mainpanel2">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#full_report" role="tab" aria-controls="full_details" aria-selected="true">Detail Report </a>
                    </li>
                   
            
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#summary_report" role="tab" aria-selected="false">Summery Report</a>
                    </li>

                 
                  </ul>
                  <div>
                    <div class="btn-wrapper">
                     
                    </div>
                  </div>
                </div>


				<div class="tab-content tab-content-basic">

                 <div class="tab-pane fade show active" id="full_report" role="tabpanel" aria-labelledby="full_report"> 
                 	<div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
					  <h4 class="card-title text-center pt-4 pb-1">Detail Report</h4>
					  
					  <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                       
					 <div class="table-responsive">
           <table class="table table-striped">
                              <thead>
                                  <tr class="bg-form" style="font-size:12px; color:#CCC;" >
                                      <th colspan="3">&nbsp;</th>
                                      <th colspan="44">SUPPLY COMPONENT</th>
                                  </tr>
                                <tr class="bg-form" style="font-size:12px; color:#CCC;" >
                                  <th rowspan="4" >SL No.</th>
                                   <th rowspan="4">Item Description</th>
                                   <th rowspan="4"><?php echo "UNIT";?></th>

                                  <?php
                                   $pdSQLcn2 = "SELECT * FROM `boqdata` where parentcd=".$query2;
                               $objDb->dbQuery($pdSQLcn2);
                               while($itemcount =$objDb->dbFetchArray())
                               {
                                 $itemname=$itemcount['itemname'];
                                  ?>
                                  <th colspan="7"><?php echo "Supply of following items for ".$itemname;?></th>
                                  <?php
                                    }
                                ?>
                                  <th colspan="2"><?php echo "Total for Substation";?></th>



                                        </tr>
                                        <tr class="bg-form" style="font-size:12px; color:#CCC;">
                                            
                                        
                                       <?php
                              
                               foreach($totals as $total){

                                ?>

                                <th colspan="5"><?php echo "Supply Amount";?></th>
                                <th colspan="2"><?php echo round($total,2);?></th>   
                                <?php

                               }





                               ?>
                             
                                        <th colspan="1"><?php echo "Total Supply Amount";?></th>
                                        <th colspan="1"><?php echo $total_final;?></th>
                                         </tr>


                                        <tr class="bg-form" style="font-size:12px; color:#CCC;">
                                        <?php
                                        foreach($totals as $total){?>
                                        <th ><?php echo "QTY";?></th>
                                        <th ><?php echo "Rate";?></th>
                                        <th ><?php echo "Amount";?></th>
                                        <th ><?php echo "Assigned WT";?></th>
                                        <th ><?php echo "Sply Qty";?></th>
                                        <th ><?php echo "Actual Progress";?></th>
                                        <th ><?php echo "Weighted Progress";?></th>
                                              <?php
                                              }?>

                                        <th ><?php echo "Actual Progress";?></th>
                                        <th ><?php echo "Weighted Progress";?></th>
                                        </tr>
                                        
                                     
                              </thead>
                            
                             <tbody>
                               <?php
                               
                               $itemcode=array();
                             $pdSQLcn0 = "SELECT * FROM `calc_value` where parentgroup like ".$query." group by boqcode order by itemid";
                             $objDb->dbQuery($pdSQLcn0);
                             while($itemcount =$objDb->dbFetchArray())
                             {

                                $itemcode[]=$itemcount['boqcode'];

                             }
                             $sl==null;
                              $name==null;
                              $actprog_total=0;
                              $wtprog_total=0;

                             foreach($itemcode as $itemcode){
                               ?>
                                <tr>
                                <?php
                             foreach($parentgroup as $parentcd){

                                    $i=0;
                                  $pdSQLcn7 = "SELECT * FROM `calc_value` where boqcode='".$itemcode."' and parentgroup like '%".$parentcd."%' order by parentcd";
                                $objDb->dbQuery($pdSQLcn7);
                                  while($itemcount =$objDb->dbFetchArray())
                                  {
                                   

                                    if($sl==null && $name==null){
                                      $sl=$itemcount['boqcode'];
                                      $name=$itemcount['itemname'];
                                      $unit=$itemcount['unit'];
                                    ?>
                                      <td ><?php echo $sl;?></td>
                                      <td ><?php echo wordwrap(substr($name,0,50)."...",30,"<br>\n");?></td>
                                      <td ><?php echo $unit;?></td>

                                      <?php
                                    }
                                     
                                    $splqty=$itemcount['ipcqty'];
                                    $qty=$itemcount['qty'];
                                    $rate=$itemcount['rate'];
                                    $amount=$itemcount['amount'];
                                    
                                    ?>
                                   

                                      <td ><?php echo $qty;?></td>
                                      <td ><?php echo $rate;?></td>
                                      <td ><?php echo $amount;?></td>

                                      <?php
                                      if($totals[$i]>0 && $amount>0 ){   
                                        $asswt=    ($amount/$totals[$i])*100;                               ?>
                                      <td ><?php echo round( $asswt,3)."%";?></td>
                                      <?php
                                    }
                                    else{?>
                                 
                                      <td ><?php echo "0.00%";?></td>

                                      <?php  }?>
                                      <td ><?php echo $splqty;;?></td>
                                      <?php
                                      if($qty>0 && $splqty>0 ){ 
                                        $actprog=($splqty/$qty)*100; 
                                        $actprog_total=$actprog_total+$actprog_total;                               ?>
                                      <td ><?php echo round($actprog,3)."%";?></td>
                                      <?php
                                    }
                                    else{?>
                                 
                                      <td ><?php echo "0.00%";?></td>

                                      <?php  }
                                     $wtprog=$actprog*$asswt;
                                     $wtprog_total=$wtprog_total+$wtprog;
                                     ?>
                                    <td ><?php echo round($wtprog). "%";?></td>
                                      <?php   }
                       
                                    }

                          

                             
                             $sl=null;
                             $name=null;
                             ?>
                                                                 <td ><?php echo round($actprog_total). "%";?></td>
                                                                 <td ><?php echo round($wtprog_total). "%";?></td>

                                </tr>
                             <?php
                            }  ?>
                                                             <tr>
                                                  <?php         
                                                   $q=1 ;
                                                  
                                                  foreach($totals as $total){
                                                             if($q==1){ ?>
                                                             <td colspan="5" style="font-weight:bold ;text-align:right;"><?php echo "TOTAL";?></td>

                                                                 <td style="font-weight:bold ;" ><?php echo round($total);?></td>
                                                                 <td colspan="4"><?php echo round($wtprog_total). "%";?></td>
                                                                 <?php }
                                                                else{?>
                                                                  <td colspan="2" style="font-weight:bold ;text-align:right;"><?php echo "TOTAL";?></td>

                                                                <td style="font-weight:bold ;" ><?php echo round($total);?></td>
                                                                <td colspan="4"><?php echo round($wtprog_total). "%";?></td>

                                                                <?php }
                                                                $q=$q+1;
                                                                }?>
                                                             </tr>


                             





                             </tbody>
        </table>
		</div>
                          </div>
                        </div>
                      </div>
					  </div>
                      </div>
                </div>
              </div>
					 
              
                  <div class="tab-pane fade show"  name="summary_report" id="summary_report" role="summary_report" aria-labelledby="qual_report"> 
                     <div class="row">
                      <div class="col-sm-12">
                      <div class="col-lg-12 d-flex flex-column">
					  <h4 class="card-title text-center pt-4 pb-1">Summary Report</h4>
                      <div class="col-lg-12 grid-margin stretch-card">
					                <div class="card">
                <div class="card-body">
                <div class="row pb-4 pt-3 text-start" >
<form action="" target="_self" method="post"  enctype="multipart/form-data"margin-top="5px">
<?php echo "Report of"; ?>:  <select class="" id="package2" name="package2"  style="width:15%; margin-right: 1%;"">
     	<option value="1" ><?php echo "Implementation" ?></option>
       <option value="2" ><?php echo "Supply" ?></option>
       <option value="3" ><?php echo "Erection" ?></option>

      
  </select> 
  <button  class="col-sm-2 button-33" type="submit" name="view2" id="view2" style="width:15%; margin-left: 2%; margin-top: 2%;"> <?php echo "VIEW";?> 
   </form>
     </div>
 <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>


                                <tr class="bg-form" style="font-size:12px; color:#CCC;">

                                  <th > Activities</th>                                
                                  <th  > Assigned Weight (a)</th>
                                  
                                  <th  >  Actual Progress (b)</th>
                                  <th  > Weighted Progress   (c = a x b)</th>
                            
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                                                  







                                $supp_total=array();
                                $supp_group=array();
                                $sup_wt_total=array();
                                $sup_wt_group=array();

                                  $sql1="SELECT parentgroup FROM `boqdata` where itemcode = 'SUPPLY'";
                                  $objDb->dbQuery($sql1);
                                  while($suppcount =$objDb->dbFetchArray())
                                  {
                                      $supp_group[]=$suppcount['parentgroup'];
  
                                  }
                                  foreach($supp_group as $supp){

                                    $sql2 = "SELECT sum(amount) as total, sum(wtprog) as total2 FROM calc_value WHERE parentgroup like  '%".$supp."%'";
                                    
                                    $objDb->dbQuery($sql2);
                                    while($supp_total_c =$objDb->dbFetchArray())
                                    {
                                        $supp_total[]=$supp_total_c['total'];
                                        $sup_wt_total[]=$supp_total_c['total2'];
                                        
    
                                    }
                                    $supp_final_total=array_sum($supp_total);
                                  }


                                  $err_total=array();
                                  $err_group=array();
                                  $err_wt_total=array();
                                  $err_wt_group=array();
                                    $sql3="SELECT parentgroup FROM `boqdata` where itemcode = 'ERECTION' order by itemid";
                                    $objDb->dbQuery($sql3);
                                    while($suppcount =$objDb->dbFetchArray())
                                    {
                                        $err_group[]=$suppcount['parentgroup'];
                                    }
                                    foreach($err_group as $err){
                                        
                                      $sql4 = "SELECT sum(amount) as total, sum(wtprog) as total2  FROM calc_value WHERE parentgroup like '%".$err."%'";
                                      $objDb->dbQuery($sql4);
                                      while($supp_total_c =$objDb->dbFetchArray())
                                      {
                                          $err_total[]=$supp_total_c['total'];
                                          $err_wt_total[]=$supp_total_c['total2'];

      
                                      }
                                      $err_final_total=array_sum($err_total);
  
                                    }

                                    $calcf2=0;
                                    $wt2=0;
                                 
                                $pdSQLcn5 = "SELECT SUM(amount) as total FROM `calc_value`";
                                $objDb->dbQuery($pdSQLcn5);
                                while($itemcount =$objDb->dbFetchArray())
                                {
                                    $amount=$itemcount['total'];

                                }
                                $j=sizeof($err_total);
                                // $total_amount=array_sum($amount);
                                

                                $itemname=array();
                                $sql5 = "SELECT * FROM `boqdata` WHERE parentcd=(SELECT itemid FROM boqdata where itemcode='LOT001')";
                                $objDb->dbQuery($sql5);
                                while($supp_total_c =$objDb->dbFetchArray())
                                {
                                    $itemname[]=$supp_total_c['itemname'];

                                }
                                $k=0;
                                
                                  foreach($itemname as $item){
                                if($package2==1){
                                
                                ?> 
                                
                                  <tr>

                                    <td colspan="4" style="font-weight: bold;font-size:18px;"><?php echo $item;?></td>
                                  </tr><?php
                                  if($k<$j){?>
                                   
                                   <tr>
                                                                          <td style=><?php echo"Supply";?></td>

                                                                        <?php if($supp_total[$k]>0 && $amount>0){
                                                                          $calc1=($supp_total[$k]/$amount)*100;
                                                                          
                                                                          ?>
                                                                          
                                                                          <td ><?php echo round($calc1,2)."%";?></td>
                                                                        <?php 
                                                                        
                                                                        
                                                                        } 
                                                                        $wtprog=$sup_wt_total[$k]/6;
                                                                        $calc_s1=($calc1*$wtprog)
                                                                        ?>
                                                                        
                                                                          <td ><?php echo round($wtprog*100,3) ."%";?></td>
                                                                           <td ><?php echo round($calc_s1,3)."%";?></td>
                                                                        
                                                                        
                                                                          </tr>
                                    

                                                                                      <tr>
                                                                                      <td style=><?php echo "Civil / Erection";?></td>

                                                                                    <?php if($err_total[$k]>0 && $amount>0){
                                                                                      $calc2=($err_total[$k]/$amount)*100;
                                                                                      ?>
                                                                                      
                                                                                      <td ><?php echo round($calc2,2)."%";?></td>
                                                                                    <?php 
                                                                                    } 
                                                                                    $wtprog2=$err_wt_total[$k]/6;
                                                                                    $calc_e1=($calc2*$wtprog2)
                                                                                    ?>
                                                                                    
                                                                                      <td ><?php echo  round($wtprog2*100,3)."%";?></td>
                                                                                  
                                                                                      <td ><?php echo round( $calc_e1,3)."%";?></td>
                                                                                   
                                                                                    
                                                                                      </tr>
                                                                                
                                                                                <tr>
                                                                                <td style="font-weight: bold;"><?php echo"Total Weight ".$item.":";?></td>

                                                                              <?php
                                                                              $calcf=0;
                                                                                $calcf=$calc1+$calc2;
                                                                                $calcf2=$calcf2+$calcf;
                                                                               ?>
                                                                                
                                                                                <td style="font-weight: bold;"><?php echo round($calcf,2)."%";?></td>
                                                                              
                                                                                <td ><?php echo " ";?></td>

                                                                                <td ><?php echo " ";?></td>
                                                                              
                                                                              
                                                                                </tr>
                                    
                                    <tr>
                                    <td style="font-weight: bold;"><?php echo"Implementation Progress  ".$item.":";?></td>

                                   <?php 
                                   $wt1=0;
                                   $wt1=$calc_s1+$calc_e1;
                                   $wt2=$wt2+$wt1;
                                     ?>
                                    
                                    <td ><?php echo " ";?></td>
                                   
                                    <td ><?php echo " ";?></td>


                                
                                    <td style="font-weight: bold;"><?php echo round($wt1,3)."%";?></td>
                                  
                                   
                                    </tr>
                                    
                                    
                                    
   
                                    <tr>
                                    <td style="font-weight: bold;"><?php echo"% Completed  ".$item.":";?></td>

                                   
                                    
                                    <td ><?php echo " ";?></td>
                                   
                                    <td ><?php echo " ";?></td>

                                    <?php 
                                    $final=$wt1/$calcf;
                                    ?>
                             
                                    <td style="font-weight: bold;"><?php echo round($final*100,3)."%";?></td>
                                   
                                   
                                    </tr>
                                <?php  
                              $k=$k+1;  
                              }
                            }

                            if($package2==2){
                              $calcf=0;                                
                              ?> 
                              
                                <tr>

                                  <td colspan="4" style="font-weight: bold;font-size:18px;"><?php echo $item;?></td>
                                </tr><?php
                                if($k<$j){?>
                                 
                                 <tr>
                                                                        <td style=><?php echo"Supply";?></td>

                                                                      <?php if($supp_total[$k]>0 && $supp_final_total>0){
                                                                        $calc1=($supp_total[$k]/$supp_final_total)*100;
                                                                        
                                                                        ?>
                                                                        
                                                                        <td ><?php echo round($calc1,2)."%";?></td>
                                                                      <?php                                                                   
                                                                      
                                                                    } 
                                                                      $wtprog=$sup_wt_total[$k]/6;
                                                                      $calc_s1=($calc1*$wtprog);
                                                                      
                                                                      $calcf=$calcf+$calc1;
                                                                      $calcf2=$calcf2+$calcf;
                                                                      ?>
                                                                                                                                            
                                                                        <td ><?php echo round($wtprog*100,3) ."%";?></td>
                                                                        <td ><?php echo round($calc_s1,3)."%";?></td>
                                                                        </tr>
                                  

                                                                                
                                                                              
                                                                              <tr>
                                                                              <td style="font-weight: bold;"><?php echo"Total Weight ".$item.":";?></td>

                                                                            <?php
                                                                           
                                                                             ?>
                                                                              
                                                                              <td style="font-weight: bold;"><?php echo round($calcf,2)."%";?></td>
                                                                            
                                                                              <td ><?php echo " ";?></td>

                                                                              <td ><?php echo " ";?></td>
                                                                            
                                                                            
                                                                              </tr>
                                  
                                  <tr>
                                  <td style="font-weight: bold;"><?php echo"Implementation Progress  ".$item.":";?></td>

                                 <?php 
                                 $wt1=0;
                                 $wt1=$calc_s1+$calc_e1;
                                 $wt2=$wt2+$wt1;
                                   ?>
                                  
                                  <td ><?php echo " ";?></td>
                                 
                                  <td ><?php echo " ";?></td>


                              
                                  <td style="font-weight: bold;"><?php echo round($wt1,3)."%";?></td>
                                
                                 
                                  </tr>
                                  
                                  
                                  
 
                                  <tr>
                                  <td style="font-weight: bold;"><?php echo"% Completed  ".$item.":";?></td>

                                 
                                  
                                  <td ><?php echo " ";?></td>
                                 
                                  <td ><?php echo " ";?></td>

                                  <?php 
                                  $final=$wt1/$calcf;
                                  ?>
                           
                                  <td style="font-weight: bold;"><?php echo round($final*100,3)."%";?></td>
                                 
                                 
                                  </tr>
                              <?php  
                            $k=$k+1;  
                            }
                          }


                          if($package2==3){
                                
                            ?> 
                            
                              <tr>

                                <td colspan="4" style="font-weight: bold;font-size:18px;"><?php echo $item;?></td>
                              </tr><?php
                              if($k<$j){?>
                               
                                                                  
                                

                                                                                  <tr>
                                                                                  <td style=><?php echo "Civil / Erection";?></td>

                                                                                <?php if($err_total[$k]>0 && $err_final_total>0){
                                                                                  $calc2=($err_total[$k]/$err_final_total)*100;
                                                                                  ?>
                                                                                  
                                                                                  <td ><?php echo round($calc2,2)."%";?></td>
                                                                                <?php 
                                                                                } 
                                                                                $wtprog2=$err_wt_total[$k]/6;
                                                                                $calc_e1=($calc2*$wtprog2)
                                                                                ?>
                                                                                
                                                                                  <td ><?php echo  round($wtprog2*100,3)."%";?></td>
                                                                              
                                                                                  <td ><?php echo round( $calc_e1,3)."%";?></td>
                                                                               
                                                                                
                                                                                  </tr>
                                                                            
                                                                            <tr>
                                                                            <td style="font-weight: bold;"><?php echo"Total Weight ".$item.":";?></td>

                                                                          <?php
                                                                          $calcf=0;
                                                                            $calcf=$calc1+$calc2;
                                                                            $calcf2=$calcf2+$calcf;
                                                                           ?>
                                                                            
                                                                            <td style="font-weight: bold;"><?php echo round($calcf,2)."%";?></td>
                                                                          
                                                                            <td ><?php echo " ";?></td>

                                                                            <td ><?php echo " ";?></td>
                                                                          
                                                                          
                                                                            </tr>
                                
                                <tr>
                                <td style="font-weight: bold;"><?php echo"Implementation Progress  ".$item.":";?></td>

                               <?php 
                               $wt1=0;
                               $wt1=$calc_s1+$calc_e1;
                               $wt2=$wt2+$wt1;
                                 ?>
                                
                                <td ><?php echo " ";?></td>
                               
                                <td ><?php echo " ";?></td>


                            
                                <td style="font-weight: bold;"><?php echo round($wt1,3)."%";?></td>
                              
                               
                                </tr>
                                
                                
                                

                                <tr>
                                <td style="font-weight: bold;"><?php echo"% Completed  ".$item.":";?></td>

                               
                                
                                <td ><?php echo " ";?></td>
                               
                                <td ><?php echo " ";?></td>

                                <?php 
                                $final=$wt1/$calcf;
                                ?>
                         
                                <td style="font-weight: bold;"><?php echo round($final*100,3)."%";?></td>
                               
                               
                                </tr>
                            <?php  
                          $k=$k+1;  
                          }
                        }



                                  }
                                  ?>
                                

                                  <tr>
                                    <td style="font-weight: bold;"><?php echo"Total Contract Implementation: ";?></td>

                                  
                                                                                
                                                                                <td style="font-weight: bold;"><?php echo round($calcf2,2)."%";?></td>                                                                              
                                                                                <td ><?php echo " ";?></td>
                                                                                <td ><?php echo " ";?></td>
                                                                              </tr>

                                   <tr>
                                    <td style="font-weight: bold;"><?php echo"% Completed Contract Implementation:";?></td>

                                 
                                    
                                    <td ><?php echo " ";?></td>
                                   
                                    <td ><?php echo " ";?></td>


                                
                                    <td style="font-weight: bold;"><?php echo round($wt2,3)."%";?></td>
                                  
                                   
                                    </tr>

                                    <tr >
                                    <td colspan="4">

                                    </td>
                                  </tr>

                                  <tr>
                                    <td style="font-weight: bold;font-size:18px;"><?php echo"Total Contract Implementation: ";?></td>

                                  
                                                                                
                                                                                <td style="font-weight: bold;font-size:18px;"><?php echo round($calcf2,2)."%";?></td>                                                                              
                                                                                <td ><?php echo " ";?></td>
                                                                                <td ><?php echo " ";?></td>
                                                                              </tr>

                                   <tr>
                                    <td style="font-weight: bold;font-size:18px;"><?php echo"% Completed Contract Implementation:";?></td>

                                 
                                    
                                    <td ><?php echo " ";?></td>
                                   
                                    <td ><?php echo " ";?></td>


                                
                                    <td style="font-weight: bold;font-size:18px;"><?php echo round($wt2,3)."%";?></td>
                                  
                                   
                                    </tr>

                              </tbody>
		</div>
        </div>
        </div>
        </div>
  </div><!-- class="content-wrapper" -->
                   
  </div>
				  </div>
                   
                    </div>

   
        <!-- partial:../../partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->

         </div>     <!--content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <!-- <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script> -->
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../../js/chart.js"></script>
  <!-- <script src="../../js/navtype_session.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


  <!-- End custom js for this page-->



  <script>
    $(function(){
      $("#partials-navbar").load("../../../partials/_navbar.php");
    });
</script>

<script>
  $(function(){
    $("#partials-theme-setting-wrapper").load("../../../partials/_settings-panel.php");
  });
</script>

<script>
  $(function(){
    $("#partials-sidebar-offcanvas").load("../../../partials/_sidebar.php");
  });
</script>

<script>
$(function(){
  $("#partials-footer").load("../../../partials/_footer.php");
});
</script>


<script language="javascript" type="text/javascript">



</script>

<script>
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
	
function getDates(lcid,lid)
{
	
	if (lcid!=0) {
			var strURL="finddate.php?lid="+lid+"&lcid="+lcid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("location_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}
		else
		{
		
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
			
		}

}

function getCanals(lid)
{
 // alert(lid);
	
	if (lid!=0) {
			var strURL="findcanal.php?lid="+lid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
          
					if (req.readyState == 4) {
						// only if "OK"
            //alert(req.responseText);
						if (req.status == 200) {						
							document.getElementById("canal_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}
		else
		{
			document.getElementById("canal_name").value="0";
			document.getElementById('canal_name').disabled = true;
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
		}
		 

}


function getGalleryView(month) 
	{
	
		var location=document.getElementById("location").value;  
			
		if (month!="") {
			var strURL="findGalleryView.php?date_p="+month+" &location="+location;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('Gallery_View').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		   
	}

  function getRisk(itemid)
{
//  alert(itemid);
	
	if (itemid!=0) {
			var strURL="findselect.php?itemid="+itemid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
          
					if (req.readyState == 4) {
						// only if "OK"
            //alert(req.responseText);
						if (req.status == 200) {	
                  document.getElementById("lot").innerHTML=req.responseText;
               
               		
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}
		else
		{
			document.getElementById("canal_name").value="0";
			document.getElementById('canal_name').disabled = true;
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
		}
		 

}
function getRisk2(itemid)
{
//  alert(itemid);
	
	if (itemid!=0) {
			var strURL="findselect.php?itemid="+itemid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
          
					if (req.readyState == 4) {
						// only if "OK"
            //alert(req.responseText);
						if (req.status == 200) {	
                  document.getElementById("comp").innerHTML=req.responseText;
               
               		
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}
		else
		{
			document.getElementById("canal_name").value="0";
			document.getElementById('canal_name').disabled = true;
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
		}
		 

}
function getRisk3(itemid)
{
//  alert(itemid);
	
	if (itemid!=0) {
			var strURL="findselect.php?itemid="+itemid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
          
					if (req.readyState == 4) {
						// only if "OK"
            //alert(req.responseText);
						if (req.status == 200) {	
                  document.getElementById("supp").innerHTML=req.responseText;
               
               		
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}
		else
		{
			document.getElementById("canal_name").value="0";
			document.getElementById('canal_name').disabled = true;
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
		}
		 

}
function getRisk4(itemid)
{
//  alert(itemid);
	
	if (itemid!=0) {
			var strURL="findselect.php?itemid="+itemid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
          
					if (req.readyState == 4) {
						// only if "OK"
            //alert(req.responseText);
						if (req.status == 200) {	
                  document.getElementById("location").innerHTML=req.responseText;
               
               		
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		}
		else
		{
			document.getElementById("canal_name").value="0";
			document.getElementById('canal_name').disabled = true;
			document.getElementById("date_p").value="0";
			document.getElementById('date_p').disabled = true;
			document.getElementById("date_p2").value="0";
			document.getElementById('date_p2').disabled = true;
		}
		 

}
</script>

</body>
</html>
