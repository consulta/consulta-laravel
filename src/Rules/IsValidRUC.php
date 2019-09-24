<?php

namespace Consulta\Rules;

use Consulta\Laravel\Consulta;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class IsValidRUC
 * @package Consulta\Rules
 */
class IsValidRUC implements Rule
{
    /**
     * @var bool
     */
    private $isOperative;

    /**
     * IsValidRUC constructor.
     * @param bool $isOperative
     */
    public function __construct(bool $isOperative)
    {
        $this->isOperative = $isOperative;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $response = Consulta::sunat()->find($value);
        if ($this->isOperative) {
            return is_array($response) && $response['estado_contribuyente'] == 'ACTIVO' && $response['condicion_contribuyente'] == 'HABIDO';
        }

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
