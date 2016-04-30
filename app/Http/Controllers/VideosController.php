<?php

namespace TeachTech\Http\Controllers;

use Illuminate\Http\Request;

use TeachTech\Http\Requests;
use TeachTech\Video;
use Validator;
use TeachTech\Comment;
use Auth;

class VideosController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view('videos.index', compact('videos'));
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $video = Video::find($id);
        $comments = $video->comments()->get();
        return view('videos.show', compact('video', 'comments'));
    }

}
