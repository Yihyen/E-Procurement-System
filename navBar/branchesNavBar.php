<!DOCTYPE html>
<?php
require '../connection/dbCon.php';
$res = $con->query("SELECT * FROM user where user_name='" . $_SESSION["username"] . "'")->fetch_array();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <!-- Boxiocns CDN Link -->
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <style>
            /* Google Fonts Import Link */
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }
            .sidebar{
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 280px;
                background: #11101d;
                z-index: 100;
                transition: all 0.5s ease;
            }
            .sidebar.close{
                width: 78px;
            }
            .sidebar .logo-details{
                height: 60px;
                width: 100%;
                display: flex;
                align-items: center;
            }
            .sidebar .logo-details i{
                font-size: 30px;
                color: #fff;
                height: 50px;
                min-width: 78px;
                text-align: center;
                line-height: 50px;
            }
            .sidebar .logo-details .logo_name{
                font-size: 22px;
                color: #fff;
                font-weight: 600;
                transition: 0.3s ease;
                transition-delay: 0.1s;
                margin-left: 50px;
            }
            .sidebar.close .logo-details .logo_name{
                transition-delay: 0s;
                opacity: 0;
                pointer-events: none;
            }
            .sidebar .nav-links{
                height: 100%;
                padding: 30px 0 150px 0;
                overflow: auto;
            }
            .sidebar.close .nav-links{
                overflow: visible;
            }
            .sidebar .nav-links::-webkit-scrollbar{
                display: none;
            }
            .sidebar .nav-links li{
                position: relative;
                list-style: none;
                transition: all 0.4s ease;
            }
            .sidebar .nav-links li:hover{
                background: #1d1b31;
            }
            .sidebar .nav-links li .iocn-link{
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .sidebar.close .nav-links li .iocn-link{
                display: block
            }
            .sidebar .nav-links li i{
                height: 50px;
                min-width: 78px;
                text-align: center;
                line-height: 50px;
                color: #fff;
                font-size: 20px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .sidebar .nav-links li.showMenu i.arrow{
                transform: rotate(-180deg);
            }
            .sidebar.close .nav-links i.arrow{
                display: none;
            }
            .sidebar .nav-links li a{
                display: flex;
                align-items: center;
                text-decoration: none;
            }
            .sidebar .nav-links li a .link_name{
                font-size: 18px;
                /*font-weight: 200;*/
                color: #fff;
                transition: all 0.4s ease;
            }
            .sidebar.close .nav-links li a .link_name{
                opacity: 0;
                pointer-events: none;
            }
            .sidebar .nav-links li .sub-menu{
                padding: 6px 6px 14px 80px;
                margin-top: -10px;
                background: #1d1b31;
                display: none;
            }
            .sidebar .nav-links li.showMenu .sub-menu{
                display: block;
            }
            .sidebar .nav-links li .sub-menu a{
                color: #fff;
                font-size: 15px;
                padding: 5px 0;
                white-space: nowrap;
                opacity: 0.6;
                transition: all 0.3s ease;
            }
            .sidebar .nav-links li .sub-menu a:hover{
                opacity: 1;
            }
            .sidebar.close .nav-links li .sub-menu{
                position: absolute;
                left: 100%;
                top: -10px;
                margin-top: 0;
                padding: 10px 20px;
                border-radius: 0 6px 6px 0;
                opacity: 0;
                display: block;
                pointer-events: none;
                transition: 0s;
            }
            .sidebar.close .nav-links li:hover .sub-menu{
                top: 0;
                opacity: 1;
                pointer-events: auto;
                transition: all 0.4s ease;
            }
            .sidebar .nav-links li .sub-menu .link_name{
                display: none;
            }
            .sidebar.close .nav-links li .sub-menu .link_name{
                font-size: 18px;
                opacity: 1;
                display: block;
            }
            .sidebar .nav-links li .sub-menu.blank{
                opacity: 1;
                pointer-events: auto;
                padding: 3px 20px 6px 16px;
                opacity: 0;
                pointer-events: none;
            }
            .sidebar .nav-links li:hover .sub-menu.blank{
                top: 50%;
                transform: translateY(-50%);
            }
            .sidebar .profile-details{
                position: fixed;
                bottom: 0;
                width: 280px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: #1d1b31;
                padding: 12px 0;
                transition: all 0.5s ease;
            }
            .sidebar.close .profile-details{
                background: none;
            }
            .sidebar.close .profile-details{
                width: 78px;
            }
            .sidebar .profile-details .profile-content{
                display: flex;
                align-items: center;
            }
            .sidebar .profile-details img{
                height: 52px;
                width: 52px;
                object-fit: cover;
                border-radius: 16px;
                margin: 0 14px 0 12px;
                background: #1d1b31;
                transition: all 0.5s ease;
            }
            .sidebar.close .profile-details img{
                padding: 10px;
            }
            .sidebar .profile-details .profile_name,
            .sidebar .profile-details .job{
                color: #fff;
                font-size: 18px;
                font-weight: 500;
                white-space: nowrap;
            }
            .sidebar.close .profile-details i,
            .sidebar.close .profile-details .profile_name,
            .sidebar.close .profile-details .job{
                display: none;
            }
            .sidebar .profile-details .job{
                font-size: 12px;
            }
            .topbar{
                position: relative;
                background: #E4E9F7;
                height: 100vh;
                left: 280px;
                width: calc(100% - 280px);
                transition: all 0.5s ease;
            }
            .sidebar.close ~ .topbar{
                left: 78px;
                width: calc(100% - 78px);
            }
            .topbar{
                height: 60px;
                display: flex;
                align-items: center;
            }
            .topbar .bx-menu,
            .topbar .text{
                color: #11101d;
                font-size: 35px;
            }
            .topbar .bx-menu{
                margin: 0 25px;
                cursor: pointer;
            }
            .topbar .text{
                font-size: 26px;
                font-weight: 600;
            }
            .name-job{
                margin-left: 30px;
            }
            @media (max-width: 400px) {
                .sidebar.close .nav-links li .sub-menu{
                    display: none;
                }
                .sidebar{
                    width: 78px;
                }
                .sidebar.close{
                    width: 0;
                }
                .topbar{
                    left: 78px;
                    width: calc(100% - 78px);
                    z-index: 100;
                }
                .sidebar.close ~ .topbar{
                    width: 100%;
                    left: 0;
                }
            }
        </style>

    </head>
    <body>
        <div class="sidebar close">
            <div class="logo-details">
                <!--<i class='bx bx'></i>-->
                <span class="logo_name">E-procurement</span>
            </div>

            <ul class="nav-links">
                <li>
                    <a href="../administration/homePage.php">
                        <i class='bx bx-home' ></i>
                        <span class="link_name">Home</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="../administration/homePage.php">Home</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../PR/PR.php">
                        <i class='bx bx-purchase-tag-alt' ></i>
                        <span class="link_name">Create Purchase Requisition</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="../PR/PR.php">Create Purchase Requisition</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../MR/MR.php">
                        <i class='bx bx-detail' ></i>
                        <span class="link_name">Create Material Requisition</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="../MR/MR.php">Create Material Requisition</a></li>
                    </ul>
                </li>

                <li>
                    <div class="profile-details">
                        <div class="name-job">
                            <div class="profile_name"><?php echo $_SESSION["username"]; ?></div>
                            <div class="job"><?php echo $res["user_role"]; ?></div>
                        </div>
                        <div class="chgpw-logoout">
                            <a href="../administration/verifyCurrentPw.php">
                                <i class='bx bx-cog' title="Change Password"></i>
                            </a>
                            <a href="../administration/login.php">
                                <i class='bx bx-log-out' title="Logout"></i>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="topbar">
            <i class='bx bx-menu' ></i>
        </div>

        <script>
            let arrow = document.querySelectorAll(".arrow");
            for (var i = 0; i < arrow.length; i++) {
                arrow[i].addEventListener("click", (e) => {
                    let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
                    arrowParent.classList.toggle("showMenu");
                });
            }
            let sidebar = document.querySelector(".sidebar");
            let sidebarBtn = document.querySelector(".bx-menu");
            console.log(sidebarBtn);
            sidebarBtn.addEventListener("click", () => {
                sidebar.classList.toggle("close");
            });
        </script>
    </body>
</html>