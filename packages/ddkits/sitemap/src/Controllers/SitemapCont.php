<?php

namespace ddkits\Sitemap\Controllers;

use Illuminate\Http\Request;

foreach ($Config::get('sitemapConfig.types') as $key) {
}

use App\Posts;
use App\Http\Controllers\Controller;
use View;
use Response;

class SitemapCont extends Controller
{
    // limit of sitemap
    protected $count = 0;
    protected $limit = 1000;

    public function index()
    {
        $posts = Posts::count();
        $this->count = (int) (($posts / $this->limit) + 1);

        $posts = Posts::select(["id", "updated_at", "path"])
            ->orderBy("id", "desc")
            ->limit($this->count)
            ->get();
        // $post = Posts::orderBy('updated_at', 'desc')->first();

        return response()->view('sitemap.index', [
            'posts' => $posts,
            'domains' => $posts,
            'count' => $this->count,
        ])->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function posts($p)
    {
        $count = $this->limit * $p;
        $posts = Posts::select(["id", "updated_at", "path", "title"])
            ->orderBy("id", "desc")
            ->take($this->limit)
            ->skip($count)
            ->get();

        return response()->view('sitemap.posts', [
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml;charset=utf-8');
    }
    public function domains($p)
    {
        $count = $this->limit * $p;
        $posts = Posts::select(["id", "updated_at", "path", "title"])
            ->orderBy("id", "desc")
            ->take($this->limit)
            ->skip($count)
            ->get();

        return response()->view('sitemap.domains', [
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml;charset=utf-8');
    }
    public function post()
    {
        $posts = Posts::select(["id", "updated_at", "path", "title"])->orderBy("id", "desc")->get();

        return response()->view('sitemap.posts', [
            'posts' => $posts,
            'domains' => $posts,
        ])->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function domain()
    {
        $posts = Posts::select(["id", "updated_at", "path", "title"])->orderBy("id", "desc")->get();

        return response()->view('sitemap.domains', [
            'posts' => $posts,
            'domains' => $posts,
        ])->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function categories()
    {
        $categories = Category::all()->orderBy("id", "desc");
        return response()->view('sitemap.categories', [
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function site()
    {
        $posts = Posts::select(["id", "updated_at"])
            ->orderBy("id", "desc")
            ->take(10000)
            ->get();

        $content = View::make('sitemap.sitemap', ['posts' => $posts]);
        return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }
}
