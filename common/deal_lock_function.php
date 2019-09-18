<?php
	function query_lock_id($id){
		global $db;
		$sq="select state,username from parkingstate where lotID={$id}";
		$result=mysqli_query($db,$sq);
		return $result;
	}
	function change_lock_id_state($id,$state,$user_name){
		global $db;
		$sq="update parkingstate set state={$state},username=\"{$user_name}\" where lotID={$id}";
		$result=mysqli_query($db,$sq);
		return $result;
	}
	function have_ordered($username){
		global $db;
		$sq="select lotID from parkingstate where username=\"{$username}\" and state>0";
		$result=mysqli_query($db,$sq);
		return $result;
	}
	function change_start_time($username,$lotID,$startTime,$endTime){
		global $db;
		$sq="insert into history(username,lotID,startTime,endTime)values(\"{$username}\",{$lotID},{$startTime},{$endTime})";
		$result=mysqli_query($db,$sq);
		return $result;
	}
?>