<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\ResponseTransformer;

/**
 * A responsetransformer transforming a xml to a simpleXML Object.
 *
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class XmlToSimpleXmlObject implements ResponseTransformerInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function transform($response)
	{
		$simpleXML = simplexml_load_string($response);
		return $simpleXML;
	}
}
