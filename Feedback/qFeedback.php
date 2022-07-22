<?php
/*
 * ContactForm
 * 
 * Created by: Doni Ronquillo                            
 * Modified by: CodeMunkyX
 * Modified by: Scott Starker
 * 
 * Copyright (c) 2011 http://www.free-php.net
 *
 * GPLv3 - (see LICENSE-GPLv3 included in folder)               
 *                                                                        
 * ContactForm is free software you can redistribute it and/or modify      
 * it under the terms of the GNU General Public License as published by   
 * the Free Software Foundation, either version 3 of the License, or      
 * (at your option) any later version.                                    
 *                                                                        
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Feedback</title>
</head>
<body>
<?php
include("../include/conn.inc.php");								// connect to the database named 'scripture'
include("../translate/functions.php");

include('inc/config.inc');
include('inc/header.php');

if (isset($_GET['st'])) {
	$st=$_GET['st'];
	$test = preg_match('/^[a-z]{3}/', $st);
	if ($test === 0) {
		die ("<body><br />$st wasn’t found.</body></html>");
	}
}

if (isset($_GET['ISO'])) {
	$ISO=$_GET['ISO'];
	$test = preg_match('/^[a-z]{3}$/', $ISO);
	if ($test === 0) {
		$ISO='';
	}
}
else {
	$ISO='';
}
				
if (isset($_GET['ROD_Code'])) {
	$ROD_Code=$_GET['ROD_Code'];
	$test = preg_match('/^[A-Za-z0-9]{,5}*$/', $ROD_Code);
	if ($test === 0) {
		$ROD_Code='00000';
	}
}
else {
	$ROD_Code='00000';
}
				
if (isset($_GET['Variant_Code'])) {
	$Variant_Code=$_GET['Variant_Code'];
	$test = preg_match('/^[a-z]$/', $Variant_Code);
	if ($test === 0) {
		$Variant_Code='';
	}
}
else {
	$Variant_Code='';
}

if (isset($_GET['ISO_ROD_index'])) {
	$ISO_ROD_index=$_GET['ISO_ROD_index'];
	$test = preg_match('/^[0-9]*$/', $ISO_ROD_index);
	if ($test === 0) {
		$ISO_ROD_index='';
	}
}
else {
	$ISO_ROD_index='';
}

	// Read in options
		$ax_reCaptcha	= false;
		$px_recaptcha_challenge_field = isset($_POST['recaptcha_challenge_field']) ? $_POST['recaptcha_challenge_field'] : '';
		$px_recaptcha_response_field  = isset($_POST['recaptcha_response_field']) ? $_POST['recaptcha_response_field'] : '';
		$nameError      = "";
		$emailError     = "";
		$subjectError   = "";
		$commentError   = "";
		$recaptchaError = "";
		
	// See if we're using reCaptcha
		if (isset($ax_publicKey) && $ax_publicKey != '' &&	isset($ax_privateKey) && $ax_privateKey != '') {
			$ax_reCaptcha = true;
			require_once('libs/recaptcha.php');
			$resp = recaptcha_check_answer ($ax_privateKey, $_SERVER['REMOTE_ADDR'], $px_recaptcha_challenge_field, $px_recaptcha_response_field);
		}
	
	// See if form was submitted
		if (isset($_POST['axMail'])) {
			
			// Validate Name
				$contactName = filter_input(INPUT_POST, 'contactName', FILTER_SANITIZE_STRING); 
			/*
				if ($contactName == '') { 
					$nameError = 'Please enter a valid name.';  
					$hasError = true;	
				}
				*/

			// Validate Email From
				$email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL ); 
			/*
				if (!filter_var( $email, FILTER_VALIDATE_EMAIL )) {  
					$emailError = '' . $email . ' is <strong>NOT</strong> a valid email address.';  
					$hasError = true;	
				}
				*/

			// Validate Subject
				$subject = filter_input( INPUT_POST, 'subject' , FILTER_SANITIZE_STRING ); 
				/*
				if ($subject == '') { 
					$subjectError = 'Please enter a valid subject.';  
					$hasError = true;
				}
				*/
			// Validate Message
				$message = filter_input( INPUT_POST, 'message', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); 	
				if ($message == '') {  
					$commentError = 'Please enter a message to send.<br/>';  
					$hasError = true;	
				}
				if (isset($_POST['ISO'])) {
					// These \r\n 's need to be here!
					$message .= '
					<br /><br />
					<p>ISO: '.$_POST['ISO'].' ROD_Code: '.$_POST['ROD_Code'].' Variant_Code: '.$_POST['Variant_Code'].' ISO_ROD_index: '.$_POST['ISO_ROD_index'].'</p>';
				}
				
			// Validate reCaptcha
				if ($ax_reCaptcha && !$resp->is_valid) {
					$recaptchaError = 'The reCAPTCHA wasn\'t entered correctly. Please try again.';
					$hasError = true;
				}

         	// Capture Send To Email Address
				//$ax_mailTo = filter_input( INPUT_POST, 'emailTo', FILTER_SANITIZE_EMAIL);
				//$ax_mailTo = "Scott_Starker@sil.org";
				$ax_mailTo = "ScriptureEarth@Wycliffe.ca";
				if (!filter_var( $ax_mailTo, FILTER_VALIDATE_EMAIL )) {										// php filter_var !
					$emailError = '' . $ax_mailTo . ' is <strong>NOT</strong> a valid email address.';  
					$hasError = true;	
				}
				
			// If we didn't hit an error, send the email
				if (!isset($hasError)) {

					// Body:
						$body = '
							<p>Name: ' . $contactName . '</p>
							<p>Email: ' . $email . '</p>
							<p>Feedback:<br />' . $message . '</p>
						';

					// Headers
						// Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
						$headers .= 'From: <' . $email . ">\r\n" .
							"X-Mailer: php\r\n";
						$headers .= 'Bcc: ' . 'Scott.Starker@gmail.com' . "\r\n";
						//  Reply-To: ' . $email . '

					// Send it
						@ini_set('sendmail_from', $email);													// for Windows
						//@ini_set('sendmail_path', );
						if (mail($ax_mailTo, $ax_mailSubject . ' : ' . $subject, $body, $headers)) {
							//echo 'SENT!<br />';
							$emailSent = true;
						}
						else {
							//echo 'DID NOT SEND!<br />';
							$errorMessage = error_get_last()['message'];
							echo $errorMessage . '<br />';
						}
				}
		}
	
	// Output template
		echo '<div class="ax-outer">';
		if (isset($emailSent) && $emailSent == true) { 
			echo '
				<h1 style="text-align: center; ">' . translate($finishedtext, $st, 'sys') . '</h1>
			';
			/*echo '
				<h1>Thanks, ' . $contactName . '</h1>
				<p>' . $finishedtext . '</p>
			';*/
		}
		else {
		?>
				<!--h1>Contact Form</h1-->
                <h1><?php echo translate('Feedback', $st, 'sys') ?><br /><span style="letter-spacing: normal; font-size: 11pt; "><?php echo translate('All that is required is the ‘message’.', $st, 'sys') ?></span></h1>
                
				<?php if ($ax_reCaptcha) { ?>
					<script type="text/javascript">
						var RecaptchaOptions = {
							theme : '<?php echo $ax_recaptchaTheme; ?>'
						};
					</script>
				<?php } ?>
				<form action="Feedback.php" id="ax-contactForm" method="post">
					<?php if ($nameError != '') { ?>
						<p class="error"><?php echo $nameError; ?></p> 
					<?php } ?>
					<label for="contactName" class="ax-label"><?php echo translate('Name', $st, 'sys') ?></label>
					<input type="text" name="contactName" id="contactName" title="name" value="<?php if (isset($contactName)) echo $contactName;?>" class="requiredField ax-input" />
					<?php if ($emailError != '') { ?>
						<p class="error"><?php echo $emailError; ?></p>
					<?php } ?>
					<label for="email" class="ax-label"><?php echo translate('Email', $st, 'sys') ?></label>
					<input type="text" name="email" id="email" title="email" value="<?php if (isset($email)) echo $email;?>" class="requiredField email ax-input" />
					<?php if ($subjectError != '') { ?>
						<p class="error"><?php echo $subjectError; ?></p> 
					<?php } ?>							
					<label for="subject" class="ax-label"><?php echo translate('Subject', $st, 'sys') ?></label>
					<input type="text" name="subject" id="subject" title="subject" value="<?php if (isset($subject)) echo $subject;?>" class="requiredField ax-input" />
					<?php if ($commentError != '') { ?>
						<p class="error"><?php echo $commentError; ?></p> 
					<?php } ?>
					<label for="message" class="ax-label"><?php echo translate('Message', $st, 'sys') ?></label>
					<textarea name="message" id="message" title="comments" rows="20" cols="30" class="requiredField ax-textarea"><?php if (isset($message)) { if (function_exists('stripslashes')) { echo stripslashes($message); } else { echo $message; } } ?></textarea>
					<?php if ($ISO != '') { ?>
                        <input type="hidden" name="st" id="st" title="st" value='<?php echo $st ?>' />
                        <input type="hidden" name="ISO" id="ISO" title="ISO" value='<?php echo $ISO ?>' />
                        <input type="hidden" name="ROD_Code" id="ROD_Code" title="ROD_Code" value='<?php echo $ROD_Code ?>' />
                        <input type="hidden" name="Variant_Code" id="Variant_Code" title="Variant_Code" value='<?php echo $Variant_Code ?>' />
                        <input type="hidden" name="ISO_ROD_index" id="ISO_ROD_index" title="ISO_ROD_index" value='<?php echo $ISO_ROD_index ?>' />
					<?php } ?>
                    <!--label for="emailTo" class="ax-label">Send To</label>
					<select id="emailTo" name='emailTo' class="requiredField ax-select">
						< ?php
							for($i=0; $i < count($adminemail); $i++) {
								foreach($adminemail[$i] as $key => $val) {
									echo '<option value="'.$key.'">'.$val.'</option>';
								}
							}
						?>
					</select-->
					<?php if ($ax_reCaptcha) { ?>
						<?php if ($recaptchaError != '') { ?>
							<p class="error"><?php echo $recaptchaError ; ?></p>
						<?php } ?>
							<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?php echo $ax_publicKey; ?>"></script>
							<noscript>
								<iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo $ax_publicKey; ?>" height="300" width="500" frameborder="0"></iframe><br />
								<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
								<input type="hidden" name="recaptcha_response_field" value="manual_challenge" />
							</noscript>
					<?php } ?>
					<input type="hidden" name="axMail" id="axMail" value="true" />
					<button type="submit" class="ax-button"><?php echo translate('Send Message', $st, 'sys') ?></button>	
				</form>
		<?php 
		}
		echo '</div>';
		//include('inc/footer.php');
?>
<script language="javascript" type="text/javascript">
	document.getElementById('contactName').focus();
</script>
</body>
</html>
