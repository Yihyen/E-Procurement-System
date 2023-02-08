<?php

   include('../connection/dbCon.php');

if(isset($_GET["createPO"])){
    //For purchase order
    $po = $_GET["poID"];
    $company_id = 'C0001';
    $storageLocation = $_GET["storageLocation"];
    $ship_to_address = $_GET["shippingAdd"];
    $po_status = 'Pending';
    $supplierAccNo = $_GET["supplierAccNo"];

    //For po_details
    $supplierID = $_GET["supplierID"];
    $documentType = 'Standard PO';
    $po_Date = date('Y-m-d');
    $po_delivery_date = date('Y-m-d', strtotime($_GET["deliveryDate"]));
    $po_remark = $_GET["poRemark"];
    $rowItemDetails = json_decode($_GET["storeItemDetails"], true);

    $sql="INSERT INTO purchaseorder (po_id, pr_id, company_id, storageLocation, ship_to_address, po_status, supplierAccNo)".
        "VALUES('$po',NULL, '$company_id','$storageLocation', '$ship_to_address','$po_status', '$supplierAccNo')";

    $result = $con->query($sql);

    if($result){
        for($i = 0; $i < count($rowItemDetails); $i++){
            $item_id = $rowItemDetails[$i]["itemID"];
            $po_itemQty = $rowItemDetails[$i]["itemQty"];
            $po_itemPrice = $rowItemDetails[$i]["itemPrice"];
            $po_total = $rowItemDetails[$i]["rowTotal"];

            $sql2 ="INSERT INTO po_details (po_id, supplierID, po_documentType, po_Date, po_delivery_date, item_id, po_itemQty, po_itemPrice, po_orderTotal, po_remark) VALUES ('$po', '$supplierID','$documentType', '$po_Date','$po_delivery_date','$item_id','$po_itemQty','$po_itemPrice','$po_total','$po_remark')";
            
            $stmt1 = $con->query($sql2);
        }
    }

    if($stmt1){
        echo json_encode("success");
    }

    exit();
}
?>