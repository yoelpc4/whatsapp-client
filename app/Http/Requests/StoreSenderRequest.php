<?php

namespace App\Http\Requests;

use App\Models\Sender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSenderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'phone' => [
                'required',
                'max:255',
                Rule::unique(Sender::class, 'phone'),
            ],
        ];
    }
}
