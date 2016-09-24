<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

class Batch implements OperationInterface
{
	/**
	 * @var OperationInterface[]
	 */
	private $operations = [];

	/**
	 * @var string
	 */
	private $operationName;

	/**
	 * Batch constructor.
	 *
	 * @param OperationInterface[]
	 */
	public function __construct(array $operations = [])
	{
		foreach ($operations as $operation)
			$this->addOperation($operation);
	}

	/**
	 * Adds a single operation.
	 * Note that only operations with the same operation name can be added.
	 * First operation which is added will be the reference and the instance will let you only add
	 * other operations with the same operation name.
	 *
	 * @param OperationInterface $operation
	 *
	 * @return void
	 */
	public function addOperation(OperationInterface $operation)
	{
		if (null === $this->operationName)
			$this->operationName = $operation->getName();

		if ($this->operationName !== $operation->getName())
			return;

		$this->operations[] = $operation;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return $this->operationName;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOperationParameter()
	{
		$parameter = [];
		$index = 1;
		foreach ($this->operations as $operation)
		{
			foreach ($operation->getOperationParameter() as $key => $value)
			{
				$keyName = sprintf('%s.%s.%s', $this->operationName, $index, $key);
				$parameter[$keyName] = $value;
			}
			$index++;
		}
		return $parameter;
	}
}
