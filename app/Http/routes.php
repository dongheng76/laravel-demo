<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('/article/{id}', ['as' => 'article', 'uses' => 'ArticleController@index']);
Route::get('/category/{id}', ['as' => 'category', 'uses' => 'CategoryController@index']);
Route::get('/tag/{id}', ['as' => 'tag', 'uses' => 'TagController@index']);
Route::get('/search', ['as' => 'search', 'uses' => 'SearchController@index']);
Route::get('/page/{alias}', ['as' => 'page.show', 'uses' => 'PageController@index']);
Route::get('/about', ['as' => 'about', 'uses' => 'PageController@about']);
Route::get('/rss', ['as' => 'rss', 'uses'=>'RssController@index']);

Route::group(['prefix'=>'backend'], function(){

    Route::get('/login', 'Backend\AuthController@showLoginForm');
    Route::post('/login', 'Backend\AuthController@login');
    Route::get('/logout', 'Backend\AuthController@logout');
    /*Route::get('/register', 'Backend\AuthController@getRegister');
    Route::post('/register', 'Backend\AuthController@postRegister');*/
    Route::post('querymenubypid', ['as' => 'backend.querymenubypid', 'uses' =>'Backend\HomeController@querymenubypid']);

    Route::group(['middleware' => ['auth','backendAuth']], function(){
        Route::get('/', ['as' => 'backend.home', 'uses' =>'Backend\HomeController@index']);

        //菜单管理
        require __DIR__.'/ControllerRoutes/Backend/area.php';
        require __DIR__.'/ControllerRoutes/Backend/article.php';
        require __DIR__.'/ControllerRoutes/Backend/category.php';
        require __DIR__.'/ControllerRoutes/Backend/dict.php';
        require __DIR__.'/ControllerRoutes/Backend/menu.php';
        require __DIR__.'/ControllerRoutes/Backend/office.php';
        require __DIR__.'/ControllerRoutes/Backend/role.php';
        require __DIR__.'/ControllerRoutes/Backend/sysfile.php';
        require __DIR__.'/ControllerRoutes/Backend/user.php';
        /*Route::resource('tag', 'Backend\TagController');
        Route::resource('link', 'Backend\LinkController');
        Route::resource('navigation', 'Backend\NavigationController');*/

        Route::resource('page', 'Backend\PageController');
        Route::get('system', ['as' => 'backend.system.index', 'uses' => 'Backend\SystemController@index']);
        Route::post('system', ['as' => 'backend.system.store', 'uses' => 'Backend\SystemController@store']);

    });
});
