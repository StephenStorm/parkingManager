<?php
$param=['host'=>'localhost',
'user'=>'root',
'password'=>'971016',
'database'=>'parking',
'charset'=>'utf8'
];
$parkName='1号停车场';
date_default_timezone_set('Asia/Shanghai');
mb_internal_encoding('UTF-8');
$db=mysqli_connect($param['host'],$param['user'],$param['password'],$param['database']);
if(!$db){
    exit('数据库连接失败:'.mysqli_connect_error());
}
mysqli_set_charset($db,$param['charset']);
?>