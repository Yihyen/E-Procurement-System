<?php
include '../connection/dbCon.php';

if(isset($_GET['poID'])){
    $poID = $_GET['poID'];
    $shippingAdd = $_GET['shippingAdd'];
    $storageLocation = $_GET['storageLocation'];
    $status = $_GET['status'];
    
    $deliveryDate = $_GET['deliveryDate'];
    $poRemark = $_GET['poRemark'];
    $storeItemDetails = json_decode($_GET['storeItemDetails'], true);

    $sql = "UPDATE purchaseorder SET ship_to_address = '$shippingAdd', storageLocation = '$storageLocation', po_status = '$status' WHERE po_id = '$poID'";
    $result = $con->query($sql);

    if($result){
        foreach($storeItemDetails as $item){
            $itemID = $item['itemID'];
            $itemQty = $item['itemQty'];
            $itemPrice = $item['itemPrice'];
            $rowTotal = $item['rowTotal'];

            $sql = "UPDATE po_details SET po_itemQty = '$itemQty', po_itemPrice = '$itemPrice', po_orderTotal = '$rowTotal', po_remark = '$poRemark', po_delivery_date = '$deliveryDate' WHERE po_id = '$poID' AND item_id = '$itemID'";

            $result = $con->query($sql);
        }
        
        if($result){
            echo json_encode("success");
        }else{
            echo json_encode("failed");
        }
        exit();
    }
}

    
?>