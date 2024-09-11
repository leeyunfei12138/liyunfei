<?php
	header("Content-type: text/html; charset=utf-8");//设置字符集

    //开启session
	session_start();

    //链接数据库
	include('dbconfig.php');                        
    $link = @mysqli_connect(HOST,USER,PASS) or die('数据库连接失败');
    mysqli_select_db($link,DBNAME);
    mysqli_set_charset($link,'utf8');
    //判断必要参数
	if (!isset($_GET['a'])) {
		echo "<script>alert('参数错误，请返回重试！');location.href='login.html'</script>";
		exit;
	}

    //登录
	if ($_GET['a'] == 'login') {
        //接收传值（注册时检查用户名重复就不可以注册，所以不判断用户类型）
        $name = trim($_POST['name']);
        $pass = trim($_POST['password']);
        if (empty($name))
        {
            echo "<script>alert('用户名为必填项');location.href='login.html'</script>";
            exit;
        }
        if (empty($pass))
        {
            echo "<script>alert('密码为必填项');location.href='login.html'</script>";
            exit;
        }

	   //验证数据库里的账号 密码
        $sql = "select * from users where name='{$name}'";
        $result = mysqli_query($link,$sql);
        if($result && mysqli_num_rows($result)>0){//用户存在
            $row = mysqli_fetch_assoc($result);
            if($pass != $row['pass']){//判断密码
                  echo "<script>alert('密码错误，请重新输入！');location.href='login.html'</script>";
                  exit;
            }

             //设置session
             $_SESSION['admin_id'] = $row['id'];
             $_SESSION['admin_user'] = $row['name'];
             $_SESSION['admin_type'] = $row['type'];

            //不同用户不同首页
            if($row['type'] == 'admin'){
                header("Location:admin.php?a=picture");
            }else{
                header("Location:index.php");
            }

        }else{//用户不存在
            echo "<script>alert('帐号不存在，请重新输入！');location.href='login.html'</script>";
            exit;
        }
	}else if ($_GET['a'] == 'zhuce') {

        $name = trim($_POST['name']);
        $pass = trim($_POST['password']);
        $surepass =  trim($_POST['password2']);


        if (!preg_match('/^[a-z0-9]{4,16}$/', $name)) {
            echo "<script>alert('帐号不合法，请输入4-16位字母、数字！');location.href='register.html'</script>";
            exit;
        }
        if(!preg_match("/^[a-z0-9_-]{4,16}$/", $pass)){
            echo "<script>alert('请输入4-16位合法密码(字母、数字、下划线)！');location.href='register.html'</script>";
            exit;
        }
        if ($pass != $surepass) {
            echo "<script>alert('两次密码不一致，请重新输入！');location.href='register.html'</script>";
            exit;
        }

        $nameSql = "select id from users where name='$name'";
        mysqli_query($link, $nameSql);
        if (mysqli_affected_rows($link)>0) {
            echo "<script>alert('该帐号已被注册，请重新输入！');location.href='register.html'</script>";
            exit;
        }
        $type = 'user';
        $date = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `users` (`name`, `pass`, `type`,`createTime`) VALUES('$name','$pass','$type','$date')";
        $result =  mysqli_query($link,$sql);
        if (mysqli_insert_id($link)>0) {
            echo "<script>alert('注册成功！');location.href='login.html'</script>";
            exit;
        }else{
            echo "<script>alert('注册失败！');location.href='register.html'</script>";
            exit;
        }

    }else if ($_GET['a'] == 'logout') {
        //清空session里面的值
		unset($_SESSION['admin_id']);
        unset($_SESSION['admin_user']);
        unset($_SESSION['admin_type']);

		header("Location:login.html");
	}

	//关闭数据库 释放结果集
	mysqli_close($link);
	mysqli_free_result($result);

?>