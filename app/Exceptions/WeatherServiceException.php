<?php

namespace App\Exceptions;

use Exception;

/**
 * Clase personalizada para manejar excepciones relacionadas con el servicio
 */
class WeatherServiceException extends Exception
{
    /**
     * Constructor de la clase WeatherServiceException.
     *
     * @param string $message Mensaje de error que describe la excepción.
     * @param int $code Código de error opcional (por defecto es 0).
     * @param Exception|null $previous Excepción anterior opcional para encadenar excepciones.
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // Llamar al constructor de la clase base Exception
        parent::__construct($message, $code, $previous);
    }
}