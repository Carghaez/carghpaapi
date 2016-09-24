<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Configuration;

use CarghPAAPI\Request\RequestInterface;
use CarghPAAPI\ResponseTransformer\ResponseTransformerInterface;

interface ConfigurationInterface
{
    /**
     * Gets the country
     *
     * @return string
     */
    public function getCountry();

    /**
     * Gets the accesskey
     *
     * @return string
     */
    public function getAccessKey();

    /**
     * Gets the secretkey
     *
     * @return string
     */
    public function getSecretKey();

    /**
     * Gets the associatetag
     *
     * @return string
     */
    public function getAssociateTag();

    /**
     * Gets the requestclass
     *
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * Gets the responsetransformerclass
     *
     * @return ResponseTransformerInterface
     */
    public function getResponseTransformer();
}
