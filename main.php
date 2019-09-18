<?php session_start();?><head>
<meta charset="utf-8">
<title>欢迎来到停车位服务系统</title>
	<script type="text/javascript">
		function draw(id,string){
			var c=document.getElementById(id);
			var cxt=c.getContext("2d");
			cxt.font='italic 30px 微软雅黑';
			cxt.textAlign='left';
			cxt.textBaseline='top';
			cxt.fillStyle="#00f";
			cxt.fillText(string,20,0,50);
		}
	</script>
</head> 		
<?php		
	if(isset($_SESSION['username'])) {
		echo " 系统时间:".date("y-m-d H:i")."<br/>";
		echo "<a href='userchange.html'>修改用户信息&nbsp;</a> <a href='history.php'>停车历史记录&nbsp;</a> <a href='exit.php'>退出</a>";
		echo "个人信息: 姓名: ".$_SESSION['username'];
		$mysqli=new mysqli('localhost','root','','parking');
		$sql="select balance from usermessage where username='".$_SESSION['username']."'";
		$result=$mysqli->query($sql);
		$row1=mysqli_fetch_row($result);
		echo "余额".$row1[0];
		echo "<br/><br/><br/>";



	function query_lock(){
	$db=mysqli_connect('localhost','root','','parking')or die('连接服务器失败');
	$sq="select lotID,state,username from parkingstate";
	$result=mysqli_query($db,$sq);
	mysqli_close($db);
	return $result;
	}
	function query_using($username){
		$db=mysqli_connect('localhost','root','','parking')or die('连接服务器失败');
		$sq="select lotID from parkingstate where username=\"{$username}\" and state=2";
		$result=mysqli_query($db,$sq);
		mysqli_close($db);
		return $result;
	}
	$result=query_lock();
	for($i=1;$i<=mysqli_num_rows($result);$i++){
	$temp=$result;
	do{
		$row=mysqli_fetch_assoc($temp);
	}while($row['lotID']!=$i);
	if($row['state']==0){
		$decision="预约";
	}else{
		if($row['username']==$_SESSION['username']){
			if($row['state']==1){
				$decision="开锁";
			}else{
				$decision="正在使用";
			}
		}else{
			if($row['state']==1){
				$decision="预约";
			}else{
				$decision="忙碌";
			}
		}
	}
	echo "
	<canvas id=\"myCanvas{$i}\" width=\"100\" height=\"40\" style=\"border: 1px solid blue\"></canvas>
	<form action=\"deal_lock.php\" method=\"post\" style=\"display: inline\">
		<input type=\"hidden\" name=\"lock_id\" value=\"$i\">
		<input type=\"submit\" name=\"submit\" value=\"{$decision}\">
	</form>";
	}
	
	if($result=query_using($_SESSION['username'])){$num=mysqli_num_rows($result);
		if($num!=0){
		$temp_row=mysqli_fetch_assoc($result);
		echo "<form action=\"close_lock.php\" method=\"post\">
		<input type=\"hidden\" name=\"lock_id\" value=\"{$temp_row['lotID']}\">
		<input type=\"submit\" name=\"close_lock\" value=\"离开\">
	</form>";
	}
}


	}
	else{
		echo "<script>
		location.href='userlogin.html';
		</script>";
	}
	
	
	?>
	
	<hr>
	<script type="text/javascript">
		draw("myCanvas1","停车位1");
		draw("myCanvas2","停车位2");
	</script>