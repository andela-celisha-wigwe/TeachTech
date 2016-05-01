<?php

namespace TeachTech\Http\Controllers;

use Illuminate\Http\Request;

use TeachTech\Http\Requests;
use TeachTech\Video;
use TeachTech\Category;
use Validator;
use TeachTech\Comment;
use Auth;

class VideosController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        $categories = Category::all();
        return view('videos.index', compact('videos', 'categories'));
    }

    /**
     * Get a validator for an incoming video addition request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateVideo(array $data)
    {
        return Validator::make($data, [
            'title'         => 'required|max:255',
            'description'   => 'required',
            'category_id'   => 'required',
            'url'           => array('required', 'regex:/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/i')
        ]);
    }


    public function createVideo(Request $request)
    {
        if (!(Auth::user())) {
            return redirect('login');
        }
        $user = Auth::user();

        $data = $request->all();
        $validator = $this->validateVideo($data);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        if ($user->videos()->create($data)) {
            return redirect('home');
        }
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $video = Video::find($id);
        $comments = $video->comments()->get();
        return view('videos.show', compact('video', 'comments'));
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $video = Video::find($id);
        $user = Auth::user();

        if ($user->cannnotHandle($video)) {
            $request->session()->flash('error', 'Not allowed');
            return redirect()->back();
        }

        return view('videos.edit', compact('video'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $video = Video::find($id);
        $data = $request->all();

        $validator = $this->validateVideo($data);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        $video->update($data);

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $video = Video::find($id);
        $user = Auth::user();

        if ($user->cannnotHandle($video)) {
            $request->session()->flash('error', 'Not allowed');
            return redirect()->back();
        }

        $video->delete();

        $request->session()->flash('success', 'Video Deleted');
        return redirect()->back();
    }

}
