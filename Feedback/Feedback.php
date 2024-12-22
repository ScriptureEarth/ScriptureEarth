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
<!DOCTYPE html>
<html>
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
	
	// Read in options
	$ax_reCaptcha	= false;
	$px_recaptcha_challenge_field = isset($_POST['recaptcha_challenge_field']) ? $_POST['recaptcha_challenge_field'] : '';
	$px_recaptcha_response_field  = isset($_POST['recaptcha_response_field']) ? $_POST['recaptcha_response_field'] : '';
	$nameError      = "";
	$emailError     = "";
	$subjectError   = "";
	$commentError   = "";
	$recaptchaError = "";
	$headers = '';
		
	// See if we're using reCaptcha
	if (isset($ax_publicKey) && $ax_publicKey != '' && isset($ax_privateKey) && $ax_privateKey != '') {
		$ax_reCaptcha = true;
		require_once('libs/recaptcha.php');
		$resp = recaptcha_check_answer ($ax_privateKey, $_SERVER['REMOTE_ADDR'], $px_recaptcha_challenge_field, $px_recaptcha_response_field);
	}
	
	// See if form was submitted
	if (isset($_POST['axMail'])) {
		
		if (isset($_POST['st'])) {
			$st=$_POST['st'];
			$test = preg_match('/^[a-z]{3}/', $st);
			if ($test === 0) {
				die ("<body><br />$st wasn’t found.</body></html>");
			}
		}
		else {
			$st = 'eng';
		}
		
		// Validate Name
			//$contactName = filter_input(INPUT_POST, 'contactName', FILTER_SANITIZE_STRING);
			if (isset($_POST['contactName'])) {
				$contactName = $_POST['contactName'];
				$contactName = trim($contactName);
				if (preg_match('/(^[-_\.@0-9 ]+$|[\*=+\(\)\{\}%!\^\$|\/`"\\#])/', $contactName)) {
					$nameError = 'Special characters and/or numbers found in your name.'; 
					$hasError = true;
				}
			}
		/*
			if ($contactName == '') { 
				$nameError = 'Please enter a valid name.';  
				$hasError = true;	
			}
			*/

		// Validate Email From
			$email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL ); 
			$email = trim($email);
			if ($email != '' && !filter_var( $email, FILTER_VALIDATE_EMAIL )) {  
				$emailError = '' . $email . ' is <strong>NOT</strong> a valid email address.';  
				$hasError = true;	
			}

		// Validate Subject
			//$subject = filter_input( INPUT_POST, 'subject' , FILTER_SANITIZE_STRING );
			if (isset($_POST['subject'])) {
				$subject = $_POST['subject'];
				$subject = trim($subject);
				if (preg_match('/(^[-_\.@0-9 ]+$|\(\)|&#|\$\(|\.\.\/|\$\{|@@|\)\)|\(\(|\|\|)/', $subject, $match)) {
					$subjectError = 'Special characters and/or numbers found in your subject.'; 
					$hasError = true;
				}
			}
			/*
			if ($subject == '') { 
				$subjectError = 'Please enter a valid subject.';  
				$hasError = true;
			}
			*/

		// Validate Message
			//$message = filter_input( INPUT_POST, 'message', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); 	
			if (isset($_POST['message'])) {
				$message = $_POST['message'];
				$message= trim($message);
				if (preg_match('/^[0-9]+$/', $message)) {
					$nameError = 'Numbers found in your message.'; 
					$hasError = true;
				}
				if ($message == '') {  
					$commentError = 'Please enter a message to send.<br/>';  
					$hasError = true;	
				}
			}
			if (isset($_POST['iso'])) {
				// These \r\n 's need to be here!
				$message .= '
				<br /><br />
				<p>iso: '.$_POST['iso'].' rod: '.$_POST['rod'].' var: '.$_POST['var'].' idx: '.$_POST['idx'].'</p>';
			}
			
		// Validate reCaptcha
			if ($ax_reCaptcha && !$resp->is_valid) {
				$recaptchaError = 'The reCAPTCHA wasn\'t entered correctly. Please try again.';
				$hasError = true;
			}

		// Capture Send To Email Address
			//$ax_mailTo = filter_input( INPUT_POST, 'emailTo', FILTER_SANITIZE_EMAIL);
			//$ax_mailTo = "Scott_Starker@sil.org";
			//$ax_mailTo = "ScriptureEarth@Wycliffe.ca";
			$ax_mailTo = "info@ScriptureEarth.org";
			if (!filter_var( $ax_mailTo, FILTER_VALIDATE_EMAIL )) {										// php filter_var !
				$emailError = '' . $ax_mailTo . ' is <strong>NOT</strong> a valid email address.';  
				$hasError = true;	
			}
			
		// If we didn't hit an error, send the email
			if (!isset($hasError)) {
				// Body:
					$body = '
						<p>Name: ' . $contactName . '</p>
						<p>Subject: '.$subject.'</p>
						<p>Feedback:<br />' . $message . '</p>
					';

				// Headers
					// Always set content-type when sending HTML email. Also, always use "\r\n" (with "!) at the end of the $headers lines.
					$headers = 'From: ' . $contactName . ' <' . $email . '>'."\r\n";
					$headers .= 'Reply-To: ' . $contactName . ' <' . $email . '>'."\r\n";
					//$headers .= 'To: ' . $ax_mailTo."\r\n";
					$headers .= 'Return-Path: ' . $contactName . ' <' . $email . '>'."\r\n";
					//$headers .= 'Bcc: Scott_Starker@sil.org'."\r\n";
					$headers .= 'X-Mailer: PHP v'.phpversion()."\r\n";
					$headers .= 'MIME-Version: 1.0'."\r\n";
					$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
					$headers .= 'Message-ID: <' . time() .'-' . md5($email . $ax_mailTo) . '@' . $_SERVER['SERVER_NAME'].'>'."\r\n";

				// Send it
					@ini_set('sendmail_from', $email);													// for Windows
					//@ini_set('sendmail_path', );
					// For example, to send HTML mail, the Content-type header must be set
					//$headers[] = 'MIME-Version: 1.0';													// $headers array is from PHP 7+
					//$headers[] = 'Content-type: text/html; charset=iso-8859-1';
					// Additional headers
					//$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
					//$headers[] = 'From: Birthday Reminder <birthday@example.com>';
					//$headers[] = 'Cc: birthdayarchive@example.com';
					//$headers[] = 'Bcc: birthdaycheck@example.com';
					// Mail it
					//mail($to, $subject, $message, implode("\r\n", $headers));
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
		if (isset($_GET['st'])) {
			$st=$_GET['st'];
			$test = preg_match('/^[a-z]{3}/', $st);
			if ($test === 0) {
				die ("<body><br />$st wasn’t found.</body></html>");
			}
		}
		else {
			$st = 'eng';
		}
		
		if (isset($_GET['iso'])) {
			$iso=$_GET['iso'];
			$test = preg_match('/^[a-z]{3}$/', $iso);
			if ($test === 0) {
				$iso='';
			}
		}
		else {
			$iso='';
		}
						
		if (isset($_GET['rod'])) {
			$rod=$_GET['rod'];
			$test = preg_match('/^[A-Za-z0-9]{,5}*$/', $rod);
			if ($test === 0) {
				$rod='00000';
			}
		}
		else {
			$rod='00000';
		}
						
		if (isset($_GET['var'])) {
			$var=$_GET['var'];
			$test = preg_match('/^[a-z]$/', $var);
			if ($test === 0) {
				$var='';
			}
		}
		else {
			$var='';
		}
		
		if (isset($_GET['idx'])) {
			$idx=$_GET['idx'];
			$test = preg_match('/^[0-9]*$/', $idx);
			if ($test === 0) {
				$idx='';
			}
		}
		else {
			$idx='';
		}
		?>
        
		<?php
		if ($st == 'arb') {
		?>
		<style>
			* {
				direction: rtl;
			}
		</style>
		<?php
		}
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
            <?php if ($iso != '') { ?>
                <input type="hidden" name="st" id="st" title="st" value='<?php echo $st ?>' />
                <input type="hidden" name="iso" id="iso" title="iso" value='<?php echo $iso ?>' />
                <input type="hidden" name="rod" id="rod" title="rod" value='<?php echo $rod ?>' />
                <input type="hidden" name="var" id="var" title="var" value='<?php echo $var ?>' />
                <input type="hidden" name="idx" id="idx" title="idx" value='<?php echo $idx ?>' />
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
