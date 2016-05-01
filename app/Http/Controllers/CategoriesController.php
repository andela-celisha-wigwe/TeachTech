<?php

namespace TeachTech\Http\Controllers;

use Illuminate\Http\Request;

use TeachTech\Http\Requests;
use TeachTech\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();#->order_by();
        return view('categories.index', compact('categories'));
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        $videos = $category->videos()->paginate(18);//->get();

        return view('videos.index', compact('videos'));
    }
}
