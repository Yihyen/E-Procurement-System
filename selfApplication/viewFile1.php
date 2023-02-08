<?php
    require '../connection/dbCon.php';

    if(isset($_GET['potential_id'])){
        $id = mysqli_real_escape_string($con, $_GET['potential_id']);
        $query = "SELECT * FROM potential_supplier WHERE potential_id='$id' ";
        $query_run = mysqli_query($con, $query);
        
        if(mysqli_num_rows($query_run) > 0){
            $potential = mysqli_fetch_array($query_run);        
            header("content-type:application/pdf");
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            header('Content-Description: inline; filename="'.$potential['bizProfile'].'"');
            readfile($potential['bizProfile']);
        }
    }
?>
