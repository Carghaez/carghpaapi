<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

interface OperationInterface
{
	/**
	 * Gets the name of the operation
	 *
	 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/CHAP_OperationListAlphabetical.html
	 *
	 * @return string
	 */
	public function getName();
}
