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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'gender' => ['required'],
            'email' => ['email','required'],
            'tel_part1' => ['required'],
            'tel_part2' => ['required'],
            'tel_part3' => ['required'],
            'address' => ['required'],
            'content' => ['required'],
            'detail' => ['required','max:120'],
            
        ];
    }

 public function messages()
     {
         return [
            'first_name.required' => '名を入力してください',
            'last_name.required' => '姓を入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel_part1.required' => '電話番号を入力してください',
            'tel_part2.required' => '電話番号を入力してください',
            'tel_part3.required' => '電話番号を入力してください',
            'address.required' => '住所を入力してください',
            'content.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせを入力してください',
            'detail.max:120' => 'お問い合わせの内容は１２０文字以内で入力してください'
         ];
     }

}
