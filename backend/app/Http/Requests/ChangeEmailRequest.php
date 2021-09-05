<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class ChangeEmailRequest extends FormRequest
{
    private const GUEST_USER_ID = 5;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // guestでログインしたユーザーがメールアドレスを変更できないようにvalidationでfalseを返してDBのレコードを変更させないようにする。
        if(Auth::id() == self::GUEST_USER_ID) {
            return false;
        }

        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore(Auth::id())->whereNull('deleted_at')]
        ];
    }
}