<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

if (isset($_GET['supplierID'])) {
    $id = $_GET['supplierID'];

    $query = "DELETE FROM supplier WHERE supplierID='$id'";
    mysqli_query($con, $query);
    echo "<script>alert('Supplier successfully deleted!')</script>";
    echo("<script>location.href = '../administration/maintainSupplier.php';</script>");
}
?>
