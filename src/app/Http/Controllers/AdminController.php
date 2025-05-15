<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('admin', ['input' => '', 'contacts' => [],'categories' => $categories]);
    }

    public function search(Request $request)
{
    $keyword = $request->input('name');

    $contacts = Contact::with('category')
                ->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->paginate(7);

    $categories = Category::all();

    return view('admin', [
        'input' => $keyword,
        'contacts' => $contacts,
        'categories' => $categories
    ]);
}

}
