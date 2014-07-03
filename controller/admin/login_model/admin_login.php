<?php 
/**
* 用户登录页面
* 
* 用户注册功能
*
* @author zhaoxin <zhaoxin_work@sina.cn>
*/
/***************************开启session**************************/
session_start();
/**************************Root_Document*************************/
$root_document = str_ireplace(str_replace("/","\\",$_SERVER['PHP_SELF']),'',__FILE__);
$root_document = $root_document ."\\";
/*******************引入-中文乱码-NOTICE-数据库*******************/
//1.定义init配置文件的路径
$init_url = $root_document . "lib/init.php";
//2.引入init文件
require($init_url);
if(empty($_POST)) {
	if(checkacc() == false || "true" ===$_SESSION['logouted']) {
		include($login_url);exit;
	}else {
		header('Location:'.$admin_location_url);
	}
}
/*else {
	if(checkacc() == false) {
	//1.
		echo "1";
		include($login_url);exit;
	}else {
		echo "2";
		header('Location:'.$admin_location_url);
		
	}
}*/
//echo $user;exit;
/**********************判断POST-引入html文件**********************/
/*
if(empty($_POST)) {
	include($login_url);
//	include('../view/login.html');
	exit;
}
*/
/***************************获取user对象***************************/
//建立对象——文章对象
$user = array(); //待插入文章数据,以数组组织

//获取发布时间
$user['lastlogin'] = time();
// 检测用户名——获取用户名
if( ($user['name'] = trim($_POST['name'])) == ''  ) {
	error('用户名不能为空');
}

// 检测密码——获取密码
if( ($user['password'] = md5(trim($_POST['password']))) == '' ) {
	error('密码不能为空');
}
/*
// 前台监测验证码
if( ($user['password'] = trim($_POST['password'])) == '' ) {
	error('密码不能为空');
}
*/
/*************************数据库-登录验证*************************/
/*$sql = "select count(userid) from user where name = "
		. 
		$user['name'] 
		.
		" and password = " 
		.
		$user['password'];//错误的写法
$sql2 = "select count(userid) from user where name = 'admin' and password = 'admin' ";
$name = $user['name'];
$password = $user['password'];
$sql3 = "select count(userid) from user where name = '$name' and password = '$password' "; 
		
$rs=mQuery($sql3);

$result=mysql_fetch_array($rs);//$info=mysql_fetch_array($rs);
//if(!empty($result))——判断是否为null
 
 $total=$result[0];
 
 //0是false 非零是true
 if($total==1){
 	include_once('admin.php');
 }else if($total==0){
 	error('用户名或密码不正确！');
 }else{
 	error('有两个用户');
 }*/
//最合适的写法-查询出来-并加入cookie中
//$sql4 = "select * from user where name='$name' and password = '$password' limit 1";

$sql4 = "select * from user where name= '" . $user['name'] . "' and password = '" . $user['password'] . "' limit 1";
$user_db = mGetRow($sql4);
$user_db['lastlogin'] = time();

if(!$user_db) {
	$fail = true;
	echo "失败";
	exit();
	include($login_url);
} else {
	//30：关闭浏览器30秒后失效
	$valid_time = time()+(60*60*24*30);//60*60*24*30 ：一个月失效
	//保存到客户端
	setcookie('name',$user_db['name'],$valid_time);//给用户一个name(验证条件1)
	setcookie('checkcode' , ccode($user_db['name']),$valid_time);//给用户一个token(验证条件2)
	setcookie('nick',$user_db['nick'],$valid_time);
	setcookie('lastlogin' , $user_db['lastlogin'],$valid_time);
	//保存到服务器
	$_SESSION['name'] = $user_db['name'];//给服务器一个name
	$_SESSION['nick'] = $user_db['nick'];//给服务器一个nick需要显示的
	$_SESSION['lastlogin'] = $user_db['lastlogin'];//给服务器一个lastlogin需要显示的
	$_SESSION['isLogin'] = "true";//给服务器一个lastlogin需要显示的
	
	header('Location:'.$admin_location_url);//或者include html页面
}

 
?>