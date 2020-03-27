<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Likes;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Http\Controllers\LikedByUser;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;

class LikeCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addLike(Request $request)
    {
        $nid = \Request::get('nid');
        $uid = \Request::get('uid');
        $type = \Request::get('type');
        $nidLiked = DB::table('likes')->where(['nid'=>$nid])->first();
        if (!empty($nidLiked)) {
                $nidLikedByUser = DB::table('liked_by_users')->where(['nid'=>$nid, 'uid'=>$uid])->first();
                if (empty($nidLikedByUser)) {
                // type must be string ex.'post' or 'propost'
                    LikeCont::update($request);

                }else{
                    LikeCont::updateDelete($request);
                }
        }else{

            DB::table('likes')
                    ->where('nid', $request->nid)
                    ->insert([
                        'nid'=>$nid,
                        'type'=>$type,
                        'likes'=>1
                    ]);
              DB::table('liked_by_users')
                ->insert(['nid'=>$nid, 'uid'=>$uid, 'type'=>$type]);
        }
        return redirect()->back();

        session::flash('success', 'like success');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getLikes($nid, $type)
    {
        $likes = DB::table('likes')->where(['nid'=> $nid, 'type'=>$type])->first();
        if (empty($likes)) {
           $result = 0;
        }else{
           $result = $likes->likes;
        }
        return $result;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nidLiked = DB::table('liked_by_users')->where(['nid'=>$request->nid, 'uid'=>$request->uid])->first();
        if (empty($nidLiked)) {
        // type must be string ex.'post' or 'propost'
            LikeCont::update($request);

        }else{
            LikeCont::updateDelete($request);
        }

            return redirect()->back();

        session::flash('success', 'like success');
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
    public function update(Request $request)
    {
        $likes = DB::table('likes')->where('nid', $request->nid)->first();
        if (!empty($likes)) {
              DB::table('likes')
                    ->where('nid', $request->nid)
                    ->update(['likes' => ($likes->likes + 1)]);
              DB::table('liked_by_users')
                ->insert(['nid'=>$request->nid, 'uid'=>$request->uid, 'type'=>$request->type]);
        }else{
             DB::table('likes')
                    ->insert(['nid'=> $request->nid, 'likes' => 1, 'type'=>$request->type]);
              DB::table('liked_by_users')
                ->insert(['nid'=>$request->nid, 'uid'=>$request->uid, 'type'=>$request->type]);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDelete(Request $request)
    {
        $likes = DB::table('likes')->where('nid', $request->nid)->first();
        if($likes){
                DB::table('likes')
                    ->where('nid', $request->nid)
                    ->update(['likes' => ($likes->likes - 1)]);
                    if ($likes->likes <= 0) {
                     DB::table('likes')
                        ->where('nid', $request->nid)
                        ->update(['likes' => 0]);
                    }
        }
        DB::table('liked_by_users')->where(['nid'=>$request->nid, 'uid'=>$request->uid])->DELETE();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Likes::find($id);
    }
    
}
