<?php
session_start();
if(!isset($_SESSION['username'])) echo "请先登录！";
else{
	require './common/ini.php';
	if(isset($_POST['change'])){
		$changed=false;
		$tem=$_POST;
		foreach ($tem as $key => $value) {
			if($value!==''&&$key!='change'){
				if($key=='username'||$key=='userID'){
					$sql="select * from userMessage where ".$key.'='."'".$value."'";
					$result=mysqli_query($db,$sql);
					if($result->num_rows>0){
						echo "<script>
						      alert('\"$key\"已存在,请重新输入');
						      location.href='userchange.html';
						      </script>";
					}
				}
				if($key==='password'){
						$value=md5($value);
						$changed=true;
					}
				$sql="update userMessage set ".$key."='".$value."' where username='".$_SESSION['username']."'";
				if(mysqli_query($db,$sql)){
					if($key==='username'){
						$sql="update history set username='".$value."' where username='".$_SESSION['username']."';";
						$sql.="update parkingstate set username='".$value."' where username='".$_SESSION['username']."' and state !=0";
						mysqli_multi_query($sql);
						$_SESSION['username']=$value;
						
					}
					
				}
				else{
					echo "error in modify";
				}
			}
		}
		mysqli_close($db);
		if($changed){
			echo "<script>
			alert('修改成功，请重新登录');
			location.href='userlogin.php';
			</script>";
					}
		else{
			echo "<script>
				alert('信息修改成功！');
			 	location.href='mainTest.php';
				</script>";
		}
	}
}

?>