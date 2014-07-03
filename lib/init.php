<?php 
/**
* 写成初始化工作
*
* 引入重要库文件,计算网站根目录,过滤非法字符等等
*/
/****************************定义编码****************************/
header('content-type:text/html; charset=utf-8');
/************************定义include作用域***********************/
define('VIEW_PATH',$root_document . 'view');//绝对路径
define('COMM_PATH',$root_document . 'view/comm');//绝对路径
define('COMM_CAT_PATH',$root_document . 'view/comm/cat_model');//绝对路径
define('LOGIN_PATH',$root_document . 'controller/admin/login_model/');//绝对路径
define('ADMIN_PATH',$root_document . 'controller/admin/');//绝对路径
set_include_path(get_include_path() . PATH_SEPARATOR . VIEW_PATH . PATH_SEPARATOR . COMM_PATH . PATH_SEPARATOR . COMM_CAT_PATH . PATH_SEPARATOR . LOGIN_PATH . PATH_SEPARATOR . ADMIN_PATH);
/****************************定义目录****************************/
/***1.定义根目录***/
define('ROOT',dirname(dirname(__FILE__)));//ROOT路径是内部跳转，http是再次请求
/***2.1.定义项目名称***/
define('PROJECT_NAME',"my_blog");									//手动定义项目名
/***2.2.定义域名***/
define('SERVER_NAME',$_SERVER['SERVER_NAME']);						//只包含域名[没有http等]		blog.com
define('URL_ROOT',"http://" . SERVER_NAME);						  	//不包含项目名称				http://blog.com
define('URL_PROJECT',"http://" . SERVER_NAME . "/" . PROJECT_NAME);	//包含项目名称[不需要项目名]	http://blog.com/my_blog
/*****************************BaseUrl****************************/
$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://' ? 'https://' : 'http://';
$hostName = $_SERVER['HTTP_HOST'];									//只包含域名[没有http等]		blog.com 				echo $hostName . "<br/>";
$currentPath = $_SERVER['PHP_SELF'];								//文件路径不包含域名			/admin/index.php 		echo $currentPath . "<br/>";
$pathInfo = pathinfo($currentPath);									//函数转化为数组				Array 					echo $pathInfo . "<br/>";
$baseUrl = $protocol.$hostName.$pathInfo['dirname']."/";			//域名+当前目录				http://blog.com/admin/ 	echo $baseUrl . "<br/>";
/*************************all-url-config*************************/
/***1.Location[header]路径***/
//login路径
$admin_login_location_url = "/controller/admin/login_model/admin_login.php";
$admin_location_url = "/controller/admin/admin.php";
/***2.inlude路径***/
//错误写法：require("/lib/init.php");
//后台：
	//后台首页
	$admin_url = "admin.html";
	$admin_include_url = "admin.html";
	$admin_php_include_url = "admin.php";
	//登录路径
	$login_url = "login.html";
	$admin_login_include_url = "admin_login.php";
	//后台左侧路径-[暂未使用]
	$admin_left_url = "admin_left.php";
	//文章模块
		//管理
		$admin_artlist_url = "admlist.html";
		//发表文章
		$admin_art_url = "admart.html";
	//栏目模块
		//管理
		$admin_catlist_url = "catlist.html";
		$admin_cat_url = "cat.html";
		
//前台：
	//头部
	$header_url = "header.php";
	//标签
	$title_url = "title.php";
	//文章列表
	$list_url = "list.php";
	//左侧
	$left_url = "left.php";
	//前台首页
	$blog_index_url = "blog_index.html";
	//前台文章页
	$blog_art_url = 'blog_art.html';
	//前台留言页
	$message_url = 'message.html';
	
/***3.css和a标签路径和***/
$bootstrap =  URL_ROOT . "/css/bootstrap.min.css";
//后台首页路径
$adminIndex = URL_ROOT . "/controller/admin/admin.php";
//文章管理路径
$adminList = URL_ROOT . "/controller/admin/art_model/admlist.php";
//添加文章路径
$addArt = URL_ROOT . "/controller/admin/art_model/admart.php";
//目录管理路径
$catList = URL_ROOT . "/controller/admin/cat_model/catlist.php";
$cat = URL_ROOT . "/controller/admin/cat_model/cat.php";
//用户管理路径
//$URL_ROOT . "/admin/admlist.php";
//评论管理路径
//$URL_ROOT . "/admin/admlist.php";
//友情链接管理路径
//$URL_ROOT . "/admin/admlist.php";
/***4.require路径***/
/***Root_Document***/
//$root_document = str_ireplace(str_replace("/","\\",$_SERVER['PHP_SELF']),'',__FILE__);
//$root_document = $root_document ."\\";
/***定义func库的路径***/
//echo $_SERVER['PHP_SELF'] . "<br/>";
//将'/'转换为'\'
//echo str_replace("/","\\",$_SERVER['PHP_SELF']) . "<br/>";
//文件：绝对物理路径
//echo __FILE__ . "<br/>";
//绝对物理路径通过str_ireplace函数以及'项目中的路径'获得项目的根目录
//$root_document = str_ireplace(str_replace("/","\\",$_SERVER['PHP_SELF']),'',__FILE__);
//echo $root_document;//F:\www_php\blog\lib\init.php\
//exit();
$func_url = $root_document . "lib/func.php";
require($func_url);//F:\www_php\blog\lib\init.php\lib\func.php
//require_once("lib/func.php");
//echo ROOT . '/lib/func.php';//F:\www_php\blog/lib/func.php
//exit();
//require_once(ROOT . '/lib/func.php');
//require_once("F:\www_php\blog/lib/func.php");
//require("F:\www_php\blog/lib/func.php");





/*
未必能获取到项目名——目录结构的原因
$url = $_SERVER['PHP_SELF'];
$arr = explode( '/' , $url );
$dirname = $arr[count($arr)-2];//未必能获取到项目名——目录结构的原因
define('PROJECT_NAME',$dirname);
define('URL_ROOT',SERVER_NAME . "/" . PROJECT_NAME);
*/
//校验码
define('CKEY' , '#%)$_(WKFL:DSK<":LL00');
require_once(ROOT . '/lib/func.php');

error_reporting(E_ALL & ~E_NOTICE);

/*
获取文件名的三种方法：
 $url = $_SERVER['PHP_SELF'];
 //1.——截取字符串第几位
 echo $url;echo "<br/>";
 echo strrpos($url , '/');echo "<br/>";
 $filename= substr( $url , strrpos($url , '/')+1 );
 echo $filename;
 echo "<br/>";
 echo $url;
 echo "<br/>";
 //2.
 $arr = explode( '/' , $url );
 $filename = $arr[count($arr)-1];
 $dirname = $arr[count($arr)-2];
 echo "dir:" . $dirname;echo "<br/>";echo "<br/>";echo "<br/>";
 echo $filename;
 echo "<br/>";
 //3.
 $filename = end(explode('/',$url));
 echo $filename;
 */

/*
未测试
echo $_SERVER['SERVER_NAME'];
//获取来源网址,即点击来到本页的上页网址
echo $_SERVER["HTTP_REFERER"];
$_SERVER['REQUEST_URI'];//获取当前域名的后缀
$_SERVER['HTTP_HOST'];//获取当前域名
dirname(__FILE__);//获取当前文件的物理路径
dirname(__FILE__)."/../";//获取当前文件的上一级物理路径
*/
?>