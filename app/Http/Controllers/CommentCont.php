<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
use Session;

class CommentCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comments::all();
        return $comments;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOnePost($nid, $type)
    {
        $comments = Comments::where('nid', $nid)->where('type', $type)->orderby('id', 'DESC')->paginate(3);
        return $comments;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOnePostAll($nid, $type)
    {
        $comments = Comments::where('nid', $nid)->orderby('id', 'DESC')->where('type', $type)->get();
        return $comments;
    }

    public function indexOnePostCount($nid, $type)
    {
        $commentsCount = Comments::where('nid', $nid)->where('type', $type)->count();
        return $commentsCount;
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
        // important request fields is where to go after the submit
        // {{ Form::text('redirect', 'blog.show') }}
        // {{ Form::number('redirectID', $post->id ) }}


        // validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'body' => 'required',
            'uid' => 'required',
            'nid' => 'required',
            ));

        // store
        $comment = new Comments;
        $comment->title = $request->title;
        $comment->body = $request->body;
        $comment->uid = $request->uid;
        $comment->nid = $request->nid;
        $comment->type = $request->type;
        $comment->tags = ($request->tags) ? $request->tags : '';
        $comment->save();

        Session::flash('Success', 'Comment created successfully!');
        // redirect must come from the module that is using this comment

        return redirect()->back();
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
    public function destroy($id)
    {
        //
    }
}
