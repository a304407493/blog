<head>
	<!-- <base href="http://blog.com/" /> -->
	<!-- <base target="_blank" /> -->
</head>
<?php 
	$login_url = URL_ROOT . "/controller/show/login.php";
	$register_url = URL_ROOT . "/controller/show/register.php";
	$index_url = URL_ROOT . "/controller/show/blog_index.php";
	$about_url = URL_ROOT . "/controller/show/about.php";
	$message_url = URL_ROOT . "/controller/show/message.php";
	$logout_url = URL_ROOT . "/controller/show/logout.php";
?>
<!-- 1.头部 -->
	<div class="container">
		<page-header>
			<!-- 二手诗人 科学家  -->
			<h1>穿越繁华 <small>人生为棋，我愿为卒，行动虽缓，不曾后退一步。。。</small></h1>
			<h3>
				乘风行 无惧
				<?php if(checkacc()==false){?>
				<button style="font-size:15px;float:right;" class="btn btn-default-btn-lg" data-toggle="modal" data-target="#MyModal">请登录</button>
				<?php }else{ ?>
					<div style="font-size:15px;float:right;">
						<!--
						_COOKIE['nick']
						-->
						<!--
						注意session中没有isLogin需要注意
						-->
						<?php echo var_dump($_SESSION);?>
						<?php if("false"!=$_SESSION['isLogin']){
							echo "欢迎你," . $_SESSION['nick'] . 
							"&nbsp;&nbsp;<a href=" . $logout_url . ">退出</a>";
						}?>
						
					</div>
				<?php } ?>
				<div class="modal fade" id="MyModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>

							<div class="modal-body">
								<a href="<?php echo $login_url;?>" class="btn btn-default">登录</a>
								<a href="<?php echo $register_url;?>" class="btn btn-default">注册</a>
							</div>

							<div class="modal-footer">
								<button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
								<button class="btn btn-primary type="button"">Save</button> 	
							</div>
						</div>
					</div>
				</div>

			</h3>
		</page-header>
		<?php 
			$url = $_SERVER['PHP_SELF'];
			$filename= substr( $url , strrpos($url , '/')+1 );
			//echo $filename;
		?>
		
		<nav class="navbar navbar-inverse">
			<ul class="nav navbar-nav">
				
				<li 
					<?php if("blog_index.php"==$filename){?>
						class="active"
					<?php }?>
				>
					<a href="<?php echo $index_url;?>">日志</a>
				</li>
				<li 
					<?php if("about.php"==$filename){?>
						class="active"
					<?php }?>
				>
					<a href="<?php echo $about_url;?>?artid=0">关于</a>
				</li>
				<li 
					<?php if("message.php"==$filename){?>
						class="active"
					<?php }?>
				>
					<a href="<?php echo $message_url;?>">留言</a>
				</li>
			</ul>
			<form action="" class="navbar-form navbar-right">
				<div class="form-group"><input type="text" class="form-control"></div>
				<div class="form-group"><input type="submit" value="搜索" class="form-control"></div>
			</form>
		</nav>
	</div>