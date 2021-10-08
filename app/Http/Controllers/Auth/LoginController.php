<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Authy;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Authy\Exceptions\SmsRequestFailedException;
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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $redirectToToken = '/auth/token';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, User $user)
    {
        if($user->hasTwoTactorAuthenticztionEnabled())
        {
            return $this->logoutAndRedirectToTokenEntry($request, $user);
        }

        return redirect()->intend($this->redirectPath());
    }

    protected function logoutAndRedirectToTokenEntry(Request $request, User $user)
    {
        Auth::logout();

        $request->session()->put('authy',[
            'user_id' => $user->id,
            'authy_id' => $user->authy_id,
            'using_sms' => false,
            'remember' => $request->has('remember')
        ]);

        if($user->hasSmsTwoTactorAuthenticztionEnabled())
        {
            try {
                Authy::requestSms($user);
            }
            catch (SmsRequestFailedException $e){

                redirect()->back();
            }

            $request->session()->push('authy.using_sms',true);

            return redirect($this->redirectToToken);
        }
    }
}
