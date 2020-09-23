<?php

namespace Consulta\Laravel\Lib;

use Consulta\Laravel\Consulta;
use Consulta\Laravel\Exceptions\InvalidPlateException;
use Illuminate\Support\Facades\Validator;

/**
 * Class Vehicle
 * @package Consulta\Laravel
 */
class Vehicle extends Consulta
{

    /**
     * @param $plate
     * @return mixed
     * @throws InvalidPlateException
     * @throws \Consulta\Laravel\Exceptions\ServerErrorException
     * @throws \Consulta\Laravel\Exceptions\UnauthenticatedException
     * @throws \Consulta\Laravel\Exceptions\UndefinedErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($plate)
    {
        if (!$this->validatePlate($plate)) {
            throw new InvalidPlateException();
        }

        return $this->execute('api/sunarp/vehicle', ['plate' => $plate]);
    }

    /**
     * @param $plate
     * @return bool
     */
    public function validatePlate($plate)
    {
        $validator = Validator::make(['plate' => $plate], ['plate' => 'required|alpha_num|size:6']);
        return !$validator->fails();
    }
}
