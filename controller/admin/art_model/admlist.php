<?php 
/**
* 文章列表页面
* 
* 文章的表单展示与发布功能
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
//echo $init_url;exit;
require($init_url);
/*********************监测用户权限-还没有实现*********************/
// 检测权限
if(checkacc() == false) {
	header('Location:'.$admin_login_location_url);
}
/*****************************逻辑部分****************************/

/*******************获取文章列表-分类-没有标签*******************/
$sql = 'select artid,pubtime,title, catname from art left join cat on art.catid=cat.catid  where art.catid>0 order by artid desc';

$arts = mGetAll($sql);

include($admin_artlist_url);
?>