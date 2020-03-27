<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Feeds;
use Illuminate\Support\Facades\DB;
use App\Comments;
use App\Profile;
use App\userFiles;
use App\postTags;
use App\postCategories;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;

class PostCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable and store in it from the database
        $blogs = Post::orderby('id', 'desc')->paginate(10);
        return view('blog.index')->with([
            'blogs' => $blogs,
        ]);
        // return a view and pass in the above variable
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHomeBlogs()
    {
        // create a variable and store in it from the database
        $blogs = Post::orderby('id', 'desc');
        // $feeds = Feeds::orderby('id', 'desc');
        // $blogs =  $blog->merge($feeds);

        // DB::table('Post')
        //     ->innerJoin('Feeds')
        //     ->get();

        return $blogs;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBlogs()
    {
        // create a variable and store in it from the database
        $blogs = Post::orderby('id', 'desc')->where('homepage', 1);
        return $blogs;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHeaderBlogs($num = 3)
    {
        // create a variable and store in it from the database
        $blogs = Post::orderby('id', 'desc')->where('homepage', 2);
        return $blogs;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTopBlogs()
    {
        $topBlog = null;
        $topBlogs = [];
        $getViews = DB::table('views')->orderby('views', 'DESC')->get();
        if ($getViews) {
            foreach ($getViews as $post) {
                $topBlog = Post::where('id', $post->nid)->first();
                if (!empty($topBlog)) {
                    $topBlogs[] = ['id' => $topBlog->id, 'title' => $topBlog->title, 'body' => $topBlog->body, 'date' => $topBlog->created_at];
                }
            }
        }
        return $topBlogs;
        // return a view and pass in the above variable
    }

    public function indexMe()
    {
        // create a variable and store in it from the database
        // $blogs = Post::all();

        $blogs = DB::table('posts')->where('uid', Auth::user()->id)->orderby('id', 'desc')->get();

        return view('blog.index')->withBlogs($blogs);
        // return a view and pass in the above variable
    }

    public function getUserBlogs($uid)
    {
        // create a variable and store in it from the database
        // $blogs = Post::all();

        $blogs = DB::table('posts')->where('uid', $uid)->orderby('id', 'desc')->get();

        return $blogs;
        // return a view and pass in the above variable
    }

    public function getUserBlogsCount($uid)
    {
        // create a variable and store in it from the database
        // $blogs = Post::all();

        $blogsc = DB::table('posts')->where('uid', $uid)->count();
        if ($blogsc) {
            $count = $blogsc;
        } else {
            $count = 0;
        }
        return $count;
        // return a view and pass in the above variable
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categories();
        $tags = $this->tags();
        $user = User::find(Auth::user()->id);
        $profileInfo = Profile::where('uid', $user->id);
        return view('blog.create')->with([
            'user' => $user,
            'profile' => $profileInfo,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myPosts()
    {
        return;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $UserFilesCont = new userFiles;
        // validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'body' => 'required',
            'uid' => 'required',
            'image' => 'max:2000|mimes:jpg,png,gif,jpeg,svg',
        ));

        $slug = $this->create_slug($request->title);
        // check image file
        $destinationPath = 'uploads/files/' . $request->uid;
        if (!empty($request->file('image'))) :

            $file = $request->file('image');
            $checkFile = userFiles::where('ftype', $file->getClientOriginalName());
            if ($checkFile->count() > 0) {
                $file = $checkFile->first();
                $saveFile = $file->file;
            } else {

                //Move Uploaded File
                $file->move($destinationPath, $file->getClientOriginalName());
                $saveFile = $destinationPath . '/' . $file->getClientOriginalName();

                // start saving the file
                $fileDB = new userFiles;
                $fileDB->uid = $request->uid;
                $fileDB->nid = null;
                $fileDB->ntype = 'blog';
                $fileDB->file = $saveFile;
                $fileDB->ftype = $file->getClientOriginalName();
                $fileDB->save();
                $saveFile = $fileDB->file;
            } else :
            $saveFile = 'img/blogImage.png';
        endif;

        // check image file
        $files = $request->file('files');
        $saveFilesA = '';

        if (!empty($request->file('files'))) :
            foreach ($files as $filea) {
                $fileDes = $destinationPath . '/' . $filea->getClientOriginalName();
                $checkFile = userFiles::where('file', $fileDes);
                if ($checkFile->count() > 0) {
                    $filea = $checkFile->first();
                    $saveFilesA = '1';
                } else {
                    //Move Uploaded File
                    $filea->move($destinationPath, $filea->getClientOriginalName());
                    $saveFile = $destinationPath . '/' . $filea->getClientOriginalName();
                    // start saving the file
                    $fileDB = new userFiles;
                    $fileDB->uid = $request->uid;
                    $fileDB->nid = null;
                    $fileDB->ntype = 'blog';
                    $fileDB->file = $saveFile;
                    $fileDB->ftype = $filea->getClientOriginalName();
                    $fileDB->save();
                    $saveFilesA = '1';
                }
            }
        endif;
        // store
        $post = new Post;
        $post->title = $request->title;
        $post->path = $slug;
        $post->body = $request->body;
        $post->uid = $request->uid;
        $post->files = $saveFilesA;
        $post->image = $saveFile;

        $post->save();


        // save categories and tags
        // remove and add in case of TAGS
        if (!empty($request->tags)) {
            DB::table('post_tags')->where(['nid' => $post->id, 'type' => 'blog'])->delete();
            foreach ($request->tags as $key => $value) {
                $newTag = new postTags;
                $newTag->type = 'blog';
                $newTag->tag = $value;
                $newTag->nid = $post->id;
                $newTag->uid = $request->uid;
                $newTag->save();
            }
        } else {
            DB::table('post_tags')->where(['nid' => $post->id, 'type' => 'blog'])->delete();
        }

        // categories
        if (!empty($request->categories)) {
            DB::table('post_categories')->where(['nid' => $post->id, 'type' => 'blog'])->delete();
            foreach ($request->categories as $key => $value) {
                $newTag = new postCategories;
                $newTag->type = 'blog';
                $newTag->category = $value;
                $newTag->nid = $post->id;
                $newTag->uid = $request->uid;
                $newTag->save();
            }
        } else {
            DB::table('post_tags')->where(['nid' => $post->id, 'type' => 'blog'])->delete();
        }


        // now update the file node id
        if (!empty($request->file('image'))) :
            DB::table('user_files')->where([
                'uid' => $request->uid,
                'file' => $saveFile
            ])->whereNull('nid')->update(
                ['nid' => $post->id]
            );
        endif;

        // update the files list to connect with the post
        if (!empty($files)) :
            foreach ($files as $key) {
                $checkFile = $destinationPath . '/' . $key->getClientOriginalName();
                // now update the file node id
                DB::table('user_files')->where([
                    'uid' => $request->uid,
                    'file' => $checkFile
                ])->whereNull('nid')->update(
                    ['nid' => $post->id]
                );
            }
        endif;
        // add views record for this post
        DB::table('views')->insert(
            ['nid' => $post->id, 'views' => 0]
        );
        Session::flash('Success', 'blog created successfully!');
        // redirect

        return redirect()->route('blog.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // myFiles list for each user
        $myFiles = userFiles::where('nid', $id)->orderBy('created_at', 'desc');
        $post = Post::find($id);
        $user = User::find($post->uid);
        $nTags = $this->nTags(['nid' => $id, 'type' => 'blog']);
        $tags = $this->tags();
        $nCategories = $this->nCategories(['nid' => $id, 'type' => 'blog']);
        $categories = $this->categories();
        $profileInfo = Profile::where('uid', $user->id);
        $comments = DB::table('comments')->where('nid', $id)->where('type', 'blog')->get();
        return view('blog.show')->with([
            'post' => $post,
            'comments' => $comments,
            'user' => $user,
            'Profile' => $profileInfo,
            'files' => $myFiles,
            'nCategories' => $nCategories,
            'nTags' => $nTags,
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
        // myFiles list for each user
        $myFiles = userFiles::where('nid', $id)->orderBy('created_at', 'desc');
        // find the post in the database and save it in variable
        $nCategories = $this->nCategories(['nid' => $id, 'type' => 'blog']);
        $categories = $this->categories();
        $nTags = $this->nTags(['nid' => $id, 'type' => 'blog']);
        $tags = $this->tags();
        $post = Post::find($id);
        $comments = DB::table('comments')->where('nid', $id)->where('type', 'blog')->get();
        $user = DB::table('users')->where('id', $post->uid)->first();
        $profileInfo = Profile::where('uid', $user->id);
        return view('blog.edit')->with([
            'post' => $post,
            'user' => $user,
            'profile' => $profileInfo,
            'files' => $myFiles,
            'tags' => $tags,
            'categories' => $categories,
            'nCategories' => $nCategories,
            'nTags' => $nTags
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
        // validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'body' => 'required'
        ));

        $slug = $this->create_slug($request->input('title'));
        // check image file
        $destinationPath = 'uploads/files/' . $request->uid;
        if (!empty($request->file('image'))) :

            $file = $request->file('image');
            $checkFile = userFiles::where('ftype', $file->getClientOriginalName());
            if ($checkFile->count() > 0) {
                $file = $checkFile->first();
                $saveFile = $file->file;
            } else {

                //Move Uploaded File
                $file->move($destinationPath, $file->getClientOriginalName());
                $saveFile = $destinationPath . '/' . $file->getClientOriginalName();

                // start saving the file
                $fileDB = new userFiles;
                $fileDB->uid = $request->uid;
                $fileDB->nid = null;
                $fileDB->ntype = 'blog';
                $fileDB->file = $saveFile;
                $fileDB->ftype = $file->getClientOriginalName();
                $fileDB->save();
                $saveFile = $fileDB->file;
            } else :
            $saveFile = 'img/blogImage.png';
        endif;

        // check image file
        $files = $request->file('newfiles');
        $saveFilesA = '';

        if (!empty($files)) :
            foreach ($files as $filea) {
                $fileDes = $destinationPath . '/' . $filea->getClientOriginalName();
                $checkFile = userFiles::where('file', $fileDes);
                if ($checkFile->count() > 0) {
                    $filea = $checkFile->first();
                    $saveFilesA = '1';
                } else {
                    //Move Uploaded File
                    $filea->move($destinationPath, $filea->getClientOriginalName());
                    $saveFile = $destinationPath . '/' . $filea->getClientOriginalName();
                    // start saving the file
                    $fileDB = new userFiles;
                    $fileDB->uid = $request->uid;
                    $fileDB->nid = null;
                    $fileDB->ntype = 'blog';
                    $fileDB->file = $saveFile;
                    $fileDB->ftype = $filea->getClientOriginalName();
                    $fileDB->save();
                    $saveFilesA = '1';
                }
            }
        endif;


        // save the data to tthe database
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->path = $slug;
        $post->body = $request->input('body');
        if (!empty($request->file('image'))) :
            $post->image = $saveFile;
        endif;
        if (!empty($request->file('files'))) :
            $post->files = $saveFileA;
        endif;
        $post->save();
        // save categories and tags
        // remove and add in case of TAGS
        if (!empty($request->tags)) {
            DB::table('post_tags')->where(['nid' => $post->id, 'type' => 'blog'])->delete();
            foreach ($request->tags as $key => $value) {
                $newTag = new postTags;
                $newTag->type = 'blog';
                $newTag->tag = $value;
                $newTag->nid = $post->id;
                $newTag->uid = $request->uid;
                $newTag->save();
            }
        } else {
            DB::table('post_tags')->where(['nid' => $post->id, 'type' => 'blog'])->delete();
        }

        // categories
        if (!empty($request->categories)) {
            DB::table('post_categories')->where(['nid' => $post->id, 'type' => 'blog'])->delete();
            foreach ($request->categories as $key => $value) {
                $newTag = new postCategories;
                $newTag->type = 'blog';
                $newTag->category = $value;
                $newTag->nid = $post->id;
                $newTag->uid = $request->uid;
                $newTag->save();
            }
        } else {
            DB::table('post_tags')->where(['nid' => $post->id, 'type' => 'blog'])->delete();
        }

        // now update the file node id
        if (!empty($request->file('image'))) :
            DB::table('user_files')->where([
                'uid' => $request->uid,
                'file' => $saveFile
            ])->whereNull('nid')->update(
                ['nid' => $post->id]
            );
        endif;

        // update the files list to connect with the post

        if (!empty($files)) :
            foreach ($files as $key) {
                $checkFile = $destinationPath . '/' . $key->getClientOriginalName();
                // now update the file node id
                DB::table('user_files')->where([
                    'uid' => $request->uid,
                    'file' => $checkFile
                ])->whereNull('nid')->update(
                    ['nid' => $post->id]
                );
            }
        endif;
        // set flash data with success msg
        Session::flash('Success', 'blog updated successfully!');
        // redirect
        return redirect()->route('blog.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('views')->where('nid', $id)->DELETE();
        Post::destroy($id);
        return redirect()->route("blog.index");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nTags($nid, $type = false)
    {
        if ($type) {
            $tags = DB::table('post_tags')->where(['nid' => $nid, 'type' => $type])->get();
            $final = [];
            foreach ($tags as $key) {
                $final[$key->tag] = $key->tag;
            }

            return $final;
        } else {
            $tags = DB::table('post_tags')->where('nid', $nid)->get();
            $final = [];
            foreach ($tags as $key) {
                $final[$key->tag] = $key->tag;
            }

            return $final;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tags($type = false)
    {
        if ($type) {
            $tags = DB::table('post_tags')->where('type', $type)->get();
            $final = [];
            foreach ($tags as $key) {
                if (!in_array($key->tag, $final)) {
                    $final[$key->tag] = $key->tag;
                }
            }
            return $final;
        } else {
            $tags = DB::table('post_tags')->get();
            $final = [];
            foreach ($tags as $key) {
                if (!in_array($key->tag, $final)) {
                    $final[$key->tag] = $key->tag;
                }
            }
            return $final;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nCategories($nid, $type = false)
    {
        if ($type) {
            $tags = DB::table('post_categories')->where(['nid' => $nid, 'type' => $type])->get();
            $final = [];
            foreach ($tags as $key) {
                $final[$key->category] = $key->category;
            }

            return $final;
        } else {
            $tags = DB::table('post_categories')->where('nid', $nid)->get();
            $final = [];
            foreach ($tags as $key) {
                $final[$key->category] = $key->category;
            }

            return $final;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categories($type = false)
    {
        if ($type) {
            $tags = DB::table('post_categories')->where('type', $type)->get();
            $final = [];
            foreach ($tags as $key) {
                if (!in_array($key->category, $final)) {
                    $final[$key->category] = $key->category;
                }
            }
            return $final;
        } else {
            $tags = DB::table('post_categories')->get();
            $final = [];
            foreach ($tags as $key) {
                if (!in_array($key->category, $final)) {
                    $final[$key->category] = $key->category;
                }
            }
            return $final;
        }
    }

    public function create_slug($string = false)
    {

        // if no string
        if ($string == null) {
            return false;
        }

        $string = preg_replace('/[«»""!?,.!@£$%^&*{};:()]+/', '', $string);
        $string = strtolower($string);
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postsRelated()
    {
        // create a variable and store in it from the database
        $postsRelated = DB::table('posts')->inRandomOrder();

        return $postsRelated;
    }
}
