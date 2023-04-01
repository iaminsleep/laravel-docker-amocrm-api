<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use AmoCRM\OAuth2\Client\Provider\AmoCRM;
use AmoCRM\OAuth2\Client\Provider\OAuthConfig;

class UserController extends Controller
{
    public function registerPage()
    {
        return view('register');
    }

    public function loginPage()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:50',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        session()->flash('success', 'Регистрация пройдена.');

        return redirect()->route('login.page');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $oauthConfig = new OAuthConfig([
            'clientId' => env('AMOCRM_CLIENT_ID'),
            'clientSecret' => env('AMOCRM_CLIENT_SECRET'),
            'redirectUri' => env('AMOCRM_REDIRECT_URI'),
        ]);

        $provider = new AmoCRM($oauthConfig);

        // Если запрос поступил после перенаправления с AmoCRM
        if ($request->has('code')) {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $request->input('code')
            ]);
            $accessToken = $token->getToken();
            // Сохраняем access-token в базу данных для использования в будущем
            file_put_contents('../../../token.json', json_encode($token));
        }

        // Если пользователь еще не авторизован в AmoCRM, перенаправляем его
        if (empty($accessToken)) {
            $authUrl = $provider->getAuthorizationUrl();
            return redirect($authUrl);
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('index');
        } else {
            return redirect()->back()->with('error', 'Логин или пароль введён неправильно');
        };
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.page');
    }
}
