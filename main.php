<?php declare(strict_types=1);

require_once "vendor/autoload.php";
use Src\Generator;
use GuzzleHttp\Client;

$allData = new Generator();
$client = new Client();
$url = 'https://data.gov.lv/dati/lv/api/3/action/datastore_search?resource_id=25e80bf3-f107-4ab4-89ef-251b5b9374e9';
$response = $client->request('GET', $url);

$getUrlData = $response->getBody();
$urlInfo = json_decode($getUrlData->getContents(), true);
$companyInfo = $urlInfo["result"]["records"];

$allData->generator($companyInfo);

while (true) {
    foreach ($allData->generator($companyInfo) as $company) {
        echo "--------{$company["name"]}--------" . PHP_EOL;
        echo "Registration number: {$company["regcode"]}" . PHP_EOL;
        echo "Registration date: " . substr($company["registered"], 0, 10) . PHP_EOL;
        echo "Registration type: {$company["regtype_text"]}" . PHP_EOL;
        echo "Address: {$company["address"]}, LV-{$company["index"]}" . PHP_EOL;
        echo "Sepa: {$company["sepa"]}" . PHP_EOL;
        echo PHP_EOL;
    }

    $quitOrContinue = readline("Continue/Quit (c/q): ");

    if ($quitOrContinue == "q") {
        echo "Bye!" . PHP_EOL;
        echo "============================" . PHP_EOL;
        return false;
    }
}