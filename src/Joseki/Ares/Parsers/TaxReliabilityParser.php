<?php

namespace Joseki\Ares\Parsers;

use Joseki\Ares\NotFoundException;
use Joseki\Ares\Records\BankAccountRecord;

class TaxReliabilityParser
{
    public static function isReliable($response)
    {
        if ($response->statusPlatceDPH->nespolehlivyPlatce === 'NENALEZEN') {
            throw new NotFoundException();
        }

        return $response->statusPlatceDPH->nespolehlivyPlatce === 'NE';
    }



    public static function parseBankAccountDetails($response)
    {
        if ($response->statusPlatceDPH->nespolehlivyPlatce === 'NENALEZEN') {
            throw new NotFoundException();
        }

        $bankAccounts = [];
        foreach ((array)$response->statusPlatceDPH->zverejneneUcty->ucet as $accountInfo) {
            $bankAccounts[] = $banAccount = new BankAccountRecord();
            if (isset($accountInfo->standardniUcet)) {
                $banAccount->setType(BankAccountRecord::TYPE_STANDARD);
                if (isset($accountInfo->predcisli)) {
                    $banAccount->setPrefix($accountInfo->standardniUcet->predcisli);
                }
                $banAccount->setAccount($accountInfo->standardniUcet->cislo);
                $banAccount->setBankCode($accountInfo->standardniUcet->kodBanky);
            } else {
                $banAccount->setType(BankAccountRecord::TYPE_NONSTANDARD);
                $banAccount->setAccount($accountInfo->nestandardniUcet->cislo);
            }
        }

        return $bankAccounts;
    }



    public static function parseUnreliableCompanies($response)
    {
        $companies = [];
        foreach ((array)$response->statusPlatceDPH as $info) {
            $companies[$info->dic] = new \DateTime($info->datumZverejneniNespolehlivosti);
        }

        return $companies;
    }
}
