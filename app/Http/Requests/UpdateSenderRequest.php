<?php

namespace App\Http\Requests;

use App\Models\Sender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSenderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->sender->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string',
            'phone' => [
                'required',
                Rule::unique(Sender::class, 'phone')->ignore($this->sender),
            ],
        ];
    }
}
