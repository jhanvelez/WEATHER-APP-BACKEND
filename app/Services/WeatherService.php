<?php

namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Exceptions\WeatherServiceException;

class WeatherService
{
    private HttpClientInterface $client; // Cliente HTTP para realizar solicitudes
    protected $apiKey; // Clave de API para autenticar las solicitudes
    protected $baseUrl; // URL base de la API de OpenWeatherMap

    /**
     * Constructor de la clase WeatherService.
     * Inicializa el cliente HTTP y cargar la configuración.
     */
    public function __construct()
    {
        $this->client = HttpClient::create(); // Crear una instancia del cliente HTTP
        $this->apiKey = config('services.openweathermap.key'); // Obtener la clave de API desde la configuración
        $this->baseUrl = config('services.openweathermap.base_url'); // Obtener la URL base desde la configuración
    }

    /**
     * Obtener el clima actual para una ciudad con un código de país específico.
     *
     * @param string $city Nombre de la ciudad
     * @param string $countryCode Código del país
     * @return array Datos del clima actual
     * @throws WeatherServiceException Si ocurre un error durante la solicitud
     */
    public function getCurrentWeather($city, $countryCode)
    {
        try {
            $response = $this->client->request('GET', "{$this->baseUrl}/weather", [
                'query' => [
                    'q' => "$city,$countryCode",
                    'appid' => $this->apiKey,
                    'units' => 'metric'
                ]
            ]);

            return $response->toArray();
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface $e) {
            throw new WeatherServiceException('Ocurrió un error, verifica los datos insertados.',);
        } catch (TransportExceptionInterface $e) {
            throw new WeatherServiceException('Ocurrió un error de red: ' . $e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            throw new WeatherServiceException('Ocurrió un error inesperado: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Obtener la previsión del clima para una ciudad con un código de país específico.
     *
     * @param string $city Nombre de la ciudad
     * @param string $countryCode Código del país
     * @param int $days Número de días para la previsión (máximo 5)
     * @return array Datos de la previsión del clima
     * @throws WeatherServiceException Si ocurre un error durante la solicitud
     */
    public function getForecast($city, $countryCode, $days)
    {
        try {
            $response = $this->client->request('GET', "{$this->baseUrl}/forecast", [
                'query' => [
                    'q' => "$city,$countryCode",
                    'appid' => $this->apiKey,
                    'cnt' => $days * 8,
                    'units' => 'metric'
                ]
            ]);

            return $response->toArray();
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface $e) {
            throw new WeatherServiceException('Ocurrió un error, verifica los datos insertados.');
        } catch (TransportExceptionInterface $e) {
            throw new WeatherServiceException('Ocurrió un error de red: ' . $e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            throw new WeatherServiceException('Ocurrió un error inesperado: ' . $e->getMessage(), $e->getCode());
        }
    }
}