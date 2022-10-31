<?php 
 include_once "../../../config/config.php";


 $objDb3  		= new Database();
 $objDb4  		= new Database();

 $objDb5  		= new Database();
 $objDb6  		= new Database();


// Load the database configuration file 
// include_once 'dbConfig.php'; 
$sSQL ;
if($_GET['pcd']) {

    $pcd = $_GET['pcd'];
	$sqlCheck = "SELECT parentgroup, parentcd, activitylevel FROM maindata where itemid= $pcd";	
	$objDb3->dbQuery($sqlCheck);
	$row = $objDb3->dbFetchArray();
	$pGroup = $row['parentgroup'];
	$oneParentcd = $row['parentcd'];
    $activitylevel = $row['activitylevel'];


	if($activitylevel==4){
		$aLevel1 =  substr($pGroup,0,13);
		$aLevel2 =  substr($pGroup,0,20);
		// $sSQL .= "";
	}else if($activitylevel==3){
		$aLevel1 =  substr($pGroup,0,13);
    // $sSQL .= "";
	}else{

    // $sSQL .= "SELECT * FROM maindata where  parentcd = 0 OR itemid = $oneParentcd OR parentgroup LIKE '$pGroup%' and isentry=0  order by parentgroup, parentcd  ";
    $sSQL .=  "SELECT a.*  , b.* FROM maindata a inner join activity b on(a.itemid=b.itemid) where a.parentcd = 0 OR a.itemid = $oneParentcd OR a.parentgroup LIKE '$pGroup%' AND  a.isentry=1 order by a.parentgroup, a.parentcd";
    $sSQL1 .= "SELECT a.*  , b.* FROM maindata a inner join activity b on(a.itemid=b.itemid) where a.parentcd = 0 OR a.itemid = $oneParentcd OR a.parentgroup LIKE '$pGroup%' AND  a.isentry=1 order by a.parentgroup, a.parentcd";
    // echo    $sSQL;

	}

}else{
      // $sSQL .= "";
}


$sSQL;
// Fetch records from database 
  $objDb4->dbQuery($sSQL);
  $objDb5->dbQuery($sSQL1);

if($objDb4->totalRecords() > 0){ 
$maxActivityLevel = 0;
  while($row =  $objDb5->dbFetchArray()){ 
    if ($row['activitylevel'] > $maxActivityLevel )
    $maxActivityLevel = $row['activitylevel'];
  } 

// if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "maindata_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 


      $fields = array('itemid',  );
      foreach ($fields as $value) {
        $header[] = $value;
      }
      for ($x = 1; $x <=($maxActivityLevel-1) ; $x++) {
        $header[] = "Level ";
      }

      $fields = array( 'itemcode', 'itemname' ,'aid','start_date', 'end_date', 'baseline',  ' progress Month', 'Progress Qty'); 

      foreach ($fields as $value) {
        $header[] = $value;
      }




    fputcsv($f, $header, $delimiter); 

   
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row =  $objDb4->dbFetchArray()){ 
  
            // $lineData = array($row['itemid'], $row['parentcd'], $row['parentgroup'], $row['activitylevel'], $row['stage'], $row['factor'], $row['itemcode'], $row['itemname'], $row['weight'], $row['activities'], $row['isentry'], $row['resources'], $row['aorder'], $row['lid']); 

            //  for ($x = 1; $x <=($maxActivityLevel-2) ; $x++) {

                $lineData = array($row['itemid'] ); 
                
                $pGroup = $row['parentgroup'];
                $pGroup = substr($pGroup,6,-7);

                $difActivitylevel = $maxActivityLevel- $row['activitylevel'];
                for ($y = 1; $y <=$difActivitylevel ; $y++) {
                  array_push($lineData, "-");
                }
                while (!empty($pGroup)) {
                  $itemIdForParent = substr($pGroup, -6);
                  $sSQL3 = "SELECT itemname FROM maindata where  itemid =$itemIdForParent ";
                  // $resultItemName;
                  $objDb6->dbQuery($sSQL3);
                  $rowResult =  $objDb6->dbFetchArray(); 
                    $resultItemName = $rowResult['itemname'];
                  array_push($lineData,$resultItemName);
                  $pGroup = substr($pGroup,0,-7);
               
                }



                $fields = array( $row['itemcode'], $row['itemname'], $row['aid'], $row['startdate'], $row['enddate'], $row['baseline'],  ' ', ' '); 
                
                foreach ($fields as $value) {
                  array_push($lineData,$value);
                }

                
            
          // }


        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>