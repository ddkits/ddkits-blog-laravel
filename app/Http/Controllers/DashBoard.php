<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Post;
use App\Followers;
use App\ToDo;
use App\Feeds;
use App\userFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashBoard extends Controller
{
    protected function getDash()
    {
        $userId = Auth::user()->id;
        $userInfo = DashBoard::getUserInfo($userId);
        $userProfile = DB::table('profiles')->where('uid', $userInfo->id)->first();

        // Finalize the user account and profile
        if (empty($userProfile)) {
            DashBoard::finishAccount($userInfo->id);
            $userProfile = Profile::where('uid', $userInfo->id);
        }

        // admin or not
        $admin = 0;
        $myFriends = [];
        $myPostsViews = 0;
        $myPostViews = [];
        $myViewsChart = [];
        $myPostsChart = [];
        $postComments = [];
        $postCommentsCount = [];
        $adminsCount = DB::table('admins')->count();
        $countv = 0;
        $countp = 0;
        $user = DB::table('admins')->where('uid', $userId)->first();
        if ($user !== null) {
            $admin = 1;
        }
        // Get the User Blogs
        $posts = DB::table('posts')->get();
        $postsCount = DB::table('posts')->count();
        // Get the User comments
        $comments = DB::table('comments')->where('uid', $userId)->get();
        $commentsCount = DB::table('comments')->where('uid', $userId)->count();
        // Get the User Blogs, folowers and friends
        $friendsIds = DB::table('friends')->where('uid1', $userId)->get();
        if ($friendsIds) {
            foreach ($friendsIds as $friend) {
                $id = $friend->uid2;
                $myFriends = DB::table('users')->where('uid', $id);
            }
        }
        // get my posts only
        $myPosts = DB::table('feeds')->where('uid', $userId)->orderBy('id', 'desc');
        $myPostsCount = DB::table('feeds')->where('uid', $userId)->count();
        foreach ($myPosts->get() as $post) {
            $existViews = DB::table('views')->where('nid', $post->id)->first();
            if ($existViews) {
                $countv = $countv + $existViews->views;
            } else {
                $existViewsAdd = DB::table('views')->insert([
                    'nid' => $post->id,
                    'views' => 1,
                    ]);
                $existViews = DB::table('views')->where('nid', $post->id)->first();
                $countv = $countv + $existViews->views;
            }
            $myPostsViews = $countv;
            $myPostViews[$post->id] = $existViews->views;
            $myViewsChart[$post->title] = $existViews->views;
            // comments for each blogs
            $postComments[$post->id] = DB::table('comments')->where('nid', $post->id)->get();
            $postCommentsCount[$post->id] = DB::table('comments')->where('nid', $post->id)->count();
        }

        // Get posts in order of dates
        $myPostsCharts = DB::table('feeds')->where('uid', $userId)->get();
        foreach ($myPostsCharts as $post) {
            $pdateY = date('Y', strtotime($post->created_at));
            $pdateM = date('M', strtotime($post->created_at));
            $pdateD = date('j', strtotime($post->created_at));
            $countp = 1;
            if (!empty($myPostsChart[$pdateD])) {
                $countp = ($myPostsChart[$pdateD]['count'] + 1);
                $myPostsChart[$pdateD] = array('month' => $pdateM, 'year' => $pdateY,  'day' => $pdateD, 'count' => $countp);
            } else {
                $myPostsChart[$pdateD] = array('month' => $pdateM, 'year' => $pdateY,  'day' => $pdateD, 'count' => $countp);
            }
        }

        $newArticles = DB::table('feeds')->orderby('id', 'desc');
        $myFriendsCount = DB::table('friends')->where(['uid1' => $userId, 'status' => 1])->orwhere(['uid2' => $userId, 'status' => 1])->count();
        $myFollowersCount = Followers::where('who', $userId)->count();
        $randomUser = DashBoard::randomUser();

        // Get all views happend to any user blog
        $myViews = DB::table('feeds')->where('uid', $userId)->first();

        // Todo list for each user
        $toDoList = ToDO::where('uid', $userId)->orderBy('created_at', 'desc');

        // myFiles list for each user
        $myFiles = userFiles::where('uid', $userId)->orderBy('created_at', 'desc');

        // feeds
        $feedsCount = 0;
        $feedsCount = DB::table('feeds')->count();

        return view('pages.dashboard')->withFeedsCount($feedsCount)->with([
            'Posts' => $posts,
            'admin' => $admin,
            'feedsCount' > $feedsCount,
            'friendsc' => $myFriendsCount,
            'followersc' => $myFollowersCount,
            'commentsc' => $commentsCount,
            'Comments' => $comments,
            'postsc' => $postsCount,
            'friends' => $myFriends,
            'myPosts' => $myPosts,
            'myPostsViews' => $myPostsViews,
            'myPostViews' => $myPostViews,
            'postComments' => $postComments,
            'postCommentsCount' => $postCommentsCount,
            'myViewsChart' => $myViewsChart,
            'myPostsChart' => $myPostsChart,
            'myPostsCharts' => $myPostsCharts,
            'adminsCount' => $adminsCount,
            'myPostsCount' => $myPostsCount,
            'myFiles' => $myFiles,
            'randomUser' => $randomUser,
            'newArticles' => $newArticles,
            'toDoList' => $toDoList,
        ]);
    }

    public function postDash()
    {
        return view('pages.dashboard');
    }

    public function randomUser()
    {
        $randomUser = User::inRandomOrder()->first();

        return $randomUser;
    }

    public function postComments($nid)
    {
        return;
    }

    public function getFriendsID($uid)
    {
        $getFriendsID = DB::table('friends')->where('uid1', $uid)->get();

        return $getFriendsID;
    }

    public function getUserInfo($uid)
    {
        $userInfo = User::find($uid);

        return $userInfo;
    }

    public function getUserPosts($uid)
    {
        $getUserPosts = Post::where('uid', $uid);

        return $getUserPosts;
    }

    protected function finishAccount($uid)
    {
        // add profile account for extra fields
        $userProfile = DB::table('profiles')->where('uid', $uid)->first();
        if (empty($userProfile)) {
            $newPro = new Profile();
            $newPro->uid = $uid;
            $newPro->picture = 'img/profileM.png';
            $newPro->save();
            DashBoard::updateUser($uid, $newPro->id);
        }
    }

    protected function updateUser($uid, $proID)
    {
        // save the data to tthe database
        $userSave = User::find($uid);
        $userSave->profile = $proID;
        $userSave->save();
    }
}
