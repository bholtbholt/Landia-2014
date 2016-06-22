<?php
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);
        $relation = trim($_POST["relation"]);
        $idea = trim($_POST["idea"]);
        $needs = trim($_POST["needs"]);
        $appeal = trim($_POST["appeal"]);
        $details = trim($_POST["details"]);
        $extra_comments = trim($_POST["extra_comments"]);
        $siteTitle = trim($_POST["site_title"]);;
        $contactEmail = trim($_POST["contact_email"]);;

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($relation) OR empty($idea) OR empty($needs) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            // http_response_code(400); //Needs to be PHP 5.4+
            header('PHP-Response-Code: 404', true, 404);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        $recipient = $contactEmail;

        // Set the email subject.
        $emailSubject = "New message from $siteTitle";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "The idea relates to:\n$relation\n\n";
        $email_content .= "What this appeals to $name:\n$appeal\n\n";
        $email_content .= "Idea:\n$idea\n\n";
        $email_content .= "Needs:\n$needs\n\n";
        $email_content .= "Date, Venue, or Cost Details:\n$details\n\n";
        $email_content .= "Additional Comments:\n$extra_comments\n\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $emailSubject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            // http_response_code(200); //Needs to be PHP 5.4+
            header('PHP-Response-Code: 200', true, 200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            //http_response_code(500);  //Needs to be PHP 5.4+
            header('PHP-Response-Code: 505', true, 505);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        //http_response_code(403); //Needs to be PHP 5.4+
        header('PHP-Response-Code: 403', true, 403);
        echo "There was a problem with your submission, please try again.";
    }

?>