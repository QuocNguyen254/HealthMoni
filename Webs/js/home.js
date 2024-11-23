
var arraySize = 7;

var request = new XMLHttpRequest(); 
var chart = null, title, rcd_title, rcd_color, rcd_data, rcd_date;
var username;
var dat_BPS, dat_Date;
let dat_HR = [];
var low_HR = 200, up_HR = 0, low_BPS = 200, up_BPS = 0;
const csvUrl2 = "https://docs.google.com/spreadsheets/d/1azhjFHceRSeBAMogVSAKg56ciFvxsHt6KbRCcl0vWeM/export?format=csv";
const interval2 = 0; //(tần suất cập nhật)

function get_data() {
    fetch(csvUrl2)
        .then(response => response.text())
        .then(data => {
            const rows = data.split("\n").map(row => row.split(","));
            
            // Log dữ liệu ra console
            console.clear(); // Xóa console trước đó
            console.log("Dữ liệu từ Google Sheets:");
            console.table(rows); // Hiển thị dưới dạng bảng (nếu trình duyệt hỗ trợ)
            low_HR = 200; 
            up_HR = 0; 
            low_BPS = 200;
            up_BPS = 0;
            rows.slice(1).forEach((row, index) => {
                let type = row[0];  // heartrate/spo2
                let date = row[1];  // datetime
                let value = row[2]; // value
                if (type && date && value && (index/2 | 0) < arraySize) {
                    if (type == "HeartRate") 
                    {
                        dat_HR[index/2 | 0] = value;
                        if (low_HR>Number(value)) low_HR=Number(value);
                        if (up_HR<Number(value)) up_HR=Number(value);
                    }
                    if (type == "SpO2")
                    {
                        dat_BPS[index/2] = value;
                        if (low_BPS>Number(value)) low_BPS=Number(value);
                        if (up_BPS<Number(value)) up_BPS=Number(value);
                    }
                    dat_Date[index/2] = date;
                }
            });
            // updateChart(type);
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu từ Google Sheets:", error));
}

// Gọi hàm lần đầu và lặp lại mỗi 5 giây
get_data();
setInterval(get_data, 0);

window.onload = function() {
    var tit2 = document.getElementById("dataChartTitle");
    tit2.textContent = "Default Chart";
    tit2.style.color = "#677483";

    // menu listener
    const sideMenu = document.getElementById("aside");
    const menuBtn  = document.getElementById("menu-btn");
    const closeBtn = document.getElementById("close-btn");

    menuBtn.addEventListener('click', () => {
        sideMenu.style.display = 'block';
    })

    closeBtn.addEventListener('click', () => {
        sideMenu.style.display = 'none';
    })

    console.log("arrSize: "+arraySize);

    setMenuHypertext();
    getUserInfo();
    updateUserInfo();
    // updateCardData();
    // updateChart('BP_S');
    // getAllRecord();
}

dat_BPS = [10,20,30,40,50,60,10];
dat_Date = ['11/20 02:54:36', '11/21 02:55:14', '11/22 02:55:53', '11/23 01:30:34', '11/23 01:43:23', '11/23 01:43:45', '11/23 02:56:31'];

function getUserInfo() {
    username = "name1";
}

function updateUserInfo() {
    var ui_username = document.getElementById("username");
    ui_username.textContent = username;
    try {
        document.getElementById("welcome").textContent = "Hi, " + username;
    } catch (error) {}
}

function getAllRecord() {
}

function updateCardData() {
    console.log("updateCardData()");
    var card_BPS    = document.getElementById("card_BPS");
    var card_HR     = document.getElementById("card_HR" );
    card_BPS.textContent    = (dat_BPS[arraySize-1]!=null?dat_BPS[arraySize-1]:0)   + " %" ;
    card_HR.textContent     = (dat_HR[arraySize-1]!=null ?dat_HR[arraySize-1]:0)     + " bpm"  ;
}

function updateChart(type) {
    if(chart!==null)chart.destroy();
    var ctx = document.getElementById("line-chart").getContext('2d');
    var tit = document.getElementById("dataChartTitle");
    window.scrollTo(0, 0);

    updateChartData(type);

    tit.style.color = rcd_color;
    tit.textContent = title;

    chart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: rcd_date,
			datasets: [{ 
				data: rcd_data,
				label: rcd_title,
				borderColor: rcd_color,
				fill: false
			}]
		}, 
        options: {
            title: {display: false}
        }
	});
    updateCardData(type);
    if(type == 'BP_S')  addBoundLine(chart, up_BPS, low_BPS);
    if(type == 'HR')    addBoundLine(chart, up_HR, low_HR);
}

function updateChartData(type){
    switch(type){
        case 'BP_S':
            title = "SpO2";
            rcd_title = "SpO2(%)";
            rcd_color = "#ff7782";
            rcd_data = dat_BPS;
            console.log(dat_BPS);
            break;
        case 'HR':
            title = "Heart Rate";
            rcd_title = "Heart Rate (bpm)";
            rcd_color = "#2E87A3";
            rcd_data = dat_HR;
            break;
    };
    rcd_date = dat_Date;
    console.log("updateChartData");
}


function addBoundLine(myChart, upperBound, lowerBound){
    myChart.data.datasets.push({ 
        data: Array(arraySize).fill(upperBound),
        label: "Upper Bound",
        borderColor: "#ff0000",
        pointRadius: 0,
        fill: false
    });
    myChart.data.datasets.push({ 
        data: Array(arraySize).fill(lowerBound),
        label: "Lower Bound",
        borderColor: "#0000ff",
        pointRadius: 0,
        fill: true,
    });
    myChart.update();
}