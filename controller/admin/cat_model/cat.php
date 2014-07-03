<?php 
/**
* 目录添加页面
* 
* 目录添加功能
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
/*****************************逻辑部分****************************/

/**********************判断POST-引入html文件**********************/
if(empty($_POST)) {
	include($admin_cat_url);
	exit;
}
/**************************获取栏目对象**************************/
//建立对象——栏目对象
$cat = array(); //待插入文章数据,以数组组织

// 检测栏目名称——获取栏目名称
if( ($cat['catname'] = trim($_POST['catname'])) == ''  ) {
	error('栏目不能为空');
}


/********************数据库-添加文章-添加标签********************/
if(!mExec($cat,'cat')) {
	error('栏目发布失败');
} else {
	header('Location:'.$catList);
	exit;
}

?>