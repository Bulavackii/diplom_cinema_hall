<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Показ формы входа.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Указываем путь до представления
    }

    /**
     * Обработка формы входа.
     */
    public function login(Request $request)
    {
        // Валидация входных данных
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Попытка аутентификации
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        // Возврат ошибки, если учетные данные неверные
        return back()->withErrors([
            'email' => 'Неправильные учетные данные.'
        ]);
    }

    /**
     * Выход из системы.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
