<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Authy;
use App\Http\Controllers\Controller;
use App\Services\Authy\Exceptions\InvalidTokenException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthTokenController extends Controller
{
    public function getToken(Request $request)
    {
        if(!$request->session()->has('authy'))
        {
            return redirect()->to('/home');
        }
        return view('token');
    }

    public function postToken(Request $request)
    {
        try {
            $verification = Authy::verifyToken($request->token);
        }
        catch (InvalidTokenException $e)
        {
            return redirect()->back()->withErrors([
               'token' => 'Invalid token'
            ]);
        }

        if(Auth::loginUsingId(
            $request->session()->get('authy.user_id'),
            $request->session()->get('authy.remember')
        ))
        {
            $request->session()->forget('authy');
            return redirect()->intended();
        }

        return redirect()->url('/home');
    }
}
