<?php


namespace Consulta\Laravel;

use Consulta\Laravel\Exceptions\ServerErrorException;
use Consulta\Laravel\Exceptions\UnauthenticatedException;
use Consulta\Laravel\Exceptions\UndefinedErrorException;
use Consulta\Laravel\Lib\DNI;
use Consulta\Laravel\Lib\ExchangeRate;
use Consulta\Laravel\Lib\RUC;
use GuzzleHttp\Client;

/**
 * Class Consulta
 * @package Consulta\Laravel
 */
class Consulta
{

    /**
     * @return mixed
     */
    public static function sunat(): RUC
    {
        return new RUC();
    }

    /**
     * @return DNI
     */
    public static function reniec(): DNI
    {
        return new DNI();
    }

    /**
     * @return ExchangeRate
     */
    public static function exchange()
    {
        return new ExchangeRate();
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getToken(): string
    {
        return config('services.consulta.token');
    }

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return 'https://consulta.pe';
    }

    /**
     * @param $url
     * @param $query
     * @param string $method
     * @return string|null
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function execute(string $url, array $query, string $method = 'POST')
    {
        $token = self::getToken();
        $client = new Client([
            'base_uri' => self::getBaseUrl(),
            'headers' => ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"]
        ]);

        $response = $client->request($method, $url, [
            'query' => $query
        ]);

        switch ($response->getStatusCode()) {
            case 200:
                return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
            case 401:
                throw new UnauthenticatedException('Token seems not to be valid.');
                break;

            case 500:
                throw new ServerErrorException('Server error.');
                break;

            default:
                throw new UndefinedErrorException('An unexpected error has ben occurred.');
                break;
        }
    }

    /**
     * Validate length dni
     * @param $value
     * @return bool
     */
    protected function validateDni($value)
    {
        if (is_numeric($value)) {
            return strlen($value) == 8;
        }
        return false;
    }
}
