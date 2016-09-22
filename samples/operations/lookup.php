<?php
require_once dirname(__FILE__).'/../bootstrap/CarghPAAPI.php';

use CarghPAAPI\Operations;

$lookup = new Operations\Lookup();
$lookup->setItemId('B00RD3X6IU');

$xmlResponse = $CarghPAAPI->runOperation($lookup);

echo $xmlResponse->saveXML();
