<?php
require_once dirname(__FILE__).'/autoload.php';
require_once dirname(__FILE__).'/config.php';

use CarghPAAPI\CarghPAAPI;
use CarghPAAPI\Configuration\GenericConfiguration;
use CarghPAAPI\Request\CurlRequest;
use CarghPAAPI\ResponseTransformer\XmlToDomDocument;

$conf = new GenericConfiguration();
try
{
    $conf
        ->setCountry('it')
        ->setAccessKey(AWS_API_KEY)
        ->setSecretKey(AWS_API_SECRET_KEY)
        ->setAssociateTag(AWS_ASSOCIATE_TAG)
        ->setRequest(new CurlRequest())
        ->setResponseTransformer(new XmlToDomDocument());
}
catch (\Exception $e)
{
    echo $e->getMessage();
}
$CarghPAAPI = new CarghPAAPI($conf);
