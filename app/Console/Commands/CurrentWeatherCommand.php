<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;
use App\Exceptions\WeatherServiceException;

class CurrentWeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:current-weather-command {city} {countryCode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene el clima actual para una ciudad específica y un código de país.';

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

        try {
            // Llamar al servicio para obtener los datos del clima actual
            $weatherData = $this->weatherService->getCurrentWeather($city, $countryCode);

            // Verificar si hay un error en los datos devueltos
            if (isset($weatherData['error'])) {
                $this->error($weatherData['error']);
                return;
            }

            // Mostrar la información del clima actual
            $this->info('Clima en ' . $weatherData['name'] . ', ' . $countryCode);
            $this->info('Temperatura: ' . $weatherData['main']['temp'] . '°C');
            $this->info('Clima: ' . $weatherData['weather'][0]['description']);
        } catch (WeatherServiceException $e) {
            // Manejo de excepciones específicas del servicio de clima
            $this->error($e->getMessage());
        }

        return 0; // Indica que el comando se ejecutó correctamente
    }
}