<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Выход из системы

        $request->session()->invalidate();

        return redirect('/');
    }

    public function login(Request $request)
    {
        $response = (object)User::login($request->get('email'), $request->get('password'));

        if ($response->token && $response->user) {
            $user = new User();
            $user->id = ((object)$response->user[0])->id;
            $user->name = ((object)$response->user[0])->name;
            $user->email = ((object)$response->user[0])->email;
            Auth::setUser($user);
            Auth::login($user);
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Неверные учетные данные.',
        ]);
    }

}
