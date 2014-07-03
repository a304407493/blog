<?php 
/**
* 博客首页
* 
* 博客的展示
*
* 功能：查询最新文章、查询最新评论、查询所有目录、查询所有的标签、查询所有友情链接
*
* @author 18 <zhaoxin_work@sina.cn>
*/

/**************************Root_Document*************************/
$root_document = str_ireplace(str_replace("/","\\",$_SERVER['PHP_SELF']),'',__FILE__);
$root_document = $root_document ."\\";
//注：$root_document=F:\www_php\blog\
/*******************引入-中文乱码-NOTICE-数据库*******************/
//1.定义init配置文件的路径
$init_url = $root_document . "lib/init.php";
//2.引入init文件
require($init_url);
/*******************获取文章列表-分类-没有标签*******************/
/*
//1.
$sql = 'select artid,pubtime,title, catname 
			from art left 
			join cat on art.catid=cat.catid  
		where art.catid>0 order by artid desc
		';
//2.查询一条的时候——获取标签		
$sql = 'select title,content,pubtime,commcount,cat.catname,art.artid,group_concat(tag) as tags from art 
				left join arttag on art.artid = arttag.artid 
				left join cat on art.catid = cat.catid 
		where art.catid>0 order by artid desc ';
*/

/*
$sql = 'select artid,art.catid, cat.catname,userid,nick,pubtime,title,content,comm,
	(select group_concat(tag) from arttag where arttag.artid=art.artid) as tags 
	from art left join cat on art.catid=cat.catid 
	where 1 ' . $where .' order by artid desc limit ' . $offset . ',' . $cnt;
*/		
//子查询效率更为高效——连接查询——有笛卡尔的问题(几何倍数成长)
//接收地址栏上的catid
$catid = $_GET['catid']+0;
if($catid) {
    $where = ' and art.catid=' . $catid;
} else {
    $where = '';
}
//根据发布时间查询
$pubtime_str = $_GET['pubtime'];
//36920
if($pubtime_str){
	$pubtime_date = strtotime($pubtime_str);
	$where = ' and art.pubtime>=' . $pubtime_date . " and art.pubtime<=" . ($pubtime_date+86400);

	//这个日期之前的
	//$where = ' and art.pubtime<' . $pubtime_date;

	//这个日期之后的的
	//$where = ' and art.pubtime>' . ($pubtime_date+86400);


	/*
	秒为时间戳
	$nextDate = strtotime('2014/05/22');
	echo "nextDate:" . $nextDate . "<br/>";
	echo "pubtime_date:" . $pubtime_date . "<br/>";
	echo "相隔:" . ($nextDate-$pubtime_date) . "<br/>";
	echo $pubtime_str . "<br/>";
	echo $pubtime_date . "<br/>";
	echo $pubtime_date+36920 . "<br/>";
	$ceshi = date('Y/m/d',$pubtime_date+36920);
	echo $ceshi . "<br/>";
	*/
}
/*exit();*/
//根据标签查询
$tag = $_GET['tag'];
//效率最低-减少效率的方式-不查询目录-不查询所有的tag——只查询文章名称

// 根据分页参数查询
// 接收分页参数
$page = (int)$_GET['page'];
if($page < 1) {
	$page = 1;
}

// 计算总条数
$num = mGetOne('select count(*) from art'); 


// 调用分页函数
$pages = pagination($num , 2 , $page);

// 每一页显示2条
$cnt = 2;
$offset =  ($page - 1) * $cnt;

if($tag){
	$where = ' and tag="' .  $tag . '"';
	//查询目录和tag效率较低
	$sql = 'select 
				title,content,pubtime,commcount,cat.catname,art.artid,tag as tags
				from art 
				left join cat on art.catid = cat.catid 
				left join arttag on art.artid = arttag.artid  
			where 1 ' . $where . ' and art.catid>0 
			order by artid desc 
			limit ' . $offset . ',' . $cnt;
	
	/*
	//没有查询目录
	$sql = 'select 
				title,content,pubtime,commcount,art.artid,tag as tags
				from art 
				left join arttag on art.artid = arttag.artid  
			where 1 ' . $where . ' and art.catid>0 
			order by artid desc 
			limit ' . $offset . ',' . $cnt;
	*/
}else{
	//catid用来查询目录
	$sql = 'select 
				title,content,pubtime,commcount,cat.catname,art.catid,art.artid,
				(select group_concat(tag) from  arttag where arttag.artid=art.artid) as tags 
				from art 
				left join cat on art.catid = cat.catid 
			where 1 ' . $where . ' and art.catid>0 
			order by artid desc 
			limit ' . $offset . ',' . $cnt;
}




		
/**************************文章列表-获取文章信息**************************/
/*
	$sql = 'select 
				artid,art.catid, cat.catname,userid,nick,pubtime,title,content,comm,(select group_concat(tag) from arttag where arttag.artid=art.artid) as tags 
				from art 
				left join cat on art.catid=cat.catid 
			where 1 ' . $where .' 
			order by artid desc 
			limit ' . $offset . ',' . $cnt;//从第几个开始显示几条
*/
//catid不需要查出来——根据catid查出catname
$sql_all = 'select 
					title,content,pubtime,commcount,catname,artid 

					from art 
					left join cat on art.catid=cat.catid  
			where art.catid>0  
			order by artid desc 
			limit ' . $offset . ',' . $cnt;//还需要一个多对多的arttag表
//$arts = mGetAll($sql_all);

$arts = mGetAll($sql);
//测试数组长度count($arts);
/**************************左侧列表-获取最新博文**************************/
$new_arts = array();
//$sql_new_arts = 'select title from art  where limit 4';//错误
//查询条件
$sql_new_arts = 'select title,artid from art  order by artid desc limit 4';//错误
$new_arts = mGetAll($sql_new_arts);
/**************************左侧列表-获取所有目录**************************/
$sql_cat = "select catname,catid from cat order by catid desc limit 4";
$cats = mGetAll($sql_cat);

/**************************左侧列表-获取所有标签**************************/
//arttag 	artid tag——根据tag查询
//$sql_tag = "select distinct(tag) from arttag order by artid desc limit 4";
//$sql_tag = "select distinct(tag) from arttag order by artid desc";
$sql_tag = "select distinct(tag) from arttag order by artid desc";

$tags = mGetAll($sql_tag);

include($blog_index_url);
//include('./view/blog_index.html');
//include('view/index.html');
?>