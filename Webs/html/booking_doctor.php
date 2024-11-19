<?php
   include 'connect.php'; 
   session_start();


 
    $dom = new DOMDocument;

    // Để xử lý tốt hơn với HTML5
    libxml_use_internal_errors(true);
    if (isset($_GET['doctorName'])&& isset($_GET['medicalSpecialty'])){
        $_SESSION['doctorName'] = $_GET['doctorName'];
        $_SESSION['doctorMajor'] = $_GET['medicalSpecialty'];
    }
    $meetingId = "";
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
        <script src="../js/booking.js"></script>
        <style>
            .row-meeting {
                border: 2px solid ;
                transition: border-width 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            }
            .row-meeting:hover{
                border-width: 4px;
                border-color: #2E87A3; /* Thay đổi màu viền */
                box-shadow: 0 0 10px rgba(52, 152, 219, 0.6); /* Thêm bóng viền mờ */
            }
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
                    <a id="menu_home">
                        <span class="material-icons">home</span>
                        <h3>Home</h3>
                    </a>
                    <a id="menu_data">
                        <span class="material-icons">query_stats</span>
                        <h3>Dataview</h3>
                    </a>
                    <a id="menu_booking" class="active">
                        <span class="material-icons">calendar_month</span>
                        <h3>Booking</h3>
                    </a>
                    <a id="menu_logout">
                        <span class="material-icons">logout</span>
                        <h3>Logout</h3>
                    </a>
                </div>
            </aside>

            <!-----------Main------------>
            <main>               
                 <form action="booking_doctor.php" id="ft-form" method="POST" accept-charset="UTF-8">
                    <fieldset>
                        <legend id="appointment-today">Your appointments today</legend>
                    </fieldset>                   
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Patient name</th>
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
                                    <th>Patient name</th>
                                    <th>Meeting link</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="rows">
                            <tbody>

                        </table>
                    </div>
                    <fieldset>
                    <legend>Insert meeting link </legend>
                    <div class="two-cols">
                        <label>
                        Link
                        <input type="text" type="hidden" id = "meetingLink" name="MeetingLink" placeholder="Please enter meeting link" required>
                        </label>

                    </div>
                    </fieldset>
                    <div class="btns">
                        <input type="submit" value="Send link">
                        <input id="confirm-button" type="submit" name="ConfirmMeeting" value="Confirm meeting done">
                        <input id="confirm-button-available-meeting" type="submit" name="ConfirmMeetingAvailable" value="Confirm meeting">
                    </div>
                </form>
            </main>
            <!-- End of main -->

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
                            <b id="username">' .$_SESSION['user_name']. '</b>
                            <small class=""tect-muted>user</small>
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
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#appointmentDate", {
                enableTime: true,           // Cho phép chọn giờ
                time_24hr: true,            // Hiển thị giờ theo định dạng 24 giờ
                dateFormat: "Y-m-d H:i",    // Định dạng ngày thành dd-mm-yyyy giờ:phút
                minuteIncrement: 1          // Điều chỉnh gia số phút (mặc định là 5 phút)
            });
        </script>

        <script>
            const rows = document.querySelectorAll("#rows tr");
            rows.forEach(row => {
                row.addEventListener("click", () => {
                    alert("You chose this appointment");
                    const tds = row.querySelectorAll("td");

                    // Chuyển NodeList thành mảng (nếu cần)
                    const tdArray = Array.from(tds);
                    let meetingId = tdArray[0].textContent;

                    console.log(meetingId);
                    fetch("booking_doctor.php", {
                        method: "POST", // Gửi yêu cầu POST
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded" // Kiểu dữ liệu gửi đi
                        },
                        body: "meetingid=" + encodeURIComponent(meetingId) // Dữ liệu gửi đi (mã hóa URL)
                    })
                    .then(response => response.text()) // Đọc phản hồi từ server
                    .then(data => {
                        console.log("Phản hồi từ PHP: ", data); // Xử lý phản hồi từ PHP
                    })
                    .catch(error => {
                        console.error("Error:", error); // Bắt lỗi nếu có
                    });
                });
                
            });
        </script>   
        <script>
            const confirmButton =  document.getElementById("confirm-button");
            confirmButton.addEventListener("click", () => {
                    fetch("booking_doctor.php", {
                        method: "POST", // Gửi yêu cầu POST
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded" // Kiểu dữ liệu gửi đi
                        },
                        body: "confirmButton=yes" // Dữ liệu gửi đi (mã hóa URL)
                    })
                    .then(response => response.text()) // Đọc phản hồi từ server
                    .then(data => {
                        console.log("Phản hồi từ PHP: ", data); // Xử lý phản hồi từ PHP
                    })
                    .catch(error => {
                        console.error("Error:", error); // Bắt lỗi nếu có
                    });                           
            });
            const confirmButton_1 =  document.getElementById("confirm-button-available-meeting");
            confirmButton_1.addEventListener("click", () => {
                    fetch("booking_doctor.php", {
                        method: "POST", // Gửi yêu cầu POST
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded" // Kiểu dữ liệu gửi đi
                        },
                        body: "confirmButtonAvailableMeeting=yes" // Dữ liệu gửi đi (mã hóa URL)
                    })
                    .then(response => response.text()) // Đọc phản hồi từ server
                    .then(data => {
                        console.log("Phản hồi từ PHP: ", data); // Xử lý phản hồi từ PHP
                    })
                    .catch(error => {
                        console.error("Error:", error); // Bắt lỗi nếu có
                    });                           
            });
        </script>     
    </body>
    </html>
    ');
    libxml_clear_errors();

    // if (isset($_GET['doctorName'])) {
        // Tạo đối tượng DOMXPath
    
    $xpath = new DOMXPath($dom);
        
    //Tìm <ul> với class "image-list grid-view"
    $dateList = $xpath->query('//tbody[@id="rows"]');

//Truy van ten bac si
    $sql = "SELECT username AS doctorName FROM users where name = '".$_SESSION['user_name']."'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $doctorName = $row['doctorName'];
    // echo "doctorName: " . $doctorName;
//Truy van cuoc hen trong table meetingdate
    $sql_2 =  "
        SELECT  DATE_FORMAT(m.MeetingTime, '%d-%m-%Y') as meetingDate,
        DATE_FORMAT(m.MeetingTime, '%H:%i:%s') as meetingTime,
        m.Id as meetingId,
        m.DateStatus as dateStatus,
        u.username as patientName,
        m.LinkMeet as meetingLink
        FROM meetingdate m
        INNER JOIN users u ON m.PatientId = u.Id
        INNER JOIN doctors d ON m.DoctorId = d.Id
        AND d.Name = '" .$doctorName. "'
        ;
    ";
    $result_2 = $conn->query($sql_2);
    // $row_2 = $result_2->fetch_assoc();
    // echo "dateStatus: " . $doctorName;
    // echo "doctorName: " . $doctorName;
    // echo "doctorName: " . $doctorName;     
    if ($result_2->num_rows > 0) {  
        while ($row_2 = $result_2->fetch_assoc()) {
            $i = 1;
            $newElementHTML = '
            <tr class = "row-meeting">
                <td><p>'. htmlspecialchars($row_2["meetingId"]) .'</p></td>
                <td><p>'. htmlspecialchars($row_2["meetingDate"]) .' | '. htmlspecialchars($row_2["meetingTime"]) .'</p></td>
                <td><p>'. htmlspecialchars($row_2["patientName"]) .'</p></td>
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
                <tr class = "row-meeting-1">
                    <td><p>'. htmlspecialchars($row_2["meetingId"]) .'</p></td>
                    <td><p>'. htmlspecialchars($row_2["meetingDate"]) .' | '. htmlspecialchars($row_2["meetingTime"]) .'</p></td>
                    <td><p>'. htmlspecialchars($row_2["patientName"]) .'</p></td>
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
    if (isset($_POST['meetingid'])) {
        // Lấy giá trị 'username' từ POST
        $meetingId = $_POST['meetingid'];
        $_SESSION['meetingId'] = $meetingId;        
        echo "Meeting Id:  AHHAHAHAH" . $meetingId;
    } else {
        
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['MeetingLink'])) {
        // Tách ngày và thời gian bằng cách sử dụng dấu cách
        $meetingLink = $_POST['MeetingLink'];
        // echo "Meeting link:  " . $meetingLink;
        $sql_2 =  "
        UPDATE meetingdate
        SET LinkMeet = '". $meetingLink ."'
        Where Id = '". $_SESSION['meetingId'] ."'
        ;
        ";
        $result_2 = $conn->query($sql_2);  
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmButton'])) {
        // echo "CONFIRM";
        // echo "Meeting link:  " . $meetingLink;
        $sql_2 =  "
        UPDATE meetingdate
        SET DateStatus = 'Done'
        Where Id = '". $_SESSION['meetingId'] ."'
        ;
        ";
        $result_2 = $conn->query($sql_2);  
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmButtonAvailableMeeting'])) {
        // echo "CONFIRM";
        // echo "Meeting link:  " . $meetingLink;
        $sql_2 =  "
        UPDATE meetingdate
        SET DateStatus = 'Confirmed'
        Where Id = '". $_SESSION['meetingId'] ."'
        ;
        ";
        $result_2 = $conn->query($sql_2);  
    }
    echo $dom->saveHTML();


?>

