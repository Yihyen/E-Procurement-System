<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

$res = $con->query("SELECT * FROM user where user_id='" . $_GET['uid'] . "'")->fetch_array();

if (isset($_POST["save"])) {
    $id = $_GET['uid'];
    $username = $_POST["username"];
    $name = $_POST["name"];
    $useremail = $_POST["userEmail"];
    $userContact = $_POST["userContact"];
    $userGender = $_POST["userGender"];
    $userAddress = $_POST["userAddress"];
    $branch = $_POST["branch"];
    $department = $_POST["department"];
    $jobposition = $_POST["jobposition"];
    $userrole = $_POST["userrole"];
    $status = $_POST["status"];

    $query = "UPDATE user SET user_name = '$username', name = '$name', user_email = '$useremail', user_contact = '$userContact', user_gender = '$userGender', user_address = '$userAddress', branch = '$branch', department = '$department', job_position = '$jobposition', user_role = '$userrole', user_status = '$status' WHERE user_id = '$id'";
    mysqli_query($con, $query);
    
    if($query){
        echo "<script>alert('Successfully updated!')</script>";
        echo("<script>location.href = '../administration/maintainUser.php';</script>");
    }else{
        echo "<script>alert('Failed to be updated. Please try again.')</script>";
    }
}
?>

<html>
    <head>
        <title>Edit User Details</title>

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
        <div class="editUser">
            <h2 style="font-size: 60px">User Details Form</h2> <br>

            <form action = "" method="post" id="editUser" class="center">

                <!--userid-->
                <label for="userID">User ID: </label>
                <input type="text" name="userID" id = "userID" value="<?php echo $res['user_id']; ?>" disabled> <br>

                <!--username-->
                <label for="username">Username: </label>
                <input type="text" name="username" id = "username" value="<?php echo $res['user_name']; ?>" required value=""> <br>
                
                <!--name-->
                <label for="name">Name: </label>
                <input type="text" name="name" id = "name" value="<?php echo $res['name']; ?>" required value=""> <br>

                <!--user email-->
                <label for="userEmail">User Email: </label>
                <input type="text" name="userEmail" id = "userEmail" value="<?php echo $res['user_email']; ?>" required value="" onkeydown="emailValidation()">
                <span id="text"></span> <br>

                <!--user contact-->
                <label for="userContact">User Contact: </label>
                <input type="text" name="userContact" id = "userContact" value="<?php echo $res['user_contact']; ?>" required value=""> <br>

                <!--user gender-->
                <label for="userGender">User Gender: </label>
                <select name="userGender" class="form-control" required value="">
                    <option value="M"
                    <?php
                    if ($res['user_gender'] == "M") {
                        echo"selected";
                    }
                    ?>
                            >Male</option>
                    <option value="F"
                    <?php
                    if ($res['user_gender'] == "F") {
                        echo"selected";
                    }
                    ?>
                            >Female</option>
                </select> <br>

                <!--user address-->
                <label for="userAddress">User Address: </label>
                <textarea id="userAddress" name="userAddress" rows="4" cols="70" required value=""><?php echo $res['user_address'] ?></textarea> <br>

                <!--branch-->
                <label for="branch">Branch: </label>
                <input type="text" name="branch" id = "branch" value="<?php echo $res['branch']; ?>" required value=""> <br>

                <!--department-->
                <label for="department">Department: </label>
                <select name="department" class="form-control" required value="">
                    <option value="Marketing Department"
                    <?php
                    if ($res['department'] == "Marketing Department") {
                        echo"selected";
                    }
                    ?>
                            >Marketing Department</option>

                    <option value="Operations Department"
                    <?php
                    if ($res['department'] == "Operations Department") {
                        echo"selected";
                    }
                    ?>   
                            >Operations Department</option>

                    <option value="Finance Department"
                    <?php
                    if ($res['department'] == "Finance Department") {
                        echo"selected";
                    }
                    ?>
                            >Finance Department</option>

                    <option value="Sales Department"
                    <?php
                    if ($res['department'] == "Sales Departmentf") {
                        echo"selected";
                    }
                    ?>
                            >Sales Department</option>

                    <option value="Purchase Department"
                    <?php
                    if ($res['department'] == "Purchase Department") {
                        echo"selected";
                    }
                    ?>
                            >Purchase Department</option>
                </select> <br>

                <!--job position-->
                <label for="jobposition">Job Position: </label>
                <input type="text" name="jobposition" id = "jobposition" value="<?php echo $res['job_position']; ?>" required value="" > <br>

                <!--user role-->
                <label for="userrole">User Role: </label>
                <select name="userrole" class="form-control" required value="">
                    <option value="Administrator"
                    <?php
                    if ($res['user_role'] == "Administrator") {
                        echo"selected";
                    }
                    ?>
                            >Administrator</option>

                    <option value="Branches"
                    <?php
                    if ($res['user_role'] == "Branches") {
                        echo"selected";
                    }
                    ?>   
                            >Branches</option>

                    <option value="Purchasing Manager"
                    <?php
                    if ($res['user_role'] == "Purchasing Manager") {
                        echo"selected";
                    }
                    ?>
                            >Purchasing Manager</option>

                    <option value="Purchasing Staff"
                    <?php
                    if ($res['user_role'] == "Purchasing Staff") {
                        echo"selected";
                    }
                    ?>
                            >Purchasing Staff</option>
                    
                    <option value="Supplier"
                    <?php
                    if ($res['user_role'] == "Supplier") {
                        echo"selected";
                    }
                    ?>
                            >Supplier</option>
                    
                    <option value="Outsourcer"
                    <?php
                    if ($res['user_role'] == "Outsourcer") {
                        echo"selected";
                    }
                    ?>
                            >Outsourcer</option>
                </select> <br>
                
                <!--user status-->
                <label for="status">Status: </label>
                <select id="status" name="status" class="form-control" required value="">
                    <option value="Available"
                    <?php
                    if ($res['user_status'] == "Available") {
                        echo"selected";
                    }
                    ?>
                            >Available</option>

                    <option value="Unavailable"
                    <?php
                    if ($res['user_status'] == "Unavailable") {
                        echo"selected";
                    }
                    ?>
                            >Unavailable</option>
                </select> <br>

                <input type='submit' name='save' value="Save" class="save" onclick="return confirm('Are you sure you want to save?');">

                <br>

                <a href="maintainUser.php">
                    <button type="button" class="btn btn-danger btn-block btnCancel">Cancel</button>
                </a>

            </form>
        </div>
        
        <script type ="text/javascript">
            function emailValidation() {
                var form = document.getElementById("editUser");
                var email = document.getElementById("userEmail").value;
                var text = document.getElementById("text");
//                var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                var pattern = /^[^@]{1,64}@[^@]{1,255}$/;
                
                if (email.match(pattern)) {
                    form.classList.add("valid");
                    form.classList.remove("invalid");
                    text.innerHTML = "Valid Email Address.";
                    text.style.color = "#00ff00";
                } else {
                    form.classList.remove("valid");
                    form.classList.add("invalid");
                    text.innerHTML = "Invalid Email Address.";
                    text.style.color = "#ff0000";
                }
                
                if(email == ""){
                    form.classList.remove("valid");
                    form.classList.remove("invalid");
                    text.innerHTML = "";
                    text.style.color = "#00ff00";
                }
            }
        </script>
        
    </body>
</html>
