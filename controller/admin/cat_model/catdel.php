<?php 
/**
* 目录删除删除页面
* 
* 目录的删除功能
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

/*****************************逻辑部分****************************/

/*****************************获取参数****************************/
// 获取地址栏参数
$catid = $_GET['catid'];

if(!is_numeric($catid)) {
	//error($catid);
	error('参数非法');
}
/*****************************逻辑部分****************************/
//先删标签
$sql = 'delete from cat where catid=' . $catid;
//mQuery($sql);
//删除文章
//$sql = 'delete from art where artid=' . $artid;

if(mQuery($sql)){
	header('Location:'.$catList);
	exit;
}else{
	error('删除失败');
}

?>
