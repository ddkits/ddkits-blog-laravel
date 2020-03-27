<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Likes;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Friends;
use App\Http\Controllers\LikedByUser;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FriendsCont;
use Session;

class friendsCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userFriends = DB::table('friends')->where('uid1', $user->id)->orwhere('uid2', $user->id)->get();
        return view('friends.index')->with([
            'friendsList' => $userFriends,
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addFriend($uid1, $uid2)
    {
           DB::table('friends')->insert([
            'uid1'=> $uid1, 
            'uid2'=>$uid2,
                ]);
           
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $addFriends = DB::table('friends')->where(['uid1'=> $request->uid1, 'uid2'=>$request->uid2])->first();
        if (empty($addFriends)) {
            FriendsCont::addFriend($request->uid1, $request->uid2);
        }else{
            FriendsCont::destroy($request->uid1, $request->uid2);
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkIfFriends($uid1, $uid2)
    {
        $isFriend = DB::table('friends')->where(['uid1'=> $uid1, 'uid2'=>$uid2])->orwhere(['uid2'=> $uid1, 'uid1'=>$uid2])->first();
        if ($isFriend) {
            
            if ($isFriend->status === 1) {
               $isFriendconfirmed = 'yes';
            }else{
                $isFriendconfirmed = 'notYet';
            }
        }else{
            $isFriendconfirmed = 'no';
        }
        return $isFriendconfirmed;
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getfriends($uid)
    {
        $friends = DB::table('friends')->where(['uid1'=>$uid, 'status'=>1])->orwhere(['uid2'=>$uid, 'status'=>1])->get();
        return $friends;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getfriendsCount($uid)
    {
        $friends = DB::table('friends')->where(['uid1'=>$uid, 'status'=>1])->orwhere(['uid2'=>$uid, 'status'=>1])->count();
        return $friends;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getFriendsInfo($uid1, $uid2)
    {
        $isFriend = DB::table('friends')->where(['uid1'=> $uid1, 'uid2'=>$uid2])->orwhere(['uid2'=> $uid1, 'uid1'=>$uid2])->first();
        return $isFriend;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function friendsConfirm(Request $request)
    {
        DB::table('friends')->where('id', $request->id)->update(['status'=>1]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('friends')->where(['id'=> $id])->DELETE();
        
    }
}
