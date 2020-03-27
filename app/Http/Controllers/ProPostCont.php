<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Controllers\Controller;
use App\Profile;
use App\ProPosts;
use App\Commments;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;


class ProPostCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
       $post = ProPosts::find($id);
        $comments = DB::table('comments')->where('nid', $id)->where('type', 'pro_post')->get();
        $user = User::find($post->uid);
        $profileInfo = Profile::where('uid', $user->id);
        return view('posts.show')->with([
            'user' => $user,
            'Profile' => $profileInfo,
            'post' => $post,
            'comments' => $comments,
            ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserProPosts($uid)
    {
        $proPosts = ProPosts::where('uid', $uid)->orderby('id', 'desc')->paginate(20);
        return $proPosts;
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserPosts($uid)
    {
        $Posts = Post::where('uid', $uid)->orderby('id', 'desc')->paginate(20);
        return $Posts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserProAllPosts($uid)
    {
        $proPosts = ProPosts::where('uid', $uid)->orderby('id', 'desc')->paginate(20);
        return $proPosts;
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
        $proPost = new ProPosts();
        $proPost->uid = $request->uid;
        $proPost->body = $request->body;
        $proPost->public = $request->public;
        $proPost->save();

        // add views record for this post
        DB::table('pro_views')->insert(
                ['nid' => $proPost->id, 'views' => 0]
            );
        Session::flash('Success', 'Post Shared');
        return redirect()->route('profile.show', $proPost->uid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = ProPosts::find($id);
        $comments = DB::table('comments')->where('nid', $id)->where('type', 'pro_post')->get();
        $user = DB::table('users')->where('id', $post->uid)->first();
        $profileInfo = Profile::where('uid', $user->id);
        return view('posts.show')->with([
            'user' => $user,
            'Profile' => $profileInfo,
            'post' => $post,
            'comments' => $comments,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */

    public function edit($id)
    {
        $post = ProPosts::find($id);
        $comments = DB::table('comments')->where('nid', $id)->where('type', 'pro_post')->get();
        $user = DB::table('users')->where('id', $post->uid)->first();
        $profileInfo = Profile::where('uid', $user->id);
        return view('posts.edit')->with([
            'post'=>$post,
            'user'=>$user,
            'profile'=>$profileInfo,
            ]);
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
        $proPost = ProPosts::find($id);
        $proPost->uid = $request->uid;
        $proPost->body = $request->body;
        $proPost->public = $request->public;
        $proPost->save();

        Session::flash('Success', 'Post Shared');
        return redirect()->route('posts.show', $proPost->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $profileID = DB::table('profiles')->where('uid', Auth::user()->id)->first();
         ProPosts::destroy($id);
         DB::table('pro_views')->where('nid', $id)->DELETE();
          Session::flash('Success', 'Post Deleted');
        return redirect()->route("profile.show", $profileID->id);
       
    }

    public function getUserProPostsCount($uid)
    {
        // create a variable and store in it from the database 
            // $blogs = Post::all();

            $postsc = DB::table('pro_posts')->where('uid', $uid)->count();
            return $postsc;
        // return a view and pass in the above variable 
    }
}
