<?php
include_once "../../config/config.php";
$ObjKfiDash1 = new KfiDashboard();
$ObjKfiDash2 = new KfiDashboard();
$ObjKfiDash3 = new KfiDashboard();
$ObjKfiDash4 = new KfiDashboard();
$ObjKfiDash5 = new KfiDashboard();

$itemids = $_GET['itemids'];

?>

         <?php

$i = 1;

// $activityItemnames = array();

$ObjKfiDash5->setProperty("parentgroup", $plevelrowitemname['parentgroup']);
$kfiallactivitylevelids = $ObjKfiDash5->getAllActivityLevels();

while ($kfiallactivitylevelidss = $ObjKfiDash5->dbFetchArray()) {

    $ObjKfiDash4->setProperty("activitylevel", $kfiallactivitylevelidss['activitylevel']);
    $kfidefalupageitemname = $ObjKfiDash4->getItemName();

    while ($plevelrowitemname = $ObjKfiDash4->dbFetchArray()) {

        ?>

      <!-- Table 1 goes here -->
      <table class="table table-bordered normaltextsize" id="tobeappliedtable" style="margin-top:20px">
         <tbody><tr id="title">
           <td colspan="13" style="font-weight: 900; font-size:16px; background-color:#000066; color:#FFF;text-align:center"><?php echo $plevelrowitemname['itemname'] ?></td></tr>

         <tr>
         <th rowspan="2">Sr. No. </th>
         <th rowspan="2"> Code </th>
         <th rowspan="2">Description </th>
         <th colspan="2"> As Per Bid</th>
         <?php if($kfiallactivitylevelidss['activitylevel']==0)
		 {?>
         <th colspan="2">Total Executed</th>
         <th colspan="2"> % in Progress</th>
         <?php }
		 else
		 {?>
         <th colspan="2">Paid Upto </th>
         <th colspan="2">Paid in  </th>
         <th colspan="2">Executed Upto  </th>
         <th colspan="2"> % in Progress</th>
         <?php } ?>
         </tr>
         <tr>
          <?php if($kfiallactivitylevelidss['activitylevel']==0)
		 {?>
             <th >PKR </th>
             <th >USD </th>
             <th >PKR </th>
             <th >USD </th>
             <th >PKR </th>
             <?php } 
			 else
			 {?>
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
             <?php } ?>

         </tr>
         <!-- Table 1 goes here -->

            <?php

        $subTotalPkr = array();
        $subTotalUsd = array();

        $ObjKfiDash1->setProperty("itemids", $plevelrowitemname['itemid']);
        $kfiprojectlevel = $ObjKfiDash1->getActivity_LevelData();

        while ($plevelrows = $ObjKfiDash1->dbFetchArray()) {

            $pkrtotal = array();
            $usdtotal = array();
            //Activity level Item Names Array
            //array_push($activityItemnames,$plevelrows['itemname']);

            $ObjKfiDash2->setProperty("parentgroup", $plevelrows['parentgroup']);
            $kfirelatedids = $ObjKfiDash2->getItemsWithIstype2();

            while ($plevelrowss = $ObjKfiDash2->dbFetchArray()) {

                $ObjKfiDash3->setProperty("boqitemid", $plevelrowss['itemid']);
                $kfidatafromboq = $ObjKfiDash3->getDataFromBoq();

                while ($plevelrowsss = $ObjKfiDash3->dbFetchArray()) {

                    $pktotal = $plevelrowsss['boqqty'] * $plevelrowsss['boq_cur_1_rate'];
                    $ustotal = $plevelrowsss['boqqty'] * $plevelrowsss['boq_cur_2_rate'];

                    array_push($pkrtotal, $pktotal);
                    array_push($usdtotal, $ustotal);

                }
            }
            array_push($subTotalPkr, array_sum($pkrtotal));
            array_push($subTotalUsd, array_sum($usdtotal));

            ?>

                    <!-- Table Row -->
                     <tr>
                        <td ><?php echo $i++ ?></td>
                        <td ><?php echo $plevelrows['itemcode'] ?></td>
                        <td ><?php echo $plevelrows['itemname'] ?> </td>
                        <td ><?php echo number_format(array_sum($pkrtotal)) ?></td>
                        <td ><?php echo number_format(array_sum($usdtotal)) ?></td>
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

        ?>

                          <tr style="background-color:#DCF3FF;font-weight: 600;  ">
                            <td colspan="3"><strong>Grand Total:</strong></td>
                            <td ><?php echo number_format(array_sum($subTotalPkr)) ?></td>
                            <td ><?php echo number_format(array_sum($subTotalUsd)) ?></td>
                            <td >0.00</td>
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

?>


         </tbody>

     </table>


