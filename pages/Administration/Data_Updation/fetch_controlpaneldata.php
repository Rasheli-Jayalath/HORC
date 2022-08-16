<?php
include_once "../../../config/config.php";
$IpcClassObj = new IpcClass();
$IpcClassObj2 = new IpcClass();
$ObjKfiDash = new KfiDashboard();
$ObjKfiDash2 = new KfiDashboard();
$ObjKfiDash3 = new KfiDashboard();
$ObjKfiDash4 = new KfiDashboard();
$ObjKfiDash5 = new KfiDashboard();
$ObjKfiDash6 = new KfiDashboard();

?>

<table class="table table-striped">
              <tdead>
                <tr class="bg-form" style="font-size:14px; color:#CCC;">
                <th  widtd="47%"><strong>Item Name</strong></th>
                <th  widtd="15%"><strong>Stage</strong></th>
                <th widtd="15%"><strong>Item Code</strong></th>
                <th widtd="15%"><strong>Isentry</strong></th>
                <th  widtd="8%"><strong><input type="checkbox" name="txtChkAll" id="txtChkAll" form="reports" onclick="group_checkbox();"></strong></td>
              </tr>
            </tdead>

      <?php
      $ipclevelsordritemid = $IpcClassObj->getParentItemByZero();

      while ($ipclevelsordritemidd = $IpcClassObj->dbFetchArray()) {

          ?>
      <tr class="text-dark" style="font-size:12px; color:#CCC; background:#475dcc">
                <td><strong><?php echo $ipclevelsordritemidd['itemname'] ?></strong>
                <!-- Expand Button -->
                <?php
                     if ($ipclevelsordritemidd['isentry'] == 1) {
                  ?>
 </br>  <button data-bs-toggle="collapse" data-bs-target="#collapseOne" style = "margin-top: 5px;" ><i class="mdi mdi-plus"></i> </button>

                  <?php
                  }
                 ?>
               </td>

                <td><strong>BOQ</strong></td>
                <td><strong><?php echo $ipclevelsordritemidd['itemcode'] ?></strong></td>
                <td><strong><?php echo $ipclevelsordritemidd['isentry'] ?></strong></td>
                <td><strong><input type="checkbox" name="txtChkAll" id="txtChkAll" form="reports" onclick="group_checkbox();"></strong></td>
              </tr>

                  <?php

                $ObjKfiDash2->setProperty("itemids", $ipclevelsordritemidd['itemid']); //13
                $kfiallactivitylevelids = $ObjKfiDash2->getActivity_LevelData(); //14 15

                while ($kfiallactivitylevelidss = $ObjKfiDash2->dbFetchArray()) {

                    ?>

              <tr class="text-dark" style="font-size:12px; color:#CCC; background:#7e8ddb;">
                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $kfiallactivitylevelidss['itemname'] ?></strong>
                <!-- Expand Button -->
                    <?php
                    if ($ipclevelsordritemidd['isentry'] == 1) {
                ?>
                  </br>  <button data-bs-toggle="collapse" data-bs-target="#collapseOne" style = "margin-top: 5px;" ><i class="mdi mdi-plus"></i> </button>

                  <?php
                      }
                   ?>
              </td>

                <td><strong>BOQ</strong></td>
                <td><strong><?php echo $kfiallactivitylevelidss['itemcode'] ?></strong></td>
                <td><strong><?php echo $kfiallactivitylevelidss['isentry'] ?></strong></td>
                <td><strong><input type="checkbox" name="txtChkAll" id="txtChkAll" form="reports" onclick="group_checkbox();"></strong></td>
              </tr>

                  <?php

                    $ObjKfiDash3->setProperty("itemids", $kfiallactivitylevelidss['itemid']); //14
                    $kfidefalupageitemname = $ObjKfiDash3->getActivity_LevelData(); //16 17 18 19

                    while ($plevelrowitemname = $ObjKfiDash3->dbFetchArray()) {

                        ?>
                      <tr class="text-dark" style="font-size:12px; color:#CCC; background:#c7ceef;">
                        <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $plevelrowitemname['itemname'] ?></strong>
                        <!-- Expand Button -->
                        <?php
                      if ($plevelrowitemname['isentry'] == 1) {
                        ?>
                          </br>  <button data-bs-toggle="collapse" data-bs-target="#collapseOne" style = "margin-top: 5px;" ><i class="mdi mdi-plus"></i> </button>

                            <?php
                              }
                            ?>
                      </td>

                        <td><strong>BOQ</strong></td>
                        <td><strong><?php echo $plevelrowitemname['itemcode'] ?></strong></td>
                        <td><strong><?php echo $plevelrowitemname['isentry'] ?></strong></td>
                        <td><strong><input type="checkbox" name="txtChkAll" id="txtChkAll" form="reports" onclick="group_checkbox();"></strong></td>
                      </tr>

                    <?php

                      $ObjKfiDash4->setProperty("itemids", $plevelrowitemname['itemid']); //16
                      $kfidefalupageitemname = $ObjKfiDash4->getActivity_LevelData(); //20 22

                      while ($plevelrowitemname33 = $ObjKfiDash4->dbFetchArray()) {

                          ?>

                      <tr class="text-dark" style="font-size:12px; color:#CCC; background:#eceef9;">
                          <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $plevelrowitemname33['itemname'] ?></strong>
                          <!-- Expand Button -->
                          <?php
                                if ($plevelrowitemname33['isentry'] == 1) {
                    ?>
                            </br>  <button data-bs-toggle="collapse" data-bs-target="#collapseOne" style = "margin-top: 5px;" ><i class="mdi mdi-plus"></i> </button>

                            <?php
                                  }
                            ?>
                        </td>

                          <td><strong>BOQ</strong></td>
                          <td><strong><?php echo $plevelrowitemname33['itemcode'] ?></strong></td>
                          <td><strong><?php echo $plevelrowitemname33['isentry'] ?></strong></td>
                          <td><strong><input type="checkbox" name="txtChkAll" id="txtChkAll" form="reports" onclick="group_checkbox();"></strong></td>
                        </tr>

                    <?php

                      $ObjKfiDash5->setProperty("itemids", $plevelrowitemname33['itemid']); //16
                      $kfidefalupageitemname = $ObjKfiDash5->getActivity_LevelData(); //20 22

                      while ($plevelrowitemname44 = $ObjKfiDash5->dbFetchArray()) {

                          ?>

            <tbody>

            <!-- Data Table -->
            <tr class="text-dark" style="font-size:12px; color:#CCC; background:#fff;">
                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $plevelrowitemname44['itemname'] ?></strong>
                <!-- Expand Button -->
                    <?php
                          if ($plevelrowitemname44['isentry'] == 1) {
                        ?>  <button onclick="insertipc_data(input_ipcid_value_<?php echo $plevelrowitemname44['itemid'] ?>.value,input_boq_value_<?php echo $plevelrowitemname44['itemid'] ?>.value,ipcvalue_qty_<?php echo $plevelrowitemname44['itemid'] ?>.value)" data-bs-toggle="collapse" data-bs-target="#abc<?php echo $plevelrowitemname44['itemid'] ?>" style = "margin-top: 5px;" ><i class="mdi mdi-plus"></i> </button>

                      <?php
                            }
                    ?>
              </td>

                <td><strong>BOQ</strong></td>
                <td><strong><?php echo $plevelrowitemname44['itemcode'] ?></strong></td>
                <td><strong><?php echo $plevelrowitemname44['isentry'] ?></strong></td>
                <td><strong><input type="checkbox" name="txtChkAll" id="txtChkAll" form="reports" onclick="group_checkbox();"></strong></td>
              </tr>

             <tr class="text-dark" style="font-size:12px; color:#CCC;">
                <td colspan="5" style = " padding : 0 ; margin: 0; " >
                <div class="accordion" id="accordionExample<?php echo $plevelrowitemname44['itemid'] ?>" style = "" >
                                    <div id="abc<?php echo $plevelrowitemname44['itemid'] ?>" class="accordion-collapse collapse " data-bs-parent="#accordionExample<?php echo $plevelrowitemname44['itemid'] ?>">

                                    <div class="accordion-body"  >



                                    <?php

                    $ObjKfiDash6->setProperty("boqitemid", $plevelrowitemname44['itemid']); //13
                    $kfiallactivitylevelids = $ObjKfiDash6->getDataFromBoq(); //14 15

                    while ($plevelrowitemname55 = $ObjKfiDash6->dbFetchArray()) {

                        $kfiprojectlevel = $IpcClassObj->getActiveIpcNo();

                        $ipcid = "";
                        $ipcavailable = "";
                        $ipcavailablemonth = "";
                        $ipcqtyyy = "";

                        while ($ipcrows = $IpcClassObj->dbFetchArray()) {
                            $ipcid = $ipcrows['ipcid'];
                            $ipcavailable = $ipcrows['ipcno'];
                            $ipcavailablemonth = $ipcrows['ipcmonth'];

                        }

                        $ipciddd = $ipcid;
                        $boqiddd = $plevelrowitemname55['boqid'];

                        $IpcClassObj2->setProperty("boqiddd", $boqiddd);
                        $IpcClasslevel = $IpcClassObj2->checkexistIpcIdIpcvTable();

                        if ($isdataavailable = $IpcClassObj2->dbFetchArray()) // if not available
                        {
                            $ipcqtyyy = $isdataavailable['ipcqty'];

                        }

                        ?>
                                          <table class="table table-striped">
                                                  <tdead>
                                                    <tr class="" style="font-size:12px; color:#CCC;  background:#000">
                                                    <th  widtd="26%"><strong>Activty</strong></th>
                                                    <th  widtd="8%"><strong>Code</strong></th>
                                                    <th widtd="12%"><strong>Item</strong></th>
                                                    <th widtd="8%"><strong>Unit</strong></th>
                                                    <th widtd="8%"><strong>Quantuty</strong></th>
                                                    <th widtd="10%"><strong>PKR Rate <br> (Base Currency)</strong></th>
                                                    <th widtd="10%"><strong>USD Rate <br> (Exchange Rate <?php echo $plevelrowitemname55['cur_2_exchrate'] ?>)</strong></th>
                                                    <th widtd="10%"><strong>IPC As on <?php echo $ipcavailablemonth ?></strong></th>
                                                    <th widtd="8%"><strong>Action</strong></th>
                                                    </tr>
                                                </tdead>

                                                <form action="#" method="post">
                                                <tbody>

                                            <tr class="text-dark" style="font-size:12px; color:#CCC;">
                                                    <td><?php echo $plevelrowitemname44['itemname'] ?> </td>
                                                    <td><?php echo $plevelrowitemname55['boqcode'] ?></td>
                                                    <td><?php echo $plevelrowitemname55['boqitem'] ?></td>
                                                    <td><?php echo $plevelrowitemname55['boqunit'] ?></td>
                                                    <td><?php echo $plevelrowitemname55['boqqty'] ?> </td>
                                                    <td><?php echo $plevelrowitemname55['boq_cur_1_rate'] ?></td>
                                                    <td><?php echo $plevelrowitemname55['boq_cur_2_rate'] ?></td>

                                                        <input  type="hidden" id="input_ipcid_value_<?php echo $plevelrowitemname44['itemid'] ?>" name="input_ipcid_value_<?php echo $plevelrowitemname44['itemid'] ?>" value="<?php echo $ipcid ?>"/>
                                                        <input  type="hidden" id="input_boq_value_<?php echo $plevelrowitemname44['itemid'] ?>" name="input_boq_value_<?php echo $plevelrowitemname44['itemid'] ?>" value="<?php echo $plevelrowitemname55['boqid'] ?>"/>
                                                        <td><input class=" form-control form-control-enhanced" type="text" id="ipcvalue_qty_<?php echo $plevelrowitemname44['itemid'] ?>" name="ipcvalue_qty_<?php echo $plevelrowitemname44['itemid'] ?>" placeholder="<?php echo $ipcqtyyy; ?>"/></td>
                                                        <td><button  value="submit" type="button" name="submitupdate" id="submitupdate" class="btn btn-warning btn-sm" onclick="updateipc_data(input_ipcid_value_<?php echo $plevelrowitemname44['itemid'] ?>.value,input_boq_value_<?php echo $plevelrowitemname44['itemid'] ?>.value,ipcvalue_qty_<?php echo $plevelrowitemname44['itemid'] ?>.value)">Update</button></td>
                                                        <!-- <button value="submit" type="button" name="submitedit" id="submitedit" class="btn btn-primary btn-sm" >Edit</button> -->
                                                  </tr>

                                                </tbody>
                                                </form>

                                                <?php
                                                  }
                                                ?>


                                        </table>

                                        <div  style = "margin-top:10px">
                                        <!-- Hide & Close Buttons -->
                                        <button  data-bs-toggle="collapse" data-bs-target="#abc<?php echo $plevelrowitemname44['itemid'] ?>" type="button" class=" btn btn-outline-info  btn-sm"   style = "margin-right:5px;" >Hide</button>
                                        <!-- <button  data-bs-toggle="collapse" data-bs-target="#abc<?php echo $plevelrowitemname44['itemid'] ?>" type="button" class=" btn btn-outline-danger  btn-sm"   style = "margin-right:5px;" >Close</button> -->

                                        </div>
                                      </div>
                                    </div>
                                  </div> <!-- accordion  id="accordionExample"  -->
                         </td>
                      </tr>




                    </tbody>

                  <?php

                }

            }
        }

    }

}

?>



</table>

