<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php 
		$view = get_post_meta(get_the_ID(), "view", true);
		if(!$view){
			update_post_meta(get_the_ID(), "view", 1);
		}else{
			update_post_meta(get_the_ID(), "view", $view + 1);
		}
		//cập nhật lượt 
	?>
	<div class="content">
		<h1 class="ctitle">Bài hát: <?php the_title(); ?></h1>
		<?php 
			$slink_accept = array("zippyshare", "youtube", "mp3", "mp4"); //mảng các loại link cho phép

			$links = array();
			foreach($slink_accept as $type){
				$link = get_post_meta(get_the_ID(), "link-".$type, true);
				if($link){
					$links[] = array("type" => $type, "link" => $link);
				}
			} //lấy các link của bài hát

			if(count($links) == 0) :
				echo "Link bài hát không tồn tại!";
			else :
				$link_type = get_query_var("link_type"); //lấy loại link

				if($link_type && in_array($link_type, $slink_accept)){
					foreach($links as $link){
						if($link['type'] == $link_type){
							dvd_play($link['link'], $link['type']);
							break;
						}
					}
				}else{
					dvd_play($links[0]['link'], $links[0]['type']);
				}

				?>
				<div class="links_lst">
					Link: 
					<?php 
						foreach($links as $link){
							?>
							<a <?php if($link_type == $link['type']) echo "class='ac'"; ?> href="<?php echo str_replace(".html", "/".$link['type'].".html", get_the_permalink()); ?>"><?php echo $link['type']; ?></a>
							<?php
						}
					?>
				</div>
				<div class="song_info">
					<h2>Thông tin bài hát:</h2>
					<p><b>Thể loại</b>: <?php the_terms(get_the_ID(), "song_category", "", ", "); ?></p>
					<p><b>Trình bày</b>: <?php the_terms(get_the_ID(), "singer", "", ", "); ?></p>
					<p><b>Chơi Nhạc</b>: </p>
					<p><b>Lời bài hát</b>: </p>
					<div id="lyric">
						<?php 
							$lyric = apply_filters( 'the_content', get_post_meta(get_the_ID(), "lyric", true) );
							$lyric = str_replace( ']]>', ']]&gt;', $lyric );
							echo $lyric;
						?>
					</div>
					<p><a id="turn" href="javascript:void(0);">Bật, tắt</a> hiển thị toàn bộ lời bài hát</p><div id="fb-root"></div>
					<script type="text/javascript">
					jQuery(document).ready(function($){
						$('#turn').click(function(){
							if($('#lyric').hasClass('full_height')){
								$('#lyric').removeClass('full_height');
							}else{
								$('#lyric').addClass('full_height');
							}
						});
					});
					</script>
				</div>
				<?php
			endif;
		?>
	</div>

	<?php endwhile; endif; ?>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>