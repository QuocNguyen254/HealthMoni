<?php
   include '../php/connect.php'; 
   session_start();
   $sql = "SELECT COUNT(*) AS total FROM doctors";
   $result = $conn->query($sql);

   // Kiểm tra kết quả
   if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // echo "Số lượng bác sĩ: " . $row['total'];
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
         <link rel="stylesheet" href="../css/style.css">
         <link rel="stylesheet" href="../css/doctors.css">
 
         <!-- Function -->
        <!--  <script src="../js/home.js"></script> -->
        <style>
            .doctor-name{
            color: black; /* Màu mặc định */
            transition: color 0.3s ease; /* Hiệu ứng chuyển màu mượt mà */
            }
            .doctor-name:hover {
            color: #2E87A3; /* Màu khi hover */
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
                     <a id="menu_booking" href="./booking.php">
                         <span class="material-icons">calendar_month</span>
                         <h3>Booking</h3>
                     </a>
                     <a id="menu_doctors" class="active" href="./doctor.php">
                         <span class="material-icons">diversity_1</span>
                         <h3>Doctors</h3>
                     </a>
                     <a id="menu_logout" href="../php/logout.php">
                         <span class="material-icons">logout</span>
                         <h3>Logout</h3>
                     </a>
                 </div>
             </aside>
 
             <!-----------Main------------>
             <main>
                 <div class="doctors">
                     <section class="gallery">
                         <div class="doc_container">
                         <div class="toolbar">
                             <div class="search-wrapper">
                             <input type="search" placeholder="Search for Doctors">
                             <div class="counter">
                                 Total results: <span id ="doctor-number"></span> 
                             </div>
                             </div>
                             <ul class="view-options">
                             <li class="zoom">
                                 <input type="range" min="180" max="400" value="280">
                             </li>
                             <li class="show-grid active">
                                 <button disabled>
                                 <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/grid-view.svg" alt="grid view">  
                                 </button>
                             </li>
                             <li class="show-list">
                                 <button>
                                 <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/list-view.svg" alt="list view">  
                                 </button>
                             </li>
                             </ul>
                         </div>
                         <ol class="image-list grid-view">

                         </ol>
                         </div>
                     </section>
                     
                     <footer>
                         <div class="doc_container">
                         </small>
                         </div>
                     </footer>
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
         <script src="../js/doctors.js"></script>
     </body>
     </html>
    ');
    libxml_clear_errors();
    
    // Tạo đối tượng DOMXPath
    $xpath = new DOMXPath($dom);
    
    // Tìm <ul> với class "image-list grid-view"
    $olList = $xpath->query('//ol[@class="image-list grid-view"]');
    $doctorNumberElement = $xpath->query('//*[@id="doctor-number"]')->item(0);
    $doctorNumberElement->nodeValue = $row['total'];
    // Thực hiện truy vấn lấy tất cả thông tin của các bác sĩ
    $sql = "SELECT * FROM doctors";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $newElementHTML = '
                 <li>
                     <figure>
                          <a href="booking.php?doctorName='. htmlspecialchars($row["Name"]) .'&medicalSpecialty='. htmlspecialchars($row["MedicalSpecialty"]). '" >
                              <img src="'. htmlspecialchars($row["ImageLink"]) .'" alt="">
                          </a>
                          <figcaption>
                              <a href="booking.php?doctorName='. htmlspecialchars($row["Name"]) .'&medicalSpecialty='. htmlspecialchars($row["MedicalSpecialty"]). '">
                                    <p class="doctor-name">'. htmlspecialchars($row["Name"]) .'</p>
                              </a>
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
        }
    }

    echo $dom->saveHTML();

} else {
    echo "Không có dữ liệu.";
}

?>

