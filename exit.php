<?php 
session_start();
if(!isset($_SESSION['username'])) echo "<script>
	alert('请先登录');
	location.href='userlogin.php';
</script>";
else{
	unset($_SESSION['username']);
	session_destroy();
	echo  "<script>
       location.href='userlogin.php';
       </script>";
}

 ?>