<?php 
// Include the database config file 
include_once "../../../config/config.php";
$objDb6  		= new Database();
 
if(!empty($_POST["level1"])){ 
    // Fetch state data based on the specific level 
    $query = "SELECT * FROM maindata WHERE parentcd = ".$_POST['level1']." AND activitylevel = 2 "; 
    $result = $objDb6->dbQuery($query);
    // Generate  list 
    if( $objDb6->totalRecords()>0){ 
        echo '<option value="">Select </option>'; 
        while($row = $objDb6->dbFetchArray()){  
            echo '<option value="'.$row['itemid'].'">'.$row['itemname'].'</option>'; 
        } 
    }else{ 
        echo '<option value=""> not available</option>'; 
    } 
}elseif(!empty($_POST["level2"])){ 
    // Fetch city data based on the specific level 
    $query = "SELECT * FROM maindata WHERE parentcd = ".$_POST['level2']." AND activitylevel = 3 "; 
    $result = $objDb6->dbQuery($query);
     
    // Generate list
    if( $objDb6->totalRecords()>0){ 
        echo '<option value="">Select </option>'; 
        while($row = $objDb6->dbFetchArray()){  
            echo '<option value="'.$row['itemid'].'">'.$row['itemname'].'</option>'; 
        } 
    }else{ 
        echo '<option value=""> not available</option>'; 
    } 
}elseif(!empty($_POST["level3"])){ 
    // Fetch city data based on the specific level 
    $query = "SELECT * FROM maindata WHERE parentcd = ".$_POST['level3']." AND activitylevel = 4 "; 
    $result = $objDb6->dbQuery($query);
     
    // Generate list
    if( $objDb6->totalRecords()>0){ 
        echo '<option value="">Select </option>'; 
        while($row = $objDb6->dbFetchArray()){  
            echo '<option value="'.$row['itemid'].'">'.$row['itemname'].'</option>'; 
        } 
    }else{ 
        echo '<option value=""> not available</option>'; 
    } 
}elseif(!empty($_POST["level4"])){ 
    // Fetch city data based on the specific level 
    $query = "SELECT * FROM maindata WHERE parentcd = ".$_POST['level4']." AND activitylevel = 5 "; 
    $result = $objDb6->dbQuery($query);
     
    // Generate list
    if( $objDb6->totalRecords()>0){ 
        echo '<option value="">Select </option>'; 
        while($row = $objDb6->dbFetchArray()){  
            echo '<option value="'.$row['itemid'].'">'.$row['itemname'].'</option>'; 
        } 
    }else{ 
        echo '<option value=""> not available</option>'; 
    } 
}  
?>