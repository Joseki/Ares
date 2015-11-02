<?php

namespace JosekiTests\Ares;

use Joseki\Ares\Ares;
use Joseki\Ares\AresRecord;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class AresTest extends \Tester\TestCase
{

    public function testPamis()
    {
        $ares = new Ares();
        $record = $ares->getByCompanyId('26266261');
        Assert::true($record instanceof AresRecord);

        Assert::equal('26266261', $record->getCompanyId());
        Assert::equal('PAMIS CZ s.r.o.', $record->getCompanyName());
        Assert::equal('CZ26266261', $record->getTaxId());
        Assert::equal('Břeclav', $record->getTown());
        Assert::equal('Poštorná', $record->getTownPart());
        Assert::equal('třída 1. máje', $record->getStreet());
        Assert::equal('1369', $record->getStreetHouseNumber());
        Assert::equal('9a', $record->getStreetOrientationNumber());
        Assert::equal('69141', $record->getZip());
        Assert::equal('Společnost s ručením omezeným', $record->getLegalForm());

        Assert::equal('Břeclav, Poštorná, třída 1. máje 1369/9a', $record->getAddress());
    }

}

\run(new AresTest());
