<?php get_header();
			if ( have_posts() ) while ( have_posts() ) : the_post();
			$templatePID = $post->ID;
			$bg_color = esc_html( get_post_meta($post->ID, 'bg_color', true) ); ?>

<article class="page-article <?php echo $bg_color ?>" id="<?php the_slug(); ?>">
	<div class="container">
		<div class="row text-center">
			<?php the_content(); ?>
		</div>
	</div>
</article>
<?php echo do_shortcode('[arrow_icon]'); ?>
<?php endwhile; ?>


<?php $page_query = query_posts(array(
				'post_parent' => $templatePID,
				'post__not_in' => array( $templatePID ),
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_type' => 'page',
				'posts_per_page' => -1
			));
			if ( have_posts() ) while ( have_posts() ) : the_post();
			$thumbnail = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
			$bg_color = esc_html( get_post_meta($post->ID, 'bg_color', true ));
			$half_bg = esc_html( get_post_meta($post->ID, 'half_bg', true) ); ?>
      	
  <?php if ($thumbnail) : ?>
		<article class="page-article" id="<?php the_slug(); ?>" style="background: url(<?php echo $thumbnail ?>) center center no-repeat fixed; background-size: cover;">
  <?php else : ?>
		<article class="page-article <?php echo $half_bg ?> <?php echo $bg_color ?>" id="<?php the_slug(); ?>">
  <?php endif; ?>

			<div class="container">
				<?php if ($half_bg) : ?>
					<div class="col-sm-6 col-sm-offset-6">
						<?php the_content(); ?>
					</div>
				<?php else : ?>
					<?php the_content(); ?>
				<?php endif; ?>
			</div> <!-- close container -->

		</article>

<?php endwhile; wp_reset_postdata(); ?>

<?php get_footer(); ?>