<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
public function index(Request $request)
{
    $category = $request->query('category');

    return view('home', [
        'category' => $category
    ]);
}

}