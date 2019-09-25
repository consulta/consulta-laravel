<?php

namespace Consulta\Laravel\Lib;

use Consulta\Laravel\Consulta;
use Consulta\Laravel\Exceptions\InvalidDniException;
use Consulta\Laravel\Exceptions\InvalidRucException;

/**
 * Class RUC
 * @package Consulta\Laravel
 */
class RUC extends Consulta
{

    /**
     * @param $rucNumber
     * @return mixed
     * @throws InvalidRucException
     * @throws \Consulta\Laravel\Exceptions\ServerErrorException
     * @throws \Consulta\Laravel\Exceptions\UnauthenticatedException
     * @throws \Consulta\Laravel\Exceptions\UndefinedErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function byRuc($rucNumber)
    {
        if (!$this->validateRuc($rucNumber)) {
            throw new InvalidRucException('RUC number seems not to be valid.');
        }

        return $this->execute('api/sunat/query/ruc', ['ruc' => $rucNumber]);
    }

    /**
     * @param string $dniNumber
     * @return mixed
     * @throws InvalidDniException
     * @throws \Consulta\Laravel\Exceptions\ServerErrorException
     * @throws \Consulta\Laravel\Exceptions\UnauthenticatedException
     * @throws \Consulta\Laravel\Exceptions\UndefinedErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function byDni(string $dniNumber)
    {
        if (!$this->validateDni($dniNumber)) {
            throw new InvalidDniException('DNI number seems not to be valid.');
        }

        return $this->execute('api/sunat/query/dni', ['dni' => $dniNumber]);
    }


    /**
     * @param $value
     * @return bool
     */
    public function validateRuc($value)
    {
        $value = trim((string)$value);

        if (is_numeric($value)) {
            if (($valuelength = strlen($value)) == 8) {
                $sum = 0;
                for ($i = 0; $i < $valuelength - 1; $i++) {
                    $digit = $this->charAt($value, $i) - '0';
                    if ($i == 0) {
                        $sum += ($digit * 2);
                    } else {
                        $sum += ($digit * ($valuelength - $i));
                    }
                }
                $diff = $sum % 11;
                if ($diff == 1) {
                    $diff = 11;
                }
                if ($diff + ($this->charAt($value, $valuelength - 1) - '0') == 11) {
                    return true;
                }
                return false;
            } elseif (($valuelength = strlen($value)) == 11) {
                $sum = 0;
                $x = 6;
                for ($i = 0; $i < $valuelength - 1; $i++) {
                    if ($i == 4) {
                        $x = 8;
                    }
                    $digit = $this->charAt($value, $i) - '0';
                    $x--;
                    if ($i == 0) {
                        $sum += ($digit * $x);
                    } else {
                        $sum += ($digit * $x);
                    }
                }
                $diff = $sum % 11;
                $diff = 11 - $diff;
                if ($diff >= 10) {
                    $diff = $diff - 10;
                }
                if ($diff == $this->charAt($value, $valuelength - 1) - '0') {
                    return true;
                }
                return false;
            }
        }
        return false;
    }


    /**
     * @param $string
     * @param $index
     * @return int|string
     */
    protected function charAt($string, $index)
    {
        if ($index < mb_strlen($string)) {
            return mb_substr($string, $index, 1);
        } else {
            return -1;
        }
    }
}
