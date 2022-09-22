<?php
include_once("../../config/config.php");
$ObjKfiDash1 = new KfiDashboard();
$ObjKfiDash2 = new KfiDashboard();
$ObjKfiDash3 = new KfiDashboard();

$itemids = $_GET['itemids'];

if($itemids!="")
{

?>


     <table class="table table-bordered normaltextsize" id="tobeappliedtable">
         <tbody><tr id="title">
           <td colspan="13" style=" background-color:#000066"></td></tr>

         <tr>
         <th rowspan="2">Sr. No. </th>
         <th rowspan="2"> Code </th>
         <th rowspan="2">Description </th>
         <th colspan="2"> As Per Bid</th>
         <th colspan="2">Paid Upto </th>
         <th colspan="2">Paid in  </th>
         <th colspan="2">Executed Upto  </th>
         <th colspan="2"> % in Progress</th>
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
             <th >PKR</th>                                                                                                                  
             <th >USD</th>
                                                                                    
         </tr>

         <?php
            $ObjKfiDash1->setProperty("itemids",$itemids);
            $kfiprojectlevel = $ObjKfiDash1->getParentGroup();

            $i=1;
            $pkrtotal = array();
            $usdtotal = array();

            while($plevelrows=$ObjKfiDash1->dbFetchArray())
            {

                $ObjKfiDash2->setProperty("parentgroup",$plevelrows['parentgroup']);
                $kfirelatedids = $ObjKfiDash2->getItemsWithIstype1();

                while($plevelrowss=$ObjKfiDash2->dbFetchArray())
                 {

                    $ObjKfiDash3->setProperty("boqitemid",$plevelrowss['itemid']);
                    $kfidatafromboq = $ObjKfiDash3->getDataFromBoq();


                    while($plevelrowsss=$ObjKfiDash3->dbFetchArray())
                    {
                    
                        $pktotal = $plevelrowsss['boqqty']*$plevelrowsss['boq_cur_1_rate'];
                        $ustotal = $plevelrowsss['boqqty']*$plevelrowsss['boq_cur_2_rate'];

            
                        array_push($pkrtotal,$pktotal);
                        array_push($usdtotal,$ustotal);
                    


        ?>

                        <tr>
                        <td ><?php echo $i++ ?></td>
                        <td ><?php echo $plevelrowsss['boqcode'] ?></td>
                        <td ><?php echo $plevelrowsss['boqitem'] ?> </td>
                        
                        <td ><?php echo number_format($pktotal)?></td>
                        <td ><?php echo number_format($ustotal) ?></td>
                        <td >00,000,000.00</td>
                        <td >0.00</td>
                        <td >0.00</td>
                        <td >0.00</td>
                        <td >0.00</td>
                        <td >0.00</td>
                        <td >0.0</td>
                        <td >0.0</td>
                        </tr>

         <?php
                  }

                     
                }
              }  
            }
            ?>
         
         <tr>
         <td colspan="3"><strong>Grand Total:</strong></td>
         <td ><?php echo number_format(array_sum($pkrtotal))  ?></td>
         <td ><?php echo number_format(array_sum($usdtotal)) ?></td>
         <td >0.00</td>
         <td >0.00</td>
         <td >0.00</td>
         <td >0.00</td>
         <td >0.00</td>
         <td >0.00</td>
         <td >0.0</td>
         <td >0.0</td>

         
         </tr>
         
         </tbody>
     
     </table>


