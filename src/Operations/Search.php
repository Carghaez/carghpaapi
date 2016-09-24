<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

/**
 * A item search operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/ItemSearch.html
 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/LocaleIT.html
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
  */
class Search extends AbstractOperation
{
    private static $categories = [
        'All'                   => ['ItemPage'],
        'Apparel'               => [
                                    'Author', 'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Grocery'               => [
                                    'Author', 'ItemPage', 'MaximumPrice', 'MinimumPrice',
                                    'MinPercentageOff', 'Publisher', 'Sort', 'Title'
                                ],
        'MobileApps'            => [
                                    'Author', 'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Automotive'            => [
                                    'Brand', 'ItemPage', 'Manufacturer',
                                    'MaximumPrice', 'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Beauty'                => [
                                    'Brand', 'ItemPage', 'Manufacturer',
                                    'MaximumPrice', 'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'GiftCards'             => [
                                    'Artist', 'MaximumPrice', 'MinimumPrice',
                                    'MinPercentageOff'
                                ],
        'Music'                 => [
                                    'Artist', 'ItemPage', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'OfficeProducts'        => [
                                    'Brand', 'ItemPage', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Kitchen'               => [
                                    'Author', 'Brand', 'ItemPage',
                                    'Manufacturer', 'MaximumPrice', 'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'HealthPersonalCare'    => [
                                    'Author', 'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Electronics'           => [
                                    'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Tools'                 => [
                            'Actor', 'Artist', 'AudienceRating', 'Author', 'Brand', 'Composer', 'Conductor',
                            'Director', 'ItemPage', 'Manufacturer', 'MaximumPrice', 'MinimumPrice', 'MinPercentageOff',
                            'Neighborhood', 'Orchestra', 'Power', 'Publisher', 'ReleaseDate', 'Sort', 'Title'
                        ],
        'DVD'                   => [
                                    'Actor', 'AudienceRating', 'Director', 'ItemPage', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Publisher', 'Sort', 'Title'
                                ],
        'Garden'                => [
                                    'Author', 'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Neighborhood', 'Sort', 'Title'
                                ],
        'Toys'                  => [
                                    'Author', 'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Neighborhood', 'Sort', 'Title'
                                ],
        'Jewelry'               => [ 'ItemPage', 'MinPercentageOff', 'Sort', 'Title'],
        'Lighting'              => [
                                    'Brand', 'ItemPage', 'MaximumPrice', 'MinimumPrice',
                                    'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Industrial'            => [
                                    'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'PCHardware'            => [
                                    'Author', 'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'KindleStore'           => [
                                    'Author', 'ItemPage', 'MaximumPrice',  'MinimumPrice',
                                    'MinPercentageOff', 'Publisher', 'Sort', 'Title'
                                ],
        'Books'                 => [
                                    'Author', 'ItemPage', 'MaximumPrice', 'MinimumPrice',
                                    'MinPercentageOff', 'Power', 'Publisher', 'Sort', 'Title'
                                ],
        'ForeignBooks'          => [
                                    'Author', 'ItemPage', 'MaximumPrice',  'MinimumPrice',
                                    'MinPercentageOff', 'Power', 'Publisher', 'Sort', 'Title'
                                ],
        'MP3Downloads'          => [
                                    'ItemPage', 'MaximumPrice', 'MinimumPrice',
                                    'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Watches'               => ['ItemPage', 'MinPercentageOff', 'Sort', 'Title'],
        'Baby'                  => [
                                    'Author', 'Brand', 'ItemPage',  'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Shoes'                 => [
                                    'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Software'              => [
                                    'Author', 'Brand', 'ItemPage',  'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'SportingGoods'         => ['ItemPage', 'MinPercentageOff', 'Sort', 'Title'],
        'MusicalInstruments'    => [
                                    'Author', 'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'Luggage'               => [
                                    'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ],
        'VideoGames'            => [
                                    'Author', 'Brand', 'ItemPage', 'Manufacturer', 'MaximumPrice',
                                    'MinimumPrice', 'MinPercentageOff', 'Sort', 'Title'
                                ]
    ];

    private static $general_parameters = [
        'Availability',
        'BrowseNode',
        'Keywords',
        'ResponseGroup',
        'VariationPage'
    ];

    private static $cat_parameters = [
        'Actor',
        'Artist',
        'AudienceRating',
        'Author',
        'Brand',
        'Composer',
        'Conductor',
        'Director',
        'ItemPage',
        'Manufacturer',
        'MaximumPrice',
        'MerchantId',
        'MinimumPrice',
        'MinPercentageOff',
        'Neighborhood',
        'Orchestra',
        'Power',
        'Publisher',
        'ReleaseDate',
        'Sort',
        'Title'
    ];

    /**
     * Initialize instance
     */
    public function __construct($category = 'All')
    {
        // Defaults parameter
        $this
            ->setCategory($category)
            ->setResponseGroup(['Large']);
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
     * Return the amazon valid parameters
     *
     * @return string
     */
    public function getValidParameters()
    {
        return array_merge(Search::$general_parameters, Search::$categories[$this->getCategory()]);
    }

    /**
     * Validate the amazon category
     *
     * @param string $category
     *
     * @return bool
     */
    private function validateCategory($category)
    {
        if (in_array($category, array_keys(Search::$categories)))
            return true;

        throw new \InvalidArgumentException(sprintf(
            "Invalid category '%s' passed. Valid categories are: '%s'",
            $category,
            implode(', ', array_keys(Search::$categories))
        ));
        return false;
    }

    /**
     * Sets the amazon category
     *
     * @param string $category
     *
     * @return \CarghPAAPI\Operations\Search
     */
    private function setCategory($category)
    {
        $this->parameters['SearchIndex'] = ($this->validateCategory($category))? $category : 'All';
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

    /**
     * Validates the given parameter.
     *
     * @param integer $parameter
     */
    private function invalidParameter($parameter)
    {
        $exlude_parameters = [
            'SearchIndex',
            'Category'
        ];

        $exlude_parameters = array_merge(
            $exlude_parameters,
            array_diff(Search::$cat_parameters, Search::$categories[$this->getCategory()])
        );

        if(in_array($parameter, $exlude_parameters))
            return true;
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $parameter)
    {
        if (substr($method, 0, 3) === 'set')
        {
            if($this->invalidParameter(substr($method, 3)))
                throw new \BadFunctionCallException(sprintf(
                    'The parameter "%s" is invalid for "%s" category!',
                    substr($method, 3),
                    $this->getCategory()
            ));
        }
        return parent::__call($method, $parameter);
    }
}
