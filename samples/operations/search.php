<?php
require_once dirname(__FILE__).'/../bootstrap/CarghPAAPI.php';

use CarghPAAPI\Operations;

$search = new Operations\Search('Electronics');
$search
    ->setKeywords('htc')
    ->setSort('relevancerank'); // Amazon default Sort

$xmlResponse = $CarghPAAPI->runOperation($search);

echo $xmlResponse->saveXML();
