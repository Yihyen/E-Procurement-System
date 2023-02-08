<!DOCTYPE html>
<?php
require '../connection/dbCon.php';

$res = $con->query("SELECT * FROM user where user_name='" . $_SESSION["username"] . "'")->fetch_array();

if ($res["user_role"] == 'Administrator') {
    include '../navBar/adminNavBar.php';
} else if ($res["user_role"] == 'Purchasing Staff') {
    include '../navBar/purchasingStaffNavBar.php';
} else if ($res["user_role"] == 'Purchasing Manager') {
    include '../navBar/purchasingManagerNavBar.php';
} else if ($res["user_role"] == 'Branches') {
    include '../navBar/branchesNavBar.php';
} else if ($res["user_role"] == 'Outsourcer'){
    include '../navBar/outsourcerNavBar.php';
} else if ($res["user_role"] == 'Supplier'){
    include '../navBar/supplierNavBar.php';
}
?>
