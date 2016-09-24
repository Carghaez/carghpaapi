<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Request;

use CarghPAAPI\Configuration\ConfigurationInterface;
use CarghPAAPI\Operations\OperationInterface;

interface RequestInterface
{
    /**
     * Performs the request
     *
     * @param OperationInterface     $operation
     * @param ConfigurationInterface $configuration
     *
     * @return mixed The response of the request
     */
    public function perform(OperationInterface $operation, ConfigurationInterface $configuration);
}
