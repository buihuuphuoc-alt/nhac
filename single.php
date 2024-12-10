<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="content">
		<h1 class="ctitle"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>

	<?php endwhile; endif; ?>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>