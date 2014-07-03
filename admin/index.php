<?php 
/**
* 博客首页
* 
* 博客的展示
*
* @author 18 <zhaoxin_work@sina.cn>
*/
/***************************开启session**************************/
session_start();
/**************************Root_Document*************************/
$root_document = str_ireplace(str_replace("/","\\",$_SERVER['PHP_SELF']),'',__FILE__);
$root_document = $root_document ."\\";//物理路径
/*******************引入-中文乱码-NOTICE-数据库*******************/
//1.定义init配置文件的路径
$init_url = $root_document . "lib/init.php";
//2.引入init文件
require($init_url);
/*******************检测权限-登录不需要监测权限*******************/
if(checkacc() == false) {
	header('Location:'.$admin_login_location_url);
}


/*******************获取文章列表-分类-没有标签*******************/
$sql = 'select artid,pubtime,title, catname from art left join cat on art.catid=cat.catid  where art.catid>0 order by artid desc';
//catid不需要查出来——根据catid查出catname
$sql_all = 'select artid,title,content,pubtime,catname from art left join cat on art.catid=cat.catid  where art.catid>0 order by artid desc';
$arts = mGetAll($sql_all);
/**************************获取最新博文**************************/
$new_arts = array();
//$sql_new_arts = 'select * from art  where limit 4';//错误
$sql_new_arts = 'select * from art  limit 4';//错误
$new_arts = mGetAll($sql_new_arts);
include($admin_url);
?>