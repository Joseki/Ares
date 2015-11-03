<?php

namespace JosekiTests\Ares;

use Joseki\Ares\Parsers\TaxReliabilityParser;
use Nette\Neon\Neon;
use Nette\Utils\ArrayHash;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class TaxReliabilityParserTest extends \Tester\TestCase
{

    public function testReliability()
    {
        $data = Neon::decode(file_get_contents(__DIR__ . '/files/tax1.neon'));
        $response = ArrayHash::from($data);
        Assert::true(TaxReliabilityParser::isReliable($response));

        $data = Neon::decode(file_get_contents(__DIR__ . '/files/tax5.neon'));
        $response = ArrayHash::from($data);
        Assert::false(TaxReliabilityParser::isReliable($response));
    }



    public function testBankAccounts()
    {
        $data = Neon::decode(file_get_contents(__DIR__ . '/files/tax2.neon'));
        $response = ArrayHash::from($data);

        $bankAccounts = TaxReliabilityParser::parseBankAccountDetails($response);
        Assert::equal(6, count($bankAccounts));
    }



    public function testUnreliableCompanies()
    {
        $data = Neon::decode(file_get_contents(__DIR__ . '/files/tax4.neon'));
        $response = ArrayHash::from($data);

        $companies = TaxReliabilityParser::parseUnreliableCompanies($response);
        Assert::equal(2428, count($companies));
    }



    public function testNotFound()
    {
        Assert::exception(
            function () {
                $data = Neon::decode(file_get_contents(__DIR__ . '/files/tax3.neon'));
                $response = ArrayHash::from($data);
                TaxReliabilityParser::isReliable($response);
            },
            'Joseki\Ares\NotFoundException'
        );

        Assert::exception(
            function () {
                $data = Neon::decode(file_get_contents(__DIR__ . '/files/tax3.neon'));
                $response = ArrayHash::from($data);
                TaxReliabilityParser::parseBankAccountDetails($response);
            },
            'Joseki\Ares\NotFoundException'
        );
    }

}

\run(new TaxReliabilityParserTest());
