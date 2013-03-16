<?php require_once('recaptchalib.php');
class Captcha
{
	function verifycaptcha($challenge,$response)
	{
		$privatekey = "6Ld80d0SAAAAALVEpdfiOzNQFhA2UeMpnBFe7nxY";
		$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$challenge,$response);
		if ($resp->is_valid)
			return "1";
		else
			return "0";
	}
}
?>