<?php

namespace Joseki\Ares;

use Joseki\Ares\Parsers\BasicParser;
use Joseki\Ares\Parsers\TaxReliabilityParser;
use SoapClient;

class Ares
{
    const PDPH_WSDL_URL = 'http://adisrws.mfcr.cz/adistc/axis2/services/rozhraniCRPDPH.rozhraniCRPDPHSOAP';



    public function getCompanyInfoById($id)
    {
        $url = sprintf('http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=%s', $id);
        $xml = file_get_contents($url);
        $record = BasicParser::parse($xml);

        return $record;
    }



    public function isCompanyReliabilityByTaxId($taxId)
    {
        if (substr(strtolower($taxId), 0, 2) === 'cz') {
            $taxId = substr($taxId, 2);
        }

        if (!class_exists('SoapClient')) {
            throw new InvalidStateException('Could not find class SoapClient, probably due missing SOAP PHP extension');
        }

        if (@file_get_contents(self::PDPH_WSDL_URL) === false) {
            throw new InvalidStateException('Could not connect (find) wsdl file. Check path to wsdl or possible ban from register site');
        }

        $client = new SoapClient(self::PDPH_WSDL_URL, ['exceptions' => true]);

        $contact = new \stdClass();
        $contact->dic = $taxId;
        $params = ["StatusNespolehlivyPlatceRequest" => $contact];
        $response = $client->__soapCall("getStatusNespolehlivyPlatce", $params);

        return TaxReliabilityParser::isReliable($response);
    }



    public function getBankAccountDetailsByTaxId($taxId)
    {
        if (substr(strtolower($taxId), 0, 2) === 'cz') {
            $taxId = substr($taxId, 2);
        }

        if (!class_exists('SoapClient')) {
            throw new InvalidStateException('Could not find class SoapClient, probably due missing SOAP PHP extension');
        }

        if (@file_get_contents(self::PDPH_WSDL_URL) === false) {
            throw new InvalidStateException('Could not connect (find) wsdl file. Check path to wsdl or possible ban from register site');
        }

        $client = new SoapClient(self::PDPH_WSDL_URL, ['exceptions' => true]);

        $contact = new \stdClass();
        $contact->dic = $taxId;
        $params = ["StatusNespolehlivyPlatceRequest" => $contact];
        $response = $client->__soapCall("getStatusNespolehlivyPlatce", $params);

        return TaxReliabilityParser::parseBankAccountDetails($response);
    }



    /**
     * @return array of taxIds
     */
    public function getUnreliableCompanies()
    {
        if (!class_exists('SoapClient')) {
            throw new InvalidStateException('Could not find class SoapClient, probably due missing SOAP PHP extension');
        }

        if (@file_get_contents(self::PDPH_WSDL_URL) === false) {
            throw new InvalidStateException('Could not connect (find) wsdl file. Check path to wsdl or possible ban from register site');
        }

        $client = new SoapClient(self::PDPH_WSDL_URL, ['exceptions' => true]);

        $response = $client->__soapCall("getStatusNespolehlivyPlatce", []);

        return TaxReliabilityParser::parseUnreliableCompanies($response);
    }

}
