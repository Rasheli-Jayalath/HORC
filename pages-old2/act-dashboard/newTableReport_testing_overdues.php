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
$ObjKfiDash10 = new KfiDashboard();
$ObjKfiDash11 = new KfiDashboard();
$ObjKfiDash22 = new KfiDashboard();
$ObjKfiDash33 = new KfiDashboard();
$ObjKfiDash99 = new KfiDashboard();

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
<h4 style="margin-top:20px;text-align:center; font-weight:800"><?php echo $itemname ?></h4>
<table class="table table-bordered normaltextsize" id="tobeappliedtable" style="margin-top:20px">
         <tbody><tr id="title">
           <!-- <td id="tableheadername" colspan="12" style="font-weight: 900; font-size:16px; background-color:#000066; color:#FFF;text-align:center"><?php echo $itemname ?></td></tr> -->

         <tr>
         <th rowspan="2">Sr. No. </th>
         <th rowspan="2"> Code </th>
         <th rowspan="2">Description </th>
         <th colspan="2">As Per Bid</th>
         <th colspan="2"  class="collapse.show collapse-horizontal" id="collapseWidthExample" style="">Paid Upto</br></br><?php echo $seclastipcidd ;?>- Dated ( <?php echo $seclastipciddsubdate ;?> )</th>
         <th colspan="2"  class="collapse.show collapse-horizontal" id="collapseWidthExample" style="">Paid in</br></br><?php echo $lastipcidd ;?>- Dated ( <?php echo $lastipcidddddsubdate ;?> )</th>
         <th colspan="2">Executed Upto</br></br><?php echo $lastipcidd ;?></th>
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
             <th >PKR </th>
             <th >USD </th>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" >PKR </th>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" >USD </th>
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" >PKR </th>                                                                                                                    
             <th class="collapse.show collapse-horizontal" id="collapseWidthExample" >USD </th>                                                                                                                                           
             <th >PKR </th>                                                                                                                                          
             <th >USD </th>                                                                                                                                            
             <th >%</th>  

             <?php
                 $allipcss = $ObjKfiDash1->getAllIpcNo();
                 while($allipcss=$ObjKfiDash1->dbFetchArray())
                 {
                   ?>
                   <th class="collapse collapse-horizontal" id="collapseWidthExample">PKR </th>
                   <th class="collapse collapse-horizontal" id="collapseWidthExample">USD </th>
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
                
                if($resultpro>100)
                {
                ?>

                <!-- Table Row -->
                <tr >
                        <td style="color:<?php echo $textcolor?>;" ><?php echo $i++ ?></td>
                        <td style="color:<?php echo $textcolor?>;"><a href="#"class="<?php echo $btncolor ?>" onclick="reportgenButton('<?php echo $plevelrows['itemid'] ?>','<?php echo $plevelrows['itemname'] ?>')"><?php echo $plevelrows['itemcode'] ?></a></td>
                        <td style="color:<?php echo $textcolor?>;"><?php echo $plevelrows['itemname'] ?> </td> 


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

            
                        
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal_pin)) ?> </td>
                        <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal_pin)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($pkripctotal_exupto)) ?> </td>
                        <td style="color:<?php echo $textcolor?>;text-align: right;"><?php echo number_format(array_sum($usdipctotal_exupto)) ?> </td>
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
            }
            
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





          <!-- <tr style="background-color:#DCF3FF;font-weight: 600;  ">
            <td colspan="3"><strong>Grand Total:</strong></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalPkr))  ?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalUsd)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpc)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpc)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpcPin)) ?></td>
            <td class="collapse.show collapse-horizontal" id="collapseWidthExample" style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpcPin)) ?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalPkrIpcExupto)) ?></td>
            <td style="text-align: right;"><?php echo number_format(array_sum($subTotalUsdIpcExupto)) ?></td>
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
          
          
          
          </tr> -->
         
         
         </tbody>
    
     </table>
     <!-- Main data table ends here -->



          </br>