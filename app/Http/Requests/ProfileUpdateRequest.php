<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [ 
            'password_lama' => ['required_with:password_baru', 'current_password:siswa'],
            'password_baru' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
