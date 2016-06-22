<?php $position = esc_html( get_post_meta( $post->ID, 'position', true ) );
			$email = esc_html( get_post_meta( $post->ID, 'email', true ) );
			$website = esc_html( get_post_meta( $post->ID, 'website', true ) );
			$summary = esc_html( get_post_meta( $post->ID, 'summary', true ) ); ?>

<input type="hidden" name="hidden_flag" value="true" />
<p class="meta-box-title">Introduction: <em>Displays on the front page. 50 word limit</em></p>
<textarea class="meta-box-textarea" name="summary" id="summary"><?php echo $summary; ?></textarea>
<div class="column">
	<p class="meta-box-title">Speaker's Position/Title:</p>
	<input type="text" class="meta-box-input full-width" name="position" value="<?php echo $position; ?>" />
</div>
<div class="column">
	<p class="meta-box-title">Email:</p>
	<input type="text" class="meta-box-input full-width" name="email" value="<?php echo $email; ?>" />
</div>
<div class="column">
	<p class="meta-box-title">Speaker's Website:</p>
	<input type="text" class="meta-box-input full-width" name="website" value="<?php echo $website; ?>" />
</div>
<div style="clear:both"></div>