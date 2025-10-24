<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
public function authorize(): bool { return auth()->check(); }

public function rules(): array
{
    return [
        'username'  => ['nullable','string','max:255', Rule::unique('users','username')->ignore($this->user()->id)],
        'email'     => ['required','email','max:255', Rule::unique('users','email')->ignore($this->user()->id)],
        'phone'     => ['nullable','string','max:30'],
        'birthday'  => ['nullable','date'],
        'avatar'    => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        // ถ้าฟอร์มยังส่ง name มา จะถูก map เป็น username ด้านล่าง
        'name'      => ['nullable','string','max:255'],
    ];
}

protected function prepareForValidation(): void
{
    $this->merge([
        // ถ้ามี name ให้กลายเป็น username อัตโนมัติ
        'username' => $this->input('username', $this->input('name')),
    ]);
}
}
