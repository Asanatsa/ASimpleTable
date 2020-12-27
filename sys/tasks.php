<?php 

ignore_user_abort();
set_time_limit(0);
ini_set("memory_limit","100M");//限制使用内存
require "../sys/info.php";

/*自定义函数区*/
function cleanOverdueLog(){
    if(!$conn = mysqli_connect(dbserver,dbuser,dbpass,db)){
             die("无法连接数据库，错误码:2");
    }
    
    $j = mysqli_query($conn,"SELELT value FROM ".dbprefix."SysValue WHERE name = \"max_request_time\"");
    if (mysqli_num_rows($j) > 0){
        while($row = mysqli_fetch_assoc($j)){
            $a = $row["value"];
        }
    }
    $b = time() - $a * 60;
    $s = "DELETE FROM ".dbprefix."RequestLog WHERE time < ".$b;
    mysqli_query($conn,$s);
    mysqli_close($conn);
}


$timeout = 30 * 60;//每次执行间隔的时间，单位为秒。建议不要过小，防止服务器负担加=重
while(true){
    /*Your function here*/
    
    
    sleep($timeout);
}

?>