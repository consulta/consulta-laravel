<?php namespace Consulta\Laravel\laravel\src;


use Illuminate\Support\Facades\Facade;

/**
 * Class ConsultaFacade
 * @package Consulta\Laravel\laravel\src
 */
class ConsultaFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'consulta';
    }
}
