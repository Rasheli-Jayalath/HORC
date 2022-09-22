<?php 
include_once("../../../config/config.php");
$ObjPictoAna = new PictorialAnalysis();

$pid=$_REQUEST['ppid'];

if(isset($_REQUEST['save']))
{ 

  $pid=$_REQUEST['pid'];
  $title=$_REQUEST['title'];

  $ObjPictoAna->setProperty("pid",$pid); 
  $ObjPictoAna->setProperty("title",$title); 
  $pictoalbumname = $ObjPictoAna->setLocationComponent(); 
  // while($rowsallcompo=$ObjPictoAna->dbFetchArray())
  // {
  //     $date_p = $rowsallcompo['date_p'];
  // }

        echo "
            <script type=\"text/javascript\">
            javascript:window.close();
            </script>
        ";


}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- bootstrap -->
    <title>Components</title>
</head>
<body>
    
    <style>
    .col-sm-6{
      text-align: center;
      background-color:lavender;
      display: block;
      margin-left: auto;
      margin-right: auto;
      padding: 20px;
    }

    #tworow{
      padding: 20px;
    }

    h3{
      font-family: Arial, Helvetica, sans-serif;
    }

    label {
      font-weight: bold;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 100%;
    }

	button.hidden {
		display: none;
	}

	thead {
		text-align: center;	
	}

	tbody {
		text-align: center;	
	}

    #inp1{
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    #back{
        float:right;
    }

	
       
    </style>
    <div class="container-fluid">
    <div class="row">
    <div class="col-sm-12" style="background-color:lavender;" id="onerow">
    <div class="row">
      <div class="col-sm-6">
      <h3>Component</h3>
      
      <form class="form-horizontal" action="component_form.php" method="post" id='frm'>
     
    <div class="form-group">
    <input class="form-control"  type="text" style="width:290px;" id="title" name="title" required placeholder="Enter Component">
    </div>

    <input type="hidden" class="form-control" name="pid" id='pid' required value='<?php echo $_REQUEST['ppid']; ?>' placeholder="">

    <button type="submit" name="save" id="save" class="btn btn-success" style="width:110px;">SAVE</button>
  <button type="button" class="btn btn-secondary" style="width:110px;" onclick="javascript:window.close()">CANCEL</button>
  <button type="button" id="clear" class="btn btn-warning hidden">Clear</button>
    </form>
    <br>
    <!-- <button type="button" class="btn btn-warning" onclick="location.href='pictorial_form.php'" id="back" style="width:110px;">BACK</button> -->
	<button type="button" class="btn btn-warning" onclick="javascript:window.close()" id="back" style="width:110px;">BACK</button>
      </div><!--  class="col-sm-6"-->
      
      </div><!-- row sm 6 -->
      </div><!-- one row -->
    <div class="col-sm-12" style="background-color:lavenderblush;" id="tworow">
    <table class="table" id='table'>
    <thead class="thead-dark">
        <th>S#</th>
        <th>Title</th>
        <th colspan="2">Action</th>
        
    </thead>
    <tbody>
    <?php
							$sql="select * from location";
							$res=$con->query($sql);
							if($res->num_rows>0)
							{
								while($row=$res->fetch_assoc())
								{	
									echo"<tr class='{$row["lid"]}'>
										<td>{$row["lid"]}</td>
										<td>{$row["locat"]}</td>
										<td><a href='#' class='btn btn-primary edit' style='width:70px;' uid='{$row["lid"]}'>Edit</a></td>
										<td><a href='#' class='btn btn-danger del' style='width:70px;' uid='{$row["lid"]}'>Delete</a></td>					
									</tr>";
								}
							}
						?>
    </tbody>
</table>
    </div><!-- tworow -->
</div><!-- class="row" -->
    </div><!-- class="container" -->

    

</body>
</html>