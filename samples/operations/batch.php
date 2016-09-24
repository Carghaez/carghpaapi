<?php
require_once dirname(__FILE__).'/../bootstrap/CarghPAAPI.php';

use CarghPAAPI\Operations;

$search1 = new Operations\Search();
$search1
    ->setCategory('DVD')
    ->setActor('Bruce Willis');

$search2 = new Operations\Search();
$search2
    ->setCategory('DVD')
    ->setActor('Arnold Schwarzenegger')
    ->setKeywords('Terminator');

$batch = new Operations\Batch();
$batch->addOperation($search1);
$batch->addOperation($search2);

$xmlResponse = $CarghPAAPI->runOperation($batch);

echo $xmlResponse->saveXML();
