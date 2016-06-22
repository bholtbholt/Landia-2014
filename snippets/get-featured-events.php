			</div> <!-- close container -->
</article><!-- close #Events header -->

<article class="page-article" id="event-list">
	<div class="container">
<?php $events = array(
									'post_type' => 'events',
									'posts_per_page' => 3,
									'orderby' => 'meta_value',
									'meta_key' => 'date',
									'order' => 'ASC',
									'meta_query' => array(array('key' => 'featured','value' => 'featured'))
								);

			$events_loop = new WP_Query( $events );
			while ( $events_loop->have_posts() ) : $events_loop->the_post();
				$PID = get_the_ID();
				$date = esc_html( get_post_meta( $PID, 'date', true ) );
				$start_time = esc_html( get_post_meta( $PID, 'start_time', true ) );
				$end_time = esc_html( get_post_meta( $PID, 'end_time', true ) );
				$venue = esc_html( get_post_meta( $PID, 'venue', true ) );
				$venue_site = esc_html( get_post_meta( $PID, 'venue_site', true ) );
				$tickets = esc_html( get_post_meta( $PID, 'tickets', true ) );
				$moderator = esc_html( get_post_meta( $PID, 'moderator', true ) );
				$img_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');
				$photo = $img_url[0];
				$summary = esc_html( get_post_meta( $PID, 'summary', true ) ); ?>

		<div class="row event-row">
			<div class="col-sm-4 col-sm-offset-2">
				<div class="event-image hidden-xs" style="background-image: url(<?php echo $photo ?>)"><a href="<?php the_permalink() ?>"><div><?php echo do_shortcode('[info_icon]'); ?><Br/>More info</div></a></div>
			</div>
			<div class="col-sm-6">
				<h3 class="h2 event-headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p class="event-subhead">
					<?php	echo date("F, jS", strtotime($date)) . ' | '?>
					<?php echo $venue_site ? '<a href="'.$venue_site.'" target="_blank">'.$venue.'</a>' : $venue; ?>
					<? echo ' | ' . date("g:i a", strtotime($start_time)) . ' &mdash; ' . date("g:i a", strtotime($end_time)); ?>
				</p>
				<p class="event-excerpt"><?php echo $summary ?></p>
				<p class="event-icons">
					<a href="<?php the_permalink() ?>"><?php echo do_shortcode('[info_icon]'); ?>View more</a>
					<?php echo $tickets ? '<a href="'.$tickets.'">'.do_shortcode('[ticket_icon]').'Get tickets</a>' : ''; ?>
				</p> 
			</div>
		</div>

<?php endwhile; wp_reset_postdata(); ?>
	
<?php // Regular loop closes article and container ?>