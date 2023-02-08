<?php 
    include ('../connection/dbCon.php');

    if(isset($_POST['find_rfq'])){
        $RFQNo = $_POST['rfqID'];
        $sql = $con->query("SELECT r.*, inv.*, s.* FROM rfq r, inventory inv, supplier s WHERE r.RFQNo = '$RFQNo' AND r.productName = inv.item_name AND r.supplierID = s.supplierID;");

        while($data = mysqli_fetch_assoc($sql)){
            $tempArr[] = array(
                'supplierID' => $data['supplierID'],
                'productName' => $data['productName'],
                'productQty' => $data['productQty'],
                'amount' => $data['amount'],
                'totalPrice' => $data['totalPrice'],
                'supplierName' => $data['companyName'],
                'supplierAddress' => $data['supplierAddress'],
                'supplierContact' => $data['supplierContact'],
                'supplierEmail' => $data['supplierEmail'],
                'item_unit_price' => $data['item_unit_price'],
                'item_description' => $data['item_description'],
                'item_id' => $data['item_id'],
            );
        }
        echo json_encode($tempArr);
    }

?>