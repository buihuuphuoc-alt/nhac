<?php get_header(); ?>
<div class="content">
	<h2 class="ctitle">Bài hát mới</h2>
	<ul class="mlst">
		<?php 
			$arg = array(
				"post_type" => "song",
				"post_status" => "publish",
				"posts_per_page" => 10,
				"orderby" => "ID",
				"order" => "DESC",
				"year"=> date('Y'),
				"w"=> date('W')
			);
			$new_songs = new WP_Query($arg);
			while($new_songs->have_posts()) : $new_songs->the_post();
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
	<a class="mlst_more" href="<?php echo get_page_link(11); ?>">Xem thêm »</a>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
