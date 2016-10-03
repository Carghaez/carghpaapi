<?php
require_once dirname(__FILE__).'/../bootstrap/CarghPAAPI.php';

use CarghPAAPI\Operations;

$category = isset($_GET['cat']) ? $_GET['cat'] : 'Electronics';
$keywords = isset($_GET['q']) ? $_GET['q'] : 'htc';
$search = new Operations\Search($category);
$search
    ->setKeywords($keywords)
    ->setCondition('New')
    ->setAvailability('Available')
    ->setMinimumPrice('500')
    ->setMerchantId('Amazon')
    ->setSort('relevancerank'); // Amazon default Sort

$xmlResponse = $CarghPAAPI->runOperation($search);

echo $xmlResponse->saveXML();
