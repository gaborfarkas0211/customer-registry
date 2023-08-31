<?php

namespace App\Http\Requests;

use App\Rules\WithinReceptionTime;
use App\Services\EventService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule', 'array', 'string>
     */
    public function rules(): array
    {
        return [
            'time_range' => ['required', 'array', new WithinReceptionTime(new EventService())],
            'time_range.start' => ['required', 'date_format:Y-m-d\TH:i:sP', 'after:now'],
            'time_range.end' => ['required', 'date_format:Y-m-d\TH:i:sP', 'after:startDateTime'],
            'title' => ['required', 'string'],
        ];
    }
}
