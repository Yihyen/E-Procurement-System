<?php
include 'connection.php';
include 'MR.php';

if(isset($_POST["itemid"]))
{
    $mrid = $mr_ID;
    $userid =$_POST['inputUserid1'];
    $mrStatus = "Pending";
    $currentDate = date("Y-m-d");
    $dateRequest = $currentDate;
    $deliveryDate = $_POST['inputDeliveryDate'];
    $address = $_POST['inputAddress'];
    $grandTotal = $_POST['grandTotal'];
    $purpose = $_POST['inputPurpose'];
    $remark = $_POST['inputRemark'];
            
    $itemid = $_POST["itemid2"];
    $lintTotal = $_POST['lineTotal'];
    $quantity = $_POST["quantity"];
    $reason = "N/A";

    $arr = $_POST['itemid2'];
    $arr1 = $_POST['lineTotal'];
    $string = explode(",", $arr);
    $string1 = explode(",", $arr1);
    $cnt = count($string);
//    $numberOfRows = sizeof($_POST['itemid']); // get the number of rows
    for ($i = 0; $i < $cnt; $i++) {
//    for($i = 0; $i<count($_POST['itemid']); $i++){

        $sql = "INSERT INTO mr_details (mr_id,item_id, qty_request, line_total) VALUES ('$mrid' ,  '" . $string[$i] . "'  , '" . $quantity[$i] . "', '" . $string1[$i] . "')";
        $query = mysqli_query($con, $sql);
    }

    if ($query) {

        $sql1 = "INSERT INTO material_requisition(mr_id,user_id,mr_status,mr_reason,date_request,date_deliver_by,deliver_address,mr_total_amount,mr_purpose,mr_remark)
            VALUES ('$mrid','$userid','$mrStatus','$reason','$dateRequest','$deliveryDate','$address','$grandTotal','$purpose','$remark')";
        $result = mysqli_query($con, $sql1);
    }
}
?>