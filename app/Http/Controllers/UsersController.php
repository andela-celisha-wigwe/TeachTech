<?php

namespace TeachTech\Http\Controllers;

use Illuminate\Http\Request;

use TeachTech\Http\Requests;
use TeachTech\User;
use Auth;
use \Input as Input;
use Validator;
use TeachTech\Video;
use TeachTech\Category;

class UsersController extends Controller
{
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

    protected function validateImage($data)
    {
        return Validator::make($data, [
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:150' // max 10000kb
        ]);
    }

    public function changeAvatar(Request $request)
    {
        if (Input::hasFile('file')) {
            $file  = Input::file('file');
        }
        
        $fileArray = ['image' => $file];

        $validator = $this->validateImage($fileArray);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        \Cloudinary::config([

          'cloud_name'  => 'dax1lcajn',
          'api_key'     => '724974163436624',
          'api_secret'  => 'LEGPtwbA-YFzAbfRsbOSK4Dvodc',

        ]);


        // \Cloudinary\Uploader::upload($_FILES["file"]["tmp_name"],
        // array(
        //    "public_id" => "sample_id",
        //    "crop" => "limit",
        //    "width" => "2000",
        //    "height" => "2000",
        //    "eager" => array(
        //                  array( "width" => 200, "height" => 200, 
        //                         "crop" => "thumb", "gravity" => "face",
        //                         "radius" => 20, "effect" => "sepia" ),
        //                  array( "width" => 100, "height" => 150, 
        //                         "crop" => "fit", "format" => "png" )
        //                ),                                     
        //    "tags" => array( "special", "for_homepage" )
        // ));

        $result = \Cloudinary\Uploader::upload($file, [
            'crop' => 'limit',
            'width' => '140',
            'height' => '140',
        ]);
        $user = Auth::user();
        $user->avatar = $result['url'];
        $user->save();
        return redirect()->back();
    }

    public function updateUser(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        if ($user->update($data)) {
            return redirect('home');
        }
    }
}
