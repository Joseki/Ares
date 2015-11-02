<?php

namespace Joseki\Ares\Parsers;

use Joseki\Ares\AresRecord;
use Joseki\Ares\NotFoundException;

class TaxReliabilityParser
{
    public static function parse($response, AresRecord $record = null)
    {
        if (!$record) {
            $record = new AresRecord();
        }

        if ($response->statusPlatceDPH->nespolehlivyPlatce === 'NENALEZEN') {
            throw new NotFoundException();
        }

        $record->setReliability($response->statusPlatceDPH->nespolehlivyPlatce === 'NE');

        foreach ((array)$response->statusPlatceDPH->zverejneneUcty->ucet as $accountInfo) {
            if (isset($accountInfo->standardniUcet)) {
                if (isset($accountInfo->predcisli)) {
                    $account = $accountInfo->standardniUcet->predcisli . '-' . $accountInfo->standardniUcet->cislo;
                } else {
                    $account = $accountInfo->standardniUcet->cislo;
                }
                $bankCode = $accountInfo->standardniUcet->kodBanky;

                $record->addBankAccount($account, $bankCode);
            }
        }

        return $record;
    }
}
