<?php 
/**
* 用户注册页面
* 
* 用户登录功能
*
* @author zhaoxin <zhaoxin_work@sina.cn>
*/

/*******************引入-中文乱码-NOTICE-数据库*******************/
require_once('./lib/init.php');
/*********************监测用户权限-还没有实现*********************/
/*
// 检测权限-登录不需要监测权限
if(checkacc() == false) {
	error('无权限');
}
*/
/**********************判断POST-引入html文件**********************/
if(empty($_POST)) {
	include_once(ROOT . '/view/register.html');
	//include('./view/register.html');
	exit;
}
/**************************获取用户对象**************************/
/*
	用户暂时的属性：
		userid-id/主键
		name-用户名/主键-登录的时候也需要用到用户名
			UQ-unique/唯一不重复
			NN
		//会不会传入同样的值
		//confirmpassword——前台监测即可——监测正确之后——传入
		password-密码
			varchar(45)
			NN
		nick-显示名称/昵称
		email-电子邮箱
		lastlogin-上次登录时间

		注册时间
		registertime
*/
//建立对象——文章对象
$user = array(); //待插入文章数据,以数组组织

//获取发布时间
$user['lastlogin'] = time();
echo $ser['lastlogin'];
// 检测用户名——获取用户名
if( ($user['name'] = trim($_POST['name'])) == ''  ) {
	error('用户名不能为空');
}

// 检测密码——获取密码
if( ($user['password'] = trim($_POST['password'])) == '' ) {
	error('密码不能为空');
}

// 检测昵称——获取昵称
if( ($user['nick'] = trim($_POST['nick'])) == '' ) {
	error('昵称不能为空');
}

// 检测电子邮箱——获取电子邮箱
if( ($user['email'] = trim($_POST['email'])) == '' ) {
	error('电子邮箱不能为空');
}

/************************数据库-添加用户************************/
if(!mExec($user,'user')) {
	error('注册失败！');
} else {
	success('注册成功！');
}

?>