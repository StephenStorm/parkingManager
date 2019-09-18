<?php
$string="qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
$verify='';
for($i=0;$i<4;$i++){
	$verify.='<span style="color:rgb('.mt_rand(0,255).','.mt_rand(0,255).','.mt_rand(0,255).')">'.$string{mt_rand(0,strlen($string)-1)}.'</span>';
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>
		用户登录
	</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<section>
		<div>
			<div class="container">
				<div class="header">
					<div>

						<a href="userRegist.html" id="a1">我要注册</a>
						<label class="lbl-1"></label>
						<label class="lbl-2"></label>
						<label class="lbl-3"></label>
					</div>
					
				</div>
				<div class="head"> 
					<img src="images/head.png" width="65px" height="65px" align="ccenter" />
					<form action="do_login.php" method="post">
					<div class="input1">
						<img src="images/user.png">
						<input type="text" name="username" placeholder="用户名" pattern="\w{4,20}" required="required">
					</div>

					
					<div class="input1">
						<img src="images/pswd.png">
						<input type="password" name="passwd" placeholder="密码" pattern="\w{8,20}" required="required">
					</div>
					<div class="input1">
						<img src="images/pass.png">
						<input type="text" name="verify" placeholder="验证码" pattern="\w{4}" required="required">
					</div>
					
					<div style="margin-top: 10px;" >
						<?php echo $verify; ?>
					</div>

					<input type="hidden" name="verify_generate" value='<?php echo strip_tags($verify);?>'>
					<div>
						<input type="submit" class="sub1" name="login" value="登陆">
					</div>
				</form>
				</div>
	
			</div>
		</div>
	</section>
	
</body>
</html>