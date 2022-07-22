<?php
//	Originally created by John Dimm http://webspeechapi.blogspot.co.uk/2013/04/how-to-use-new-bing-translator-api-with.html

//ScriptureEarth.org -- AJAX Microsoft Translator Bing AppID:
//$ClientID="8987";
//$ClientSecret="5v8DZ7euDxJl+HIm7G26qVFifDUVkxdcgGAABV+dNBI=";
//to get an access token for use on the AJAX translation API.
$ClientID="8987";
$ClientSecret="5v8DZ7euDxJl+HIm7G26qVFifDUVkxdcgGAABV+dNBI=";

$ClientSecret = urlencode ($ClientSecret);
$ClientID = urlencode($ClientID);

// Get a 10-minute access token for Microsoft Translator API.
$url = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13";
$postParams = "grant_type=client_credentials&client_id=$ClientID&client_secret=$ClientSecret&scope=http://api.microsofttranslator.com";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
//curl_setopt ($ch, CURLOPT_CAINFO, "./cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$hostname = $_SERVER['SERVER_ADDR'];	// localhost = 127.0.0.1
//$port = $_SERVER['SERVER_PORT'];
if ($hostname != "127.0.0.1")
	curl_setopt($ch, CURLOPT_PROXY, "http://proxy.wycliffe.ca:4128");

$rsp = curl_exec($ch); 
//Get the Error Code returned by Curl.
$curlErrno = curl_errno($ch);
if ($curlErrno) {
	$curlError = curl_error($ch);
	throw new Exception($curlError);
}
curl_close($ch);

print $rsp;
// like: {"token_type":"http://schemas.xmlsoap.org/ws/2009/11/swt-token-profile-1.0",
//       "access_token":"http%3a%2f%2fschemas.xmlsoap.org%2fws%2f2005%2f05%2fidentity%2fclaims%2fnameidentifier=8987&http%3a%2f%2fschemas.microsoft.com%2faccesscontrolservice%2f2010%2f07%2fclaims%2fidentityprovider=https%3a%2f%2fdatamarket.accesscontrol.windows.net%2f&Audience=http%3a%2f%2fapi.microsofttranslator.com&ExpiresOn=1397880047&Issuer=https%3a%2f%2fdatamarket.accesscontrol.windows.net%2f&HMACSHA256=Ntr0HbmiFWVyowb95Rw4WLMl7bAYFaTcm8jDfkeYXv8%3d",
//       "expires_in":"599",
//       "scope":"http://api.microsofttranslator.com"}
?>