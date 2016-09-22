<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

/**
 * A cart add operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/CartAdd.html
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class CartClear extends AbstractOperation
{
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'CartClear';
	}

	/**
	 * Returns the cart id
	 *
	 * @return string
	 */
	public function getCartId()
	{
		return $this->getSingleOperationParameter('CartId');
	}

	/**
	 * Sets the cart id
	 *
	 * @param string $cartId
	 */
	public function setCartId($cartId)
	{
		$this->parameters['CartId'] = $cartId;
	}

	/**
	 * Returns the HMAC
	 *
	 * @return mixed
	 */
	public function getHMAC()
	{
		return $this->getSingleOperationParameter('HMAC');
	}

	/**
	 * Sets the HMAC
	 *
	 * @param string $HMAC
	 */
	public function setHMAC($HMAC)
	{
		$this->parameters['HMAC'] = $HMAC;
	}
}
