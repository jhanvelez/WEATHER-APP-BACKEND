<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Instalación

Para instalar el framework Laravel, sigue estos pasos:

1. Clona el repositorio:
    ```bash
    git clone https://github.com/your-repo/weather-app-backend.git
    cd weather-app-backend
    ```

2. Instala las dependencias:
    ```bash
    composer install
    ```

3. Copia el archivo `.env.example` a `.env`:
    ```bash
    cp .env.example .env
    ```

4. Genera la clave de la aplicación:
    ```bash
    php artisan key:generate
    ```

5. Añade las siguientes variables a tu archivo `.env`:
    ```env
    OWM_API_KEY="tu api key"
    OWM_BASE_URL="https://api.openweathermap.org/data/2.5"
    ```

## Ejecutar Comandos

Para ejecutar los siguientes comandos desde la consola, usa:

```bash
php artisan app:current-weather-command <city> <country_code>
php artisan app:forecast-weather-command <city> <country_code> <days>
```

## Autor

El autor de este proyecto es @jhanvelez. Puedes encontrar más información sobre él en su [perfil de GitHub](https://github.com/jhanvelez).

