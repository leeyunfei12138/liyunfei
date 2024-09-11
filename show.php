<?php
session_start();
//连接数据库
include('dbconfig.php');
$link = @mysqli_connect(HOST, USER, PASS) or die('数据库连接失败');
mysqli_select_db($link, DBNAME);
mysqli_set_charset($link, 'utf8');

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>安溪旅游</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<div id="header">
    <div class="header">
        <h1><a href="./index.php"><img src="./images/logo1.png" alt="Travel"></a></h1>
        <div id="global_navi">
            <ul>
                <li class="current"><a href="index.php#head">首页</a></li>
                <li><a href="about.php">关于安溪</a></li>

                <?php
                if (!isset($_SESSION['admin_user'])) {
                    ?>
                    <li><a href="login.html">登录</a></li>
                    <li><a href="register.html">注册</a></li>
                    <?php

                } ?>
            </ul>
            <?php
            if (isset($_SESSION['admin_user'])){
            ?>
            <span class="userinfo"> <?php echo $_SESSION['admin_user']; ?> | <a
                        href="dologin.php?a=logout">注销</a> </span></div>
        <?php
        }


        $sql = "select * from picture where id=" . $_GET['id'];
        $result = mysqli_query($link, $sql);
        @$row = mysqli_fetch_assoc($result);
        ?>

    </div>
</div>
<!-- banner -->
<div>
   <img src="images/banner.jpg" width="100%">
</div>
<!-- banner -->
<!-- wrapper -->
<div id="wrapper">
    <h2><?php echo $row["name"]; ?></h2>

    <div style="text-align:center" id="point">

        <p><?php echo $row["sinfo"]; ?></p>
        <p><img src="<?php echo $row['pics']; ?>"></p>
        <p><?php echo $row["content"]; ?></p>
    </div>
</div>
<div class="footer">
    <div class="copy">版权所有</div>
</div>
<script type="text/javascript">
    function rollTo(id) {
        var obj = document.getElementById(id);
        window.scrollTo(0, obj.offsetTop - 86);
    }
</script>
</body>
</html>
