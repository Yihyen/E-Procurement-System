<?php
    require '../connection/dbCon.php';

    if(isset($_GET['catalog_id'])){
        $catalog_id = mysqli_real_escape_string($con, $_GET['catalog_id']);
        $query = "SELECT * FROM catalog WHERE catalog_id='$catalog_id' ";
        $query_run = mysqli_query($con, $query);
        
        if(mysqli_num_rows($query_run) > 0){
            $catalog = mysqli_fetch_array($query_run);        
            header("content-type:application/pdf");
            header('Content-Description: inline; filename="'.$catalog['catalogFile'].'"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            readfile($catalog['catalogFile']);
        }
    }
?>
