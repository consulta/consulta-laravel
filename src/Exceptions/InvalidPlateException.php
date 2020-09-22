<?php

namespace Consulta\Laravel\Exceptions;

/**
 * Class InvalidPlateException
 * @package Consulta\Laravel\Exceptions
 */
class InvalidPlateException extends \Exception
{
	protected $message = 'Plate number seems not to be valid.';
}
