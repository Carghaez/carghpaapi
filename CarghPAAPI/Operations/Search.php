<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

/**
 * A item search operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/ItemSearch.html
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
  */
class Search extends AbstractOperation
{
	/**
	 * Initialize instance
	 */
	public function __construct()
	{
		// Defaults parameter
		$this
			->setResponseGroup(['Large'])
			->setSort('relevancerank'); // Amazon default Sort
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'ItemSearch';
	}

	/**
	 * Return the amazon category
	 *
	 * @return string
	 */
	public function getCategory()
	{
		return $this->getSingleOperationParameter('SearchIndex');
	}

	/**
	 * Sets the amazon category
	 *
	 * @param string $category
	 *
	 * @return \CarghPAAPI\Operations\Search
	 */
	public function setCategory($category)
	{
		$this->parameters['SearchIndex'] = $category;
		return $this;
	}

	/**
	 * Returns the keywords
	 *
	 * @return string
	 */
	public function getKeywords()
	{
		return $this->getSingleOperationParameter('Keywords');
	}

	/**
	 * Sets the keywords
	 *
	 * @param string $keywords
	 *
	 * @return \CarghPAAPI\Operations\Search
	 */
	public function setKeywords($keywords)
	{
		$this->parameters['Keywords'] = $keywords;
		return $this;
	}

	/**
	 * Return the resultpage
	 *
	 * @return integer
	 */
	public function getPage()
	{
		return $this->getSingleOperationParameter('ItemPage');
	}

	/**
	 * Sets the resultpage to a specified value
	 * Allows to browse resultsets which have more than one page
	 *
	 * @param integer $page
	 *
	 * @return \CarghPAAPI\Operations\Search
	 */
	public function setPage($page)
	{
		if (false === is_numeric($page) || $page < 1 || $page > 10)
		{
			throw new \InvalidArgumentException(sprintf(
				'%s is an invalid page value. It has to be numeric, positive and between 1 and 10 (1 to 5 when search index is All)',
				$page
			));
		}
		$this->parameters['ItemPage'] = $page;
		return $this;
	}

	/**
	 * Return the minimum price as integer so 8.99$ will be returned as 899
	 *
	 * @return integer
	 */
	public function getMinimumPrice()
	{
		return $this->getSingleOperationParameter('MinimumPrice');
	}

	/**
	 * Sets the minimum price to a specified value for the search
	 * Currency will be given by the site you are querying: EUR for IT, USD for COM
	 * Price should be given as integer. 8.99$ USD becomes 899
	 *
	 * @param integer $price
	 *
	 * @return \CarghPAAPI\Operations\Search
	 */
	public function setMinimumPrice($price)
	{
		$this->validatePrice($price);
		$this->parameters['MinimumPrice'] = $price;
		return $this;
	}

	/**
	 * Returns the maximum price as integer so 8.99$ will be returned as 899
	 * @return mixed
	 */
	public function getMaximumPrice()
	{
		return $this->getSingleOperationParameter('MaximumPrice');
	}

	/**
	 * Sets the maximum price to a specified value for the search
	 * Currency will be given by the site you are querying: EUR for IT, USD for COM
	 * Price should be given as integer. 8.99€ EUR becomes 899
	 *
	 * @param integer $price
	 *
	 * @return \CarghPAAPI\Operations\Search
	 */
	public function setMaximumPrice($price)
	{
		$this->validatePrice($price);
		$this->parameters['MaximumPrice'] = $price;
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

	/**
	 * Returns the availability.
	 *
	 * @return string
	 */
	public function getAvailability()
	{
		return $this->getSingleOperationParameter('Availability');
	}

	/**
	 * Sets the availability. Don't use method if you want the default Amazon behaviour.
	 * Only valid value = Available
	 *
	 * @param string $availability
	 * @see http://docs.aws.amazon.com/AWSECommerceService/latest/DG/CHAP_ReturningPriceAndAvailabilityInformation-itemsearch.html
	 *
	 * @return \CarghPAAPI\Operations\Search
	 */
	public function setAvailability($availability)
	{
		$this->parameters['Availability'] = $availability;
		return $this;
	}

	/**
	 * Returns the browseNodeId
	 *
	 * @return integer
	 */
	public function getBrowseNode()
	{
		return $this->getSingleOperationParameter('BrowseNode');
	}

	/**
	 * Sets the browseNodeId
	 *
	 * @param integer $browseNodeId
	 *
	 * @return \CarghPAAPI\Operations\Search
	 */
	public function setBrowseNode($browseNodeId)
	{
		$this->parameters['BrowseNode'] = $browseNodeId;
		return $this;
	}

	/**
	 * Validates the given price.
	 *
	 * @param integer $price
	 */
	protected function validatePrice($price)
	{
		if (false === is_numeric($price) || $price < 1)
		{
			throw new \InvalidArgumentException(sprintf(
				'%s is an invalid price value. It has to be numeric and >= than 1',
				$price
			));
		}
	}
}
