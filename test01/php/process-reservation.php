<?php
	
	/**
	 *  Edit your email details here...
	 *  -----------------------------------------------------------------------
	 */
	$site_owners_email = 'youremail@example.com';	// Replace this with your own Email Address
	$site_owners_name  = 'John Smith';		 		// Replace with your name
	
	/**
	 *  Get the user's input and put them into variables
	 *  -----------------------------------------------------------------------
	 */
	$res_name		= trim( strip_tags( $_POST['res_name'] ) );
	$res_email		= strip_tags( $_POST['res_email'] );
	$res_phone		= strip_tags( $_POST['res_phone'] );
	$res_amount		= strip_tags( $_POST['res_amount'] );
	$res_date		= strip_tags( $_POST['res_date'] );
	$res_time		= strip_tags( $_POST['res_time'] );
	$res_message	= strip_tags( $_POST['res_message'] );
	
	/**
	 *  Error messages for invalid text fields
	 *  -----------------------------------------------------------------------
	 */
	$error_name		= 'Please enter your name!';
	$error_email	= 'Please enter a valid email address!';
	$error_phone	= 'Please provide a telephone contact number!';
	$error_amount	= 'Please tell us how many are coming!';
	$error_date		= 'Please enter a valid date!';
	$error_time		= 'Please enter a valid time!';
	
	/**
	 *  Basic validation
	 *  -----------------------------------------------------------------------
	 */
	if ( strlen( $res_name ) < 2 ) {
		$error['res_name'] = $error_name;	
	}
	
	if ( ! preg_match( '/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is' , $res_email ) ) {
		$error['res_email'] = $error_email;	
	}
	
	if( ! is_numeric( $res_phone ) ) {
		$error['res_phone'] = $error_phone;
	}
	
	if( empty( $res_amount ) ) {
		$error['res_amount'] = $error_amount;
	}
	
	if ( strlen( $res_date ) < 2 ) {
		$error['res_date'] = $error_date;	
	}
	
	if ( strlen( $res_time ) < 2 ) {
		$error['res_time'] = $error_time;
	}
	
	/**
	 *  If there's no errors, process the form
	 *  -----------------------------------------------------------------------
	 */
	if ( ! $error ) {
		
		require 'php-mailer/PHPMailerAutoload.php';
		
		/**
		 *  Email message sent to the site owner (HTML Allowed)
		 */
		$mail_message  = '<h2>You have a new booking! Here are the details&hellip;</h2>';
		$mail_message .= '<br />';
		$mail_message .= '<h3>Contact Details</h3>';
		$mail_message .= '<strong>Name:</strong> ' . $res_name . '<br />';
		$mail_message .= '<strong>Email Address:</strong> ' . $res_email . '<br />';
		$mail_message .= '<strong>Contact Number:</strong> ' . $res_phone . '<br />';
		$mail_message .= '<h3>Booking Details</h3>';
		$mail_message .= '<strong>Date:</strong> ' . $res_date . '<br />';
		$mail_message .= '<strong>Time:</strong> ' . $res_time . '<br />';
		$mail_message .= '<strong>For:</strong> ' . $res_amount . ' People<br />';
		if( ! empty( $res_message ) && $res_message !== null && $res_message !== '' ) {
			$mail_message .= '<strong>Message:</strong> ' . $res_message . '<br />';
		}
		
		$mail = new PHPMailer();
		
		$mail->From 		= $res_email;
		$mail->FromName 	= $res_name;
		$mail->Subject 		= 'Reservation Booking';
		$mail->AddAddress( $site_owners_email , $site_owners_name );
		$mail->IsHTML(true);
		$mail->Body 		= $mail_message;
		
		/**
		 *  GMail Configurations - Fill these out if you use GMail!
		 */
		$mail->Mailer 		= 'smtp';
		$mail->Host 		= 'smtp.gmail.com';
		$mail->Port 		= 587;
		$mail->SMTPSecure 	= 'tls'; 
		
		$mail->SMTPAuth 	= true; 					// turn on SMTP authentication
		$mail->Username 	= 'youremail@example.com';	// SMTP username (Usually same as email address)
		$mail->Password 	= 'YourPassword';			// SMTP password (This includes all upper and lower case letters)
		
		$mail->Send();
		
		$response  = '<div class="grid-100 tablet-grid-100 mobile-grid-100">' . "\n";
		$response .= '<div class="reservation-confirmed">' . "\n";
		$response .= '<i class="fa fa-thumbs-up"></i>' . "\n";
		$response .= '<h4 class="reservation-confirmed-title">Thanks a lot!</h4>' . "\n";
		$response .= '<p class="reservation-confirmed-text">Your party has requested a booking for <em>' . $res_time . '</em> on the date of <em>' . $res_date . '</em>. We\'ll be in touch soon to confirm your booking!</p>' . "\n";
		$response .= '</div>' . "\n";
		$response .= '</div>' . "\n";
		
		echo $response;
		
	} else {

		$response  = ( isset( $error['res_name'] ) )	? '<p>' . $error['res_name']	. '</p>' : null;
		$response .= ( isset( $error['res_email'] ) )	? '<p>' . $error['res_email']	. '</p>' : null;
		$response .= ( isset( $error['res_phone'] ) )	? '<p>' . $error['res_phone']	. '</p>' : null;
		$response .= ( isset( $error['res_amount'] ) )	? '<p>' . $error['res_amount']	. '</p>' : null;
		$response .= ( isset( $error['res_date'] ) )	? '<p>' . $error['res_date']	. '</p>' : null;
		$response .= ( isset( $error['res_time'] ) )	? '<p>' . $error['res_time']	. '</p>' : null;
		
		echo $response;

	}
	
?>