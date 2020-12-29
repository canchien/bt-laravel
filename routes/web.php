<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Postmeta;
use App\Models\Usermeta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('show', function () {
    $result = Usermeta::whereIn('user_id',[73,71])->where('meta_key','vote_post')->pluck('meta_value');
    dd($result);
});


// admin login and logout
Route::get('/home/login','Auth\LoginController@login')->name('login');
Route::post('/home/signin','Auth\LoginController@signIn')->name('signin');
Route::get('/home/signup','Auth\LoginController@getSignUp')->name('get-signup');
Route::post('/home/signup','Auth\LoginController@postSignUp')->name('signup');
Route::get('/forgetPassword','Auth\LoginController@getForgetpassword')->name('get-forget-password');
Route::post('/forgetPassword','Auth\LoginController@postForgetpassword')->name('forget-password');
Route::get('/logout','UsersController@logout')->name('logout');
Route::get('/verify/{code}','Auth\LoginController@verify')->name('verify');
Route::get('/change-password/{code}','Auth\LoginController@getChangePassword')->name('get-change-password');
Route::post('/change-password','Auth\LoginController@postChangePassword')->name('change-password');
Route::get('/redirect', 'Auth\LoginController@redirectToProvider')->name('loginGoogle');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback')->name('callback');

Route::group(['middleware' => 'adminLogin'], function () {

    // Admin
    Route::group(['prefix' => 'admin'], function () {
        Route::get('home', function () {

        });
        Route::get('/test','CategoriesController@show');
        Route::group(['prefix' => 'image'], function () {
            Route::get('list-image','ImagesController@listImages')->name('listImages');
            Route::get('edit-image-category/{id}','ImagesController@getEditCategory')->name('getEditImgCategory');
            Route::post('edit-image-category','ImagesController@postEditCategory')->name('postEditCategory');
            Route::get('delete-image-category/{id}','ImagesController@deleteImgCategory')->name('deleteImgCategory');
            ;
            //Image post
            Route::get('/edit-image-Post/{id}','ImagesController@getEditPost')->name('getEditImgPost');
            Route::post('/edit-image-Post','ImagesController@postEditPost')->name('postEditPost');
            Route::get('/delete-image-Post/{id}','ImagesController@deleteImgPost')->name('deleteImgPost');
            Route::get('/search-images','ImagesController@searchImages')->name('searchImages');
            Route::get('/limit-images','ImagesController@limit')->name('limitImages');
            Route::post('bulk-action-images','ImagesController@bulkActionImages')->name('bulkActionImages');
            Route::get('/sort-Images','ImagesController@sort')->name('sortImages');

        });
        //Categories
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/list-categories','CategoriesController@listCategories')->name('list-categories');
            Route::get('/add-category','CategoriesController@getAddCategory')->name('add-category');
            Route::post('/add-category','CategoriesController@postAddCategory')->name('add-category');
            Route::get('/test','CategoriesController@test');
            Route::get('/edit-category/{id}','CategoriesController@getEditCategory')->name('edit-get-category');
            Route::post('/edit-category','CategoriesController@postEditCategory')->name('edit-category');
            Route::get('/delete-category/{id}','CategoriesController@deleteCategory')->name('delete-category');
            Route::get('/search-categories','CategoriesController@searchCategories')->name('searchCategories');
            Route::get('/limit-categories','CategoriesController@limit')->name('limitCategories');
            Route::post('bulk-action-categories','CategoriesController@bulkActionCategories')->name('bulkActionCategories');
            Route::get('/sort-categories','CategoriesController@sort')->name('sortCategories');
        });
        Route::group(['prefix' => 'tags'], function () {
            Route::get('/list-tags','TagsController@listTags')->name('listTags');
            Route::get('/delete-tags/{id}','TagsController@deleteTag')->name('deleteTag');
            Route::get('/search-tags','TagsController@searchTags')->name('searchTags');
            Route::get('/limit-tags','TagsController@limit')->name('limitTags');
            Route::post('bulk-action-tags','TagsController@bulkActionTags')->name('bulkActionTags');
            Route::get('/sort-tags','TagsController@sort')->name('sortTags');
        });
        Route::group(['prefix' => 'comments'], function () {
            Route::get('/list-comments','CommentsController@listComments')->name('listComments');
            Route::get('/delete-comment/{id}','CommentsController@deleteComment')->name('deleteComment');
            Route::get('/search-comments','CommentsController@searchComments')->name('searchComments');
            Route::get('/limit-comments','CommentsController@limit')->name('limitComments');
            Route::post('bulk-action-comments','CommentsController@bulkActionComments')->name('bulkActionComments');
            Route::get('/sort-comments','CommentsController@sort')->name('sortComments');
        });
        //post
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/list-posts','PostsController@listPosts')->name('posts.list_posts');
            Route::get('/add-post','PostsController@getAddPost')->name('add-post');
            Route::post('/add-post','PostsController@postAddPost')->name('add-post');
            Route::get('/edit-post/{id}','PostsController@getEditPost')->name('edit-get-post');
            Route::post('/edit-post','PostsController@postEditPost')->name('edit-post');
            Route::get('/delete-post/{id}','PostsController@deletePost')->name('delete-post');
            Route::get('/search-posts','PostsController@searchPosts')->name('searchPosts');
            Route::get('/limit-posts','PostsController@limit')->name('limitPosts');
            Route::post('bulk-action-posts','PostsController@bulkActionPosts')->name('bulkActionPosts');
            Route::get('test-aaa','PostsController@test')->name('test');
            Route::get('/sort-posts','PostsController@sort')->name('sortPosts');
            Route::get('/status-posts','PostsController@status')->name('statusPosts');
        });
        //changelog
        Route::group(['prefix' => 'changelog'], function () {
            Route::get('/list-changelog','ChangelogController@index')->name('changelog.list_posts');
            Route::get('/add-changelog','ChangelogController@create')->name('changelog.get_add_posts');
            Route::post('/add-changelog','ChangelogController@store')->name('changelog.post_add_posts');
            Route::get('/edit-changelog/{id}','ChangelogController@edit')->name('changelog.get_edit_posts');
            Route::post('/edit-changelog','ChangelogController@update')->name('changelog.post_edit_posts');
            Route::get('/delete-changelog/{id}','ChangelogController@destroy')->name('changelog.delete_posts');
            Route::get('/search-changelog','ChangelogController@searchPosts')->name('changelog.search_posts');
            Route::get('/limit-changelog','ChangelogController@limit')->name('changelog.limit_posts');
            Route::post('bulk-action-changelog','ChangelogController@bulkActionPosts')->name('changelog.bulkAction_posts');
            Route::get('/sort-changelog','ChangelogController@sort')->name('changelog.sort_posts');
            Route::get('/status-changelog','ChangelogController@status')->name('changelog.status_posts');
            Route::get('/setting-changelog','ChangelogController@settingChangelog')->name('setting_changelog');
            Route::post('/update-setting-changelog','ChangelogController@updateSettingChangelog')->name('update_setting_changelog');
        });
        //roadmaps
        Route::group(['prefix' => 'roadmaps'], function () {
            Route::get('/list-roadmaps','RoadmapsController@listRoadmaps')->name('listRoadmaps');
            Route::get('/add-roadmaps','RoadmapsController@getAddRoadmaps')->name('getAddRoadmaps');
            Route::post('/add-roadmaps','RoadmapsController@postAddRoadmaps')->name('postAddRoadmaps');
            Route::get('/edit-roadmaps/{id}','RoadmapsController@getEditRoadmaps')->name('getEditRoadmaps');
            Route::post('/edit-roadmaps','RoadmapsController@postEditRoadmaps')->name('postEditRoadmaps');
            Route::get('/delete-roadmaps/{id}','RoadmapsController@deleteRoadmaps')->name('deleteRoadmaps');
            Route::get('/search-roadmaps','RoadmapsController@searchRoadmaps')->name('searchRoadmaps');
            Route::get('/limit-roadmaps','RoadmapsController@limit')->name('limitRoadmaps');
            Route::post('bulk-action-roadmaps','RoadmapsController@bulkActionRoadmaps')->name('bulkActionRoadmaps');
            Route::get('/sort-roadmaps','RoadmapsController@sort')->name('sortRoadmaps');
            Route::get('/status-proadmapsosts','RoadmapsController@status')->name('statusRoadmaps');
        });

        //Status
        Route::group(['prefix' => 'status'], function () {
            Route::get('/list-status','StatusController@listStatus')->name('listStatus');
            Route::get('/add-status','StatusController@getAddStatus')->name('getAddStatus');
            Route::post('/add-status-add','StatusController@postAddStatus')->name('postAddStatus');
            Route::get('/edit-status/{id}','StatusController@getEditStatus')->name('getEditStatus');
            Route::post('/edit-status','StatusController@postEditStatus')->name('postEditStatus');
            Route::get('/delete-status/{id}','StatusController@deleteStatus')->name('deleteStatus');
            Route::get('/search-status','StatusController@searchStatus')->name('searchStatus');
            Route::get('/limit-status','StatusController@limit')->name('limitStatus');
            Route::get('/sort-status','StatusController@sort')->name('sortStatus');
            Route::get('/statuses','StatusController@status')->name('statuses');
            Route::post('bulk-action-status','StatusController@bulkActionStatus')->name('bulkActionStatus');
        });
        //user
        Route::group(['prefix' => 'users'], function () {
            Route::get('/list-users','UsersController@listUsers')->name('listUsers');
            Route::get('/add-user','UsersController@getAddUser')->name('getAddUser');
            Route::post('/add-user-add','UsersController@postAddUser')->name('postAddUser');
            Route::get('/edit-user/{id}','UsersController@getEditUser')->name('getEditUser');
            Route::post('/edit-user','UsersController@postEditUser')->name('postEditUser');
            Route::get('/change-status/{id}','UsersController@changeStatus')->name('change-status');
            Route::get('/search-users','UsersController@searchUsers')->name('searchUsers');
            Route::get('/limit-users','UsersController@limit')->name('limitUsers');
            Route::get('/sort-users','UsersController@sort')->name('sortUsers');
            Route::get('/status-users','UsersController@status')->name('statusUsers');
            Route::post('bulk-action-users','UsersController@bulkActionUsers')->name('bulkActionUsers');
        });
    });
});

Route::get('/categories', 'PagesController@listCategories')->name('listCategories');
Route::get('/posts', 'PagesController@listPosts')->name('listPosts');
Route::get('/home', 'PagesController@home')->name('home');
Route::get('/changelog', 'PagesController@listChangelog')->name('home.list_changelog');
Route::get('/changelog/{id}', 'PagesController@changelogDetails')->name('changelog_details');

Route::get('/filter-categories','PagesController@filterCategories')->name('home.filter_categories');

Route::get('/roadmaps', 'PagesController@allRoadmaps')->name('home.all_roadmaps');
Route::get('/filter-tags','PagesController@filterTags')->name('home.filter_tags');
Route::get('/category/{key}', 'PagesController@categoryDetails')->name('category_details');
Route::get('/post-details/{id}', 'PagesController@postDetails')->name('postDetail');
Route::get('/search', 'PagesController@search')->name('search');
Route::post('/add-comment', 'CommentsController@addComment')->name('addComment');
Route::get('/delete-comment/{id}/{post_id}','CommentsController@removeComment')->name('removeComment');
Route::get('/get-comment','CommentsController@getComment')->name('getComment');
Route::post('/post-comment','CommentsController@postUpdateComment')->name('postUpdateComment');

route::post('/upvote','PagesController@upvote')->name('up_vote');
route::post('/unvote','PagesController@unvote')->name('un_vote');

route::post('/create-a-post','PagesController@createPost')->name('create_post');

