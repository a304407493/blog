<?php 
/**
*   html 应用css或者js时是相对于主文件的
*   当从note.php文件进入时，主目录为note.php
*
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

include($message_url);
?>