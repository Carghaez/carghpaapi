<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI;

use CarghPAAPI\Configuration\ConfigurationInterface;
use CarghPAAPI\Operations\OperationInterface;

/**
 * CarghPAAPI Core
 * Bundles all components
 *
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 *
 * Useful links
 * http://www.amazon.com
 * http://docs.aws.amazon.com/AWSECommerceService/latest/GSG/Welcome.html
 * http://docs.aws.amazon.com/AWSECommerceService/latest/DG/Welcome.html
 * http://webservices.amazon.it/scratchpad/index.html
 *
 * This class is realized by the Product Advertising API (former ECS) from Amazon WS Front.
 * https://programma-affiliazione.amazon.it/
 */
class CarghPAAPI
{
    const VERSION = "1.0.0-DEV";

    /**
     * Configuration.
     *
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Runs the given operation.
     *
     * @param OperationInterface $operation The operationobject
     *
     * @return mixed
     */
    public function runOperation(OperationInterface $operation)
    {
        $request  = $this->configuration->getRequest();
        $response = $request->perform($operation, $this->configuration);
        return $this->applyResponseTransformer($response);
    }

    /**
     * Applies a responsetransformer.
     *
     * @param mixed $response The response of the request
     *
     * @return mixed
     */
    protected function applyResponseTransformer($response)
    {
        if (null === $responseTransformer = $this->configuration->getResponseTransformer())
            return $response;

        return $responseTransformer->transform($response);
    }
}