<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('index', compact('categories'));

    }
}
