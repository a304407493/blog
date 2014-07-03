一、基本操作
	1.
		模块的划分
	2.
		建表
	3.
		实现模块
			3.1.前台模块的划分
				①登录注册模块
					登录/登出
						加密-防止xss攻击
					注册
					Cookie
				②界面模块
					首页、文章列表页[查询、留言、分类]
						增删改查、分页
				③log模块
			3.2.后台模块的划分
				①登录注册模块
				②验证码模块
				③文章模块
				④留言模块
				⑤标签模块
				⑦统计模块
					访问量
					点击量
					ip地址
				⑧数据备份模块
				⑨用户权限模块
				⑩定时发表文章、定时删除文章模块
				11.log模块
二、API
	模版：
		html模版
		php模版
		note模版
	0.目录的划分
		注意：
			每个目录都有一个index	
		主目录[index.php]

			基本目录[index.php]

				css、font、images、js
				lib、upload
				view——静态页面

			后台目录[index.php]

				admin
					index.php

			日志目录[index.php]

				log

			参考目录[index.php]

			笔记目录[index.php]
				note——存入数据库一份
				静态页面(将静态页面的地址存入数据库一份)

				


	1.登录/登出
		前台登录

		后台登录

	2.注册
	3.xss攻击[md5加密、防止删除]
	4.sql	
	5.分页
	6.sql拼接和防止sql拼接[登录界面(直接登录)、防止删除的时候全部删除]——sql注入
		容易导致的问题：
			用户直接登录
			数据库中的数据被全部删除
		登录界面：
			sql注入：
				用户名：admin'#
				密码：随便输入
			解决sql注入	
				对单引号和双引号进行转义
		在删除页面：
		 	admartdel.php
		 	admcomm.php
		 	错误的写法：	
		 		$sql = 'delete from arttag where artid=' . $artid;
		 		mQuery($sql);
		 	危险点：
		 		容易删除数据库中所有的数据：
		 	攻击方法：
		 		?admartdel.php?act=del&commid=44 + or 1
		 	解决方法：
		 		php的解决方法：
		 			获取的字符串+0——转换为整型
		 		$artid = $_GET('artid')+0;
	7.Cookie
	8.目录的建立
	9.需要做的一些处理
		路径的处理
		Cookie的处理



			



