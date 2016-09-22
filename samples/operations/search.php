<?php
require_once dirname(__FILE__).'/../bootstrap/CarghPAAPI.php';

use CarghPAAPI\Operations;

$search = new Operations\Search();
$search
	->setCategory('Electronics')
	->setKeywords('htc');

$xmlResponse = $CarghPAAPI->runOperation($search);

echo $xmlResponse->saveXML();
