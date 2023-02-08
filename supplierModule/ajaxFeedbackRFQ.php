<?php
    if(isset($_GET['RFQNo']) && isset($_GET['productJson'])){
        $RFQNo = $_GET['RFQNo'];
        $productJson = json_decode($_GET['productJson'], true);
        $conn = mysqli_connect ("localhost" , "root" , "" , "procurementsystem");
        $updateReject = true;

        for ($i=0; $i < count($productJson); $i++) {
            $productName = $productJson[$i]['productName'];
            $productStatus = $productJson[$i]['status'];
            $rejectReason = $productJson[$i]['rejectReason'];

            //Check if there is a product that is not rejected
            if($productStatus == "Approved"){
                $updateReject = false;
            }

            $sql = "UPDATE rfq SET Status = '$productStatus', rejectReason = '$rejectReason' WHERE RFQNo = '$RFQNo' AND productName = '$productName'";
            $result = mysqli_query($conn, $sql);

            if(!$result){
                echo json_encode('error');
                exit();
            }
        }

        //If all products are rejected, update the status of the RFQ to rejected
        if($updateReject){
            $sql = "UPDATE rfq SET supplierFeedback = 'Rejected', quotationStatus = 'Rejected' WHERE RFQNo = '$RFQNo'";
            $result = mysqli_query($conn, $sql);          
        }else{
            $sql = "UPDATE rfq SET supplierFeedback = 'Responded' WHERE RFQNo = '$RFQNo'";
            $result = mysqli_query($conn, $sql);
        }

        if($result){
            echo json_encode('success');  
        }else{
            echo json_encode('error');
        }

        exit();
    }
?>