<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Configuration;

use CarghPAAPI\Request\RequestInterface;
use CarghPAAPI\ResponseTransformer\ResponseTransformerInterface;

/**
 * A generic configuration Class
 *
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class GenericConfiguration implements ConfigurationInterface
{
	/**
	 * The country
	 *
	 * @var string
	 */
	protected $country;

	/**
	 * The accesskey
	 *
	 * @var string
	 */
	protected $accessKey;

	/**
	 * The string
	 *
	 * @var string
	 */
	protected $secretKey;

	/**
	 * The associate Tag
	 *
	 * @var string
	 */
	protected $associateTag;

	/**
	 * The requestclass
	 * By default its set to the provided restful request
	 *
	 * @var RequestInterface
	 */
	protected $request;

	/**
	 * The responsetransformerclass
	 * By default its set to null which means that no transformer will be applied
	 *
	 * @var ResponseTransformerInterface
	 */
	protected $responseTransformer;

	/**
	 * {@inheritdoc}
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * Sets and validates the country
	 *
	 * @param string $country
	 *
	 * @return \CarghPAAPI\Configuration\GenericConfiguration
	 */
	public function setCountry($country)
	{
		if (!Country::isValidCountry($country))
		{
			throw new \InvalidArgumentException(sprintf(
					"Invalid Country-Code: %s! Possible Country-Codes: %s",
					$country,
					implode(', ', Country::getCountries())
			));
		}
		$this->country = strtolower($country);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAccessKey()
	{
		return $this->accessKey;
	}

	/**
	 * Sets the accesskey
	 *
	 * @param string $accessKey
	 *
	 * @return \CarghPAAPI\Configuration\GenericConfiguration
	 */
	public function setAccessKey($accessKey)
	{
		$this->accessKey = $accessKey;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSecretKey()
	{
		return $this->secretKey;
	}

	/**
	 * Sets the secretkey
	 *
	 * @param string $secretKey
	 *
	 * @return \CarghPAAPI\Configuration\GenericConfiguration
	 */
	public function setSecretKey($secretKey)
	{
		$this->secretKey = $secretKey;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAssociateTag()
	{
		return $this->associateTag;
	}

	/**
	 * Sets the associatetag
	 *
	 * @param string $associateTag
	 *
	 * @return \CarghPAAPI\Configuration\GenericConfiguration
	 */
	public function setAssociateTag($associateTag)
	{
		$this->associateTag = $associateTag;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * Sets the Request.
	 *
	 * @param RequestInterface $request
	 *
	 * @return \CarghPAAPI\Configuration\GenericConfiguration
	 */
	public function setRequest(RequestInterface $request)
	{
		$this->request = $request;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getResponseTransformer()
	{
		return $this->responseTransformer;
	}

	/**
	 * Sets the ResponseTransformer
	 *
	 * @param ResponseTransformerInterface $responseTransformer
	 *
	 * @return \CarghPAAPI\Configuration\GenericConfiguration
	 */
	public function setResponseTransformer(ResponseTransformerInterface $responseTransformer)
	{
		$this->responseTransformer = $responseTransformer;
		return $this;
	}
}
