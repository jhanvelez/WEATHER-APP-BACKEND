<?php
namespace Tests\Feature;

use Tests\TestCase;

class WeatherTest extends TestCase
{
    public function testCurrentWeather()
    {
        $response = $this->get('/api/weather/current?city=Madrid&country=ES');
        $response->assertStatus(200);
    }

    public function testWeatherForecast()
    {
        $response = $this->get('/api/weather/forecast?city=Madrid&country=ES&days=3');
        $response->assertStatus(200);
    }
}