<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeRoleRequest extends FormRequest
{
    /**
     * Otorisasi dilakukan oleh middleware can:manage-roles pada route,
     * jadi Form Request di sini hanya memeriksa bentuk input.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role' => ['required', 'string', Rule::in(['customer', 'staff'])],
        ];
    }
}
