<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

/**
 * A cart create operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/CartCreate.html
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class CartCreate extends AbstractOperation
{
    private $itemCounter = 1;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'CartCreate';
    }

    /**
     * Adds an item to the Cart
     *
     * @param string  $id       The ASIN or OfferListingId Number of the item
     * @param integer $quantity How much you want to add
     * @param bool    $byAsin   If False will use OfferListingId insted of ASIN
     */
    public function addItem($id, $quantity, $byAsin = true)
    {
        $itemIdentifier = ($byAsin) ? '.ASIN' : '.OfferListingId';

        $this->parameters['Item.' . $this->itemCounter . $itemIdentifier] = $id;
        $this->parameters['Item.' . $this->itemCounter . '.Quantity'] = $quantity;

        $this->itemCounter++;
    }
}
