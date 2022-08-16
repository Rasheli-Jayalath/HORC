
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row ">
      <!-- <div class="bg-light navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row  navbar-expand-lg  blur blur-rounded top-0   shadow-md   py-2 "> -->
      <nav class="navbar navbar-expand-lg  blur blur-rounded top-0  z-index-3  position-absolute my-0 py-2 start-0 end-0 ">
      <img src="smec.png" class="  " style=" width: 100px ; margin: 0.25%; margin-left: 40px;" alt="...">
        
        <div style = "margin: 0 auto; ">
       <span class="text-dark text-center font-weight-bold ml-5 " style="font-size: 22px;"><strong>Tarbela 4th Extension Hydropower Project </strong></span>
       </div>
      
       <div style=" width: 150px ;  margin: 0.1%;" >        <ul class="navbar-nav ms-auto">
        <div class="top-box-set" >


<?php if ($mode == 1) { ?>
<span style="position:absolute; top: 25% ; right: 150px;">
<form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop" style="padding: 0; border: none; background: none;"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 25% ; right: 150px;">
<form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume" style="padding: 0; border: none; background: none;"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 25% ; right: 100px;">
<form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout" style="padding: 0; border: none; background: none;" > <img src="logout.png" width="35px" height="35px" /> </button></form></span>
<span style="position:absolute; top: 25% ; right: 20px;font-family:Verdana, Geneva, sans-serif; font-size: 1.9em;font-weight:bold; color:#4CAF50; background-color:#FFF">PMU</span>

</div>
        </ul> </div>

       
</nav>
    </nav>