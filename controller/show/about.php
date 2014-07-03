<?php 
/**
* 关于我的页面
* 
* 前台页面
*
* 关于我
*
* @author zhaoxin <zhaoxin_work@sina.cn>
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

// 接收地址栏上的文章id
$artid = $_GET['artid']+0;

//POST为提交评论
if(!empty($_POST)) {
	//1.建立对象
    $comm = array();
    //2.添加属性
    $comm['artid'] = $artid;//外键——必须添加——外键1452
    $comm['userid'] = 0;//外键——必须添加——外键1452——默认0——游客//必须有对应的值1452
	//Cannot add or update a child row
    $comm['nick'] = $_POST['nick'];
    $comm['content'] = $_POST['content'];
    $comm['pubtime'] = time();
    $comm['ip'] = ip2long(real_ip());
	/*
    echo $comm['artid'] . "<br/>";
    echo $comm['nick'] . "<br/>";
    echo $comm['content'] . "<br/>";
    echo $comm['pubtime'] . "<br/>";
    echo $comm['ip'] . "<br/>";
    */
    //exit();
    session_start();
    /*
    	测试验证码
     echo "1" . strtolower($_SESSION['vercode']) . "<br/>";
     echo "2" . strtolower($_POST['vercode']) . "<br/>";
    */	
    //3.验证码比较——与session中的验证码进行比较
    if(strtolower($_POST['vercode']) != strtolower($_SESSION['vercode'])) {
        echo 'fail';
        exit;
    }

    
    //4. ①数据库添加评论	②评论的时候修改文章评论的个数
    if(mExec($comm , 'comm')) {
        $sql = 'update art set commcount=commcount+1 where artid=' . $artid;
        mQuery($sql);

        // 如果是ajax请求,则返回 succ,或fail,并结束
        if($_POST['agent'] == 'ajax') {
            echo 'succ';
            exit;
        }
    }else{
    	if($_POST['agent'] == 'ajax') {
	        echo 'fail';
	        exit;
	    }else{
	    	echo "fail-不是ajax";
    		exit();
	    }

    	
    }
}

//POST为显示页面
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
	/**************************获取所有评论**************************/
	//arttag 	artid tag——根据tag查询
	$slq_comm = "select * from comm limit 4";
	$comms = mGetAll($slq_comm);
	include($blog_art_url);
}
	
?>