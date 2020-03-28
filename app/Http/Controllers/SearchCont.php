<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Feeds;
use App\postCategories;
use View;

class SearchCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = \Request::get('search'); //<-- we use global request to get the param of URI
        $categories = \Request::get('categories');

        if (!empty($name)) {
            $name = \Request::get('search');
        } else {
            $name = '';
        }

        $results = Feeds::where([
            ['title', 'like', '%'.$name.'%'],
        ])->orwhere([
            ['body', 'like', '%'.$name.'%'],
        ]);
        $feeds = Feeds::where([
            ['title', 'like', '%'.$name.'%'],
        ])->orwhere([
            ['body', 'like', '%'.$name.'%'],
        ]);
        $users = User::where([
            ['firstname', 'like', '%'.$name.'%'],
        ])->orwhere([
            ['lastname', 'like', '%'.$name.'%'],
        ]);

        if (!empty($categories) and $categories !== null) {
            $catList = [];
            $usersList = [];
            $cat = postCategories::where([
                ['category', 'like', '%'.$categories.'%'],
            ])->get();
            foreach ($cat as $key) {
                $catList[$key->nid] = $key->nid;
                $usersList[$key->uid] = $key->uid;
            }
            $users = User::whereIn('id', $usersList);
            $results = Post::whereIn('id', $catList);
        }

        return View::make('pages.search')->with([
            'results' => $results,
            'news' => $feeds,
            'usersResults' => $users,
            'categories' => ((!empty($categories)) ? 'yes' : 'no'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
