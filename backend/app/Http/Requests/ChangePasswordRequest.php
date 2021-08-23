<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// ↓追加
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// ValidationをControllerのMethodから切り離し、Validation専用のファイルを作り処理させるために、FormRequestを作る。

class ChangePasswordRequest extends FormRequest
{

    public function authorize()
    {
        // ↓fulseからtrueに変更
        return true;
    }

    
    public function rules()
    {
        return [
            // バリデーションルールを書く
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
    }

    public function withValidator(Validator $validator) {
        $validator->after(function ($validator) {
            $auth = Auth::user();
            
            //現在のパスワードと新しいパスワードが合わなければエラー
            if (!(Hash::check($this->input('current_password'), $auth->password))) {
                $validator->errors()->add('current_password', __('The current password is incorrect.'));
            }
        });
    }
}