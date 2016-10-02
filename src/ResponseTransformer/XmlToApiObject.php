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
class XmlToApiObject implements ResponseTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($response)
    {
        $json = (new XmlToJson())->transform($response);
        return $this->refactorize(json_decode($json));
    }

    private function refactorize($obj)
    {
        $R = (object)[];
        $R->status_code = '200';

        if (isset($obj->Error)) {
            $R->error = true;
            $R->results = (object)[];
            $R->results->code = $obj->Error->Code;
            $R->results->message = $obj->Error->Message;
            return $R;
        }

        if (isset($obj->Items->Request->Errors)) {
            $R->error = true;
            $R->results = (object)[];
            $R->results->code = $obj->Items->Request->Errors->Error->Code;
            $R->results->message = $obj->Items->Request->Errors->Error->Message;
            return $R;
        }
        $R->error = false;

        $R->results = (object)[];
        $R->results->items = [];
        foreach ($obj->Items->Item as $item) {
            array_push($R->results->items, $item);
        }
        return $R;
    }
}
