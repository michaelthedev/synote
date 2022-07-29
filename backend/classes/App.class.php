<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 18 Jul, 2022 11:01AM
// +------------------------------------------------------------------------+
// | 2022 Logad Networks
// +------------------------------------------------------------------------+

// +----------------------------+
// | APP class
// +----------------------------+

class App {
	## Clean string ##
	public static function clean($string) {
		if (is_object($string) || is_array($string)) return $string;
		return trim(htmlentities($string));
	}

	## Encrypt string ##
	public static function encrypt($string) {
		$simple_string = $string;
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;

		$encryption_iv = 'Rhm2lRLbGwi5m(!!';
		$encryption_key = "5OZHVomiqK4e62RT1zaFWur0jAY3cEkf";

		return openssl_encrypt($simple_string, $ciphering,
			$encryption_key, $options, $encryption_iv);
	}

	## Decrypt string ##
	public static function decrypt($string) {
		$encryption = $string;
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;

		$decryption_iv = 'Rhm2lRLbGwi5m(!!';
		$decryption_key = "5OZHVomiqK4e62RT1zaFWur0jAY3cEkf";

		return openssl_decrypt ($encryption, $ciphering,
			$decryption_key, $options, $decryption_iv);
	}

	## Generate random string ##
	public static function GenerateKey($minlength = 20, $maxlength = 20, $uselower = true, $useupper = true, $usenumbers = true, $usespecial = false) {
		$charset = '';
		if ($uselower) {
			$charset .= "abcdefghijklmnopqrstuvwxyz";
		}
		if ($useupper) {
			$charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		}
		if ($usenumbers) {
			$charset .= "0123456789";
		}
		if ($usespecial) {
			$charset .= "~@#$%^*()_+-={}|][";
		}
		if ($minlength > $maxlength) {
			$length = mt_rand($maxlength, $minlength);
		} else {
			$length = mt_rand($minlength, $maxlength);
		}
		$key = '';
		for ($i = 0; $i < $length; $i++) {
			$key .= $charset[(mt_rand(0, strlen($charset) - 1))];
		}
		return $key;
	}
}