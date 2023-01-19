<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        // eğer post güncelleniyorsa
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $image = 'nullable|';
        } else {
            $image = 'required|';
        }

        // 'user_id', 'cover_image', 'title', 'categories',
        // 'tags', 'body', 'status', 'seo'
        $forImage = $image . 'file|mimes:' . $this->helpers->extensions('images') . '|max:2048';
        return [
            'cover_image' => $forImage,
            'thumbnail_image' => $forImage,
            'title' => 'required|string|min:5|max:255',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
            'body' => 'required|string|min:30',
            'status' => 'required|string|in:' . $this->helpers->status('rules'),
            //'seo' => 'nullable|json',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            '*.required' => 'Lütfen bu alanı doldurunuz.',
            '*.integer' => 'Lütfen bu alana sayısal bir değer giriniz.',
            '*.string' => 'Lütfen bu alana metinsel bir değer giriniz.',
            '*.min' => 'Lütfen bu alana en az :min karakter giriniz.',
            '*.max' => 'Lütfen bu alana en fazla :max karakter giriniz.',
            '*.mimes' => 'Lütfen sadece ' . $this->helpers->extensions('images') . ' uzantılı bir dosya seçiniz.',
            '*.exists' => 'Lütfen bu alana geçerli bir değer giriniz.',
            '*.in' => 'Lütfen bu alana geçerli bir değer seçiniz.',
            '*.json' => 'Lütfen bu alana geçerli bir JSON değeri giriniz.',
            '*.unique' => 'Lütfen bu alana benzersiz bir değer giriniz.',
            '*.array' => 'Lütfen bu alana geçerli bir dizi giriniz.',
        ];
    }
}
