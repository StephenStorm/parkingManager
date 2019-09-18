<?php
require './common/ini.php';
if(isset($_POST['regist'])){
	$username=$_POST['username'];
	$passwd=$_POST['passwd'];
	$license=$_POST['licensePlate'];
	$tel=$_POST['tel'];
	$mysqli=new mysqli('localhost','root',$param['password'],'parking');
	$mysqli->set_charset('utf8');
	$sql="select * from usermessage where username='$username'";
	$result=$mysqli->query($sql);
	if($result->num_rows>0){
		echo "<script>
				 alert('用户名已存在,请重新输入');
				 location.href='userRegist.html';
			</script>";
	}
	$sql="select * from userMessage where userID='$tel'";
	$result=$mysqli->query($sql);
	if($result->num_rows>0){
		echo "<script>
				 alert('该手机号已注册过,请重新输入');
				 location.href='userRegist.html';
			</script>";
	}
	$passwd1=md5($passwd);
	$sql="insert into userMessage values ('{$tel}','{$username}','{$passwd1}','{$license}',100);";
	if($mysqli->query($sql)){
		echo "<script>
				alert('注册成功,请登录！')
				location.href='userlogin.php';
				</script>";
	}
}
?>