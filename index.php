<?php
session_start();
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
                <li class="current"><a href="#head">首页</a></li>
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
        ?>

    </div>
</div>
<!-- banner -->
<div id="main_visual">
    <div class="v">
        <div class="visual_box">
            <p><span>安溪概览</span>安溪县，古称清溪，位于福建省东南沿海，厦、漳、泉闽南金三角西北部，隶属泉州市。县域范围东经117°36′－118°17′，北纬24°50′－25°26′，东接南安市，西连华安县，南毗同安区，北邻永春县，西南与长泰区接壤，西北与漳平市交界。全县总面积3057.28平方千米，辖24个乡镇、488个村居，户籍人口121.2万人，常住人口100.4万人，有汉族、畲族等多个民族，通行普通话与闽南语。1985年被国家批准为首批沿海对外开放县之一，是台胞的主要祖籍地。
            </p>
        </div>
    </div>
</div>
<!-- banner -->
<!-- wrapper -->
<div id="wrapper">

    <div id="point">
        <h2>景点介绍</h2>
        <?php
        //连接数据库
        include('dbconfig.php');
        $link = @mysqli_connect(HOST, USER, PASS) or die('数据库连接失败');
        mysqli_select_db($link, DBNAME);
        mysqli_set_charset($link, 'utf8');

        $sql = "select * from picture order by createTime desc";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['id'] % 2 == 1) {
                ?>
                <div class="point_div">
                    <div class="figure"><img src="<?php echo $row['pics']; ?>" alt="" width="785" height="441"></div>
                    <div class="txt">
                        <h3> <?php echo $row['name']; ?></h3>

                        <p> <?php echo $row['sinfo']; ?></p>
                        <a href="show.php?id=<?php echo $row['id']; ?>">查看详情</a> </div>
                </div>
                <?php
            } else {
                ?>
                <div class="point_div">
                    <div class="f2"><img src="<?php echo $row['pics']; ?>" alt="" width="785" height="341"></div>
                    <div class="txt2">
                        <h3><?php echo $row['name']; ?></h3>

                        <p> <?php echo $row['sinfo']; ?></p>
                        <a href="show.php?id=<?php echo $row['id']; ?>">查看详情</a> </div>
                </div>
                <?php

            }
        }
        ?>
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
