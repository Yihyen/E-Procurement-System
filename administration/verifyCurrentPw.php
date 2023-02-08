<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

if (isset($_POST["submit"])) {
    $username = $_SESSION["username"];
    $password = $_POST['password'];

    if ($password != "") {

        $query = "SELECT * FROM user WHERE user_name = '$username'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        if ($password == $row["user_password"]) {
            echo("<script>location.href = '../administration/chgPw.php';</script>");
        } else {
            echo "<script>alert('Invalid password. Please enter again.')</script>";
        }
    }
}
?>

<html>
    <head>
        <title>Change Password</title>
        <style>
            h1 {
                text-align: center;
                padding: 0.4em;
                margin-bottom: 0em;
            }

            label{
                width: 500px;
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

            .submit{
                background-color: dodgerblue;
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
        <br><br><br><br>
        <h1>Change Password</h1>
        <form class="" action="" method="post" autocomplete="off">
            <label for="password">Please Type Your Original Password Here: </label>
            <input type="password" name="password" id = "password" required value=""> <br>

            <input type='submit' name='submit' value="Confirm" class="submit"> <br>
        </form>
    </body>
</html>
