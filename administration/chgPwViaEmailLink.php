<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';

if (isset($_POST["submit"])) {
    $password = $_POST['pw'];
    $confirmPw = $_POST["confirmPw"];
    
    $username = $_SESSION["username"];
    $query = "UPDATE user SET user_password = '$password' WHERE user_name = '$username'";
    mysqli_query($con, $query);
    if ($query) {
        echo "<script>alert('Password successfully updated! Please login again to proceed.')</script>";
        echo("<script>location.href = '../administration/login.php';</script>");
    }
}
?>

<html>
    <head>
        <title>Change Password</title>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
            *{
                margin: 0;
                padding: 0;
                user-select: none;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }
            
            h1 {
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

            #pw{
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
            
            #confirmPw{
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
                background-color: dodgerblue;
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
        <br><br><br><br>
        <h1>Change Password</h1>
        <form class="" action="" method="post" autocomplete="off" onSubmit="return validate();">
            <label for="pw">Password: </label>
            <input type="password" name="pw" id="pw" pattern="(?=.*[^\w])(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, one special character and at least 8 or more characters." required>
            <input type="checkbox" id="showpw" onclick="myFunction()">Show Password
            <br><br>
            
            <label for="confirmPw">Confirm Password: </label>
            <input type="password" name="confirmPw" id="confirmPw" required value="">
            <input type="checkbox" id="showconfirmpw" onclick="myFunction2()">Show Password
            <br><br>
            
            <p>*Password must contain at least one number and one uppercase and lowercase letter, one special character and at least 8 or more characters.</p>

            <input type='submit' name='submit' value="Confirm" class="submit"> <br>
        </form>

        <script>
            function myFunction() {
              var x = document.getElementById("pw");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
            
            function myFunction2() {
              var x = document.getElementById("confirmPw");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
            
            function validate(){
                var a = document.getElementById("pw").value;
                var b = document.getElementById("confirmPw").value;
                if (a!=b) {
                   alert("The password and confirm password are not matched. Please try again.");
                   return false;
                }
            }

        </script>
    </body>
</html>
