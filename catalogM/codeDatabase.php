<?php
session_start();
require '../connection/dbCon.php';

if(isset($_POST['delete_catalog'])){
    $catalog_id = $_POST['selectCatalogID'];
    $query = "DELETE FROM catalog WHERE catalog_id='$catalog_id' ";
    $query_run = mysqli_query($con, $query);
    $oldFile = $_POST['imgold_file'];
    $fileArray = explode("/", $oldFile);
    $fileName = $fileArray[count($fileArray) - 1];
    $upload_path = "../uploads/". $fileName;
    $upload_path = $oldFile;
    
    if($query_run){
        unlink($oldFile);
        $_SESSION['message'] = "Catalog Deleted Successfully";
        header("Location: catalog.php");
        exit(0);
    }
    else{
        $_SESSION['message'] = "Catalog Not Deleted";
        header("Location: catalog.php");
        exit(0);
    }
}

if(isset($_POST['update_catalog'])){
    $catalog_id = $_POST['catalog_id'];
    $supplierID = mysqli_real_escape_string($con, $_POST['supplierID']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $oldFile = $_POST['imgold_file'];
    $fileName = $_FILES['img_file']['name'];
    $upload_path = "../uploads/". $fileName;
    $tem_loc = $_FILES['img_file']['tmp_name'];
    
    if($fileName != ''){ 
        $upload_path = "../uploads/".$_FILES['img_file']['name'];
    }else{
        $upload_path = $oldFile;
    }
    
    if(file_exists("../uploads/".$_FILES['img_file']['name'])){
        $filename = $_FILES['img_file']['name'];
        $_SESSION['message1'] = "Already exists this ". $filename;
        header("Location: catalog.php");
        exit(0);
    } 
    else{
        $query = "UPDATE catalog SET supplierID='$supplierID', catalogFile='$upload_path', catalogDate='$date' WHERE catalog_id='$catalog_id' ";
        $query_run = mysqli_query($con, $query);

        if($query_run){
            if($_FILES['img_file']['name'] != ''){
                move_uploaded_file($tem_loc,$upload_path);
                unlink($oldFile);
            }
            $_SESSION['message'] = "Catalog Successfully Updated";
            header("Location: catalog.php");
            exit(0);
        }else{
            $_SESSION['message1'] = "Catalog Not Updated";
            header("Location: updateCatalog.php");
            exit(0);
        } 
    }
}

if(isset($_POST['save_catalog'])){
    $catalog_id = $_POST['catalog_id'];
    $supplierID = mysqli_real_escape_string($con, $_POST['supplierID']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $fileName = $_FILES['img_file']['name'];
    $upload_path = '../uploads/'. $fileName;
    $query = "INSERT INTO catalog (catalog_id,supplierID,catalogFile,catalogDate) VALUES ('$catalog_id','$supplierID','$upload_path','$date')";
    $query_run = mysqli_query($con, $query); 
    
    if($query_run){
        move_uploaded_file($_FILES['img_file']['tmp_name'], $upload_path);
        $_SESSION['message'] = "Catalog Successfully Created";
        header("Location: addCatalog.php");
        exit(0);
    }
    else{
        $_SESSION['message1'] = "Catalog Not Created";
        header("Location: addCatalog.php");
        exit(0);
    }
}
?>
