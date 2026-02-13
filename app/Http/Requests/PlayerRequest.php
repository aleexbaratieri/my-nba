<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlayerRequest extends FormRequest
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
            'player_id' => [
                'required',
                'integer',
                Rule::unique('players', 'player_id')->ignore($this->route('player'), 'id')
            ],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'position' => 'nullable|string',
            'height' => 'nullable|string',
            'weight' => 'nullable|integer',
            'jersey_number' => 'nullable|integer',
            'college' => 'nullable|string',
            'country' => 'nullable|string',
            'draft_year' => 'nullable|integer',
            'draft_round' => 'nullable|integer',
            'draft_number' => 'nullable|integer',
            'team_id' => 'required|integer'
        ];
    }
}
