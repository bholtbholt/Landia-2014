<?php $events = array( 'post_type' => 'events', 'posts_per_page' => -1, 'order' => 'ASC' );
			$events_loop = new WP_Query( $events );
			$bgColor = esc_html( get_post_meta( get_page_by_title('Contact')->ID, 'bg_color', true ) );
			$category_count = floor(100/count(get_categories('type=events')))-1; ?>

<div class="row">
	<div id="event-category-list-div" class="event-category-list text-center">

<?php $tabCount=0; $event_categories=array(); while ( $events_loop->have_posts() ) : $events_loop->the_post();
			$category = get_the_category();
			$category_name = $category[0]->slug;

			// Make tabs for each category only once
			if (!in_array($category_name, $event_categories)) :
				$tabCount++; $event_categories[]=$category_name; ?>
					<a href="#<?php echo $category_name ?>" data-toggle="tab" class="event-filter">
						<?php echo '<img src="'.get_template_directory_uri() . '/images/icons/'.$category_name.'-button.svg" class="event-filter-img">'; ?>
					</a>
			<?php endif; ?>
<?php endwhile; ?>

	</div> <!-- close event-date-list -->
</div><!-- close row -->
<div class="tab-content">

<?php $tabCount=0; $event_categories=array(); while ( $events_loop->have_posts() ) : $events_loop->the_post();
			$category = get_the_category();
			$category_name = $category[0]->slug;
			// Make sections for each day
			if (!in_array($category_name, $event_categories)) :
				$tabCount++; $event_categories[]=$category_name; ?>
				<div class="tab-pane fade <?php echo $tabCount==1? 'in active' : ''; ?>" id="<?php echo $category_name ?>">
<?php // Only events that match the category are added
			$events_in_cat = array( 'post_type' => 'events', 'posts_per_page' => -1, 'order' => 'ASC', 'category_name' => $category_name );
			$events_in_cat_loop = new WP_Query( $events_in_cat );
			
			while ( $events_in_cat_loop->have_posts() ) : $events_in_cat_loop->the_post();
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

		<div class="row event-list">
			<div class="col-sm-7 col-sm-push-2">
				<h3 class="event-headline strong"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="event-description">
					<p>
						<span class="strong visible-xs"><?php echo date("D j", strtotime($date)) ?></span><?php	echo date("g:i a", strtotime($start_time)) . ' &mdash; ' . date("g:i a", strtotime($end_time)) . ' | ' ?>
						<?php echo $venue_site ? '<a href="'.$venue_site.'" target="_blank">'.$venue.'</a>' : $venue; ?>
					</p>
					<?php echo wpautop($summary) ?>
				</div>
			</div>
			<div class="col-sm-2 col-sm-pull-7">
				<div class="date-box <?php echo $category_name ?>">
					<span class="day"><?php echo date("D", strtotime($date)) ?></span>
					<span class="date"><?php echo date("j", strtotime($date)) ?></span>
				</div>
			</div>
			<div class="col-sm-3">
				<?php echo $tickets ? '<p class="event-icons"><a href="'.$tickets.'">'.do_shortcode('[ticket_icon]').'Get tickets</a></p>' : ''; ?>
				<p class="event-icons"><a href="<?php the_permalink() ?>"><?php echo do_shortcode('[info_icon]'); ?>View more</a></p>
			</div>
		</div>

<?php endwhile; wp_reset_postdata(); ?>
</div><!-- end tab pane -->
<?php endif; ?>
<?php endwhile; wp_reset_postdata(); ?>

</div><!-- end tab-content -->
	
<?php // Regular loop closes article and container ?>