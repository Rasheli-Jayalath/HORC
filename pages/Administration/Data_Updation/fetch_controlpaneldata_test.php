<?php
include_once "../../../config/config.php";
$IpcClassObj = new IpcClass();
$IpcClassObj2= new IpcClass();
$ObjKfiDash = new KfiDashboard();
$ObjKfiDash1 = new KfiDashboard();

?>

<table class="table table-striped"> 
              <tdead>
                <tr class="bg-form" style="font-size:14px; color:#CCC;">
                <th  width="47%"><strong>Item Name</strong></th>
                <th  width="15%"><strong>Stage</strong></th>
                <th width="15%"><strong>Item Code</strong></th>
                <th width="15%"><strong>Isentry</strong></th>
                <th  width="8%"><strong><input type="checkbox" name="txtChkAll" id="txtChkAll" form="reports" onclick="group_checkbox();"></strong></td>
              </tr>
            </tdead>

            <tbody>

            <?php

                $allboqtabledata = $ObjKfiDash->getAllDataOrderByAorder();
                while ($allboqtabledata = $ObjKfiDash->dbFetchArray()) {

              ?>
 
            <tr class="text-dark" style="font-size:12px; color:#CCC; background-color:antiquewhite;">
                <td><strong style="margin-left:<?php echo $allboqtabledata['activitylevel']*4 ?>0px;"><?php echo $allboqtabledata['itemname'] ?></strong> 
                <!-- Expand Button -->
                 <?php
                     if ($allboqtabledata['isentry'] == 1) {
                  ?>
                  <button onclick="insertipc_data(input_ipcid_value_<?php echo $allboqtabledata['itemid'] ?>.value,input_boq_value_<?php echo $allboqtabledata['itemid'] ?>.value,ipcvalue_qty_<?php echo $allboqtabledata['itemid'] ?>.value)" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $allboqtabledata['itemid'] ?>" style = "margin-top: 5px;" ><i class="mdi mdi-plus"></i> </button>

                  <?php
                  }
                 ?>
                </td>
                <td><strong><?php echo $allboqtabledata['stage'] ?></strong></td>
                <td><strong><?php echo $allboqtabledata['itemcode'] ?></strong></td>
                <td><strong><?php echo $allboqtabledata['isentry'] ?></strong></td>
                <td><strong><input type="checkbox" name="txtChkAll" id="txtChkAll" form="reports" onclick="group_checkbox();"></strong></td>
            </tr>
              
            <?php

                $IpcClassObj->setProperty("itemid", $allboqtabledata['itemid']);
                $boqdatadetailsbyitemid = $IpcClassObj->getDataFromBoq();
                while ($boqdatadetailsbyitemid = $IpcClassObj->dbFetchArray()) 
                {

                  $boqiddd = $boqdatadetailsbyitemid['boqid'];

                        $IpcClassObj2->setProperty("boqiddd", $boqiddd);
                        $IpcClasslevel = $IpcClassObj2->checkexistIpcIdIpcvTable();

                        if ($isdataavailable = $IpcClassObj2->dbFetchArray()) // if not available
                        {
                            $ipcqtyyy = $isdataavailable['ipcqty'];

                        }

                        $kfiprojectlevel = $IpcClassObj->getActiveIpcNo();
                        while ($ipcrows = $IpcClassObj->dbFetchArray()) {
                          $ipcid = $ipcrows['ipcid'];
                          $ipcavailable = $ipcrows['ipcno'];
                          $ipcavailablemonth = $ipcrows['ipcmonth'];

                      }

              ?>

             <tr class="text-dark" style="font-size:12px; color:#CCC;">
                <td colspan="5" style = " padding : 0 ; margin: 0; " >
                <div class="accordion" id="accordionExample" style = " padding :0; margin: 10px;" >
                                    <div id="collapse<?php echo $allboqtabledata['itemid'] ?>" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                                      <div class="accordion-body"  >
                                          <table class="table table-striped" style="table-layout:fixed; width: 100%"> 
                                                  <tdead>
                                                    <tr class="bg-primary" style="font-size:12px; color:#CCC;">
                                                    <th style="width:10%"><strong>Activty</strong></th>
                                                    <th style="width:5%"><strong>Code</strong></th>
                                                    <th style="width:15%"><strong></strong>Item</strong></th>
                                                    <th style="width:5%"><strong>Unit</strong></th>
                                                    <th style="width:5%"><strong>Quantity</strong></th>
                                                    <th style="width:5%;" ><strong>PKR Rate<br>Base Currency</strong></th>
                                                    <th style="width:5%"><strong>USD Rate <br> Exchange Rate <br>(<?php echo $boqdatadetailsbyitemid['cur_2_exchrate'] ?>)</strong></th>
                                                    <th style="width:10%"><strong>IPC As on<br>(<?php echo $ipcavailablemonth ?>)</strong></th>
                                                    <th style="width:5%"><strong>Action</strong></th>
                                                    </tr>
                                                </tdead>
                                                <tbody>
                                          <tr class="text-dark" style="font-size:12px; color:#CCC;">
                                                    <td><span style="white-space: normal;line-height:1.5;"><?php echo $allboqtabledata['itemname'] ?></span></td>
                                                    <td><?php echo $boqdatadetailsbyitemid['boqcode'] ?></td>
                                                    <td><span style="white-space: normal;line-height:1.5;"><?php echo $boqdatadetailsbyitemid['boqitem'] ?></span></td>
                                                    <td><?php echo $boqdatadetailsbyitemid['boqunit'] ?></td>
                                                    <td><?php echo $boqdatadetailsbyitemid['boqqty'] ?> </td>
                                                    <td><?php echo $boqdatadetailsbyitemid['boq_cur_1_rate'] ?></td>
                                                    <td><?php echo $boqdatadetailsbyitemid['boq_cur_2_rate'] ?></td>
                                                   
                                                    <input  type="hidden" id="input_ipcid_value_<?php echo $allboqtabledata['itemid'] ?>" name="input_ipcid_value_<?php echo $allboqtabledata['itemid'] ?>" value="<?php echo $ipcid ?>"/>
                                                        <input  type="hidden" id="input_boq_value_<?php echo $allboqtabledata['itemid'] ?>" name="input_boq_value_<?php echo $allboqtabledata['itemid'] ?>" value="<?php echo $boqdatadetailsbyitemid['boqid'] ?>"/>
                                                        <td><input class=" form-control form-control-enhanced" type="text" id="ipcvalue_qty_<?php echo $allboqtabledata['itemid'] ?>" name="ipcvalue_qty_<?php echo $allboqtabledata['itemid'] ?>" placeholder="<?php echo $ipcqtyyy; ?>"/></td>
                                                        <td><button  value="submit" type="button" name="submitupdate" id="submitupdate" class="btn btn-warning btn-sm" onclick="updateipc_data(input_ipcid_value_<?php echo $allboqtabledata['itemid'] ?>.value,input_boq_value_<?php echo $allboqtabledata['itemid'] ?>.value,ipcvalue_qty_<?php echo $allboqtabledata['itemid'] ?>.value)">Update</button></td>
                                              </tr>
                                                </tbody>
                                        </table>
                                        <div class=" m-2 "> 
                                        <button  data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $allboqtabledata['itemid'] ?>" type="button" class=" btn btn-outline-info  btn-sm"   style = "margin-right:5px;" >Hide</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div> <!-- accordion  id="accordionExample"  -->   
                </td>
              </tr>

              <?php
                }
                
              }
              ?>


            </tbody>


</table>

