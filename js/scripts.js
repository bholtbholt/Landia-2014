jQuery(document).ready(function($) {
	// Mailto Anti Spam logic
	// Use: <a class="mailto" data-domain="youneeq.ca" data-prefix="info" ></a>
  $('.mailto').each(function() {
      prefix = $(this).data('prefix');
      domain = $(this).data('domain');
      text = $(this).data('text') ? $(this).data('text') : prefix+'@'+domain;
      $(this).attr('href', 'mailto:'+prefix+'@'+domain).append(text);
  });

  // Scroll the hidden Speakers
  $(function() {
      var ele   = $('#speaker-list-div');
      var speed = 25, scroll = 3, scrolling;
      
      $('.scroll-speakers-list').mouseenter(function() {
          // Scroll the element down
          scrolling = window.setInterval(function() {
              ele.scrollTop( ele.scrollTop() + scroll );
          }, speed);
      });
      
      $('.scroll-speakers-list, .scroll-speakers-list').bind({
          click: function(e) {
              // Prevent the default click action
              e.preventDefault();
          },
          mouseleave: function() {
              if (scrolling) {
                  window.clearInterval(scrolling);
                  scrolling = false;
              }
          }
      });
  });


  // Scrolls to the next article from the top
  $('.scroll-arrow').click(function(event) {
    link = $(this).parent().next('article').attr('id');
		$('body,html').animate({scrollTop: $('#'+link).position().top}, 800);
  });


  // Scrolls to button
  $('.scroll-button').click(function(event) {
  	scroll = $(this).data('scroll');
  	$('body,html').animate({scrollTop: $('#'+scroll).position().top}, 800);
  });


  // Scrolls to the article from the menu
  $('.slide-menu a').click(function(event) {
		link = $(this).attr('title');
		if ($('#'+link).length) {
	  	event.preventDefault();
  	 	$('body,html').animate({scrollTop: $('#'+link).position().top}, 800);
  	}
  });

  // Make Home Navigation links send users to
  // the right spot when navigation from another page
  $('.slide-menu a').each(function() {
  	link = $(this).attr('title');
  	href = $(this).attr('href');
  	$(this).attr('href', href+'#'+link);
  })


  // Toggles side navigation
  var isSideNavOpen = false;
  $('#toggle-side-nav').click(function(event) {
  	if (isSideNavOpen) {
  		$('#side-nav').animate({left: -202}, 600);
  		isSideNavOpen = false;
  	} else {
  		$('#side-nav').animate({left: 0}, 600);
  		isSideNavOpen = true;
  	}
  });


  // Enable Tool Tips
  $('.team-member-tooltip').tooltip({html:true});


	//Ajax contact form
	$(function() {
		var form = $('#ContactForm');
		var formMessages = $('#form-messages');

		$(form).submit(function(event) {
			event.preventDefault();
			var formData = $(form).serialize();

			$.ajax({  
				type: "POST",
				data: formData,
				url: landia_scripts_vars.template_path + '/snippets/forms/contactForm.php'				
			}).done(function(response) {
		    // Set the message text.
		    $(formMessages).show().text(response);

		    // Clear the form.
        formIDS = ['name', 'email', 'phone', 'relation', 'idea', 'needs', 'appeal', 'details', 'extra_comments'];
        for (id in formIDS) {
          $('#'+formIDS[id]).val('');
        }
		    $(formMessages).delay(2500).fadeOut();
			}).fail(function(data) {
		    // Set the message text.
		    if (data.responseText !== '') {
	        $(formMessages).text(data.responseText);
		    } else {
	        $(formMessages).text('Oops! An error occurred and your message could not be sent.');
		    }
			})
		});
	})
});