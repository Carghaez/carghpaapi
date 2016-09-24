<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\ResponseTransformer;

/**
 * A responsetransformer transforming a xml to a domdocument
 *
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class XmlToDomDocument implements ResponseTransformerInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function transform($response)
	{
		$document = new \DOMDocument('1.0', 'UTF-8');
		$document->loadXML($response);
		header("content-type: application/xml; charset=ISO-8859-15");
		return $document;
	}
}
