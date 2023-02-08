<?php
include '../connection/dbCon.php';

if(isset($_GET['supplierID'])){
    $supplier_id = $_GET['supplierID'];
    $sql = mysqli_query($con,"SELECT * FROM supplier WHERE supplierID = '$supplier_id' ");
    $result = $con->query($sql);
    // $data = mysqli_fetch_all($result,MYSQLI_ASSOC);

    while($data = mysqli_fetch_all($result,MYSQLI_ASSOC)){
        $tempArr[] = array(
            'supplierAddress' => $data['supplierAddress'],
            'supplierContact' => $data['supplierContact'],
            'supplierEmail' => $data['supplierEmail']
        );
    }
    echo json_encode($tempArr);
    exit();
}

?>