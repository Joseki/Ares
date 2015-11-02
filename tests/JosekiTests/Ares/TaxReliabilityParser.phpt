<?php

namespace JosekiTests\Ares;

use Joseki\Ares\AresRecord;
use Joseki\Ares\Parsers\BasicParser;
use Joseki\Ares\Parsers\TaxReliabilityParser;
use Nette\Neon\Neon;
use Nette\Utils\ArrayHash;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class TaxReliabilityParserTest extends \Tester\TestCase
{

    public function testSimpleData()
    {
        $data = Neon::decode(file_get_contents(__DIR__ . '/files/tax1.neon'));
        $response = ArrayHash::from($data);

        $record = TaxReliabilityParser::parse($response);
        Assert::true($record instanceof AresRecord);

        Assert::true($record->isReliable());
    }



    public function testBankAccounts()
    {
        $data = Neon::decode(file_get_contents(__DIR__ . '/files/tax2.neon'));
        $response = ArrayHash::from($data);

        $record = TaxReliabilityParser::parse($response);
        Assert::true($record instanceof AresRecord);

        Assert::true($record->isReliable());
        Assert::equal(5, count($record->getBankAccounts()));
    }



    public function testNotFound()
    {
        Assert::exception(
            function () {
                $data = Neon::decode(file_get_contents(__DIR__ . '/files/tax3.neon'));
                $response = ArrayHash::from($data);
                TaxReliabilityParser::parse($response);
            },
            'Joseki\Ares\NotFoundException'
        );
    }

}

\run(new TaxReliabilityParserTest());
