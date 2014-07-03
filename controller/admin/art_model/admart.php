<?php 
/**
* 后台文章发布页面
* 
* 文章的表单展示与发布功能
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
/************************查询出所有的类别***********************/
//获取所有的类别集合/数组——元素为对象/数组
$sql_cat = 'select catid,catname from cat';
$cats = mGetAll($sql_cat);
/**********************判断POST-引入html文件**********************/
if(empty($_POST)) {
	include($admin_art_url);
	exit;
}
/**************************获取文章对象**************************/
//建立对象——文章对象
$art = array(); //待插入文章数据,以数组组织

//获取发布时间
$art['pubtime'] = time();

// 检测标题——获取标题
if( ($art['title'] = trim($_POST['title'])) == ''  ) {
	error('标题不能为空');
}

// 检测栏目——获取栏目
if( !is_numeric($art['catid'] = $_POST['catid']) ) {
	error('栏目选择不正确');
}

// 检测内容——获取内容
if( ($art['content'] = trim($_POST['content'])) == '' ) {
	error('内容不能为空');
}
/********************数据库-添加文章-添加标签********************/
if(!mExec($art,'art')) {
	error('文章发布失败');
} else {
	//1.1获取标签——标签对象/数组
	$tags = $_POST['tags'];
	//1.2处理标签
	$tags = explode(',', str_replace(array(' ',';','，'), ',', $tags));//分割为数组
	$tags = array_unique($tags);//去重

	if(empty($tags)) {
		success('发布失败');
	} else {	
		//取出文章的id-添加到标签对象-数组中
		$tag['artid'] = getLastId();
		//循环添加标签
		$res = true;
		foreach ($tags as $t) {
			$tag['tag'] = $t;
			$res = $res && mExec($tag , 'arttag');
		}
		//添加标签失败之后
		if($res) {
			header('Location:'.$adminList);
			exit;
		//删除文章
		} else {
			$sql = 'delete from art where artid=' . $tag['artid'];
			mQuery($sql);
			error('发布失败');
		}
	}
}

?>