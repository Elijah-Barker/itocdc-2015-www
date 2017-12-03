<?php
// ***** combine with config.php? *****
// security header settings
header("X-XSS-Protection: 1");

//XSS Fixed here.  Usage in view.php, etc.
function CleanXSS($unsanitized)
{
	$sanitized = str_replace("<","&lt;",$unsanitized);
	return $sanitized;
}

?> 
