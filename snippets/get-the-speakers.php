<?php $speakers = array( 'post_type' => 'speakers', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );
			$speakers_loop = new WP_Query( $speakers );
			$buttonColor = esc_html( get_post_meta( get_page_by_title('Contact')->ID, 'bg_color', true ) ); ?>

<div class="row">
	<div class="col-sm-2 speaker-list-wrapper text-center">
		<button type="button" class="btn btn-primary visible-xs <?php echo $buttonColor ?>" data-toggle="collapse" data-target="#speaker-list-div">See the Speakers</button>
		<div id="speaker-list-div" class="collapse">
			<ul class="speaker-list" role="tablist">

	<?php $tabCount=0; while ( $speakers_loop->have_posts() ) : $speakers_loop->the_post();
				$tabCount++;
				echo($tabCount==1? '<li class="active">' : '<li>'); ?>
				<a href="#<?php the_slug(); ?>" data-toggle="tab"><?php the_title(); ?></a></li>
	<?php endwhile; ?>

			</ul>
		</div>
		<a href="#speaker-list-div" class="scroll-speakers-list"><span class="glyphicon glyphicon-chevron-down"></span></a>
	</div>
	<div class="col-sm-10 tab-content">

<?php $tabCount=0; while ( $speakers_loop->have_posts() ) : $speakers_loop->the_post();
			$position = esc_html( get_post_meta( get_the_ID(), 'position', true ) );
			$summary = esc_html( get_post_meta( get_the_ID(), 'summary', true ) );
			$tabCount++; echo($tabCount==1? '<div class="tab-pane fade in active" id="'.the_slug(false).'">' : '<div class="tab-pane fade" id="'.the_slug(false).'">'); ?>
			<div class="col-sm-5">
				<h2 class="h1 strong grey"><?php the_title(); ?></h2>
				<h4><?php echo $position ?></h4>
				<div class="speaker-bio">
					<?php echo wpautop($summary) ?>
					<p><a href="<?php the_permalink() ?>">View Profile</a></p>
				</div>
			</div>
			<div class="speaker-image hidden-xs">
				<?php the_post_thumbnail('medium', array('class'=>"img-responsive")); ?>
			</div>
		</div><!-- close tab-pane-->
<?php endwhile; wp_reset_postdata(); ?>

	</div><!-- close tab-content -->
</div><!-- close row-->