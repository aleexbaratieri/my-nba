<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
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
            'team_id' => [
                'required',
                'integer',
                Rule::unique('teams', 'team_id')->ignore($this->route('team'), 'id')
            ],
            'conference' => 'nullable|string',
            'division' => 'nullable|string',
            'city' => 'nullable|string',
            'name' => 'required|string',
            'full_name' => 'required|string',
            'abbreviation' => 'nullable|string', 
        ];
    }
}
