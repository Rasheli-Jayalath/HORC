<div class="main-panel" id="mainpanel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Project Overview</a>
                    </li>
                      <li class="nav-item">
                      <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab" aria-selected="false">Logs
                      </a>
                    </li>
                  </ul>
                  <div>
                    <div class="btn-wrapper">
                      <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                      <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                      <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export</a>
                    </div>
                  </div>
                </div>
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
                    <div class="row">
                      <div class="col-sm-12" style="height:90px">
                        <div class="statistics-details d-flex align-items-center justify-content-between">
                        <div class="d-none d-md-block">
                            <p class="statistics-title">Planned Progress</p>
                            <h3 class="rate-percentage"><?php echo "40.5 %";?></h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>This Month: 12.5%</span></p>
                          </div>
                        <div>
                            <p class="statistics-title">Physical Progress</p>
                            <h3 class="rate-percentage">32.53%</h3>
                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>Gap: -7.97%</span></p>
                          </div>
                          
                          <div>
                            <p class="statistics-title">Financial Progress</p>
                            <h3 class="rate-percentage">10.15 %</h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>+0.1%</span></p>
                          </div>

                        <div>
                            <p class="statistics-title">Total Payment</p>
                            <h3 class="rate-percentage"><?php echo "20.5 M";?></h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span></span></p>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title">Last Payment(This Month)</p>
                            <h3 class="rate-percentage"><?php echo "2.5 M";?></h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span></span></p>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title">Last Updated</p>
                            <h3 class="rate-percentage"><?php echo date('d, F, Y',strtotime("10-06-2019"));?> </h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span></span></p>
                          </div>
                          
                                                    
                          
                        </div>
                      </div>
                    </div> 
                    <div class="row">
                      <div class="col-lg-8 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                   <h4 class="card-title card-title-dash">Project Physical Progress</h4>
                                   <h5 class="card-subtitle card-subtitle-dash">Planned Vs. Actual</h5>
                                  </div>
                                  <div id="performance-line-legend"></div>
                                </div>
                                <div class="chartjs-wrapper mt-5">
                                  <canvas id="performaneLine"></canvas>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4 d-flex flex-column">
                        <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <h4 class="card-title card-title-dash">Latest Project Issues</h4>
                                     
                                    </div>
                                    <div class="list-wrapper">
                                   <?php /*?> <marquee id="MARQUEE1" style="text-align: left; float: left; height: 210px;" scrollamount="4" onmouseout="this.start();" onmouseover="this.stop();" direction="up" behavior="scroll"><?php */?>
                                      <ul class="todo-list todo-list-rounded">
                                      <?php $swwSQL = "Select * from t012issues where iss_status<>0 order by nos_id DESC LIMIT 0,3 ";
							 $objSDb->dbQuery($swwSQL);
							  $issCount = $objSDb->totalRecords();
							  if($issCount>0)
							  {
							  while($iss_rows= $objSDb->dbFetchArray())
							  { ?>
                                        <li class="d-block">
                                          <div class="form-check w-100">
                                            <label class="form-check-label">
                                              <?php echo trim($iss_rows['iss_title']);?><i class="input-helper rounded"></i>
                                            </label>
                                            <div class="d-flex mt-2">
                                              <div class="ps-4 text-small me-3"> <?php echo date('d, F, Y',strtotime($iss_rows['iss_date']));?></div>
                                              <div class="badge <?php if($iss_rows['action_status']==1) 
												  {
													  echo 'badge-opacity-success"'; 
												  }
											  else { echo 'badge-opacity-warning"';
											       }?> me-3"><?php 
											  if($iss_rows['action_status']==1) 
												  {
													  echo "Resolved"; 
												  }
											  else { echo "Pending";
											       }?></div>
                                            </div>
                                          </div>
                                        </li> 
                                        <?php }
							  }?>
                              <br/>
                                      </ul>
                                    <?php /*?>  </marquee><?php */?>
                                    <div class="list align-items-right pt-3">
                                  <div class="wrapper w-100">
                                    <p class="mb-0">
                                      <a href="#" class="fw-bold text-primary">Show all <i class="mdi mdi-arrow-right ms-2"></i></a>
                                    </p>
                                  </div>
                                </div>
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                     
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-lg-8 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Financial Progress</h4>
                                   <p class="card-subtitle card-subtitle-dash">Total Financial Dispursement Todate</p>
                                  </div>
                                  <div>
                                    <div class="dropdown">
                                      <button class="btn btn-secondary dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> This month </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <h6 class="dropdown-header">Settings</h6>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Separated link</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                  <div class="d-sm-flex align-items-center mt-4 justify-content-between"><h2 class="me-2 fw-bold">$36,2531.00</h2><h4 class="me-2">USD</h4><h4 class="text-success">(+1.37%)</h4></div>
                                  <div class="me-3"><div id="marketing-overview-legend"></div></div>
                                </div>
                                <div class="chartjs-bar-wrapper mt-3">
                                  <canvas id="marketingOverview"></canvas>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded table-darkBGImg">
                              <div class="card-body">
                                <div class="col-sm-8">
                                  <h3 class="text-white upgrade-info mb-0">
                                    Latest <span class="fw-bold">News & Events on Project</span> 
                                  </h3>
                                  <a href="#" class="btn btn-info upgrade-btn">View All Events!</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                       
                      </div>
                      <div class="col-lg-4 d-flex flex-column">
                            <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card bg-primary card-rounded">
                              <div class="card-body pb-0">
                                <h4 class="card-title card-title-dash text-white mb-4">Dashboard Update Status</h4>
                                <div class="row">
                                  <div class="col-sm-4">
                                    <p class="status-summary-ight-white mb-1">Last Updated:</p>
                                    <h4 style="font-size:12px; color:#FFF">10-06-2019</h4>
                                  </div>
                                  <div class="col-sm-8">
                                    <div class="status-summary-chart-wrapper pb-4">
                                      <canvas id="status-summary"></canvas>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                                      <div class="circle-progress-width">
                                        <div id="totalVisitors" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2"><strong>CPI</strong></p>
                                        <h4 class="mb-0 fw-bold">0.9</h4>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="circle-progress-width">
                                        <div id="visitperday" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2"><strong>SPI</strong></p>
                                        <h4 class="mb-0 fw-bold">0.8</h4>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                         <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <h4 class="card-title  card-title-dash">Recent Events</h4>
                                <?php
 	$objNews->setProperty("status", "Y");
	$objNews->setProperty("orderby", "newsdate desc");
	$objNews->setProperty("limit", 4);
	$objNews->lstNews();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objNews->dbFetchArray(1)){
			
			?>
                                <div class="list align-items-center border-bottom py-2">
                                  <div class="wrapper w-100">
                                    <p class="mb-2 font-weight-medium">
                                      <?php echo $rows['title'];?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="d-flex align-items-center">
                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                        <p class="mb-0 text-small text-muted"><?php echo $rows['newsdate'];?></p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php } }?>
                                                                <div class="list align-items-center pt-3">
                                  <div class="wrapper w-100">
                                    <p class="mb-0">
                                      <a href="#" class="fw-bold text-primary">Show all <i class="mdi mdi-arrow-right ms-2"></i></a>
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div> 
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade show" id="audiences" role="tabpanel" aria-labelledby="audiences"> 
                    <div class="row">
                      <div class="col-lg-8 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Project Overview</h4>
                                   
                                  </div>
                                  <div>
                                    
                                  </div>
                                </div>
                                <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                
                                  <div class="me-3"><div id="marketing-overview-legend"></div></div>
                                </div>
                                <div class="chartjs-bar-wrapper mt-3">
                                <table class="table table-striped">
                                   <tr>
              <td width="16%" ><strong>Project code:</strong></td>
              <td colspan="3" ><?php echo $pcode; ?></td>
        </tr>
            <tr>
              <td  ><strong>Project Name:</strong></td>
              <td colspan="3" style="line-height:20px"><?php echo $pdetail; ?></td>
            </tr>
             <tr>
              <td  ><strong>Project Type:</strong></td>
              <td colspan="3" ><?php if($ptype==1) echo "Time-Based";
			  elseif($ptype==2) echo "Milestone"; ?></td>
            </tr>
            <tr>
              <td ><strong>Start Date:</strong></td>
              <td colspan="3" ><?php echo date("d-m-Y", strtotime($pstart)); ?></td>
        </tr>
			 <tr>
              <td ><strong>End Date:</strong></td>
              <td colspan="3" ><?php echo date("d-m-Y", strtotime($pend)); ?></td>
             </tr>
              <tr>
              <td ><strong>Client:</strong></td>
              <td colspan="3" ><?php echo $client; ?></td>
             </tr>
               <tr>
              <td ><strong>Consultant:</strong></td>
              <td colspan="3" ><?php echo $consultant; ?></td>
             </tr>
             <tr>
              <td ><strong>Funding Agency:</strong></td>
              <td colspan="3" ><?php echo $funding_agency; ?></td>
             </tr>
             <tr>
              <td ><strong>Contractor:</strong></td>
              <td colspan="3" ><?php echo $contractor; ?></td>
             </tr>
             <tr>
              <td ><strong>Contract Value:</strong></td>
              <td colspan="3" ><?php echo number_format($pcost,0); ?></td>
             </tr>
             <tr>
              <td ><strong>Sector:</strong></td>
              <td colspan="3" ><?php echo $sector_name; ?></td>
             </tr>
             <tr>
              <td ><strong>Country:</strong></td>
              <td colspan="3" ><?php echo $country_name; ?></td>
             </tr>
             <tr>
              <td ><strong>Location:</strong></td>
              <td colspan="3" ><?php echo $location; ?></td>
             </tr>
             <tr>
              <td ><strong>SMEC Code:</strong></td>
              <td colspan="3" ><?php echo $smec_code; ?></td>
             </tr>
             </table>
             
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Pending Requests</h4>
                                   <p class="card-subtitle card-subtitle-dash">You have 50+ new requests</p>
                                  </div>
                                  <div>
                                    <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button"><i class="mdi mdi-account-plus"></i>Add new member</button>
                                  </div>
                                </div>
                                <div class="table-responsive  mt-1">
                                  <table class="table select-table">
                                    <thead>
                                      <tr>
                                        <th>
                                          <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                          </div>
                                        </th>
                                        <th>Customer</th>
                                        <th>Company</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                          <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                          </div>
                                        </td>
                                        <td>
                                          <div class="d-flex ">
                                            <img src="images/faces/face1.jpg" alt="">
                                            <div>
                                              <h6>Brandon Washington</h6>
                                              <p>Head admin</p>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <h6>Company name 1</h6>
                                          <p>company type</p>
                                        </td>
                                        <td>
                                          <div>
                                            <div class="d-flex justify-content-between align-items-center mb-1 max-width-progress-wrap">
                                              <p class="text-success">79%</p>
                                              <p>85/162</p>
                                            </div>
                                            <div class="progress progress-md">
                                              <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                          </div>
                                        </td>
                                        <td><div class="badge badge-opacity-warning">In progress</div></td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                          </div>
                                        </td>
                                        <td>
                                          <div class="d-flex">
                                            <img src="images/faces/face2.jpg" alt="">
                                            <div>
                                              <h6>Laura Brooks</h6>
                                              <p>Head admin</p>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <h6>Company name 1</h6>
                                          <p>company type</p>
                                        </td>
                                        <td>
                                          <div>
                                            <div class="d-flex justify-content-between align-items-center mb-1 max-width-progress-wrap">
                                              <p class="text-success">65%</p>
                                              <p>85/162</p>
                                            </div>
                                            <div class="progress progress-md">
                                              <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                          </div>
                                        </td>
                                        <td><div class="badge badge-opacity-warning">In progress</div></td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                          </div>
                                        </td>
                                        <td>
                                          <div class="d-flex">
                                            <img src="images/faces/face3.jpg" alt="">
                                            <div>
                                              <h6>Wayne Murphy</h6>
                                              <p>Head admin</p>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <h6>Company name 1</h6>
                                          <p>company type</p>
                                        </td>
                                        <td>
                                          <div>
                                            <div class="d-flex justify-content-between align-items-center mb-1 max-width-progress-wrap">
                                              <p class="text-success">65%</p>
                                              <p>85/162</p>
                                            </div>
                                            <div class="progress progress-md">
                                              <div class="progress-bar bg-warning" role="progressbar" style="width: 38%" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                          </div>
                                        </td>
                                        <td><div class="badge badge-opacity-warning">In progress</div></td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                          </div>
                                        </td>
                                        <td>
                                          <div class="d-flex">
                                            <img src="images/faces/face4.jpg" alt="">
                                            <div>
                                              <h6>Matthew Bailey</h6>
                                              <p>Head admin</p>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <h6>Company name 1</h6>
                                          <p>company type</p>
                                        </td>
                                        <td>
                                          <div>
                                            <div class="d-flex justify-content-between align-items-center mb-1 max-width-progress-wrap">
                                              <p class="text-success">65%</p>
                                              <p>85/162</p>
                                            </div>
                                            <div class="progress progress-md">
                                              <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                          </div>
                                        </td>
                                        <td><div class="badge badge-opacity-danger">Pending</div></td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                          </div>
                                        </td>
                                        <td>
                                          <div class="d-flex">
                                            <img src="images/faces/face5.jpg" alt="">
                                            <div>
                                              <h6>Katherine Butler</h6>
                                              <p>Head admin</p>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <h6>Company name 1</h6>
                                          <p>company type</p>
                                        </td>
                                        <td>
                                          <div>
                                            <div class="d-flex justify-content-between align-items-center mb-1 max-width-progress-wrap">
                                              <p class="text-success">65%</p>
                                              <p>85/162</p>
                                            </div>
                                            <div class="progress progress-md">
                                              <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                          </div>
                                        </td>
                                        <td><div class="badge badge-opacity-success">Completed</div></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row flex-grow">
                          <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body card-rounded">
                                <h4 class="card-title  card-title-dash">Recent Events</h4>
                                <div class="list align-items-center border-bottom py-2">
                                  <div class="wrapper w-100">
                                    <p class="mb-2 font-weight-medium">
                                      Change in Directors
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="d-flex align-items-center">
                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                        <p class="mb-0 text-small text-muted">Mar 14, 2019</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="list align-items-center border-bottom py-2">
                                  <div class="wrapper w-100">
                                    <p class="mb-2 font-weight-medium">
                                      Other Events
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="d-flex align-items-center">
                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                        <p class="mb-0 text-small text-muted">Mar 14, 2019</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="list align-items-center border-bottom py-2">
                                  <div class="wrapper w-100">
                                    <p class="mb-2 font-weight-medium">
                                      Quarterly Report
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="d-flex align-items-center">
                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                        <p class="mb-0 text-small text-muted">Mar 14, 2019</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="list align-items-center border-bottom py-2">
                                  <div class="wrapper w-100">
                                    <p class="mb-2 font-weight-medium">
                                      Change in Directors
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="d-flex align-items-center">
                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                        <p class="mb-0 text-small text-muted">Mar 14, 2019</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="list align-items-center pt-3">
                                  <div class="wrapper w-100">
                                    <p class="mb-0">
                                      <a href="#" class="fw-bold text-primary">Show all <i class="mdi mdi-arrow-right ms-2"></i></a>
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                  <h4 class="card-title card-title-dash">Activities</h4>
                                  <p class="mb-0">20 finished, 5 remaining</p>
                                </div>
                                <ul class="bullet-line-list">
                                  <li>
                                    <div class="d-flex justify-content-between">
                                      <div><span class="text-light-green">Ben Tossell</span> assign you a task</div>
                                      <p>Just now</p>
                                    </div>
                                  </li>
                                  <li>
                                    <div class="d-flex justify-content-between">
                                      <div><span class="text-light-green">Oliver Noah</span> assign you a task</div>
                                      <p>1h</p>
                                    </div>
                                  </li>
                                  <li>
                                    <div class="d-flex justify-content-between">
                                      <div><span class="text-light-green">Jack William</span> assign you a task</div>
                                      <p>1h</p>
                                    </div>
                                  </li>
                                  <li>
                                    <div class="d-flex justify-content-between">
                                      <div><span class="text-light-green">Leo Lucas</span> assign you a task</div>
                                      <p>1h</p>
                                    </div>
                                  </li>
                                  <li>
                                    <div class="d-flex justify-content-between">
                                      <div><span class="text-light-green">Thomas Henry</span> assign you a task</div>
                                      <p>1h</p>
                                    </div>
                                  </li>
                                  <li>
                                    <div class="d-flex justify-content-between">
                                      <div><span class="text-light-green">Ben Tossell</span> assign you a task</div>
                                      <p>1h</p>
                                    </div>
                                  </li>
                                  <li>
                                    <div class="d-flex justify-content-between">
                                      <div><span class="text-light-green">Ben Tossell</span> assign you a task</div>
                                      <p>1h</p>
                                    </div>
                                  </li>
                                </ul>
                                <div class="list align-items-center pt-3">
                                  <div class="wrapper w-100">
                                    <p class="mb-0">
                                      <a href="#" class="fw-bold text-primary">Show all <i class="mdi mdi-arrow-right ms-2"></i></a>
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <div id="partials-footer"></div>
        <!-- partial -->
      </div>