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
    <h2>人口数量</h2>
    <p>
        截至2021年末，安溪县有常住人口100.2万人，人口出生率9.1‰，死亡率7.4‰，自然增长率1.6‰。户籍人口120.72万人，其中男性64.40万人，占53.35%，女性56.32万人，占比46.65%。18岁以下325314人，18~34岁277146人，35~59岁437788人，60岁及以上166986人。 </p>
    <h2>历史文化</h2>
    <h3 style="text-align:left">茶文化铁观音</h3>
    <p>
        安溪产茶始于1725。安溪铁观音天下闻名，安溪县的乌龙茶制作技艺（铁观音制作技艺）被列入国家级非物质文化遗产名录。安溪是中国古老的茶区，铁观音境内生长着不少古老野生茶树，茶叶在蓝田，剑斗等地发现的野生茶树树高7米，树冠达3.2米，据专家考证，已有1000多年的树龄。安溪茶叶通过“海上丝绸之路”走向世界，畅销海外。</p>
    <p>台湾乌龙茶由安溪传入，随着乌龙茶传入台湾，安溪的茶俗也传入台湾。以茶王赛、茶文化交流会等民间习俗加强与台湾同胞的交流往来，如今已成为安台加深联系和乡情的重要方式。 </p>
    <h3 style="text-align:left">安溪台湾妈祖文化基地</h3>
    <p>
        安溪台湾妈祖文化基地项目总投资超过2亿元，规划建设妈祖文化纪念馆、植物园、樱花林等主辅工程。安溪与台湾语言文化习俗相同，台湾茶叶与安溪铁观音同根同源、一脉相承，两岸有着深厚的茶缘，由茶缘演绎出来的茶文化，推动两岸乡亲的交流与合作。此外，安溪台湾妈祖文化基地的建设是对妈祖文化的传承与发展，对促进两岸文化交流有着重要的意义。</p>
    <h3 style="text-align:left">民俗文化</h3>
    <p>
        安溪的民俗文化极为丰富，除安溪高甲戏外，还有木偶戏、南音、茶歌对唱、鼓吹音乐、民间舞蹈、水车阁、舞狮舞龙、彩灯、装阁、说书、灯猜等。这些丰富多彩的民俗文化千百年来一直在民间盛行。在台湾地区，有供奉保生大帝的寺庙达400多座，供奉清水祖师寺庙达200多座，不少的宗祠、民居、地名与安溪本土一样，成为沟通乡情、联络乡谊的桥梁和纽带，成为数百万台胞心灵的栖息地和故土文化的象征。 </p>
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
