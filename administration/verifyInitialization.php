<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';

$sql = "SELECT count(company_id) AS total FROM company";
$result = mysqli_query($con, $sql);
$value = mysqli_fetch_assoc($result);
$num_rows = $value['total'];

if ($num_rows >= 1) {
    header("Location: ../administration/homePage.php");
} else {
    header("Location: ../administration/companySettings.php");
}
?>