<?php

namespace Consulta\Laravel\Test;

use Consulta\Laravel\Consulta;


/**
 * Class IdentifyTest
 * @package Consulta\Laravel\Test
 */
class IdentifyTest extends TestCase
{
    /**
     * @test
     * @return void
     * @throws \Consulta\Laravel\Exceptions\InvalidDniException
     * @throws \Consulta\Laravel\Exceptions\ServerErrorException
     * @throws \Consulta\Laravel\Exceptions\UnauthenticatedException
     * @throws \Consulta\Laravel\Exceptions\UndefinedErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function consult_person_dni()
    {
        $dni = '43989177';
        $response = Consulta::reniec()->find($dni);
        $this->assertTrue($response['dni'] == $dni);
    }

    /**
     * @test
     * @throws \Consulta\Laravel\Exceptions\InvalidDniException
     * @throws \Consulta\Laravel\Exceptions\ServerErrorException
     * @throws \Consulta\Laravel\Exceptions\UnauthenticatedException
     * @throws \Consulta\Laravel\Exceptions\UndefinedErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function consult_company_by_dni()
    {
        $dni = '46126030';
        $companyByDni = Consulta::sunat()->byDni($dni);
        $this->assertTrue($companyByDni['ruc'] == '10461260301');
    }

    /**
     * @test
     * @throws \Consulta\Laravel\Exceptions\InvalidRucException
     * @throws \Consulta\Laravel\Exceptions\ServerErrorException
     * @throws \Consulta\Laravel\Exceptions\UnauthenticatedException
     * @throws \Consulta\Laravel\Exceptions\UndefinedErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function consult_company_by_ruc()
    {
        $ruc = '20601772541';
        $company = Consulta::sunat()->byRuc($ruc);
        $this->assertTrue($company['ruc'] == $ruc);
    }
}
