<?php declare(strict_types=1);

namespace Src;

class Generator
{
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
    }
}