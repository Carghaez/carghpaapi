<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Request;

/**
 * A collection of misc functions helping to build the request
 *
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class Util
{
	/**
	 * Provides the current timestamp according to the requirements of amazon
	 *
	 * @return string
	 */
	public static function getTimeStamp()
	{
		return gmdate("Y-m-d\TH:i:s\Z");
	}

	/**
	 * Provides the signature
	 *
	 * @param string $stringToSign The string to be signed
	 * @param string $secretKey    The paapi secret key
	 *
	 * @return string
	 */
	public static function buildSignature($stringToSign, $secretKey)
	{
		return base64_encode(hash_hmac("sha256", $stringToSign, $secretKey, true));
	}
}
