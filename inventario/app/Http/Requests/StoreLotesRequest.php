<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreLotesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'descripcion' => ['required', 'string', 'max:30'],
            'producto_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')
                    ->where('usuario', Auth::id())
                    ->where('estado', true)
                    ->where('habilitado', true)
                    ->where('eliminado', false),
            ],
            'cantidad' => ['required', 'numeric', 'min:0', 'max:10000000'],
            'almacen_id' => [
                'required',
                'integer',
                Rule::exists('almacens', 'id')
                    ->where('usuario', Auth::id())
                    ->where('estado', true)
                    ->where('habilitado', true)
                    ->where('eliminado', false),
            ],
        ];
    }
}
