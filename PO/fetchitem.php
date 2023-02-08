<?php
ini_set('display_errors',1);

include ('../connection/dbCon.php');

if(isset($_GET['find_desc'])) {
    $item_id = $_GET['item_id'];
    $sql = $con -> query("SELECT item_description FROM inventory WHERE item_id = '$item_id'");
    if($sql) {
        $row = $sql->fetch_assoc();
        echo json_encode($row['item_description']);
    }
}

?>