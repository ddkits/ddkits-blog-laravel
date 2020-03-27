<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;

class ProfileCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = DB::table('users')->where('id', Auth::user()->id)->first();
        $profileInfo = Profile::where('uid', $user->id);
        return view('profile.index')->with([
            'user' => $user,
            'Profile' => $profileInfo,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $profile = Profile::find($id);
        if (!empty($profile->uid)) {
            $user = User::find($profile->uid);
            return view('profile.show')->with([
                'Profile'=>$profile,
                'user'=>$user,
            ]);
        }else{
            return redirect('/profile');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::find($id);
        return view('profile.edit')->withProfile($profile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate the data
        $this->validate($request, array(
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'job_title' => 'required|string|max:255',
            'password' => 'required|string|min:3',
            ));

        // save user profile
        ProfileCont::updateUserProfile($request, $id);
        // save user info 
        ProfileCont::updateUserInfo($request, $request->uid);
       
        Session::flash('Success', 'Profile Saved successfully!');
        return redirect()->route('profile.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProfInfo($id)
    {
        $profileInfo = Profile::find($id);
        return $profileInfo;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserInfo($id)
    {
        $userInfo = User::find($id);
        return $userInfo;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getFriendsPosts($id)
    {
        $userInfo = User::find($id);
        return $userInfo;
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getFriends($id)
    {
        $userInfo = User::find($id);
        return $userInfo;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function updateUserInfo($Request, $id)
    {
        $user = User::find($id);
        if ($Request->password ) {
            if (bcrypt($Request->password) === $user->password) {
                // $user->email = $Request->email;
                $user->firstname = $Request->firstname;
                $user->lastname = $Request->lastname;
                $user->job_title = $Request->job_title;
                $user->industry = $Request->industry;
                
                // if the user changes his password save it too
                 if ($Request->new_password ) {
                   $table->password = bcrypt($Request->password);
                 }

                $user->updated_at = date('Y-m-d H:i:s');
                 $user->save();  
            }
           
         }  
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function updateUserProfile($request, $id)
    {
        $profile = Profile::find($id);
        $profile->uid = $request->uid;
    if(!empty($request->file('image'))){
          $file = $request->file('image');
          //Move Uploaded File
          $destinationPath = 'uploads/profile/' . $id;
          $file->move($destinationPath,$id . '-' . $file->getClientOriginalName());
          $saveFile = $destinationPath . '/' . $id . '-' . $file->getClientOriginalName();
          $profile->picture = $saveFile;
      }
        $profile->description = $request->input('description');
        $profile->save();
    }
}
