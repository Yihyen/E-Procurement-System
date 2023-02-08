<?php
session_start();
require '../connection/dbCon.php';
require_once ('../config/email.php');

if(isset($_POST['delete_potential'])){
    $potential_id = $_POST['selectPotentialID'];
    $query = "DELETE FROM potential_supplier WHERE potential_id='$potential_id' ";
    $query_run = mysqli_query($con, $query);
    
//    $oldFile = $_POST['imgold_file'];
//    $oldFile1 = $_POST['biz_file'];
//    $fileName = $_FILES['img_file']['name'];
//    $upload_path = "../file/". $fileName;
//    $upload_path = $oldFile;
//    $fileName1 = $_FILES['biz']['name'];
//    $upload_path1 = "../biz/". $fileName1;
//    $upload_path1 = $oldFile1;
//    
//    
    $oldFile = $_POST['imgold_file'];
    $fileArray = explode("/", $oldFile);
    $fileName = $fileArray[count($fileArray) - 1];
    $upload_path = "../file/". $fileName;
    $upload_path = $oldFile;
    
    $oldFile1 = $_POST['biz_file'];
    $fileArray1 = explode("/", $oldFile1);
    $fileName1 = $fileArray[count($fileArray1) - 1];
    $upload_path1 = "../biz/". $fileName1;
    $upload_path1 = $oldFile1;
    
    if($query_run)
    {
        unlink($oldFile);
        unlink($oldFile1);
        $_SESSION['message'] = "Potential Supplier Deleted Successfully";
        header("Location: potential.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Potential Supplier Not Deleted";
        header("Location: potential.php");
        exit(0);
    }
}

if(isset($_POST['update_potential']))
{
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
    
    //catalog
    $oldFile = $_POST['imgold_file'];
    $fileName = $_FILES['img_file']['name'];
    $upload_path = "../file/". $fileName;
    $tem_loc = $_FILES['img_file']['tmp_name'];
    //bizProfile
    $fileName1 = $_FILES['biz_file']['name'];
    $upload_path1 = "../biz/". $fileName1;
    $tem_loc1 = $_FILES['biz_file']['tmp_name'];
    $oldFile1 = $_POST['imgold1_file'];
    
    if($fileName != '' || $fileName1 != ''){ 
        $upload_path = "../file/".$_FILES['img_file']['name'];
        $upload_path1 = "../biz/".$_FILES['biz_file']['name'];
    }else{
        $upload_path = $oldFile;
        $upload_path1 = $oldFile1;
    }
    
    if(file_exists("../file/".$_FILES['img_file']['name'])){
        $filename = $_FILES['img_file']['name'];
        $_SESSION['message1'] = "Already exists this ". $filename;
        header("Location: potential.php");
        exit(0);
    } else if(file_exists("../biz/".$_FILES['biz_file']['name'])){
        $filename1 = $_FILES['biz_file']['name'];
        $_SESSION['message1'] = "Already exists this ". $filename1;
        header("Location: potential.php");
        exit(0);
    } 
    else{
        $query = "UPDATE potential_supplier SET companyName='$companyName', registrationNum='$regNum', supplierAddress='$address', country='$country', supplierContact='$contact', supplierEmail='$email', faxNum='$faxNum', typeOfBusiness='$type', catalog='$upload_path', status='$status', bizProfile='$upload_path1' WHERE potential_id='$potential_id' ";
        $query_run = mysqli_query($con, $query);

        if($query_run){
            if($_FILES['img_file']['name'] != '' || $_FILES['biz_file']['name'] != ''){
                move_uploaded_file($tem_loc,$upload_path);
                move_uploaded_file($tem_loc1,$upload_path1);
                unlink($oldFile);
                unlink($oldFile1);
            }
            $_SESSION['message'] = "Potential Supplier Successfully Updated";
            header("Location: potential.php");
            exit(0);
        }else{
            $_SESSION['message1'] = "Potential Supplier Not Updated";
            header("Location: updatePotential.php");
            exit(0);
        } 
    }
}

?>


