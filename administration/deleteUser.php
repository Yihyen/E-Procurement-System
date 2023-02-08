<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

if (isset($_GET['userID'])) {
    $id = $_GET['userID'];

    $query = "DELETE FROM user WHERE user_id='$id'";
    mysqli_query($con, $query);
    echo "<script>alert('User successfully deleted!')</script>";
    echo("<script>location.href = '../administration/maintainUser.php';</script>");
}
?>
