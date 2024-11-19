<?php
 include '../php/connect.php'; 
session_start();

$sql_1 = "SELECT ImageLink AS userImage FROM users where name = '".$_SESSION['user_name']."'";
$result_1 = $conn->query($sql_1);
$row_1 = $result_1->fetch_assoc();
$_SESSION['userImage'] = $row_1['userImage'];
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
                     <a id="menu_home" class="active" href="./home_doctor.php">
                         <span class="material-icons" >home</span>
                         <h3>Home</h3>
                     </a>
                     <a id="menu_data"  href="./dataview_doctor.php">
                         <span class="material-icons">query_stats</span>
                         <h3>Dataview</h3>
                     </a>
                     <a id="menu_booking" href="./booking_doctor.php">
                         <span class="material-icons">calendar_month</span>
                         <h3>Booking</h3>
                     </a>
                     <a id="menu_logout" href="../php/logout.php">
                         <span class="material-icons">logout</span>
                         <h3>Logout</h3>
                     </a>
                 </div>
        </aside>

        <!-----------Main------------>
        <main>
            <!-- <div class="topbar">
                <input type="text" class="searchBar" placeholder="Search Doctor">
                <div class="right">

                </div>
            </div> -->

            <div class="info">
                <div class="welcome">
                    <h2 id="welcome">Hi, <?php echo $_SESSION['name']; ?>  </h2>
                    <h2>You are viewing </h2>
                    <h1 class="dataChartTitle" id="dataChartTitle">
                        Blood Pressure (systolic)</h1>
                </div>
                <div class="dataChart">
                    <canvas id="line-chart"></canvas>
                    <!--<script type="text/javascript" src="../js/lineChart.js"></script>-->
                </div>
            </div>

            <div class="deck">
                <!-- Data Card -->
                <script>updateChart('none')</script>
                <div class="card-BP" onclick="updateChart('BP_S')">
                    <span class="material-icons">water_drop</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Blood pressure (systolic)</h3>
                            <h1 id="card_BPS">110 mmHg</h1>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <!--End of Card-->
                <!-- <div class="card-BP" onclick="updateChart('BP_D')">
                    <span class="material-icons">water_drop</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Blood Glucose</h3>
                            <h1 id="card_BPD" hidden="true">11 mmHg</h1>
                            <h1 id="card_BG">11 mmHg</h1>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div> -->
                <!--End of Card-->
                <div class="card-HR" onclick="updateChart('HR')">
                    <span class="material-icons">monitor_heart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Heart Rate</h3>
                            <h1 id="card_HR">82 bpm</h1>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <!--End of Card-->
                <!-- <div class="card-Steps" onclick="updateChart('Steps')">
                    <span class="material-icons">directions_walk</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Walks</h3>
                            <h1 id="card_Steps">12482 steps</h1>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div> -->
                <!--End of Card-->
            </div>
        </main>
        <!-- End of main -->

        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class="material-icons">menu</span>
                </button>
                <div class="profile">
                    <div class="info">
                        <b id="username"><?php echo $_SESSION['name']; ?></b>
                    </div>
                    <div class="profile-photo">
                        <img src="<?php echo $_SESSION['userImage']; ?>">
                    </div>
                </div>
            </div>
            <!--end of top-->
            <div clsaa="right-btm">
                
            </div>
        </div>
    </div>
</body>
</html>


<?php

}else{
    header("Location: ../html/index.html");
    exit();
}
?>