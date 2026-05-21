<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreATSRouteRequest extends FormRequest
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
            'route_name'  => ['required', 'string', 'max:50', 'unique:ats_routes,route_name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'waypoints'   => ['required', 'array', 'min:2'],
            'waypoints.*' => ['required', 'integer', 'exists:waypoints,id'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'waypoints.min'       => 'An ATS route must contain at least 2 waypoints.',
            'waypoints.required'  => 'Please add at least 2 waypoints to the route.',
            'waypoints.*.exists'  => 'One or more selected waypoints are invalid.',
        ];
    }
}
