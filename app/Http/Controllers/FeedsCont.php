<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;
use App\Comments;
use App\Profile;
use App\userFiles;
use App\Feeds;
use App\FeedsList;
use App\postTags;
use Facebook\Facebook;
use App\postCategories;
use Session;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ArticlePublished;
use function GuzzleHttp\json_decode;

class FeedsCont extends Controller
{
    use Notifiable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable and store in it from the database
        $categories = $this->categories();
        $tags = $this->tags();
        $feeds = FeedsList::orderby('id', 'desc')->paginate(10);
        return view('admin.feed.index')->with([
            'feeds' => $feeds,
            'tags' => $tags,
            'categories' => $categories,
        ]);
        // return a view and pass in the above variable
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function homepage()
    {
        return view('pages.news');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHomefeeds(Request $request)
    {
        $id = ($request->id) ?: 0;
        $source = ($request->source) ?: false;
        $date = ($request->date) ?: false;
        $response['code'] = 200;
        $response['message'] = $date;
        // create a variable and store in it from the database
        $feeds = DB::table('feeds')
            ->where('created_at', '<', $date);
        if ($source !== 'all') {
            $feeds->where('source', 'like', $source . '%');
        }
        $feeds->orderBy('created_at', 'DESC')->limit(18);
        $data = '';
        $count = 0;
        foreach ($feeds->get() as $post) {
            $last_id = $post->id;
            $count++;
            $data .= '<a href="' . route("feeds.showPage", $post->path) . '" class="black fondo-ddkits-home  col-md-6" data-id="' . $last_id . '" >
            <div class="ddkits-blog-content-home col-md-11 col-sx-11" >
            <div class="img-ddkits-principal-home">';
            if (strpos($post->image, 'http') !== true) {
                $data .= '<img class="ddkits" src="/' . $post->image . '" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;"  alt="' . $post->title . '">';
            } else {
                $data .= '<img class="ddkits" src="' . $post->image . '" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;"  alt="' . $post->title . '">';
            }
            $data .= '</div>
            <div class="whytopost-ddkits-principal-home">
            <div class=" col-md-12">' . $this->encoded($post->title, 0, 50, "yes") .  '<div class="small">' . date('M/d/Y', strtotime($post->created_at)) . '</div></div>
            <div class="author">
            </div>
            </div>
            </div>
            </a>';
            $dataNow = $post->created_at;
        }
        if ($count < 18) {
            //
        } else {
            $data .= '<div id="post_data" class="col-md-12"></div>
        <div id="load_more" class="align-text-center align-items-center col-md-12">
        <button type="button" name="load_more_button" class="btn form-control" data-id="' . $last_id . '" data-source="' . $source . '" data-date="' . $dataNow . '" id="load_more_button">Load More News</button>
        </div>';
        }
        echo $data;
}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHomeNews($id = false, $random = false)
    {
        // create a variable and store in it from the database
        if ($id > 0) {
            $feeds = DB::table('feeds')
                ->where('id', '<', $id);
        } else {
            $feeds = DB::table('feeds');
        }
        if ($random) {
            $feeds->inRandomOrder();
        } else {
            $feeds->orderBy('created_at', 'DESC');
        }
        foreach ($feeds as $feed => $item) {
            if ($feed == 'image') {
                if (strpos($item, 'http') !== true) {
                    $feeds[$feed] = '/' . $feed->image;
                }
            }
        }
        return $feeds;
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFeedsHomeNews($id = false, $date = false, $random = false)
    {
        // create a variable and store in it from the database
        $feeds = DB::table('feeds');

        if ($date and $date != 0) {
            $feeds->where('created_at', '<', $date);
        } else {
            $feeds->orderBy('created_at', 'DESC');
        }
        foreach ($feeds as $feed => $item) {
            if ($feed == 'image') {
                if (strpos($item, 'http') !== true) {
                    $feeds[$feed] = '/' . $feed->image;
                }
            }
        }
        return $feeds;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSourceNews($source = false, $random = false)
    {
        // create a variable and store in it from the database
        $feeds = DB::table('feeds');
        if ($source) {
            $feeds->where('source', 'like', $source . '%');
        }
        if ($random) {
            $feeds->inRandomOrder();
        } else {
            $feeds->orderBy('created_at', 'DESC');
        }
        foreach ($feeds as $feed => $item) {
            if ($feed == 'image') {
                if (strpos($item, 'http') !== true) {
                    $feeds[$feed] = '/' . $feed->image;
                }
            }
        }
        return $feeds;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllfeeds()
    {
        // create a variable and store in it from the database
        $feeds = Feeds::orderby('created_at', 'desc')->where('homepage', 1);
        return $feeds;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHeaderfeeds($num = 3)
    {
        // create a variable and store in it from the database
        $feeds = Feeds::orderby('created_at', 'desc')->where('homepage', 2);
        return $feeds;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTopfeeds()
    {
        $topfeed = null;
        $topfeeds = [];
        $getViews = DB::table('views')->orderby('views', 'DESC')->get();
        if ($getViews) {
            foreach ($getViews as $post) {
                $topfeed = Feeds::where('id', $post->nid)->first();
                $topfeeds[] = ['id' => $topfeed->id, 'title' => $topfeed->title, 'body' => $topfeed->body, 'date' => $topfeed->created_at];
            }
        }
        return $topfeeds;
        // return a view and pass in the above variable
    }

    public function indexMe()
    {
        // create a variable and store in it from the database
        // $feeds = Feeds::all();

        $feeds = DB::table('posts')->where('uid', Auth::user()->id)->orderby('id', 'desc')->get();

        return view('admin.feed.index')->withfeeds($feeds);
        // return a view and pass in the above variable
    }

    public function getUserfeeds($uid)
    {
        // create a variable and store in it from the database
        // $feeds = Feeds::all();

        $feeds = DB::table('posts')->where('uid', $uid)->orderby('id', 'desc')->get();

        return $feeds;
        // return a view and pass in the above variable
    }

    public function getUserfeedsCount($uid)
    {
        // create a variable and store in it from the database
        // $feeds = Feeds::all();

        $feedsc = DB::table('posts')->where('uid', $uid)->count();
        if ($feedsc) {
            $count = $feedsc;
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
        return view('admin.feed.create')->with([
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
            'title' => 'required|max:255'
        ));


        // store
        $feedslist = new FeedsList;
        $feedslist->uid = Auth::user()->id;
        $feedslist->title = $request->title;
        if (!empty($request->youtube)) {
            $feedslist->feed_url = 'https://www.youtube.com/feeds/videos.xml?channel_id=' . (string) $request->youtube;
        } else if (!empty($request->youtubeuser)) {
            $feedslist->feed_url = 'https://www.youtube.com/feeds/videos.xml?user=' . (string) $request->youtubeuser;
        } else {
            $feedslist->feed_url = $request->feed_url;
        }

        if ($request->categories) {
            if (count($request->categories) > 0) {
                $cats = implode(', ', $request->categories);
            } else {
                $cats = '';
            }
        } else {
            $cats = '';
        }
        if ($request->tags) {
            if (count($request->tags) > 0) {
                $tags = implode(', ', $request->tags);
            } else {
                $tags = '';
            }
        } else {
            $tags = '';
        }

        $feedslist->tags = $tags;
        $feedslist->categories = $cats;
        $feedslist->save();

        Session::flash('Success', 'Feeds Added');
        return redirect()->route('feeds.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $message)
    {
        return view('admin.feed.show')->with([
            'message' => $message
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
        $nCategories = $this->nCategories(['nid' => $id, 'type' => 'feed']);
        $categories = $this->categories();
        $nTags = $this->nTags(['nid' => $id, 'type' => 'feed']);
        $tags = $this->tags();
        $post = Feeds::find($id);
        $comments = DB::table('comments')->where('nid', $id)->where('type', 'feed')->get();
        $user = DB::table('users')->where('id', $post->uid)->first();
        $profileInfo = Profile::where('uid', $user->id);
        return view('admin.feed.edit')->with([
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
            'feed_url' => 'required'
        ));
        $categories = $this->categories();
        $tags = $this->tags();
        $post = FeedsList::find($id);
        $post->title = $request->input('title');
        $post->feed_url = $request->input('feed_url');
        $post->tags = (!empty($request->input('tags'))) ? $request->input('tags') : 'News';
        $post->categories = (!empty($request->input('categories'))) ? $request->input('categories') : 'News';
        $post->save();
        // set flash data with success msg
        Session::flash('Success', 'feed updated successfully!');
        // create a variable and store in it from the database
        $feeds = FeedsList::orderby('id', 'desc')->paginate(10);
        return view('admin.feed.index')->with([
            'feeds' => $feeds,
            'tags' => $tags,
            'categories' => $categories,
        ]);
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
        Feeds::destroy($id);
        return redirect()->route("admin.feed.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        $feed = Feeds::truncate();
        return redirect()->route("feeds.index");
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
     * Update the specified feeds to store.
     *
     * @param  int  $url
     * @return \Illuminate\Http\Response
     */
    private function syncFeed($url)
    {
        try {
            // $simpleXml = simplexml_load_file($url, "SimpleXMLElement", LIBXML_NOCDATA);
            // $json = json_encode($simpleXml);
            // $results = json_decode($json, true);
            $results = simplexml_load_file($url);
            // print_r($results);
            Session::flash('Success', 'Pass');
            return $results;
            // return $this->createNewFeeds($results);
        } catch (\Exception $e) {
            $results = '';
            Session::flash('Error', 'Null results');
            // redirect
            return $results;
        }
    }
    /**
     * Update the specified feeds to store.
     *
     * @param  int  $url
     * @return \Illuminate\Http\Response
     */
    private function syncVideoFeed($url)
    {
        try {
            // $simpleXml = simplexml_load_file($url, "SimpleXMLElement", LIBXML_NOCDATA);
            // $json = json_encode($simpleXml);
            // $results = json_decode($json, true);
            $feed = $this->curl_get_contents($url);
            $results = new \SimpleXMLElement($feed);
            // print_r($results);
            Session::flash('Success', 'Pass');
            return $results;
            // return $this->createNewFeeds($results);
        } catch (\Exception $e) {
            $results = '';
            Session::flash('Error', 'Null results');
            // redirect
            return $results;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function genAllfeeds()
    {
        // create a variable and store in it from the database
        $feeds = FeedsList::all();
        foreach ($feeds as $key) {
            echo $key->id . ' Imported';
            $this->feedsSyncDirect($key->id);
        }
        return $feeds;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function feedsList()
    {
        // create a variable and store in it from the database
        $feeds = DB::table('feeds');

        return view('admin.feed.feedslist')->with([
            'feeds' => $feeds
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function feedsListDelete($id)
    {
        // create a variable and store in it from the database
        $feeds = Feeds::destroy($id);
        $feeds = DB::table('feeds');

        return view('admin.feed.feedslist')->with([
            'feeds' => $feeds
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function feedsRelated($source, $id = false)
    {
        // create a variable and store in it from the database
        if ($id > 0) {
            $feedsRelated = DB::table('feeds')
                ->where('source', $source)
                ->where('id', '<', $id);
        } else {
            $feedsRelated = DB::table('feeds')
                ->where('source', $source);
        }
        $feedsRelated->inRandomOrder()
            ->orderBy('id', 'DESC');

        return $feedsRelated;
    }
    /**
     * feedsSync the specified feeds to store.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function feedsSyncDirect($id)
    {
        $item = FeedsList::find($id);
        $url = $item->feed_url;
        $tags = $item->tags;
        $categories = $item->categories;
        $title = $item->title;
        $source_id = (int) $id;
        if (strpos($url, 'youtube')) {
            $result = $this->syncVideoFeed($url);
        } else {
            $result = $this->syncFeed($url);
        }

        if (!empty($result)) {
            Session::flash('Success', 'Synced successfully');
            // redirect
            if (strpos($url, 'youtube')) {
                return $this->createNewVideoFeeds($result, $tags, $categories, $source_id, $title);
            } else {
                return $this->createNewFeeds($result, $tags, $categories, $source_id, $title);
            }
        } else {
            Session::flash('Error', 'Synced not correct');
            // redirect
            return redirect()->route('feeds.index');
        }
    }
    /**
     * feedsSync the specified feeds to store.
     *
     * @return \Illuminate\Http\Response
     */
    public function feedsSync(Request $request)
    {
        $id = (int) $request->id;
        $item = FeedsList::find($id);
        $url = $item->feed_url;
        $tags = $item->tags;
        $title = $item->title;
        $categories = $item->categories;
        $source_id = (int) $request->id;
        if (strpos($url, 'youtube')) {
            $result = $this->syncVideoFeed($url);
        } else {
            $result = $this->syncFeed($url);
        }
        if (!empty($result)) {
            Session::flash('Success', 'Synced successfully');
            // redirect
            if (strpos($url, 'youtube')) {
                return $this->createNewVideoFeeds($result, $tags, $categories, $source_id, $title);
            } else {
                return $this->createNewFeeds($result, $tags, $categories, $source_id, $title);
            }
        } else {
            Session::flash('Error', 'Synced not correct');
            // redirect
            return redirect()->route('feeds.index');
        }
    }

    /**
     * createNewFeeds the specified feeds to store.
     *
     * @param  array  $results
     * @return \Illuminate\Http\Response
     */
    public function createNewFeeds($results, $tags, $categories, $source_id, $title)
    {
        $channel = $results->channel->item;
        $author = 'author';
        $image = 'image';
        $guid = 'guid';
        $category = false;
        $content = false;
        $dateIs = Carbon::today();

        // check the XML style and keys
        foreach ($channel as $key) {
            if (strpos($key, 'author') !== false || strpos($key, 'user') !== false || strpos($key, 'dc:') !== false) {
                $author = $key;
            } else if (strpos($key, 'guid') !== false) {
                $guid = $key;
            } else if (strpos($key, 'image') !== false) {
                $image = $key;
            } else if (strpos($key, 'cate') !== false) {
                $category = $key;
            } else if (strpos($key, 'content') == true) {
                $content = $key;
            } else if (strpos($key, 'pubDate') !== false || strpos($key, 'created') !== false) {
                $dateIs = $key;
            }
        }

        foreach ($channel as $result) {
            $guidIs = $result->$guid;
            $e_title = (string) $result->title;
            $e_link = (string) $result->link;
            $e_pubDate = (string) $result->pubDate;
            $e_description = (string) $result->description;
            $e_guid = (string) $result->guid;
            $e_author = $result->children('dc', True)->creator;
            $e_authorencoded = (string) $e_author[0];
            // get encoded contents
            $e_content = $result->children("content", true);
            $e_encoded = (string) $e_content->encoded;
            if (!Feeds::where('guid', $e_guid)->first()) {
                $slug = $this->create_slug($result->title);
                $feed = new Feeds;
                $feed->uid = (Auth::user()->id) ?? 1;
                $feed->title = $e_title;

                // get the guid from the item
                $feed->guid = $e_guid;

                // check the auther of the item
                $feed->author = ($e_authorencoded) ?? $result->author;
                if ($e_encoded) {
                    $feed->body = $e_encoded;
                } else {
                    $feed->body =  $e_description;
                }
                $feed->source = (string) $title;
                $feed->path = $slug;
                $feed->tags = $tags;

                if ($category) {
                    $feed->categories = implode(', ', $result->$category);
                } else {
                    $feed->categories = $categories;
                }

                $feed->source_id = $source_id;
                $feed->channel = (string) $results->channel->title;
                if (isset($result->enclosure)) {
                    $imageIs = $result->enclosure;
                    foreach ($imageIs->attributes() as $a => $b) {
                        if ($a == 'url') {
                            $downloadedImage = $this->downloadImage($b, $slug);
                            $feed->image = $downloadedImage;
                        }
                    }
                } else {
                    if (property_exists($image, $result)) {
                        $downloadedImage = $this->downloadImage($result->$image->url, $slug);
                        $feed->image = $downloadedImage;
                    }
                }

                // image from items
                $feed->author = $result->$author;

                $feed->created_at = Carbon::parse($result->$dateIs);
                $feed->updated_at = Carbon::parse(now());
                $feed->save();
                // notify facebook for new content
                // $feed->notify(new ArticlePublished);
                $this->doShare($feed);

                Session::flash('Success', 'Feed created');
            } else {
                Session::flash('Success', 'Feed exist');
            }
        }

        return redirect()->route('feeds.index');
    }

    /**
     * createNewFeeds the specified feeds to store.
     *
     * @param  array  $results
     * @return \Illuminate\Http\Response
     */
    public function createNewVideoFeeds($results, $tags, $categories, $source_id, $title)
    {
        $channel = $results->title;
        $count = count($results->entry);
        for ($i = 0; $i < $count; $i++) {
            $item = $results->entry[$i];
            $url = $item->link->attributes();
            $e_guid = $url['href'];
            if (!Feeds::where('guid', $e_guid)->first()) {
                $videourl = explode("&", $url['href']);
                $video = str_replace("https://www.youtube.com/watch?v=", "", $videourl[0]);
                $slug = $this->create_slug($item->title);
                $feed = new Feeds;
                $feed->uid = (Auth::user()->id) ?? 1;
                $feed->title = $item->title;
                // get the guid from the item
                $feed->guid = $url['href'];
                $feed->author = $item->author->name;
                $bodyUpdate = '';
                $bodyUpdate .= '<p><iframe class="center" width="500px" height="300px" src="https://www.youtube.com/embed/' . $video . '" frameborder="0" allowfullscreen></iframe></p><br>';
                $feed->source = $title;
                $feed->source_id = $source_id;
                // get the image
                $thumbUrl = $item->children('media', True)->group->children('media', True)->thumbnail->attributes();
                $bodyUpdate .= $item->children('media', True)->group->children('media', True)->description;
                $downloadedImage = $this->downloadImage($thumbUrl, $slug);
                $feed->image = $downloadedImage;
                $feed->path = $slug;
                $feed->body = $bodyUpdate;
                $feed->created_at = Carbon::parse(date('jS M Y h:i:s', strtotime($item->published)));
                $feed->updated_at = Carbon::parse(time());
                $feed->tags = $tags;
                $feed->categories = $categories;
                $feed->channel = $channel;
                $feed->save();
                // notify facebook for new content
                // $feed->notify(new ArticlePublished);
                $this->doShare($feed);
                Session::flash('Success', 'Feed created');

                // save categories and tags
                // remove and add in case of TAGS
                if (!empty($tags)) {
                    DB::table('post_tags')->where(['nid' => $feed->id, 'type' => 'feed'])->delete();
                    foreach (explode(', ', $tags) as $key => $value) {
                        $newTag = new postTags;
                        $newTag->type = 'feed';
                        $newTag->tag = $value;
                        $newTag->nid = $feed->id;
                        $newTag->uid = (Auth::user()->id) ?? 1;
                        $newTag->save();
                    }
                } else {
                    DB::table('post_tags')->where(['nid' => $feed->id, 'type' => 'feed'])->delete();
                }

                // categories
                if (!empty($categories)) {
                    DB::table('post_categories')->where(['nid' => $feed->id, 'type' => 'feed'])->delete();
                    foreach (explode(', ', $categories) as $key => $value) {
                        $newTag = new postCategories;
                        $newTag->type = 'feed';
                        $newTag->category = $value;
                        $newTag->nid = $feed->id;
                        $newTag->uid = (Auth::user()->id) ?? 1;
                        $newTag->save();
                    }
                } else {
                    DB::table('post_tags')->where(['nid' => $feed->id, 'type' => 'feed'])->delete();
                }
            } else {
                Session::flash('Success', 'Feed exist');
            }
        }
        return redirect()->route('feeds.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function feedsChannelTitle($slug = false)
    {
        $results = Feeds::where('source', 'like', $slug . '%')->orderBy('created_at', 'DESC');
        return view('news.channel')->with([
            'news' => $results,
            'source' => $slug
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function feedsTitle($slug = false)
    {
        $post = Feeds::where('path', $slug)->first();
        $comments = DB::table('comments')->where('nid', $post->id)->where('type', 'feed')->get();
        $user = DB::table('users')->where('id', $post->uid)->first();
        $profileInfo = Profile::where('uid', $user->id);
        $tags = App(\App\Http\Controllers\PostCont::class)->nTags($post->id, 'feeds');
        $categories = App(\App\Http\Controllers\PostCont::class)->nCategories($post->id, 'feeds');
        if (count($categories) > 0) {
            $cats = implode(', ', $categories);
        } else {
            $cats = '';
        }
        if (count($tags) > 0) {
            $tags = implode(', ', $tags);
        } else {
            $tags = '';
        }


        return view('news.article')->with([
            'post' => $post,
            'comments' => $comments,
            'nTags' => $tags,
            'nCategories' => $cats,
            'slug' => $slug
        ]);
    }
    private function curl_get_contents($url)
    {
        // Initiate the curl session
        $ch = curl_init();
        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);
        // Removes the headers from the output
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // Return the output instead of displaying it directly
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //set timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        // Execute the curl session
        $output = curl_exec($ch);
        // Close the curl session
        curl_close($ch);
        // Return the output as a variable
        return $output;
    }
    // the function below to encode any html content and trim
    public function encoded($string, $param, $param2, $filter = 'no')
    {
        if ($filter == 'yes') {
            $fin = strip_tags($string);
        } else {
            $fin = $string;
        }
        $s = html_entity_decode($fin);
        $sub = substr($s, $param, $param2);
        $before = htmlentities($sub);
        $dots = strlen($string) > $param ? "..." : "";

        $final = $before . ' ' . $dots;
        return $final;
    }

    // the function below to encode any html content without trim
    public function encodeOnly($string)
    {
        $final = html_entity_decode($string);
        return $final;
    }

    // Download images instead
    public function downloadImage($iurl, $file_name)
    {

        $destinationPath = 'uploads/files/feeds';
        $path = public_path('uploads/files/feeds');
        if (!Storage::directories('public')) {
            Storage::makeDirectory('public');
        } else  if (!Storage::directories('public/uploads')) {
            Storage::makeDirectory('public/uploads');
        } else  if (!Storage::directories($path)) {
            Storage::makeDirectory($path);
        }
        $path_name =  parse_url($iurl, PHP_URL_PATH);
        // $file_name = str_replace('/', '', $path_name);

        $file = file_get_contents($iurl);
        $checkFile = userFiles::where('ftype', $file_name);
        if ($checkFile->count() > 0) {
            $file = $checkFile->first();
            $saveFile = $file->file;
        } else {
            //Move Uploaded File
            $saveFile = $destinationPath . '/' . $file_name;
            $realFile = $path . '/' . $file_name;
            file_put_contents($realFile, $file);
            // start saving the file
            $fileDB = new userFiles;
            $fileDB->uid = 1;
            $fileDB->nid = null;
            $fileDB->ntype = 'feed';
            $fileDB->file = $saveFile;
            $fileDB->ftype = $file_name;
            $fileDB->save();
            $saveFile = $fileDB->file;
        }
        return $saveFile;
    }

    // share with facebook SDK
    public function doShare($feed)
    {

        $post = new GraphController();
        $post->publishToPageNew('109307603921320', $feed);
    }
}
