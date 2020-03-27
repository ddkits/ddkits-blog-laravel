<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Likes;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Followers;
use App\Http\Controllers\LikedByUser;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;

class FollowersCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addFollower($uid, $who)
    {
           DB::table('followers')->insert([
            'who'=> $who, 
            'uid'=>$uid,
                ]);
           Session::flash('succeess', 'followed');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $addFollower = DB::table('followers')->where(['who'=> $request->who, 'uid'=>$request->uid])->first();
        if (empty($addFollower)) {
            FollowersCont::addFollower($request->uid, $request->who);
        }else{
            FollowersCont::destroy($request->uid, $request->who);
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkIfFollowed(Request $request)
    {
        $addFollower = DB::table('followers')->where(['who'=> $request->who, 'uid'=>$request->uid])->first();
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFollowers($uid)
    {
        $followers = DB::table('followers')->where(['who'=> $uid])->count();
        return $followers;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid, $who)
    {
        DB::table('followers')->where(['who'=> $who, 'uid'=>$uid])->DELETE();
        Session::flash('succeess', 'Unfollowed');
    }
}
