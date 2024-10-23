<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrentWeatherRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * 
     * Reglas de validación:
     * - 'city': Campo requerido, debe ser una cadena de texto con un máximo de 255 caracteres.
     * - 'codeCountry': Campo requerido, debe ser una cadena de texto con exactamente 2 caracteres.
     */
    public function rules(): array
    {
        return [
            'city' => 'required|string|max:255',
            'codeCountry' => 'required|string|size:2',
        ];
    }
}
