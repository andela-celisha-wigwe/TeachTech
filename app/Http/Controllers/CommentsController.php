<?php

namespace TeachTech\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use TeachTech\Comment;
use Auth;
use TeachTech\Video;

use TeachTech\Http\Requests;

class CommentsController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        $validator = $this->validateComment($data);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()->back()->withErrors($messages);
        }

        $video = Video::find($data['comment_video']);

        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->video_id = $video->id;
        $comment->user_id = Auth::user()->id;
        $comment->save();

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        // $comment = Comment::find($id);
        // $video = $comment->video;
        Comment::destroy($id);
        // return json_encode(true);
        // return redirect()->back();
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $validator = $this->validateComment($data);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()->back()->withErrors($messages);
        }

        $id = $request->id;

        $comment = Comment::find($id);
        $comment->comment = $data['comment'];
        $comment->save();

        return redirect()->back();
    }

    protected function validateComment(array $data)
    {
        return Validator::make($data, [
            'comment'         => 'required|max:255',
        ]);
    }
}
