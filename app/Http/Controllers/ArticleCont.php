<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;
use App\Comments;
use App\Profile;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;

class ArticleCont extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gotoArticles(Request $request)
    {
        $id = \Request::get('id'); 
        return $this->show($id);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('id', $id)->first();
        $comments = DB::table('comments')->where('nid', $id)->get();
        $tags = App(\App\Http\Controllers\PostCont::class)->nTags($id, 'blog');
        $categories = App(\App\Http\Controllers\PostCont::class)->nCategories($id, 'blog');
        if ($categories) {
            $cats = implode(', ', $categories);
        }else{
            $cats = '';
        }
        if ($tags) {
            $tags = implode(', ', $tags);
        }else{
            $tags = '';
        }
        $slug = $this->create_slug($post->title);

        return view('blog.article')->with([
            'post'=>$post,
            'comments'=> $comments,
            'nTags' =>$tags,
            'nCategories' => $cats,
            'slug' => $slug 
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTitle($slug = false) 
    {
        $post = Post::where('path', $slug)->first();
        $comments = DB::table('comments')->where('nid', $post->id)->get();
        $tags = App(\App\Http\Controllers\PostCont::class)->nTags($post->id, 'blog');
        $categories = App(\App\Http\Controllers\PostCont::class)->nCategories($post->id, 'blog');
        if ($categories) {
            $cats = implode(', ', $categories);
        }else{
            $cats = '';
        }
        if ($tags) {
            $tags = implode(', ', $tags);
        }else{
            $tags = '';
        }
        

        return view('blog.article')->with([
            'post'=>$post,
            'comments'=> $comments,
            'nTags' =>$tags,
            'nCategories' => $cats,
            'slug' => $slug 
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
    public function destroy($id)
    {
        //
    }

    public function create_slug($string = false)
    {

        // if no string
        if($string == null){
            return false;
        }

            $string = preg_replace( '/[«»""!?,.!@£$%^&*{};:()]+/', '', $string );
            $string = strtolower($string);
            $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug;
     }

}
