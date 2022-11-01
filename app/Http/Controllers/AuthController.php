<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Mail\ValidateIp;
use App\Models\AccessAttempts;
use App\Models\Whitelist;
use App\Providers\RouteServiceProvider;
use App\Repositories\AccessAttemptsRepository;
use App\Repositories\WhitelistRepository;
use Barryvdh\Debugbar\Facades\Debugbar;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signIn(LoginRequest $request, AccessAttemptsRepository $repository)
    {
        $request->authenticate();

        if (!Whitelist::checkIp($request->ip())) {
            $user = Auth::user();
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $accessAttempt = $repository->create($request->ip());
            Mail::to($user)->send(new ValidateIp($accessAttempt, $user));
            return back()->withWarning('Verifique seu email para liberar seu acesso ao sistema!');
        }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function releaseAccess(Request $request, WhitelistRepository $repository)
    {
        $token = $request->get('token');
        $access = AccessAttempts::query()->whereToken($token)->where('expiration', '>=', date('Y-m-d H:i:s'))->first();

        if (is_null($access)) {
            return redirect()->route('login')->withError('Houve um erro ao liberar o ip de acesso');
        }

        $repository->create($access->ip, new DateTime(date('Y-m-d') . '23:59:59'), 'IP liberado por validação de email');
        return redirect()->route('login')->withSuccess('O seu IP foi liberado, insira suas credenciais para entrar no sistema!');
    }
}
