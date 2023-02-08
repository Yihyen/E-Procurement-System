<?php
session_start();
require '../connection/dbCon.php';

if (isset($_GET['removeBudget'])) {
    $id = $_GET['removeBudget'];

    $query = "DELETE FROM purchasebudget WHERE budget_id='$id'";
    mysqli_query($con, $query);
    echo "<script>alert('Purchase budget successfully deleted!')</script>";
    echo("<script>location.href = '../administration/maintainPurchaseBudget.php';</script>");
}
?>
