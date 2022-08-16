<?php 
include_once("../config/config.php");
include_once("../rs_lang.admin.php");
$objSDb  		= new Database();
$objDb  		= new ProjectSetup();
$objPD  		= new ProjectSetup();
$objCommon 		= new Common();
$objAdminUser 	= new AdminUser();
 $objPD->getProject();
  $PCount=$objPD->totalRecords();
  
  if($PCount==1)
  {
	   while ($prows = $objPD->dbFetchArray()) {
	  $pid 						= $prows['pid'];
	  $pcode 					= $prows['pcode'];
	 // $pname	 				= $prows['pname'];
	  $pdetail					= $prows['pdetail'];
	  
	   }
  }
 ?><nav
  class="
    navbar
    default-layout
    col-lg-12 col-12
    p-0
    fixed-top
    d-flex
    align-items-top
    flex-row
  "
>
  <div
    class="
      text-center
      navbar-brand-wrapper
      d-flex
      align-items-center
      justify-content-start
    "
  >
    <div class="me-3" id="navbarburgericon">
      <button
        class="navbar-toggler navbar-toggler align-self-center"
        type="button"
        data-bs-toggle="minimize"
      >
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="<?php echo SITE_URL; ?>index.php">
        <img src="<?php echo SITE_URL; ?>images/smec-logo.png" alt="logo" />
      </a>
      <a class="navbar-brand brand-logo-mini" href="<?php echo SITE_URL; ?>index.php">
        <img src="<?php echo SITE_URL; ?>images/logo-mini.svg" alt="logo" />
      </a>
    </div>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav">
      <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
        <h2 class="text-black fw-bold">
          Project Monitoring and Management Information System (PMIS)
        </h2>
        <!-- <h3>Good Morning, <span class="text-black fw-bold">Pulasthi Bethmage</span></h3> -->
        <h3 class="welcome-sub-text" style="font-weight:bold; color:#006">
     <?php echo $pdetail;?>
        </h3>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <form class="search-form" action="#">
          <i class="icon-search"></i>
          <input
            type="search"
            class="form-control"
            placeholder="Search Here"
            title="Search here"
          />
        </form>
      </li>
      <li class="nav-item dropdown">
        <a
          class="nav-link count-indicator"
          id="notificationDropdown"
          href="#"
          data-bs-toggle="dropdown"
        >
          <i class="icon-mail icon-lg"></i>
        </a>
        <div
          class="
            dropdown-menu dropdown-menu-right
            navbar-dropdown
            preview-list
            pb-0
          "
          aria-labelledby="notificationDropdown"
        >
          <a class="dropdown-item py-3 border-bottom">
            <p class="mb-0 font-weight-medium float-left">
              You have 4 new notifications
            </p>
            <span class="badge badge-pill badge-primary float-right"
              >View all</span
            >
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-alert m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject fw-normal text-dark mb-1">
                Application Error
              </h6>
              <p class="fw-light small-text mb-0">Just now</p>
            </div>
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-settings m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject fw-normal text-dark mb-1">Settings</h6>
              <p class="fw-light small-text mb-0">Private message</p>
            </div>
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-airballoon m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject fw-normal text-dark mb-1">
                New user registration
              </h6>
              <p class="fw-light small-text mb-0">2 days ago</p>
            </div>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a
          class="nav-link count-indicator"
          id="countDropdown"
          href="#"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          <i class="icon-bell"></i>
          <span class="count"></span>
        </a>
        <div
          class="
            dropdown-menu dropdown-menu-right
            navbar-dropdown
            preview-list
            pb-0
          "
          aria-labelledby="countDropdown"
        >
          <a class="dropdown-item py-3">
            <p class="mb-0 font-weight-medium float-left">
              You have 3 unread mails
            </p>
            <span class="badge badge-pill badge-primary float-right"
              >View all</span
            >
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img
                src="<?php echo SITE_URL; ?>images/faces/face10.png"
                alt="image"
                class="img-sm profile-pic"
              />
            </div>
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">
               Mobina Zafar
              </p>
              <p class="fw-light small-text mb-0">KFI dashbaord is updated</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img
                src="<?php echo SITE_URL; ?>images/faces/face10.jpg"
                alt="image"
                class="img-sm profile-pic"
              />
            </div>
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">
                Tahira Nasreen
              </p>
              <p class="fw-light small-text mb-0">DMS is upto date.</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img
                src="<?php echo SITE_URL; ?>images/faces/face1.jpg"
                alt="image"
                class="img-sm profile-pic"
              />
            </div>
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">
                Umair Asharf
              </p>
              <p class="fw-light small-text mb-0">GIS is updated</p>
            </div>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown d-none d-lg-block user-dropdown">
        <a
          class="nav-link"
          id="UserDropdown"
          href="#"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          <img
            class="img-xs rounded-circle"
            src="<?php echo SITE_URL; ?>images/faces/face_default.png"
            alt="Profile image"
            title= "Welcome <?php echo $objAdminUser->ne_fullname_name;?>"
          />
        </a>
        <div
          class="dropdown-menu dropdown-menu-right navbar-dropdown"
          aria-labelledby="UserDropdown"
        >
          <div class="dropdown-header text-center">
            <img
              class="img-md rounded-circle"
              src="<?php echo SITE_URL; ?>images/faces/face_default.png"
              alt="Profile image"
              title="Welcome <?php echo $objAdminUser->ne_fullname_name;?>"
            />
            <p class="mb-1 mt-3 font-weight-semibold"><?php echo $objAdminUser->ne_fullname_name;?></p>
            <p class="fw-light text-muted mb-0"><?php echo $objAdminUser->ne_email;?></p>
          </div>
          <a class="dropdown-item"
            ><i
              class="
                dropdown-item-icon
                mdi mdi-account-outline
                text-primary
                me-2
              "
            ></i>
            My Profile <span class="badge badge-pill badge-danger">1</span></a
          >
          <a class="dropdown-item"
            ><i
              class="
                dropdown-item-icon
                mdi mdi-message-text-outline
                text-primary
                me-2
              "
            ></i>
            Messages</a
          >
          <a class="dropdown-item"
            ><i
              class="
                dropdown-item-icon
                mdi mdi-calendar-check-outline
                text-primary
                me-2
              "
            ></i>
            Activity</a
          >
          <a class="dropdown-item"
            ><i
              class="
                dropdown-item-icon
                mdi mdi-help-circle-outline
                text-primary
                me-2
              "
            ></i>
            Help</a
          >
          <a class="dropdown-item"
           href="<?php echo SITE_URL; ?>pages/user-access-manage/logout.php" ><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i
            >Sign Out</a
          >
        </div>
      </li>
    </ul>
    <button
      class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
      type="button"
      data-bs-toggle="offcanvas"
    >
      <span class="mdi mdi-menu"></span>
    </button>
  </div>

  <!-- Second Nav Bar -->
  <!-- Second Nav Bar -->
  <!-- Second Nav Bar -->
</nav>

<!-- inject:js -->
<script src="<?php echo SITE_URL; ?>js/off-canvas.js"></script>
<script src="<?php echo SITE_URL; ?>js/hoverable-collapse.js"></script>
<script src="<?php echo SITE_URL; ?>js/template.js"></script>
<script src="<?php echo SITE_URL; ?>js/settings.js"></script>
<script src="<?php echo SITE_URL; ?>js/todolist.js"></script>
<!-- <script src="<?php echo SITE_URL; ?>js/navtype_session.js"></script> -->
<!-- endinject -->

<script>
  // function viewVerticalNav() {
  //   sessionStorage.clear();

  //   sessionStorage.setItem("NAVTYPE", "VERTNAV");

  //   document.getElementById("navbarburgericon").style.display = "block";
  //   document.getElementById("horizontalnavbar").style.display = "none";
  //   document.getElementById("pagebodywraper").style.marginTop = "0px";
  //   document.getElementById("partials-sidebar-offcanvas").style.display =
  //     "block";
  //   document.getElementById("mainpanel").style.width = "calc(100% - 220px)";
  //   document.getElementById("mainpanel").style.display = "flex";
  //   document.getElementById("offcanvabutton").style.right = "200px";
  // }
</script>
