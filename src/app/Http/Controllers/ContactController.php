<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
Use App\Models\Category;

class ContactController extends Controller
{
    public function index()
  {
    $categories = Category::all();
    return view('index', compact('categories'));
  }

  public function confirm(ContactRequest $request)
  {
    $contact = $request->only(['first_name', 'last_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'tel', 'address', 'building',  'detail', 'category_id']);

    $contact['tel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];

    if ($contact['gender'] === 'male') {
        $contact['gender'] = 1;
    } elseif ($contact['gender'] === 'female') {
        $contact['gender'] = 2;
    } else {
        $contact['gender'] = 3;
    }

    $category = Category::find($contact['category_id']);
    $contact['category_name'] = $category->content ;

    return view('confirm', compact('contact'));

  }

  public function store(ContactRequest $request)
  {
    $contact = $request->only(['first_name', 'last_name', 'gender', 'email', 'tel', 'address', 'building',  'detail','category_id']);

    if ($contact['gender'] === 'male') {
        $contact['gender'] = 1;
    } elseif ($contact['gender'] === 'female') {
        $contact['gender'] = 2;
    } else {
        $contact['gender'] = 3;
    }
    Contact::create($contact);

    return view('thanks');

  }



}

