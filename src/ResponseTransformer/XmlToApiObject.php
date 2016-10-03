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
            $R->results = null;
            $R->code = $obj->Error->Code;
            $R->message = $obj->Error->Message;
            return $R;
        }

        if (isset($obj->Items->Request->Errors)) {
            $R->error = true;
            $R->results = null;
            $R->code = $obj->Items->Request->Errors->Error->Code;
            $R->message = $obj->Items->Request->Errors->Error->Message;
            return $R;
        }
        $R->error = false;
        $R->code = null;
        $R->message = null;

        $R->results = (object)[];
        $R->results->total = (isset($obj->Items->TotalResults))
            ? $obj->Items->TotalResults
            : '1';
        $R->results->per_page = '10';

        if (isset($obj->Items->Request->ItemSearchRequest)
            && isset($obj->Items->Request->ItemSearchRequest->ItemPage)) {
            $R->results->current_page = $obj->Items->Request->ItemSearchRequest->ItemPage;
        } else {
            $R->results->current_page = '1';
        }

        if (isset($obj->Items->TotalPages)) {
            $R->results->last_page = $obj->Items->TotalPages;
        } else {
            $R->results->last_page = '1';
        }

        $R->results->data = [];
        if (is_array($obj->Items->Item)) {
            foreach ($obj->Items->Item as $item) {
                array_push($R->results->data, $item);
            }
        } else {
            array_push($R->results->data,  $obj->Items->Item);
        }

        return $R;
    }
}
