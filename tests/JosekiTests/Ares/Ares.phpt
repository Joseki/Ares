<?php

namespace JosekiTests\Ares;

use Joseki\Ares\Ares;
use Joseki\Ares\Records\AresRecord;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class AresTest extends \Tester\TestCase
{

    public function testAresRequest()
    {
        $ares = new Ares();
        $record = $ares->getCompanyInfoById('26266261');
        Assert::true($record instanceof AresRecord);

        Assert::equal('26266261', $record->getCompanyId());
        Assert::equal('PAMIS CZ s.r.o.', $record->getCompanyName());
        Assert::equal('', $record->getTaxId());
        Assert::equal('Břeclav', $record->getTown());
        Assert::equal('Poštorná', $record->getTownPart());
        Assert::equal('třída 1. máje', $record->getStreet());
        Assert::equal('1369', $record->getStreetHouseNumber());
        Assert::equal('9a', $record->getStreetOrientationNumber());
        Assert::equal('69141', $record->getZip());
        Assert::equal('112', $record->getLegalForm());

        Assert::equal('Břeclav, Poštorná, třída 1. máje 1369/9a', $record->getAddress());
    }



    public function testInvalid()
    {
        Assert::exception(
            function () {
                $ares = new Ares();
                $ares->getCompanyInfoById('99999999');
            },
            'Joseki\Ares\NotFoundException'
        );
    }
}

\run(new AresTest());
