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
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'subject' => 'required|max:80',
            'body1' => 'required|max:15',
            'body2' => 'required|max:15',
            'body3' => 'required|max:15',
            'category_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください。',
            'name.max' => '名前は40文字以内で入力してください',
            'subject.required' => '件名を入力してください',
            'subject.max' => '件名は80文字以内で入力してください',
            'message.required' => 'メッセージを入力してください',
            'message.max' => 'メッセージは350文字以内で入力してください',
            'category_id.required' => 'カテゴリーを選択してください',
            'category_id.integer' => 'カテゴリーの入力形式が不正です',
        ];
    }
}