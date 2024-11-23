<?php
   include '../Backend/connect.php'; 

   session_start();
   if(isset($_GET['doctorName'])&&isset($_GET['medicalSpecialty'])){
    $_SESSION['doctorName'] =$_GET['doctorName'];
    $_SESSION['doctorMajor'] =$_GET['medicalSpecialty'];    
   }
    $dom = new DOMDocument;
    // Để xử lý tốt hơn với HTML5
    libxml_use_internal_errors(true);

    // Nhúng mã HTML trực tiếp
    $dom->loadHTML('
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
        <script src="https://kit.fontawesome.com/6970e19c66.js" crossorigin="anonymous"></script>

        <!-- Chart JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

        <!-- Stylesheet -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/booking.css">
        <link rel="stylesheet" href="../css/doctors.css">
        <link rel="stylesheet" href="../css/dataview.css">
        <!-- Function -->
       <!-- <script src="../js/home.js"></script> -->
        <!--<script src="../js/booking.js"></script> -->
        <style>
            .meetingLink:hover{
                color: #2E87A3;
            }
        </style>
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
                     <a id="menu_home" href="./home.php">
                         <span class="material-icons" >home</span>
                         <h3>Home</h3>
                     </a>
                     <a id="menu_data" href="./dataview.php">
                         <span class="material-icons">query_stats</span>
                         <h3>Dataview</h3>
                     </a>
                     <a id="menu_booking" class="active" href="./booking.php">
                         <span class="material-icons">calendar_month</span>
                         <h3>Booking</h3>
                     </a>
                     <a id="menu_doctors"  href="./doctor.php">
                         <span class="material-icons">diversity_1</span>
                         <h3>Doctors</h3>
                     </a>
                     <a id="menu_logout" href="../Backend/logout.php">
                         <span class="material-icons">logout</span>
                         <h3>Logout</h3>
                     </a>
                 </div>
            </aside>

            <!-----------Main------------>
            <main>               
                 <form action="booking.php" id="ft-form" method="POST" accept-charset="UTF-8">
                    <input type="hidden" name="doctorName" value="'. $_SESSION['doctorName'] .'">
                    <input type="hidden" name="medicalSpecialty" value="'. $_SESSION['doctorMajor'] .'">
                    <fieldset>
                        <legend id = "doctor-choose">The doctor that you chose</legend>
                        <div >
                            <ol class="image-list grid-view" style = "width:50%;" >
                            </ol>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend id="appointment-today">Your appointments today</legend>
                    </fieldset>                   
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Doctor name</th>
                                    <th>Medical specialty</th>
                                    <th>Meeting link</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="rows_1">
                            <tbody>

                        </table>
                    </div>
                    <fieldset>
                        <legend>Your appointments</legend>
                    </fieldset>                   
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Doctor name</th>
                                    <th>Medical specialty</th>
                                    <th>Meeting link</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="rows">
                            <tbody>

                        </table>
                    </div>
                    <fieldset>
                    <legend>Appointment request</legend>
                    <div class="two-cols">
                        <label>
                        Date
                        <input type="datetime-local" id = "appointmentDate" name="appointmentDate" placeholder="Click to choose meeting date" required>
                        </label>

                    </div>

                    </fieldset>
                    <div class="btns">
                    <input type="text" name="_gotcha" value="" style="display:none;">
                    <input type="submit" value="Submit request">
                    </div>
                </form>
            </main>
            <!-- End of main -->

            <div class="right">
                <div class="top">
                    <button id="menu-btn">
                        <span class="material-icons">menu</span>
                    </button>
                    <div class="profile">
                        <div class="info">
                            <b id="username">' .$_SESSION['user_name']. '</b>
                        </div>
                        <div class="profile-photo">
                            <img src="'. $_SESSION['userImage'] .'">
                        </div>
                    </div>
                </div>
                <!--end of top-->
                <div clsaa="right-btm">
                    

                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#appointmentDate", {
                enableTime: true,           // Cho phép chọn giờ
                time_24hr: true,            // Hiển thị giờ theo định dạng 24 giờ
                dateFormat: "Y-m-d H:i",    // Định dạng ngày thành dd-mm-yyyy giờ:phút
                minuteIncrement: 1          // Điều chỉnh gia số phút (mặc định là 5 phút)
            });
        </script>
    </body>
    </html>
    ');
    libxml_clear_errors();

    // $doctorName = $_GET['name'];
    // $doctorMajor = $_GET['medicalSpecialty'];

    // echo "doctorName: " .$doctorName;
    // echo "doctorMajor: " .$doctorMajor;   

    if (!empty($_SESSION['doctorName'])) {
        $name = $_SESSION['doctorName'];
        // Tạo đối tượng DOMXPath
        $xpath = new DOMXPath($dom);
        
        //Tìm <ul> với class "image-list grid-view"
        $olList = $xpath->query('//ol[@class="image-list grid-view"]');


        // Thực hiện truy vấn lấy tất cả thông tin của các bác sĩ
        $sql = "SELECT * FROM doctors where Name = '$name'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $newElementHTML = '
                    <li>
                        <figure>
                                <img src="'. htmlspecialchars($row["ImageLink"]) .'" alt="">
                            <figcaption>

                                        <p class="doctor-name">'. htmlspecialchars($row["Name"]) .'</p>

                                <p>Medical specialty: '. htmlspecialchars($row["MedicalSpecialty"]) .'</p>
                                <p>Degree: '. htmlspecialchars($row["Degree"]) .'</p>
                            </figcaption>
                        </figure>
                    </li>';
            
                // Tạo một tài liệu DOM mới để tải chuỗi HTML
                $tempDom = new DOMDocument();
                libxml_use_internal_errors(true); // Bỏ qua lỗi khi tải HTML
                $tempDom->loadHTML($newElementHTML);
                libxml_clear_errors();
            
                // Nhập phần tử <li> vào tài liệu DOM chính
                $newElement = $dom->importNode($tempDom->getElementsByTagName('li')->item(0), true);
                
                // Thêm phần tử mới vào <ol>
                $olList->item(0)->appendChild($newElement);
                // $dateList->item(0)->appendChild($newElement);

            }
        }
        // echo $dom->saveHTML();

    }else{
        // echo "Không có dữ liệu.";
    }
    
    $xpath = new DOMXPath($dom);
        
    //Tìm <ul> với class "image-list grid-view"
    $dateList = $xpath->query('//tbody[@id="rows"]');
    // $dateList = $xpath->query('//div[@id="testDiv"]');

//Truy van cuoc hen trong table meetingdate
    $sql_2 =  "
        SELECT  DATE_FORMAT(m.MeetingTime, '%d-%m-%Y') as meetingDate,
        DATE_FORMAT(m.MeetingTime, '%H:%i:%s') as meetingTime,
        m.Id as meetingId,
        m.LinkMeet as meetingLink,
        m.DateStatus as dateStatus,
        d.Name as doctorName,
        d.MedicalSpecialty as doctorMajor,
        u.Id as patientId
        FROM meetingdate m
        INNER JOIN users u ON m.PatientId = u.Id
        INNER JOIN doctors d ON m.DoctorId = d.Id
        AND u.name = '".$_SESSION['user_name']."';
    ";
    $patientId = "";
    $doctorId = "";
    $result_2 = $conn->query($sql_2);  
    if ($result_2->num_rows > 0) {  
        while ($row_2 = $result_2->fetch_assoc()) {
            $patientId = $row_2['patientId'];
            $newElementHTML = '
            <tr>
                <td><p>'. htmlspecialchars($row_2["meetingId"]) .'</p></td>
                <td><p>'. htmlspecialchars($row_2["meetingDate"]) .' | '. htmlspecialchars($row_2["meetingTime"]) .'</p></td>
                <td><p>'. htmlspecialchars($row_2["doctorName"]) .'</p></td>
                <td><p>'. htmlspecialchars($row_2["doctorMajor"]) .'</p></td>
                <td><a class = "meetingLink" href="'. htmlspecialchars($row_2["meetingLink"]) .'">Link</a></td>
                <td><p>'. htmlspecialchars($row_2["dateStatus"]) .'</p></td>
            </tr>
            ';

            // Tạo một tài liệu DOM mới để tải chuỗi HTML
            $tempDom = new DOMDocument();
            libxml_use_internal_errors(true); // Bỏ qua lỗi khi tải HTML
            $tempDom->loadHTML($newElementHTML);
            libxml_clear_errors();
        
            // Nhập phần tử <li> vào tài liệu DOM chính
            // $newElement = $dom->importNode($tempDom->getElementsByTagName('tr')->item(0), true);

            $newElement = $dom->importNode($tempDom->getElementsByTagName('tr')->item(0), true);

            
            // Thêm phần tử mới vào <ol>
            $dateList->item(0)->appendChild($newElement);

            // $olList->item(0)->appendChild($newElement);




        }
    }else {
        echo "Không có dữ liệu.";        
    }

//Lich hen hom nay
    $xpath = new DOMXPath($dom);
        
    //Tìm <ul> với class "image-list grid-view"
    $dateList = $xpath->query('//tbody[@id="rows_1"]');
    // $dateList = $xpath->query('//div[@id="testDiv"]');

//Truy van cuoc hen trong table meetingdate
    $isTodayMeeting = 0;
    $result_2 = $conn->query($sql_2);  
    if ($result_2->num_rows > 0) {  
        while ($row_2 = $result_2->fetch_assoc()) {
            $meetingDateStr = $row_2["meetingDate"]; 
            
            $meetingDate = DateTime::createFromFormat('d-m-Y', $meetingDateStr);
                      
            $today = new DateTime(); 

            if ($meetingDate->format('d-m-Y') == $today->format('d-m-Y')) {
                $isTodayMeeting = 1;
                $newElementHTML = '
                <tr>
                    <td><p>'. htmlspecialchars($row_2["meetingId"]) .'</p></td>
                    <td><p>'. htmlspecialchars($row_2["meetingDate"]) .' | '. htmlspecialchars($row_2["meetingTime"]) .'</p></td>
                    <td><p>'. htmlspecialchars($row_2["doctorName"]) .'</p></td>
                    <td><p>'. htmlspecialchars($row_2["doctorMajor"]) .'</p></td>
                    <td><a class = "meetingLink" href="'. htmlspecialchars($row_2["meetingLink"]) .'">Link</a></td>
                    <td><p>'. htmlspecialchars($row_2["dateStatus"]) .'</p></td>
                </tr>
                ';
    
                // Tạo một tài liệu DOM mới để tải chuỗi HTML
                $tempDom = new DOMDocument();
                libxml_use_internal_errors(true); // Bỏ qua lỗi khi tải HTML
                $tempDom->loadHTML($newElementHTML);
                libxml_clear_errors();
            
                // Nhập phần tử <li> vào tài liệu DOM chính
                // $newElement = $dom->importNode($tempDom->getElementsByTagName('tr')->item(0), true);
    
                $newElement = $dom->importNode($tempDom->getElementsByTagName('tr')->item(0), true);
    
                
                // Thêm phần tử mới vào <ol>
                $dateList->item(0)->appendChild($newElement);
    
                // $olList->item(0)->appendChild($newElement);
                
            }           
        }
    }else {
        echo "Không có dữ liệu Today meeting"; 
    }
    if ($isTodayMeeting==0){
        $xpath = new DOMXPath($dom);
        $appointmentToday = $xpath->query('//legend[@id="appointment-today"]');
        $element = $appointmentToday->item(0); // Lấy phần tử đầu tiên
        $element->nodeValue = "You don't have any appointments today"; // Thay đổi nội dung
    }  
    if (empty($_SESSION['doctorName'])){
        $xpath = new DOMXPath($dom);
        
        $doctorChooseLegend = $xpath->query('//legend[@id="doctor-choose"]');
        $element = $doctorChooseLegend->item(0); // Lấy phần tử đầu tiên
        $element->nodeValue = "You haven't choose a doctor.Go to Booking to set an appointment with a doctor"; // Thay đổi nội dung
        
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"&&!empty($_SESSION['doctorName'])&&!empty($_SESSION['doctorMajor'])&&!empty($_POST['appointmentDate'])) {
        $appointmentDate = $_POST['appointmentDate'];
        // Tách ngày và thời gian bằng cách sử dụng dấu cách
        list($date, $time) = explode(' ', $appointmentDate);
        $sql = "SELECT Id AS doctorId FROM doctors where Name = '".$_SESSION['doctorName']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $doctorId = $row['doctorId'];

        $sql_1 = "SELECT COUNT(*) AS total FROM meetingdate";
        $result_1 = $conn->query($sql_1);
        $row_1 = $result_1->fetch_assoc();
        $date_index = $row_1['total'] + 1;
        $sql_2 =  "
        INSERT INTO meetingdate values ('". $date_index ."','". $patientId ."','". $doctorId ."','". $appointmentDate ."','In progress','NOLINK". $date_index ."');
        ";
        $result_2 = $conn->query($sql_2);  
    }
    echo $dom->saveHTML();


?>

