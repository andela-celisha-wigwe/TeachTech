<?php

namespace TeachTech\Http\Controllers;

use Illuminate\Http\Request;

use TeachTech\Http\Requests;
use TeachTech\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
}
