<?php

namespace TeachTech\Http\Controllers;

use Illuminate\Http\Request;

use TeachTech\Http\Requests;
use TeachTech\Category;
use Auth;
use Validator;

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

    public function add(Request $request)
    {
        if(Auth::user() == null || Auth::user()->isNotAdmin()) {
            $request->session()->flash('error', 'Not Allowed.');
            return redirect()->back();
        }

        return view('categories.add');
    }

    public function create(Request $request)
    {
        $data = $request->all();

        if(Auth::user() == null || Auth::user()->isNotAdmin()) {
            $request->session()->flash('error', 'Not Allowed.');
            return redirect()->back();
        }

        $validator = $this->validateCategory($data);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        $user = Auth::user();
        $category = $user->categories()->create($data);

        $request->session()->flash('success', 'Category added.');
        return redirect()->action('CategoriesController@show', compact('category'));
    }

    public function edit(Request $request)
    {
        if(Auth::user() == null) {
            $request->session()->flash('error', 'Please Login');
            return redirect()->to('login');
        }

        $id = $request->id;
        $category = Category::find($id);

        if(Auth::user()->isNotAdmin() || Auth::user()->cannnotHandle($category)) {
            $request->session()->flash('error', 'Not Allowed.');
            return redirect()->back();
        }

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = $request->all();

        if(Auth::user() == null || Auth::user()->isNotAdmin()) {
            $request->session()->flash('error', 'Not Allowed.');
            return redirect()->back();
        }

        $category = Category::find($id);
        if(Auth::user()->cannnotHandle($category)) {
            $request->session()->flash('error', 'Not Allowed.');
            return redirect()->back();
        }

        $validator = $this->validateCategory($data);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        $category->update($data);

        $request->session()->flash('success', 'Category updated.');
        return redirect()->back();
    }

    protected function validateCategory(array $data)
    {
        return Validator::make($data, [
            'name'      =>  'required|max:15',
            'brief'     =>  'required|max:255',
        ]);
    }
}
