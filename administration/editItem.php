<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

$res = $con->query("SELECT * FROM inventory where item_id='" . $_GET['itemid'] . "'")->fetch_array();

if (isset($_POST["save"])) {
    $itemId = $_GET['itemid'];
    $catID = $_POST["catID"];
    $itemName = $_POST["itemName"];
    $itemDesc = $_POST["itemDesc"];
    $itemQty = $_POST["itemQty"];
    $itemUnitPrice = $_POST["itemUnitPrice"];
    $status = $_POST["status"];

    $query = "UPDATE inventory SET cat_id = '$catID', item_name = '$itemName', item_description = '$itemDesc', item_quantity = '$itemQty', item_unit_price = '$itemUnitPrice', item_status = '$status' WHERE item_id = '$itemId'";
    mysqli_query($con, $query);
    
    if($query){
        echo "<script>alert('Successfully updated!')</script>";
        echo("<script>location.href = '../administration/maintainInventory.php';</script>");
    }else{
        echo "<script>alert('Failed to be updated. Please try again.')</script>";
    }
}
?>

<html>
    <head>
        <title>Edit Item Details</title>

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

            .save{
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
        <div class="editUser">
            <h2 style="font-size: 60px">Item Property Form</h2> <br>

            <form action = "" method="post" id="editUser" class="center">

                <!--userid-->
                <label for="itemID">Item ID: </label>
                <input type="text" name="itemID" id = "itemID" value="<?php echo $res['item_id']; ?>" disabled> <br>

                <!--category id-->
                <?php
                $query = "SELECT * FROM itemcategory";
                $result = mysqli_query($con, $query);
                ?>

                <label for="catID">Category: </label>
                <select id="catID" name="catID" class="form-control" required value="">
                    <?php
                    while ($rows = $result->fetch_assoc()) {
                        $cat_id = $rows['cat_id'];
                        $cat_name = $rows['cat_name'];

                        echo "<option value = '$cat_id'>$cat_name</option>";
                    }
                    ?>
                </select> <br>
                
                <!--item name-->
                <label for="itemName">Item Name: </label>
                <input type="text" name="itemName" id = "itemName" value="<?php echo $res['item_name']; ?>" required value=""> <br>

                <label for="itemDesc">Item Description: </label>
                <input type="text" name="itemDesc" id = "itemDesc" value="<?php echo $res['item_description']; ?>" required value=""> <br>

                <label for="itemQty">Quantity: </label>
                <input type="number" name="itemQty" id = "itemQty" value="<?php echo $res['item_quantity']; ?>" required value="" pattern="[0-9]+" title="Please enter numeric input."> <br>

                <label for="itemUnitPrice">Unit Price: </label>
                <input type="number" name="itemUnitPrice" id = "itemUnitPrice" min="0" step="any" value="<?php echo $res['item_unit_price']; ?>" required value="" pattern="[0-9]+" title="Please enter digit input."> <br>

                <label for="status">Status: </label>
                <select id="status" name="status" class="form-control" required value="">
                    <option value="Available"
                    <?php
                    if ($res['item_status'] == "Available") {
                        echo"selected";
                    }
                    ?>
                            >Available</option>

                    <option value="Unavailable"
                    <?php
                    if ($res['item_status'] == "Unavailable") {
                        echo"selected";
                    }
                    ?>
                            >Unavailable</option>
                </select> <br>

                <input type='submit' name='save' value="Save" class="save" onclick="return confirm('Are you sure you want to save?');"><br>

                <a href="../administration/maintainInventory.php">
                    <button type="button" class="btn btn-danger btn-block btnCancel">Cancel</button>
                </a>

            </form>
        </div>
    </body>
</html>
