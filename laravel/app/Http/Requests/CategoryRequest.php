<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $param = '|unique:categories,slug,' . $this->id;
        } else {
            $param = '|unique:categories,slug';
        }
        return [
            'name' => 'required|string|min:2|max:50' . $param,
            'order' => 'required|integer|min:1|max:100',
            'status' => 'required|string|in:' . $this->helpers->status('rules'),
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            '*.required' => 'Lütfen bu alanı doldurunuz!',
            '*.string' => 'Lütfen geçerli bir değer giriniz!',
            '*.integer' => 'Lütfen geçerli bir sayı giriniz!',
            '*.min' => 'Lütfen en az :min karakter giriniz!',
            '*.max' => 'Lütfen en fazla :max karakter giriniz!',
            '*.in' => 'Lütfen geçerli bir değer giriniz!',
            '*.unique' => 'Bu isimde bir kategori zaten mevcut!',
        ];
    }
}
