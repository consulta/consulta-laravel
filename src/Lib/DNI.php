<?php

namespace Consulta\Laravel\Lib;

use Consulta\Laravel\Consulta;
use Consulta\Laravel\Exceptions\InvalidDniException;

/**
 * Class DNI
 * @package Consulta\Laravel
 */
class DNI extends Consulta
{
    /**
     * Find a person by DNI
     * @param string $dniNumber
     * @return mixed
     * @throws InvalidDniException
     * @throws \Consulta\Laravel\Exceptions\ServerErrorException
     * @throws \Consulta\Laravel\Exceptions\UnauthenticatedException
     * @throws \Consulta\Laravel\Exceptions\UndefinedErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $dniNumber)
    {
        if (!$this->validateDni($dniNumber)) {
            throw new InvalidDniException('DNI number seems not to be valid.');
        }
        $response = $this->execute('/api/reniec/dni', ['dni' => $dniNumber]);
        return $response;
    }


    /**
     * evaluate if dni's digit is correct
     * @param $dni
     * @param $digit
     * @return bool
     */
    public function validateDigit(string $dni, int $digit): bool
    {
        return $this->validateDni($dni) && $this->validateHash($dni, $digit);
    }


    /**
     * @param $v
     * @param $h
     * @return bool
     */
    protected function validateHash(string $v, int $h): bool
    {
        $identificationDocument = $v . '0';
        $addition = 0;
        $hash = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];
        $identificationDocumentLength = strlen($identificationDocument);
        $identificationComponent = substr($identificationDocument, 0, $identificationDocumentLength - 1);
        $identificationComponentLength = strlen($identificationComponent);
        $diff = count($hash) - $identificationComponentLength;

        for ($i = $identificationComponentLength - 1; $i >= 0; $i--) {
            $addition += ($identificationComponent[$i] - '0') * $hash[$i + $diff];
        }

        $addition = 11 - ($addition % 11);

        if ($addition == 11) {
            $addition = 0;
        }

        $last = $identificationDocument[$identificationDocumentLength - 1];

        $hashValue = '';

        if (ctype_alpha($last)) {
            $hashLetters = ['K', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
            $hashValue = $hashLetters[$addition];
        } else {
            if (is_numeric($last)) {
                $hashNumbers = ['6', '7', '8', '9', '0', '1', '1', '2', '3', '4', '5'];
                $hashValue = $hashNumbers[$addition];
            }
        }

        return $h == $hashValue;
    }

}
