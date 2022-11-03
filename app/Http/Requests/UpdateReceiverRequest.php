<?php

namespace App\Http\Requests;

use App\Models\Receiver;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReceiverRequest extends FormRequest
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
            'type'        => [
                'required',
                Rule::in([
                    Receiver::TYPE_PERSON,
                    Receiver::TYPE_GROUP,
                ]),
            ],
            'name'        => 'required|string',
            'whatsapp_id' => 'required|string',
        ];
    }
}
