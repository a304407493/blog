<?php 
/***************************开启session**************************/
session_start();
/**************************Root_Document*************************/
$root_document = str_ireplace(str_replace("/","\\",$_SERVER['PHP_SELF']),'',__FILE__);

$root_document = $root_document ."\\";
/*******************引入-中文乱码-NOTICE-数据库*******************/
//1.定义init配置文件的路径
$init_url = $root_document . "lib/init.php";
//2.引入init文件
//echo $init_url;exit;
require($init_url);

setcookie('name','',0);
setcookie('nick','',0);
//setcookie('checkcode','',0);
//setcookie('lastlogin','',0);
//setcookie('PHPSESSID','',0);
//setcookie('isLougout',"true",10000);//有它前面的可以去掉
//如果想要以上代码生效，下次才可以
//echo $_COOKIE;exit;


//在客户端无法置空$_COOKIE=array();//
var_dump($_COOKIE);
/*
//1.$_SESSION=array();//2.unset($_session['xxx'])
$_SESSION=array();//删除内存中的session信息
session_destroy();//删除磁盘上的session信息
*/
$_SESSION['isLogin'] = "false";
header('Location:'.$admin_login_location_url);
//header('Location: ' . $admin_login_url);
//header('Location: blog_index.php');

?>