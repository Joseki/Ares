<?php

namespace Joseki\Ares\Parsers;

use Joseki\Ares\NotFoundException;
use Joseki\Ares\Records\AresRecord;
use Joseki\Ares\ServerDoesNotResponseException;

class BasicParser
{

    public static function parse($xml)
    {
        $aresResponse = simplexml_load_string($xml);

        if (!$aresResponse) {
            throw new ServerDoesNotResponseException('Ares did not send any response');
        }

        $ns = $aresResponse->getDocNamespaces();
        $data = $aresResponse->children($ns['are'])->children($ns['D']);

        if (isset($data->E)) {
            throw new NotFoundException(strval($data->E->ET));
        }
        
        $elements = $data->VBAS;

        $record = new AresRecord();
        $record->setCompanyId(strval($elements->ICO));
        $record->setTaxId(strval($elements->DIC));
        $record->setCompanyName(strval($elements->OF));
        $record->setLegalForm(strval($elements->PF->KPF));

        $record->setStreet(strval($elements->AA->NU));
        $record->setStreetHouseNumber(strval($elements->AA->CD));
        if (strval($elements->AA->CO)) {
            $record->setStreetOrientationNumber(strval($elements->AA->CO));
        }
        if ($elements->AA->NMC) {
            $record->setTown(strval($elements->AA->NMC));
        } else {
            $record->setTown(strval($elements->AA->N));
        }

        if (strval($elements->AA->NCO)) {
            $record->setTownPart(strval($elements->AA->NCO));
        }
        $record->setZip(strval($elements->AA->PSC));

        return $record;
    }
}
