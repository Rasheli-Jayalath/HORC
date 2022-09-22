<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Drawing Register";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($kpid_flag==0)
{
	header("Location: index.php?init=3");
}
$kpi_temp_id			= $_GET['kpi_temp_id'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg	= "";
//This is the default language. We will use it 2 places, so i am put it 
//into a varaible.
$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
    //Based on the lowecase $_GET['language'] value, we will decide,
    //what lanuage do we use
    switch (strtolower($_GET["language"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang'] = 'en';
            break;
        case "rus":
            //If the string is tr or TR
            $_SESSION['lang'] = 'rus';
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang'] = $defaultLang;
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.admin.php');

}
else
{
	require_once('rs_lang.admin_rus.php');

}
$comp_id = $_REQUEST['comp_id'];
$contract_id = $_REQUEST['contract_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Drawing Register</title>
<link rel="stylesheet" type="text/css" href="css/styleNew.css">
<style>
.search_box
{
	height:60px;
	background-color:#FF6317;
	
	margin-top:35px;
	padding-top:30px;
	padding-left:15px;
}
</style>
<script>
function doFilter(frm){
	var qString = '';
	if(frm.comp_id.value != ""){
		qString += 'comp_id=' + escape(frm.comp_id.value);
	}
	if(frm.contract_id.value != ""){
		qString += '&contract_id=' + escape(frm.contract_id.value);
	}
	
	document.location = 'drawing_reg.php?' + qString;
}

</script>
<style>/* Unless you use normalizer or some other CSS reset, 
you need to set all these properties. */body,html{ height: 100%; margin:0; padding:0; overflow:hidden; }
</style>
</head>
<body>
  <?php 
		include 'includes/header.php'; 
	?>

<br/>

<h1 style="font-size:22px; color:#000">Drawing Register</h1>

<form action="" target="_self" method="post"  enctype="multipart/form-data">
<div class="search_box">
<strong>Component:</strong> 
<select id="comp_id" name="comp_id" >
<option value="">Select Component</option>
<option value="1" <?php if($comp_id==1) echo "selected='selected'";?> >Civil</option>
<option value="2" <?php if($comp_id==2) echo "selected='selected'";?> >Electrical</option>
</select>
&nbsp;&nbsp;
 <strong>Contractor:</strong> <select id="contract_id" name="contract_id" >
  <option value=""> Select Contractor</option>
  <option value="1" <?php if($contract_id==1) echo "selected='selected'";?> > Ashoka Buildcon</option>
  <option value="2" <?php if($contract_id==2) echo "selected='selected'";?> > Sri Gopikrishna Infrastructures</option>
  <option value="3" <?php if($contract_id==3) echo "selected='selected'";?> > Laser Power & Infra</option>
  <option value="4" <?php if($contract_id==4) echo "selected='selected'";?> > Shalaka Infra Tech Pvt. Ltd.</option>
  <option value="5" <?php if($contract_id==5) echo "selected='selected'";?> > Vikran & Exim Pvt. Ltd.</option>
  
  </select>
  <input type="button"  onclick="doFilter(this.form);" class="SubmitButton" name="Submit" id="Submit" value=" <?php echo VIEW; ?> " />
</div>
</form>
<div id="result1" style="margin-top:10px">
<?php
if ($comp_id == 1 && $contract_id == 1)
{
	$filename_civil =   "civil-Ashoka.htm";
	}
else if($comp_id == 1 && $contract_id == 2)
{
	$filename_civil =  "civil-SriGopikrishna.htm";
	}
else if($comp_id == 1 && $contract_id == 3)
{
	$filename_civil =   "civil-LaserPower.htm";
	}
else if($comp_id == 1 && $contract_id == 4)
{
	$filename_civil =   "civil-ShalakaInfra.htm";
	}
else if($comp_id == 1 && $contract_id == 5)
{
	$filename_civil =   "civil-VikranExim.htm";
	}



if ($comp_id == 2 && $contract_id == 1)
{
	$filename_electrical =   "electrical-Ashoka.htm";
	}
else if($comp_id == 2 && $contract_id == 2)
{
	$filename_electrical =  "electrical-SriGopikrishna.htm";
	}
else if($comp_id == 2 && $contract_id == 3)
{
	$filename_electrical =   "electrical-LaserPower.htm";
	}
else if($comp_id == 2 && $contract_id == 4)
{
	$filename_electrical =   "electrical-ShalakaInfra.htm";
	}
else if($comp_id == 2 && $contract_id == 5)
{
	$filename_electrical =   "electrical-VikranExim.htm";
	}
	?>
    
    <?php if (isset($filename_civil)) {?>

<iframe style="min-height:300px;  " src="pages/civil/<?php echo $filename_civil; ?>" title="description" frameborder="0" min-height="300px" width="100%" 
scrolling="auto" id="frame1"></iframe> 
<?php }
else if (isset($filename_electrical)){?>
<iframe style="min-height:300px" src="pages/electrical/<?php echo $filename_electrical; ?>" title="description" min-height="300px" width="100%" 
scrolling="auto" frameborder="0" scrolling="auto"  ></iframe>
<?php } ?>
</div>
</div>
</body>
</html>