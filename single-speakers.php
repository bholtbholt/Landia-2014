<?php get_header();
			if ( have_posts() ) while ( have_posts() ) : the_post();
			$position = esc_html( get_post_meta( $post->ID, 'position', true ) );
			$name = explode(' ',get_the_title());
			$firstName =$name[0];
			$lastName =$name[1];
			$img_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
			$photo = $img_url[0];
			$bg_color = esc_html( get_post_meta( $post->ID, 'bg_color', true ) );
			$headlineColour = substr(esc_html( get_post_meta( get_page_by_title('Contact')->ID, 'bg_color', true ) ), 0, -3);
			$email = esc_html( get_post_meta( get_the_ID(), 'email', true ) );
			$website = esc_html( get_post_meta( get_the_ID(), 'website', true ) ); ?>

<article style="background-image: url(<?php echo $photo ?>)" class="page-article speaker-bg-image <?php echo $bg_color ?>" >
	<div class="container">
		<div class="row">
			<div class="col-sm-5 speaker-bg-title">
				<h1 class="giant-text caps"><?php echo $firstName ?> <br><strong><?php echo $lastName ?></strong></h1>
				<h3 class="grey subheadline"><?php echo $position ?></h3>
			</div>
		</div>
	</div>
</article>
<?php echo do_shortcode('[arrow_icon]'); ?>

<article class="page-article" id="<?php the_slug(); ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-3 speaker-event-details">

<?php // Display event information pertaining to the speaker
			$connected = new WP_Query( array(
										  'connected_type' => 'Speakers and Events',
										  'connected_items' => get_queried_object(),
										  'nopaging' => true,
										) );
			if ( $connected->have_posts() ) :
				while ( $connected->have_posts() ) : $connected->the_post();
					$PID = $post->ID;
					$date = esc_html( get_post_meta( $PID, 'date', true ) );
					$start_time = esc_html( get_post_meta( $PID, 'start_time', true ) );
					$end_time = esc_html( get_post_meta( $PID, 'end_time', true ) );
					$venue = esc_html( get_post_meta( $PID, 'venue', true ) );
					$address = esc_html( get_post_meta( $PID, 'address', true ) );
					$venue_site = esc_html( get_post_meta( $PID, 'venue_site', true ) );
					$tickets = esc_html( get_post_meta( $PID, 'tickets', true ) );
					$price = esc_html( get_post_meta( $PID, 'price', true ) );
					$moderator = esc_html( get_post_meta( $PID, 'moderator', true ) ); ?>

				<h4 class="<?php echo $headlineColour ?> caps">What</h4>
				<p class="lead"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
				<h4 class="<?php echo $headlineColour ?> caps">When</h4>
				<p><?php	echo date("F, jS", strtotime($date)) . '<br>' . date("g:i a", strtotime($start_time)) . ' &mdash; ' . date("g:i a", strtotime($end_time)); ?></p>
				<h4 class="<?php echo $headlineColour ?> caps">Where</h4>
				<p><?php echo $venue_site ? '<a href="'.$venue_site.'" target="_blank">'.$venue.'</a>' : $venue; ?><br><?php echo $address ?></p>
				<?php echo $tickets ? '<p class="caps"><a href="'.$tickets.'">'.do_shortcode('[ticket_icon]').'<br>Get tickets</a></p>' : ''; ?>
				<?php echo $price ? '<p class="price caps strong">$'.$price.'</p>' : ''; ?>

<?php endwhile; 
			wp_reset_postdata();
			endif;
			//finish event information ?>

				<?php if ($website) : ?>
					 <p><a href="<?php echo $website ?>" target="_blank"><?php echo str_replace("http://www.", "", $website) ?></a></p>
				<?php endif; ?>
					 <p class="social-row"><?php echo landia_social_icons_row($post->ID) ?></p>
			</div>
			<div class="col-sm-8 col-sm-offset-1">
				<?php the_content() ?>
			</div>
		</div><!-- close row-->
	</div><!--close container -->
</article>
<?php endwhile; ?>
<?php get_footer(); ?>