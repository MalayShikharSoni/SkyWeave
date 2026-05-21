<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNavaidRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'identifier' => [
                'required',
                'string',
                'max:10',
                Rule::unique('navaids', 'identifier')->ignore($this->route('navaid')),
            ],
            'name'       => ['required', 'string', 'max:255'],
            'type'       => ['required', 'string', 'in:VOR,DME,VOR_DME,NDB,TACAN'],
            'frequency'  => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'latitude'   => ['required', 'numeric', 'between:-90,90'],
            'longitude'  => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    /**
     * Custom attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'identifier' => 'NAVAID identifier',
        ];
    }
}
