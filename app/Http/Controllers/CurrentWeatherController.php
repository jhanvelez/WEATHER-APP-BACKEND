<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CurrentWeatherRequest;
use App\Services\WeatherService;

class CurrentWeatherController extends Controller
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
    public function index(CurrentWeatherRequest $request)
    {
        try {
            $city = $request->input('city');
            $codeCountry = $request->input('codeCountry');

            $data = $this->weatherService->getCurrentWeather($city, $codeCountry);

            $formattedData = $this->formatCurrentWeatherResponse($data);

            return response()->json($formattedData);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Formatear la respuesta del clima actual.
     *
     * @param array $data Los datos del clima actual.
     * @return array Los datos del clima actual formateados.
     */
    private function formatCurrentWeatherResponse(array $data): array
    {
        return [
            'city' => $data['name'],
            'country' => $data['sys']['country'],
            'temperature' => [
                'current' => $data['main']['temp'],
                'feels_like' => $data['main']['feels_like'],
                'min' => $data['main']['temp_min'],
                'max' => $data['main']['temp_max']
            ],
            'weather' => [
                'main' => $data['weather'][0]['main'],
                'description' => $data['weather'][0]['description'],
                'icon' => $data['weather'][0]['icon']
            ],
            'wind' => [
                'speed' => $data['wind']['speed'],
                'deg' => $data['wind']['deg']
            ],
            'humidity' => $data['main']['humidity'],
            'pressure' => $data['main']['pressure'],
            'visibility' => $data['visibility'],
            'sunrise' => date('H:i:s', $data['sys']['sunrise']),
            'sunset' => date('H:i:s', $data['sys']['sunset']),
            'timezone' => $data['timezone']
        ];
    }
}
