<?php

namespace App\Http\Controllers\ClienteAuth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ClienteNewPasswordController extends Controller
{
    public function create(Request $request, string $token)
    {
        return view('clientelogin.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::broker('clientes')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($cliente) use ($request) {
                $cliente->forceFill([
                    'password' => Hash::make($request->input('password')),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($cliente));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('cliente.login')->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
