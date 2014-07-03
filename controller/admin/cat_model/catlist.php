<?php 
/**
* 目录列表页面
* 
* 目录列表功能
*
* @author 18 <zhaoxin_work@sina.cn>
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
/*****************************逻辑部分****************************/

/****************************目录列表****************************/
$sql = 'select catid,catname,artcount from cat order by catid desc';
$sql_valid = 'select catid,catname,artcount from cat order by catid desc';

$cats = mGetAll($sql_valid);
include($admin_catlist_url);

?>