<?php $date = esc_html( get_post_meta( $post->ID, 'date', true ) );
			$start_time = esc_html( get_post_meta( $post->ID, 'start_time', true ) );
			$end_time = esc_html( get_post_meta( $post->ID, 'end_time', true ) );
			$venue = esc_html( get_post_meta( $post->ID, 'venue', true ) );
			$address = esc_html( get_post_meta( $post->ID, 'address', true ) );
			$venue_site = esc_html( get_post_meta( $post->ID, 'venue_site', true ) );
			$tickets = esc_html( get_post_meta( $post->ID, 'tickets', true ) );
			$price = esc_html( get_post_meta( $post->ID, 'price', true ) );
			$moderator = esc_html( get_post_meta( $post->ID, 'moderator', true ) );
			$featured = esc_html( get_post_meta( $post->ID, 'featured', true ) );
			$showTitle = esc_html( get_post_meta( $post->ID, 'show_title', true ) );
			$header_icon = esc_html( get_post_meta( $post->ID, 'header_icon', true ) );
			$summary = esc_html( get_post_meta( $post->ID, 'summary', true ) );
			$bgIcons = array('', 'atom-bg', 'beer-bg', 'bike-bg', 'brain-bg', 'crossed-wrenches-bg', 'frame-bg', 'pencil-bg', 'thought-shop-bg', 'ticket-bg'); ?>
<input type="hidden" name="hidden_flag" value="true" />
<div class="row">
	<div class="column">
		<p class="meta-box-title">Date:</p>
		<input type="date" name="date" class="meta-box-input width-99" value="<?php echo $date? $date : date("m/d/Y"); ?>"/>
	</div>
	<div class="column">
		<p class="meta-box-title">Start Time:</p>
		<input type="time" name="start_time" class="meta-box-input width-99" value="<?php echo $start_time? $start_time : date("g:i"); ?>"/>
	</div>
	<div class="column">
		<p class="meta-box-title">End Time:</p>
		<input type="time" name="end_time" class="meta-box-input width-99" value="<?php echo $end_time? $end_time : date("g:i"); ?>"/>
	</div>
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="column">
		<p class="meta-box-title">Venue:</p>
		<input type="text" class="meta-box-input full-width" name="venue" value="<?php echo $venue; ?>" />
	</div>
	<div class="column">
		<p class="meta-box-title">Venue Address:</p>
		<input type="text" class="meta-box-input full-width" name="address" value="<?php echo $address; ?>" />
	</div>
	<div class="column">
		<p class="meta-box-title">Venue Website:</p>
		<input type="text" class="meta-box-input full-width" name="venue_site" value="<?php echo $venue_site; ?>" />
	</div>
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="column">
		<p class="meta-box-title">Ticket Link:</p>
		<input type="text" class="meta-box-input full-width" name="tickets" value="<?php echo $tickets; ?>" />
	</div>
	<div class="column">
		<p class="meta-box-title">Price:</p>
		<input type="text" class="meta-box-input full-width" name="price" value="<?php echo $price; ?>" />
	</div>
	<div class="column">
		<p class="meta-box-title">Moderator:</p>
		<input type="text" class="meta-box-input full-width" name="moderator" value="<?php echo $moderator; ?>" />
	</div>
	<div class="clearfix"></div>
</div>

<p class="meta-box-title">Summary: <em>Appears only in the featured event section</em></p>
<textarea class="meta-box-textarea" name="summary" id="summary"><?php echo $summary; ?></textarea>

<div class="row">
	<div class="column">
		<p class="meta-box-title">Header Icon:</p>
	  <div id="header_icon_select_wrapper">
		  <select id="header_icon" name="header_icon" class="full-width">
		  <?php foreach ($bgIcons as $icon) : ?>
		  	<option value="<?php echo $icon ?>" <?php echo ($icon == $header_icon)? 'selected' : ''; ?>><?php echo ucfirst(substr($icon, 0, -3)) ?></option>
		  <?php endforeach; ?>
		  </select>
	  </div>
	</div>
	<div class="column">
		<p class="meta-box-title page-meta-checkboxes">
			<label><input type="checkbox" <?php if ($showTitle){echo "checked ";}?> name="show_title" value="showTitle"> Show Title on Single Page</label>
		</p>
	</div>
	<div class="column">
		<p class="meta-box-title page-meta-checkboxes">
			<label><input type="checkbox" <?php if ($featured){echo "checked ";}?> name="featured" value="featured"> Front Page Featured Event</label>
		</p>
	</div>
	<div class="clearfix"></div>
</div>