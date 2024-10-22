<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

/**
 * @package App\Http\Controllers
 * WeatherController maneja las solicitudes relacionadas con el clima.
 * 
 * Este controlador utiliza el WeatherService para obtener datos del clima actual
 * y previsiones meteorológicas basadas en la ciudad y el código de país.
 */
class WeatherController extends Controller
{
    protected $weatherService; // Instancia del servicio de clima

    /**
     * Constructor para inicializar WeatherService.
     *
     * @param WeatherService $weatherService La instancia del servicio de clima.
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Obtener el clima actual para una ciudad y código de país especificados.
     *
     * @param Request $request La instancia de la solicitud HTTP.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que contiene los datos del clima actual.
     */
    public function current(Request $request)
    {
        $city = $request->input('city');
        $countryCode = $request->input('country_code');

        $data = $this->weatherService->getCurrentWeather($city, $countryCode);

        return response()->json($data);
    }

    /**
     * Obtener la previsión del clima para una ciudad, código de país y número de días especificados.
     *
     * @param Request $request La instancia de la solicitud HTTP.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que contiene los datos de la previsión meteorológica.
     */
    public function forecast(Request $request)
    {
        $city = $request->input('city');
        $countryCode = $request->input('country_code');
        $days = $request->input('days');

        $data = $this->weatherService->getForecast($city, $countryCode, $days);

        return response()->json($data);
    }
}