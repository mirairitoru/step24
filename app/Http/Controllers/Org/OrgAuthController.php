<?php

namespace App\Http\Controllers\Org;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => 'メールアドレス形式で入力してください',
                'password' => 'パスワードを入力してください',
            ]
        );

        if (Auth::guard('org')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {

            $request->session()->regenerate();

            return redirect()->route('animals');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません'
            ])->withInput()->with('login_type', 'org');
    }

    public function logout()
    {
        Auth::guard('org')->logout();

        return redirect('/');
    }
}
