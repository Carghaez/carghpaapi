<?php
require_once dirname(__FILE__).'/../bootstrap/CarghPAAPI.php';

use CarghPAAPI\Operations;

$lookup = new Operations\Lookup();
if(!isset($_GET['asin']))
    $lookup->setItemId('B01E9WLATY');
else
    $lookup->setItemId($_GET['asin']);

$xmlResponse = $CarghPAAPI->runOperation($lookup);

echo $xmlResponse->saveXML();
