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
			<a href="mainTest.php" >车辆预约</a>
			<a href="userchange.html">修改信息</a>
			<a href="history.php" class="active">停车记录</a>
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
							// $t2=iconv("latin1","utf-8",$row1[0]);
							echo $row1[0];
							// echo "豫A9Rk32";
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
</body>
</html>

<?php
	$username=$_SESSION['username'];
	echo "<br/>";
	$sql="select * from history where username='$username' order by startTime desc";
	$result=mysqli_query($db,$sql)

?>

<div style="color: white;width:1300px;margin:0 auto;text-align: center;">

	<h2 class="tabh">停车历史记录</h2>
	<table style="border: 1px solid white;text-align: center;border-collapse: collapse;width: 1000px;margin:0 auto;">
		<tr>
			<td>用户名</td>
			<td>停车场</td>
			<td>车位号</td>
			<td>开始时间</td>
			<td>结束时间</td>
			<td>费用</td>
		</tr>
		<?php 
		while($myrow=mysqli_fetch_row($result)){
		 ?>
		 <tr>
		 	<td><?php echo $myrow[0];  ?></td>
		 	<td><?php echo $myrow[1];  ?></td>
		 	<td><?php echo $myrow[2];  ?></td>
		 	<td><?php echo date('Y-m-d H:i',$myrow[3]);  ?></td>
		 	<td><?php if($myrow[4]==6) echo "本次停车未结束"; else echo date('Y-m-d H:i',$myrow[4]); ?></td>
		 	<td><?php echo $myrow[5];  ?></td>
		 </tr>
		 <?php
		}
		?>


	</table>
	<a href="mainTest.php" >返回主页</a>


</div>

</html>
<?php
mysqli_close($db);
}
?>