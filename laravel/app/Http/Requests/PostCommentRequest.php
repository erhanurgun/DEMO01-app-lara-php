<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCommentRequest extends FormRequest
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
        return [
            // post_id, user_id, first_name, last_name, email, comment, status
            'post_id' => 'required|integer',
            'user_id' => 'required|integer',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'comment' => 'required|string',
            'status' => 'required|string|in:' . $this->helpers->status('rules'),
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
            '*.required' => 'Lütfen bu alanı doldurunuz!',
            '*.integer' => 'Lütfen bu alana sayısal bir değer giriniz!',
            '*.string' => 'Lütfen bu alana metinsel bir değer giriniz!',
            '*.max' => 'Lütfen bu alana :max karakterden fazla değer girmeyiniz!',
            '*.email' => 'Lütfen bu alana geçerli bir e-posta adresi giriniz!',
            '*.in' => 'Lütfen bu alan için geçerli bir değer seçiniz!',
        ];
    }
}
