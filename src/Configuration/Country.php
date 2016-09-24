<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Configuration;

/**
 * Countryvalidation and countrylistings according to the amazonapi
 *
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
final class Country
{
	/**
	 * Possible countries
	 * Important for the requestendpoints
	 *
	 * @var array
	 */
	private static $countryList = [
		'ca',
		'cn',
		'co.jp',
		'co.uk',
		'com',
		'com.au',
		'com.br',
		'com.mx',
		'de',
		'es',
		'fr',
		'in',
		'it'
	];

	/**
	 * Gets all possible countries
	 *
	 * @return array
	 */
	public static function getCountries()
	{
		return self::$countryList;
	}

	/**
	 * Checks if the given value is a valid country
	 *
	 * @param string  $country
	 *
	 * @return boolean
	 */
	public static function isValidCountry($country)
	{
		return in_array(strtolower($country), self::$countryList) ? true : false;
	}
}
