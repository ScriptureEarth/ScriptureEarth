<?php
/*
 * ContactForm
 * 
 * Created by: Doni Ronquillo                            
 * Modified by: CodeMunkyX
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

# Specify text to prepend to the subject filled out in the contact form
$ax_mailSubject  	 = "[Feedback]";
# $ax_mailSubject  	 = "[Contact Form]";

# If you do not have a reCAPTCHA API Key - visit the following URL to signup
# http://www.google.com/recaptcha/whyrecaptcha
# If the following are left blank, this feature will simply be ignored

$ax_publicKey		 = "";
$ax_privateKey		 = "";
$ax_recaptchaTheme = "clean"; // valid values = red, white, blackglass, clean

# variables below corresponds to the Send to * in your contact form
# follow same formatting below to add new entries to the select box

# see Feedback -- Capture Send To Email Address
# $adminemail[] = array("cs@yourdomain.com" => "Customer Service");
# $adminemail[] = array("info@yourdomain.com" => "Information");
# $adminemail[] = array("support@yourdomain.com" => "Technical Support");

# text to display when form is submitted
$finishedtext = "Thank you for your feedback.";
#$finishedtext = "Your email was successfully sent. We will be in touch soon.";

# reCAPTCHA Variables - do not modify unless these change
define("RECAPTCHA_API_SERVER", "http://www.google.com/recaptcha/api");
define("RECAPTCHA_API_SECURE_SERVER", "https://www.google.com/recaptcha/api");
define("RECAPTCHA_VERIFY_SERVER", "www.google.com");
?>