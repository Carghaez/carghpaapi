<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\ResponseTransformer;

interface ResponseTransformerInterface
{
    /**
     * Transforms the response of the request
     *
     * @param mixed $response
     */
    public function transform($response);
}
