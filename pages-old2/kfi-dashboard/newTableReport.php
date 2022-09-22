<?php
include_once("../../config/config.php");
$ObjKfiDash1 = new KfiDashboard();
$ObjKfiDash2 = new KfiDashboard();
$ObjKfiDash3 = new KfiDashboard();
$ObjKfiDash4 = new KfiDashboard();
$ObjKfiDash5 = new KfiDashboard();
$ObjKfiDash6 = new KfiDashboard();
$ObjKfiDash7 = new KfiDashboard();
$ObjKfiDash8 = new KfiDashboard();
$ObjKfiDash9 = new KfiDashboard();

$itemids = $_GET['itemids'];
$itemname = $_GET['itemname'];

//Last Ipc Nummber
$lastipcid = $ObjKfiDash6->getLastIpcNo();
$lastipcidd="";
$lastipciddddd="";
while($lastipciddd=$ObjKfiDash6->dbFetchArray())
{
  $lastipcidd=$lastipciddd['ipcno'];
  $lastipciddddd=$lastipciddd['ipcid'];
  $lastipcidddddsubdate=$lastipciddd['ipcsubmitdate'];
}

//Second Last Ipc Nummber
$seclastipcid = $ObjKfiDash6->getSecondLastIpcNo();
$seclastipcidd="";
while($seclastipciddd=$ObjKfiDash6->dbFetchArray())
{
  $seclastipcidd=$seclastipciddd['ipcno'];
  $seclastipciddsubdate=$seclastipciddd['ipcsubmitdate'];
}
 
?>
<!-- Table 1 goes here -->
<table class="table table-bordered normaltextsize" id="tobeappliedtable" style="margin-top:20px">
         <tbody><tr id="title">
           <td id="tableheadername" colspan="12" style="font-weight: 900; font-size:16px; background-color:#000066; color:#FFF;text-align:center"><?php echo $itemname ?></td></tr>

         <tr>
         <th rowspan="2">Sr. No. </th>
         <th rowspan="2"> Code </th>
         <th rowspan="2">Description </th>
         <th colspan="2"> As Per Bid</th>
         <th colspan="2">Paid Upto</br></br><?php echo $seclastipcidd ;?>- Dated ( <?php echo $seclastipciddsubdate ;?> )</th>
         <th colspan="2">Paid in</br></br><?php echo $lastipcidd ;?>- Dated ( <?php echo $lastipcidddddsubdate ;?> )</th>
         <th colspan="2">Executed Upto</br></br><?php echo $lastipcidd ;?></th>
         <th colspan="1"> % in</br>Progress</th>
         </tr>
         <tr> 
             <th >PKR </th>
             <th >USD </th>
             <th >PKR </th>
             <th >USD </th>
             <th >PKR </th>                                                                                                                    
             <th >USD </th>                                                                                                                                           
             <th >PKR </th>                                                                                                                                          
             <th >USD </th>                                                                                                                                            
             <th >%</th>  
                                                                                    
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

                $ObjKfiDash1->setProperty("itemids",$itemids);
                $kfiprojectlevel = $ObjKfiDash1->getActivity_LevelData();

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
                        $ObjKfiDash7->setProperty("lastipcid",$lastipciddddd);
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
                  }
                  else
                  {
                    $textcolor = "black";
                  }
                  
                }
                else
                {
                  $resultpro = 0;
                }

                ?>

                <!-- Table Row -->
                <tr>
                        <td style="color:<?php echo $textcolor?>;" ><?php echo $i++ ?></td>
                        <td style="color:<?php echo $textcolor?>;"><?php echo $plevelrows['itemcode'] ?></td>
                        <td style="color:<?php echo $textcolor?>;"><?php echo $plevelrows['itemname'] ?> </td> 


                        <?php
                        if($pkrtotal!="" || $pkrtotal!=0)
                        {

                            ?>
                            <td style="color:<?php echo $textcolor?>;"><?php echo number_format(array_sum($pkrtotal))  ?></td>
                            <td style="color:<?php echo $textcolor?>;"><?php echo number_format(array_sum($usdtotal)) ?></td>

                            <?php
                        }
                        else{
                            ?>
                            <td style="color:<?php echo $textcolor?>;">0.00</td>
                            <td style="color:<?php echo $textcolor?>;">0.00</td>

                            <?php
                        }

                        ?>

            
                        
                        <td style="color:<?php echo $textcolor?>;"><?php echo number_format(array_sum($pkripctotal)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;"><?php echo number_format(array_sum($usdipctotal)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;"><?php echo number_format(array_sum($pkripctotal_pin)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;"><?php echo number_format(array_sum($usdipctotal_pin)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;"><?php echo number_format(array_sum($pkripctotal_exupto)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;"><?php echo number_format(array_sum($usdipctotal_exupto)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;" ><?php echo $resultpro ?>%</td>
                        </tr>

                         
                <?php

                
            }
            
            ?>

<tr style="background-color:#DCF3FF;font-weight: 600;  ">
                            <td colspan="3"><strong>Grand Total:</strong></td>
                            <td ><?php echo number_format(array_sum($subTotalPkr))  ?></td>
                            <td ><?php echo number_format(array_sum($subTotalUsd)) ?></td>
                            <td ><?php echo number_format(array_sum($subTotalPkrIpc)) ?></td>
                            <td ><?php echo number_format(array_sum($subTotalUsdIpc)) ?></td>
                            <td ><?php echo number_format(array_sum($subTotalPkrIpcPin)) ?></td>
                            <td ><?php echo number_format(array_sum($subTotalUsdIpcPin)) ?></td>
                            <td ><?php echo number_format(array_sum($subTotalPkrIpcExupto)) ?></td>
                            <td ><?php echo number_format(array_sum($subTotalUsdIpcExupto)) ?></td>
                            <td ><?php echo @number_format((float)array_sum($subTotalPkrIpcExupto)/array_sum($subTotalPkr)*100,2, '.', '') ?>%</td>
                            </tr>
         
         
         </tbody>
    
     </table>


