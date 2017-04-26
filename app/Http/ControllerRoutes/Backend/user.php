<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 13:32
 */
/**
 * Verb    Path                        Action  Route Name
GET     /users                      index   users.index
GET     /users/create               create  users.create
POST    /users                      store   users.store
GET     /users/{user}               show    users.show
GET     /users/{user}/edit          edit    users.edit
PUT     /users/{user}               update  users.update
DELETE  /users/{user}               destroy users.destroy
 */
//Route::resource('user', 'Backend\UserController');

Route::any('user', ['as' => 'backend.user.index', 'uses' => 'Backend\UserController@index']);
Route::any('user/create', ['as' => 'backend.user.create', 'uses' => 'Backend\UserController@create']);
Route::any('user/store', ['as' => 'backend.user.store', 'uses' => 'Backend\UserController@store']);
Route::any('user/show', ['as' => 'backend.user.show', 'uses' => 'Backend\UserController@show']);
Route::any('user/edit', ['as' => 'backend.user.edit', 'uses' => 'Backend\UserController@edit']);
Route::any('user/update', ['as' => 'backend.user.update', 'uses' => 'Backend\UserController@update']);
Route::any('user/delete', ['as' => 'backend.user.delete', 'uses' => 'Backend\UserController@delete']);