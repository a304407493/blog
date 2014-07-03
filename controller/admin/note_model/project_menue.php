<?php
/**
* 文件列表展示页面
* 
* 功能：列出所有的文件
*
*
* @author zhaoxin <zhaoxin_work@sina.cn>
*/
/**
三个函数：
	①函数：opendir——返回一个目录流
	②函数：readdir——读取opendir返回的目录流
	③函数：iconv  ——返回一个指定编码的变量
		输入编码(操作系统gb2312)、输出编码(页面utf-8)、输入变量
**/

/*******************引入-中文乱码-NOTICE-数据库*******************/
require_once('./lib/init.php');


/* 函数 listDirTree( $dirName = null )
** 功能 列出目录下所有文件及子目录
** 参数 $dirName 目录名称
** 返回 目录结构数组 false为失败
*/
function listDirTree( $dirName = null ){
	if( empty( $dirName ) )
		exit( "IBFileSystem: directory is empty." );
	if( is_dir( $dirName ) ){
		//①函数：opendir——返回一个目录流
		if( $dh = opendir( $dirName ) ){
			//List-存放filePaht
			$tree = array();
			//$file——属性-文件夹
			//普通——文件
			/*
				②函数：readdir——读取opendir返回的目录流
				readdir返回值1.false 2.目录
				//( $file = readdir( $dh ) ) !== false
					含义：
						1.如果读取出来为false赋值给$file
						  判断是否为false
						  		1.1：是——报错
						  	  1.2：不是——下一步
						2.如果读取出来为文件赋值给$file
			*/
			while( ( $file = readdir( $dh ) ) !== false ){
				//排除掉.和..
				if( $file != "." && $file != ".." ){
					//③函数：iconv——输入编码(操作系统gb2312)、输出编码(页面utf-8)、输入变量
					$file = iconv("gb2312","UTF-8",$file); 
					//文件路径为：dirName(文件夹名)+file(文件名)
					$filePath = $dirName . "/" . $file;
					//再次判断是否为目录,递归——获取子文件
						if( is_dir( $filePath ) ){
							$tree[$file] = listDirTree( $filePath );
						}
					//为文件,添加到当前数组
						else {
							$tree[] = $file;
						}
				}
			}
			
			closedir( $dh );
		}
		else{
			exit( "IBFileSystem: can not open directory $dirName.");
		}

		//返回当前的$tree
		return $tree;
	}
	else
	{
		exit( "IBFileSystem: $dirName is not a directory.");
	}
}

//列出当前目录的文件和子目录
$files = listDirTree(".");
//print_r($files);
$size = count(files);

//以下代码是创建一个本目录下文件的列表（带有链接地址）
//列出文件——没有文件夹($file)
echo '<ol>';
	for( $i=0; $files[$i] != NULL; $i++ ) {
		echo '<li><a href="'.($files[$i]).'" target="_blank">'.$files[$i].'</a></li>';
	}
echo '</ol>';


?>