<?php session_start();
require './common/ini.php';
require './common/deal_lock_function.php';

	$lock_id=$_POST['lock_id'];//////////////////////////////注意锁ID
	$result=query_lock_id($lock_id);
	$row=mysqli_fetch_assoc($result);
	$state=$row['state'];
	$lock_user=$row['username'];
	$display="操作成功";
	if($state==0){
		//是否已经预约了一个
		$result=have_ordered($_SESSION['username']);
		$num=mysqli_num_rows($result);
		if($num==0){
			change_lock_id_state($lock_id,1,$_SESSION['username']);
			//记录时间，超时重置
			$temp_name=$_SESSION['username']."order_start_time";
			$_SESSION[$temp_name]=time();
			$display=5;
		}else{
			$display=1;
		}
	}else{
		if($lock_user==$_SESSION['username']){
			if($state==1){
				$temp_nam=$_SESSION['username']."order_start_time";
				if((time()-$_SESSION[$temp_nam])>900){//时间超出限制
					unset($_SESSION[$temp_nam]);
					change_lock_id_state($lock_id,0,"");
					$display=2;
				}else{
					unset($_SESSION[$temp_nam]);
					change_lock_id_state($lock_id,2,$_SESSION['username']);
					//开始记录开始时间
					change_start_time($_SESSION['username'],$lock_id,time(),6);//6表示无效
					$display=0;
				//	echo"<script>
				//		f2();
				//	</script>";
				}
			}
			else{
				$display=3;
			}
		}else{
			//遍历所有已经预约，但是没有开锁的情况
			if($state==1){
				$temp_na=$lock_user."order_start_time";
				if((time()-$_SESSION[$temp_na])>900){
					//
					unset($_SESSION[$temp_na]);
					change_lock_id_state($lock_id,0,"");
					//重新判断,看state=0的情况
					$result=have_ordered($_SESSION['username']);
					$num=mysqli_num_rows($result);
					if($num==0){
						change_lock_id_state($lock_id,1,$_SESSION['username']);
					//记录时间，超时重置
						$temp_name=$_SESSION['username']."order_start_time";
						$_SESSION[$temp_name]=time();
						$display=5;
					}else{
						$display=1;
					}
				}else{
					$display=4;
				}
			}else{
				$display=4;
			}
		}
	}
	/*
	$str1="<script>
			var str=\"";
	$str2=$display;
	$str3="\";
			setTimeout(function(){location.href='mainTest.php';alert(str);},500);
	</script>";
	*/
	echo $display;
	mysqli_close($db);
	?>