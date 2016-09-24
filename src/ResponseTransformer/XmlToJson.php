<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\ResponseTransformer;

/**
 * A responsetransformer transforming a xml to a json
 *
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class XmlToJson implements ResponseTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($response)
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        $document->loadXML($response);
        $this->json_prepare_xml($document);
        $sxml = simplexml_load_string($document->saveXML());
        $json = json_encode($sxml);
        return $json;
    }

    /**
     * A common pitfall is to forget that json_encode() does not respect elements with a textvalue and attribute(s).
     * It will choose one of those, meaning dataloss.
     * The function below solves that problem.
     * If one decides to go for the json_encode/decode way, the following function is advised.
     * @param  $domNode
     */
    private function json_prepare_xml($domNode)
    {
        foreach ($domNode->childNodes as $node)
        {
            if ($node->hasChildNodes())
            {
                $this->json_prepare_xml($node);
            }
            else
            {
                if ($domNode->hasAttributes() && strlen($domNode->nodeValue))
                {
                    $domNode->setAttribute("nodeValue", $node->textContent);
                    $node->nodeValue = "";
                }
            }
        }
    }

}
