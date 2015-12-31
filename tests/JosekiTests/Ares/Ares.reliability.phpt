<?php

namespace JosekiTests\Ares;

use Joseki\Ares\Ares;
use Joseki\Ares\Parsers\TaxReliabilityParser;
use Nette\DI\Config\Adapters\NeonAdapter;
use Nette\Utils\ArrayHash;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class AresReliabilityTest extends \Tester\TestCase
{

    public function testReliabilityParser()
    {
        $adapter = new NeonAdapter();

        $data = ArrayHash::from($adapter->load(__DIR__ . '/files/tax1.neon'));
        Assert::true(TaxReliabilityParser::isReliable($data));

        Assert::exception(
            function () use ($adapter) {
                $data = ArrayHash::from($adapter->load(__DIR__ . '/files/tax3.neon'));
                TaxReliabilityParser::isReliable($data);
            },
            'Joseki\Ares\NotFoundException'
        );
    }



    public function testReliabilityRequest()
    {
        $ares = new Ares();
        Assert::true($ares->isCompanyReliabilityByTaxId('27074358'));
        Assert::true($ares->isCompanyReliabilityByTaxId('CZ27074358'));
    }



    public function testBankAccountsRequest()
    {
        $ares = new Ares();
        $bankAccounts = $ares->getBankAccountDetailsByTaxId('49969242');
        Assert::equal(6, count($bankAccounts));
    }

}

if (@file_get_contents(Ares::PDPH_WSDL_URL) === false) {
    \Tester\Environment::skip('Test requires connection to MFCR PDPH wsdl');
}

\run(new AresReliabilityTest());
