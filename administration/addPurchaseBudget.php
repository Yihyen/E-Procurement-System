<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

$res = $con->query('SELECT * FROM purchasebudget');

//generate item ID
$query = "SELECT * FROM purchasebudget ORDER BY budget_id DESC LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
$lastid = $row['budget_id'] ?? '';
if ($lastid == null or $lastid == '') {
    $budgetId = "PB0001";
} else {
    $get_numbers = str_replace("PB", "", $lastid);
    $id_increase = $get_numbers + 1;
    $get_string = str_pad($id_increase, 4, 0, STR_PAD_LEFT);
    $budgetId = "PB" . $get_string;
}

//insert user
if (isset($_POST["submit"])) {
    $budget_id = $budgetId;
    $userID = $_POST["userID"];
    $budgetAmount = $_POST["budgetAmount"];
    $budgetDesc = $_POST["budgetDesc"];
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $datecreated = date('Y-m-d H:i:s');
    $status = "Available";

    $query = $con->prepare('INSERT INTO purchasebudget (budget_id, user_id, budget_amount, budget_description ,date_created, budget_status) VALUES (?,?,?,?,?,?)');
    $query->bind_param('ssssss', $budget_id, $userID, $budgetAmount, $budgetDesc, $datecreated, $status);

    $query->execute();

    if ($query) {
        echo "<script>alert('Successfully added!')</script>";
        echo("<script>location.href = '../administration/addPurchaseBudget.php';</script>");
    }else{
        echo "<script>alert('Purchase budget failed to be added. Please try again.')</script>";
    }
}

if (isset($_POST['cancel'])) {
    header("Location: ../administration/maintainPurchaseBudget.php");
}
?>

<html>
    <head>
        <title>Add Purchase Budget</title>

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
        <div class="addPurchaseBudget">
            <h2 style="font-size: 60px">Purchase Budget Form</h2> <br>

            <form action = "" method="post" id="addPurchaseBudget" class="center">

                <!--purchase id-->
                <label for="budgetID">Budget ID: </label>
                <input type="text" name="budgetID" id = "budgetID" value="<?php echo $budgetId; ?>" disabled> <br>

                <!--user id-->
                <label for="userID">User ID: </label>
                <select id="userID" name="userID" class="form-control" required value=""> <br>
                    <?php
                    $res = $con->query('SELECT * FROM user WHERE user_status = "Available"');

                    while ($rows = $res->fetch_assoc()) {
                        $user_id = $rows['user_id'];

                        echo "<option value = '$user_id'>$user_id</option>";
                    }
                    ?>
                </select> <br>

                <!--budget amount-->
                <label for="budgetAmount">Budget Amount: </label>
                <input type="number" name="budgetAmount" id = "budgetAmount" min="0" step="any" required value="" pattern="[0-9]+" title="Please enter digit or numeric input."> <br>

                <!--budget desc-->
                <label for="budgetDesc">Budget Description: </label>
                <input type="text" name="budgetDesc" id = "budgetDesc" required value=""> <br>

                <input type='submit' name='submit' value="Submit" class="submit" onclick="return confirm('Are you sure you want to add this purchase budget?');"> <br>

                <a href="maintainPurchaseBudget.php">
                    <button type="button" class="btn btn-danger btn-block btnCancel">Cancel</button>
                </a>
            </form>
        </div>
    </body>
</html>
