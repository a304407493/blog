<?php 
/**
* 用户登录页面
* 
* 用户注册功能
*
* @author zhaoxin <zhaoxin_work@sina.cn>
*/

/*****************************BaseUrl****************************/
$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://' ? 'https://' : 'http://';
$hostName = $_SERVER['HTTP_HOST'];
$currentPath = $_SERVER['PHP_SELF'];$pathInfo = pathinfo($currentPath);
$baseUrl = $protocol.$hostName.$pathInfo['dirname']."/";
/**************************Root_Document*************************/
$root_document = str_ireplace(str_replace("/","\\",$_SERVER['PHP_SELF']),'',__FILE__);
$root_document = $root_document ."\\";
/*************************all-url-config*************************/
//1.设置include的作用域
//view
define('VIEW_PATH',$root_document . '/view');//绝对路径
define('COMM_PATH',$root_document . '/view/comm');//绝对路径
set_include_path(get_include_path() . PATH_SEPARATOR . VIEW_PATH . PATH_SEPARATOR . COMM_PATH);
//2.定义路径
//login路径-Location[header]
$admin_login_url = "/controller/admin/admin_login.php";
//init路径-require
$init_url = $root_document . "lib/init.php";
//admin路径-include
$admin_url = "admin.html";
//header.php路径-include
$header_url = "header.php";
$title_url = "title.php";
$login_url = "login.html";
/*******************引入-中文乱码-NOTICE-数据库*******************/
require($init_url);
//错误写法：require("/lib/init.php");
/*************************all-url-config*************************/
//css路径
$bootstrap =  URL_ROOT . "/css/bootstrap.min.css";
$adminIndex = URL_ROOT . "/controller/admin/admin.php";
$adminList = URL_ROOT . "/controller/admin/admlist.php";
$catList = URL_ROOT . "/cat_model/catlist.php";
//此处没有使用
$addArt = URL_ROOT . "/controller/admin/admart.php";
//用户管理路径
//$URL_ROOT . "/admin/admlist.php";
//评论管理路径
//$URL_ROOT . "/admin/admlist.php";
//友情链接管理路径
//$URL_ROOT . "/admin/admlist.php";


/*********************监测用户权限-还没有实现*********************/
/*
// 检测权限-登录不需要监测权限
if(checkacc() == false) {
	error('无权限');
}
*/
/**********************判断POST-引入html文件**********************/
echo "test";
exit();
if(empty($_POST)) {
	
//	echo $title_url;
//	exit();

	include($login_url);
//	exit;
}

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
/*
	$sql = "select count(userid) from user where name = "
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
		//success('登录成功！');
	}else if($total==0){
		error('用户名或密码不正确！');
	}else{
		error('有两个用户');
	}
*/
//最合适的写法-查询出来-并加入cookie中
$sql4 = "select * from user where name= '" . $user['name'] . "' and password = '" . $user['password'] . "' limit 1";
mLog($sql4);
//exit();
/*
echo $sql4;
exit();
*/
$user_db = mGetRow($sql4);
$user_db['lastlogin'] = time();

//if(empty($user_db)) {//错误的写法
if(!$user_db) {//没有登录
	$fail = true;
	echo $title_url;
	exit();
	include($login_url);
} else {
	setcookie('name',$user_db['name']);
	setcookie('nick',$user_db['nick']);
	setcookie('checkcode' , ccode($user_db['name']));
	setcookie('lastlogin' , ccode($user_db['lastlogin']));
	//success('登录成功！');
	//转入
	
	header('Location: blog_index.php');
}
 
?>