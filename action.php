<?php
	date_default_timezone_set('PRC'); 
    include('dbconfig.php');                        
    $link = @mysqli_connect(HOST,USER,PASS) or die('数据库连接失败');
    mysqli_select_db($link,DBNAME);
	mysqli_set_charset($link,'utf8');
    session_start(); //开启session

    switch($_GET['b']){
		case 'insert':
            if($_GET['a'] == 'picture'){
                $name     = $_POST['name'];
                $sinfo   = $_POST['sinfo'];
                $content    = $_POST['content'];


                if($_FILES["pics"]["name"] ==''){
                    echo "<script>alert('必须上传配');location.href='admin.php?a=addS'</script>";
                    exit;
                }

                $image = $_FILES["pics"]["tmp_name"];
                $imagetype = trim(strrchr($_FILES['pics']['type'], '/'),'/');
                $imagesize = $_FILES['pics']['size'];

                if($imagesize>5214000){
                    echo "<script>alert('您所上传图片过大，请选择00小于50kb的图片！');location.href='admin.php?a=addS'</script>";
                    exit;
                }

             

                $imagepath ='./images/'. time() .'.'.$imagetype;
                move_uploaded_file($_FILES["pics"]["tmp_name"], $imagepath);

              
                $pics = $imagepath;
              

                $date = date('Y-m-d H:i:s');

                $sql = "INSERT INTO `picture`(`name`, `pics`, `sinfo`,`sfile`,`content`,`createTime`) VALUES ('$name', '$pics','$sinfo','','$content','$date')";
                $result =  mysqli_query($link,$sql);
                if (mysqli_insert_id($link)>0) {
                    echo '<h1 style="text-align:center">添加成功!</h1>';
                    header("refresh:1;url=admin.php?a=picture");
                }else{
                    echo "添加失败";
                    header("refresh:1;url=admin.php?a=addS");
                }
            }
		break;
        case "del":
            $id = $_GET['id'];
            if($_GET['a'] == 'picture'){
                //判断合法性
                if(!preg_match("/^[1-9][0-9]{0,}$/", $id)){
                    echo '<h1 style="text-align:center">参数错误，请刷新页面再试！</h1>';
                    header("refresh:1;url=admin.php?a=picture");
                    break;
                }

                $sql = "delete from picture where id=".$id;

                $result = mysqli_query($link,$sql);
                if(mysqli_affected_rows($link)){
                    echo '<h1 style="text-align:center">删除成功！</h1>';
                    header("refresh:1;url=admin.php?a=picture");
                    break;
                }else{
                    echo '<h1 style="text-align:center">删除失败！</h1>';
                    header("refresh:1;url=admin.php?a=picture");
                    break;
                }

            }
            if($_GET['a'] == 'userS'){
                //判断合法性
                if(!preg_match("/^[1-9][0-9]{0,}$/", $id)){
                    echo '<h1 style="text-align:center">参数错误，请刷新页面再试！</h1>';
                    header("refresh:1;url=admin.php?a=userS");
                    break;
                }

                $sql = "delete from users where id=".$id;

                $result = mysqli_query($link,$sql);
                if(mysqli_affected_rows($link)){
                    echo '<h1 style="text-align:center">删除成功！</h1>';
                    header("refresh:1;url=admin.php?a=userS");
                    break;
                }else{
                    echo '<h1 style="text-align:center">删除失败！</h1>';
                    header("refresh:1;url=admin.php?a=userS");
                    break;
                }

            }
            break;
        case 'update':
            $id = $_POST['id'];
            if($_GET['a'] == 'picture'){

                $name     = $_POST['name'];
                $sinfo   = $_POST['sinfo'];
                $content    = $_POST['content'];

                if($_FILES["pics"]["name"] ==''){
                    $pics = $_POST['pics_name'];
                }else{
                    $image = $_FILES["pics"]["tmp_name"];
                    $imagetype = trim(strrchr($_FILES['pics']['type'], '/'),'/');
                    $imagesize = $_FILES['pics']['size'];

                    if($imagesize>5214000){
                        echo "<script>alert('您所上传图片过大，请选择小于5000kb的图片！');location.href='admin.php?a=addS'</script>";
                        exit;
                    }
                    $imagepath ='./images/'. time() .'.'.$imagetype;
                    move_uploaded_file($_FILES["pics"]["tmp_name"], $imagepath);
                    $pics = $imagepath;
                }

              

                $sql = "UPDATE `picture` SET `name`='$name',`pics`='$pics',`sinfo`='$sinfo',`content`='$content' where `id`=".$id;


                $result = mysqli_query($link,$sql);
                if(mysqli_affected_rows($link)>0){
                    echo '<h1 style="text-align:center">修改成功！</h1>';
                    header("refresh:1;url=admin.php?a=picture");
                }else{
                    echo '<h1 style="text-align:center">修改失败！</h1>';
                    header("refresh:1;url=admin.php?a=editS&id=".$id);
                }
            }
            if($_GET['a'] == 'userS'){

                $pass  = $_POST['password'];

                $sql = "UPDATE `users` SET `pass`='$pass' where `id`=".$id;

                $result = mysqli_query($link,$sql);
                if(mysqli_affected_rows($link)>0){
                    echo '<h1 style="text-align:center">修改成功！</h1>';
                    header("refresh:1;url=admin.php?a=userS");
                }else{
                    echo '<h1 style="text-align:center">修改失败！</h1>';
                    header("refresh:1;url=admin.php?a=edituserS&id=".$id);
                }
            }
            break;

    }
	//关闭数据库 
	mysqli_close($link);