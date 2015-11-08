<?php

namespace JosekiTests\Ares;

use Joseki\Ares\Parsers\BasicParser;
use Joseki\Ares\Records\AresRecord;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class BasicParserTest extends \Tester\TestCase
{

    public function testAsseco()
    {
        $xml = file_get_contents(__DIR__ . '/files/darv_bas.example1.xml');
        $record = BasicParser::parse($xml);
        Assert::true($record instanceof AresRecord);

        Assert::equal('27074358', $record->getCompanyId());
        Assert::equal('Asseco Central Europe, a.s.', $record->getCompanyName());
        Assert::equal('CZ27074358', $record->getTaxId());
        Assert::equal('Praha 4', $record->getTown());
        Assert::equal('Michle', $record->getTownPart());
        Assert::equal('Budějovická', $record->getStreet());
        Assert::equal('778', $record->getStreetHouseNumber());
        Assert::equal('3a', $record->getStreetOrientationNumber());
        Assert::equal('14000', $record->getZip());
        Assert::equal('121', $record->getLegalForm());

        Assert::equal('Praha 4, Michle, Budějovická 778/3a', $record->getAddress());
    }



    public function testPamis()
    {
        $xml = file_get_contents(__DIR__ . '/files/darv_bas.example2.xml');
        $record = BasicParser::parse($xml);
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
        Assert::equal('112', $record->getLegalForm());

        Assert::equal('Břeclav, Poštorná, třída 1. máje 1369/9a', $record->getAddress());
    }

}

\run(new BasicParserTest());
