<?php

namespace Joseki\Ares\Records;

class BanAccountRecord
{
    const TYPE_STANDARD = 'standardniUcet';
    const TYPE_NONSTANDARD = 'nestandardniUcet';

    private $prefix;

    private $account;

    private $bankCode;

    private $type;



    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }



    /**
     * @param mixed $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }



    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }



    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }



    /**
     * @return mixed
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }



    /**
     * @param mixed $bankCode
     */
    public function setBankCode($bankCode)
    {
        $this->bankCode = $bankCode;
    }



    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }



    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}
