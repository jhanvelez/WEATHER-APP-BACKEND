<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;

class ForecastWeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:forecast-weather-command {city} {countryCode} {days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene la previsión del clima para una ciudad específica durante un número determinado de días.';

    protected $weatherService;

    /**
     * Create a new command instance.
     *
     * @param WeatherService $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener los argumentos de la línea de comandos
        $city = $this->argument('city');
        $countryCode = $this->argument('countryCode');
        $days = $this->argument('days');

        // Llamar al servicio para obtener los datos
        $forecastData = $this->weatherService->getForecast($city, $countryCode, $days);

        // Mostrar la información en la consola
        $this->info('Previsión de ' . $forecastData['city']['name'] . ', ' . $countryCode);
        foreach ($forecastData['list'] as $day) {
            $this->info($day['dt_txt'] . ': ' . $day['main']['temp'] . '°C - ' . $day['weather'][0]['description']);
        }

        return 0;
    }
}