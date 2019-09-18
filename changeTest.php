<?php
session_start();
if(!isset($_SESSION['username'])) {
echo "<script>
	alert('请先登录');
	location.href='userlogin.html';
</script>";
}
else{
require './common/ini.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>自助停车管理系统</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript">
		window.onload=function(){
			var tem=document.getElementsByClassName("img");
			var oDiv1=tem[0];
			var oDiv2=document.getElementById('info');
			var timer=null;
			oDiv2.onmouseover=oDiv1.onmouseover=function(){
				clearTimeout(timer);
				oDiv2.style.display='block';
			};
			oDiv2.onmouseout=oDiv1.onmouseout=function(){
				timer=setTimeout(function(){
					oDiv2.style.display='none';
				},400);
			};
		};
		function showTime(){
		    nowtime=new Date();
		    year=nowtime.getFullYear();
		    month=nowtime.getMonth()+1;
		    date=nowtime.getDate();
		    document.getElementById("mytime").innerText=nowtime.toLocaleTimeString('chinese',{hour12:false});
		}
		setInterval("showTime()",1000);
	</script>
</head>
<body >
	<div class="bg">
		<div class="header"  >
		<div class="header1">
			<img src="images/head.png" class="img">
			<a href="mainTest.php">车辆预约</a>
			<a href="changeTest.html" class="active">修改信息</a>
			<a href="history.php">停车记录</a>
			<div id="info">
				<div id="tri"></div>
				<div id="div2">
					<div class="tipbk">
						<img src="images/head.png" class="img"><?php echo $_SESSION['username'];?>
						<hr style="border-top: 1px solid grey; width:230px;margin-left: 10px;">
					</div>
					<div class="tipbk">
						<img src="images/balance.png" style="float:left; width: 30px; height:30px; margin:7px 50px 0 10px;"><span style="font-size: 0.9em;margin-top: 7px;">
							<?php
							$sql="select balance from usermessage where username='".$_SESSION['username']."'";
							$result=mysqli_query($db,$sql);
							$row1=mysqli_fetch_row($result);
							echo $row1[0];
							?>
						</span>
					</div>
					<div class="tipbk">
						<img src="images/car.png" style="float:left; width: 30px; height:30px; margin:7px 50px 0 10px;">
						<span style="font-size: 0.9em;margin-top: 7px;">
							<?php
							$sql="select licensePlate from usermessage where username='".$_SESSION['username']."'";
							$result=mysqli_query($db,$sql);
							$row1=mysqli_fetch_row($result);
							$t2=iconv("latin1","utf-8",$row1[0]);
							echo $t2;
							mysqli_close($db);
							?>
						</span>
					</div>
					<a href="exit.php" title="退出登录" id="exit" >退出登录</a>
				</div>
			</div>
		</div>
		<div class="header2">
			<div class="time">
				<span style="color:#f1c85f;margin-right:15px">
				<?php echo date("y-m-d "); ?>
				</span>
				<span style="color:#EA569A; margin-right:15px;" id="mytime">
					<?php echo date(" H:i:s");?>	      		
				</span>
				<span style="color:#6756ea; margin-right:15px;">
					<?php echo date(" D");?>
	      		</span>
			</div>
		</div>
		</div>
	</div>
	<iframe id="iframe" src="userchange.html" style=" border:none;width: 100%; display: block;"></iframe>
</body>
</html>
<script type="text/javascript">
	document.getElementById('iframe').style.height=(window.innerHeight-45)+'px';
</script>
<?php
}
?>