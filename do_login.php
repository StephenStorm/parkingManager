<?php
session_start();
if(isset($_POST['login'])){
	$username=$_POST['username'];
	$passwd=$_POST['passwd'];
	$verify=$_POST['verify'];
	$verify_generate=$_POST['verify_generate'];
	if(strcasecmp($verify_generate,$verify)!==0){
		echo "<script>
			  alert('验证码错误');
			  location.href='userlogin.php';
			  </script>";
	}
	else{
	    require './common/ini.php';
	    $mysqli=$db;
		//$mysqli=new mysqli('localhost','root','971016','parking');
		$mysqli->set_charset('utf-8');
		$passwd1=md5($passwd);
		$sql="select * from userMessage where (username='$username' or userID='$username') and password='$passwd1'";
		$result=$mysqli->query($sql);
		if($result->num_rows>0){
			$result=$mysqli->query("select username from userMessage where userID='".$username."' or username='".$username."'");
			$rows=mysqli_fetch_row($result);
			$_SESSION['username']=$rows[0];
			echo "<script>
					location.href='mainTest.php';
					</script>";
		}
		else{
			echo "<script>
					alert('用户名或密码错误,请重新输入');
					location.href='userlogin.php';
					</script>";
		}
        $mysqli->close();
	}
	

}
?>