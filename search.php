<?php get_header(); ?>
<div class="content">
	<h1 class="ctitle">Tìm kiếm với "<?php echo get_query_var('s'); ?>"</h1>
	<ul class="mlst">
		<?php
			while(have_posts()) : the_post();
				?>
				<li>
					<div class="info-song">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<span>-</span>
						<p>
							<?php 
								$singers = get_the_terms(get_the_ID(), "singer"); 
								if ( $singers && ! is_wp_error( $singers ) ) : 
									$singers_name = "";
									foreach($singers as $singer){
										$singers_name .= $singer->name.", ";
									}
									echo rtrim($singers_name, ", ");
								endif;
							?>
						</p>
					</div>
					<div class="view">
						<?php 
							$view = get_post_meta(get_the_ID(), "view", true);
							if($view) echo $view; else echo 0;
						?>
					</div>
				</li>
				<?php
			endwhile;
		?>
	</ul>
	<div class="clear"></div>
	<?php 
		if(have_posts()) {
			dvd_paging();
		}else{
			echo "<p>Không tìm thấy kết quả nào cho từ khóa \"".get_query_var('s')."\"</p>";
		} 
	?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>