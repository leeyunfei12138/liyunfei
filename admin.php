<?php 
  session_start(); 
  if(!isset($_SESSION['admin_user']) || !isset($_SESSION['admin_type'])){
    header('Location:login.html');
    exit;
  }elseif ($_SESSION['admin_type'] != 'admin'){
      echo "<script>alert('抱歉，您没有权限查看');location.href='login.html'</script>";
      //清空session里面的值
      unset($_SESSION['admin_id']);
      unset($_SESSION['admin_user']);
      unset($_SESSION['admin_type']);
      exit;
  }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>安溪旅游-管理</title>
</head>
<body>
<div class="admin">
  <div class="bgimg"> <img src="images/timg.jpg" width="100%" height="100%"/> </div>
  <div class="bgbr"> </div>
  <div id="body">
    <div class="userinfo"> 欢迎 <?php echo $_SESSION['admin_user'];?>&nbsp;&nbsp;管理员 &nbsp;
      | <a class="logout" href="dologin.php?a=logout">注销</a> </div>
    <h1>安溪旅游</h1>
    <?php
                if($_GET['a'] == 'editS' || $_GET['a'] == 'detilS' ) {
                    ?>
    <div class="sysChange">
      <ul>
        <a href="admin.php?a=picture">
        <li>返回</li>
        </a>
      </ul>
    </div>
    <?php
                }elseif ($_GET['a'] == 'edituserS'){
                    ?>
    <div class="sysChange">
      <ul>
        <a href="admin.php?a=userS">
        <li>返回</li>
        </a>
      </ul>
    </div>
    <?php
                }else{
            ?>
    <div class="sysChange">
      <ul>
        <a href="admin.php?a=addS">
        <li>添加景点</li>
        </a> <a href="admin.php?a=picture">
        <li>景点信息管理</li>
        </a> <a href="admin.php?a=userS">
        <li>用户信息管理</li>
        </a>
      </ul>
    </div>
    <?php
                }
            ?>
    <div class="content"> 
      <!-- 添加景点信息 -->
      <div id="addS">
        <?php
                    if($_GET['a'] == 'addS'){
                        ?>
        <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" class="searchmain">
          <tr>
            <td align="left" valign="top"><form method="post" action="action.php?a=picture&b=insert" enctype="multipart/form-data">
                <table width="60%" border="0" cellspacing="0" cellpadding="0" class="main-tab class80">
                  <tr>
                    <td align="left" valign="middle" class="borderright" width="20%">景区名：</td>
                    <td align="left" valign="middle" class="borderright"><input type="text" name="name" class="text-word" required></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">配图：</td>
                    <td align="left" valign="middle" class="borderright"><input type="file" name="pics" class="text-file" accept="image/png,image/jpeg,image/jpg" required ></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">简介：</td>
                    <td align="left" valign="middle" class="borderright"><input type="text" name="sinfo" class="text-word" required></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">内容体：</td>
                    <td align="left" valign="middle" class="borderright"><textarea  rows="5" cols="50" name="content" required></textarea></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">&nbsp;</td>
                    <td align="left" valign="middle" class="borderright"><input type="submit" value="提交" class="a_btn">
                      <input type="reset" value="重置" class="a_btn"></td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table>
        <?php
                    }
                    ?>
      </div>
      
      <!-- 乐器列表 -->
      <div id="pictureManage">
        <?php
                    if($_GET['a'] == 'picture'){

                        //连接数据库
                        include('dbconfig.php');
                        $link = @mysqli_connect(HOST,USER,PASS) or die('数据库连接失败');
                        mysqli_select_db($link,DBNAME);
                        mysqli_set_charset($link,'utf8');

                        ?>
        <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" >
          <thead>
            <tr>
              <td  align="center">景点信息管理列表</td>
            </tr>
            <tr>
              <td align="left" valign="top" colspan="2"><form method="get" action="admin.php?a=picture">
                  <span>景区名：</span>
                  <input type="text" name="a" value="picture" hidden>
                  <input type="text" name="name" value="<?php if(!empty($_GET['name'])){echo $_GET['name'];} ?>" class="text-word">
                  <input type="submit" value="查询" class="text-but">
                </form></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td align="left" valign="top"  colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
                  <tr>
                    <th align="center" valign="middle" class="borderright"style="width: 40px;">序号</th>
                    <th align="center" valign="middle" class="borderright" style="width: 80px;">景区名</th>
                    <th align="center" valign="middle" class="borderright">配图</th>
                    <th align="center" valign="middle" class="borderright" >简介</th>
                    <th align="center" valign="middle" class="borderright" style="width: 180px;">添加时间</th>
                    <th align="center" valign="middle" class="borderright" style="width: 70px;">操作</th>
                  </tr>
                  <?php
                                        //接受搜索条件信息
                                        $wherelist = array();//搜索条件给数据库
                                        $urllist = array();//搜索条件给url 实现url的状态维持
                                        //判断搜索条件是否存在
                                        if(!empty($_GET['name'])){
                                            $wherelist[] = " name like '%".$_GET['name']."%'";
                                            $urllist[] = "name={$_GET['name']}";
                                        }
                                        //拼接搜索语句
                                        $where = "";
                                        $url = "";
                                        if(count($wherelist)>0){
                                            $where =  " where ".implode(' and ', $wherelist);
                                            $url = implode('&', $urllist);
                                        }

                                        // 分页设置
                                        $page = !empty($_GET['p']) ? $_GET['p'] : 1 ;//具体的页码
                                        $pagesize = 10;//每页显示多少条
                                        $maxrow = 0;//一共有多少条信息
                                        $maxpage = 0;//一共显示多少页

                                        //  一共有多少条信息
                                        $sql = "select id from picture ".$where;
                                        $result = mysqli_query($link,$sql);
                                        $maxrow = mysqli_num_rows($result);

                                        //  一共分多少页
                                        $maxpage = ceil($maxrow/$pagesize);  //ceil是进一取整函数

                                        //  判断一下页码的有效
                                        if($page>$maxpage){
                                            $page = $maxpage;
                                        }
                                        if($page<1){
                                            $page = 1;
                                        }

                                        // 写sql语句
                                        $limit = " limit ".($page-1)*$pagesize.",".$pagesize;

                                        //拼接搜索和分页的功能
                                        $sql = "select * from picture ".$where.' order by createTime desc '.$limit;
                                        $result = mysqli_query($link,$sql);
                                        //将数据显示到表格里
                                        $index = 1;

                                        while($row = mysqli_fetch_assoc($result)){
                                            ?>
                  <tr>
                    <td align="center" valign="middle" class="borderright"><?php echo $index+($page-1)*10;?></td>
                    <td align="center" valign="middle" class="borderright"><a href="admin.php?a=detilS&id=<?php echo $row['id'];?>" class="add"> <?php echo $row['name'];?> </a></td>
                    <td align="center" valign="middle" class="borderright"><img src="<?php echo $row['pics'];?>" class="xpic"></td>
                    <td align="center" valign="middle" class="borderright"><?php echo $row['sinfo'];?></td>
                    
                    <td align="center" valign="middle" class="borderright"><?php echo $row['createTime'];?></td>
                    <td align="center" valign="middle" class="borderright"><a href="admin.php?a=editS&id=<?php echo $row['id'];?>" class="add">编辑</a><span class="gray">&nbsp;</span> <a href="javascript:sureDelpicture(<?php echo $row['id'];?>)" class="add mod">删除</a><span class="gray"></td>
                  </tr>
                  <?php
                                            $index++;
                                        }
                                        ?>
                </table></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td align="left" valign="top" class="fenye"  colspan="2">共<?php echo $maxrow; ?>条数据 <?php echo $page."/"; echo $maxpage; ?> 页&nbsp;&nbsp;
                <?php
                                        echo "<a href='admin.php?a=picture&p=1&{$url}'>首页</a>&nbsp;&nbsp;
                                      <a href='admin.php?a=picture&p=".($page-1)."&{$url}'>上一页</a>&nbsp;&nbsp;
                                      <a href='admin.php?a=picture&p=".($page+1)."&{$url}'>下一页</a>&nbsp;&nbsp;
                                      <a href='admin.php?a=picture&p={$maxpage}&{$url}'>尾页</a>";
                                        ?></td>
            </tr>
          </tfoot>
        </table>
        <?php

                        //关闭数据库 释放结果集
                        mysqli_close($link);
                        mysqli_free_result($result);

                    }

                    ?>
      </div>
      
      <!-- 修改乐器信息 -->
      <div id="editS">
        <?php
                    if($_GET['a'] == 'editS'){

                        include("dbconfig.php");
                        // 连接数据库
                        $link = @mysqli_connect(HOST,USER,PASS) or die("数据库连接失败");
                        // 选择数据库 设置字符集
                        mysqli_select_db($link,DBNAME);
                        mysqli_set_charset($link,"utf8");
                        $sql = "select * from picture where id=".$_GET['id'];
                        $result = mysqli_query($link,$sql);
                        @$row = mysqli_fetch_assoc($result);

                        ?>
        <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" class="searchmain">
          <tr>
            <td align="left" valign="top"><form method="post" action="action.php?a=picture&b=update" enctype="multipart/form-data">
                <input type="hidden" name="id" class="text-word" value="<?php echo $row['id'];?>">
                <table width="60%" border="0" cellspacing="0" cellpadding="0" class="main-tab class80">
                  <tr>
                    <td align="left" valign="middle" class="borderright" width="20%">景区名：</td>
                    <td align="left" valign="middle" class="borderright"><input type="text" name="name" class="text-word" required value="<?php echo $row['name'];?>"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">配图：</td>
                    <td align="left" valign="middle" class="borderright"><input type="text" name="pics_name" value="<?php echo $row['pics'];?>" hidden>
                      <input type="file" name="pics" class="text-file" accept="image/png,image/jpeg,image/jpg">
                      <img src="<?php echo $row['pics'];?>" class="xpic"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">简介：</td>
                    <td align="left" valign="middle" class="borderright"><textarea  rows="3" cols="60" name="sinfo" required><?php echo $row['sinfo'];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">内容：</td>
                    <td align="left" valign="middle" class="borderright"><textarea  rows="8" cols="60" name="content" required><?php echo $row['content'];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">&nbsp;</td>
                    <td align="left" valign="middle" class="borderright"><input type="submit" value="提交" class="a_btn">
                      <input type="reset" value="重置" class="a_btn"></td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table>
        <?php
                    }
                    ?>
      </div>
      
      <!-- 查看乐器信息 -->
      <div id="detilS">
        <?php
                    if($_GET['a'] == 'detilS'){

                        include("dbconfig.php");
                        // 连接数据库
                        $link = @mysqli_connect(HOST,USER,PASS) or die("数据库连接失败");
                        // 选择数据库 设置字符集
                        mysqli_select_db($link,DBNAME);
                        mysqli_set_charset($link,"utf8");
                        $sql = "select * from picture where id=".$_GET['id'];
                        $result = mysqli_query($link,$sql);
                        @$row = mysqli_fetch_assoc($result);

                        ?>
        <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" class="searchmain">
          <tr>
            <td align="left" valign="top"><table width="60%" border="0" cellspacing="0" cellpadding="0" class="main-tab class80">
                <tr>
                  <td align="left" valign="middle" class="borderright" width="20%">景区编号：</td>
                  <td align="left" valign="middle" class="borderright"><?php echo $row['id'];?></td>
                </tr>
                <tr>
                  <td align="left" valign="middle" class="borderright" width="20%">景区名：</td>
                  <td align="left" valign="middle" class="borderright"><?php echo $row['name'];?></td>
                </tr>
                <tr>
                  <td align="left" valign="middle" class="borderright">配图：</td>
                  <td align="left" valign="middle" class="borderright"><img src="<?php echo $row['pics'];?>" class="xpic"></td>
                </tr>
                <tr>
                  <td align="left" valign="middle" class="borderright">简介：</td>
                  <td align="left" valign="middle" class="borderright"><?php echo $row['sinfo'];?></td>
                </tr>
                <tr>
                  <td align="left" valign="middle" class="borderright">内容：</td>
                  <td align="left" valign="middle" class="borderright"><?php echo $row['content'];?></td>
                </tr>
                <tr>
                  <td align="left" valign="middle" class="borderright" width="180">添加时间：</td>
                  <td align="left" valign="middle" class="borderright"><?php echo $row['createTime'];?></td>
                </tr>
              </table>
              </form></td>
          </tr>
        </table>
        <?php
                    }
                    ?>
      </div>
      
      <!-- 用户列表 -->
      <div id="userManage">
        <?php
                    if($_GET['a'] == 'userS'){

                        //连接数据库
                        include('dbconfig.php');
                        $link = @mysqli_connect(HOST,USER,PASS) or die('数据库连接失败');
                        mysqli_select_db($link,DBNAME);
                        mysqli_set_charset($link,'utf8');

                        ?>
        <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" >
          <thead>
            <tr>
              <td  align="center">用户信息管理列表</td>
            </tr>
            <tr>
              <td align="left" valign="top" colspan="2"><form method="get" action="admin.php?a=userS">
                  <span>用户名：</span>
                  <input type="text" name="a" value="userS" hidden>
                  <input type="text" name="name" value="<?php if(!empty($_GET['name'])){echo $_GET['name'];} ?>" class="text-word">
                  <input type="submit" value="查询" class="text-but">
                </form></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td align="left" valign="top"  colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
                  <tr>
                    <th align="center" valign="middle" class="borderright"style="width: 40px;">序号</th>
                    <th align="center" valign="middle" class="borderright" style="width: 80px;">用户名</th>
                    <th align="center" valign="middle" class="borderright">密码</th>
                    <th align="center" valign="middle" class="borderright" style="width: 180px;">注册时间</th>
                    <th align="center" valign="middle" class="borderright" style="width: 70px;">操作</th>
                  </tr>
                  <?php
                                        //接受搜索条件信息
                                        $wherelist = array();//搜索条件给数据库
                                        $urllist = array();//搜索条件给url 实现url的状态维持
                                        //判断搜索条件是否存在
                                        if(!empty($_GET['name'])){
                                            $wherelist[] = " name like '%".$_GET['name']."%'";
                                            $urllist[] = "name={$_GET['name']}";
                                        }
                                        //拼接搜索语句
                                        $where = "";
                                        $url = "";
                                        if(count($wherelist)>0){
                                            $where =  " and  ".implode(' and ', $wherelist);
                                            $url = implode('&', $urllist);
                                        }

                                        // 分页设置
                                        $page = !empty($_GET['p']) ? $_GET['p'] : 1 ;//具体的页码
                                        $pagesize = 10;//每页显示多少条
                                        $maxrow = 0;//一共有多少条信息
                                        $maxpage = 0;//一共显示多少页

                                        //  一共有多少条信息
                                        $sql = "select id from users where type <> 'admin' ".$where;
                                        $result = mysqli_query($link,$sql);
                                        $maxrow = mysqli_num_rows($result);

                                        //  一共分多少页
                                        $maxpage = ceil($maxrow/$pagesize);  //ceil是进一取整函数

                                        //  判断一下页码的有效
                                        if($page>$maxpage){
                                            $page = $maxpage;
                                        }
                                        if($page<1){
                                            $page = 1;
                                        }

                                        // 写sql语句
                                        $limit = " limit ".($page-1)*$pagesize.",".$pagesize;

                                        //拼接搜索和分页的功能
                                        $sql = "select * from users where type <> 'admin'  ".$where.' order by createTime desc '.$limit;
                                        $result = mysqli_query($link,$sql);
                                        //将数据显示到表格里
                                        $index = 1;

                                        while($row = mysqli_fetch_assoc($result)){
                                            ?>
                  <tr>
                    <td align="center" valign="middle" class="borderright"><?php echo $index+($page-1)*10;?></td>
                    <td align="center" valign="middle" class="borderright"><?php echo $row['name'];?></td>
                    <td align="center" valign="middle" class="borderright"><?php echo $row['pass'];?></td>
                    <td align="center" valign="middle" class="borderright"><?php echo $row['createTime'];?></td>
                    <td align="center" valign="middle" class="borderright"><a href="admin.php?a=edituserS&id=<?php echo $row['id'];?>" class="add">编辑</a><span class="gray">&nbsp;</span> <a href="javascript:sureDelusers(<?php echo $row['id'];?>)" class="add mod">删除</a><span class="gray"></td>
                  </tr>
                  <?php
                                            $index++;
                                        }
                                        ?>
                </table></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td align="left" valign="top" class="fenye"  colspan="2">共<?php echo $maxrow; ?>条数据 <?php echo $page."/"; echo $maxpage; ?> 页&nbsp;&nbsp;
                <?php
                                    echo "<a href='admin.php?a=userS&p=1&{$url}'>首页</a>&nbsp;&nbsp;
                                      <a href='admin.php?a=userS&p=".($page-1)."&{$url}'>上一页</a>&nbsp;&nbsp;
                                      <a href='admin.php?a=userS&p=".($page+1)."&{$url}'>下一页</a>&nbsp;&nbsp;
                                      <a href='admin.php?a=userS&p={$maxpage}&{$url}'>尾页</a>";
                                    ?></td>
            </tr>
          </tfoot>
        </table>
        <?php

                        //关闭数据库 释放结果集
                        mysqli_close($link);
                        mysqli_free_result($result);

                    }

                    ?>
      </div>
      
      <!-- 修改用户信息 -->
      <div id="edituserS">
        <?php
                    if($_GET['a'] == 'edituserS'){

                        include("dbconfig.php");
                        // 连接数据库
                        $link = @mysqli_connect(HOST,USER,PASS) or die("数据库连接失败");
                        // 选择数据库 设置字符集
                        mysqli_select_db($link,DBNAME);
                        mysqli_set_charset($link,"utf8");
                        $sql = "select * from users where id=".$_GET['id'];
                        $result = mysqli_query($link,$sql);
                        @$row = mysqli_fetch_assoc($result);

                        ?>
        <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" class="searchmain">
          <tr>
            <td align="left" valign="top"><form method="post" action="action.php?a=userS&b=update" >
                <input type="hidden" name="id" class="text-word" value="<?php echo $row['id'];?>">
                <table width="60%" border="0" cellspacing="0" cellpadding="0" class="main-tab class80">
                  <tr>
                    <td align="left" valign="middle" class="borderright" width="20%">用户名：</td>
                    <td align="left" valign="middle" class="borderright"><?php echo $row['name'];?></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">密码：</td>
                    <td align="left" valign="middle" class="borderright"><input type="text" name="password" class="text-word" required value="<?php echo $row['pass'];?>"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="borderright">&nbsp;</td>
                    <td align="left" valign="middle" class="borderright"><input type="submit" value="提交" class="a_btn">
                      <input type="reset" value="重置" class="a_btn"></td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table>
        <?php
                    }
                    ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script>

function sureDelpicture(argument) {
    if (confirm('确定删除该信息吗？')) {
        window.location.href = "action.php?a=picture&b=del&id="+argument;
    }
}

function sureDelusers(argument) {
    if (confirm('确定删除该用户信息吗？')) {
        window.location.href = "action.php?a=userS&b=del&id="+argument;
    }
}


</script>