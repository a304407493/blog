<?php 
	
	/**
	*	1.2.中文乱码的解决方案：
	*/
	header('Content-Type:text/html;charset=utf-8');
	/**
	*   1.1.
	*		html 应用css或者js时是相对于主文件的
	*	
	*		当从note.php文件进入时，主目录为note.php
	*
	*		因此需要将css、js、images等文件复制到主目录位置
	*	1.2.
	*		中文乱码解决：
	*			header('Content-Type:text/html;charset=utf-8');
	*	1.3.
	*		输出html文件：
	*			include('html文件');
	*
	*/
	echo 
	"<pre>
		1.1.
			html 应用css或者js时是相对于主文件的
		
			当从note.php文件进入时，主目录为note.php

			因此需要将css、js、images等文件复制到主目录位置
		1.2.
			中文乱码解决：
				header('Content-Type:text/html;charset=utf-8');
		1.3.
			输出html文件：
				include('html文件');
	</pre>";
	echo 
	"
	<span style='margin-left:125px;'><a href='./note/include.php'>1.输出html文件</a></span>
	<br/><br/><br/>
	<hr/>
	";
	/**
	*   2.1.	
	*		输出目录：dirname(__FILE__)
	* 	2.2.
	*	 	输出目录的目录：dirname(dirname(__FILE__))
	*/
	echo 
	"<pre>
		2.1.	
			输出目录：dirname(__FILE__)
		2.2.
		 	输出目录的目录：dirname(dirname(__FILE__))
	</pre>";
	echo 
	"
	<span style='margin-left:125px;'>"
	.	dirname(__FILE__) 
	.  "<br/>"
	.
	"</span>
	<span style='margin-left:125px;'>"
	.   dirname(dirname(__FILE__))
	.   "<br/>"
	.
	"</span>
	<br/><br/><br/>
	<hr/>
	";
	/**
	*   3.1.	
	*		定义常量：define('ROOT',dirname(dirname(__FILE__)));
	*	3.2.
	*		输出加上分号
	*/
	echo 
	"<pre>
		3.1.	
			定义常量：define('ROOT',dirname(dirname(__FILE__)));
	</pre>";
	//3.1定义常量
	define('ROOT',dirname(dirname(__FILE__)));
	//3.2输出加上分号
	echo
		"
			<span style='margin-left:125px;'>
		"
		.	ROOT//不能加分号否则echo中断
		.   
		"
			</span>
			<br/><br/><br/>
			<hr/>
		";
	
	/**
	*   4.	
	*		关闭Notice错误-error_reporting(E_ALL & ~E_NOTICE);
	*	
	*/
	error_reporting(E_ALL & ~E_NOTICE);
	echo 
	"<pre>
		4.	
			关闭Notice错误-error_reporting(E_ALL & ~E_NOTICE);
		<br/><br/><br/>
		<hr/>
	</pre>";
	/**
	*   5.	
	*		php文件，在开头部分需要初始化工作
	*			5.1：避免中文乱码
	*				header('content-type:text/html; charset=utf-8');
	*			5.2：定义项目路径
	*				define('ROOT',dirname(dirname(__FILE__)));
	*			5.3：引入库文件
	*				require(ROOT . '/lib/func.php');
	*			5.4：关闭Notice错误
	*				error_reporting(E_ALL & ~E_NOTICE);
	*	
	*/
	echo
	"<pre>
		4.	
			php文件，在开头部分需要初始化工作
				5.1：避免中文乱码
					header('content-type:text/html; charset=utf-8');
				5.2：定义项目路径
					define('ROOT',dirname(dirname(__FILE__)));
				5.3：引入库文件
					require(ROOT . '/lib/func.php');
				5.4：关闭Notice错误
					error_reporting(E_ALL & ~E_NOTICE);
		<br/><br/><br/>
	</pre>";	
	echo 
		"
			<span style='margin-left:125px;'><a href='lib/init.php'>
				init.php
			</a>
			</span>
			<br/><br/><br/>
			<hr/>
		";
	/**
	*   6.	
	*		库文件
	*			数据库相关的函数：func.php
	*				1.用户权限监测
	*				2.错误页面
	*				3.成功页面
	*				4.返回数据库资源——conn
	*				5.查询语句
	*				6.查询语句——处理后，返回一个属性/标量-mGetOne
	*					取出一行生成枚举数据类型
	*					mysql_fetch_row——得到一个对象，在得到一个属性
	*					取出一行——偏移量从0开始,不能用字段名来取值
	*
	*					通过mysql_fetch_row 将rs处理为枚举类型
	*					并返回第一个字段/属性/对象的属性
	*				7.查询语句——处理后，返回一个对象/数组-mGetRow
	*					取出一行生成数组类型
	*					mysql_fetch_assoc——得到一个对象
	*					取出一行——只能用字段名，不能用索引来取值
	*					返回一个一维数组
	*					
	*					通过mysql_fetch_assoc将rs处理为数组类型——返回对象
	*				8.查询语句——没有处理，或返回一个集合/二维数组
	*
	*					通过mysql_fetch_assoc将rs处理为数组类型，需要多次处理
	*					并存放到另一个数组中，形成二维数组
	*				9.添加和修改
	*
	*	
	*/	
	echo
	"<pre>
		6.库文件
				数据库相关的函数：func.php
					1.用户权限监测
					2.错误页面
					3.成功页面
					4.返回数据库资源——conn
					5.查询语句
					6.查询语句——处理后，返回一个属性/标量-mGetOne
						取出一行生成枚举数据类型
						mysql_fetch_row——得到一个对象，在得到一个属性
						取出一行——偏移量从0开始,不能用字段名来取值
	
						通过mysql_fetch_row 将rs处理为枚举类型
						并返回第一个字段/属性/对象的属性
					7.查询语句——处理后，返回一个对象/数组-mGetRow
						取出一行生成数组类型
						mysql_fetch_assoc——得到一个对象
						取出一行——只能用字段名，不能用索引来取值
						返回一个一维数组
						
						通过mysql_fetch_assoc将rs处理为数组类型——返回对象
					8.查询语句——没有处理，或返回一个集合/二维数组
	
						通过mysql_fetch_assoc将rs处理为数组类型，需要多次处理
						并存放到另一个数组中，形成二维数组
					9.添加和修改
		<br/><br/><br/>
	</pre>";
	echo 
		"
			<span style='margin-left:125px;'><a href='lib/func.php'>
				func.php
			</a>
			</span>
			<br/><br/><br/>
			<hr/>
		";
	/**
	*   7.	
	*		文章添加页面
	*			数据库相关的函数：func.php
	*				1.引入init.php
	*				2.监测用户权限
	*				3.POST是否为null
	*				4.监测标题、内容是否为null；栏目是否为数字
	*				5.查询语句
	*				6.查询语句——处理后，返回一个属性/标量-mGetOne
	*					取出一行生成枚举数据类型
	*					mysql_fetch_row——得到一个对象，在得到一个属性
	*					取出一行——偏移量从0开始,不能用字段名来取值
	*
	*					通过mysql_fetch_row 将rs处理为枚举类型
	*					并返回第一个字段/属性/对象的属性
	*				7.查询语句——处理后，返回一个对象/数组-mGetRow
	*					取出一行生成数组类型
	*					mysql_fetch_assoc——得到一个对象
	*					取出一行——只能用字段名，不能用索引来取值
	*					返回一个一维数组
	*					
	*					通过mysql_fetch_assoc将rs处理为数组类型——返回对象
	*				8.查询语句——没有处理，或返回一个集合/二维数组
	*
	*					通过mysql_fetch_assoc将rs处理为数组类型，需要多次处理
	*					并存放到另一个数组中，形成二维数组
	*				9.添加和修改
	*
	*	
	*/	
	/**
	*   5.1.	
	*		连接数据库 
	*			static $conn = null;
	*			$conn = mysql_connect('localhost', 'root' , 'admin');//记得判断null
	*				mysql_query('use blog' , $conn);//设置1
	*				mysql_query('set names utf8' , $conn);//设置2
	*	5.2.
	*		return $conn;
	*/
	echo 
	"<pre>
		5.1.	
			连接数据库 
				static $conn = null;
				$conn = mysql_connect('localhost', 'root' , 'admin');//记得判断null
					mysql_query('use blog' , $conn);//设置1
					mysql_query('set names utf8' , $conn);//设置2
		5.2.
			return $conn;
	</pre>";
	//1.
	/**
	* 连接数据库
	* @return resource 成功返回一个资源
	*/
	function getConn() {
		static $conn = null;

		if($conn === null) {
			$conn = mysql_connect('localhost', 'root' , 'admin');
			mysql_query('use blog' , $conn);
			mysql_query('set names utf8' , $conn);
		}

		return $conn;
	}

	//2.
	echo 
		"
			<span style='margin-left:125px;'>获取到的资源id：
		"
		.   getConn()
		.
		"
			</span>
			<br/><br/><br/>
			<hr/>
		";
	/**
	*   6.1.	
	*		获取资源$conn
	*			$conn = getConn();
	*	6.2.
	*		查询语句
	*			mysql_query($sql,$conn);
	*   6.3.
	*		sql
	*			添加
	*				sql_add = "insert into art (pubtime,title,content) values (pubtime,'title','content')";
	*				
	*/	
	echo 
	"<pre>
		6.1.	
			获取资源conn
				conn = getConn();
		6.2.
			查询语句
				mysql_query(sql,conn);
	</pre>";
	//1.查询函数
	/**
	* 执行查询语句
	* @param string $sql 查询非select语句
	* return boolean 返回布尔型
	*/
	function mQuery($sql) {
		$conn = getConn();
		return mysql_query($sql,$conn);
	}
	//2.
	$pubtime = time();
	$title = 'title';
	$content = 'content';
	//添加art
	$sql_add_art = "insert into art (pubtime,title,content) values ($pubtime,'$title','$content')";
	//删除-根据artid删除
	$sql_delete_art = "delete from art where artid=" . $tag['artid'];
	//修改-先查询，后修改
	$sql_edit_art = "update art set title=$title,content=$content,catid=$catid";
	//查询art
	$sql_select_art = "select artid,pubtime,title
						from art
						order by artid desc
					  ";
	//查询art和cat				  
	$sql_select_art_cat = "
			select artid,pubtime,title, catname 
				from art  
					left join cat 
				on art.catid=cat.catid  
			where art.catid>0 
			order by artid desc
			";
	$sql2 = "
			select artid,pubtime,title, catname 
				from art  
					left join cat 
				on art.catid=cat.catid  
			where art.catid>0 
			order by artid desc
			";
	//3.
		//添加
			//$isAdd = mQuery($sql_add_art);
			//echo $isAdd;//返回值1——添加成功
		//查询
			$arts = mQuery($sql_select_art);//对象的集合——数组的数组
			//1.list
			$data = array();
			//2.1.循环rs——得到对象/数组
			//2.2.将对象/数组——放到list/数组中
			while($row = mysql_fetch_assoc($arts)) {
				$data[] = $row;
			}
			//先从list/数据中获取对象,在从对象/数组中获取属性
			echo $data[0]['title'];


?>