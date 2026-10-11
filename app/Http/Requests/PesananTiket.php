<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PesananTiket extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role === 'user';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jenis_tiket_id' => ['required', 'integer', 'exists:jenis_tikets,id'],
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'jumlah_dewasa' => ['required', 'integer', 'min:0', 'max:20'],
            'jumlah_anak' => ['required', 'integer', 'min:0', 'max:20'],
        ];
    }
}
