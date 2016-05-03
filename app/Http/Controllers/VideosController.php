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
        $videos = Video::latest()->paginate(18);
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
            $request->session()->flash('error', 'Login or register to post a video.');
            return redirect('login');
        }
        $user = Auth::user();

        $data = $request->all();
        $validator = $this->validateVideo($data);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        $user->videos()->create($data);
        return redirect('home');
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $video = Video::find($id);
        $comments = $video->comments()->latest()->paginate(4);
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

    public function search(Request $request)
    {
        $data = $request->all();
        $toSearch = $data['search'];
        $videos = Video::where('title', 'LIKE', "%$toSearch%")->latest()->paginate(5);
        return view('videos.index', compact('videos'));
    }

    public function like(Request $request)
    {
        $id = $request->id;
        $video = Video::find($id);

        $liked = $video->favorites()->where('user_id', Auth::user()->id)->first();

        if ($liked == null) {
            $liked = $video->favorites()->create([
                        'user_id' => Auth::user()->id,
                    ]);
        }
        $liked->status = 1;
        $liked->save();

        return redirect()->back();
    }

    public function unlike(Request $request)
    {
        $id = $request->id;
        $video = Video::find($id);
        $liked = $video->favorites()->where('user_id', Auth::user()->id)->first();
        $liked->status = 0;
        $liked->save();

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $video = Video::find($id);
        $user = Auth::user();

        if ($user->cannnotHandle($video)) {
            $request->session()->flash('error', 'Not allowed');
            return redirect()->to('/videos');
        }

        $video->delete();

        $request->session()->flash('success', 'Video Deleted');
        return redirect()->back();
    }

}
