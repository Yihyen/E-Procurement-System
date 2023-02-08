<?php 
    include ('../connection/dbCon.php');

    if(isset($_POST['find_sup'])){
        $supplier_id = $_POST['supplierID'];
        $sql = $con->query("SELECT * FROM supplier WHERE supplierID = '$supplier_id'");

        while($data = mysqli_fetch_assoc($sql)){
            $tempArr[] = array(
                'supplierAddress' => $data['supplierAddress'],
                'supplierContact' => $data['supplierContact'],
                'supplierEmail' => $data['supplierEmail']
            );
        }
        echo json_encode($tempArr);
    }

?>