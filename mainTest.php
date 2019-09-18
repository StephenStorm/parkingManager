<?php
session_start();
if(!isset($_SESSION['username'])) {
echo "<script>
	alert('请先登录');
	location.href='userlogin.php';
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
	 <link rel="stylesheet" type="text/css" href="./css/park.css">
    <link rel="stylesheet" type="text/css" href="./css/sweetalert2.min.css">
    <script src="./js/sweetalert2.min.js"></script>
    <script src="./js/es6-promise.min.js"></script>
	
    <script src="js/mqttws31.js"></script>
    <script src="js/usrCloud.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
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
	function deal_lock(id){
		 $.post("./deal_lock.php",
	           {
	               lock_id:id,
	           },
	            function (data, status) {
	                if (status == "success") {
						//
						var display="";
						data=parseInt(data);
						switch(data){
							case 0:
								//开锁
								publishRawToDev();
								display="正在开锁中";
								break;
							case 1:
								display="您已经占了一个车位，禁止多占";
								break;
							case 2:
								display="您的预约时间已超时，请重新预约";
								break;
							case 3:
								display="您已经在使用中";
								break;
							case 4:
								display="该车位正忙";
								break;
							case 5:
								display="预约成功";
								break;
						}
						location.reload();//主界面更新
						alert(display);
	                } else {
	                    alert("系统错误");
	                }
	            });
		
	}
	setInterval("showTime()",1000);
	function USR_onConnAck(event) {
	        console.log(event);
	        if (event.code == 0) {
	            //连接成功，接下来订阅设备
	            usrCloud.USR_SubscribeDevRaw("00016767000000000001");
	        } else {
	            alert("连接失败");
	        }
	    }
	    function USR_onConnLost(event) {
	        console.log(event);
	        $("#info1").text("连接断开");
	    }
	    function USR_onSubscribeAck(event) {
	        console.log(event);
	        if(event.code===0){
	            console.log("连接到账户，订阅成功");
	        }else{
	            console.log("未连接到账户");
	        }
	
	    }
	function publishRawToDev(){
	    var dataByte = [];
	    var s="a11f";
	    for (var i = 0; i < s.length; i++) {
	        dataByte[i] = s.charCodeAt(i);
	    }
	    stringToUTF8(s, dataByte, 0);
	    var result=usrCloud.USR_PublishRawToDev("00016767000000000001", dataByte);
	    if(result==0){
	        console.log("open lock");
	    }
		console.log(result);
	}
	function publishRawToDev2(){
	    var dataByte = [];
	    var s="a10f";
	    for (var i = 0; i < s.length; i++) {
	        dataByte[i] = s.charCodeAt(i);
	    }
	    stringToUTF8(s, dataByte, 0);
	    var result=usrCloud.USR_PublishRawToDev("00016767000000000001", dataByte);
	    if(result==0){
	        alert(dataByte);
	    }
	}
	   function USR_onRcvRawFromDev(event) {
            var temp_lock_id = event.payload[1];//字节数组
			var x=48;
			temp_lock_id=temp_lock_id-x;
			console.log(event);
			console.log(temp_lock_id);
            $.post("close_lock.php",
            	           {
            	               lock_id:temp_lock_id,
            					username:$("#usernamejs").text()
            	           },
            	            function (data, status) {
            	                if (status == "success") {
            						location.reload();//主界面更新
            						var receive_username=$(data)[0].innerText;
            						if($("#usernamejs").text()==receive_username){
            							alert($(data)[1].innerText);
            						}else{
            							console.log(receive_username);
            							console.log($("#usernamejs").text());
            							alert("用户名错误");
            						}
            	                } else {
            	                    alert("系统错误");
            	                }
            	            });
							
        };
	var usrCloud = new UsrCloud();
	var callback = {
	    USR_onConnAck: USR_onConnAck,
	    USR_onConnLost: USR_onConnLost,
	    USR_onSubscribeAck: USR_onSubscribeAck,
		USR_onRcvRawFromDev: USR_onRcvRawFromDev
	   /*USR_onUnSubscribeAck: USR_onUnSubscribeAck,
	    USR_onRcvParsedDataPointPush: USR_onRcvParsedDataPointPush,
	    USR_onRcvParsedOptionResponseReturn: USR_onRcvParsedOptionResponseReturn,
	    USR_onRcvParsedDevStatusPush: USR_onRcvParsedDevStatusPush,
	    
	    USR_onRcvParsedDevAlarmPush: USR_onRcvParsedDevAlarmPush*/
	};
	//初始化
	usrCloud.Usr_Init("clouddata.usr.cn", 8080, 2, callback);
	//连接
	
	usrCloud.USR_Connect("Zzzyf", hex_md5("123456zhang"));
	//订阅
	
        
	</script>
</head>
<body>
	<div class="bg">
		<div class="header"  >
		<div class="header1">
			<img src="images/head.png" class="img">
			<a href="mainTest.php" class="active">车辆预约</a>
			<a href="userchange.html">修改信息</a>
			<a href="history.php">停车记录</a>
            <a href="./zhifubao/index.php">我要充值</a>
			<div id="info">
				<div id="tri"></div>
				<div id="div2">
					<div class="tipbk">
						<img src="images/head.png" class="img"><span id="usernamejs"><?php echo $_SESSION['username'];?></span>
						<hr style="border-top: 1px solid grey; width:230px;margin-left: 10px;">
					</div>
					<div class="tipbk">
						<img src="images/balance.png" style="float:left; width: 30px; height:30px; margin:7px 50px 0 10px;">
						<span style="font-size: 0.9em;margin-top: 7px;" id="balancejs">
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
	<div>
			<?php	
				
				
				/*
					<script src="js/mqttws31.js"></script>
				    <script src="js/usrCloud.js"></script>
				    <script src="js/jquery-3.2.1.min.js"></script>
				    <script type="text/javascript">
				    	var account="sdktest";
						var password="sdktest";
						usrCloud = new UsrCloud();
						var callback = {
					    	USR_onConnAck: USR_onConnAck,
					    	// USR_onConnLost: USR_onConnLost,
					     //    USR_onSubscribeAck: USR_onSubscribeAck,
					     //    USR_onUnSubscribeAck: USR_onUnSubscribeAck,
					     //    USR_onRcvParsedDataPointPush: USR_onRcvParsedDataPointPush,
					     //    USR_onRcvParsedOptionResponseReturn: USR_onRcvParsedOptionResponseReturn,
					     //    USR_onRcvParsedDevStatusPush: USR_onRcvParsedDevStatusPush,
					        USR_onRcvRawFromDev: USR_onRcvRawFromDev
					        // USR_onRcvParsedDevAlarmPush: USR_onRcvParsedDevAlarmPush
					    	};
				    	function USR_onConnAck(event) {
				        		if(event.code==0){
				        			if(usrCloud.USR_SubscribeDevRaw("00007867000000000001")==0){
				        				console.log('sub success');
				        				publishRawToDev();
				        			}
				        			else{
				        				console.log('sub faild');
				        			}
				        		}else{
				        			console.log('event:',event);
				        		}
				        	}
				        function USR_onRcvRawFromDev(event) {
					        var temp_lock_id = event.payload[0];//字节数组
					        temp_lock_id &= 0x0f;
					        $.post("close_lock.php",
					           {
					               lock_id:temp_lock_id,
									username:$("#usernamejs").text()
					           },
					            function (data, status) {
					                if (status == "success") {
										location.reload();//主界面更新
										var receive_username=$(data)[0].innerText;
										if($("#usernamejs").text()==receive_username){
											alert($(data)[1].innerText);
										}
					                } else {
					                    alert("系统错误");
					                }
					            });
				    	};
				
				    	 function publishRawToDev(){
					    		var dataByte = [];
				        		var s="a00f";
				        		for (var i = 0; i < s.length; i++) {
				           			dataByte[i] = s.charCodeAt(i);
				       			}
				        		stringToUTF8(s, dataByte, 0);
					    		var result2=usrCloud.USR_PublishRawToDev("00007867000000000001",dataByte);
					    		if(result2==0){
					    			console.log("send success");
					    			console.log('data:',dataByte)
					    		}else{
					    			console.log('send error:',result);
					    		}
				    		}
				    		function f2(){
							if(usrCloud.Usr_Init("clouddata.usr.cn", 8080, 2, callback)==0){
					    		console.log('init success');
					    	}
					    	var result1=usrCloud.USR_Connect(account, hex_md5(password));
				        	if(result1==0){
				        		console.log("link success");
				        	}else{
				        		console.log('link error:',result);
				        	}
				        }
				    </script>
				
				
				
				*/
				
				
				
				
			function query_lock(){
			global $db;
			$sq="select lotID,state,username from parkingstate";
			$result=mysqli_query($db,$sq);
			return $result;
			}
			function query_using($username){
				global $db;
				$sq="select lotID from parkingstate where username=\"{$username}\" and state=2";
				$result=mysqli_query($db,$sq);
				return $result;
			}
			$result=query_lock();
			$records=[];
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
			$record[$i-1]=$decision;
			}
			$string=<<<EOD
			<div class="sec1">
    <div style="padding-left: 20%;padding-top: 30px">
    <table border=1 width="285px" color="white"
           cellspacing="10">
        <tr>
            <td class="td1">
                <div style="padding-top: 85px; padding-left: 100px;font-family: 'Microsoft YaHei UI'">
                    <div style="display: -webkit-box;display: -moz-box;-webkit-box-orient: horizontal;-moz-box-orient: horizontal;">
                        <p id="sd">停车位1</p>
                        <div style="padding-top: 25px;padding-left: 35px">
                            <button id="1" class="hvr-round-corners" onclick="deal_lock(1);">{$record[0]}</button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td1">
                <div style="padding-top: 85px; padding-left: 100px;font-family: 'Microsoft YaHei UI'">
                    <div style="display: -webkit-box;display: -moz-box;-webkit-box-orient: horizontal;-moz-box-orient: horizontal;">
                        <p>停车位2</p>
                        <div style="padding-top: 25px;padding-left: 35px">
                            <button id="2" class="hvr-round-corners" onclick="deal_lock(2);">{$record[1]}</button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td1">
                <div style="padding-top: 85px; padding-left: 100px;font-family: 'Microsoft YaHei UI'">
                    <div style="display: -webkit-box;display: -moz-box;-webkit-box-orient: horizontal;-moz-box-orient: horizontal;">
                        <p>停车位3</p>
                        <div style="padding-top: 25px;padding-left: 35px">
                            <button id="3" class="hvr-round-corners" onclick="deal_lock(3);">{$record[2]}</button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td1">
                <div style="padding-top: 85px; padding-left: 100px;font-family: 'Microsoft YaHei UI'">
                    <div style="display: -webkit-box;display: -moz-box;-webkit-box-orient: horizontal;-moz-box-orient: horizontal;">
                        <p>停车位4</p>
                        <div style="padding-top: 25px;padding-left: 35px">
                            <button id="4" class="hvr-round-corners" onclick="deal_lock(4);">{$record[3]}</button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    </div>
    <div style="padding-left:10%;width: 17px;height: auto;padding-top: 30px">
        <div style="width: 17px;height: 50px;background-color: #fbf63a;"></div>
        <div style="width: 17px;height: 50px;background-color: #fbf63a;margin-top: 40px"></div>
        <div style="width: 17px;height: 50px;background-color: #fbf63a;margin-top: 40px"></div>
        <div style="width: 17px;height: 50px;background-color: #fbf63a;margin-top: 40px"></div>
        <div style="width: 17px;height: 50px;background-color: #fbf63a;margin-top: 40px"></div>
        <div style="width: 17px;height: 50px;background-color: #fbf63a;margin-top: 40px"></div>
        <div style="width: 17px;height: 50px;background-color: #fbf63a;margin-top: 40px"></div>
    </div>
    <div style="padding-left: 10%;padding-top: 30px">
        <table border=1 width="285px" color="white"
           cellspacing="10">
        <tr>
            <td class="td2">
                <div style="padding-top: 85px; padding-left: 100px;font-family: 'Microsoft YaHei UI'">
                    <div style="display: -webkit-box;display: -moz-box;-webkit-box-orient: horizontal;-moz-box-orient: horizontal;">
                        <p>停车位5</p>
                        <div style="padding-top: 25px;padding-left: 35px">
                            <button id="5" class="hvr-round-corners" onclick="deal_lock(5);">{$record[4]}</button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td2">
                <div style="padding-top: 85px; padding-left: 100px;font-family: 'Microsoft YaHei UI'">
                    <div style="display: -webkit-box;display: -moz-box;-webkit-box-orient: horizontal;-moz-box-orient: horizontal;">
                        <p>停车位6</p>
                        <div style="padding-top: 25px;padding-left: 35px">
                            <button id="6" class="hvr-round-corners" onclick="deal_lock(6);">{$record[5]}</button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td2">
                <div style="padding-top: 85px; padding-left: 100px;font-family: 'Microsoft YaHei UI'">
                    <div style="display: -webkit-box;display: -moz-box;-webkit-box-orient: horizontal;-moz-box-orient: horizontal;">
                        <p>停车位7</p>
                        <div style="padding-top: 25px;padding-left: 35px">
                            <button id="7" class="hvr-round-corners" onclick="deal_lock(7);">{$record[6]}</button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td2">
                <div style="padding-top: 85px; padding-left: 100px;font-family: 'Microsoft YaHei UI'">
                    <div style="display: -webkit-box;display: -moz-box;-webkit-box-orient: horizontal;-moz-box-orient: horizontal;">
                        <p>停车位8</p>
                        <div style="padding-top: 25px;padding-left: 35px">
                            <button id="8" class="hvr-round-corners" onclick="deal_lock(8);">{$record[7]}</button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    </div>
</div>			
EOD;
			
			
		echo $string;
			if($result=query_using($_SESSION['username'])){
				$num=mysqli_num_rows($result);
				if($num!=0){
				$temp_row=mysqli_fetch_assoc($result);
				echo "<form action=\"close_lock.php\" method=\"post\">
				<input type=\"hidden\" name=\"lock_id\" value=\"{$temp_row['lotID']}\">
				<input type=\"submit\" name=\"close_lock\" value=\"离开\"> 
			</form>";
			}
		}
		?>
	</div>
	<span id="tip"></span>
	<script>
	$(document).ready(function(){
		$(".hvr-round-corners").each(
		function(){
		    //注意此处id值在这里获得在传到下面，否则无法获取到id值
			var id=parseInt($(this).attr("id"));
			if($(this).text()=="正在使用"){
				$(this).css("background","red");
				/*
				setTimeout(function(){
  $.post("close_lock.php",
	           {
	               lock_id:id,
					username:$("#usernamejs").text()
	           },
	            function (data, status) {
	                if (status == "success") {
						location.reload();//主界面更新
						var receive_username=$(data)[0].innerText;
						if($("#usernamejs").text()==receive_username){
							alert($(data)[1].innerText);
						}else{
							console.log(receive_username);
							console.log($("#usernamejs").text());
							alert("用户名错误");
						}
	                } else {
	                    alert("系统错误");
	                }
	            });
	},5000);
	*/
			}else{
				if($(this).text()=="开锁"){
					$(this).css("background","orange");
			}else{
				if($(this).text()=="忙碌"){$(this).css("background","grey");}else{$(this).css("background","green");}
				
			}
			}
		}
		);

       });
		
	</script>
	
</body>
</html>
<?php
mysqli_close($db);
}
?>
