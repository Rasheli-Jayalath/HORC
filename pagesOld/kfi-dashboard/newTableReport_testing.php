<?php
include_once("../../config/config.php");
$objDb  		= new Database();
$objDb1 		= new Database();
$objDb2		= new Database();
$ObjKfiDash1 = new KfiDashboard();
$ObjKfiDash2 = new KfiDashboard();
$ObjKfiDash3 = new KfiDashboard();
$ObjKfiDash4 = new KfiDashboard();
$ObjKfiDash5 = new KfiDashboard();
$ObjKfiDash6 = new KfiDashboard();
$ObjKfiDash7 = new KfiDashboard();
$ObjKfiDash8 = new KfiDashboard();
$ObjKfiDash9 = new KfiDashboard();
$ObjKfiDash10 = new KfiDashboard();
$ObjKfiDash11 = new KfiDashboard();
$ObjKfiDash22 = new KfiDashboard();
$ObjKfiDash33 = new KfiDashboard();
$ObjKfiDash99 = new KfiDashboard();
$parentcd=NULL;
$lid=0;
$eSqls = "Select * from project_currency ";
  $objDb -> dbQuery($eSqls);
  $base_currFlag=false;
  $eeCount = $objDb->totalRecords();
	if($eeCount > 0){
		$res_e=$objDb->dbFetchArray();
	  $cur_1_rate 					= $res_e['cur_1_rate'];
	  $cur_2_rate 					= $res_e['cur_2_rate'];
	  $cur_3_rate 					= $res_e['cur_3_rate'];
	  $base_cur 				= $res_e['base_cur'];
	  $cur_1 					= $res_e['cur_1'];
	  $cur_2 					= $res_e['cur_2'];
	  $cur_3 					= $res_e['cur_3'];
	  
	  }
	  $find_pos=0;
 $itemids = $_GET['itemids'];
$find_pos=strpos($itemids,"BOQ");
if($find_pos==0)
{
$sql="SELECT * FROM boqdata where itemid=".$itemids;
	$objDb1->dbQuery($sql);
$pcdrows = $objDb1->dbFetchArray();
		$is_entry=$pcdrows["isentry"];
$itemname = $_GET['itemname'];
if(isset($itemids)&&$itemids!=0&&$itemids!='')
{
	$sql="SELECT parentcd FROM boqdata where itemid=".$itemids;
	$objDb->dbQuery($sql);
	 $iiCount = $objDb->totalRecords();
	 if($iiCount>0)
	 {
		$pcdrows = $objDb->dbFetchArray();
		$parentcd=$pcdrows["parentcd"];
	 }

}
if(isset($parentcd)&&$parentcd!=0&&$parentcd!='')
{
	 $sql_l="SELECT lid FROM boqdata where itemid=".$itemids;
	$objDb->dbQuery($sql_l);
	 $liCount = $objDb->totalRecords();
	 if($liCount>0)
	 {
		$lidrows = $objDb->dbFetchArray();
		$lid=$lidrows["lid"];
	 }
	 
	 if(isset($lid)&&$lid!=0)
	 {
		 $sql_l="SELECT max(ipcmonth) as maxdate FROM ipc where lid=".$lid;
		 $objDb->dbQuery($sql_l);
	 	 $ipcCount = $objDb->totalRecords();
		 if($ipcCount>0)
		 {
		$ipcrows = $objDb->dbFetchArray();
		$maxdate=$ipcrows["maxdate"]; 
		 }
		 
	 }
	 if(isset($lid)&&$lid!=0)
	 {
		 $sql_l="SELECT max(ipcno) as maxipcno FROM ipc where lid=".$lid;
		 $objDb->dbQuery($sql_l);
	 	 $ipcCount = $objDb->totalRecords();
		 if($ipcCount>0)
		 {
		$ipcrows = $objDb->dbFetchArray();
		$maxipcno=$ipcrows["maxipcno"]; 
		 }
		 
	 }

}
//Last Ipc Nummber

if(isset($parentcd)&&$parentcd!=0&&$parentcd!='')
{
$ObjKfiDash6->setProperty("lid",$lid);
$ObjKfiDash6->setProperty("ipcno",$maxipcno);
$ObjKfiDash6->setProperty("ipcmonth",$maxdate);
$lastipcid = $ObjKfiDash6->getLastIpcNo();
$lastipcidd="";
$lastipciddddd="";
while($lastipciddd=$ObjKfiDash6->dbFetchArray())
{
	
  $lastipcno=$lastipciddd['ipcno'];
  $lastipcidd=$lastipcno;
  $lastipciddddd=$lastipciddd['ipcid'];
  $lastipcidddddsubdate=$lastipciddd['ipcsubmitdate'];
}
if(isset($lastipcno))
	 {
		 $sql_l="SELECT max(ipcno) as maxipcno FROM ipc where lid=".$lid." AND ipcno<>'".$lastipcno."'";
		 $objDb->dbQuery($sql_l);
	 	 $ipcCount = $objDb->totalRecords();
		 if($ipcCount>0)
		 {
		$ipcrows = $objDb->dbFetchArray();
		$lastmaxipcno=$ipcrows["maxipcno"]; 
		 }
		 
	 }
//Second Last Ipc Nummber
$ObjKfiDash6->setProperty("lid",$lid);
$ObjKfiDash6->setProperty("lastipcno",$lastmaxipcno);
//$ObjKfiDash6->setProperty("ipcmonth",$maxdate);
$seclastipcid = $ObjKfiDash6->getSecondLastIpcNo();
$seclastipcidd="";
while($seclastipciddd=$ObjKfiDash6->dbFetchArray())
{
  $seclastipcidd=$seclastipciddd['ipcno'];
   $seclastipc_id=$seclastipciddd['ipcid'];
  $seclastipciddsubdate=$seclastipciddd['ipcsubmitdate'];
}
}
}
else
{
	$boqids=explode("-",$itemids);
	 $boqid=$boqids[0];
	$sql="SELECT * FROM boq where boqid=".$boqid;
	$objDb2->dbQuery($sql);
$pcdrows2 = $objDb2->dbFetchArray();
		$itemname = $_GET['itemname'];
		$itemids=$pcdrows2["itemid"];
	$sql="SELECT * FROM boqdata where itemid=".$itemids;
	$objDb1->dbQuery($sql);
$pcdrows = $objDb1->dbFetchArray();
		$is_entry=$pcdrows["isentry"];

if(isset($itemids)&&$itemids!=0&&$itemids!='')
{
	$sql="SELECT parentcd FROM boqdata where itemid=".$itemids;
	$objDb->dbQuery($sql);
	 $iiCount = $objDb->totalRecords();
	 if($iiCount>0)
	 {
		$pcdrows = $objDb->dbFetchArray();
		$parentcd=$pcdrows["parentcd"];
	 }

}
if(isset($parentcd)&&$parentcd!=0&&$parentcd!='')
{
	 $sql_l="SELECT lid FROM boqdata where itemid=".$itemids;
	$objDb->dbQuery($sql_l);
	 $liCount = $objDb->totalRecords();
	 if($liCount>0)
	 {
		$lidrows = $objDb->dbFetchArray();
		$lid=$lidrows["lid"];
	 }
	 
	 if(isset($lid)&&$lid!=0)
	 {
		 $sql_l="SELECT max(ipcmonth) as maxdate FROM ipc where lid=".$lid;
		 $objDb->dbQuery($sql_l);
	 	 $ipcCount = $objDb->totalRecords();
		 if($ipcCount>0)
		 {
		$ipcrows = $objDb->dbFetchArray();
		$maxdate=$ipcrows["maxdate"]; 
		 }
		 
	 }
	 if(isset($lid)&&$lid!=0)
	 {
		 $sql_l="SELECT max(ipcno) as maxipcno FROM ipc where lid=".$lid;
		 $objDb->dbQuery($sql_l);
	 	 $ipcCount = $objDb->totalRecords();
		 if($ipcCount>0)
		 {
		$ipcrows = $objDb->dbFetchArray();
		$maxipcno=$ipcrows["maxipcno"]; 
		 }
		 
	 }

}
//Last Ipc Nummber

if(isset($parentcd)&&$parentcd!=0&&$parentcd!='')
{
$ObjKfiDash6->setProperty("lid",$lid);
$ObjKfiDash6->setProperty("ipcno",$maxipcno);
$ObjKfiDash6->setProperty("ipcmonth",$maxdate);
$lastipcid = $ObjKfiDash6->getLastIpcNo();
$lastipcidd="";
$lastipciddddd="";
while($lastipciddd=$ObjKfiDash6->dbFetchArray())
{
	
  $lastipcno=$lastipciddd['ipcno'];
  $lastipcidd=$lastipcno;
  $lastipciddddd=$lastipciddd['ipcid'];
  $lastipcidddddsubdate=$lastipciddd['ipcsubmitdate'];
}
if(isset($lastipcno))
	 {
		 $sql_l="SELECT max(ipcno) as maxipcno FROM ipc where lid=".$lid." AND ipcno<>'".$lastipcno."'";
		 $objDb->dbQuery($sql_l);
	 	 $ipcCount = $objDb->totalRecords();
		 if($ipcCount>0)
		 {
		$ipcrows = $objDb->dbFetchArray();
		$lastmaxipcno=$ipcrows["maxipcno"]; 
		 }
		 
	 }
//Second Last Ipc Nummber
$ObjKfiDash6->setProperty("lid",$lid);
$ObjKfiDash6->setProperty("lastipcno",$lastmaxipcno);
//$ObjKfiDash6->setProperty("ipcmonth",$maxdate);
$seclastipcid = $ObjKfiDash6->getSecondLastIpcNo();
$seclastipcidd="";
while($seclastipciddd=$ObjKfiDash6->dbFetchArray())
{
  $seclastipcidd=$seclastipciddd['ipcno'];
   $seclastipc_id=$seclastipciddd['ipcid'];
  $seclastipciddsubdate=$seclastipciddd['ipcsubmitdate'];
}
}
}
 
?>
<!-- Table 1 goes here -->
<h4 style="margin-top:20px;text-align:center; font-weight:800" id="tabletitlename"><?php echo $itemname ?></h4>
<?php /*?><table   align="center" class="project"  height="265px">
	<tr ><td><div id="container" style="min-width: 310px;height:223px;"></div>
								 </td></tr></table><?php */?>
<?php if($is_entry==1)
{
	if(isset($boqid) && $boqid!=0 && $boqid!="")
	{ ?>
<table class="table table-bordered normaltextsize" id="tobeappliedtable" style="margin-top:20px">
         <tbody>

         <tr>
         <th rowspan="2">Sr. No. </th>
         <th rowspan="2"> Code </th>
         <th rowspan="2">Description </th>
         <th colspan="2">As Per Bid</th>
          <?php if($parentcd==0)
		 {?>
         <th colspan="2">Total Executed</th>
         
         <?php }
		 else
		 {?>
         <th colspan="2"  class="collapse.show collapse-horizontal" id="collapseWidthExample" style="">Paid Upto</br></br><?php echo $seclastipcidd ;?>- Dated ( <?php echo $seclastipciddsubdate ;?> )</th>
         <th colspan="2"  class="collapse.show collapse-horizontal" id="collapseWidthExample" style="">Paid in</br></br><?php echo $lastipcidd ;?>- Dated ( <?php echo $lastipcidddddsubdate ;?> )</th>
         <th colspan="2">Executed Upto</br></br><?php echo $lastipcidd ;?></th>
         <?php }?>
         <th colspan="1"> % in</br>Progress</th>

         <?php
                 $allipcss = $ObjKfiDash1->getAllIpcNo();
                 while($allipcss=$ObjKfiDash1->dbFetchArray())
                 {
                   ?>
                  <th colspan="2" class="collapse collapse-horizontal" id="collapseWidthExample" style=""><?php echo $allipcss['ipcno'] ?></br></br><?php echo $allipcss['ipcmonth'] ?></th>
                   <?php
                 }
                ?>



         </tr>
         <tr> 
             <th ><?php echo $cur_1;?> </th>
             <th ><?php echo $cur_2;?> </th>
              <?php if($parentcd==0)
		 	 {?>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_1;?> </th>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_2;?> </th>
             <?php }
			 else
			 {?>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_1;?> </th>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_2;?> </th>

             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_1;?> </th>                                                                                                                    
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_2;?> </th>                                                                                                                                           
             <th ><?php echo $cur_1;?> </th>                                                                                                                                          
             <th ><?php echo $cur_2;?> </th>   
             <?php }?>                                                                                                                                         
             <th >%</th>  

             <?php
                 $allipcss = $ObjKfiDash1->getAllIpcNo();
                 while($allipcss=$ObjKfiDash1->dbFetchArray())
                 {
                   ?>
                   <th class="collapse collapse-horizontal" id="collapseWidthExample"><?php echo $cur_1;?> </th>
                   <th class="collapse collapse-horizontal" id="collapseWidthExample"><?php echo $cur_2;?> </th>
                 <?php
                 }
                ?>
                                                                                    
         </tr>
         <!-- Table 1 goes here -->

         <?php

                $subTotalPkr = array();
                $subTotalUsd = array();

                $subTotalPkrIpc = array();
                $subTotalUsdIpc = array();

                $subTotalPkrIpcPin = array();
                $subTotalUsdIpcPin = array();

                $subTotalPkrIpcExupto = array();
                $subTotalUsdIpcExupto = array();

                $subTotalUsdIpcProgress = array();

                ///Monthly distribution
                $subTotalPkrIpcipcmonthly = array();

                $ObjKfiDash1->setProperty("boqid",$boqid);
                $kfiprojectlevel = $ObjKfiDash1->getBOQ_Data();//1201_1202 1201_1203 ... 1201_1216
				$planned = array();
				$actual =  array();
				$xaxis =   array();
                $i=1;
                while($plevelrows=$ObjKfiDash1->dbFetchArray())
                {
                  
                    $pkrtotal = array();
                    $usdtotal = array();

                    $pkripctotal = array();
                    $usdipctotal = array();

                    $pkripctotal_pin = array();
                    $usdipctotal_pin = array();

                    $pkripctotal_exupto = array();
                    $usdipctotal_exupto = array();

                    //////For Monthly distribution
                    $pkrtotalstack_asperbid = array();
                    $usdtotalstack_asperbid = array();
  
                    $pkrsingleid_fulllist_stack = array();
                    $usdsingleid_fulllist_stack = array();
                    //////For Monthly distribution


             /*   $ObjKfiDash2->setProperty("itemid",$plevelrows['itemid']);
                $kfirelatedids = $ObjKfiDash2->getItemsWithIstype2BOQ();

                while($plevelrowss=$ObjKfiDash2->dbFetchArray())
                 {*/
                  
                  // AS PER BID
                    $ObjKfiDash3->setProperty("boqitemid",$plevelrows['boqid']);
                    $kfidatafromboq = $ObjKfiDash3->getDataFromBoqLevel();

                    while($plevelrowsss=$ObjKfiDash3->dbFetchArray())
                    {
                    
                        $pktotal = $plevelrowsss['x'];
                        $ustotal = $plevelrowsss['y'];

                        array_push($pkrtotal,$pktotal);
                        array_push($usdtotal,$ustotal);
                        

                    }
                    // AS PER BID

                
                       
                        /// UP TO
                        $ObjKfiDash7->setProperty("boqid",$plevelrows['boqid']);
						//	$ObjKfiDash9->setProperty("lastipcid",$seclastipcidd);
                      //  $ObjKfiDash7->setProperty("lastipcid",$lastipciddddd);
					    $ObjKfiDash7->setProperty("lastipcid",$seclastipc_id);
                        $kfidatafromboq = $ObjKfiDash7->getAllIpcVBOQ();
                        while($plevelrowipcall=$ObjKfiDash7->dbFetchArray())
                          {
                            
                              $pkipctotal = $plevelrowipcall['zp'];
                              $usipctotal = $plevelrowipcall['qu'];
                               
                              array_push($pkripctotal,$pkipctotal);
                              array_push($usdipctotal,$usipctotal);

                          }
                          
                           ///// UP TO

                           /// Paid In
                        $ObjKfiDash9->setProperty("boqid",$plevelrows['boqid']);
						
                       $ObjKfiDash9->setProperty("lastipcid",$lastipciddddd);
					
                        $kfidatafromboqping = $ObjKfiDash9->getAllIpcVExupBOQ();
                        while($plevelrowipcallpin=$ObjKfiDash9->dbFetchArray())
                          {
                            
                              $pkipctotal_pin = $plevelrowipcallpin['xx'];
                              $usipctotal_pin = $plevelrowipcallpin['yy'];

                              array_push($pkripctotal_pin,$pkipctotal_pin);
                              array_push($usdipctotal_pin,$usipctotal_pin);

                          }
                           /// Paid In

                            /// PAID excy up to
                        $ObjKfiDash8->setProperty("boqid",$plevelrows['boqid']);
                        $ObjKfiDash8->setProperty("lastipcid",$lastipciddddd);
                        $kfidatafromboqexupto = $ObjKfiDash8->getAllIpcVPInBOQ();
                        while($plevelrowipcallexup=$ObjKfiDash8->dbFetchArray())
                          {
                            
                              $pkipctotal_exupto = $plevelrowipcallexup['xx'];
                              $usipctotal_exupto = $plevelrowipcallexup['yy'];

                              array_push($pkripctotal_exupto,$pkipctotal_exupto);
                              array_push($usdipctotal_exupto,$usipctotal_exupto);
                               
                          }
                          /// PAID excy up to



              

					$planned[] = $pktotal;
					$actual[] =  $pkipctotal_exupto;
					$xaxis[] = $plevelrows['boqitem'];
                  /////Monthly Distribution
                  $allipcss = $ObjKfiDash11->getAllIpcNo();
                  while($allipcss=$ObjKfiDash11->dbFetchArray())//1
                  {
                  $pkrsingleid_stack = array();
                  $usdsingleid_stack = array();

                  

                          $ObjKfiDash2->setProperty("boqid",$plevelrows['boqid']);//parentgroup 1201_1204
                          $kfirelatedids = $ObjKfiDash2->getItemsWithBOQ();
                          while($plevelrowss=$ObjKfiDash2->dbFetchArray())//for parentgroup 1201_1204 - itemids : 1219,1220,...1233
                          {

                              /// Paid In
                                $ObjKfiDash33->setProperty("boqid",$plevelrows['boqid']);//1219 1220 1221 ... 1233
                                $ObjKfiDash33->setProperty("lastipcid",$allipcss['ipcid']);
                                $kfidatafromboqping = $ObjKfiDash33->getAllIpcVExupBOQ();
                                while($plevelrowipcallpin=$ObjKfiDash33->dbFetchArray())
                                  {
                                    
                                      $pkripctotal_pinn = $plevelrowipcallpin['xx'];
                                      $usdipctotal_pinn = $plevelrowipcallpin['yy'];

                                      array_push($pkrsingleid_stack,$pkripctotal_pinn);
                                     array_push($usdsingleid_stack,$usdipctotal_pinn);

                                  }
                                /// Paid In
                              
                          }                                          
                                array_push($pkrsingleid_fulllist_stack,array_sum($pkrsingleid_stack));
                                array_push($usdsingleid_fulllist_stack,array_sum($usdsingleid_stack));

                       
                  }
                  array_push($subTotalPkrIpcipcmonthly,array_sum($pkrsingleid_fulllist_stack));

                  //////Monthly Distribution

                      
                //}

                if($pkrtotal!="" || $pkrtotal!=0)
                {
                array_push($subTotalPkr,array_sum($pkrtotal));
                array_push($subTotalUsd,array_sum($usdtotal));
                array_push($subTotalPkrIpc,array_sum($pkripctotal));
                array_push($subTotalUsdIpc,array_sum($usdipctotal));
                array_push($subTotalPkrIpcPin,array_sum($pkripctotal_pin));
                array_push($subTotalUsdIpcPin,array_sum($usdipctotal_pin));
                array_push($subTotalPkrIpcExupto,array_sum($pkripctotal_exupto));
                array_push($subTotalUsdIpcExupto,array_sum($usdipctotal_exupto));

                }

                if(array_sum($pkrtotal)>0)
                {
                  $resultpro = number_format((float)(array_sum($pkripctotal_exupto)/array_sum($pkrtotal)*100),2,'.','');
                
                  if($resultpro>100)
                  {
                    $textcolor = "red";
                    $btncolor = "link-danger";

                  }
                  else
                  {
                    $textcolor = "black";
                    $btncolor = "link-primary";
                  }
                  
                }
                else
                {
                  $resultpro = 0;

                  
                  if($resultpro>100)
                  {
                    $textcolor = "red";
                    $btncolor = "link-danger";

                  }
                  else
                  {
                    $textcolor = "black";
                    $btncolor = "link-primary";
                  }
                }
                

                ?>

                <!-- Table Row -->
                <tr >
                        <td style="color:<?php echo $textcolor?>;" ><?php echo $i++ ?></td>
                        <td style="color:<?php echo $textcolor?>;"><?php /*?><a href="#"class="<?php echo $btncolor ?>" 
                        onclick="reportgenButton('<?php echo $plevelrows['boqid'] ?>','<?php echo $plevelrows['boqitem'] ?>')"><?php */?><?php echo $plevelrows['boqcode'] ?><?php /*?></a><?php */?></td>
                        <td style="color:<?php echo $textcolor?>;" nowrap="nowrap"><?php  $boq_length=strlen($plevelrows['boqitem']);
						if($boq_length>30)
						{
							echo substr($plevelrows['boqitem'],0,29)."...";
						}
						else
						{
							echo $plevelrows['boqitem'];
						}?> </td> 


                        <?php
                        if($pkrtotal!="" || $pkrtotal!=0)
                        {

                            ?>
                            <td style="color:<?php echo $textcolor?>; text-align: right;"><?php echo number_format(array_sum($pkrtotal))  ?></td>
                            <td style="color:<?php echo $textcolor?>; text-align: right;"><?php echo number_format(array_sum($usdtotal)) ?></td>

                            <?php
                        }
                        else{
                            ?>
                            <td style="color:<?php echo $textcolor?>;text-align: right;">0.00</td>
                            <td style="color:<?php echo $textcolor?>;text-align: right;">0.00</td>

                            <?php
                        }
                        

                        ?>

            			<?php if($parentcd==0)
		 	 {?>
                        
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal)) ?> </td>
                        <?php }
						else
						{?>
                           <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal_pin)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal_pin)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal_exupto)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal_exupto)) ?> </td>
                        <?php }?>
                        <td style="color:<?php echo $textcolor?>;text-align: right;" ><?php echo $resultpro ?>%</td>
                       
                        <?php
                              
                              $allipcss = $ObjKfiDash11->getAllIpcNo();
                              $pd =0;
                              while($allipcss=$ObjKfiDash11->dbFetchArray())
                              {
                            
                            ?>

                            <td class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;" ><?php echo number_format($pkrsingleid_fulllist_stack[$pd]) ?></td>
                            <td class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;" ><?php echo number_format($usdsingleid_fulllist_stack[$pd]) ?></td>
                            

                            <?php
                            $pd++;
                              }
				}?>
                      
                      
                      
                      </tr>

                         
                <?php  
            
//}
            ?>

         
         
         </tbody>
    
     </table>
 <?php }
 else
 {  ?>
     <table class="table table-bordered normaltextsize" id="tobeappliedtable" style="margin-top:20px">
         <tbody>

         <tr>
         <th rowspan="2">Sr. No. </th>
         <th rowspan="2"> Code </th>
         <th rowspan="2">Description </th>
         <th colspan="2">As Per Bid</th>
          <?php if($parentcd==0)
		 {?>
         <th colspan="2">Total Executed</th>
         
         <?php }
		 else
		 {?>
         <th colspan="2"  class="collapse.show collapse-horizontal" id="collapseWidthExample" style="">Paid Upto</br></br><?php echo $seclastipcidd ;?>- Dated ( <?php echo $seclastipciddsubdate ;?> )</th>
         <th colspan="2"  class="collapse.show collapse-horizontal" id="collapseWidthExample" style="">Paid in</br></br><?php echo $lastipcidd ;?>- Dated ( <?php echo $lastipcidddddsubdate ;?> )</th>
         <th colspan="2">Executed Upto</br></br><?php echo $lastipcidd ;?></th>
         <?php }?>
         <th colspan="1"> % in</br>Progress</th>

         <?php
                 $allipcss = $ObjKfiDash1->getAllIpcNo();
                 while($allipcss=$ObjKfiDash1->dbFetchArray())
                 {
                   ?>
                  <th colspan="2" class="collapse collapse-horizontal" id="collapseWidthExample" style=""><?php echo $allipcss['ipcno'] ?></br></br><?php echo $allipcss['ipcmonth'] ?></th>
                   <?php
                 }
                ?>



         </tr>
         <tr> 
             <th ><?php echo $cur_1;?> </th>
             <th ><?php echo $cur_2;?> </th>
              <?php if($parentcd==0)
		 	 {?>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_1;?> </th>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_2;?> </th>
             <?php }
			 else
			 {?>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_1;?> </th>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_2;?> </th>

             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_1;?> </th>                                                                                                                    
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_2;?> </th>                                                                                                                                           
             <th ><?php echo $cur_1;?> </th>                                                                                                                                          
             <th ><?php echo $cur_2;?> </th>   
             <?php }?>                                                                                                                                         
             <th >%</th>  

             <?php
                 $allipcss = $ObjKfiDash1->getAllIpcNo();
                 while($allipcss=$ObjKfiDash1->dbFetchArray())
                 {
                   ?>
                   <th class="collapse collapse-horizontal" id="collapseWidthExample"><?php echo $cur_1;?> </th>
                   <th class="collapse collapse-horizontal" id="collapseWidthExample"><?php echo $cur_2;?> </th>
                 <?php
                 }
                ?>
                                                                                    
         </tr>
         <!-- Table 1 goes here -->

         <?php

                $subTotalPkr = array();
                $subTotalUsd = array();

                $subTotalPkrIpc = array();
                $subTotalUsdIpc = array();

                $subTotalPkrIpcPin = array();
                $subTotalUsdIpcPin = array();

                $subTotalPkrIpcExupto = array();
                $subTotalUsdIpcExupto = array();

                $subTotalUsdIpcProgress = array();

                ///Monthly distribution
                $subTotalPkrIpcipcmonthly = array();

                $ObjKfiDash1->setProperty("itemids",$itemids);
                $kfiprojectlevel = $ObjKfiDash1->getBOQ_LevelData();//1201_1202 1201_1203 ... 1201_1216
				$planned = array();
				$actual =  array();
				$xaxis =   array();
                $i=1;
                while($plevelrows=$ObjKfiDash1->dbFetchArray())
                {
                  
                    $pkrtotal = array();
                    $usdtotal = array();

                    $pkripctotal = array();
                    $usdipctotal = array();

                    $pkripctotal_pin = array();
                    $usdipctotal_pin = array();

                    $pkripctotal_exupto = array();
                    $usdipctotal_exupto = array();

                    //////For Monthly distribution
                    $pkrtotalstack_asperbid = array();
                    $usdtotalstack_asperbid = array();
  
                    $pkrsingleid_fulllist_stack = array();
                    $usdsingleid_fulllist_stack = array();
                    //////For Monthly distribution


             /*   $ObjKfiDash2->setProperty("itemid",$plevelrows['itemid']);
                $kfirelatedids = $ObjKfiDash2->getItemsWithIstype2BOQ();

                while($plevelrowss=$ObjKfiDash2->dbFetchArray())
                 {*/
                  
                  // AS PER BID
                    $ObjKfiDash3->setProperty("boqitemid",$plevelrows['boqid']);
                    $kfidatafromboq = $ObjKfiDash3->getDataFromBoqLevel();

                    while($plevelrowsss=$ObjKfiDash3->dbFetchArray())
                    {
                    
                        $pktotal = $plevelrowsss['x'];
                        $ustotal = $plevelrowsss['y'];

                        array_push($pkrtotal,$pktotal);
                        array_push($usdtotal,$ustotal);
                        

                    }
                    // AS PER BID

                
                       
                        /// UP TO
                        $ObjKfiDash7->setProperty("boqid",$plevelrows['boqid']);
						//	$ObjKfiDash9->setProperty("lastipcid",$seclastipcidd);
                      //  $ObjKfiDash7->setProperty("lastipcid",$lastipciddddd);
					    $ObjKfiDash7->setProperty("lastipcid",$seclastipc_id);
                        $kfidatafromboq = $ObjKfiDash7->getAllIpcVBOQ();
                        while($plevelrowipcall=$ObjKfiDash7->dbFetchArray())
                          {
                            
                              $pkipctotal = $plevelrowipcall['zp'];
                              $usipctotal = $plevelrowipcall['qu'];
                               
                              array_push($pkripctotal,$pkipctotal);
                              array_push($usdipctotal,$usipctotal);

                          }
                          
                           ///// UP TO

                           /// Paid In
                        $ObjKfiDash9->setProperty("boqid",$plevelrows['boqid']);
						
                       $ObjKfiDash9->setProperty("lastipcid",$lastipciddddd);
					
                        $kfidatafromboqping = $ObjKfiDash9->getAllIpcVExupBOQ();
                        while($plevelrowipcallpin=$ObjKfiDash9->dbFetchArray())
                          {
                            
                              $pkipctotal_pin = $plevelrowipcallpin['xx'];
                              $usipctotal_pin = $plevelrowipcallpin['yy'];

                              array_push($pkripctotal_pin,$pkipctotal_pin);
                              array_push($usdipctotal_pin,$usipctotal_pin);

                          }
                           /// Paid In

                            /// PAID excy up to
                        $ObjKfiDash8->setProperty("boqid",$plevelrows['boqid']);
                        $ObjKfiDash8->setProperty("lastipcid",$lastipciddddd);
                        $kfidatafromboqexupto = $ObjKfiDash8->getAllIpcVPInBOQ();
                        while($plevelrowipcallexup=$ObjKfiDash8->dbFetchArray())
                          {
                            
                              $pkipctotal_exupto = $plevelrowipcallexup['xx'];
                              $usipctotal_exupto = $plevelrowipcallexup['yy'];

                              array_push($pkripctotal_exupto,$pkipctotal_exupto);
                              array_push($usdipctotal_exupto,$usipctotal_exupto);
                               
                          }
                          /// PAID excy up to



              

					$planned[] = $pktotal;
					$actual[] =  $pkipctotal_exupto;
					$xaxis[] = $plevelrows['boqitem'];
                  /////Monthly Distribution
                  $allipcss = $ObjKfiDash11->getAllIpcNo();
                  while($allipcss=$ObjKfiDash11->dbFetchArray())//1
                  {
                  $pkrsingleid_stack = array();
                  $usdsingleid_stack = array();

                  

                          $ObjKfiDash2->setProperty("itemid",$plevelrows['itemid']);//parentgroup 1201_1204
                          $kfirelatedids = $ObjKfiDash2->getItemsWithIstype2BOQ();
                          while($plevelrowss=$ObjKfiDash2->dbFetchArray())//for parentgroup 1201_1204 - itemids : 1219,1220,...1233
                          {

                              /// Paid In
                                $ObjKfiDash33->setProperty("boqid",$plevelrows['boqid']);//1219 1220 1221 ... 1233
                                $ObjKfiDash33->setProperty("lastipcid",$allipcss['ipcid']);
                                $kfidatafromboqping = $ObjKfiDash33->getAllIpcVExupBOQ();
                                while($plevelrowipcallpin=$ObjKfiDash33->dbFetchArray())
                                  {
                                    
                                      $pkripctotal_pinn = $plevelrowipcallpin['xx'];
                                      $usdipctotal_pinn = $plevelrowipcallpin['yy'];

                                      array_push($pkrsingleid_stack,$pkripctotal_pinn);
                                     array_push($usdsingleid_stack,$usdipctotal_pinn);

                                  }
                                /// Paid In
                              
                          }                                          
                                array_push($pkrsingleid_fulllist_stack,array_sum($pkrsingleid_stack));
                                array_push($usdsingleid_fulllist_stack,array_sum($usdsingleid_stack));

                       
                  }
                  array_push($subTotalPkrIpcipcmonthly,array_sum($pkrsingleid_fulllist_stack));

                  //////Monthly Distribution

                      
                //}

                if($pkrtotal!="" || $pkrtotal!=0)
                {
                array_push($subTotalPkr,array_sum($pkrtotal));
                array_push($subTotalUsd,array_sum($usdtotal));
                array_push($subTotalPkrIpc,array_sum($pkripctotal));
                array_push($subTotalUsdIpc,array_sum($usdipctotal));
                array_push($subTotalPkrIpcPin,array_sum($pkripctotal_pin));
                array_push($subTotalUsdIpcPin,array_sum($usdipctotal_pin));
                array_push($subTotalPkrIpcExupto,array_sum($pkripctotal_exupto));
                array_push($subTotalUsdIpcExupto,array_sum($usdipctotal_exupto));

                }

                if(array_sum($pkrtotal)>0)
                {
                  $resultpro = number_format((float)(array_sum($pkripctotal_exupto)/array_sum($pkrtotal)*100),2,'.','');
                
                  if($resultpro>100)
                  {
                    $textcolor = "red";
                    $btncolor = "link-danger";

                  }
                  else
                  {
                    $textcolor = "black";
                    $btncolor = "link-primary";
                  }
                  
                }
                else
                {
                  $resultpro = 0;

                  
                  if($resultpro>100)
                  {
                    $textcolor = "red";
                    $btncolor = "link-danger";

                  }
                  else
                  {
                    $textcolor = "black";
                    $btncolor = "link-primary";
                  }
                }
                

                ?>

                <!-- Table Row -->
                <tr >
                        <td style="color:<?php echo $textcolor?>;" ><?php echo $i++ ?></td>
                        <td style="color:<?php echo $textcolor?>;"><?php /*?><a href="#"class="<?php echo $btncolor ?>" 
                        onclick="reportgenButton('<?php echo $plevelrows['boqid'] ?>','<?php echo $plevelrows['boqitem'] ?>')"><?php */?><?php echo $plevelrows['boqcode'] ?><?php /*?></a><?php */?></td>
                        <td style="color:<?php echo $textcolor?>;"><span title="<?php echo $plevelrows['boqitem']; ?>"><?php $boq_length=strlen($plevelrows['boqitem']);
						if($boq_length>30)
						{
							echo substr($plevelrows['boqitem'],0,29)."...";
						}
						else
						{
							echo $plevelrows['boqitem'];
						} ?></span> </td> 


                        <?php
                        if($pkrtotal!="" || $pkrtotal!=0)
                        {

                            ?>
                            <td style="color:<?php echo $textcolor?>; text-align: right;"><?php echo number_format(array_sum($pkrtotal))  ?></td>
                            <td style="color:<?php echo $textcolor?>; text-align: right;"><?php echo number_format(array_sum($usdtotal)) ?></td>

                            <?php
                        }
                        else{
                            ?>
                            <td style="color:<?php echo $textcolor?>;text-align: right;">0.00</td>
                            <td style="color:<?php echo $textcolor?>;text-align: right;">0.00</td>

                            <?php
                        }
                        

                        ?>

            			<?php if($parentcd==0)
		 	 {?>
                        
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal)) ?> </td>
                        <?php }
						else
						{?>
                           <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal_pin)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal_pin)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal_exupto)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal_exupto)) ?> </td>
                        <?php }?>
                        <td style="color:<?php echo $textcolor?>;text-align: right;" ><?php echo $resultpro ?>%</td>
                       
                        <?php
                              
                              $allipcss = $ObjKfiDash11->getAllIpcNo();
                              $pd =0;
                              while($allipcss=$ObjKfiDash11->dbFetchArray())
                              {
                            
                            ?>

                            <td class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;" ><?php echo number_format($pkrsingleid_fulllist_stack[$pd]) ?></td>
                            <td class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;" ><?php echo number_format($usdsingleid_fulllist_stack[$pd]) ?></td>
                            

                            <?php
                            $pd++;
                              }
				}?>
                      
                      
                      
                      </tr>

                         
                <?php  
            
//}
            ?>


<?php

$pkrsingleid_fulllist_stack_totoals =array();
$usdsingleid_fulllist_stack_totoals =array();


      $allipcss = $ObjKfiDash11->getAllIpcNo();//1, 2, 3, 4, ..... 45
      while($allipcss=$ObjKfiDash11->dbFetchArray())
      {
        $pkrsingleid_fulllist_stack_tot = array();
        $usdsingleid_fulllist_stack_tot = array();

            $ObjKfiDash1->setProperty("itemids",$itemids);// 0 
            $kfiprojectlevel = $ObjKfiDash1->getBOQ_LevelData();
            while($plevelrows=$ObjKfiDash1->dbFetchArray())//1201_1202 , 1201_1203, 1201_1204,   ... 1201_1216
            {
              $pkrsingleid_stack_tot = array();
              $usdsingleid_stack_tot = array();

                      //$ObjKfiDash2->setProperty("itemid",$plevelrows['itemid']);//parentgroup 1201_1204
                     // $kfirelatedids = $ObjKfiDash2->getItemsWithIstype2BOQ();
                     // while($plevelrowss=$ObjKfiDash2->dbFetchArray())//for parentgroup 1201_1204 - itemids : 1219,1220,...1233
                     // {

                          /// Paid In
                            $ObjKfiDash33->setProperty("boqid",$plevelrows['boqid']);//1219 1220 1221 ... 1233
                            $ObjKfiDash33->setProperty("lastipcid",$allipcss['ipcid']);
                            $kfidatafromboqping = $ObjKfiDash33->getAllIpcVExupBOQ();
                            while($plevelrowipcallpin=$ObjKfiDash33->dbFetchArray())
                              {
                                
                                  $pkripctotal_pin = $plevelrowipcallpin['xx'];
                                  $usdipctotal_pin = $plevelrowipcallpin['yy'];

                                  array_push($pkrsingleid_stack_tot,$pkripctotal_pin);
                                array_push($usdsingleid_stack_tot,$usdipctotal_pin);

                              }
                            /// Paid In
                          
                      //} 
                      array_push($pkrsingleid_fulllist_stack_tot,array_sum($pkrsingleid_stack_tot));
                      array_push($usdsingleid_fulllist_stack_tot,array_sum($usdsingleid_stack_tot));



            }
            
            array_push($pkrsingleid_fulllist_stack_totoals,array_sum($pkrsingleid_fulllist_stack_tot));
            array_push($usdsingleid_fulllist_stack_totoals,array_sum($usdsingleid_fulllist_stack_tot));
      }
      
?>





          <tr style="background-color:#DCF3FF;font-weight: 600;  ">
            <td colspan="3"><strong>Grand Total:</strong></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalPkr))  ?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalUsd)) ?></td>
            <?php if($parentcd==0)
		 	 {?>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpc)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpc)) ?></td> <?php }
			else
			{?>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpc)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpc)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpcPin)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpcPin)) ?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpcExupto)) ?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpcExupto)) ?></td>
            <?php }?>
            <td style="text-align: right;"><?php echo @number_format((float)array_sum($subTotalPkrIpcExupto)/array_sum($subTotalPkr)*100,2, '.', '') ?>%</td>
          
            <?php
                              
                              $allipcss = $ObjKfiDash11->getAllIpcNo();
                              $pdd =0;
                              while($allipcss=$ObjKfiDash11->dbFetchArray())
                              {
                            
                            ?>

                            <td  class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;;" ><?php echo number_format($pkrsingleid_fulllist_stack_totoals[$pdd]) ?></td>
                            <td  class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;" ><?php echo number_format($usdsingleid_fulllist_stack_totoals[$pdd]) ?></td>

                            <?php
                            $pdd++;
                              }
                            ?>
          
          
          
          </tr>
         
         <script type="text/javascript">
  
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
       
	  title: {
		 text: '<?php echo '<span style="font-size:22px;font-weight:bold; color:#000; font-family:Soleto, sans-serif;width:100%; text-align:left">'."Progress".'</span>'; ?>',
        floating: true,
        align: 'left',
        x: -12,
        y: 7
        },
       
        xAxis: {
            categories: [<?php echo $categories; ?>],
			//title: { text: '<?php //echo $xaxistitle; ?>' },
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '<?php echo $yaxistitle; ?>'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
							
            }
        },
        series: [{
            name: '<?php echo $data1name; ?>',
			data: [<?php echo $data1; ?>],
			color: '<?php echo $color_planned; ?>',
             dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'right',
                    x: 12,
                    y: 25,
					format: '{point.y:.1f}',
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }

        }, {
            name: '<?php echo $data2name; ?>',
			data: [<?php echo $data2; ?>],
			color: '<?php echo $color_actual; ?>',
			 dataLabels: {
                    enabled: true,
                    color: '#FFF',
                    align: 'left',
                    x: 0,
                    y: 25,
					format: '{point.y:.1f}',
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'                        
                    }
					
                }

        }]
    });
});
</script>
         </tbody>
    
     </table>
     <?php 
 }
 }
 else
 {?>
 <table class="table table-bordered normaltextsize" id="tobeappliedtable" style="margin-top:20px">
         <tbody>

         <tr>
         <th rowspan="2">Sr. No. </th>
         <th rowspan="2"> Code </th>
         <th rowspan="2">Description </th>
         <th colspan="2">As Per Bid</th>
          <?php if($parentcd==0)
		 {?>
         <th colspan="2">Total Executed</th>
         
         <?php }
		 else
		 {?>
         <th colspan="2"  class="collapse.show collapse-horizontal" id="collapseWidthExample" style="">Paid Upto</br></br><?php echo $seclastipcidd ;?>- Dated ( <?php echo $seclastipciddsubdate ;?> )</th>
         <th colspan="2"  class="collapse.show collapse-horizontal" id="collapseWidthExample" style="">Paid in</br></br><?php echo $lastipcidd ;?>- Dated ( <?php echo $lastipcidddddsubdate ;?> )</th>
         <th colspan="2">Executed Upto</br></br><?php echo $lastipcidd ;?></th>
         <?php }?>
         <th colspan="1"> % in</br>Progress</th>

         <?php
                 $allipcss = $ObjKfiDash1->getAllIpcNo();
                 while($allipcss=$ObjKfiDash1->dbFetchArray())
                 {
                   ?>
                  <th colspan="2" class="collapse collapse-horizontal" id="collapseWidthExample" style=""><?php echo $allipcss['ipcno'] ?></br></br><?php echo $allipcss['ipcmonth'] ?></th>
                   <?php
                 }
                ?>



         </tr>
         <tr> 
             <th ><?php echo $cur_1;?> </th>
             <th ><?php echo $cur_2;?> </th>
              <?php if($parentcd==0)
		 	 {?>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_1;?> </th>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_2;?> </th>
             <?php }
			 else
			 {?>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_1;?> </th>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_2;?> </th>

             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_1;?> </th>                                                                                                                    
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" ><?php echo $cur_2;?> </th>                                                                                                                                           
             <th ><?php echo $cur_1;?> </th>                                                                                                                                          
             <th ><?php echo $cur_2;?> </th>   
             <?php }?>                                                                                                                                         
             <th >%</th>  

             <?php
                 $allipcss = $ObjKfiDash1->getAllIpcNo();
                 while($allipcss=$ObjKfiDash1->dbFetchArray())
                 {
                   ?>
                   <th class="collapse collapse-horizontal" id="collapseWidthExample"><?php echo $cur_1;?> </th>
                   <th class="collapse collapse-horizontal" id="collapseWidthExample"><?php echo $cur_2;?> </th>
                 <?php
                 }
                ?>
                                                                                    
         </tr>
         <!-- Table 1 goes here -->

         <?php

                $subTotalPkr = array();
                $subTotalUsd = array();

                $subTotalPkrIpc = array();
                $subTotalUsdIpc = array();

                $subTotalPkrIpcPin = array();
                $subTotalUsdIpcPin = array();

                $subTotalPkrIpcExupto = array();
                $subTotalUsdIpcExupto = array();

                $subTotalUsdIpcProgress = array();

                ///Monthly distribution
                $subTotalPkrIpcipcmonthly = array();

                $ObjKfiDash1->setProperty("itemids",$itemids);
                $kfiprojectlevel = $ObjKfiDash1->getActivity_LevelData();//1201_1202 1201_1203 ... 1201_1216
				$planned = array();
				$actual =  array();
				$xaxis =   array();
                $i=1;
                while($plevelrows=$ObjKfiDash1->dbFetchArray())
                {
                  
                    $pkrtotal = array();
                    $usdtotal = array();

                    $pkripctotal = array();
                    $usdipctotal = array();

                    $pkripctotal_pin = array();
                    $usdipctotal_pin = array();

                    $pkripctotal_exupto = array();
                    $usdipctotal_exupto = array();

                    //////For Monthly distribution
                    $pkrtotalstack_asperbid = array();
                    $usdtotalstack_asperbid = array();
  
                    $pkrsingleid_fulllist_stack = array();
                    $usdsingleid_fulllist_stack = array();
                    //////For Monthly distribution


                $ObjKfiDash2->setProperty("parentgroup",$plevelrows['parentgroup']);
                $kfirelatedids = $ObjKfiDash2->getItemsWithIstype2();

                while($plevelrowss=$ObjKfiDash2->dbFetchArray())
                 {
                  
                  // AS PER BID
                    $ObjKfiDash3->setProperty("boqitemid",$plevelrowss['itemid']);
                    $kfidatafromboq = $ObjKfiDash3->getDataFromBoq();

                    while($plevelrowsss=$ObjKfiDash3->dbFetchArray())
                    {
                    
                        $pktotal = $plevelrowsss['x'];
                        $ustotal = $plevelrowsss['y'];

                        array_push($pkrtotal,$pktotal);
                        array_push($usdtotal,$ustotal);
                        

                    }
                    // AS PER BID

                
                       
                        /// UP TO
                        $ObjKfiDash7->setProperty("itemid",$plevelrowss['itemid']);
						//	$ObjKfiDash9->setProperty("lastipcid",$seclastipcidd);
                      //  $ObjKfiDash7->setProperty("lastipcid",$lastipciddddd);
					    $ObjKfiDash7->setProperty("lastipcid",$seclastipc_id);
                        $kfidatafromboq = $ObjKfiDash7->getAllIpcV();
                        while($plevelrowipcall=$ObjKfiDash7->dbFetchArray())
                          {
                            
                              $pkipctotal = $plevelrowipcall['zp'];
                              $usipctotal = $plevelrowipcall['qu'];
                               
                              array_push($pkripctotal,$pkipctotal);
                              array_push($usdipctotal,$usipctotal);

                          }
                          
                           ///// UP TO

                           /// Paid In
                        $ObjKfiDash9->setProperty("itemid",$plevelrowss['itemid']);
						
                       $ObjKfiDash9->setProperty("lastipcid",$lastipciddddd);
					
                        $kfidatafromboqping = $ObjKfiDash9->getAllIpcVExup();
                        while($plevelrowipcallpin=$ObjKfiDash9->dbFetchArray())
                          {
                            
                              $pkipctotal_pin = $plevelrowipcallpin['xx'];
                              $usipctotal_pin = $plevelrowipcallpin['yy'];

                              array_push($pkripctotal_pin,$pkipctotal_pin);
                              array_push($usdipctotal_pin,$usipctotal_pin);

                          }
                           /// Paid In

                            /// PAID excy up to
                        $ObjKfiDash8->setProperty("itemid",$plevelrowss['itemid']);
                        $ObjKfiDash8->setProperty("lastipcid",$lastipciddddd);
                        $kfidatafromboqexupto = $ObjKfiDash8->getAllIpcVPIn();
                        while($plevelrowipcallexup=$ObjKfiDash8->dbFetchArray())
                          {
                            
                              $pkipctotal_exupto = $plevelrowipcallexup['xx'];
                              $usipctotal_exupto = $plevelrowipcallexup['yy'];

                              array_push($pkripctotal_exupto,$pkipctotal_exupto);
                              array_push($usdipctotal_exupto,$usipctotal_exupto);
                               
                          }
                          /// PAID excy up to



                  }


					$planned[] = $pktotal;
					$actual[] =  $pkipctotal_exupto;
					$xaxis[] = $plevelrows['itemname'];
                  /////Monthly Distribution
                  $allipcss = $ObjKfiDash11->getAllIpcNo();
                  while($allipcss=$ObjKfiDash11->dbFetchArray())//1
                  {
                  $pkrsingleid_stack = array();
                  $usdsingleid_stack = array();

                  

                          $ObjKfiDash2->setProperty("parentgroup",$plevelrows['parentgroup']);//parentgroup 1201_1204
                          $kfirelatedids = $ObjKfiDash2->getItemsWithIstype2();
                          while($plevelrowss=$ObjKfiDash2->dbFetchArray())//for parentgroup 1201_1204 - itemids : 1219,1220,...1233
                          {

                              /// Paid In
                                $ObjKfiDash33->setProperty("itemid",$plevelrowss['itemid']);//1219 1220 1221 ... 1233
                                $ObjKfiDash33->setProperty("lastipcid",$allipcss['ipcid']);
                                $kfidatafromboqping = $ObjKfiDash33->getAllIpcVExup();
                                while($plevelrowipcallpin=$ObjKfiDash33->dbFetchArray())
                                  {
                                    
                                      $pkripctotal_pinn = $plevelrowipcallpin['xx'];
                                      $usdipctotal_pinn = $plevelrowipcallpin['yy'];

                                      array_push($pkrsingleid_stack,$pkripctotal_pinn);
                                     array_push($usdsingleid_stack,$usdipctotal_pinn);

                                  }
                                /// Paid In
                              
                          }                                          
                                array_push($pkrsingleid_fulllist_stack,array_sum($pkrsingleid_stack));
                                array_push($usdsingleid_fulllist_stack,array_sum($usdsingleid_stack));

                       
                  }
                  array_push($subTotalPkrIpcipcmonthly,array_sum($pkrsingleid_fulllist_stack));

                  //////Monthly Distribution

                      
                //}

                if($pkrtotal!="" || $pkrtotal!=0)
                {
                array_push($subTotalPkr,array_sum($pkrtotal));
                array_push($subTotalUsd,array_sum($usdtotal));
                array_push($subTotalPkrIpc,array_sum($pkripctotal));
                array_push($subTotalUsdIpc,array_sum($usdipctotal));
                array_push($subTotalPkrIpcPin,array_sum($pkripctotal_pin));
                array_push($subTotalUsdIpcPin,array_sum($usdipctotal_pin));
                array_push($subTotalPkrIpcExupto,array_sum($pkripctotal_exupto));
                array_push($subTotalUsdIpcExupto,array_sum($usdipctotal_exupto));

                }

                if(array_sum($pkrtotal)>0)
                {
                  $resultpro = number_format((float)(array_sum($pkripctotal_exupto)/array_sum($pkrtotal)*100),2,'.','');
                
                  if($resultpro>100)
                  {
                    $textcolor = "red";
                    $btncolor = "link-danger";

                  }
                  else
                  {
                    $textcolor = "black";
                    $btncolor = "link-primary";
                  }
                  
                }
                else
                {
                  $resultpro = 0;

                  
                  if($resultpro>100)
                  {
                    $textcolor = "red";
                    $btncolor = "link-danger";

                  }
                  else
                  {
                    $textcolor = "black";
                    $btncolor = "link-primary";
                  }
                }
                

                ?>

                <!-- Table Row -->
                <tr >
                        <td style="color:<?php echo $textcolor?>;" ><?php echo $i++ ?></td>
                        <td style="color:<?php echo $textcolor?>;"><a href="#"class="<?php echo $btncolor ?>" onclick="reportgenButton('<?php echo $plevelrows['itemid'] ?>','<?php echo $plevelrows['itemname'] ?>')"><?php echo $plevelrows['itemcode'] ?></a></td>
                        <td style="color:<?php echo $textcolor?>;"><?php  $desc_length=strlen($plevelrows['itemname']);
						if($desc_length>30)
						{
							echo substr($plevelrows['itemname'],0,29)."...";
						}
						else
						{
							echo $plevelrows['itemname'];
						}?> </td> 


                        <?php
                        if($pkrtotal!="" || $pkrtotal!=0)
                        {

                            ?>
                            <td style="color:<?php echo $textcolor?>; text-align: right;"><?php echo number_format(array_sum($pkrtotal))  ?></td>
                            <td style="color:<?php echo $textcolor?>; text-align: right;"><?php echo number_format(array_sum($usdtotal)) ?></td>

                            <?php
                        }
                        else{
                            ?>
                            <td style="color:<?php echo $textcolor?>;text-align: right;">0.00</td>
                            <td style="color:<?php echo $textcolor?>;text-align: right;">0.00</td>

                            <?php
                        }
                        

                        ?>

            			<?php if($parentcd==0)
		 	 {?>
                        
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal)) ?> </td>
                        <?php }
						else
						{?>
                           <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal_pin)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal_pin)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal_exupto)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal_exupto)) ?> </td>
                        <?php }?>
                        <td style="color:<?php echo $textcolor?>;text-align: right;" ><?php echo $resultpro ?>%</td>
                       
                        <?php
                              
                              $allipcss = $ObjKfiDash11->getAllIpcNo();
                              $pd =0;
                              while($allipcss=$ObjKfiDash11->dbFetchArray())
                              {
                            
                            ?>

                            <td class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;" ><?php echo number_format($pkrsingleid_fulllist_stack[$pd]) ?></td>
                            <td class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;" ><?php echo number_format($usdsingleid_fulllist_stack[$pd]) ?></td>
                            

                            <?php
                            $pd++;
                              }
                            ?>
                      
                      
                      
                      </tr>

                         
                <?php  
            }
$planneddata = implode(",",$planned);
$actualdata = implode(",",$actual);
$xaxisdata = "'".implode("','",$xaxis)."'";
$title="Progress";
$categories =  $xaxisdata;
$xaxistitle = "Month";
$yaxistitle = "Percentage";
$data1name = "Planned";
$data1 = $planneddata;
$data2name = "Actual";
$data2 = $actualdata;
            ?>


<?php

$pkrsingleid_fulllist_stack_totoals =array();
$usdsingleid_fulllist_stack_totoals =array();


      $allipcss = $ObjKfiDash11->getAllIpcNo();//1, 2, 3, 4, ..... 45
      while($allipcss=$ObjKfiDash11->dbFetchArray())
      {
        $pkrsingleid_fulllist_stack_tot = array();
        $usdsingleid_fulllist_stack_tot = array();

            $ObjKfiDash1->setProperty("itemids",$itemids);// 0 
            $kfiprojectlevel = $ObjKfiDash1->getActivity_LevelData();
            while($plevelrows=$ObjKfiDash1->dbFetchArray())//1201_1202 , 1201_1203, 1201_1204,   ... 1201_1216
            {
              $pkrsingleid_stack_tot = array();
              $usdsingleid_stack_tot = array();

                      $ObjKfiDash2->setProperty("parentgroup",$plevelrows['parentgroup']);//parentgroup 1201_1204
                      $kfirelatedids = $ObjKfiDash2->getItemsWithIstype2();
                      while($plevelrowss=$ObjKfiDash2->dbFetchArray())//for parentgroup 1201_1204 - itemids : 1219,1220,...1233
                      {

                          /// Paid In
                            $ObjKfiDash33->setProperty("itemid",$plevelrowss['itemid']);//1219 1220 1221 ... 1233
                            $ObjKfiDash33->setProperty("lastipcid",$allipcss['ipcid']);
                            $kfidatafromboqping = $ObjKfiDash33->getAllIpcVExup();
                            while($plevelrowipcallpin=$ObjKfiDash33->dbFetchArray())
                              {
                                
                                  $pkripctotal_pin = $plevelrowipcallpin['xx'];
                                  $usdipctotal_pin = $plevelrowipcallpin['yy'];

                                  array_push($pkrsingleid_stack_tot,$pkripctotal_pin);
                                array_push($usdsingleid_stack_tot,$usdipctotal_pin);

                              }
                            /// Paid In
                          
                      } 
                      array_push($pkrsingleid_fulllist_stack_tot,array_sum($pkrsingleid_stack_tot));
                      array_push($usdsingleid_fulllist_stack_tot,array_sum($usdsingleid_stack_tot));



            }
            
            array_push($pkrsingleid_fulllist_stack_totoals,array_sum($pkrsingleid_fulllist_stack_tot));
            array_push($usdsingleid_fulllist_stack_totoals,array_sum($usdsingleid_fulllist_stack_tot));
      }
      
?>





          <tr style="background-color:#DCF3FF;font-weight: 600;  ">
            <td colspan="3"><strong>Grand Total:</strong></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalPkr))  ?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalUsd)) ?></td>
            <?php if($parentcd==0)
		 	 {?>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpc)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpc)) ?></td> <?php }
			else
			{?>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpc)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpc)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpcPin)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpcPin)) ?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpcExupto)) ?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpcExupto)) ?></td>
            <?php }?>
            <td style="text-align: right;"><?php echo @number_format((float)array_sum($subTotalPkrIpcExupto)/array_sum($subTotalPkr)*100,2, '.', '') ?>%</td>
          
            <?php
                              
                              $allipcss = $ObjKfiDash11->getAllIpcNo();
                              $pdd =0;
                              while($allipcss=$ObjKfiDash11->dbFetchArray())
                              {
                            
                            ?>

                            <td  class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;;" ><?php echo number_format($pkrsingleid_fulllist_stack_totoals[$pdd]) ?></td>
                            <td  class="collapse collapse-horizontal" id="collapseWidthExample" style="text-align: right;" ><?php echo number_format($usdsingleid_fulllist_stack_totoals[$pdd]) ?></td>

                            <?php
                            $pdd++;
                              }
                            ?>
          
          
          
          </tr>
         
         <script type="text/javascript">
  
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
       
	  title: {
		 text: '<?php echo '<span style="font-size:22px;font-weight:bold; color:#000; font-family:Soleto, sans-serif;width:100%; text-align:left">'."Progress".'</span>'; ?>',
        floating: true,
        align: 'left',
        x: -12,
        y: 7
        },
       
        xAxis: {
            categories: [<?php echo $categories; ?>],
			//title: { text: '<?php //echo $xaxistitle; ?>' },
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '<?php echo $yaxistitle; ?>'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
							
            }
        },
        series: [{
            name: '<?php echo $data1name; ?>',
			data: [<?php echo $data1; ?>],
			color: '<?php echo $color_planned; ?>',
             dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'right',
                    x: 12,
                    y: 25,
					format: '{point.y:.1f}',
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }

        }, {
            name: '<?php echo $data2name; ?>',
			data: [<?php echo $data2; ?>],
			color: '<?php echo $color_actual; ?>',
			 dataLabels: {
                    enabled: true,
                    color: '#FFF',
                    align: 'left',
                    x: 0,
                    y: 25,
					format: '{point.y:.1f}',
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'                        
                    }
					
                }

        }]
    });
});
</script>
         </tbody>
    
     </table>
    <?php }?>
     <!-- Main data table ends here -->



          </br>
          