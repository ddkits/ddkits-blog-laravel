<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\ProPosts;
use Illuminate\Support\Facades\DB;
use App\Comments;
use App\Profile;
use App\admin;
use App\Http\Controllers\ShareCont;
use App\Http\Controllers\ProPostCont;
use App\Http\Controllers\PostCont;
use App\Http\Controllers\AdminCont;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;


class ShareCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addShare(Request $request)
    {
        $nid = \Request::get('nid');
        $uid = \Request::get('uid');
        $type = \Request::get('type');

        $nidLiked = DB::table('liked_by_users')->where(['nid'=>$nid, 'uid'=>$uid])->first();
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->type == 'blog') {
        	$share = ShareCont::reshareBlog($request);
        	
        }
        else if ($request->type == 'post') {
        	$share = ShareCont::reshareProPost($request);
        }
        return redirect()->route($share['route'], $share['id']);

        Session::flash('Success', 'Shared successfully!');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reshareProPost($request)
    {
        $user = Auth::user();
        $profileInfo = Profile::where('uid', $user->id);
        $originalPost = ProPosts::find($request->nid);

        // validate the data
        $this->validate($request, array(
            'uid' => 'required',
            'nid' => 'required',
            ));
        $body = app('App\Http\Controllers\AdminCont')->encoded($originalPost->body, 0, 300, 'yes');
        // store
        if ($request->shared) {
           $post = new ProPosts;
           $post->shared = $request->shared;
           $post->body = $request->shared;
           $post->uid = $request->uid;
            $post->save();
        }else{
             $post = new ProPosts;
                $post->shared = '<div class="well d-flex align-items-center col-md-12"><a href="/blog/' . $originalPost->id . '"> <div id="reshare-body" height="150px" width="300">' . $body .  '<br><div class="pull-right" id="reshare-author">By: ' . User::find($originalPost->uid)->firstname . ' ' . User::find($originalPost->uid)->lastname .  '</div></div></a></div>';
                $post->body = '<div class="well d-flex align-items-center col-md-12"><a href="/blog/' . $originalPost->id . '"> <div id="reshare-body" height="150px" width="300">' . $body .  '<br><div class="pull-right" id="reshare-author">By: ' . User::find($originalPost->uid)->firstname . ' ' . User::find($originalPost->uid)->lastname .  '</div></div></a></div>';
                $post->uid = $request->uid;
                $post->save();
        }
       

        // add views record for this post must be always for posts no reshare on blogs table
        DB::table('pro_views')->insert(
                ['nid' => $post->id, 'views' => 0]
            );
        
        $share = ['route'=> 'posts.show', 'id'=>$post->id];
        // redirect
        return $share;
    }
    public function reshareBlog($request)
    {
    	$user = Auth::user();
        $profileInfo = Profile::where('uid', $user->id);
        $originalPost = Post::find($request->nid);

    	// validate the data
        $this->validate($request, array(
            'uid' => 'required',
            'nid' => 'required',
            ));
        $body = app('App\Http\Controllers\AdminCont')->encoded($originalPost->body, 0, 300, 'yes');
    	// store
        // store
        if ($request->shared) {
           $post = new ProPosts;
           $post->shared = $request->shared;
           $post->body = $request->shared;
           $post->uid = $request->uid;
            $post->save();
        }else{
        $post = new ProPosts;
            $post->body = '<div class="well d-flex align-items-center col-md-12"><a href="/blog/' . $originalPost->id . '"><div class="pull-left col-md-4"><img id="reshare-image" class=" img-thumbnail" alt="' . User::find($originalPost->uid)->firstname . ' ' . User::find($originalPost->uid)->lastname .  '" width="304" height="236" src="/' . $originalPost->image . '"></div><div id="text"><h3>' . $originalPost->title . '</h3><br> <div id="reshare-body" height="150px" width="300">' . $body .  '</div> <br></div><div class="pull-right" id="reshare-author">By: ' . User::find($originalPost->uid)->firstname . ' ' . User::find($originalPost->uid)->lastname .  '</div></a></div>';
            $post->shared = '<div class="well d-flex align-items-center col-md-12"><a href="/blog/' . $originalPost->id . '"><div class="pull-left col-md-4"><img id="reshare-image" class=" img-thumbnail" alt="' . User::find($originalPost->uid)->firstname . ' ' . User::find($originalPost->uid)->lastname .  '" width="304" height="236" src="/' . $originalPost->image . '"></div><div id="text"><h3>' . $originalPost->title . '</h3><br> <div id="reshare-body" height="150px" width="300">' . $body .  '</div> <br></div><div class="pull-right" id="reshare-author">By: ' . User::find($originalPost->uid)->firstname . ' ' . User::find($originalPost->uid)->lastname .  '</div></a></div>';
            $post->uid = $request->uid;
            $post->save();
        }
        // add views record for this post must be always for posts no reshare on blogs table
        DB::table('pro_views')->insert(
                ['nid' => $post->id, 'views' => 0]
            );
        
        $share = ['route'=> 'posts.show', 'id'=>$post->id];
        // redirect
        return $share;
    }

}
