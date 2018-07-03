<?php
//客人選取房間檔
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
date_default_timezone_set ("ASIA/Taipei");
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="UTF-8">
<head>
<style type="text/css">
    body{
        background:#FFDDAA;
    }
    #sendButton{
        outline:none;
        background:#F5F5DC;
        height:50;
        width:200;
        border:none;
        cursor:pointer;
        text-align:center;
        font-size:18px;
    }
    #sendButton:hover {
        background-color:#4682B4;
        color:white;
    }
    #leftButton{
        outline:none;
        background:#F5F5DC;
        height:50px;
        width:200px;
        border:none;
        cursor:pointer;
        text-align:center;
        font-size:18px;
    }
    #leftButton:hover {
        background-color:#4682B4;
        color:white;
    }
    #rightButton{
        outline:none;
        background:#F5F5DC;
        height:50px;
        width:200px;
        border:none;
        cursor:pointer;
        text-align:center;
        font-size:18px;
    }
    #rightButton:hover {
        background-color:#4682B4;
        color:white;
    }
    .button1{
        margin:10px;
        outline:none;
        border-radius: 19px;
        background:#9ACD32;
        height:108px;
        width:110px;
        cursor:pointer;
        font-size:50px;
        color:white;
    }
    .button1:hover{
        opacity:0.8;
    }
    .button2{
        margin:10px;
        outline:none;
        border-radius: 19px;
        height:108px;
        width:110px;
        background-image:url("res/img2.png");
        cursor:pointer;
    }
    .button2:hover{
        opacity:0.8;
    }
    .button-1{
        margin:10px;
        outline:none;
        border-radius: 19px;
        background:#A9A9A9;
        height:108px;
        width:110px;
        cursor:pointer;
        font-size:50px;
        color:white;
    }
    .button-1:hover{
        opacity:0.8;
    }
    .img1{
        border-radius:8px;
    }
    .img-1{
        border-radius:8px;
    }
    .sendtd{
        float:right;
    }
    
</style>
</head>
<body>
    <h1 align='center'><image src='res/header.png' width='200' height='100'></h>
<?php
    $day = date("ymd");
    for($x = 0; $x < 14; $x++){
        $date = DateTime::createFromFormat('ymd', $day);
        $date->modify("+".$x." day");
        $date = $date->format("ymd");
        $sql = "SELECT * FROM $dbname Where check_in_date = $date";
        $result = $conn->query($sql);
        $num = $result->num_rows;
        $count = 0;
        //check whether the table in the day has been created
        if($result->num_rows >= 6)
            continue;
        elseif ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $room[$count] = $row["room"];
                $count = $count+1;
            }
        } 
        for($y = 1; $y <= 6; $y++){
            //check whether the table has been established
            $flag = 0;
            for($z = 0; $z < $result->num_rows; $z++){
                if($y == $room[$z]){
                    $flag = 1;
                    break;
                }
            }
            if($flag == 1)
                continue;
            //if the table has not been established
            //creat an empty table
            $sql = "INSERT INTO reservation (check_in_date, room, available, extrabed)
                    VALUES ( $date, $y, '1', '0')";
            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    /* something will be used in the html */
    //store the room information (roomInf[14][6])
    //this will be used in the html
    $roomInf[14][6] = 0;
    for($x = 1; $x <= 14; $x++){
        $count = 1;
        $sum = $x-1;
        $date = DateTime::createFromFormat('ymd', $day);
        $date->modify("+".$sum." day");
        $date = $date->format("ymd");
        $sql = "SELECT * FROM $dbname Where check_in_date = $date";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $roomInf[$x][$count] = $row["available"];
            $count = $count+1;
        }
    }
    /**********************************   make html table  *******************************************/
    //a week start from monday
    //if today is monday, then we only need 2 page to show all the room information
    if(date("N" == "1"))
        $howManyPage = 2;
    else
        $howManyPage = 3;
    //title table
    echo "
    <table align='center'>
        <tr bgcolor='#F5F5DC'>
            <th colspan='2'> 
                <button type=\"button\" id = leftButton>上一週</button> 
            </th>
            <th colspan='5'> 
                date
            </th>
            <th colspan='2'> 
                <button type=\"button\" id = rightButton>下一週</button> 
            </th>
        </tr>
        ";
    
    //date table
    echo "
        <tr bgcolor='#f2f2f2'>
            <th>圖片</th>
            <th>房型</th>
            <th>一</th>
            <th>二</th>
            <th>三</th>
            <th>四</th>
            <th>五</th>
            <th>六</th>
            <th>日</th>
        </tr>
    ";    
    for($y = 0; $y < 6; $y++){
        for($x = 0; $x <= 7; $x++){
            $sum = $y*7+$x;
            if($x == 0){
                switch($y){
                    //房間名稱
                    case 0:{
                        echo "<tr bgcolor=#F5F5DC>
                            <td>
                                <a href='res/room1.jpg'><img src='res/room1.jpg' width='150' height='150'></a>
                            </td>
                            <td align='center'>
                            <p>浪漫公主(VIP雙人房)</p>
                            <p>NT$2800</p>
                            </td>";    
                                                   
                        break;
                    }
                    case 1:{
                        echo "<tr bgcolor=#f2f2f2>
                            <td>
                                <a href='res/room2.jpg'><img src='res/room2.jpg' width='150' height='150'></a>
                            </td>
                            <td align='center'> 
                            <p>甜蜜花漾(VIP雙人房)</p>
                            <p>NT$2800</p> 
                            </td>";
                        break;
                    }
                    case 2:{
                        echo "<tr bgcolor=#F5F5DC>
                            <td>
                                <a href='res/room3.jpg'><img src='res/room3.jpg' width='150' height='150'></a>
                            </td>
                            <td align='center'> 
                            <p>自然恬雅(雙人房)</p>
                            <P>NT$2800</p> 
                            </td>";
                        break;
                    }
                    case 3:{
                        echo "<tr bgcolor=#f2f2f2>
                            <td>
                                <a href='res/room4.jpg'><img src='res/room4.jpg' width='150' height='150'></a>
                            </td>
                            <td align='center'> 
                            <p>夢幻奇想(四人房)</p>
                            <p>NT$4600</p> 
                            </td>";
                        break;
                    }
                    case 4:{
                        echo "<tr bgcolor=#F5F5DC>
                            <td>
                                <a href='res/room5.jpg'><img src='res/room5.jpg' width='150' height='150'></a>
                            </td>
                            <td align='center'>
                            <p>經典風華(六人房)</p>
                            <p>NT$6000</p> 
                            </td>";
                        break;
                    }
                    case 5:{
                        echo "<tr bgcolor=#f2f2f2>
                            <td>
                                <a href='res/room6.jpg'><img src='res/room6.jpg' width='150' height='150'></a>
                            </td>
                            <td align='center'> 
                            <p>溫馨幸福(六人房)</p>
                            <p>NT$6000</p> 
                            </td>";
                        break;
                    }
                }
            }
            else{
                //button name is .$sum.Button
                //day after today
                if($x >= (int)date("N")){
                    $num = $roomInf[$x+1-(int)date("N")][$y+1];
                    switch($num){
                        case 1:{
                            //空房預設畫面
                            echo "
                                <td>
                                    <button type=\"button\" class=\"button1\" id = ".$sum."Button>".$num."</button>
                                </td>";
                            break;
                        }
                        case 2:{
                            //已訂房未付款
                            echo "
                                <td>
                                    <button type=\"button\" class=\"button2\" id = ".$sum."Button></button>
                                </td>";
                            break;
                        }
                        case 0:{
                            //已訂房已付款
                            echo "
                                <td>
                                    <button type=\"button\" class=\"button2\" id = ".$sum."Button></button>
                                </td>";
                            break;
                        }
                        default:
                            break;
                    }
                }
                //day before today
                /*這個else是在今天之前*/
                else{
                    echo "<td>
                            <button type=\"button\" class=\"button-1\" id = ".$sum."Button> x </button>
                        </td>";
                }
            }
            if($x == 7){
                echo "</tr>";
            }
        }
    }
    echo "</table>";
    echo "
        <table align='center'>
            <tr>
                <td>
                    <p><image src='res/img2.png' width='50' height='50'></p>
                    <p align='center'>已預定</p>
                </td>
                <td>
                    <p><image src='res/img1.png' width='50' height='50' class=\"img1\"></p>
                    <p align='center'>空房</p>
                </td>
                <td>
                    <p><image src='res/img-1.png' width='50' height='50' class=\"img-1\"></p>
                    <p align='center'>未開放</p>
                </td>
                <td class=\"sendtd\">
                    <button type=\"button\" class=\"sendButton\" id = sendButton>送出</button>
                </td>
            </tr>
        </table>";
    //end the table
    /******************** here is javascript **************************/
    echo"<script>";
    echo"
            var startDay = ".(int)date("N").";";
    echo"   let roomInfor = [];";
            for($x = 0; $x <= 13; $x++){
                for($y = 1; $y <= 6; $y++){
                    echo "
                    roomInfor.push(".$roomInf[$x+1][$y].");" ;
                }
            }
    /*** control which page ***/
    echo"
            var page = 1;
            var maxPage = ".$howManyPage.";
            maxPage = Number(maxPage);
            document.getElementById(\"leftButton\").onclick = function() {leftFcn()};
            function leftFcn() {
                var x = 0;
                var a = 0;
                if(page > 1){
                    page = page-1;
                    //window.alert(page);
                    if(page == 1){
                        //the day before today";
    //the day before today in page 1 
    /*改頁面後不在14天的範圍內*/                
    for($x = 1; $x <= 42; $x++){
        if($x%7 < (int)date("N") && $x%7 != 0){
        echo"
                            var b = document.getElementById('".$x."Button');
                            //below can be rewrited
                            //what to do the day before today
                            //remember the b.
                            b.innerHTML = 'x';
                            b.style.background='#A9A9A9';
                            b.style.fontSize='50px';                          

            ";
        }
    //the day after today in page 1 第一個禮拜(按過leftButton後)
    //範圍確定在14天之內                         
        else{
        echo"
                            var b = document.getElementById('".$x."Button');
                            //what to do the day before today
                            //remember the b.
                            if($x%7 == 0)
                                a = 7;
                            else
                                a = $x%7; 
                                //roomInfor[Math.ceil($x/7)+];
                            switch (roomInfor[Math.floor(($x-1)/7) + (a-startDay)*6]){
                                //已預訂已付款
                                case 0:
                                    //below can be rewrited
                                    //be reserved, paid
                                    b.innerHTML = '';
                                    b.style.backgroundImage='url(\'res/img2.png\')';
                                    break;
                                
                                //空房
                                case 1:
                                    //below can be rewrited
                                    //available
                                    b.innerHTML = '1';
                                    b.style.fontSize='50px';
                                    b.style.color='white';
                                    b.style.background='#9ACD32';
                                    break;
                                //已預訂未付款
                                case 2:
                                    //below can be rewrited
                                    //be reserved, not paid
                                    b.innerHTML = '';
                                    b.style.backgroundImage='url(\'res/img2.png\')';
                                    break;
                            }
                ";
        }
    }                                               
                        
    echo"
                    }
                    else{";
    //the day in other page (all in the 14 days)第二個禮拜(按過leftButton後)
    for($x =  1; $x <= 42; $x++){
    echo"
                            var b = document.getElementById('".$x."Button');
                            if($x%7 == 0)
                                a = 7;
                            else
                                a = $x%7; 
                            switch (roomInfor[(8-startDay)*6 + Math.floor(($x-1)/7) + (a-1)*6]){
                                //已予定已付款
                                case 0:
                                    //below can be rewrited
                                    //be reserved, paid
                                    b.innerHTML = '';
                                    b.style.backgroundImage='url(\'res/img2.png\')';
                                    break;
                                //空房
                                case 1:
                                    //below can be rewrited
                                    //available
                                    b.innerHTML = '1';
                                    b.style.fontSize='50px';
                                    b.style.color='white';
                                    b.style.background='#9ACD32';
                                    break;
                                //已預訂未付款
                                case 2:
                                    //below can be rewrited
                                    //be reserved, not paid
                                    b.innerHTML = '';
                                    b.style.backgroundImage='url(\'res/img2.png\')';
                                    break;
                            }
                ";
    }
    
    echo"
                    }
                }
            }
            document.getElementById(\"rightButton\").onclick = function() {rightFcn()};
            function rightFcn() {
                var a = 0;
                if(page < maxPage){
                    page = page+1;
                    //window.alert(page);
                    if(page == maxPage){";
    for($x = 1; $x <= 42; $x++){
        if($x%7 == 0)
            $a = 7;
        else
            $a = $x%7; 
        //day after the last day
        if($a >= (int)date("N")){
        //超出14天範圍外
        echo"
                        var b = document.getElementById('".$x."Button');
                        //below can be rewrited
                        //what to do the day before today
                        //remember the b.
                        b.innerHTML = 'x';
                        b.style.background='#A9A9A9';
                                                
                        
            ";
        }
        //the day before the last day in maxPage                          
        else{
        echo"
                        var b = document.getElementById('".$x."Button');
                        //what to do the day before today
                        //remember the b.
                        if($x%7 == 0)
                            a = 7;
                        else
                            a = $x%7; 
                        switch (roomInfor[(8-startDay)*6 + (page-2)*42 +  Math.floor(($x-1)/7) + (a-1)*6]){
                            //已預訂已付款
                            case 0:
                                //below can be rewrited
                                //be reserved, paid
                                b.innerHTML = '';
                                b.style.backgroundImage='url(\'res/img2.png\')';
                                break;
                            //空房
                            case 1:
                                //below can be rewrited
                                //available
                                b.innerHTML = '1';
                                b.style.background='#9ACD32';
                                break;
                            //已預訂未付款
                            case 2:
                                //below can be rewrited
                                //be reserved, not paid
                                b.innerHTML = '';
                                b.style.backgroundImage='url(\'res/img2.png\')';
                                break;
                        }
            ";
        }
    }                                               
    echo"
                    }
                    else{";
    //the day in other page (all in the 14 days)(第一次按rightButton)
    for($x =  1; $x <= 42; $x++){
        echo"
                        var b = document.getElementById('".$x."Button');
                        if($x%7 == 0)
                            a = 7;
                        else
                            a = $x%7; 
                        switch (roomInfor[(8-startDay)*6 + Math.floor(($x-1)/7) + (a-1)*6]){
                            case 0:
                                //below can be rewrited
                                //be reserved, paid
                                b.innerHTML = '';
                                break;
                            case 1:
                                //below can be rewrited
                                //available
                                b.innerHTML = '1';
                                b.style.background='#9ACD32';
                                b.style.color='white';
                                b.style.fontSize='50px'
                                break;
                            case 2:
                                //below can be rewrited
                                //be reserved, not paid
                                b.innerHTML = '';
                                b.style.backgroundImage='url(\'res/img2.png\')';
                                break;
                        }
                ";
    }
    echo"
                    }//else
                }
            }";
    /*** store the room information ***/ 
      
    echo"
            var howManyReserve = 0;
            let reservationRoom = [];
            let isClicked = [];
            for(var x = 0; x<42; x++){
                isClicked.push(0);
            }
            ";
    
    /*** deside what to do after click room button ***/
   
    for($x = 1; $x <= 42; $x++){
        $temp = $x % 7;
        if($temp == 0)
            $temp = 7;
        $whichRoom = ((int)(($x-1)/7) + 1)*100;
        echo"
            document.getElementById(\"".$x."Button\").onclick = function() {button".$x."Fcn()};";
        echo"
            function button".$x."Fcn(){
                var temp = $temp;
                var whichRoom = $whichRoom;
                //page 1
                if(page == 1){
                    //day before today here
                    //比今天前面的日期 不能按
                    if( temp < startDay){
                        return;
                    }
                    //the room is reserved and paid money
                    //已預訂已付款 不能按
                    else if(roomInfor[(temp - startDay)*6 + whichRoom/100 -1] == 0){
                        return;
                    }
                    //the room is reserved and not paid money
                    //已預訂未付款  不能按
                    else if(roomInfor[(temp - startDay)*6 + whichRoom/100 -1] == 2){
                        return;
                    }
                    //the button has been clicked
                    //空房 取消
                    else if( isClicked[(temp - startDay)*6 + whichRoom/100 -1] == 1){
                        let deleteChoice = [];
                        howManyReserve--;
                        for(var x = 0; x <howManyReserve; x++){
                            if(reservationRoom[x] == whichRoom + temp + 1 - startDay)
                            deleteChoice.push(x);
                        }
                        delete reservationRoom[deleteChoice[1]];
                        delete reservationRoom[deleteChoice[0]];
                        isClicked[(temp - startDay)*6 + whichRoom/100 -1] = 0;
                        var b = document.getElementById('".$x."Button');
                        b.innerHTML = '1';
                        b.style.fontSize='50px';                       
                        return;
                    }
                    //day after today and the room is available
                    //空房 預定
                    else if(roomInfor[(temp - startDay)*6 + whichRoom/100 -1] == 1){
                        reservationRoom.push( whichRoom + temp + 1 - startDay);
                        howManyReserve++;
                        //window.alert(reservationRoom[howManyReserve-1]);
                        isClicked[(temp - startDay)*6 + whichRoom/100 -1] = 1;
                        var b = document.getElementById('".$x."Button');
                        b.innerHTML = '請按送出';
                        b.style.fontSize='35px';
                        return;
                    }
                }
                //other page
                else{
                    //day behind after 14 days
                    //不再14天的範圍內 不能按
                    if( temp >= startDay && page == maxPage){
                        return;
                    }
                    //the room is reserved and paid money
                    //已預訂已付款 不能按
                    else if(roomInfor[(8-startDay)*6+(temp-1)*6+(page-2)*42+whichRoom/100 -1] == 0){
                        return;
                    }  
                    //the room is reserved and not paid money
                    //已預訂未付款 不能按
                    else if(roomInfor[(8-startDay)*6+(temp-1)*6+(page-2)*42+whichRoom/100 -1] == 2){
                        return;
                    } 
                    //the button has been clicked
                    //空房 取消
                    else if(isClicked[(8-startDay)*6+(temp-1)*6+(page-2)*42+whichRoom/100 -1] == 1){
                        let deleteChoice = [];
                        howManyReserve--;
                        for(var x = 0; x <howManyReserve; x++){
                            if(reservationRoom[x] == whichRoom + temp + 1 - startDay)
                            deleteChoice.push(x);
                        }
                        delete reservationRoom[deleteChoice[1]];
                        delete reservationRoom[deleteChoice[0]];
                        isClicked[(8-startDay)*6+(temp-1)*6+(page-2)*42+whichRoom/100 -1] = 0;
                        
                        var b = document.getElementById('".$x."Button');
                        b.innerHTML = '1';
                        b.style.fontSize='50px';
                        return;
                    }
                    //day before last day and room is available
                    //空房 預定
                    else if(roomInfor[(8-startDay)*6+(temp-1)*6+(page-2)*42+whichRoom/100 -1] == 1){
                        reservationRoom.push( whichRoom + 8 - startDay + temp + (page-2)*7);
                        howManyReserve++;
                        isClicked[(8-startDay)*6+(temp-1)*6+(page-2)*42+whichRoom/100 -1] = 1;
                        //window.alert(reservationRoom[howManyReserve-1]);
                        var b = document.getElementById('".$x."Button');
                        b.innerHTML = '請按送出';
                        b.style.fontSize='35px';
                        return;
                    }
                }      
            }";
    }
    /*** send all the information to another window ***/
    echo"
        document.getElementById(\"sendButton\").onclick = function() {sendFcn()};
        function sendFcn(){
            var a = \"?roomNum=\";
            if(howManyReserve > 0){
                for(var x = 0; x < howManyReserve; x++)
                    a = a + reservationRoom[x].toString();
                window.open('./consumerInformation.php'+a, '_self');
            }
            else{
                //沒有訂房卻送出
            }
        }
        ";
    
    
    echo"</script>";
    /********************************************************/  
?> 
</body>
</html>