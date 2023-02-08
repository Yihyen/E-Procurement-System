<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

$res = $con->query("SELECT * FROM itemcategory where cat_id='" . $_GET['icid'] . "'")->fetch_array();

if (isset($_POST["save"])) {
    $icid = $_GET['icid'];
    $catName = $_POST["catName"];
    $catDesc = $_POST["catDesc"];

    $query = "UPDATE itemcategory SET cat_name = '$catName', cat_description = '$catDesc' WHERE cat_id = '$icid'";
    mysqli_query($con, $query);
    
    if($query){
        echo "<script>alert('Successfully updated!')</script>";
        echo("<script>location.href = '../administration/maintainItemCategory.php';</script>");
    }else{
        echo "<script>alert('Failed to be updated. Please try again.')</script>";
    }
}
?>

<html>
    <head>
        <title>Edit Item Category Details</title>

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
        <div class="editItemCategory">
            <h2 style="font-size: 60px">Item Category Details Form</h2> <br>

            <form action = "" method="post" id="editUser" class="center">

                <!--category id-->
                <label for="itemCatid">Item Category ID: </label>
                <input type="text" name="itemCatid" id = "itemCatid" value="<?php echo $res['cat_id']; ?>" disabled> <br>

                <!--category name-->
                <label for="catName">Category Name: </label>
                <input type="text" name="catName" id = "catName" value="<?php echo $res['cat_name']; ?>" required value=""> <br>

                <!--category description-->
                <label for="catDesc">Category Description: </label>
                <input type="text" name="catDesc" id = "catDesc" value="<?php echo $res['cat_description']; ?>" required value=""> <br>

                <input type='submit' name='save' value="Save" class="save" onclick="return confirm('Are you sure you want to save?');">

                <br>

                <a href="../administration/maintainItemCategory.php">
                    <button type="button" class="btn btn-danger btn-block btnCancel">Cancel</button>
                </a>

            </form>
        </div>
    </body>
</html>
