<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Socialite;
use App\AuditLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            AuditLog::log(AuditLog::ERROR, $e);
            return redirect('/login');
        }
        $appUser = $this->findOrCreateUser($socialUser, $provider);
        AuditLog::log(AuditLog::USER_OAUTH_AUTHENTICATION, $appUser);
        Auth::login($appUser, true);
        return redirect($this->redirectTo);
    }


    public function findOrCreateUser($providerUser, $provider)
    {

        $user = User::whereProvider($provider)->whereProviderId($providerUser->getId())->first();

        if ($user) {
            return $user;
        } else {
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name'  => $providerUser->getName(),
                'provider' => $provider,
                'provider_id'   => $providerUser->getId(),
                'provider_token'   => $providerUser->token,
                'provider_secret'   => $providerUser->tokenSecret,
            ]);

            return $user;
        }
    }
}
