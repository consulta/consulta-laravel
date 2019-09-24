<?php

namespace Consulta\Rules;

use Consulta\Laravel\Consulta;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class IsValidDNIDigit
 * @package App\Rules
 */
class IsValidDNIDigit implements Rule
{
    /**
     * @var string
     */
    private $dni;

    /**
     * Create a new rule instance.
     *
     * @param string $dni
     */
    public function __construct(string $dni)
    {
        $this->dni = $dni;
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
        return Consulta::reniec()->validateDigit($this->dni, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El dígito del DNI no es válido';
    }
}
