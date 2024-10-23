<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForecastWeatherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> Un arreglo asociativo que contiene las reglas de validación.
     *
     * Las reglas de validación son:
     * - 'city': Requerido, debe ser una cadena de texto con un máximo de 255 caracteres.
     * - 'codeCountry': Requerido, debe ser una cadena de texto de exactamente 2 caracteres.
     * - 'days': Requerido, debe ser un número entero entre 1 y 5.
     */
    public function rules(): array
    {
        return [
            'city' => 'required|string|max:255',
            'codeCountry' => 'required|string|size:2',
            'days' => 'required|integer|min:1|max:5',
        ];
    }
}
