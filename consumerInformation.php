
<?php 
    //顧客輸入個人資料畫面檔
    date_default_timezone_set ("ASIA/Taipei");
    session_start();
    $roomInf = $_GET['roomNum'];
    $_SESSION["roomInf"] = $roomInf;
    $howManyRoom  = strlen($roomInf)/3;
    $whichRoom[$howManyRoom] = 0;
    $whichDate[$howManyRoom] = 0;
    for($x = 1; $x <= $howManyRoom; $x++){
        $whichRoom[$x] = substr($roomInf,($x-1)*3, 1);
        $temp = substr($roomInf,($x-1)*3+1, 1);
        if($temp == "0")
            $whichDate[$x] = (int)substr($roomInf,($x-1)*3+2, 1);
        else
            $whichDate[$x] = (int)substr($roomInf,($x-1)*3+1, 2);
    }
?>


<html>
<meta charset="UTF-8">
<head>
<style>
body{
    background:#FFDDAA;
}
input[type=text], select {
    width: 100%;
    height:5%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
input[type=submit] {   
    width: 50%;
    align:center;
    background-color: grey;
    color: white;
    padding: 14px 20px;
    margin: 8px 0px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    opacity:0.5;
}

div {
    margin:auto;
    width: 58%;
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 10px;
    text-align:center;
}
</style>
</head>
<body>
    <h1 align='center'><image src='res/header.png' width='200' height='100'></h>
    <table align='center'>
        <tr>
            <th><font size='5px' face='DFKai-SB'>訂房明細</th>
        </tr>
    </table>
<table align='center'>
        <form action = "./sendConsumerInf.php" method="post">
        <?php
        for($x = 1; $x <= $howManyRoom; $x++){
            $room = $whichRoom[$x];
            $day = date("ymd");
            $date = DateTime::createFromFormat('ymd', date('ymd'));
            $temp = $whichDate[$x]-1;
            $date->modify("+".$temp." day");    
            $date = $date->format("Y-m-d");

            switch ($room){
                case 1:{
                    $roomName = '浪漫公主(VIP雙人房)';
                    $roomPrice='2800';
                    break;
                }
                case 2:{
                    $roomName = '甜蜜花漾(VIP雙人房)';
                    $roomPrice='2800';
                    break;
                }                
                case 3:{
                    $roomName = '自然恬雅(雙人房)';
                    $roomPrice='2800';
                    break;
                }
                case 4:{
                    $roomName = '夢幻奇想(四人房)';
                    $roomPrice='4600';
                    break;
                }                
                case 5:{
                    $roomName = '經典風華(六人房)';
                    $roomPrice='6000';
                    break;
                }
                case 6:{
                    $roomName = '溫馨幸福(六人房)';
                    $roomPrice='6000';
                    break;
                }
            }

            /**************  which room *****************/
            echo"
            <table align='center' bgcolor='grey'>
                <tr>
                    <!-- date是訂房日期 -->
                    <th><font size='8px' face='verdana' color='white'>$date</font></th>
                    <!-- room是哪間房間 -->
                    <th><font size='8px' face='DFKai-SB' color='white'>$roomName</font></th>
                </tr>
                <tr bgcolor='#f2f2f2'>
                    <th><font size='8px' face='DFKai-SB'>房價</font></th>
                    <th><font size='8px' face='DFKai-SB'>NT$$roomPrice</font></th>
                </tr>
            </table>
            ";
        }
        ?>
        <table align='center'>
            <tr>
                <th><font size='5px' face='DFKai-SB'>聯絡資料</th>
            </tr>
        </table>
        <div>
            <label for="Name">姓名</label>
            <input type="text" name="name" id="Name" placeholder="姓名(必填)">
            <label for="Gender">性別</label>
            <input type="text" name="gender" id="Gender" placeholder="F/M">
            <label for="Phone">連絡電話</label>
            <input type="text" name="phone" id="Phone" placeholder="電話(必填)，例如:0910XXXXXX">
            <label for="Email">電子信箱</label>
            <input type="text" name="email" id="Email" placeholder="電子信箱(必填)">
            <label for="Number">人數</label>
            <input type="text" name="number" id="Number" placeholder="共多少人入住">
            <label for="Extrabed">加床</label>
            <input type="text" name="extrabed" id="Extrabed" placeholder="加床數(加一張床500元)">
            <label for="Others">備註</label>
            <input type="text" name="others" id="Others" placeholder="備註(希望民宿主人知道的事)">
            <input type = submit value = "確認">
            
        </div>

 
    <script>
    </script>
</body>
</html>
