<?php

namespace JosekiTests\Ares;

use Joseki\Ares\Ares;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class AresReliabilityTest extends \Tester\TestCase
{



    public function testReliabilityRequest()
    {
        $ares = new Ares();
        Assert::true($ares->isCompanyReliabilityByTaxId('26266261'));
        Assert::true($ares->isCompanyReliabilityByTaxId('CZ26266261'));
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
