<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * Этот конструктор позволяет применять middleware 'auth'
     * ко всем методам контроллера, чтобы разрешить доступ только авторизованным пользователям.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * Отображает главную страницу панели пользователя.
     * Метод возвращает представление 'home'.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
