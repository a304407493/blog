<?php 
/**
* 后台文章编辑页面
* 
* 文章修改功能
*
*  @author zhaoxin <zhaoxin_work@sina.cn>
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
if(empty($_POST)) {
	//获取id
	$artid = $_GET['artid'];
	//is_numeric是否为数字类型
	if(!is_numeric($artid)) {
		error('参数有误');
	}
	/************************查询某一篇文章***********************/
	$sql = 'select * from art where artid=' . $artid;
	$art = mGetRow($sql);

	if($art === false) {
		error('参数有误');
	}
	/*********************查询某一篇文章的标签********************/
	//列转行
	//一个文章有多个标签——将多行转换为一行
	$sql = 'select group_concat(tag) as tags from arttag where artid=' .$artid;
	/***********************查询出所有的类别**********************/
	//获取对象/数组——元素为属性
	$art['tags'] = mGetOne($sql);
	//获取所有的类别集合/数组——元素为对象/数组
	$sql = 'select catid,catname from cat';
	$cats = mGetAll($sql);
	
	include(ROOT . '/view/admedit.html');
	//include('./view/admedit.html');
	exit;
}
/**************************从数据库中获取文章对象**************************/
//是否应该放到监测后面
// 检测artid是否为数字——修改数据库中获取到的文章对象的id
if( !is_numeric($art['artid'] = $_POST['artid']) ) {
	error('参数有误');
}

// 检测标题——修改数据库中获取到的文章对象的标题
if( ($art['title'] = trim($_POST['title'])) == ''  ) {
	error('标题不能为空');
}

// 检测栏目——修改数据库中获取到的文章对象的栏目
if( !is_numeric($art['catid'] = $_POST['catid']) ) {
	error('栏目选择不正确');
}

// 检测内容——修改数据库中获取到的文章对象的内容
if( ($art['content'] = trim($_POST['content'])) == '' ) {
	error('内容不能为空');
}
//是否有这一片文章
//查询是某个id是否有对应的对象——参考标准是否有属性(属性的总数是否为0)
$sql = 'select count(*) from art where artid=' . $art['artid'];

// 没这篇文章
if(!mGetOne($sql)) {
	error('参数有误');
}
//修改数据库中获取到的文章对象的更新时间
//更新时间为当前时间
$art['lastup'] = time();
/**************************数据库操作-根据id修改文章**************************/

//修改art表
//根据id修改文章
if(!mExec($art,'art','update','artid='.$art['artid'])) {
	error('修改失败');
}
/**************************删除旧标签，再重新添加**************************/
// 处理标签
// 删除旧标签
$sql = 'delete from arttag where artid=' . $art['artid'];
mQuery($sql);

// 获取参数加入到数组中
$tags = $_POST['tags'];
//str_replace 从tags中查找(空字符串 或 分号 或 逗号) 替换为 逗号
//explode     根据逗号 将tags 分割为数组
$tags = explode(',', str_replace(array(' ',';','，'), ',', $tags));
//移除数组中重复的元素
$tags = array_unique($tags);


/**************************数据库操作添加标签**************************/
//修改arttag表
//empty判断数组是否为空——判断对象是否为null——判断是否数组是否有元素
//添加与修改
if(!empty($tags)) {	
	// 获取刚才文章的artid
	$tag['artid'] = $art['artid'];
	$res = true;
	foreach ($tags as $t) {
		$tag['tag'] = $t;
		//mExec 添加对象tag artid + tag/标签/文字——一次添加，一次添加失败为false
		$res = $res && mExec($tag , 'arttag');//默认值添加-添加标签，有一次添加失败，res为false
	}
}

header('Location:'.$adminList);
exit;
?>