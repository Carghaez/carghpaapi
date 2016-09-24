<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\ResponseTransformer;

/**
 * A responsetransformer transforming an xml via xslt
 *
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class Xslt implements ResponseTransformerInterface
{
	/**
	 * XSLTProcessor object
	 *
	 * @var \XSLTProcessor
	 */
	protected $xsl;

	/**
	 * Constructor
	 *
	 * @param string $xslt
	 */
	public function __construct($xslt)
	{
		$xsl = new \XSLTProcessor();
		$xsldoc = new \DOMDocument();
		$xsldoc->loadXML($xslt);
		$xsl->importStyleSheet($xsldoc);
		$this->xsl = $xsl;
	}

	/**
	 * {@inheritdoc}
	 */
	public function transform($response)
	{
		$document = new \DOMDocument('1.0', 'UTF-8');
		$document->loadXML($response);
		return $this->xsl->transformToXml($document);
	}
}
