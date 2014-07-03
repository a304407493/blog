<?php 
/**
* 用户管理页面
* 
* 文章的表单展示与发布功能
*
* @author 18 <zhaoxin_work@sina.cn>
*/

/*******************引入-中文乱码-NOTICE-数据库*******************/
require_once('../lib/init.php');
/*********************监测用户权限-还没有实现*********************/
// 检测权限
if(checkacc() == false) {
	error('无权限');
}
/*******************获取文章列表-分类-没有标签*******************/
/*
userid
name
pasword
nick
email
lastlogin
*/
$sql = 'select userid,nick,name,pasword,email,lastlogin from user order by userid desc';
$sql_user = 'select nick,email,lastlogin from user order by userid desc';//name password userid

$users = mGetAll($sql_user);

//include(ROOT . '/view/admlist.html');
include(ROOT . '/view/user_model/userlist.html');
//include('/view/user_model/userlist.html');

?>