<?php 
/****
布尔教育 高端PHP培训
培  训: http://www.itbool.com
论  坛: http://www.zixue.it
****/

// 1 创建画布
$im = imagecreatetruecolor(80,30);


// 2 创建颜料
$white = imagecolorallocate($im,10,10,10);
$gray = imagecolorallocate($im, 200, 200, 200);

// 3 画图形或写字
imagefill($im, 0, 0, $gray);
$vercode = randstr();
imagestring($im, 5, 15, 5, $vercode , $white);

// 4: 保存或输出
// imagepng($im, './test.png');
header('content-type: image/png');
imagepng($im);

// 5: 销毁画布
imagedestroy($im);


// 6: 验证码写进session
session_start();
$_SESSION['vercode'] = $vercode;

function randStr($len = 4) {
	$str = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
	$str = str_shuffle($str);
	return substr($str, 0,$len);
}


?>