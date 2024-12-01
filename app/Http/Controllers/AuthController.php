<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    # Show login view
    public function login()
    {
        return view('login');
    }

    # Login from the application
    public function loginSubmit(Request $request)
    {
        # Form validation
        $request->validate(
            # Rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            # Error messages
            [
                'text_username.required' => 'O email é obrigatório.',
                'text_username.email' => 'Você deve informar um email válido.',

                'text_password.required' => 'A senha é obrigatória.',
                'text_password.min' => 'A senha deve ter pelo menos :min caracteres.',
                'text_password.max' => 'A senha deve ter no máximo :max caracteres.'
            ]
        );

        # Get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        $user = User::where('username', $username)
            ->where('deleted_at', NULL)
            ->first();

        # Check if users exists
        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Email ou senha incorretos.');
        }

        # Chef if password is correct
        if (!password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Email ou senha incorretos.');
        }

        # Update last login
        $user->last_login = date('Y:m:d H:i:s');
        $user->save();

        # Login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        // Redirect to home
        return redirect()
            ->route('home');
    }

    # Logout from the application
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}
