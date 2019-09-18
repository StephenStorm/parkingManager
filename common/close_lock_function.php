<?php
	function get_start_time($username,$lock_id,$endTime){
		global $db;
		$sq="select startTime from history where username=\"{$username}\" and lotID={$lock_id} and endTime={$endTime}";
		$result=mysqli_query($db,$sq);
		return $result;
	}
	function change_end_time($username,$lock_id,$endTime,$real_end_time,$cost,$parkname){
		global $db;
		$sq="update history set parkName=\"{$parkname}\",endTime={$real_end_time},cost={$cost} where username=\"{$username}\" and lotID={$lock_id} and endTime={$endTime}";
		$result=mysqli_query($db,$sq);
		return $result;
	}
	function change_money($rest_money,$username){
		global $db;
		$sq="update userMessage set balance={$rest_money} where username=\"{$username}\"";
		$result=mysqli_query($db,$sq);
		return $result;
	}
	function change_lock_id_state($id,$state){
		global $db;
		$sq="update parkingstate set state={$state} where lotID={$id}";
		$result=mysqli_query($db,$sq);
		return $result;
	}
	function get_username_state($id){
		global $db;
		$sq="select username,state from parkingstate where lotID={$id}";
		$result=mysqli_query($db,$sq);
		return $result;
	}
?>

