<?php 
/**
* 文章展示页面
* 
* 前台页面
*
* 查询文章内容、评论、栏目
*
* @author zhaoxin <zhaoxin_work@sina.cn>
*/


/*******************引入-中文乱码-NOTICE-数据库*******************/
//include/require  include_once/require_once
//require('./lib/init.php');
require_once('./lib/init.php');


if(!empty($_GET)) {
	//获取id
	$artid = $_GET['artid'];


	//is_numeric是否为数字类型
	if(!is_numeric($artid)) {
		error('参数有误');
	}

	/*
	//1.
	$sql = 'select * from art where artid=' . $artid;//此条语句效率不够高
	//2.
	$sql = 'select title,content,pubtime,commcount,cat.catname,artid from art left join cat on art.catid = cat.catid 
			 where 1 and art.artid=' . $artid;
	//3.
	$sql = 'select art.catid cat.catname,userid,nick,pubtime,title,content,(select group_concat(tag) from arttag where 
		arttag.artid=art.artid)as tags from tag left join cat on art.catid = cat.catid where 1' .where .' order by artid desc limit 5'
	*/		 
	//4.	
	//commcount——评论总数其实是不需要的——blog的首页需要查询commcount
	$sql = 'select title,content,pubtime,commcount,cat.catname,art.artid,group_concat(tag) as tags from art 
				left join arttag on art.artid = arttag.artid 
				left join cat on art.catid = cat.catid 
			 	where 1 and art.artid=' . $artid;
	 
	/************************查询某一篇文章***********************/
	$art = mGetRow($sql);
	
	/*
	if($art === false) {
		error('参数有误');
	}
	*/

	/*********************查询这一篇文章的标签********************/
	/*
	//列转行
	//一个文章有多个标签——将多行转换为一行
	$sql = 'select group_concat(tag) as tags from arttag where artid=' .$artid;
	//获取对象/数组——元素为属性
	$art['tags'] = mGetOne($sql);
	*/
	/***********************查询出所有的类别**********************/
	/*
	//获取所有的类别集合/数组——元素为对象/数组
	$sql = 'select catid,catname from cat';
	$cats = mGetAll($sql);
	*/
	//include_once('view/blog_art.html');
	//exit;
	//	include('./view/blog_art.html');
	}
	/**************************获取最新博文**************************/
	$new_arts = array();
	//$sql_new_arts = 'select * from art  where limit 4';//错误
	$sql_new_arts = 'select * from art  limit 4';//错误

	$new_arts = mGetAll($sql_new_arts);
	
	/**************************获取所有目录**************************/
	$slq_cat = "select * from cat limit 4";
	$cats = mGetAll($slq_cat);
	/**************************获取所有标签**************************/
	//arttag 	artid tag——根据tag查询
	$slq_tag = "select * from arttag limit 4";
	$tags = mGetAll($slq_tag);
	include('./view/blog_art.html');
?>