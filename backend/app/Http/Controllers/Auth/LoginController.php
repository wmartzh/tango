<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function log(Request $request){

        $data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        //dd($data); //Funcion para realizar debuggin
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
//obtener datos de usuario para token
            $user = Auth::user();

            $tokenResult = $user->createToken('Personal')->accessToken;

            $res = [
                'token' => $tokenResult,
                'nickname' => $user->nickname
            ];

            return response($res, 200);
        }else{
         $res = [
             'message' => 'Invalid credentials'
         ];

         return response($res, 401);
        }

    }
}
