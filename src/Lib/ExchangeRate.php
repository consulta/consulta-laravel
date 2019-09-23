<?php

namespace Consulta\Laravel\Lib;

/**
 * Class ExchangeRate
 * @package Consulta\Laravel\Lib
 */
class ExchangeRate
{

    /**
     * get
     * @param string $toCurrency
     * @throws \Exception
     */
    public function today($toCurrency = 'USD')
    {
        //TODO: get only today exchange
        throw new \Exception('Not implemented');

    }
}
