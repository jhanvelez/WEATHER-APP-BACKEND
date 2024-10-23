<?php

namespace App\Exceptions;

use Exception;

/**
 * Clase personalizada para manejar excepciones relacionadas con el servicio
 */
class WeatherServiceException extends Exception
{
    protected $details;

    /**
     * Constructor de la clase WeatherServiceException.
     *
     * @param string $message Mensaje de error que describe la excepción.
     * @param int $code Código de error opcional (por defecto es 0).
     * @param Exception|null $previous Excepción anterior opcional para encadenar excepciones.
     */
    public function __construct($message, $code = 0, Exception $previous = null, $details = [])
    {
        // Llamar al constructor de la clase base Exception
        parent::__construct($message, $code, $previous);
        $this->details = $details;
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
            'code' => $this->getCode(),
            'details' => $this->getDetails()
        ], $this->getCode() ?: 500);
    }
}