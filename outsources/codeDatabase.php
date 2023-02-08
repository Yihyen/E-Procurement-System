<?php
session_start();
require '../connection/dbCon.php';
require_once ('../config/email.php');

if(isset($_POST['delete_outsourcer'])){
    $outsourcer_id = $_POST['selectOutsourceID'];
    $query = "DELETE FROM outsourcer WHERE outsourcer_id='$outsourcer_id' ";
    $query_run = mysqli_query($con, $query);
    if($query_run){
        $_SESSION['message'] = "Outsourcing Supplier Deleted Successfully";
        header("Location: outsourcer.php");
        exit(0);
    }
    else{
        $_SESSION['message'] = "Outsourcing Supplier Not Deleted";
        header("Location: outsourcer.php");
        exit(0);
    }
}

if(isset($_POST['update_oursourcer'])){
    $outsourcer_id = $_POST['outsourcer_id'];
    $outsourcerName = mysqli_real_escape_string($con, $_POST['outsourcerName']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $type = mysqli_real_escape_string($con, $_POST['serviceType']);
    $status = $_POST['status'];
    
    $query = "UPDATE outsourcer SET outsourcerName='$outsourcerName', contactNumber='$contact', address='$address', email='$email', serviceType='$type', status='$status' WHERE outsourcer_id='$outsourcer_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run){
        $_SESSION['message'] = "Outsourcing Supplier Successfully Updated";
        header("Location: outsourcer.php");
        exit(0);
    }else{
        $_SESSION['message1'] = "Outsourcing Supplier Not Updated";
        header("Location: updateOutsourcer.php");
        exit(0);
    } 
}

if (isset($_POST['approve'])){
    $appid = $_POST['appid'];
    $outsourcer_id = generateOutsourceID($con);
    $sql = "UPDATE outsourcerlist SET status='Accept' WHERE id = '$appid'";
    $run = mysqli_query($con,$sql);

    $query = "INSERT INTO outsourcer (outsourcer_id,outsourcerName,contactNumber, address, email,serviceType,status) 
    SELECT '$outsourcer_id', outsourcerName,contactNumber, address, email,serviceType, 'Accept'
    from outsourcerlist where id = '$appid';";
    $query_run = mysqli_query($con, $query); 

    if($run == true){
        header("Location: messagesAccept.php");
        exit(0);
    }else{
        $_SESSION['message1'] = "Failed To Accept";
        header("Location: outsourcesApprove.php");
        exit(0);
    }
}

function generateOutsourceID($con){
    //generate outsourcer ID
    $query = "SELECT * FROM outsourcer ORDER BY outsourcer_id DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $lastid = $row['outsourcer_id'];

    if (empty($lastid)) {
        $sid = "OS0001";
    } else {
        $get_id = str_replace("OS", "", $lastid);
        $get_string = str_pad($get_id + 1, 4, 0, STR_PAD_LEFT);
        $sid = 'OS' . $get_string;
    }
    return $sid;
}

if (isset($_POST['rejectBtn'])){
    $appid = $_POST['appid'];
    $reason = $_POST['reason'];
    $sql = "UPDATE outsourcerlist SET status='Rejected', reason='$reason' WHERE id = '$appid'";
    $run = mysqli_query($con,$sql);
    if($run == true){
        header("Location: messagesReject.php");
        exit(0);
    }else{
        $_SESSION['message1'] = "Failed To Reject";
        header("Location: outsourcesApprove.php");
        exit(0);
    }
}

if(isset($_POST['invite'])){
    $id = $_POST['appid'];
    $sql = "UPDATE outsourcerlist SET status='Invited' WHERE id = '$id'";
    $run = mysqli_query($con,$sql);
    if($run == true){
        $_SESSION['message'] = "Application already invite";
        $sql = "SELECT * FROM outsourcerlist WHERE id='$id'";
        $run = mysqli_query($con,$sql);
        
        while ($result = mysqli_fetch_assoc($run)){
            $resultset[] = $result;
        }
        $cmpName = $resultset[0]['outsourcerName'];
        $cmpEmail = $resultset[0]['email'];
        $email = new EmailConfig();
        $successful = $email->singleEmail($cmpEmail,'Invite your company to be our outsourcer' , createContent($cmpName));
        
        if($successful){
           header("Location: outsourcesList.php?success");
        } else {
            header("Location: outsourcesList.php?failed");
        }
            exit(0); 
    }else{
        $_SESSION['message1'] = "Failed To invite";
        header("Location: outsourcesList.php");
        exit(0);
    } 
}

function createContent($cmpName){
    $id = $_POST['appid'];
    $html = "
    <html>
        <head>
            <title>Invite $cmpName to be our outsourcer</title>
        </head>
        <body>
            <p>Dear Sir/Madam,</p>
            <p>We are from <b>xxx company</b>, our company is engaged in <b>Electrical Appliance</b> business. Honesty would like to invite you to be our outsourcer.</p>
            <p>We know from your company <span style='color:blue; font-weight: bold;'>$cmpName</span> that you provide relevant services and are very suitable to be our outsourcer.</p>
            <p>If you are interested to become our outsourcer, please contact <b>0176662832</b> or email to <b><a href='mailto:joanneleeenen@gmail.com'>joanneleeenen@gmail.com</a></b> for more information.</p>
            <p>This is the <a href='http://localhost/ProcurementSystem/outsources/outsourcesApprove.php?id=$id'><span style='color:red; font-weight: bold;'>Link</span></a> to accept or reject the request.</p>
            <p>We look forward to hearing from you. thanks.</p>
            <br>
            <p>Best Regards,<p>
            <p>Joanne | admin</p>
            <p>xxx company</p>
        </body>
    </html>
    ";
    return $html;
}

if(isset($_POST['save'])){
    $id = $_POST['outsourcer_id'];
    $companyName = mysqli_real_escape_string($con, $_POST['outsourcerName']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $type = mysqli_real_escape_string($con, $_POST['serviceType']);
    $status = $_POST['status'];
    
    $query = "INSERT INTO outsourcerlist (id,outsourcerName,contactNumber,address,email,serviceType,status) VALUES ('$id','$companyName','$contact','$address','$email','$type','$status')";
    $query_run = mysqli_query($con, $query); 
    
    if($query_run){
        $_SESSION['message'] = "Outsourcer List Successfully Created";
        header("Location: addOutsourcesList.php");
        exit(0);
    }else{
        $_SESSION['message1'] = "Outsourcer List Not Created";
        header("Location: addOutsourcesList.php");
        exit(0);
    }
}

if(isset($_POST['update'])){
    $outsourcer_id = $_POST['id'];
    $outsourcerName = mysqli_real_escape_string($con, $_POST['outsourcerName']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $type = mysqli_real_escape_string($con, $_POST['serviceType']);
    $status = $_POST['status'];
    
    $query = "UPDATE outsourcerlist SET outsourcerName='$outsourcerName', contactNumber='$contact', address='$address', email='$email', serviceType='$type', status='$status' WHERE id='$outsourcer_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run){
        $_SESSION['message'] = "Outsourcing List Successfully Updated";
        header("Location: outsourcesList.php");
        exit(0);
    }else{
        $_SESSION['message1'] = "Outsourcing List Not Updated";
        header("Location: updateOutsourcesList.php");
        exit(0);
    } 
}

if(isset($_POST['delete'])){
    $outsourcer_id = $_POST['selectListID'];
    $query = "DELETE FROM outsourcerlist WHERE id='$outsourcer_id' ";
    $query_run = mysqli_query($con, $query);
  
    if($query_run){
        $_SESSION['message'] = "Outsourcing List Deleted Successfully";
        header("Location: outsourcesList.php");
        exit(0);
    }else{
        $_SESSION['message'] = "Outsourcing List Not Deleted";
        header("Location: outsourcesList.php");
        exit(0);
    }
}
?>
