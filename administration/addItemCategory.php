<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

//generate category ID
$query = "SELECT * FROM itemcategory ORDER BY cat_id DESC LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
$lastid = $row['cat_id'] ?? '';
if ($lastid == null or $lastid == '') {
    $itemCatid = "IC0001";
} else {
    $get_numbers = str_replace("IC", "", $lastid);
    $id_increase = $get_numbers + 1;
    $get_string = str_pad($id_increase, 4, 0, STR_PAD_LEFT);
    $itemCatid = "IC" . $get_string;
}

//insert
if (isset($_POST["submit"])) {
    $icID = $itemCatid;
    $catName = $_POST["catName"];
    $catDesc = $_POST["catDesc"];

    $query = $con->prepare('INSERT INTO itemcategory (cat_id, cat_name, cat_description) VALUES (?,?,?)');
    $query->bind_param('sss', $icID, $catName, $catDesc);

    $query->execute();

    if ($query) {
        echo "<script>alert('Successfully added!')</script>";
        echo("<script>location.href = '../administration/addItemCategory.php';</script>");
    }else{
        echo "<script>alert('Item category failed to be added. Please try again.')</script>";
    }
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
        <div class="addItemCategory">
            <h2 style="font-size: 60px">Item Category Details Form</h2> <br>

            <form action = "" method="post" id="addItemCategory" class="center">

                <!--category id-->
                <label for="itemCatid">Item Category ID: </label>
                <input type="text" name="itemCatid" id = "itemCatid" value="<?php echo $itemCatid; ?>" disabled> <br>

                <!--category name-->
                <label for="catName">Category Name: </label>
                <input type="text" name="catName" id = "catName" required value=""> <br>

                <!--category description-->
                <label for="catDesc">Category Description: </label>
                <input type="text" name="catDesc" id = "catDesc" required value=""> <br>

                <input type='submit' name='submit' value="Submit" class="submit" onclick="return confirm('Are you sure you want to add this item category?');"> <br>

                <a href="../administration/maintainItemCategory.php">
                    <button type="button" class="btn btn-danger btn-block btnCancel">Cancel</button>
                </a>
            </form>
        </div>
    </body>
</html>
