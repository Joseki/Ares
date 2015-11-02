<?php

namespace Joseki\Ares;

use Joseki\Ares\Parsers\BasicParser;
use Joseki\Ares\Parsers\TaxReliabilityParser;
use SoapClient;

class Ares
{
    public function getByCompanyId($id)
    {
        $url = sprintf('http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=%s', $id);
        $record = BasicParser::parse(file_get_contents($url));

        if (class_exists('SoapClient')) {
            $client = @new SoapClient("http://adisrws.mfcr.cz/adistc/axis2/services/rozhraniCRPDPH.rozhraniCRPDPHSOAP");
            if ($client instanceof SoapClient) {
                $contact = new TaxReliabilityRequest ($id);
                $params = ["StatusNespolehlivyPlatceRequest" => $contact];
                $response = $client->__soapCall("getStatusNespolehlivyPlatce", $params);

                $record = TaxReliabilityParser::parse($response, $record);
            }
        }

        return $record;
    }
}
