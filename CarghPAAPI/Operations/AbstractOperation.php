<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

/**
 * A base implementation of the OperationInterface
 *
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
abstract class AbstractOperation implements OperationInterface
{
	/**
	 * @var array
	 */
	protected $parameters = [];

	/**
	 * Returns an array of responseGroups
	 *
	 * @return array
	 */
	public function getResponseGroup()
	{
		return $this->getSingleOperationParameter('ResponseGroup');
	}

	/**
	 * Sets the responsegroups for the current operation
	 * Which responsegroup are available depends on the Operation you perform
	 *
	 * @param array $responseGroups The responsegroup as an array
	 *
	 * @see http://docs.aws.amazon.com/AWSECommerceService/latest/DG/CHAP_ResponseGroupsList.html
	 */
	public function setResponseGroup(array $responseGroup)
	{
		$this->parameters['ResponseGroup'] = $responseGroup;
		return $this;
	}

	/**
	 * Returns all paramerters belonging to the current operation
	 *
	 * @return array
	 */
	public function getOperationParameter()
	{
		return $this->parameters;
	}

	/**
	 * Returns a single operation parameter if set
	 *
	 * @param string $keyName
	 *
	 * @return mixed|null
	 */
	public function getSingleOperationParameter($keyName)
	{
		return isset($this->parameters[$keyName]) ? $this->parameters[$keyName] : null;
	}

	/**
	 * Magic setter and getter functions
	 *
	 * @param string $method    Methodname
	 * @param string $parameter Parameters
	 *
	 * @return \CarghPAAPI\Operations\AbstractOperation
	 */
	public function __call($method, $parameter)
	{
		if (substr($method, 0, 3) === 'set')
		{
			$this->parameters[substr($method, 3)] = array_shift($parameter);
			return $this;
		}

		if (substr($method, 0, 3) === 'get')
		{
			$key = substr($method, 3);
			return $this->getSingleOperationParameter($key);
		}

		throw new \BadFunctionCallException(sprintf('The function "%s" does not exist!', $method));
	}
}
