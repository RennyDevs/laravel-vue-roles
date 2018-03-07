<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function test(Request $request)
    {
        // php artisan storage:link -> crea un acceso directo a la carpeta storage/public desde public/storage
        // foreach ($request->images as $image) {
            print_r($request->file('image'));
        // }
        if ($request->hasFile('image')) {
            echo('si');
            // echo $request->file('image')->move(public_path(), time() . '.' . $request->file('image')->getClientOriginalExtension());
            // echo $request->image->storeAs('public', 'imagencita.jpg');
        }
        echo('no');
    }
}
