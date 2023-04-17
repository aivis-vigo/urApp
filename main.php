<?php declare(strict_types=1);

require_once "vendor/autoload.php";
use GuzzleHttp\Client;

$client = new Client();
$url = 'https://data.gov.lv/dati/lv/api/3/action/datastore_search?resource_id=25e80bf3-f107-4ab4-89ef-251b5b9374e9';
$response = $client->request('GET', $url);

$getUrlData = $response->getBody();
$urlInfo = json_decode($getUrlData->getContents(), true);
$companyInfo = $urlInfo["result"]["records"];

function generator(array $companyInfo)
{
    echo "========Company Info========" . PHP_EOL;
    echo "Menu: " . PHP_EOL;
    echo " - Search by Reg. number (1)" . PHP_EOL;
    echo " - Search by name (2)" . PHP_EOL;
    echo " - Exit (3)" . PHP_EOL;
    echo "============================" . PHP_EOL;

    $menuChoice = readline("Select: ");
    if ($menuChoice == 1) {
        $menuChoice = readline("Enter reg. number: ");
    } elseif ($menuChoice == 2) {
        $menuChoice = readline("Enter company name: ");
    } elseif ($menuChoice == 3) {
        echo "Bye!" . PHP_EOL;
        echo "============================" . PHP_EOL;
        exit();
    } else {
        echo "Invalid input!" . PHP_EOL;
        return false;
    }
    echo "============================" . PHP_EOL;

    foreach ($companyInfo as $company)
        if (in_array($menuChoice, $company))
            yield $company;

    if (!in_array($menuChoice, $companyInfo))
        echo "Not found!" . PHP_EOL;

    return false;
}

while (true) {
    foreach (generator($companyInfo) as $company) {
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