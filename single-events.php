<?php get_header();
			if ( have_posts() ) while ( have_posts() ) : the_post();
				$PID = $post->ID;
				$date = esc_html( get_post_meta( $PID, 'date', true ) );
				$start_time = esc_html( get_post_meta( $PID, 'start_time', true ) );
				$end_time = esc_html( get_post_meta( $PID, 'end_time', true ) );
				$venue = esc_html( get_post_meta( $PID, 'venue', true ) );
				$address = esc_html( get_post_meta( $PID, 'address', true ) );
				$venue_site = esc_html( get_post_meta( $PID, 'venue_site', true ) );
				$tickets = esc_html( get_post_meta( $PID, 'tickets', true ) );
				$price = esc_html( get_post_meta( $PID, 'price', true ) );
				$moderator = esc_html( get_post_meta( $PID, 'moderator', true ) );
				$img_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				$photo = $img_url[0];
				$bg_color = esc_html( get_post_meta( $PID, 'bg_color', true ) );
				$showTitle = esc_html( get_post_meta( $PID, 'show_title', true ) );
				$title = explode(' ',get_the_title());
				$lightTitle = implode(" ", array_slice($title, 0, -1));
				$header_icon = esc_html( get_post_meta( $PID, 'header_icon', true ) ); ?>

<article <?php echo ($header_icon) ? '' : 'style="background-image: url('.$photo.')"'; ?>	class="page-article <?php echo ($header_icon) ? $header_icon : 'event-bg-image'; echo ' '.$bg_color ?>" id="<?php the_slug() ?>-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-5 speaker-bg-title">
				<?php echo ($showTitle) ? '<h1 class="giant-text caps cream">'.$lightTitle.' <strong>'. end($title) . '</strong></h1>' : ''; ?>
			</div>
		</div>
	</div>
</article>
<?php echo do_shortcode('[arrow_icon]'); ?>

<article class="page-article" id="<?php the_slug(); ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-3 speaker-event-details">
				<h4 class="<?php echo $headlineColour ?> caps">What</h4>
				<p class="lead"><?php the_title(); ?></p>
				<h4 class="<?php echo $headlineColour ?> caps">When</h4>
				<p><?php	echo date("F, jS", strtotime($date)) . '<br>' . date("g:i a", strtotime($start_time)) . ' &mdash; ' . date("g:i a", strtotime($end_time)); ?></p>
				<h4 class="<?php echo $headlineColour ?> caps">Where</h4>
				<p><?php echo $venue_site ? '<a href="'.$venue_site.'" target="_blank">'.$venue.'</a>' : $venue; ?><br><?php echo $address ?></p>
				<?php echo $tickets ? '<p class="caps"><a href="'.$tickets.'">'.do_shortcode('[ticket_icon]').'<br>Get tickets</a></p>' : ''; ?>
				<?php echo $price ? '<p class="price caps strong">$'.$price.'</p>' : ''; ?>
			</div>
			<div class="col-sm-8 col-sm-offset-1">
				<?php the_content() ?>

<?php // Show the connected speakers
			$connected = new WP_Query( array(
										  'connected_type' => 'Speakers and Events',
										  'connected_items' => get_queried_object(),
										  'nopaging' => true,
										) );
			if ( $connected->have_posts() ) :
				$plural = ($connected->post_count > 1) ? 's' : '';
				echo "<p class='event-speakers'><strong>Speaker${plural}:</strong>";
				while ( $connected->have_posts() ) : $connected->the_post();
					echo ' <a href="'.get_the_permalink().'">'.get_the_title().'</a>';
				endwhile; 
				echo '</p>';
			wp_reset_postdata();
			endif;
			//finish event information ?>

				<?php if ($moderator) { echo "<p><strong>Moderated by:</strong> ${moderator}</p>"; } ?>
			</div>
		</div><!-- close row-->
	</div><!--close container -->
</article>
<?php endwhile; ?>
<?php get_footer(); ?>