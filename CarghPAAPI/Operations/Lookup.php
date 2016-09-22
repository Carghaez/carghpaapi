<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

/**
 * A item lookup operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/ItemLookup.html
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
  */
class Lookup extends AbstractOperation
{
	const TYPE_ASIN = 'ASIN';
	const TYPE_SKU = 'SKU';
	const TYPE_UPC = 'UPC';
	const TYPE_EAN = 'EAN';
	const TYPE_ISBN = 'ISBN';

	/**
	 * Initialize instance
	 */
	public function __construct()
	{
		// Defaults parameter
		$this
			->setIdType('ASIN')
			->setResponseGroup(['Large, VariationMatrix'])
			->setVariationPage('All');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'ItemLookup';
	}

	/**
	 * Pass up to 10 itemid's which should be looked up
	 *
	 * @param array $itemIds
	 *
	 * @return Lookup
	 *
	 * @throws \Exception
	 */
	public function setItemIds(array $itemIds)
	{
		if (count($itemIds) > 10)
			throw new \Exception('setItemIds accepts not more then 10 itemid\'s at once');

		$asinString = implode(',', $itemIds);
		$this->setItemId($asinString);
		return $this;
	}

	/**
	 * Returns the itemid
	 *
	 * @return string
	 */
	public function getItemId()
	{
		return $this->getSingleOperationParameter('ItemId');
	}

	/**
	 * Sets the itemid which should be looked up
	 *
	 * @param string $itemId
	 *
	 * @return \CarghPAAPI\Operations\Lookup
	 */
	public function setItemId($itemId)
	{
		$this->parameters['ItemId'] = $itemId;
		return $this;
	}

	/**
	 * Returns the idtype either ASIN (Default), SKU, UPC, EAN, and ISBN
	 *
	 * @return string
	 */
	public function getIdType()
	{
		return $this->getSingleOperationParameter('IdType');
	}

	/**
	 * Sets the idtype either ASIN (Default), SKU, UPC, EAN, and ISBN
	 *
	 * @param string $idType
	 *
	 * @return \CarghPAAPI\Operations\Lookup
	 */
	public function setIdType($idType)
	{
		$idTypes = [
			self::TYPE_ASIN,
			self::TYPE_SKU,
			self::TYPE_UPC,
			self::TYPE_EAN,
			self::TYPE_ISBN
		];

		if (!in_array($idType, $idTypes))
		{
			throw new \InvalidArgumentException(sprintf(
				"Invalid type '%s' passed. Valid types are: '%s'",
				$idType,
				implode(', ', $idTypes)
			));
		}

		$this->parameters['IdType'] = $idType;

		if (empty($this->parameters['SearchIndex']) && $idType != self::TYPE_ASIN)
			$this->parameters['SearchIndex'] = 'All';

		return $this;
	}

	/**
	 * Returns the searchindex
	 *
	 * @return mixed
	 */
	public function getSearchIndex()
	{
		return $this->getSingleOperationParameter('SearchIndex');
	}

	/**
	 * Sets the searchindex which should be used when set IdType other than ASIN
	 *
	 * @param string $searchIndex
	 *
	 * @return \CarghPAAPI\Operations\Lookup
	 */
	public function setSearchIndex($searchIndex)
	{
		$this->parameters['SearchIndex'] = $searchIndex;
		return $this;
	}

	/**
	 * Returns the condition of the items to return. New | Used | Collectible | Refurbished | All
	 *
	 * @return string
	 */
	public function getCondition()
	{
		return $this->getSingleOperationParameter('Condition');
	}

	/**
	 * Sets the condition of the items to return: New | Used | Collectible | Refurbished | All
	 *
	 * Defaults to New.
	 *
	 * @param string $condition
	 *
	 * @return \CarghPAAPI\Operations\Search
	 */
	public function setCondition($condition)
	{
		$this->parameters['Condition'] = $condition;
		return $this;
	}
}
