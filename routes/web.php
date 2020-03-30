<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('pages.news');
    });
    Route::get('/news', ['as' => 'feeds.homepage', 'uses' => 'FeedsCont@homepage']);
    Route::get('/article/{path}', ['as' => 'article.show', 'uses' => 'ArticleCont@showTitle']);
    Route::get('/news/{path}', ['as' => 'feeds.showPage', 'uses' => 'FeedsCont@feedsTitle']);
    Route::get('/news/channel/{path}', ['as' => 'feeds.channel.showPage', 'uses' => 'FeedsCont@feedsChannelTitle']);
    Route::get('/admin/feeds/delete-all', ['as' => 'feeds.delete.all', 'uses' => 'FeedsCont@destroyAll']);
    Route::get('/feeds-load-more/{source}', ['as' => 'feeds.LoadMore', 'uses' => 'FeedsCont@getHomefeeds']);
    Route::resource('/articles', 'ArticleCont');
    Route::get('/load', ['as' => 'articles.goto', 'uses' => 'ArticleCont@gotoArticles']);
    Route::group(['middleware' => ['auth']], function () {
        // Admin
        Route::resource('/admin/menu', 'MenuCont');
        Route::resource('/admin/feeds', 'FeedsCont');
        Route::post('/admin/feeds-sync', ['as' => 'feeds.sync', 'uses' => 'FeedsCont@feedsSync']);
        Route::get('/admin/feeds-hour', function () {
            /* php artisan feeds Import */
            \Artisan::call('feeds:hour');
            dd('Feeds Synced.');
        });
        Route::get('/admin/feeds-list', ['as' => 'feeds.list', 'uses' => 'FeedsCont@feedsList']);
        Route::delete('/admin/feeds-list-delete-one/{id}', ['as' => 'feeds.list.delete', 'uses' => 'FeedsCont@feedsListDelete']);

        Route::resource('/admin', 'AdminCont');
        Route::resource('/admin-facebook', 'FacebookCont');
        Route::post('/admin-facebook-post', ['as' => 'admin-facebook.post', 'uses' => 'FacebookCont@postToPage']);
        Route::resource('/admin/private/settings', 'SettingCont');
        Route::post('/admin-save/settings', ['as' => 'admin.settings.save', 'uses' => 'AdminCont@storeSettings']);
        Route::post('/create-settings', ['as' => 'settings.store', 'uses' => 'AdminCont@createSettings']);
        // saves admins
        Route::post('/admin-users/save', ['as' => 'admin.users.save', 'uses' => 'AdminCont@adminUsersStore']);
        Route::post('/admin-posts/save', ['as' => 'admin.posts.save', 'uses' => 'AdminCont@adminPostsStore']);
        Route::post('/admin-proposts/save', ['as' => 'admin.proposts.save', 'uses' => 'AdminCont@adminProPostsStore']);
        Route::post('/admin-tags/save', ['as' => 'admin.tags.save', 'uses' => 'AdminCont@adminPostTagsStore']);
        Route::post('/admin-categories/save', ['as' => 'admin.categories.save', 'uses' => 'AdminCont@adminPostCategoriesStore']);
        Route::post('/admin-path-update', ['as' => 'admin.updatePath', 'uses' => 'AdminCont@pathUpdate']);

        // get
        Route::get('/admin-users', ['as' => 'admin.users', 'uses' => 'AdminCont@adminUsers']);
        Route::get('/admin-posts', ['as' => 'admin.posts', 'uses' => 'AdminCont@adminPosts']);
        Route::get('/admin-proposts', ['as' => 'admin.proposts', 'uses' => 'AdminCont@adminProPosts']);
        Route::get('/admin-tags', ['as' => 'admin.tags', 'uses' => 'AdminCont@adminPostTags']);
        Route::get('/admin-categories', ['as' => 'admin.categories', 'uses' => 'AdminCont@adminPostCategories']);

        // Pages
        Route::resource('/search', 'SearchCont');
        Route::resource('/media', 'UserFilesCont');
        Route::resource('/calendar', 'CalendarCont');
        Route::resource('/my_to_do_list', 'ToDoCont');
        Route::resource('/blog', 'PostCont');
        Route::resource('/comment', 'CommentCont');
        Route::get('/dashboard', 'DashBoard@getDash');
        Route::post('/dashboard', 'DashBoard@postDash');
        //  For share and reshare with blogs and posts
        Route::resource('/reshare', 'ShareCont');
        // User Profiles
        Route::resource('/profile', 'ProfileCont');
        Route::resource('/posts', 'ProPostCont');
        Route::get('/add-like', ['as' => 'likes.store.link', 'uses' => 'LikeCont@addLike']);
        Route::get('/add-share', ['as' => 'shares.store.link', 'uses' => 'ShareCont@addShare']);
        Route::resource('/likes', 'LikeCont');
        Route::resource('/friends', 'FriendsCont');
        Route::resource('/followers', 'FollowersCont');
        // Actions needed files
        Route::post('/friend/confirm', 'FriendsCont@friendsConfirm');
        //  messages routes
        // Route::resource('/messages', 'MsgCont');
        Route::get('/messages', ['as' => 'messages.index', 'uses' => 'MsgCont@index']);
        Route::get('/messages/create', ['as' => 'messages.create', 'uses' => 'MsgCont@create']);
        Route::post('/messages/sent', ['as' => 'messages.store', 'uses' => 'MsgCont@store']);
        Route::get('/messages/outbox', ['as' => 'messages.outbox', 'uses' => 'MsgCont@outbox']);
        Route::get('/messages/{default}', ['as' => 'messages.show', 'uses' => 'MsgCont@show']);
        Route::get('autocomplete', function () {
            return View::make('autocomplete');
        });
        Route::get('getFriendsList', ['as' => 'messages.getFriendsList', 'uses' => 'MsgCont@getFriendsList']);
    });
});

Route::get('/email', function () {
    return view('pages.email');
});

// sitemap links
Route::get('/sitemap', 'SitemapController@index');
Route::get('/sitemap/posts', 'SitemapController@posts');
Route::get('/sitemap/feeds', 'SitemapController@feeds');
Route::get('/sitemap/categories', 'SitemapController@categories');
Route::get('/sitemap/podcasts', 'SitemapController@podcasts');
Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebookProvider');

// Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderFacebookCallback');
Route::get('login/facebook/callback', function () {
    return view('pages.welcome');
});

Route::group(['middleware' => [
    'auth',
]], function () {
    Route::get('/facebook-user', 'GraphController@retrieveUserProfile');
    Route::post('/facebook-user', 'GraphController@publishToProfile');
    Route::post('/facebook-page', 'GraphController@publishToPage');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
