<!-- <!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/main.2.8.css" rel="stylesheet" type="text/css">
    <link href="css/responsive1.1.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-multiEmail.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link href="css/responsive.dataTables.min.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrapValidator.css" rel="stylesheet" type="text/css">
    <link href="css/notification.css" rel="stylesheet" type="text/css">

</head>

<body>
    <div class="login">
        <h1>Login</h1>
        <form method="post" action="loginProcessTesting.php">
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="supplierName" placeholder="Supplier Name" id="supplierName" required>
            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Password" id="password" required>
            <input type="submit" value="Login" name="login">
        </form>
    </div>
</body>
</html> -->

<!DOCTYPE html>
<html>

<head>
    <title>Supplier Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        form {
            border: 3px solid #f1f1f1;
            width: 50%;
            margin: 0 auto;
        }

        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }

        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        .container {
            padding: 50px;
            width: 50%;
            margin: 0 auto;

        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <h2 style="text-align: center;">Supplier Login Form</h2>

    <form method="post" action="loginProcess.php"">

  <div class=" container">
        <input type="text" name="companyName" placeholder="Company Name" id="companyName" required>
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Password" id="password" required>
      

        <button type="submit" value="Login" name="login">Login</button>

        </div>

    </form>

</body>

</html>