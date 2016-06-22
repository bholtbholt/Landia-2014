<?php $contactID = get_page_by_title('Contact')->ID;
			$contactEmail = get_post_meta( $contactID, 'contact_email', true );
			$emailArray = explode('@',$contactEmail);
			$emailDomain = $emailArray[1];
			$emailPrefix = $emailArray[0];
			$siteTitle = get_bloginfo('name'); ?>

		<form id="ContactForm" role="form" method="post" style="margin-top:15px">
			<div class="form-group">
				<label class="sr-only" for="name">Name</label>
				<input type="text" class="form-control" id="name" name="name" required placeholder="Name">
			</div>
			<div class="form-group">
				<label class="sr-only" for="email">Email</label>
				<input type="email" class="form-control" id="email" name="email" required placeholder="Email">
			</div>
			<div class="form-group margin-bottom">
				<label class="sr-only" for="phone">Phone Number</label>
				<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
			</div>
			<div class="form-group margin-bottom">
				<label for="relation">Tell us about your idea, firstly what it relates to:</label>
				<select name="relation" id="relation" class="form-control" required>
					<option selected disabled value="">Please Select</option>
					<option value="Event">Event</option>
					<option value="Artist">Artist</option>
					<option value="Speaker">Speaker</option>
					<option value="Workshop">Workshop</option>
					<option value="A-Suggestion"> A Suggestion</option>
					<option value="Just-an-Idea">Just an idea</option>
					<option value="Let-me-explain">Let me explain it...</option>
				</select>
			</div>
			<div class="form-group margin-bottom">
				<label for="idea">What do you have in mind?</label>
				<textarea class="form-control" rows="3" id="idea" name="idea" required></textarea>
			</div>
			<div class="form-group margin-bottom">
				<label for="needs">What will you need to do it?</label>
				<textarea class="form-control" rows="3" id="needs" name="needs" required></textarea>
			</div>
			<div class="form-group margin-bottom">
				<label for="appeal">Why does this idea or person appeal to you?</label>
				<input type="text" class="form-control" id="appeal" name="appeal">
			</div>
			<div class="form-group margin-bottom">
				<label for="details">Do you have any date, venue, or cost details in mind?</label>
				<input type="text" class="form-control" id="details" name="details">
			</div>
			<div class="form-group margin-bottom">
				<label for="extra_comments">What else can you tell us?</label>
				<input type="text" class="form-control" id="extra_comments" name="extra_comments">
			</div>
			<input type="hidden" name="site_title" value="<?php echo $siteTitle ?>">
			<input type="hidden" name="contact_email" value="<?php echo $contactEmail ?>">
			<div class="form-group margin-bottom">
				<button type="submit" id="submit" class="btn btn-primary">Submit Your Idea</button>
			</div>
			<div id="form-messages"></div>
		</form>