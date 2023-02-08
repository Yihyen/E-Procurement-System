<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

$res = $con->query('SELECT * FROM itemcategory');

//generate item ID
$query = "SELECT * FROM inventory ORDER BY item_id DESC LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
$lastid = $row['item_id'] ?? '';
if ($lastid == null or $lastid == '') {
    $itemId = "IV0001";
} else {
    $get_numbers = str_replace("IV", "", $lastid);
    $id_increase = $get_numbers + 1;
    $get_string = str_pad($id_increase, 4, 0, STR_PAD_LEFT);
    $itemId = "IV" . $get_string;
}

//insert user
if (isset($_POST["submit"])) {
    $item_id = $itemId;
    $catName = $_POST["catName"];
    $itemName = $_POST["itemName"];
    $itemDesc = $_POST["itemDesc"];
    $itemQty = $_POST["itemQty"];
    $itemUnitPrice = $_POST["itemUnitPrice"];
    $status = "Available";

    $query = $con->prepare('INSERT INTO inventory (item_id, cat_id, item_name, item_description, item_quantity, item_unit_price, item_status) VALUES (?,?,?,?,?,?,?)');
    $query->bind_param('sssssss', $item_id, $catName, $itemName, $itemDesc, $itemQty, $itemUnitPrice, $status);

    $query->execute();

    if ($query) {
        echo "<script>alert('Successfully added!')</script>";
        echo("<script>location.href = '../administration/addItem.php';</script>");
    }else{
        echo "<script>alert('Item failed to be added. Please try again.')</script>";
    }
}

if (isset($_POST['cancel'])) {
    header("Location: ../administration/maintainItem.php");
}

?>

<html>
    <head>
        <title>Add Item Category</title>

        <style>
            h2 {
                text-align: center;
                padding: 0.4em;
                margin-bottom: 0em;
            }

            label{
                width: 300px;
                display: inline-block;
                margin: 6px;
            }

            form{
                max-width: 700px;
                padding: 10px 20px;
                background: #f4f7f8;
                margin: 10px auto;
                padding: 20px;
                background: #f4f7f8;
                border-radius: 8px;
                font-family: Arial;
            }

            input {
                color: white;
                padding: 8px;
                font-family: Arial;
                background-color: #e7e7e7;
                color: black;
                display: block;
                border: 2px solid #ccc;
                width: 100%;
                margin: 10px auto;
                border-radius: 5px;
            }

            textarea {
                color: white;
                padding: 8px;
                font-family: Arial;
                background-color: #e7e7e7;
                color: black;
                display: block;
                border: 2px solid #ccc;
                width: 100%;
                margin: 10px auto;
                border-radius: 5px;
            }

            select {
                color: white;
                padding: 8px;
                font-family: Arial;
                background-color: #e7e7e7;
                color: black;
                display: block;
                border: 2px solid #ccc;
                width: 100%;
                margin: 10px auto;
                border-radius: 5px;
            }

            .submit{
                background-color: powderblue;
                font-family: 'Poppins', sans-serif;
            }
        </style>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <!--Bootstrap CSS library--> 
        <link rel="stylesheet" href=
              "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity=
              "sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              crossorigin="anonymous">

        <!--jQuery library--> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
                integrity=
                "sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>

        <!--JS library--> 
        <script src=
                "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity=
                "sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    </head>

    <body>
        <br>
        <br>
        <div class="addItem">
            <h2 style="font-size: 60px">Item Property Form</h2> <br>

            <form action = "" method="post" id="addItem" class="center" >

                <!--item id-->
                <label for="itemCatid">Item ID: </label>
                <input type="text" name="itemCatid" id = "itemCatid" value="<?php echo $itemId; ?>" disabled> <br>

                <!--category id-->
                <label for="catName">Category: </label>
                <select id="catName" name="catName" class="form-control" required value=""> <br>
                    <?php
                    while ($rows = $res->fetch_assoc()) {
                        $cat_id = $rows['cat_id'];
                        $cat_name = $rows['cat_name'];

                        echo "<option value = '$cat_id'>$cat_name</option>";
                    }
                    ?>
                </select> <br>

                <!--item name-->
                <label for="itemName">Item Name: </label>
                <input type="text" name="itemName" id = "itemName" required value=""> <br>

                <label for="itemDesc">Item Description: </label>
                <input type="text" name="itemDesc" id = "itemDesc" required value=""> <br>

                <label for="itemQty">Quantity: </label>
                <input type="number" name="itemQty" id = "itemQty" required value="" pattern="[0-9]+" title="Please enter numeric input."> <br>

                <label for="itemUnitPrice">Unit Price: </label>
                <input type="number" name="itemUnitPrice" id = "itemUnitPrice" min="0" step="any" required value="" pattern="[0-9]+" title="Please enter digit or numeric input."> <br>

                <input type='submit' name='submit' value="Submit" class="submit" onclick="return confirm('Are you sure you want to add this item?');"> <br>

                <a href="../administration/maintainInventory.php">
                    <button type="button" class="btn btn-danger btn-block btnCancel">Cancel</button>
                </a>
            </form>
        </div>
    </body>
</html>
