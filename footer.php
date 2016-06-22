<?php $contactID = get_page_by_title('Contact')->ID;
			$contactBG = esc_html( get_post_meta( $contactID, 'bg_color', true ) );
			$contactEmail = esc_html( get_post_meta( $contactID, 'contact_email', true ) );
			$emailArray = explode('@',$contactEmail);
			$emailDomain = $emailArray[1];
			$emailPrefix = $emailArray[0];
			$contactAddress = get_post_meta( $contactID, 'contact_address', true );
			$sponsorLink = esc_html( get_post_meta( $contactID, 'sponsor_link', true ) );
			$volunteerLink = esc_html( get_post_meta( $contactID, 'volunteer_link', true ) ); ?>

<footer id="main-footer" class="<?php echo $contactBG ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h4 class="giant-text caps">With <br>support <br><strong>from</strong></h4>
				<p class="social-icons text-shadow">
					<?php echo landia_social_icons_row($contactID) ?>
          <a class="glyphicon glyphicon-envelope mailto" title="Email" data-domain="<?php echo $emailDomain ?>" data-prefix="<?php echo $emailPrefix ?>" data-text=" "></a>
        </p>
      </div>
      <div class="col-sm-6">
      	<img src="http://thinklandia.ca/wp-content/uploads/2014/08/logos.svg" class="img-responsive">
      </div>
    </div><!-- close row -->
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
		        <p><a class="mailto" data-domain="<?php echo $emailDomain ?>" data-prefix="<?php echo $emailPrefix ?>" ></a></p>
		        <p><?php echo $contactAddress ?></p>
		        <p>&copy; <?php echo date("Y") ?></p>
		      </div>
		      <div class="col-sm-6">
		      	<p>Designed by <br>J. MacDonald</p>
		      	<p>Site Development by <br><a href="http://www.brianholt.ca" target="_blank">Brian Holt</a></p>
		    	</div>
	    	</div>
			</div> <!-- close col-sm-6 -->
			<div class="col-sm-6">
				<?php if ($sponsorLink) : ?><a href="<?php echo $sponsorLink ?>" class="btn btn-primary pull-left">Become a Sponsor</a><?php endif ?>
				<?php if ($volunteerLink) : ?><a href="<?php echo $volunteerLink ?>" class="btn btn-primary pull-right">Apply to Volunteer</a><?php endif ?>
				<div class="clearfix"></div>
			</div> <!-- close col-sm-6-->
		</div><!-- close row -->
	</div><!--close .container-->
</footer>

<?php wp_footer(); ?>
</body>
</html>