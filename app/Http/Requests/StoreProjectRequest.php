<?php

namespace App\Http\Requests;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'deadline' => ['required', 'date_format:Y-m-d'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'status' => ['required', 'string', Rule::enum(ProjectStatus::class)],
        ];
    }
}
