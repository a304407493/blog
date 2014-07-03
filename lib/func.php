<?php 

/**
* 计算用户的加密cookie——计算校验码——发送给用户，用户设置为cookie
*/
function ccode($name) {
	return md5($name . CKEY);
}
function mlog($log) {
    $path = ROOT . '/log/' . date('Ymd') . '.txt';
    //TODO 需要增加的逻辑：没有判断是否有此目录，如果没有此目录——出错
    file_put_contents($path , $log . "\n" , FILE_APPEND);
}

/**
* 检测管理用户
* 	是否登录
* 	是否有权限发表文章,删除评论等后台操作[没有权限系统]
* 判断条件
* 	1.判断用户是否退出
* 	2.判断用户是否已经登录过
* 	3.判断用户是否记住密码[从cookie中取值存入session]
* 	4.判断用户是否伪造——用户名
* 
* @return boolean 返回真则有权操作
*/
function checkacc() {
	//1.判断用户是否退出
	if("false"==$_SESSION['isLogin']){
		return false;
	}
	//2.判断用户是否已经登录过
	if(!$_SESSION['nick']) {
		//3.判断用户是否记住密码
		if(!$_COOKIE['name']) {
			return false;
		} else {
			//4.判断用户是否伪造——用户名
			$realcheckcode = ccode($_COOKIE['name']);
			if($realcheckcode === $_COOKIE['checkcode']){
				$_SESSION['nick'] = $_COOKIE['nick'];//记住密码之后，将Cookie传递给Session
				return true;
			}else {
				return false;
			}
		}
	}else{
		return true; 
	}
}


/**
* 用户出错时,停止页面并提示错误信息
* @param string $msg 错误提示信息
* 不用返回值,直接渲染一个错误页面
*/
//必须有此页面，否则报错
function error($msg) {
	//echo $msg;
	$type = 'error';
	include(ROOT . '/view/info.html');
	exit;
}
//必须有此页面，否则报错
function success($msg) {
	$type = 'success';
	include(ROOT . '/view/info.html');
	exit;
}


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


/**
* 执行查询语句
* @param string $sql 查询非select语句
* return boolean 返回布尔型
*/
function mQuery($sql) {
	$conn = getConn();
	//日志
	mLog($sql);
	return mysql_query($sql,$conn);
}


/**
* 查询select语句并返回一个单元
* @param string $sql select语句
* @return mixed string 返回1个标量值未查到返回false
*/
function mGetOne($sql) {
	$conn = getConn();
	$rs = mysql_query($sql,$conn);

	if(!$rs) {
		return false;
	} else {
		$rs = mysql_fetch_row($rs);
		return $rs[0];
	}
}

/**
* 查询select语句并返回一行
* @param string $sql select语句
* @return mixed array 查询到返回一维数组,未查到返回false
*/
function mGetRow($sql) {
	$conn = getConn();
	$rs = mysql_query($sql,$conn);

	return !$rs?false:mysql_fetch_assoc($rs);
}

/**
* 查询select语句并返回多行
* @param string $sql select语句
* @return mixed array 查询到返回二维数组,未查到返回false
*/
function mGetAll($sql) {
	$conn = getConn();
	$rs = mysql_query($sql,$conn);

	if(!$rs) {
		return false;
	} else {
		$data = array();

		while($row = mysql_fetch_assoc($rs)) {
			$data[] = $row;
		}

		return $data;
	}
}

/**
* 添加与修改
* 拼接sql语句并发送查询
* @param array $data 要插入或更改的数据,键代表列名,值为新值
* @param string $table 待插入的表名
* @param string $act 插入还是更新 默认为insert 
*/
function mExec($data , $table , $act='insert',$where='0') {
	if($act == 'insert') {
		$sql = 'insert into ' . $table . ' (';
		$sql .= implode(',', array_keys($data));//所有的数组下标用逗号分割
		$sql .= ") values ('";
		$sql .= implode("','", array_values($data));//所有的数组值用逗号分割
		$sql .= "')";
		return mQuery($sql);//执行上面的查询语句
	} else if($act == 'update') {
		// 拼接sql....
		$sql = 'update ' . $table . ' set ';
		foreach($data as $k=>$v) {//变量/对象/变量对象——用变量数组代表
			$sql .= $k . "='" . $v . "',";
		}

		$sql = rtrim($sql,',');//去掉右面的逗号,
		$sql .= ' where ' . $where;//查询条件——默认查询条件为false——避免将所有的数据修改
		return mQuery($sql);
	}

}

/**
* 返回最近的一次insert产生的主键值
* @return int
*/
function getLastId() {
	$conn = getConn();
	return mysql_insert_id($conn);
}

//mExec(array('title'=>'this is title','content'=>'this is content'),'art','update');

/**
 * 获得用户的真实IP地址
 *
 * @access  public
 * @return  string
 */
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}



/**
* 分页代码函数
* @param $num int 总条数
* @param $cnt int 每页条数
* @param $curr int 当前页码
* @return array 
*/
function pagination($num,$cnt=2,$curr=1) {
	$max = ceil($num / $cnt); // 计算出总页码
	if($curr > $max) {
		$curr = $max;
	}

	$right = $curr + 2;
	$left = $curr - 2;

	if($right > $max) {
		$right = $max;  // 计算输出的最大页码
	}

	$left = $right - 5 + 1;
	if($left < 1) {
		$left = 1; // 计算最小的输出页码
	}

	//echo $left,$right;

	// 把地址栏的参数读出
	for($i=$left , $pages = array(); $i<=$right; $i++) {
		$_GET['page'] = $i;
		$pages[$i] = http_build_query($_GET);
	}

	return $pages;
}

?>