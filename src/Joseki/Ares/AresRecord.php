<?php

namespace Joseki\Ares;

class AresRecord
{
    /** @var string */
    private $companyId;

    /** @var string */
    private $taxId;

    /** @var string */
    private $companyName;

    /** @var string */
    private $street;

    /** @var string */
    private $streetHouseNumber;

    /** @var string */
    private $streetOrientationNumber;

    /** @var string */
    private $town;

    /** @var string */
    private $townPart;

    /** @var string */
    private $zip;

    /** @var string */
    private $legalForm;

    /** @var bool|null */
    private $reliable = null;

    private $bankAccounts = [];



    public function getAddress()
    {
        return $this->town . ', '
        . ($this->townPart ? $this->townPart . ', ' : '')
        . ($this->street ? $this->street . ' ' : '')
        . ($this->streetHouseNumber ? $this->streetHouseNumber : '')
        . ($this->streetOrientationNumber ? '/'.$this->streetOrientationNumber : '')
            ;
    }



    /**
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }



    /**
     * @param string $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }



    /**
     * @return string
     */
    public function getTaxId()
    {
        return $this->taxId;
    }



    /**
     * @param string $taxId
     */
    public function setTaxId($taxId)
    {
        $this->taxId = $taxId;
    }



    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }



    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }



    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }



    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }



    /**
     * @return string
     */
    public function getStreetHouseNumber()
    {
        return $this->streetHouseNumber;
    }



    /**
     * @param string $streetHouseNumber
     */
    public function setStreetHouseNumber($streetHouseNumber)
    {
        $this->streetHouseNumber = $streetHouseNumber;
    }



    /**
     * @return string
     */
    public function getStreetOrientationNumber()
    {
        return $this->streetOrientationNumber;
    }



    /**
     * @param string $streetOrientationNumber
     */
    public function setStreetOrientationNumber($streetOrientationNumber)
    {
        $this->streetOrientationNumber = $streetOrientationNumber;
    }



    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }



    /**
     * @param string $town
     */
    public function setTown($town)
    {
        $this->town = $town;
    }



    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }



    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }



    /**
     * @return string
     */
    public function getTownPart()
    {
        return $this->townPart;
    }



    /**
     * @param string $townPart
     */
    public function setTownPart($townPart)
    {
        $this->townPart = $townPart;
    }



    /**
     * @return string
     */
    public function getLegalForm()
    {
        return $this->legalForm;
    }



    /**
     * @param string $legalForm
     */
    public function setLegalForm($legalForm)
    {
        $this->legalForm = $legalForm;
    }



    /**
     * @return bool
     * @throws InvalidStateException
     */
    public function isReliable()
    {
        if ($this->reliable === null) {
            throw new InvalidStateException('Reliability not set');
        }
        return $this->reliable;
    }



    /**
     * @param bool $reliable
     */
    public function setReliability($reliable)
    {
        $this->reliable = $reliable;
    }



    public function addBankAccount($bankAccount, $bankCode = null)
    {
        $this->bankAccounts[] = trim(sprintf('%s/%s', $bankAccount, $bankCode), '/');
    }



    public function getBankAccounts()
    {
        return $this->bankAccounts;
    }

}
