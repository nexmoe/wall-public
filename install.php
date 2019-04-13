<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8">
    <title>墙 - 安装程序</title>
    <meta name="description" content="匿名表白墙程序 GitHub：https://github.com/nexmoe/wall-public">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        body {
            margin: 0;
            padding-bottom: 60px;
        }
        header {
            background-color: #f8f9fa;
            width: 100%;
            padding: 60px;
            box-sizing: border-box;
        }
        .container {
            width: 400px;   
            margin: auto;
        }
        h3,p {
            margin: 10px 0;
        }
        h3 {
            color: #454d5d;
            margin-top: 30px;
        }
        p {
            color: #5755d9;
        }
        h3::before {
            content: "# ";
            color: #e06870;
        }
        input {
            box-sizing: border-box;
            border-radius: 5px;
            padding: 12px;
            border: 2px solid #454d5d;
            width: 400px;
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>安装程序</h1>
        </div>
    </header>
    <div class="container">
        <form action="install.php" method="post">  
            <h3>填写主机</h3>
            <input type="text" name="host" value="localhost">
            <p>数据库 IP 地址或者 链接 如：127.0.0.1，或：example.com，本地主机为 localhost</p>
            
                <h3>连接数据库的用户名</h3>
                <input type="text" name="user">
                <p>数据库用户名 如：root</p>
                 
            <h3>连接数据库的密码</h3>
            <input type="text" name="password">
                <p>数据库密码 如：root</p>
                
                <h3>要创建的数据库表名</h3>
                <input type="text" name="dbname">
                <p>本程序数据库表 如：wall</p>
                
            <h3>新浪微博账号</h3>
            <input type="text" name="sina_username">
            <p>新浪微博账号，用于图床</p>
            
                <h3>新浪微博密码</h3>
                <input type="text" name="sina_password">
                <p>新浪微博密码，用于图床</p>
                
            <br>
            <input type="submit" name="install" value="安装">  
        </form>
    </div>
</body>

</html>

<?php
if($_POST['install']){
    if($_POST['host'] == NULL){
        echo "<script>alert('主机不可为空！')</script>";
        die();
    }
    $host=$_POST['host'];
    if($_POST['user'] == NULL){
        echo "<script>alert('数据库的用户名不可为空！')</script>";
        die();
    }
    $user=$_POST['user']; 
    if($_POST['password'] == NULL){
        echo "<script>alert('数据库的密码不可为空！')</script>";
        die();
    }
    $password=$_POST['password'];
    if($_POST['dbname'] == NULL){
        echo "<script>alert('数据库表名不可为空！')</script>";
        die();
    }
    
    $sina_username=$_POST['sina_username'];
    if($_POST['dbname'] == NULL){
        echo "<script>alert('新浪微博账号不可为空！')</script>";
        die();
    }
    $sina_password=$_POST['sina_password'];
    if($_POST['dbname'] == NULL){
        echo "<script>alert('新浪微博密码不可为空！')</script>";
        die();
    }
    
    $dbname=$_POST['dbname'];  
    $con = mysqli_connect($host,$user, $password);
    if (mysqli_connect_errno($con)) {
        echo "<script>alert('连接 MySQL 失败: " . mysqli_connect_error()."')</script>";
        die();
    }
    
    mysqli_query($con,"CREATE DATABASE `".$dbname."`;");
    mysqli_query($con,"USE `".$dbname."`;");
    
    $lines = file("wall.sql");
    $sqlstr = "";
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line != "") {
            if (!($line { 0
            } == "#" || $line { 0
            }
                .$line { 1
                } == "--")) {
                $sqlstr.= $line;
            }
        }
    }
    $sqlstr = rtrim($sqlstr,";");
    $sqls = explode(";",$sqlstr);
    
    foreach($sqls as $sql){
        mysqli_query($con,$sql);
    }
    
    $fp=fopen("config.php","wb");
    
    $config = "<?php return array (
      'hostname' => ".$host.", // 数据库 IP 地址或者 链接 如：127.0.0.1，或：example.com，本地主机为 localhost
      'username' => ".$user.", // 数据库用户名 如：root
      'password' => ".$password.", // 数据库密码 如：root
      'database' => ".$dbname.", // 本程序数据库表 如：wall
      'sina' => array(
        'username' => ".$sina_username.", // 新浪微博账号，用于图床
        'password' => ".$sina_password.", // 新浪微博密码，用于图床
      ),
    );";

    fwrite($fp,$config);

    fclose($fp);

    
    @unlink ("install.php");
    @unlink ("wall.sql");
    
    echo "<script>alert('安装成功！')</script>";

    header("location:/");
    
}