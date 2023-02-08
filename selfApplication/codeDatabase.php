<?php
session_start();
require '../connection/dbCon.php';
require_once ('../config/email.php');

if(isset($_POST['registerSupplier'])){
    $potential_id = $_POST['potential_id'];
    $companyName = mysqli_real_escape_string($con, $_POST['companyName']);
    $regNum = mysqli_real_escape_string($con, $_POST['regNum']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $faxNum = mysqli_real_escape_string($con, $_POST['fax']);
    $type = mysqli_real_escape_string($con, $_POST['typeOfBusiness']);
    $status = $_POST['status'];
    
    $fileName = $_FILES['img_file']['name'];
    $upload_path = '../registerC/'. $fileName;
    
    $fileName1 = $_FILES['biz_file']['name'];
    $upload_path1 = '../registerB/'. $fileName1;
   
    $check_regNum = "SELECT * FROM supplier WHERE registrationNum = '$regNum'";
    $query_run1 = mysqli_query($con, $check_regNum);
    
    if(mysqli_num_rows($query_run1) > 0){
        $_SESSION['message1'] = "Already exists this registration number:". $regNum;
        header("Location: error.php");
        exit(0);
    }else{
        $query = "INSERT INTO potential_supplier (potential_id,companyName,registrationNum,supplierAddress,country,supplierContact,supplierEmail,faxNum,typeOfBusiness,catalog,status,bizProfile) VALUES ('$potential_id','$companyName','$regNum','$address','$country','$contact','$email','$faxNum','$type','$upload_path','$status','$upload_path1')";
        $query_run = mysqli_query($con, $query); 
        
        if($query_run){
            move_uploaded_file($_FILES['img_file']['tmp_name'], $upload_path);
            move_uploaded_file($_FILES['biz_file']['tmp_name'], $upload_path1);
            $_SESSION['message'] = "Supplier Successfully Register";
            header("Location: thankyou.php");
            exit(0);
        }else{
            $_SESSION['message1'] = "Supplier Not Register";
            header("Location: error.php");
            exit(0);
        }
        exit(0);
    }
}

if (isset($_POST['approve'])){
    $appid = $_POST['appid'];
    $supplier_id = generateSupplierID($con);
    $sql = "UPDATE potential_supplier SET status='Approved' WHERE potential_id = '$appid'";
    $run = mysqli_query($con,$sql);
    
    $query = "INSERT INTO supplier (supplierID,companyName,registrationNum,supplierAddress,country, supplierContact,supplierEmail,faxNum,typeOfBusiness, catalog,bizProfile,supplier_status) 
    SELECT '$supplier_id', companyName,registrationNum, supplierAddress,country, supplierContact,supplierEmail,faxNum,typeOfBusiness, catalog,bizProfile,'Available'
    from potential_supplier where potential_id = '$appid';";
    $query_run = mysqli_query($con, $query); 
    
    if($run == true){
        $_SESSION['message'] = "Application Approved";
        
        $sql = "SELECT * FROM potential_supplier WHERE potential_id='$appid'";
        $run = mysqli_query($con,$sql);
        
        while ($result = mysqli_fetch_assoc($run)){
            $resultset[] = $result;
        }
        $cmpName = $resultset[0]['companyName'];
        $cmpEmail = $resultset[0]['supplierEmail'];
        $status = $resultset[0]['status'];
        
        $email = new EmailConfig();
        
        $successful = $email->singleEmail($cmpEmail,'Application Status in Register Supplier' , createContent($cmpName,$status));
        
        if($successful){
           header("Location: status.php?success");
        } else {
            header("Location: status.php?failed");
        }
            exit(0); 
    }else{
        $_SESSION['message1'] = "Failed To Approved";
        header("Location: status.php");
        exit(0);
    }
}

function generateSupplierID($con){
    //generate supplier ID
    $query = "SELECT * FROM supplier ORDER BY supplierID DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $lastid = $row['supplierID'];

    if (empty($lastid)) {
        $sid = "SP0001";
    } else {
        $get_id = str_replace("SP", "", $lastid);
        $get_string = str_pad($get_id + 1, 4, 0, STR_PAD_LEFT);
        $sid = 'SP' . $get_string;
    }
    return $sid;
}

if (isset($_POST['rejectBtn'])){
    $appid = $_POST['appid'];
    $reason = $_POST['reason'];
    $sql = "UPDATE potential_supplier SET status='Rejected',reason='$reason' WHERE potential_id = '$appid'";
    $run = mysqli_query($con,$sql);
    if($run == true){
        $_SESSION['message'] = "Application Rejected";
        
        $sql = "SELECT * FROM potential_supplier WHERE potential_id='$appid'";
        $run = mysqli_query($con,$sql);
        
        while ($result = mysqli_fetch_assoc($run)){
            $resultset[] = $result;
        }
        $cmpName = $resultset[0]['companyName'];
        $cmpEmail = $resultset[0]['supplierEmail'];
        $status = $resultset[0]['status'];
        
        $email = new EmailConfig();
        
        $successful = $email->singleEmail($cmpEmail,'Application Status in Register Supplier' , createContent($cmpName, $status));
        
        if($successful){
           header("Location: status.php?success");
        } else {
            header("Location: status.php?failed");
        }
            exit(0); 
    }else{
        $_SESSION['message1'] = "Failed To Reject";
        header("Location: status.php");
        exit(0);
    }
}

function createContent($companyName,$status){
    $id = $_POST['appid'];
//    $status = $_POST['status'];
    $html = "
    <html>
        <head>
            <title>Application Status in Register Supplier</title>
        </head>
        <body>
            <p>Dear Sir/Madam,</p>
            <p>We are from <b>xxx company</b>,Your application is <span style='color:red; font-weight: bold;'>$status</span> 
            <p>This is the <a href='http://localhost/ProcurementSystem/selfApplication/statusSupplier.php?potential_id=$id'>Link</a> to see the application.</p>
            <p>Thank You to join our company.</p>
            <br>
            <p>Best Regards,<p>
            <p>Joanne | admin</p>
            <p>xxx company</p>
        </body>
    </html>
    ";

    return $html;
}

if(isset($_POST['save_potential'])){
    $potential_id = $_POST['potential_id'];
    $companyName = mysqli_real_escape_string($con, $_POST['companyName']);
    $regNum = mysqli_real_escape_string($con, $_POST['regNum']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $faxNum = mysqli_real_escape_string($con, $_POST['fax']);
    $type = mysqli_real_escape_string($con, $_POST['typeOfBusiness']);
    $status = $_POST['status'];
    
    $fileName = $_FILES['img_file']['name'];
    $upload_path = '../file/'. $fileName;
    
    $fileName1 = $_FILES['biz_file']['name'];
    $upload_path1 = '../biz/'. $fileName1;
    
    $query = "INSERT INTO potential_supplier (potential_id,companyName,registrationNum,supplierAddress,country,supplierContact,supplierEmail,faxNum,typeOfBusiness,catalog,status,bizProfile) VALUES ('$potential_id','$companyName','$regNum','$address','$country','$contact','$email','$faxNum','$type','$upload_path','$status','$upload_path1')";
    $query_run = mysqli_query($con, $query); 
    
    if($query_run){
        move_uploaded_file($_FILES['img_file']['tmp_name'], $upload_path);
        move_uploaded_file($_FILES['biz_file']['tmp_name'], $upload_path1);
        $_SESSION['message'] = "Potential Supplier Successfully Created";
        header("Location: addPotentialS.php");
        exit(0);
    }else{
        $_SESSION['message1'] = "Potential Supplier Not Created";
        header("Location: addPotentialS.php");
        exit(0);
    }
}
?>
