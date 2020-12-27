<?php 
    if (!fopen("../sys/wi","r")){
              fclose();
          }else{
              fclose ();
              die ("{\"code\":3,\"msg\":\"未安装\",\"result\":null}");
          }
    /**/
    require "../sys/info.php";
    require "../sys/unsqli.php";
    $mode = $_GET["mode"];
    $tablen = $_GET["table"];
    $id = $_GET["id"];
    $word = $_GET["keyword"];
    
    
    /**/
    switch($mode){
        case "id":
            byId($id,$n);
        break;
        
        case "keyword":
            byKeyword($id,$keyword,$n);
        break;
        case "table":
            byTable($table,$n);
        break;
        
        case "write":
            writeTable();
        break;
        
        default:
            die ("{\"code\":1,\"msg\":\"非法模式名称\",\"result\":null}");
        break;
    };
    
    if(! $conn = mysqli_connect(dbserver,dbuser,dbpass,db)){
        die("{\"code\":2,\"msg\":\"无法连接数据库\",\"result\":null}");
        
    }
    function byId($fid,$fnum){
        addLog($ip,"byId");
        /*if(is_int($fnum) == true && $fnum > 0){*/
            $sql = "SELECT value FROM ".dbprefix."TableInfo WHERE id = \"".$id."\"";
            $r = mysqli_query($conn,$sql);
            if(mysqli_num_rows($r) > 0){
                $c = mysqli_fetch_assoc($r);
                $v= json_decode($c["value"]);
            }else{
                die("{\"code\":4,\"msg\":\"没有找到表\",\"result\":null}");
            }
            if(is_int($fnum) == true && $fnum > 0){
                $sqla = 
            }
    }
        ?>