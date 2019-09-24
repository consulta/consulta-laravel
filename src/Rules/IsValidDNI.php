<?php

namespace Consulta\Rules;

use Consulta\Laravel\Consulta;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class IsValidDNI
 * @package Consulta\Rules
 */
class IsValidDNI implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws \Consulta\Laravel\Exceptions\InvalidDniException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function passes($attribute, $value)
    {
        $response = Consulta::reniec()->find($value);
        return is_array($response);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El DNI no existe o pertenece a un menor de edad.';
    }
}
