<?php

namespace App\Http\Requests\Invoices;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetInvoiceListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => ['sometimes', 'integer', 'gte:1'],
            'page' => ['sometimes', 'integer', 'gte:1'],
        ];
    }
}
