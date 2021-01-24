<html>
    <head>
        <title>Install</title>
        <style>div{color:red;font-size:40px}</style>
    </head>
    <body>
        <?php 
        if(false){
            echo "<div>您的服务器似乎并不支持PHP，请安装PHP后再安装</div>";
        };
        ?>
        
        <?php
          if (!fopen("../sys/wi","r")){
              fclose();
              die ("已经安装，如果您是安装过程中退出或出现错误请先删除安装根目录下的/sys/sys_info.php、/sys/wi和数据库中的**_SysTable、**_TableInfo表，之后再运行安装程序");
              
          }else{
              fclose ();
          }
        
        /*获取表单数据*/
        $dbserver = $_POST["dbserver"];
        $dbuser = $_POST["dbuser"];
        $dbpass = $_POST["dbpass"];
        $db = $_POST["db"];
        $dbprefix = $_POST["dbprefix"];
        $name = $_POST["name"];
        $password = $_POST["password"];
        
        
        /*尝试连接服务器*/
        $conndb = mysqli_connect($dbserver,$dbuser,$dbpass,$db);
        if ($conndb){
            echo "数据库连接成功";
        }else{
            die("数据库连接失败，错误信息:".mysqli_connect_error());
        }
        
        /*尝试写入文件*/
        $file = fopen("../sys/info.php","w+") or die("无法打开文件，已退出安装");
        $d = "<?php define(\"dbserver\",\"".$dbserver."\");\n"."define(\"dbuser\",\"".$dbuser."\");\n"."define(\"dbpass\",\"".$dbpass."\");\n"."define(\"db\",\"".$db."\");\n"."define(\"dbprefix\",\"".$dbprefix."\"); ?>";
        $w = file_put_contents("../sys/info.php",$d);
        /*关闭文件使用*/
        fclose($file);
        
        /*计算token*/
        $token = md5(crypt($name.",".$password,"asanatsa"));//连salt用的都是asanatsa(小声bb)
        
        /*创建表并插入值*/
        /*表信息*/
        $ct = "CREATE TABLE " .$dbprefix."TableInfo(id int NOT NULL AUTO INCREMENT PRIMARY,name varchar(255) NOT NULL,key text NOT NULL,can_write int NOT NULL)";
        if(mysqli_query($conndb,$ct)){
            echo "数据表成功创建";
        }else{
            die("数据表创建失败，已退出安装，错误信息".mysql_error());
        }
        
        /*系统信息*/
        $ct = "CREATE TABLE " .$dbprefix."SysValue(name varchar(40) NOT NULL,value varchar(255) NOT NULL)";
        if(mysqli_query($conndb,$ct)){
            echo "数据表成功创建";
        }else{
            die("数据表创建失败，已退出安装，错误信息".mysql_error());
            mysqli_close($conndb);
        }
        
        if(!$y = $conndb -> prepare("INSERT INTO ".$dbprefix."SysValue(?,?)")){
            die("写入数据库出现错误，已退出安装");
        }
        $vname = "";
        $vvalue = "";
        $y -> bind_param("ss",$name,$value);
        
        $vname = "max_request_time";
        $vvalue = "20";
        $y -> execute();
        
        /*
        $vname = "max_write_time";
        $vvalue = "5";
        $y -> execute();
        */
        
        $vname = "ban_time";
        $vvalue = "20";
        $y -> execute();
        
        $vname = "g_html_tag";
        $vvalue = "false";
        $y -> execute();
        
        $vname = "admin_token";
        $vvalue = $token;
        $y -> execute();
        $y -> close();
        
        /*写入文件*/
        $d = fopen("../sys/wi","w+");
        fclose($d);
        
        /*关闭MySQL连接*/
        mysqli_close($conndb);
        
        echo "安装完成，您的token为：".$token."。此为您登录的唯一凭证，请妥善保存，以免泄露造成安全问题";
        echo "请安装安卓端进行管理，或参阅我们的api文档使用api进行管理";
        
        ?>
    </body>
</html>
