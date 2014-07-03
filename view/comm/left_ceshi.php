			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">最新博文</div>
					<div class="panel-body">
						<ul>
							<!-- 
							is_array($result = xxxxxxxxx)?null:$result = array(); 
								//$result后的赋值表达式返回的结果是一个有效数组，则正常进行下面代码，
								//否则给$result变量赋一个空数组值。 
							-->
							
							
							<?php foreach ($new_arts as $new_art) { ?>
								<li>
									<a href="<?php echo URL_ROOT;?>/blog_art.php?artid=<?php echo $new_art['artid'] ;?>">
										<?php echo $new_art['title']; ?>
									</a>
								</li>

							<?php } ?>
								<li><?echo new_arts?></li>
							
						</ul>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">日志分类</div>
					<div class="panel-body">
						<ul>
							<?php foreach ($cats as $cat) { ?>
								<li>
									<a href="<?php echo URL_ROOT;?>/blog_art.php?catid=<?php echo $cat['catid'] ;?>">
										<?php echo $cat['catname']; ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Tag标签</div>
					<div class="panel-body">
						<ul>
							<?php foreach ($tags as $tag) { ?>
								<li>
									<a href="<?php echo URL_ROOT;?>/blog_art.php?tag=<?php echo $cat['tag'] ;?>">
										<?php echo $tag['tag']; ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">友情链接</div>
					<div class="panel-body">
						<ul>
							<li><a href="http://www.baidu.com">百度</a></li>
							<li><a href="http://www.google.hk">谷歌</a></li>
							<li><a href="http://jingyan.baidu.com">百度经验</a></li>
							<li><a href="http://sports.sina.com.cn/nba">NBA</a></li>
						</ul>
					</div>
				</div>
			</div>