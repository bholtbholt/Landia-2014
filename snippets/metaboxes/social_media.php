<?php $facebook = esc_html( get_post_meta( $post->ID, 'facebook', true ) );
			$instagram = esc_html( get_post_meta( $post->ID, 'instagram', true ) );
			$twitter = esc_html( get_post_meta( $post->ID, 'twitter', true ) );
			$flickr = esc_html( get_post_meta( $post->ID, 'flickr', true ) );
			$linkedin = esc_html( get_post_meta( $post->ID, 'linkedin', true ) );
			$vimeo = esc_html( get_post_meta( $post->ID, 'vimeo', true ) );
			$googlePlus = esc_html( get_post_meta( $post->ID, 'googlePlus', true ) );
			$pinterest = esc_html( get_post_meta( $post->ID, 'pinterest', true ) );
			$youtube = esc_html( get_post_meta( $post->ID, 'youtube', true ) );	?>

<input type="hidden" name="hidden_flag" value="true" />
<div class="column">
  <p class="meta-box-title">Facebook:</p>
	<input type="text" class="meta-box-input full-width" name="facebook" value="<?php echo $facebook; ?>" />
	<p class="meta-box-title">Instagram:</p>
	<input type="text" class="meta-box-input full-width" name="instagram" value="<?php echo $instagram; ?>" />
	<p class="meta-box-title">Twitter:</p>
	<input type="text" class="meta-box-input full-width" name="twitter" value="<?php echo $twitter; ?>" />
</div>
<div class="column">
	<p class="meta-box-title">Flickr:</p>
	<input type="text" class="meta-box-input full-width" name="flickr" value="<?php echo $flickr; ?>" />
	<p class="meta-box-title">LinkedIn:</p>
	<input type="text" class="meta-box-input full-width" name="linkedin" value="<?php echo $linkedin; ?>" />
	<p class="meta-box-title">Vimeo:</p>
	<input type="text" class="meta-box-input full-width" name="vimeo" value="<?php echo $vimeo; ?>" />
</div>
<div class="column">
	<p class="meta-box-title">Google+:</p>
	<input type="text" class="meta-box-input full-width" name="googlePlus" value="<?php echo $googlePlus; ?>" />
	<p class="meta-box-title">Pinterest:</p>
	<input type="text" class="meta-box-input full-width" name="pinterest" value="<?php echo $pinterest; ?>" />
	<p class="meta-box-title">YouTube:</p>
	<input type="text" class="meta-box-input full-width" name="youtube" value="<?php echo $youtube; ?>" />
</div>
<div style="clear:both"></div>