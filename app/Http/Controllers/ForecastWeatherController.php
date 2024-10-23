<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForecastWeatherRequest;
use App\Services\WeatherService;

class ForecastWeatherController extends Controller
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
     * Obtener la previsión del clima para una ciudad, código de país y número de días especificados.
     *
     * @param ForecastWeatherRequest $request La instancia de la solicitud HTTP.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que contiene los datos de la previsión meteorológica.
     */
    public function index(ForecastWeatherRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $city = $request->input('city');
            $codeCountry = $request->input('codeCountry');
            $days = $request->input('days');

            $data = $this->weatherService->getForecast($city, $codeCountry, $days);

            $formattedData = $this->formatForecastResponse($data);

            return response()->json($formattedData);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Formatea la respuesta de la previsión meteorológica.
     *
     * @param array $data Los datos de la previsión meteorológica.
     * @return array Los datos formateados de la previsión meteorológica.
     */
    private function formatForecastResponse(array $data): array
    {
        $formattedData = [
            'city' => data_get($data, 'city.name', 'Unknown City'),
            'country' => data_get($data, 'city.country', 'Unknown Country'),
            'forecast' => []
        ];

        foreach ($data['list'] as $forecast) {
            $formattedData['forecast'][] = [
                'date' => data_get($forecast, 'dt_txt', 'N/A'),
                'temperature' => [
                    'current' => data_get($forecast, 'main.temp', 'N/A'),
                    'feels_like' => data_get($forecast, 'main.feels_like', 'N/A'),
                    'min' => data_get($forecast, 'main.temp_min', 'N/A'),
                    'max' => data_get($forecast, 'main.temp_max', 'N/A')
                ],
                'weather' => [
                    'main' => data_get($forecast, 'weather.0.main', 'N/A'),
                    'description' => data_get($forecast, 'weather.0.description', 'N/A'),
                    'icon' => data_get($forecast, 'weather.0.icon', 'N/A')
                ],
                'wind' => [
                    'speed' => data_get($forecast, 'wind.speed', 'N/A'),
                    'deg' => data_get($forecast, 'wind.deg', 'N/A')
                ],
                'humidity' => data_get($forecast, 'main.humidity', 'N/A'),
                'pressure' => data_get($forecast, 'main.pressure', 'N/A'),
                'visibility' => data_get($forecast, 'visibility', 'N/A')
            ];
        }

        return $formattedData;
    }
}