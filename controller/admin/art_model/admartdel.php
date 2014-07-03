<?php 
/**
* 后台文章删除页面
* 
* 文章的删除功能
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
/*********************监测用户权限-还没有实现*********************/
// 检测权限
if(checkacc() == false) {
	header('Location:'.$admin_login_location_url);
}
/*****************************获取参数****************************/
// 获取地址栏参数
$artid = $_GET['artid'];

if(!is_numeric($artid)) {
	error('参数非法');
}
/*****************************逻辑部分****************************/
//先删标签
$sql = 'delete from arttag where artid=' . $artid;
mQuery($sql);
//删除文章
$sql = 'delete from art where artid=' . $artid;
/*
	//success('删除成功');
	//include_once(ROOT . '/admlist.php');//必须加‘/ ’//绝对路径是错的
	
	
	//include_once(<?php echo URL_ROOT;?> . 'admin/admlist.php');//添加admin
	//include 'admlist.php';
	exit;
*/
if(mQuery($sql)) {
	header('Location:'.$adminList);
}else {
	error('删除失败');
}

?>