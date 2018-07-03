<?php 
    date_default_timezone_set ("ASIA/Taipei");
    $servername = "140.116.245.148";
    $username = "f74064088";
    $password = "amy0210amy";
    $database = "f74064088";
    $dbname = "reservation";
    
    // connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    session_start();
    $roomInf = $_SESSION['roomInf'];
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
<head>
    <meta charset="UTF-8">
<style>
    body{
        background:#FFDDAA;
    }
    #backButton{
        outline:none;
        background:#F5F5DC;
        height:50;
        width:200;
        border:none;
        cursor:pointer;
        text-align:center;
        font-size:18px;
    }
    #backButton:hover{
        background-color:#4682B4;
        color:white;
    }
</style>
</head>
<body>
    <?php 
        $name = (String)$_POST['name'];
        $number = $_POST['number'];
        $extrabed = $_POST['extrabed'];
        $gender = (string)$_POST['gender'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $others = $_POST['others'];

        for($x = 1; $x <= $howManyRoom; $x++){
            $room = $whichRoom[$x];
            $day = date("ymd");
            $date = DateTime::createFromFormat('ymd', date('ymd'));
            $temp = $whichDate[$x]-1;
            $date->modify("+".$temp." day");    
            $date = $date->format("ymd");

            $sql = "UPDATE  reservation 
                    SET people = $number,
                        name = '$name',
                        available = '2',
                        extrabed = '$extrabed',
                        gender = '$gender',
                        phone = '$phone',
                        email = '$email',
                        others = '$others'
                    WHERE room = $room AND check_in_date = $date";
            if($conn->query($sql))
            //成功送出資料畫面
                echo "
                <!-- 可以直接家html -->
                    <h1 align='center'>訂房成功!!</h>
                    <p align='center'>$name 顧客您好</p>
                    <p align='center'>請自行匯款</p>
                    <table align='center' width='500' height='200'>
                        <tr bgcolor='#f2f2f2'>
                            <th colspan='2'>匯款資訊</th>
                        </tr>
                        <tr bgcolor='#F5F5DC'>
                            <th>代碼</th>
                            <th>700</th>
                        </tr>
                        <tr bgcolor='#f2f2f2'>
                            <th>郵局</th>
                            <th>琉球郵局</th>
                        </tr>
                        <tr bgcolor='#F5F5DC'>
                            <th>局號</th>
                            <th>0071673</th>
                        </tr>
                        <tr bgcolor='#f2f2f2'>
                            <th>帳號</th>
                            <th>0113122</th>
                        </tr>
                        <tr bgcolor='#F5F5DC'>
                            <th>戶名</th>
                            <th>許貿喆</th>
                        </tr>
                    </table>
                    <p align='center'>
                        <a href='http://localhost/chooseRoom.php'><button type=\"button\" id = backButton>返回首頁</button></a>
                    </p> 
                ";
            //資料送出失敗畫面
            else
                echo "
                    <h1 align='center'>訂房失敗</h>
                    <p align='center'>請返回首頁再試一次</p>
                    <p align='center'>
                        <a href='http://localhost/chooseRoom.php'><button type=\"button\" id = backButton>返回首頁</button></a>
                    </p> 

                ";
            
        }
    ?>
</body>
</html>
