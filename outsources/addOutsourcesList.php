<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

if(isset($_SESSION['message'])){
    echo "<script>alert('Outsources List Successfully Created')</script>";
    unset ($_SESSION['message']);
} 
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <title>Add Outsources List</title>

</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Outsources List 
                            <a href="outsourcesList.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="codeDatabase.php" enctype="multipart/form-data" method="POST">
                            <div class="mb-3">
                                <input type="hidden" name="outsourcer_id" class="form-control" id = "outsourcer_id" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Outsources Name:</label>
                                <input type="text" name="outsourcerName" id="outsourcerName" class="form-control" placeholder="Enter company name" onkeyup="checkName()" required>
                            </div>
                            <div class="icons">
                                <span class="icon1 fas fa-exclamation"></span> <!--！-->
                                <span class="icon2 fas fa-check"></span> <!--v-->
                            </div>
                            <div class="error-text">
                                Please Enter Valid company Name
                            </div>
                            <div class="mb-3">
                                <label>Contact Number:</label>
                                <input type="text" name="contact" id="contact" class="form-control" placeholder="Enter contact number" onkeyup="checkContact()" required>
                            </div>
                            <div class="icons">
                                <span class="icon3 fas fa-exclamation"></span> <!--！-->
                                <span class="icon4 fas fa-check"></span> <!--v-->
                            </div>
                            <div class="error-text1">
                                Please Enter Valid Contact Number
                            </div>
                            <div class="mb-3">
                                <label>Address:</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="Enter address" onkeyup="checkAddress()" required>
                            </div>
                            <div class="icons">
                                <span class="icon7 fas fa-exclamation"></span> <!--！-->
                                <span class="icon8 fas fa-check"></span> <!--v-->
                            </div>
                            <div class="error-text3">
                                Please Enter Valid Address
                            </div>
                            <div class="mb-3">
                                <label>Email:</label>
                                <input onkeyup="checkEmail()" type="text" name="email" id="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="icons">
                                <span class="icon5 fas fa-exclamation"></span> <!--！-->
                                <span class="icon6 fas fa-check"></span> <!--v-->
                            </div>
                            <div class="error-text2">
                                Please Enter Valid Email
                            </div>
                            <div class="mb-3">
                                <label for="serviceType">Service Type: </label>
                                <select id="serviceType" name="serviceType" class="form-control" required value="">
                                    <option value="Professional Service" selected="selected" >Professional Services</option>
                                    <option value="IT Service">IT Service</option>
                                    <option value="Manufacturing Service">Manufacturing Service</option>
                                    <option value="Project Service">Project Service</option>
                                    <option value="Process Service">Process Service</option>
                                    <option value="Operational Service">Operational Service</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="status" value="Invite">
                                <button type="submit" name="save" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div><br>
            </div>
        </div>
    </div>

    <style>
        .mt-5{
            width:500px;
            font-family: 'Poppins', sans-serif;
        }
        
        .card-header{
            text-align: center;
            color:#17a2b8;
        }
        
        form .icons{
            position: absolute;
            right: 25px;
            transform: translateY(-190%);
        }
        
        .icons span{ /*error circle*/
            height: 20px;
            width: 23px;
            border: 2px solid;
            border-radius: 50%;
            line-height: 19px;
            display:none;
        }
        
        .icons span.icon1, .icon3, .icon5, .icon7, .icon9, .icon11, .icon13{
            color: #e74c3c;
            border-color: #e74c3c;
            text-align: center;
        }
        
        .icons span.icon2, .icon4, .icon6, .icon8, .icon10, .icon12, .icon14{
            color: #27ae60;
            border-color: #27ae60;
            text-align: center;
        }
        
        form .error-text, .error-text1, .error-text2, .error-text3, .error-text4, .error-text5, .error-text6{
            position: relative;
            margin: 15px 0 10px 0;
            background: #e74c3c;
            color: #fceae8;
            font-size: 15px;
            padding: 8px;
            border-radius: 5px;
            user-select: none;
            display: none;
        }
        
        form .error-text:before, .error-text1:before, .error-text2:before, .error-text3:before, .error-text4:before, .error-text5:before, .error-text6:before{
            position: absolute;
            content: '';
            height: 15px;
            width: 15px;
            background: #e74c3c;
            right: 20px;
            top: -5px;
            transform: rotate(45deg);
        }
        
        .mvv{
            border: 2px dashed blue;
        }
        
        iframe{
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        
        .mb-3 input{
            margin-bottom: 10px;
        }
        
        .btn-primary {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        
        h4{
            font-size:2.5rem;
        }
    </style>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const outsourcerName = document.querySelector("#outsourcerName");
        const contact = document.querySelector("#contact");
        const email = document.querySelector("#email");
        //name
        const icon1 = document.querySelector(".icon1");
        const icon2 = document.querySelector(".icon2");
        const error = document.querySelector(".error-text");
        const btn = document.querySelector("button");
        //contact
        const icon3 = document.querySelector(".icon3");
        const icon4 = document.querySelector(".icon4");
        const error1 = document.querySelector(".error-text1");
        //email
        const icon5 = document.querySelector(".icon5");
        const icon6 = document.querySelector(".icon6");
        const error2 = document.querySelector(".error-text2");
        //address
        const icon7 = document.querySelector(".icon7");
        const icon8 = document.querySelector(".icon8");
        const error3 = document.querySelector(".error-text3");
        
        let regExp = /^[a-zA-Z\s]+$/; //a-z / A-z
        let regExp1 = /^([0-9]{9,11})+$/; // 0-9 can 9-11 number
        let regExp2 = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        let regExp3 = /^[a-zA-Z\s\d\,\.\-\/]+$/; //a-z / A-z / space / 0-9 /,/-//
        
        function checkName() {
            if (outsourcerName.value.match(regExp)) {
                outsourcerName.style.borderColor = "#27ae60"; //green
                outsourcerName.style.background = "#eafaf1";
                icon1.style.display = "none";
                icon2.style.display = "block";
                error.style.display = "none";
//                btn.style.display = "block";
            } else if (outsourcerName.value === "") {
                outsourcerName.style.borderColor = "lightgrey";
                outsourcerName.style.background = "#fff";
                icon1.style.display = "none";
                icon2.style.display = "none";
                error.style.display = "none";
                btn.style.display = "none";
            }
            else {
                outsourcerName.style.borderColor = "#e74c3c"; //red
                outsourcerName.style.background = "#fceae9";
                icon1.style.display = "block";
                icon2.style.display = "none";
                error.style.display = "block";
                btn.style.display = "none";
            }
        }
        
        function checkContact() {
            if (contact.value.match(regExp1)) {
                contact.style.borderColor = "#27ae60"; //green
                contact.style.background = "#eafaf1";
                icon3.style.display = "none";
                icon4.style.display = "block";
                error1.style.display = "none";
//                btn.style.display = "block";
            } else if (contact.value === "") {
                contact.style.borderColor = "lightgrey";
                contact.style.background = "#fff";
                icon3.style.display = "none";
                icon4.style.display = "none";
                error1.style.display = "none";
                btn.style.display = "none";
            }
            else {
                contact.style.borderColor = "#e74c3c"; //red
                contact.style.background = "#fceae9";
                icon3.style.display = "block";
                icon4.style.display = "none";
                error1.style.display = "block";
                btn.style.display = "none";
            }
        }
       
        function checkEmail(){
           if(email.value.match(regExp2)){
             email.style.borderColor = "#27ae60";
             email.style.background = "#eafaf1";
             icon5.style.display = "none";
             icon6.style.display = "block";
             error2.style.display = "none";
             btn.style.display = "block";
           }else if(email.value == ""){
             email.style.borderColor = "lightgrey";
             email.style.background = "#fff";
             icon5.style.display = "none";
             icon6.style.display = "none";
             error2.style.display = "none";
             btn.style.display = "none";
           }else{
             email.style.borderColor = "#e74c3c";
             email.style.background = "#fceae9";
             icon5.style.display = "block";
             icon6.style.display = "none";
             error2.style.display = "block";
             btn1.style.display = "none";
           }
         }

         function checkAddress() {
            if (address.value.match(regExp3)) {
                address.style.borderColor = "#27ae60"; //green
                address.style.background = "#eafaf1";
                icon7.style.display = "none";
                icon8.style.display = "block";
                error3.style.display = "none";
//                btn.style.display = "block";
            } else if (address.value === "") {
                address.style.borderColor = "lightgrey";
                address.style.background = "#fff";
                icon7.style.display = "none";
                icon8.style.display = "none";
                error3.style.display = "none";
//                btn.style.display = "none";
            }
            else {
                address.style.borderColor = "#e74c3c"; //red
                address.style.background = "#fceae9";
                icon7.style.display = "block";
                icon8.style.display = "none";
                error3.style.display = "block";
                btn.style.display = "none";
            }
        }
    </script>
</body>
</html>
