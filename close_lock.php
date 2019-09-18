<?php session_start();
require './common/ini.php';
require './common/close_lock_function.php';
?>
	<?php
	$lock_id=$_POST['lock_id'];////////////////////////////////注意lotID
	$row_modify=mysqli_fetch_assoc(get_username_state($lock_id));
	$username=$row_modify['username'];
	$state=$row_modify['state'];
	if($state==2){
		//算时间，钱数，更新user,history数据表
		$end_time=time();
		$row=mysqli_fetch_assoc(get_start_time($username,$lock_id,6));
		$start_time=$row['startTime'];
		$used_time=$end_time-$start_time;
		$fee=$used_time*0.0014;//价格0.01元每秒
		$fee=round($fee,2);
		echo "<p>{$username}</p>";
		echo "<p>您本次花费为".$fee."元,账户余额为";
		change_end_time($username,$lock_id,6,$end_time,$fee,$parkName);
			$sql="select balance from usermessage where username='".$username."'";
			$result1=mysqli_query($db,$sql);
			$row1=mysqli_fetch_row($result1);
		$rest_money=$row1[0]-$fee;
		echo $rest_money."元。</p>";
		change_money($rest_money,$username);
		change_lock_id_state($lock_id,0);
	}
	mysqli_close($db);
	?>