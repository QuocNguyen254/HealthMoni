
<?php
session_start();
if(isset($_SESSION['id'])&& isset($_SESSION['user_name'])){

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Moni</title>

    <!-- Material Icon -->
    <link rel="shortcut icon" href="../src/ico/logo.ico">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/dataview.css">

    <!-- Function -->
    <script src="../js/home.js"></script>

</head>

<body>
    <div class="container">
        <aside id="aside">
            <div class="top">
                <div class="logo">
                    <img src="../src/png/logo.png">
                    <h2>Health<span class="logoKey">Moni</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a id="menu_home">
                    <span class="material-icons">home</span>
                    <h3>Home</h3>
                </a>
                <a id="menu_data" class="active">
                    <span class="material-icons">query_stats</span>
                    <h3>Dataview</h3>
                </a>
                <a id="menu_booking">
                    <span class="material-icons">calendar_month</span>
                    <h3>Booking</h3>
                </a>
                <a id="menu_doctors">
                    <span class="material-icons">diversity_1</span>
                    <h3>Doctors</h3>
                </a>
                <a id="menu_logout">
                    <span class="material-icons">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>

        <!-----------Main------------>
        <main>
            <h2>Responsive Table</h2>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Datetime</th>
                            <th>Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="rows">
                    <tbody>
                </table>
            </div>
        </main>

        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class="material-icons">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class="material-icons active">light_mode</span>
                    <span class="material-icons">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <b id="username"><?php echo $_SESSION['name']; ?></b>
                        <small class="" tect-muted>user</small>
                    </div>
                    <div class="profile-photo">
                        <img src="../src/jpg/null.jpg">
                    </div>
                </div>
            </div>
            <!--end of top-->
            <div clsaa="right-btm">


            </div>
        </div>
    </div>
    <script src="../js/dataview.js"></script>
</body>

</html>
<?php

}else{
    header("Location: ../html/index.html");
    exit();
}
?>