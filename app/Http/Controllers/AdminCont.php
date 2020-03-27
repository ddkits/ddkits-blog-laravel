<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\admin;
use App\postTags;
use App\Post;
use App\usersAdmin;
use App\postCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Session;

class AdminCont extends Controller
{
    /**
     * Admin or not resource.
     *
     */
    public function getAdmin($id = false)
    {

        $userId = $id;
        // admin or not
        $admin = 0;
        $user = DB::table('admins')->where('uid', $userId)->first();
        if (!empty($user)) {
            $admin = 1;
        }

        return $admin;
    }
    /**
     * Admin or not resource.
     *
     */
    public function getAdminLevel()
    {

        $userId = Auth::user()->id;
        // admin or not
        $level = 99;
        $user = DB::table('admins')->where('uid', $userId)->first();
        if ($user !== null) {
            $level = $user->level;
        }

        return $level;
    }
    /**
     * Admin or not resource.
     *
     */
    public function adminInfo($id)
    {
        $info = DB::table('admins')->where('uid', $id)->first();
        return $info;
    }

    /**
     * Admin or not resource.
     *
     */
    public function homeMainMenu()
    {
        $info = DB::table('menus')->where('menu', 'homemainmenu')->orderBy('id', 'desc');
        return $info;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminSettings = DB::table('settings')->get();
        return view('admin.index')->with([
            'settings' => $adminSettings,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPostCategories()
    {
        $adminSettings = DB::table('settings')->get();
        $adminPostCategories = DB::table('post_Categories');

        return view('admin.index')->with([
            'settings' => $adminSettings,
            'adminPostCategories' => $adminPostCategories,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminComments()
    {
        $adminSettings = DB::table('settings')->get();
        $comments = DB::table('comments');

        return view('admin.index')->with([
            'settings' => $adminSettings,
            'adminComments' => $comments,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPostTags()
    {
        $adminSettings = DB::table('settings')->get();
        $adminPostTags = DB::table('post_tags');

        return view('admin.index')->with([
            'settings' => $adminSettings,
            'adminPostTags' => $adminPostTags,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminUsers()
    {
        $adminSettings = DB::table('settings')->get();
        $adminUsers = DB::table('users');
        $adminAdmins = DB::table('admins');

        return view('admin.users')->with([
            'settings' => $adminSettings,
            'adminUsers' => $adminUsers,
            'adminAdmins' => $adminAdmins,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPosts()
    {
        $adminSettings = DB::table('settings')->get();
        $adminUsers = DB::table('users');
        $adminPosts = DB::table('posts');
        return view('admin.posts')->with([
            'settings' => $adminSettings,
            'adminUsers' => $adminUsers,
            'adminPosts' => $adminPosts,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminProPosts()
    {
        $adminSettings = DB::table('settings')->get();
        $adminUsers = DB::table('users');
        $adminProPosts = DB::table('pro_posts');

        return view('admin.proposts')->with([
            'settings' => $adminSettings,
            'adminUsers' => $adminUsers,
            'adminProPosts' => $adminProPosts,

        ]);
    }


    // Storing functions for admins below
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPostCategoriesStore(Request $request)
    {
        $adminSettings = DB::table('settings')->get();
        $adminPostCategories = DB::table('post_Categories');

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminCommentsStore(Request $request)
    {
        $adminSettings = DB::table('settings')->get();
        $comments = DB::table('comments');


        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPostTagsStore(Request $request)
    {
        $adminSettings = DB::table('settings')->get();
        $adminPostTags = DB::table('post_tags');

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminUsersStore(Request $request)
    {
        if ($request) :
            $list = $request->user;
            foreach ($list as $user) {
                $saveUser = User::find($user['id']);

                // save users
                if ($saveUser) {
                    $saveUser->email = $user['email'];
                    $saveUser->username = $user['username'];
                    $saveUser->blocked = $user['blocked'];
                    $saveUser->save();



                    // check admins
                    if ($user['admin'] == 1) {

                        $admin = DB::table('admins')->where('uid', $user['id'])->first();
                        if (!$admin) {
                            $createAdmin = new usersAdmin;
                            $createAdmin->uid = $user['id'];
                            $createAdmin->level = 1;
                            $createAdmin->save();
                            Session::flash('Success', 'New Admin created.');
                        }
                    } else {
                        $admin = DB::table('admins')->where('uid', $user['id'])->first();

                        if ($admin) {
                            $deleteAdmin = DB::table('admins')->where([
                                'uid' => $user['id']
                            ])->delete();
                        }
                    }

                    // end if User exist
                }
            }
            Session::flash('Success', 'Settings Saved Successfully!');
        endif;


        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPostsStore(Request $request)
    {
        $posts = $request->homepage;
        foreach ($posts as $key => $value) {
            $post = Post::find($key);
            $post->homepage = $value;
            $post->save();
        }
        Session::flash('Success', 'Saved Successfully!');
        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminProPostsStore(Request $request)
    {
        $adminSettings = DB::table('settings')->get();
        $adminUsers = DB::table('users');
        $adminProPosts = DB::table('pro_posts');
        return redirect()->back();
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getValue($field)
    {
        $adminSettings = DB::table('settings')->where('field_name', $field)->first();
        if ($adminSettings) {
            return  $adminSettings->value;
        }
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
        $getConfig = admin::find($id);
        return $getConfig;
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
        $proPost = admin::find($id);
        $proPost->uid = $request->uid;
        $proPost->body = $request->body;
        $proPost->public = $request->public;
        $proPost->save();

        Session::flash('Success', 'Post Shared');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function createSettings(Request $request)
    {
        $this->validate($request, [
            'field_name' => 'string|max:255',
        ]);

        $check = DB::table('settings')->where('field_name', 'like', $request->field_name)->first();
        if ($check) {
            Session::flash('Success', 'This field already exist.');
            return redirect()->back();
        }
        DB::table('settings')->insert([
            'field_name' => $request->field_name,
            'value' => $request->value,
            'type' => $request->type,
            'updated_at' => date('Y-m-d H:i:s'),
            'uid' => $request->uid,
        ]);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function pathUpdate()
    {
        $posts = DB::table('posts')->where('path', NULL)->get();
        foreach ($posts as $key) {
            $slug = $this->create_slug($key->title);
            DB::table('posts')->where('title', $key->title)
                ->update([
                    'path' => $slug,
                ]);
        }

        Session::flash('Success', 'All paths updated.');
        return redirect()->back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function storeSettings(Request $request)
    {
        // sitename

        if ($request->sitename) {
            DB::table('settings')->where('field_name', 'sitename')->update([
                'value' => $request->sitename,
                'updated_at' => date('Y-m-d H:i:s'),
                'uid' => Auth::user()->id,
            ]);
        }

        if ($request->description) {
            DB::table('settings')->where('field_name', 'description')->update([
                'value' => $request->description,
                'updated_at' => date('Y-m-d H:i:s'),
                'uid' => Auth::user()->id,
            ]);
        }

        if ($request->main_keywords) {
            DB::table('settings')->where('field_name', 'main_keywords')->update([
                'value' => $request->main_keywords,
                'updated_at' => date('Y-m-d H:i:s'),
                'uid' => Auth::user()->id,
            ]);
        }

        if ($request->google_analytic) {
            DB::table('settings')->where('field_name', 'google_analytic')->update([
                'value' => $request->google_analytic,
                'updated_at' => date('Y-m-d H:i:s'),
                'uid' => Auth::user()->id,
            ]);
        }

        if ($request->homepage_image) {
            DB::table('settings')->where('field_name', 'homepage_image')->update([
                'value' => $request->homepage_image,
                'updated_at' => date('Y-m-d H:i:s'),
                'uid' => Auth::user()->id,
            ]);
        }

        Session::flash('Success', 'Settings Saved Successfully!');
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
        //
    }
    // the function below to encode any html content and trim
    public function encoded($string, $param, $param2, $filter = 'no')
    {
        if ($filter == 'yes') {
            $fin = strip_tags($string);
        } else {
            $fin = $string;
        }
        $s = htmlspecialchars_decode(html_entity_decode($fin));
        $sub = substr($s, $param, $param2);
        $before = htmlentities($sub);
        $dots = strlen($string) > $param ? "..." : "";

        $final = $before . ' ' . $dots;
        return $final;
    }

    // the function below to encode any html content without trim
    public function encodeOnly($string)
    {
        $final = htmlspecialchars_decode(html_entity_decode($string));
        return $final;
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
}
