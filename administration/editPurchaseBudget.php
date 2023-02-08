<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

$res = $con->query("SELECT * FROM purchasebudget where budget_id='" . $_GET['budgetID'] . "'")->fetch_array();

if (isset($_POST["save"])) {
    $budgetID = $_GET['budgetID'];
    $userID = $_POST["userID"];
    $budgetAmount = $_POST["budgetAmount"];
    $budgetDesc = $_POST["budgetDesc"];
    $date = $res["date_created"];
    $status = $_POST["status"];

    $query = "UPDATE purchasebudget SET user_id = '$userID', budget_amount = '$budgetAmount', budget_description = '$budgetDesc', date_created = '$date', budget_status = '$status' WHERE budget_id = '$budgetID'";
    mysqli_query($con, $query);
    
    if($query){
        echo "<script>alert('Successfully updated!')</script>";
        echo("<script>location.href = '../administration/maintainPurchaseBudget.php';</script>");
    }else{
        echo "<script>alert('Failed to be updated. Please try again.')</script>";
    }
}
?>

<html>
    <head>
        <title>Edit Purchase Budget</title>

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
        <div class="editBudget">
            <h2 style="font-size: 60px">Purchase Budget Form</h2> <br>

            <form action = "" method="post" id="editBudget" class="center">

                <!--purchase id-->
                <label for="budgetID">Budget ID: </label>
                <input type="text" name="budgetID" id = "budgetID" value="<?php echo $res['budget_id']; ?>" disabled> <br>

                <!--user id-->
                <?php
                $query = "SELECT * FROM user";
                $result = mysqli_query($con, $query);
                ?>

                <label for="userID">User ID: </label>
                <select id="userID" name="userID" class="form-control" required value="">
                    <?php
                    while ($rows = $result->fetch_assoc()) {
                        $userID = $rows['user_id'];

                        echo "<option value = '$userID'>$userID</option>";
                    }
                    ?>
                </select> <br>
                
                <!--budget amount-->
                <label for="budgetAmount">Budget Amount: </label>
                <input type="text" name="budgetAmount" id = "budgetAmount" value="<?php echo $res['budget_amount']; ?>" required value=""> <br>

                 <!--budget desc-->
                <label for="budgetDesc">Budget Description: </label>
                <input type="text" name="budgetDesc" id = "budgetDesc" value="<?php echo $res['budget_description']; ?>" required value=""> <br>

                <!--date-->
                <label for="date">Date Created: </label>
                <input type="text" name="date" id = "date" value="<?php echo $res['date_created']; ?>" disabled> <br>
                
                <!--status-->
                <label for="status">Status: </label>
                <select id="status" name="status" class="form-control" required value="">
                    <option value="Available"
                    <?php
                    if ($res['budget_status'] == "Available") {
                        echo"selected";
                    }
                    ?>
                            >Available</option>

                    <option value="Unavailable"
                    <?php
                    if ($res['budget_status'] == "Unavailable") {
                        echo"selected";
                    }
                    ?>
                            >Unavailable</option>
                </select> <br>

                <input type='submit' name='save' value="Save" class="save" onclick="return confirm('Are you sure you want to save?');"><br>

                <a href="../administration/maintainPurchaseBudget.php">
                    <button type="button" class="btn btn-danger btn-block btnCancel">Cancel</button>
                </a>

            </form>
        </div>
    </body>
</html>
