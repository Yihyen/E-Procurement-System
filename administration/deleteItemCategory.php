<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

if (isset($_GET['itemCatID'])) {
    $id = $_GET['itemCatID'];

    $query = "DELETE FROM itemcategory WHERE cat_id='$id'";
    mysqli_query($con, $query);
    echo "<script>alert('Item category successfully deleted!')</script>";
    echo("<script>location.href = '../administration/maintainItemCategory.php';</script>");
}
?>
