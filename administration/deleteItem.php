<?php
session_start();
require '../connection/dbCon.php';

if (isset($_GET['itemID'])) {
    $id = $_GET['itemID'];

    $query = "DELETE FROM inventory WHERE item_id='$id'";
    mysqli_query($con, $query);
    echo "<script>alert('Item successfully deleted!')</script>";
    echo("<script>location.href = '../administration/maintainInventory.php';</script>");
}
?>
