<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

/**
 * A similarity lookup operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/SimilarityLookup.html
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class SimilarityLookup extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'SimilarityLookup';
    }

    /**
     * Returns the itemid which has to be looked up
     *
     * @return string
     */
    public function getItemId()
    {
        return $this->getSingleOperationParameter('ItemId');
    }

    /**
     * Sets the itemid which has to be looked up
     * Basicly it is an amazon asin
     *
     * @param string $itemId
     *
     * @return \CarghPAAPI\Operations\SimilarityLookup
     */
    public function setItemId($itemId)
    {
        $this->parameters['ItemId'] = $itemId;
        return $this;
    }
}
