<?php 
	$blog_art_url = URL_ROOT . "/controller/show/blog_art.php";
	$index_url = URL_ROOT . "/controller/show/blog_index.php";
?>
	<div class="col-xs-9">
	<?php foreach ($arts as $art) {?>
		<article>
			<h1>
				<a href="<?php echo $blog_art_url;?>?artid=<?php echo $art['artid'];?>">
					<?php echo $art['title']; ?>
				</a>
			</h1>
			<div class="arc">
				<div class="art_details" >
					<?php $pubtime = date('Y/m/d',$art['pubtime']);?>
					<?php if($art['pubtime']){?>
						发表时间：
						<a href="<?php echo $index_url;?>?pubtime=<?php echo $pubtime;?>">
							<?php echo $pubtime;?>
						</a>   
					<?php }?>

					<?php if($art['catname']){?>
						&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						分类：
						<a href="<?php echo $index_url;?>?catid=<?php echo $art['catid'];?>">
							<?php echo $art['catname'];?> 
						</a> 
					<?php }?>

					
					<?php if($art['tags']){?>
						&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						标签：
								<?php 
									$art_tags = explode(",", $art['tags']);
									foreach ($art_tags as $art_tag) {
								?>
									<a href="<?php echo $index_url;?>?tag=<?php echo $art_tag;?>">
										<?php echo $art_tag;?> 
									</a>
								<?php
									}
								?>
					<?php }?>

					<?php if($art['nick']){?>
						&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
						作者：by 
						<a href="<?php echo $index_url;?>?nick=<?php echo $art['nick'];?>">
							<?php echo $art['nick'];?>
						</a> &nbsp;&nbsp;&nbsp;
					<?php }?>

				</div>
				<!-- <p><?php echo htmlspecialchars($art['content']); ?></p> -->
				<!-- <p><?php echo $art['content']; ?></p> -->
				<p><?php echo $art['title']; ?></p>
				<p><?php echo $art['content']; ?></p>
				
			</div>
			<span class="pull-right">
				<a 
					href="<?php echo $blog_art_url;?>?artid=<?php echo $art['artid'];?>#comms"
				>
					<?php echo $art['commcount'];?>条评论&raquo;
				</a>
			</span>
		</article>
	<?php }?>

	<!-- 分页 -->
		<ul class="pagination">
			<li><a href="<?php echo $index_url;?>">&laquo;</a></li>
				<?php foreach($pages as $k=>$v) { ?>
					<!-- 方式一 -->
					<!-- <li><a href="blog_index.php?<?php echo $v;?>"><?php echo $k; ?></a></li> -->
					<!-- 分析1：page=1<div><?php echo $v;?></div> -->
					<!-- 分析2：1、2、3<div><?php echo $k;?></div> -->
					
					<!-- 方式二 -->
					<li><a href="<?php echo $index_url;?>?page=<?php echo $k; ?>"><?php echo $k; ?></a></li>
				<?php } ?>
			<li><a href="<?php echo $index_url;?>?page=">&raquo;</a></li> 
		</ul>	

	</div>
