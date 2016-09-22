<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Request;

use CarghPAAPI\CarghPAAPI;
use CarghPAAPI\Configuration\ConfigurationInterface;
use CarghPAAPI\Operations\OperationInterface;

/**
 * Basic implementation of the rest request
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/AnatomyOfaRESTRequest.html
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class CurlRequest implements RequestInterface
{
	/**
	 * The requestscheme
	 *
	 * @var string
	 */
	private $requestTemplate = "%s://webservices.amazon.%s/onca/xml?%s";

	/**
	 * The scheme for the uri. E.g. http or https.
	 *
	 * @var string
	 */
	private $scheme = 'http';

	/**
	* curl options
	*
	* @var array
	*/
	private $options = [];

	/**
	 * Initialize instance
	 *
	 * @param ClientInterface $client
	 */
	public function __construct(array $options = [])
	{
		$this->options = [
			CURLOPT_USERAGENT       => 'CarghPAAPI [' . CarghPAAPI::VERSION . ']',
			CURLOPT_CUSTOMREQUEST   => 'GET',
			CURLOPT_CONNECTTIMEOUT  => 10,
			CURLOPT_TIMEOUT         => 10,
			CURLOPT_FOLLOWLOCATION  => 1
		];
		$this->setOptions($options);
	}

	/**
	* Sets the curl options
	*
	* @param array $options
	*/
	public function setOptions(array $options = [])
	{
		foreach ($options as $currentOption => $currentOptionValue)
			$this->options[$currentOption] = $currentOptionValue;
		$this->options[CURLOPT_RETURNTRANSFER] = 1; // true or 1: force the return transfer
	}

	/**
	 * {@inheritdoc}
	 */
	public function perform(OperationInterface $operation, ConfigurationInterface $configuration)
	{
		$ch = curl_init();
		if (false === $ch) throw new \RuntimeException("Cannot initialize curl resource");

		$preparedRequestParams = $this->prepareRequestParams($operation, $configuration);
		$queryString = $this->buildQueryString($preparedRequestParams, $configuration);
		$url = sprintf($this->requestTemplate, $this->scheme, $configuration->getCountry(), $queryString);
		$this->options[CURLOPT_URL] = $url;

		// foreach ($this->options as $currentOption => $currentOptionValue)
		// {
		// 	if (false === curl_setopt($ch, $currentOption, $currentOptionValue))
		// 	{
		// 		throw new \RuntimeException(sprintf(
		// 				"An error occurred while setting %s with value %s",
		// 				$currentOption,
		// 				$currentOptionValue
		// 		));
		// 	}
		// }
		curl_setopt_array($ch, $this->options);

		$result = curl_exec($ch);
		if (false === $result)
		{
			$errorNumber = curl_errno($ch);
			$errorMessage = curl_error($ch);
			curl_close($ch);
			throw new \RuntimeException(sprintf(
					"An error occurred while sending request. Error number: %d; Error message: %s",
					$errorNumber,
					$errorMessage
			));
		}
		curl_close($ch);
		return $result;
	}

	/**
	 * Sets the scheme.
	 *
	 * @param string $scheme
	 */
	public function setScheme($scheme)
	{
		if (!in_array($scheme = strtolower($scheme), ['http', 'https']))
			throw new \InvalidArgumentException('The scheme can only be http or https.');
		$this->scheme = $scheme;
	}

	/**
	 * Prepares the parameters for the request
	 *
	 * @param OperationInterface     $operation
	 * @param ConfigurationInterface $configuration
	 *
	 * @return array
	 */
	protected function prepareRequestParams(OperationInterface $operation, ConfigurationInterface $configuration)
	{
		$baseRequestParams = [
			'Service'        => 'AWSECommerceService',
			'AWSAccessKeyId' => $configuration->getAccessKey(),
			'AssociateTag'   => $configuration->getAssociateTag(),
			'Operation'      => $operation->getName(),
			'Version'        => '2013-08-01', // hardcoded version dependent by documentation
			'Timestamp'      => Util::getTimeStamp()
		];

		$operationParams = $operation->getOperationParameter();
		foreach ($operationParams as $key => $value)
			if (true === is_array($value))
				$operationParams[$key] = implode(',', $value);

		$fullParameterList = array_merge($baseRequestParams, $operationParams);
		ksort($fullParameterList);

		return $fullParameterList;
	}

	/**
	 * Builds the final querystring including the signature
	 *
	 * @param array                  $params
	 * @param ConfigurationInterface $configuration
	 *
	 * @return string
	 */
	protected function buildQueryString(array $params, ConfigurationInterface $configuration)
	{
		$parameterList = [];
		foreach ($params as $key => $value)
			$parameterList[] = sprintf('%s=%s', $key, rawurlencode($value));

		$parameterList[] = 'Signature=' . rawurlencode(
			$this->buildSignature($parameterList, $configuration->getCountry(), $configuration->getSecretKey())
		);

		return implode("&", $parameterList);
	}

	/**
	 * Calculates the signature for the request
	 *
	 * @param array  $params
	 * @param string $country
	 * @param string $secret
	 *
	 * @return string
	 */
	protected function buildSignature(array $params, $country, $secret)
	{
		return Util::buildSignature(
			sprintf(
				"GET\nwebservices.amazon.%s\n/onca/xml\n%s",
				$country,
				implode('&', $params)
			),
			$secret
		);
	}
}
