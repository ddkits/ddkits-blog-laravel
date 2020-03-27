<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Post;
use App\Feeds;
use App\Followers;
use App\ToDo;
use App\userFiles;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;


class SitemapController extends Controller
{
	public function index()
	{
		$post = Post::orderBy('updated_at', 'desc')->first();
		$feed = Feeds::orderBy('updated_at', 'desc')->first();

		return response()->view('sitemap.index', [
			'post' => $post,
			'feeds' => $feed,
		])->header('Content-Type', 'text/xml');
	}
	public function posts()
	{
		$posts = Post::all();
		return response()->view('sitemap.posts', [
			'posts' => $posts,
		])->header('Content-Type', 'text/xml');
	}
	public function feeds()
	{
		$posts = Feeds::all();
		return response()->view('sitemap.feeds', [
			'posts' => $posts,
		])->header('Content-Type', 'text/xml');
	}

	public function categories()
	{
		$categories = Category::all();
		return response()->view('sitemap.categories', [
			'categories' => $categories,
		])->header('Content-Type', 'text/xml');
	}
}
