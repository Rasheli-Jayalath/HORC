<?php include_once("../config/config.php");
$objPD  		= new ProjectSetup();
$objPD->getProject();
  $PCount=$objPD->totalRecords();
  
  if($PCount==1)
  {
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="<?php echo SITE_URL; ?>index.php">
        <i class="mdi mdi-home menu-icon"></i>
        <span class="menu-title">Home</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/news/news_info.php">
        <i class="mdi mdi-calendar menu-icon"></i>
        <span class="menu-title">News & Events</span>
      </a>
    </li>

    <li class="nav-item nav-category">Dashboards</li>
    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#kfi-dashboard"
        aria-expanded="false"
        aria-controls="kfi-dashboard"
      >
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboards</span>

        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="kfi-dashboard">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">            <a
              class="nav-link"
              href="<?php echo SITE_URL; ?>pages/kfi-dashboard/kfi_dashboard.php"
              >KFIs Dashboard</a

            >
          </li>
             <?php /*?><li class="nav-item">            <a
              class="nav-link"
              href="<?php echo SITE_URL; ?>pages/eva-dashboard/eva_dashboard.php"
              >EVA Dashboard</a

            >
          </li><?php */?>
          <li class="nav-item">            <a
              class="nav-link"
              href="<?php echo SITE_URL; ?>pages/act-dashboard/act_dashboard.php"
              >Activity Dashboard</a

            >
          </li>
		 
		  <li class="nav-item">
         <a class="nav-link"
              href="<?php echo SITE_URL; ?>pages/kpi-dashboard/kpi_dashboard.php"
              >KPI Dashboard</a>
          </li>
		  
		   <li class="nav-item">
           <a class="nav-link"
              href="<?php echo SITE_URL; ?>pages/act-dashboard-summary/act_dashboard.php"
              >Progress Dashboard</a>
        
          </li>
		  
        </ul>
      </div>
    </li>
	 
        <li class="nav-item nav-category">Project Tools</li>
    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#project-tools"
        aria-expanded="false"
        aria-controls="project-tools"
      >
        <i class="mdi mdi-layers-outline menu-icon"></i>
        <span class="menu-title">Project Tools</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="project-tools">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a
              class="nav-link"
              href="<?php echo SITE_URL; ?>pages/project-tools/pictorial_analysis/analysis.php"
              >Pictorial Analysis</a
            >
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/maps_drawings/dm_drawingmap.php">Maps and Drawings</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/project_issues/project_issues_info.php">Project Issues</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/ncn/project_nonconfirmity_info.php">Non Conformity Notices</a>
          </li>
        </ul>
		 <!--<ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/drawing_register/drawing_reg.php?comp_id=1&contract_id=1">Drawing Register</a>
          </li>
        </ul>
		<ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/contractors/contractors.php?cid=1&category_cd=85">Contractors</a>
          </li>
        </ul>-->
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/design_progress/sp_design.php">Design Progress</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/risk_register/risk_register.php">Risk Register</a>
          </li>
        </ul>
       <?php /*?> <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/site_diary/site_diary.php">Site Diary</a>
          </li>
        </ul><?php */?>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/project-tools/RFI/rfi_info.php">Request for Inspection</a>
          </li>
        </ul>

      </div>
    </li>


    <li class="nav-item nav-category">Administration</li>
    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#admin-pro-setup"
        aria-expanded="false"
        aria-controls="admin-pro-setup"
      >
        <i class="mdi mdi-chart-line menu-icon"></i>
        <span class="menu-title">Project Setup</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="admin-pro-setup">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/administration/Data_Updation/project_details.php">Project Details</a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/administration/Data_Updation/project_structure.php">Define Project Structure</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#admin-bdata-setup"
        aria-expanded="false"
        aria-controls="admin-bdata-setup"
      >
        <i class="mdi mdi-floor-plan menu-icon"></i>
        <span class="menu-title">Base Data Setup</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="admin-bdata-setup">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
          <a class="nav-link" href="<?php echo SITE_URL; ?>pages/administration/BOQ/boqdata.php">Step 1 - BOQ Entry</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/administration/data_entry/addbaseline.php">Step 2 - Baseline Entry</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/administration/activity/maindata.php">Step 3 - Activities Entry</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/administration/kpi_entry/kpidata.php">Step 4 - KPIs Entry</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#admin-data-up"
        aria-expanded="false"
        aria-controls="admin-data-up"
      >
        <i class="mdi mdi-file-document-box menu-icon"></i>
        <span class="menu-title">Data Updation</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="admin-data-up">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
          <a
              class="nav-link"
              href="<?php echo SITE_URL; ?>pages/administration/IPC/addipc.php" >Step 1 - IPC Entry</a      >
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/administration/progress_entry/addprogress.php">Step 2 - Progress Entry</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#usermanagement"
        aria-expanded="false"
        aria-controls="usermanagement"
      >
        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
        <span class="menu-title">User Management</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="usermanagement">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/user-access-manage/user_mangement.php">Manage Users</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/administration/Data_Updation/project_structure.php">Define Project Structure</a>
          </li>-->
        </ul>
      </div>
    </li>

<li class="nav-item nav-category">Major Systems</li>
<li class="nav-item">
<a class="nav-link" href="<?php echo SITE_URL; ?>DMS/" target="_blank">
<i class="mdi mdi-bulletin-board menu-icon"></i>
<span class="menu-title">DMS</span>
</a>
</li>
<!--<li class="nav-item">
<a class="nav-link" href="<?php echo SITE_URL; ?>GIS/" target="_blank">
<i class="mdi mdi-chart-arc menu-icon"></i>
<span class="menu-title">GIS</span>
</a>
</li>-->

<li class="nav-item">
<a class="nav-link" href="#" onclick="return confirm('If You want GIS Module, Please contact us.')" target="_blank">
<i class="mdi mdi-chart-arc menu-icon"></i>
<span class="menu-title">GIS</span>
</a>
</li>
<!--<li class="nav-item">
<a class="nav-link" href="#" >
<i class="mdi mdi-book-open menu-icon"></i>
<span class="menu-title">Strategic Dashboard</span>
</a>
</li>-->

    <li class="nav-item nav-category">Settings</li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo SITE_URL; ?>pages/user-access-manage/logout.php">
        <i class="mdi mdi-logout menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
  </ul>
</nav>
  
  <?php
  }
  else
  {
	  ?>
	  <nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="<?php echo SITE_URL; ?>index.php">
        <i class="mdi mdi-home menu-icon"></i>
        <span class="menu-title">Home</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="mdi mdi-calendar menu-icon"></i>
        <span class="menu-title">News & Events</span>
      </a>
    </li>

    <li class="nav-item nav-category">Dashboards</li>
    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#kfi-dashboard"
        aria-expanded="false"
        aria-controls="kfi-dashboard"
      >
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboards</span>

        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="kfi-dashboard">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">            <a
              class="nav-link"
              href=""
              >KFIs Dashboard</a

            >
          </li>
            <!-- <li class="nav-item">            <a
              class="nav-link"
              href=""
              >EVA Dashboard</a

            >
          </li>-->
          <li class="nav-item">            <a
              class="nav-link"
              href=""
              >Activity Dashboard</a

            >
          </li>
		   <li class="nav-item">
         <a class="nav-link"
              href="#"
              >KPI Dashboard</a>
          </li>
		   <li class="nav-item">
         <a class="nav-link"
              href="#"
              >Progress Dashboard</a>
          </li>
        </ul>
      </div>
    </li>
	 
        <li class="nav-item nav-category">Project Tools</li>
    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#project-tools"
        aria-expanded="false"
        aria-controls="project-tools"
      >
        <i class="mdi mdi-layers-outline menu-icon"></i>
        <span class="menu-title">Project Tools</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="project-tools">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a
              class="nav-link"
              href=""
              >Pictorial Analysis</a
            >
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Maps and Drawings</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Project Issues</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Non Conformity Notices</a>
          </li>
        </ul>
		<!--<ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Drawing Register</a>
          </li>
        </ul>
		<ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Contractors</a>
          </li>
        </ul>-->
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Design Progress</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Risk Register</a>
          </li>
        </ul>
       <!-- <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Site Diary</a>
          </li>
        </ul>-->
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Request for Inspection</a>
          </li>
        </ul>

      </div>
    </li>


    <li class="nav-item nav-category">Administration</li>
    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#admin-pro-setup"
        aria-expanded="false"
        aria-controls="admin-pro-setup"
      >
        <i class="mdi mdi-chart-line menu-icon"></i>
        <span class="menu-title">Project Setup</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="admin-pro-setup">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Project Details</a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="">Define Project Structure</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#admin-bdata-setup"
        aria-expanded="false"
        aria-controls="admin-bdata-setup"
      >
        <i class="mdi mdi-floor-plan menu-icon"></i>
        <span class="menu-title">Base Data Setup</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="admin-bdata-setup">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
          <a class="nav-link" href="">Step 1 - BOQ Entry</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="#">Step 2 - Baseline Entry</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="#">Step 3 - Activities Entry</a>
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="#">Step 4 - KPIs Entry</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#admin-data-up"
        aria-expanded="false"
        aria-controls="admin-data-up"
      >
        <i class="mdi mdi-file-document-box menu-icon"></i>
        <span class="menu-title">Data Updation</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="admin-data-up">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
          <a
              class="nav-link"
              href="" >Step 1 - IPC Entry</a      >
          </li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="#">Step 2 - Progress Entry</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a
        class="nav-link"
        data-bs-toggle="collapse"
        href="#usermanagement"
        aria-expanded="false"
        aria-controls="usermanagement"
      >
        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
        <span class="menu-title">User Management</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="usermanagement">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/user-access-manage/user_mangement.php">Manage Users</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>pages/administration/Data_Updation/project_structure.php">Define Project Structure</a>
          </li>-->
        </ul>
      </div>
    </li>

<li class="nav-item nav-category">Major Systems</li>
<li class="nav-item">
<a class="nav-link" href="<?php echo SITE_URL; ?>DMS/" target="_blank">
<i class="mdi mdi-bulletin-board menu-icon"></i>
<span class="menu-title">DMS</span>
</a>
</li>
<!--<li class="nav-item">
<a class="nav-link" href="<?php echo SITE_URL; ?>GIS/" target="_blank">
<i class="mdi mdi-chart-arc menu-icon"></i>
<span class="menu-title">GIS</span>
</a>
</li>-->

<li class="nav-item">
<a class="nav-link" href="#" onclick="return confirm('If You want GIS Module, Please contact us.')" target="_blank">
<i class="mdi mdi-chart-arc menu-icon"></i>
<span class="menu-title">GIS</span>
</a>
</li>

<!--<li class="nav-item">
<a class="nav-link" href="#" >
<i class="mdi mdi-book-open menu-icon"></i>
<span class="menu-title">Strategic Dashboard</span>
</a>
</li>-->

    <li class="nav-item nav-category">Settings</li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo SITE_URL; ?>pages/user-access-manage/logout.php">
        <i class="mdi mdi-logout menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
  </ul>
</nav>
<?php	  
  }
  ?>
<script>
  // function viewHorizontalNav() {
  //   sessionStorage.clear();

  //   sessionStorage.setItem("NAVTYPE", "HORZNAV");

  //   document.getElementById("navbarburgericon").style.display = "none";
  //   document.getElementById("horizontalnavbar").style.display = "block";
  //   document.getElementById("pagebodywraper").style.marginTop = "55px";
  //   document.getElementById("partials-sidebar-offcanvas").style.display =
  //     "none";
  //   document.getElementById("mainpanel").style.width = "100%";
  //   document.getElementById("offcanvabutton").style.left = "-10px";
  // }
</script>
